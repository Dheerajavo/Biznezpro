<?php
// Function to handle AJAX request and save node data
function save_node_data()
{

    // Check nonce for security
    check_ajax_referer('save_node_data_nonce', 'nonce');

    // Retrieve nodes, SVG data, and company name from POST request
    $current_user_id = isset($_POST['current_user_id']) ? sanitize_text_field($_POST['current_user_id']) : '';
    $nodes = isset($_POST['nodes']) ? $_POST['nodes'] : [];
    $svg_data = isset($_POST['svg_data']) ? $_POST['svg_data'] : [];
    $drawflow_translate_values = isset($_POST['drawflow_translate_values']) ? $_POST['drawflow_translate_values'] : [];
    $company_name = isset($_POST['company_name']) ? sanitize_text_field($_POST['company_name']) : '';
    $node_text = isset($_POST['node_text']) ? sanitize_text_field($_POST['node_text']) : '';
    $node_cat = isset($_POST['node_cat']) ? sanitize_text_field($_POST['node_cat']) : '';
    $node_country = isset($_POST['node_country']) ? sanitize_text_field($_POST['node_country']) : '';


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

    // Create the post and get the slug
    // $company_slug = create_company_post($company_name, $node_text);
    // if (is_wp_error($company_slug)) {
    //     wp_send_json_error($company_slug->get_error_message());
    //     return;
    // }

    // Insert serialized node and SVG data into the database
    // $insert_result = insert_node_data($company_name, $company_slug, $nodes, $svg_data, $drawflow_translate_values);

    // if ($insert_result) {
    //     $post_creation_result = create_company_post($company_name, $node_text);

    //     if (is_wp_error($post_creation_result)) {
    //         wp_send_json_error($post_creation_result->get_error_message());
    //         return;
    //     }

    //     wp_send_json_success('Data saved successfully.');
    // } else {
    //     wp_send_json_error('Failed to save data.');
    // }


    // Create the post and get both post ID and company slug
    // $post_creation_result = create_company_post($company_name, $node_text);
    $post_creation_result = create_company_post($company_name, $node_cat, $node_text);

    if (is_wp_error($post_creation_result)) {
        wp_send_json_error($post_creation_result->get_error_message());
        return;
    }

    $post_id = $post_creation_result['post_id'];
    $company_slug = $post_creation_result['post_slug'];

    // Insert serialized node and SVG data into the database
    // $insert_result = insert_node_data($company_name, $company_slug, $nodes, $svg_data, $drawflow_translate_values);
    $insert_result = insert_node_data($company_name,$company_slug,$node_cat, $node_country, $nodes, $svg_data, $drawflow_translate_values);

    if ($insert_result) {
        wp_send_json_success('Data saved successfully.');
    } else {
        wp_send_json_error('Failed to save data.');
    }
}

// Function to insert serialized node data and SVG data into the database
// function insert_node_data($company_name, $company_slug, $nodes, $svg_data, $drawflow_translate_values)
function insert_node_data($company_name,$company_slug,$node_cat, $node_country, $nodes, $svg_data, $drawflow_translate_values)
{
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
            'company_slug' => $company_slug,  // New field
            'node_cat' => $node_cat,  // New field
            'node_country' => $node_country,  // New field
            'node_data' => $serialized_nodes, // Save serialized node data
            'svg_data' => $serialized_svg_data, // Save serialized SVG data
            'drawflow_translate_values' => $serialized_drawflow_translate_values,
        ),
        array(
            '%s', // company_name
            '%s',
            '%s',
            '%s', // company_slug
            '%s', // svg_data
            '%s', // svg_data
            '%s'
        )
    );

    return $result !== false;
}


// Function to save base64 image data and return the URL
function save_base64_image($base64_string, $prefix)
{
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
// function create_company_post($company_name, $node_text)
function create_company_post($company_name, $node_cat, $node_text)
{
    $post_title = sanitize_text_field($company_name);
    $post_slug = sanitize_title($company_name);

    // Check if a post with this slug already exists
    $existing_post = get_page_by_path($post_slug, OBJECT, 'post');
    if ($existing_post) {
        return new WP_Error('post_exists', 'Post with this slug already exists.');
    }

    // Ensure the category specified by $node_cat exists
    $category = get_term_by('slug', $node_cat, 'category');
    if (!$category) {
        // If the category does not exist, create it
        $category = wp_insert_term($node_cat, 'category', array(
            'slug' => $node_cat,
        ));
        if (is_wp_error($category)) {
            return $category; // Return error if category creation failed
        }
        $category_id = $category['term_id'];
    } else {
        $category_id = $category->term_id;
    }

    // Create the post with the excerpt set to node_text
    $post_id = wp_insert_post(array(
        'post_title'    => $post_title,
        'post_name'     => $post_slug,
        'post_type'     => 'post',
        'post_status'   => 'publish',
        'post_category' => array($category_id), // Add category ID to the post
        'post_excerpt'  => sanitize_text_field($node_text), // Set node_text as the post excerpt
    ));

    if (is_wp_error($post_id)) {
        return $post_id;
    }
    // Return both the post ID and slug
    return array(
        'post_id' => $post_id,
        'post_slug' => $post_slug,
    );
    // return $post_id;

}

// Function to check if a company name already exists in the database
function is_company_name_exists($company_name)
{
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




function create_nodechild_category()
{
    if (isset($_POST['category_name'])) {
        $category_name = sanitize_text_field($_POST['category_name']);

        // Check if the category already exists in the taxonomy
        $existing_term = term_exists($category_name, 'nodechilds_categories');

        if ($existing_term) {
            wp_send_json_error(array('message' => 'NodeChild name already exists.'));
        } else {
            // Attempt to insert the term into the correct taxonomy
            $term = wp_insert_term($category_name, 'nodechilds_categories');

            if (is_wp_error($term)) {
                wp_send_json_error(array('message' => $term->get_error_message()));
            } else {
                wp_send_json_success(array('term_id' => $term['term_id']));
            }
        }
    } else {
        wp_send_json_error(array('message' => 'NodeChild name not set.'));
    }

    wp_die();
}
add_action('wp_ajax_create_nodechild_category', 'create_nodechild_category');
add_action('wp_ajax_nopriv_create_nodechild_category', 'create_nodechild_category');



function create_nodechild_page(): void
{
    global $wpdb; // WordPress database object

    if (isset($_POST['category_name'])) {
        $page_title = sanitize_text_field($_POST['category_name']);
        $page_slug = sanitize_title($page_title);
        $original_slug = $page_slug;
        $counter = 1;

        // Ensure the slug is unique by appending a number if it already exists
        while (get_page_by_path($page_slug, OBJECT, 'page')) {
            $page_slug = $original_slug . '-' . $counter;
            $counter++;
        }
        //$page_tittle = str_replace('-','',$page_title);
        // Create the page with the unique slug and assign the template
        $page_id = wp_insert_post(array(
            'post_title'    => $page_title,
            'post_name'     => $page_slug,
            'post_type'     => 'page',
            'post_status'   => 'publish',
            'meta_input'    => array(
                '_wp_page_template' => 'node-child-view.php' // Assign the template
            ),
        ));

        if (is_wp_error($page_id)) {
            wp_send_json_error(array('message' => $page_id->get_error_message()));
        } else {
            // If the page is created successfully, store the slug and name in the custom table
            $table_name = $wpdb->prefix . 'child_node_page_data'; // Custom table name

            $data = array(
                'nc_page_slug' => $page_slug,    // Slug of the newly created page
                'nc_page_name' => $page_title,   // Name of the newly created page (title)
                'page_id'      => $page_id,      // ID of the newly created page
            );
            $format = array('%s', '%s', '%d'); // Data types for the fields
            // Insert data into the custom table
            $wpdb->insert($table_name, $data, $format);
            // Return success response
            wp_send_json_success(array('page_id' => $page_id));
        }
    } else {
        wp_send_json_error(array('message' => 'Page title not set.'));
    }

    wp_die();
}
add_action('wp_ajax_create_nodechild_page', 'create_nodechild_page');
add_action('wp_ajax_nopriv_create_nodechild_page', 'create_nodechild_page');






function create_nodeschild_page(): void
{
    if (isset($_POST['category_name'])) {
        $page_title = sanitize_text_field($_POST['category_name']);

        // Sanitize the title to create a slug
        $page_slug = sanitize_title($page_title);

        // Initialize a counter to add to the slug if it already exists
        $original_slug = $page_slug;
        $counter = 1;

        // Check if the slug already exists and append a number if necessary
        while (get_page_by_path($page_slug, OBJECT, 'page')) {
            $page_slug = $original_slug . '-' . $counter;
            $counter++;
        }

        // Create the new page with the unique slug
        $page_id = wp_insert_post(array(
            'post_title'    => $page_title,
            'post_name'     => $page_slug, // This is the unique slug
            'post_type'     => 'page',
            'post_status'   => 'publish',
        ));

        if (is_wp_error($page_id)) {
            wp_send_json_error(array('message' => $page_id->get_error_message()));
        } else {
            wp_send_json_success(array('page_id' => $page_id));
        }
    } else {
        wp_send_json_error(array('message' => 'Page title not set.'));
    }

    wp_die();
}
add_action('wp_ajax_create_nodeschild_page', 'create_nodeschild_page');
add_action('wp_ajax_nopriv_create_nodeschild_page', 'create_nodeschild_page');







function save_child_node_data()
{

    // Check nonce for security

    check_ajax_referer('save_node_data_nonce', 'nonce');
    $nodechild_group = isset($_POST['nodeGroupData']) ? $_POST['nodeGroupData'] : [];
    $nodechild_data = isset($_POST['nodeChildData']) ? $_POST['nodeChildData'] : [];
    $svg_data = isset($_POST['lineData']) ? $_POST['lineData'] : [];
    $parent_nodename = isset($_POST['parentnodename']) ? $_POST['parentnodename'] : [];
    $page_id = isset($_POST['page_id']) ? $_POST['page_id'] : 0;

    $insert_result = insert_nodechild_data($nodechild_group, $nodechild_data, $svg_data, $parent_nodename, $page_id);
    if ($insert_result) {
        wp_send_json_success('Node data saved successfully!');
    } else {
        wp_send_json_error('Failed to save node data.');
    }
}

function insert_nodechild_data($nodechild_group, $nodechild_data, $svg_data, $parent_nodename, $page_id)
{

    global $wpdb;

    $table_name = $wpdb->prefix . 'nodechild_data';

    // Serialize the nodes and SVG data arrays
    $serialized_nodechild_group = maybe_serialize($nodechild_group);
    $serialized_nodechild_data = maybe_serialize($nodechild_data);
    $serialized_svg_data = maybe_serialize($svg_data);
    $parent_node_name = $parent_nodename;
    $page_id = $page_id;

    // Insert the serialized data into the database
    $insert_result = $wpdb->insert(
        $table_name,
        array(
            'nodechild_groupdata' => $serialized_nodechild_group,
            // 'node_cat' => $node_cat,  // New field
            'nodechild_data' =>  $serialized_nodechild_data,  // New field
            'child_svgline_data' => $serialized_svg_data, // Save serialized node data
            'parent_node_name' => $parent_node_name,
            'page_id' => $page_id,

        ),
        array(
            '%s',
            // '%s',
            '%s' , // svg_data
            '%s',
            '%s',
            '%d'
        )
    );

    return $insert_result !== false;
}

add_action('wp_ajax_save_child_node_data', 'save_child_node_data');
add_action('wp_ajax_nopriv_save_child_node_data', 'save_child_node_data');
