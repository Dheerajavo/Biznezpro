<?php
// Function to handle AJAX request and save node data
function save_node_data() {
    global $wpdb;

    // Check nonce for security
    check_ajax_referer('save_node_data_nonce', 'nonce');

    // Retrieve nodes, SVG data, and company name from POST request
    $nodes = isset($_POST['nodes']) ? $_POST['nodes'] : [];
    $svg_data = isset($_POST['svg_data']) ? $_POST['svg_data'] : [];
    $drawflow_translate_values = isset($_POST['drawflow_translate_values']) ? $_POST['drawflow_translate_values'] : [];
    $company_name = isset($_POST['company_name']) ? sanitize_text_field($_POST['company_name']) : '';

    // Check if company name already exists
    if (is_company_name_exists($company_name)) {
        wp_send_json_error('Company name already in use.');
        return;
    }

    // Validate that all necessary fields are present
    foreach ($nodes as &$node) {
        if (empty($node['company_logo']) || empty($company_name)) {
            wp_send_json_error('Company Name and Company Logo are required.');
            return;
        }

        // Handle base64 image data for company logo and node image URLs
        if (strpos($node['company_logo'], 'data:image') === 0) {
            $node['company_logo'] = save_base64_image($node['company_logo'], 'logo');
        }

        if (strpos($node['element_image_url'], 'data:image') === 0) {
            $node['element_image_url'] = save_base64_image($node['element_image_url'], 'node_image');
        }
    }

    // Insert serialized node and SVG data into the database
    $insert_result = insert_node_data($company_name, $nodes, $svg_data, $drawflow_translate_values);

    if ($insert_result) {
        $post_creation_result = create_company_post($company_name);

        if (is_wp_error($post_creation_result)) {
            wp_send_json_error($post_creation_result->get_error_message());
            return;
        }

        wp_send_json_success('Data saved successfully.');
    } else {
        wp_send_json_error('Failed to save data.');
    }
}

// Function to insert serialized node data and SVG data into the database
function insert_node_data($company_name, $nodes, $svg_data, $drawflow_translate_values) {
    global $wpdb;

    $table_name = $wpdb->prefix . 'node_data';

    // Serialize the nodes and SVG data arrays
    $serialized_nodes = maybe_serialize($nodes);
    $serialized_svg_data = maybe_serialize($svg_data);
    $serialized_drawflow_translate_values = maybe_serialize($drawflow_translate_values);

    // Insert the serialized data into the database
    $result = $wpdb->insert(
        $table_name,
        array(
            'company_name' => $company_name,
            'node_data' => $serialized_nodes, // Save serialized node data
            'svg_data' => $serialized_svg_data, // Save serialized SVG data
            'drawflow_translate_values' => $serialized_drawflow_translate_values,
        ),
        array(
            '%s', // company_name
            '%s', // node_data
            '%s' , // svg_data
            '%s'
        )
    );

    return $result !== false;
}


// Function to save base64 image data and return the URL
function save_base64_image($base64_string, $prefix) {
    $upload_dir = wp_upload_dir();
    $image_data = explode(',', $base64_string);
    $decoded_image = base64_decode(end($image_data));

    // Generate a unique filename
    $file_name = uniqid() . "_{$prefix}.jpg"; // Adjust file extension based on image type
    $file_path = $upload_dir['path'] . '/' . $file_name;

    // Save the image to the uploads directory
    file_put_contents($file_path, $decoded_image);

    // Return the URL to the saved file
    return $upload_dir['url'] . '/' . $file_name;
}

// Function to create a post with the company name as the title and slug
function create_company_post($company_name) {
    $post_title = sanitize_text_field($company_name);
    $post_slug = sanitize_title($company_name);

    // Check if a post with this slug already exists
    $existing_post = get_page_by_path($post_slug, OBJECT, 'post');
    if ($existing_post) {
        return new WP_Error('post_exists', 'Post with this slug already exists.');
    }

    // Ensure the 'Node' category exists
    $category_name = 'Node';
    $category_slug = 'node';
    $category_id = get_term_by('slug', $category_slug, 'category');

    if (!$category_id) {
        // If the category does not exist, create it
        $category = wp_insert_term($category_name, 'category', array(
            'slug' => $category_slug,
        ));
        if (is_wp_error($category)) {
            return $category; // Return error if category creation failed
        }
        $category_id = $category['term_id'];
    } else {
        $category_id = $category_id->term_id;
    }

    // Create the post
    $post_id = wp_insert_post(array(
        'post_title'    => $post_title,
        'post_name'     => $post_slug,
        'post_type'     => 'post',
        'post_status'   => 'publish',
        'post_category' => array($category_id), // Add category ID to the post
    ));

    if (is_wp_error($post_id)) {
        return $post_id;
    }

    return $post_id;
}

// Function to check if a company name already exists in the database
function is_company_name_exists($company_name) {
    global $wpdb;
    $table_name = $wpdb->prefix . 'node_data';

    $result = $wpdb->get_var($wpdb->prepare(
        "SELECT COUNT(*) FROM $table_name WHERE company_name = %s",
        $company_name
    ));

    return $result > 0;
}
// Register the AJAX actions
add_action('wp_ajax_save_node_data', 'save_node_data');
add_action('wp_ajax_nopriv_save_node_data', 'save_node_data');
