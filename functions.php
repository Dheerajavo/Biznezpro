<?php
// Dequeue parent css
function dequeue_parent_theme_style()
{
    wp_dequeue_style('parent-theme-style');
}
add_action('wp_enqueue_scripts', 'dequeue_parent_theme_style', 20);
function remove_parent_style()
{
    wp_dequeue_style('twenty-twenty-one-style');
}
add_action('wp_enqueue_scripts', 'remove_parent_style', 20);

// Wp login
function my_login_logo()
{
?>
    <style type="text/css">
        #login h1 a,
        .login h1 a {
            background-image: url(<?php echo esc_url(wp_get_attachment_url(get_theme_mod('custom_logo'))); ?>);
            background-repeat: no-repeat;
            background-position: center;
            width: 100%;
            background-size: contain;
            pointer-events: none;
            cursor: default;
        }
    </style>
<?php
}
add_action('login_enqueue_scripts', 'my_login_logo');

//For Menu locations
function mytheme_register_nav_menu()
{
    register_nav_menus(
        array(
            'my_header_top' => __('Header Top', 'text_domain'),
            'my_header_middle' => __('Header Middle', 'text_domain'),
            'my_header_bottom' => __('Header Bottom', 'text_domain'),


        )
    );
}
add_action('after_setup_theme', 'mytheme_register_nav_menu', 0);

// ENqueue Scripts
function enqueue_custom_scripts()
{
    wp_enqueue_script('jquery', 'https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js', array(), null, true);
    wp_enqueue_script('bootstrap', get_stylesheet_directory_uri() . '/assets/js/bootstrap.js', array('jquery'), null, true);
    wp_enqueue_script('sweetalert2', 'https://cdn.jsdelivr.net/npm/sweetalert2@11', array('jquery'), null, true);

    // Conditionally enqueue node-js.js for 'node' and 'test' pages , 'node-child'
    if (is_page(['node', 'test', 'node-check'])) {
        wp_enqueue_script('node-js', get_stylesheet_directory_uri() . '/node-functionality/node-js.js', array('jquery'), time(), true);
    }
    wp_enqueue_script('custom-js', get_stylesheet_directory_uri() . '/assets/js/custom.js', array('jquery'), time(), true);
    wp_localize_script('custom-js', 'my_ajax_object', array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('save_node_data_nonce'),
        'homeUrl' => home_url()
    ));



    // Enqueue for logged in
    if (is_user_logged_in()) {
        $current_user = wp_get_current_user();
        // if (!in_array('administrator', $current_user->roles)) {
        //     $user_data = array(
        //         'user_id'   => $current_user->ID,
        //         'user_role' => implode(', ', $current_user->roles),
        //         'full_name' => get_user_meta($current_user->ID, 'fullname', true) ?: $current_user->display_name,
        //         'email'     => $current_user->user_email,
        //     );
        //     wp_localize_script('custom-js', 'userData', $user_data);
        // }



        // if (!in_array('administrator', $current_user->roles)) {
        //     $user_data = array(
        //         'user_id'   => $current_user->ID,
        //         'user_role' => implode(', ', $current_user->roles),
        //         'full_name' => get_user_meta($current_user->ID, 'fullname', true) ?: $current_user->display_name,
        //         'email'     => $current_user->user_email,
        //     );
        //     wp_localize_script('custom-js', 'userData', $user_data);
        // } else {
        //     $alluser_data = array(
        //         'user_id'   => $current_user->ID,
        //         'user_role' => implode(', ', $current_user->roles),
        //         'full_name' => get_user_meta($current_user->ID, 'fullname', true) ?: $current_user->display_name,
        //         'email'     => $current_user->user_email,
        //     );
        //     wp_localize_script('custom-js', 'allUserData', $alluser_data);
        // }


        $all_user_data = array(
            'user_id'   => $current_user->ID,
            'user_role' => implode(', ', $current_user->roles),
            'full_name' => get_user_meta($current_user->ID, 'fullname', true) ?: $current_user->display_name,
            'email'     => $current_user->user_email,
        );
        wp_localize_script('custom-js', 'allUserData', $all_user_data);

        // Data for non-admin users only
        if (!in_array('administrator', $current_user->roles)) {
            $user_data = array(
                'user_id'   => $current_user->ID,
                'user_role' => implode(', ', $current_user->roles),
                'full_name' => get_user_meta($current_user->ID, 'fullname', true) ?: $current_user->display_name,
                'email'     => $current_user->user_email,
            );
            wp_localize_script('custom-js', 'userData', $user_data);
        }
    }
}
add_action('wp_enqueue_scripts', 'enqueue_custom_scripts');


include get_stylesheet_directory() . '/node-functionality/node_data_store.php';
include get_stylesheet_directory() . '/node-functionality/node_data_update.php';
// require get_stylesheet_directory() . '/template-parts/node_data_store.php';




// Edit Cooprtate page

function hide_edit_button_with_jquery_for_non_admins()
{
    // Check if the current user is not an administrator
    if (!current_user_can('administrator')) {
        // Output the script to hide the "Edit" button and show SweetAlert on click
        echo '<script type="text/javascript">
            jQuery(document).ready(function($) {
                // Hide the "Edit" button for non-admins
                $(".page-template-default footer.entry-footer span.edit-link").hide();

                // Add click event listener for non-admin users
                $(".page-template-default footer.entry-footer span.edit-link a").on("click", function(e) {
                    // Prevent default click action (navigation to edit page)
                    e.preventDefault();

                    // Show SweetAlert for non-admin users
                    Swal.fire({
                        icon: "error",
                        title: "Access Denied",
                        text: "Only admins have access to edit this page.",
                        confirmButtonText: "Okay"
                    });
                });
            });
        </script>';
    }
}
add_action('wp_footer', 'hide_edit_button_with_jquery_for_non_admins');






// for search in HOme page
function fetch_post_suggestions()
{
    // Check if the query parameter is provided
    if (isset($_POST['query'])) {
        global $wpdb;
        $query = sanitize_text_field($_POST['query']);

        // Query to fetch post titles that match the search query
        $posts = $wpdb->get_results($wpdb->prepare(
            "SELECT ID, post_title FROM $wpdb->posts WHERE post_type = 'post' AND post_status = 'publish' AND post_title LIKE %s LIMIT 10",
            '%' . $wpdb->esc_like($query) . '%'
        ));

        $suggestions = array();
        foreach ($posts as $post) {
            $suggestions[] = array(
                'title' => $post->post_title,
                'url' => get_permalink($post->ID)
            );
        }

        wp_send_json_success(array('suggestions' => $suggestions));
    } else {
        wp_send_json_error();
    }

    wp_die(); // Required to terminate immediately and return a proper response
}
add_action('wp_ajax_fetch_post_suggestions', 'fetch_post_suggestions');
add_action('wp_ajax_nopriv_fetch_post_suggestions', 'fetch_post_suggestions');
function handle_post_search()
{
    // Check if the query parameter is set
    $query = isset($_POST['query']) ? sanitize_text_field($_POST['query']) : '';

    if (empty($query)) {
        wp_send_json_error();
    }

    // Handle the request differently based on the 'mode' parameter
    $mode = isset($_POST['mode']) ? $_POST['mode'] : '';

    if ($mode === 'suggestions') {
        // Fetch suggestions: search for posts by partial title match
        $args = array(
            's' => $query,
            'post_type' => 'post',
            'posts_per_page' => 5, // Limit the number of suggestions
        );
        $posts = get_posts($args);

        if (!empty($posts)) {
            $suggestions = array();
            foreach ($posts as $post) {
                $suggestions[] = array(
                    'title' => get_the_title($post->ID),
                    'url' => get_permalink($post->ID),
                );
            }
            wp_send_json_success(['suggestions' => $suggestions]);
        } else {
            wp_send_json_error();
        }
    } elseif ($mode === 'check_title') {
        // Check for an exact title match
        $post = get_page_by_title($query, OBJECT, 'post');

        if ($post) {
            wp_send_json_success(['post_url' => get_permalink($post)]);
        } else {
            wp_send_json_error();
        }
    }
}

// Hook the function to AJAX actions for both logged-in and non-logged-in users
add_action('wp_ajax_handle_post_search', 'handle_post_search');
add_action('wp_ajax_nopriv_handle_post_search', 'handle_post_search');




// Create Posttype
function custom_post_type1()
{
    register_post_type(
        'nodechilds',
        array(
            'labels' => [
                'name' => 'Nodechilds',
                'singular_name' => 'Nodechild',
                'add_new' => 'Add New Post',
            ],
            'public' => true,
            'has_archive' => true,
            'rewrite'  => array('slug' => 'nodechilds'),
            'menu_position' => 4,
            'supports' => [
                'title',
                'editor',
                'author',
                'thumbnail',
                'content',

            ],
            'taxonomies' => ['nodechilds_categories', 'nodechilds_tags'],
        )
    );
    register_taxonomy(
        'nodechilds_categories',
        ['nodechilds'],
        array(
            'labels' => [
                'name' => 'Categories',
                'singular_name' => 'Category',
                'add_new_item' => 'Add New Category',

            ],
            'rewrite' => array('slug' => 'nodechilds_categories'),
        )
    );
    register_taxonomy_for_object_type('nodechilds_categories', 'nodechilds');
    register_taxonomy(
        'nodechilds_tags',
        ['nodechilds'],
        array(
            'labels' => [
                'name' => 'Tags',
                'singular_name' => 'Tag',
            ],
            'rewrite' => array('slug' => 'nodechilds_tags'),
        )
    );
    register_taxonomy_for_object_type('nodechilds_tags', 'nodechilds');
}

add_action('init', 'custom_post_type1');





// function extend_login_session($expirein)
// {
//     return 30 * DAY_IN_SECONDS; // Return 30 days in seconds
// }
// add_filter('auth_cookie_expiration', 'extend_login_session');
// function extend_login_session($expirein) {
//     return 30 * 86400; // Set expiration to 30 days (30 * 86400 seconds)
// }
// add_filter('auth_cookie_expiration', 'extend_login_session');



//fOr additional functioanlity to nav menu
class Custom_Walker_Nav_Menu extends Walker_Nav_Menu
{
    // Add main/sub classes to li's and links
    function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0)
    {
        $is_active = $item->current || $item->current_item_ancestor || $item->current_item_parent ? ' active' : '';

        // Extract FontAwesome class and the <li> class
        $li_class = '';
        $fa_class = '';
        if (!empty($item->classes)) {
            $li_class = isset($item->classes[1]) ? esc_attr($item->classes[1]) : '';
            $fa_class = isset($item->classes[0]) ? esc_attr($item->classes[0]) : '';
        }
        $output .= '<li class="' . $li_class . '">';

        $atts = array();
        $atts['title']  = !empty($item->attr_title) ? $item->attr_title : '';
        $atts['target'] = !empty($item->target)     ? $item->target     : '';
        $atts['rel']    = !empty($item->xfn)        ? $item->xfn        : '';
        $atts['href']   = !empty($item->url)        ? $item->url        : '';

        $attributes = '';
        foreach ($atts as $attr => $value) {
            if (!empty($value)) {
                $value = ('href' === $attr) ? esc_url($value) : esc_attr($value);
                $attributes .= ' ' . $attr . '="' . $value . '"';
            }
        }

        $item_output = $args->before;
        $item_output .= '<a' . $attributes . ' class="dash-nav' . $is_active . '">';
        $item_output .= '<div class="svg-ico">';
        $item_output .= '<i class="' . $fa_class . '"></i>';
        $item_output .= '</div>';
        $item_output .= '<div class="tooltion-title">';
        $item_output .= $args->link_before . apply_filters('the_title', $item->title, $item->ID) . $args->link_after;
        $item_output .= '</div>';
        $item_output .= '</a>';
        $item_output .= $args->after;

        $output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
    }
}

// HiDe Admin Bar
add_filter('show_admin_bar', 'hide_admin_bar_for_subscribers');

function hide_admin_bar_for_subscribers($show)
{
    if (!current_user_can('administrator')) {
        return false;
    }
    return $show;
}

//HiDe Menu Items
function hide_sign_in_menu_item()
{
?> <script type="text/javascript">
        jQuery(document).ready(function($) {
            <?php if (is_user_logged_in()) : ?>
                $('.menu-item-account').show();
                <?php
                $user = wp_get_current_user();
                // if (!in_array('administrator', (array) $user->roles)) {
                // if (!in_array('administrator', (array) $user->roles) || $user->ID !== 1){
                ?>
                $('.menu-item-sign-in').hide();
                <?php
                // }
                ?>
            <?php else : ?>
                $('.menu-item-account').hide();
                $('.menu-item-sign-in').show();
            <?php endif; ?>
        });
    </script>
<?php
}
//add_action('wp_head', 'hide_sign_in_menu_item');

function add_admin_editor_class()
{
    if (current_user_can('administrator') || current_user_can('editor')) {
        echo '<style>#admin_editor { display: block; }</style>';
    } else {
        echo '<style>#admin_editor { display: none; }</style>';
    }
    if (is_user_logged_in()) {
        echo '<style>.menu-item-account { display: block; }</style>';




        // if (!current_user_can('administrator')) {
        //     echo '<style>.menu-item-sign-in, #admin_only, .admin_only { display: none; }</style>';
        // }

        // Check if user is an administrator
        if (!current_user_can('administrator')) {
            echo '<style>.menu-item-sign-in, #admin_only, .admin_only { display: none; }</style>';
        } else {
            // Check if user ID is 1
            if (get_current_user_id() === 1) {
                echo '<style>.menu-item-sign-in { display: block; }</style>';
            } else {
                echo '<style>.menu-item-sign-in { display: none; }</style>';
            }
        }
    } else {
        echo '<style> .menu-item-account { display: none; }</style>';
        echo '<style> .menu-item-sign-in, #admin_only, .admin_only { display: block; }</style>';
    }
}
add_action('wp_head', 'add_admin_editor_class');

// Hook to handle the AJAX request
add_action('wp_ajax_request_password_reset', 'handle_password_reset_request');
add_action('wp_ajax_nopriv_request_password_reset', 'handle_password_reset_request');

function handle_password_reset_request()
{

    // Check if email is provided
    if (!isset($_POST['email'])) {
        wp_send_json_error(array('message' => 'Email is required.'));
    }

    $email = sanitize_email($_POST['email']);

    // Check if the email is valid
    if (!is_email($email)) {
        wp_send_json_error(array('message' => 'Invalid email address.'));
    }

    // Check if the email exists in the database
    if (!email_exists($email)) {
        wp_send_json_error(array('message' => 'No user found with this email address.'));
    }

    // Generate and send password reset email
    $user = get_user_by('email', $email);
    $reset_key = get_password_reset_key($user);

    // Send email
    $reset_page_url = home_url('/password-reset/');
    $reset_url = add_query_arg(array(
        'key' => $reset_key,
        'login' => rawurlencode($user->user_login)
    ), $reset_page_url);
    // $reset_url = network_site_url("wp-login.php?action=rp&key=$reset_key&login=" . rawurlencode($user->user_login), 'login');
    $message = "Click the following link to reset your password: \n\n" . $reset_url;

    if (wp_mail($email, 'Password Reset Request', $message)) {
        wp_send_json_success(array('message' => 'Password reset email sent.'));
    } else {
        wp_send_json_error(array('message' => 'Failed to send password reset email.'));
    }
    wp_die(); // This is required to terminate immediately and return a proper response
}




//Delete Structure Request

// Action to check if a deletion request for the company already exists
add_action('wp_ajax_check_deletion_request', 'check_deletion_request');
function check_deletion_request()
{
    $company_name = sanitize_text_field($_POST['company_name']);
    $user_id = get_current_user_id();

    // Retrieve all deletion requests stored in a single user meta key
    $deletion_requests = get_user_meta($user_id, '_deletion_request', true);

    // Check if the request for the specific company already exists
    if (!empty($deletion_requests) && array_key_exists($company_name, $deletion_requests)) {
        wp_send_json_error(array('message' => 'You have already requested deletion for this company.'));
    } else {
        wp_send_json_success();
    }
}

// Action to handle the deletion request and save it in user meta
add_action('wp_ajax_request_delete', 'handle_delete_request');
function handle_delete_request()
{
    global $wpdb;

    $company_name = sanitize_text_field($_POST['company_name']);
    $user_id = get_current_user_id();

    // Retrieve existing deletion requests
    $deletion_requests = get_user_meta($user_id, '_deletion_request', true);
    if (empty($deletion_requests)) {
        $deletion_requests = array(); // Initialize if no requests exist yet
    }

    // Check if a request for this company already exists
    if (array_key_exists($company_name, $deletion_requests)) {
        wp_send_json_error(array('message' => 'You have already requested deletion for this company.'));
        return;
    }

    // Retrieve the post ID for the company name if it exists
    $post = get_page_by_title($company_name, OBJECT, 'post');
    $post_id = $post ? $post->ID : null;

    // Retrieve additional data
    $user_info = get_userdata($user_id);
    $user_name = $user_info->user_login; // Get the username of the requester

    // Store the deletion request details
    $deletion_requests[$company_name] = array(
        'post_id' => $post_id,
        'company_name' => $company_name,
        'user_name' => $user_name,
        'request_date' => current_time('mysql')
    );

    // Save the updated deletion requests back to user meta
    update_user_meta($user_id, '_deletion_request', $deletion_requests);

    wp_send_json_success(array('message' => 'Request sent successfully.'));
}

function admin_handle_request_action()
{
    // Ensure only administrators can perform this action
    if (!current_user_can('administrator')) {
        wp_send_json_error('Unauthorized action.');
        return;
    }

    // Retrieve and sanitize input data
    $post_id = isset($_POST['post_id']) ? absint($_POST['post_id']) : 0;
    $company_name = isset($_POST['company_name']) ? sanitize_text_field($_POST['company_name']) : '';
    $action = isset($_POST['request_action']) ? sanitize_text_field($_POST['request_action']) : '';

    if ($post_id && $company_name && $action) {
        $post = get_post($post_id); // Fetch the post
        if (!$post) {
            wp_send_json_error('Post not found');
            return;
        }

        if ($action === 'delete') {
            // Permanently delete the post
            wp_delete_post($post_id, true);

            // Clean up related user meta
            $users_with_requests = get_users(array(
                'meta_key'     => '_deletion_request',
                'meta_compare' => 'EXISTS'
            ));

            foreach ($users_with_requests as $user) {
                $requests = get_user_meta($user->ID, '_deletion_request', true);
                if ($requests && is_array($requests)) {
                    foreach ($requests as $index => $request) {
                        if ($request['company_name'] === $company_name) {
                            unset($requests[$index]);
                            update_user_meta($user->ID, '_deletion_request', $requests);
                            break;
                        }
                    }
                }
            }

            wp_send_json_success('Request deleted successfully');
        } elseif ($action === 'reject') {
            // Only delete the request-related metadata
            $users_with_requests = get_users(array(
                'meta_key'     => '_deletion_request',
                'meta_compare' => 'EXISTS'
            ));

            foreach ($users_with_requests as $user) {
                $requests = get_user_meta($user->ID, '_deletion_request', true);
                if ($requests && is_array($requests)) {
                    foreach ($requests as $index => $request) {
                        if ($request['company_name'] === $company_name) {
                            unset($requests[$index]);
                            update_user_meta($user->ID, '_deletion_request', $requests);
                            break;
                        }
                    }
                }
            }

            // No deletion of the post, only the metadata related to the request is removed
            wp_send_json_success('Delete request rejected successfully.');
        }
    } else {
        wp_send_json_error('Invalid data provided.');
    }

    wp_die(); // Properly terminate the request
}

add_action('wp_ajax_admin_handle_request_action', 'admin_handle_request_action');






// Admin handler for accepting or rejecting the request

add_action('init', 'handle_admin_delete_reject_requests');
function handle_admin_delete_reject_requests()
{
    if (current_user_can('administrator') && isset($_GET['action']) && isset($_GET['user_id']) && isset($_GET['company_name'])) {
        $user_id = intval($_GET['user_id']);
        $company_name = sanitize_text_field($_GET['company_name']);
        $action = sanitize_text_field($_GET['action']);

        // Fetch all deletion requests for the user
        $requests = get_user_meta($user_id, '_deletion_request', true);

        if ($requests && is_array($requests)) {
            foreach ($requests as $index => $request) {
                if ($request['company_name'] === $company_name) {
                    // Remove the specific request for the given company
                    unset($requests[$index]);
                    break;
                }
            }

            // Update the meta with the remaining requests or delete the meta if no requests left
            if (!empty($requests)) {
                update_user_meta($user_id, '_deletion_request', $requests);
            } else {
                delete_user_meta($user_id, '_deletion_request');
            }

            // Redirect with success parameter
            wp_redirect(add_query_arg('status', 'success', remove_query_arg(array('action', 'user_id', 'company_name'))));
            exit;
        }

        // Redirect with error parameter if no request found
        wp_redirect(add_query_arg('status', 'error', remove_query_arg(array('action', 'user_id', 'company_name'))));
        exit;
    }
}


// Handle deletion request (AJAX)
function handle_deletion_request()
{
    if (isset($_POST['company_name']) && !empty($_POST['company_name'])) {
        $company_name = sanitize_text_field($_POST['company_name']);
        $user_id = get_current_user_id();

        // Check if a post exists with the given company name
        $post = get_page_by_title($company_name, OBJECT, 'post');

        if ($post) {
            // Check if the user already sent a deletion request
            $existing_request = get_post_meta($post->ID, '_deletion_request', true);

            if (!$existing_request) {
                // Save the deletion request as post meta
                update_post_meta($post->ID, '_deletion_request', $user_id);

                // Send success response
                wp_send_json_success(['message' => 'Request sent successfully.']);
            } else {
                // If request exists, send a message
                wp_send_json_error(['message' => 'You have already sent a deletion request.']);
            }
        } else {
            wp_send_json_error(['message' => 'Post not found.']);
        }
    }
    wp_die();
}

add_action('wp_ajax_request_delete', 'handle_deletion_request');


add_action('wp_ajax_send_editor_request', 'handle_editor_request');
add_action('wp_ajax_nopriv_send_editor_request', 'handle_editor_request');






// category delete request

function dlt_handle_request_action()
{
    if (!current_user_can('administrator')) return;

    $category_id = isset($_POST['category_id']) ? absint($_POST['category_id']) : 0;
    $action = isset($_POST['request_action']) ? sanitize_text_field($_POST['request_action']) : '';

    if ($category_id && $action) {
        if ($action === 'approve') {
            wp_delete_term($category_id, 'category'); // Delete the category
        } elseif ($action === 'reject') {
            delete_term_meta($category_id, 'delete_request_status'); // Remove the request status
        }
    }

    wp_send_json_success('Action completed.');
}
add_action('wp_ajax_dlt_handle_request_action', 'dlt_handle_request_action');



// Handle AJAX request to notify admin about a category delete request (for editors)
function notify_admin_category_delete()
{
    // Check if the user is an editor
    if (!current_user_can('edit_posts')) {
        wp_send_json_error('You do not have permission to make this request.');
        wp_die();
    }

    $category_id = isset($_POST['category_id']) ? absint($_POST['category_id']) : 0;

    if ($category_id) {
        // Check if the category already has a pending delete request
        $existing_request = get_term_meta($category_id, 'delete_request_status', true);

        if ($existing_request === 'pending') {
            wp_send_json_error('Your request to delete this category is already pending.');
            wp_die();
        }

        // Store a request meta indicating a delete request was made
        update_term_meta($category_id, 'delete_request_status', 'pending');

        // // Optionally: Notify the admin via email (optional)
        // $admin_email = get_option('admin_email');
        $category = get_term($category_id);
        // $message = sprintf(
        //     'A request to delete the category "%s" (ID: %d) has been made by an editor.',
        //     $category->name,
        //     $category_id
        // );
        // wp_mail($admin_email, 'Category Delete Request', $message);

        wp_send_json_success('Delete request sent to admin.');
    } else {
        wp_send_json_error('Invalid category ID.');
    }
    wp_die();
}
add_action('wp_ajax_notify_admin_category_delete', 'notify_admin_category_delete');


//Request Subscriber become Editor
function custom_user_request_page()
{
    $current_user = wp_get_current_user();
    $is_admin = in_array('administrator', $current_user->roles);

    if (!$is_admin) {
        return 'You do not have permission to view this page.';
    }

    $users = get_users(array(
        'meta_key' => 'editor_request',
        'meta_value' => 'requested'
    ));

    ob_start();

    echo '<div class="wrap user-details-main">';
    echo '<h1>User Information</h1>';
    echo '<table id="user-details-table" class="widefat fixed user-details-table" cellspacing="0">
            <thead>
                <tr>
                    <th id="columnname" class="manage-column column-columnname" scope="col">User ID</th>
                    <th id="columnname" class="manage-column column-columnname" scope="col">User Role</th>
                    <th id="columnname" class="manage-column column-columnname" scope="col">Full Name</th>
                    <th id="columnname" class="manage-column column-columnname" scope="col">Email</th>
                    <th id="columnname" class="manage-column column-columnname us_action" scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>';
    foreach ($users as $user) {
        $user_id = $user->ID;
        $user_roles = implode(', ', $user->roles);
        $fullname = get_user_meta($user_id, 'fullname', true);
        $first_name = get_user_meta($user_id, 'first_name', true);
        $display_name = !empty($fullname) ? $fullname : $first_name;

        echo '<tr>';
        echo '<td>' . esc_html($user_id) . '</td>';
        echo '<td class="cap_text">' . esc_html($user_roles) . '</td>';
        echo '<td class="cap_text">' . esc_html($display_name) . '</td>';
        echo '<td>' . esc_html($user->user_email) . '</td>';
        echo '<td class="us_action_btn">';
        echo '<button class="accept-btn" data-user-id="' . esc_attr($user_id) . '">Accept</button> ';
        echo '<button class="reject-btn" data-user-id="' . esc_attr($user_id) . '">Reject</button>';
        echo '</td>';
        echo '</tr>';
    }

    echo '</tbody></table>';
    echo '</div>';

    return ob_get_clean();
}

function register_user_request_shortcode()
{
    add_shortcode('user_requests', 'custom_user_request_page');
}
add_action('init', 'register_user_request_shortcode');

function handle_editor_request()
{
    check_ajax_referer('editor_request_nonce', 'nonce');

    $current_user = wp_get_current_user();
    if ($current_user->exists()) {
        $has_requested = get_user_meta($current_user->ID, 'editor_request', true);
        if ($has_requested === 'requested') {
            wp_send_json_error(array('message' => 'You have already sent a request.'));
        } else {
            update_user_meta($current_user->ID, 'editor_request', 'requested');
            wp_send_json_success(array('message' => 'Request submitted successfully.'));
        }
    } else {
        wp_send_json_error(array('message' => 'User not logged in.'));
    }
}
add_action('wp_ajax_editor_request', 'handle_editor_request');

function handle_admin_editor_request()
{
    if (!current_user_can('administrator')) {
        wp_send_json_error(array('message' => 'You do not have permission to perform this action.'));
    }

    $user_id = isset($_POST['user_id']) ? intval($_POST['user_id']) : 0;
    $request_action = isset($_POST['request_action']) ? sanitize_text_field($_POST['request_action']) : '';

    if (!$user_id || !$request_action) {
        wp_send_json_error(array('message' => 'Invalid request.'));
    }

    $user = get_userdata($user_id);
    if (!$user) {
        wp_send_json_error(array('message' => 'User not found.'));
    }

    if ($request_action === 'accept') {
        $user->set_role('editor');
        update_user_meta($user_id, 'editor_request', '');
        wp_send_json_success(array('message' => 'User role updated to Editor.'));
    } elseif ($request_action === 'reject') {
        update_user_meta($user_id, 'editor_request', 'rejected');
        wp_send_json_success(array('message' => 'Editor request rejected.'));
    } else {
        wp_send_json_error(array('message' => 'Invalid action.'));
    }
}
add_action('wp_ajax_handle_admin_editor_request', 'handle_admin_editor_request');


// Add a new category via AJAX
function add_new_category_ajax()
{
    if (isset($_POST['category_name']) && !empty($_POST['category_name'])) {
        $category_name = sanitize_text_field($_POST['category_name']);

        $new_category = wp_insert_term(
            $category_name,
            'category',
            array(
                'slug' => sanitize_title($category_name)
            )
        );

        if (is_wp_error($new_category)) {
            wp_send_json_error($new_category->get_error_message());
        } else {
            wp_send_json_success('Category added successfully');
        }
    } else {
        wp_send_json_error('Category name is required.');
    }

    wp_die();
}
add_action('wp_ajax_add_new_category', 'add_new_category_ajax');
add_action('wp_ajax_nopriv_add_new_category', 'add_new_category_ajax');


// Handle delete category via AJAX
function delete_category_ajax()
{
    if (isset($_POST['category_id'])) {
        $category_id = intval($_POST['category_id']);
        $result = wp_delete_term($category_id, 'category');

        if (!is_wp_error($result)) {
            wp_send_json_success();
        } else {
            wp_send_json_error('Error deleting category.');
        }
    }
    wp_die();
}
add_action('wp_ajax_delete_category', 'delete_category_ajax');
add_action('wp_ajax_nopriv_delete_category', 'delete_category_ajax');

// Handle edit category via AJAX
function edit_category_ajax()
{
    if (isset($_POST['category_id']) && !empty($_POST['category_id']) && isset($_POST['category_name'])) {
        $category_id = intval($_POST['category_id']);
        $category_name = sanitize_text_field($_POST['category_name']);

        $result = wp_update_term($category_id, 'category', array('name' => $category_name));

        if (is_wp_error($result)) {
            wp_send_json_error($result->get_error_message());
        } else {
            wp_send_json_success('Category updated successfully');
        }
    } else {
        wp_send_json_error('Invalid data.');
    }
    wp_die();
}
add_action('wp_ajax_edit_category', 'edit_category_ajax');
add_action('wp_ajax_nopriv_edit_category', 'edit_category_ajax');
// Fetch category details via AJAX
function get_category_details_ajax()
{
    if (isset($_POST['category_id'])) {
        $category_id = intval($_POST['category_id']);
        $category = get_term($category_id);

        if (!is_wp_error($category)) {
            wp_send_json_success(array(
                'name' => $category->name,
            ));
        } else {
            wp_send_json_error('Category not found.');
        }
    }
    wp_die();
}
add_action('wp_ajax_get_category_details', 'get_category_details_ajax');
add_action('wp_ajax_nopriv_get_category_details', 'get_category_details_ajax');


function load_categories_ajax()
{
    // Get the current user
    $current_user = wp_get_current_user();
    // Get page number from AJAX request
    $paged_cat = isset($_POST['paged']) ? intval($_POST['paged']) : 1;
    $categories_per_page = 5;
    $offset = ($paged_cat - 1) * $categories_per_page;

    $args = array(
        'taxonomy' => 'category',
        'orderby' => 'name',
        'order' => 'ASC',
        'number' => $categories_per_page,
        'offset' => $offset,
        'hide_empty' => false,
    );

    $term_query = new WP_Term_Query($args);
    $categories = $term_query->terms;
    $total_categories = wp_count_terms(array('taxonomy' => 'category'));
    $total_pages_cat = ceil($total_categories / $categories_per_page);

    // Prepare HTML for the new categories list and pagination
    ob_start();

    // Add the "Add New Category" button and the popup form
    echo '<div class="cont-head">
            <div class="add-btn blue-btn-hv" id="open-category-popup">Add New Category</div>
          </div>
          <div id="category-popup" class="category-popup" style="display: none;">
              <div class="popup-content">
                  <h3 id="popup-title">Add New Category</h3>
                  <form id="category-form">
                      <label for="category-name">Category Name</label>
                      <input type="text" id="category-name" name="category_name" class="input-control" required>
                      <!-- Hidden field to store category ID when editing -->
                      <input type="hidden" id="category-id" name="category_id">
                      <input type="submit" id="submit-button" value="Add Category">
                  </form>
                  <button id="close-popup">Close</button>
              </div>
          </div>';

    // Display the categories
    if (!empty($categories)) {
        echo '<ul>';
        foreach ($categories as $category) {

            echo '<li>' . esc_html($category->name) . '
                <a href="#" class="edit-category" data-id="' . esc_attr($category->term_id) . '"><i class="fa fa-edit"></i></a>
                <a href="#" class="delete-category" data-id="' . esc_attr($category->term_id) . '"><i class="fa fa-trash"></i></a>
            </li>';
        }
        echo '</ul>';
    } else {
        echo '<p>No categories found.</p>';
    }

    // Generate the pagination links
    if ($total_pages_cat > 1) {
        echo '<nav class="pagination">';
        echo paginate_links(array(
            'base'      => '%_%',
            'format'    => 'page/%#%/',
            'current'   => $paged_cat,
            'total'     => $total_pages_cat,
            'prev_text' => __('&laquo; Prev'),
            'next_text' => __('Next &raquo;'),
        ));
        echo '</nav>';
    }

    $content = ob_get_clean();
    wp_send_json_success($content);
}
add_action('wp_ajax_load_categories', 'load_categories_ajax');
add_action('wp_ajax_nopriv_load_categories', 'load_categories_ajax');




function ajax_pagination()
{
    $paged = isset($_POST['page']) ? intval($_POST['page']) : 1;
    $template_file = 'node-child-view.php';  // Use your template file name

    $args = array(
        'post_type'      => 'page',
        'post_status'    => 'publish',
        'meta_key'       => '_wp_page_template',
        'meta_value'     => $template_file,
        'posts_per_page' => 5,  // Adjust the number of posts per page
        'paged'          => $paged
    );

    // Custom query
    $template_query = new WP_Query($args);

    // Output HTML
    if ($template_query->have_posts()) {
        $output = '<div class="process-main"><ul class="mod-list">';

        while ($template_query->have_posts()) {
            $template_query->the_post();

            // Get the delete URL (nonce for security)
            $delete_url = wp_nonce_url(
                admin_url('admin-post.php?action=delete_page&post_id=' . get_the_ID()),
                'delete_page_' . get_the_ID()
            );

            // Add each page title with a delete button
            $output .= '<li>';
            $output .= '<span>' . get_the_title() . '</span>';
            $output .= '<div class="mod-list-btns">';
            $output .= '<a href="' . get_permalink() . '">View</a>';
            $output .= '<a href="' . esc_url($delete_url) . '" class="delete-button" onclick="return confirm(\'Are you sure you want to delete this page?\');">Delete</a>';
            $output .= '</div>';
            $output .= '</li>';
        }

        $output .= '</ul></div>';

        // Pagination links
        $pagination = paginate_links(array(
            'total'        => $template_query->max_num_pages,
            'current'      => $paged,
            'type'         => 'array',
            'prev_text'    => __('« Previous'),
            'next_text'    => __('Next »'),
        ));

        // Append pagination links to the output
        if ($pagination) {
            $output .= '<div class="pagination_two"><ul>';
            foreach ($pagination as $page_link) {
                $output .= '<li>' . $page_link . '</li>';
            }
            $output .= '</ul></div>';
        }

        // Return the output
        wp_send_json_success($output);
    } else {
        wp_send_json_error('<p>No pages found.</p>');
    }

    wp_die(); // Stop execution
}
add_action('wp_ajax_nopriv_ajax_pagination', 'ajax_pagination');
add_action('wp_ajax_ajax_pagination', 'ajax_pagination');


function handle_delete_page()
{
    // Check for the nonce to ensure security
    if (isset($_GET['post_id']) && isset($_GET['_wpnonce']) && wp_verify_nonce($_GET['_wpnonce'], 'delete_page_' . $_GET['post_id'])) {
        $post_id = intval($_GET['post_id']);

        // Check if the current user has permission to delete this page
        if (current_user_can('delete_post', $post_id)) {
            wp_delete_post($post_id, true); // Force delete the post
            wp_redirect(admin_url('edit.php?post_type=page')); // Redirect to the page list after deletion
            exit;
        } else {
            wp_die('You do not have permission to delete this page.');
        }
    } else {
        wp_die('Security check failed.');
    }
}
add_action('admin_post_delete_page', 'handle_delete_page');

function delete_user_ajax_handler()
{

    //check_ajax_referer( 'delete_user_nonce', 'security' );
    if (isset($_POST['user_id'])) {
        $user_id = intval($_POST['user_id']);
        // Delete the user
        if (wp_delete_user($user_id)) {
            wp_send_json_success();
        } else {
            wp_send_json_error();
        }
    }

    wp_send_json_error();
}
add_action('wp_ajax_delete_user', 'delete_user_ajax_handler');


function add_delete_user_nonce()
{
?>
    <script type="text/javascript">
        var user_delete_nonce = '<?php echo wp_create_nonce('delete_user_nonce'); ?>';
    </script>
<?php
}
add_action('admin_footer', 'add_delete_user_nonce');


// WordPress AJAX handler for TinyMCE image upload
// WordPress AJAX handler for TinyMCE image upload
function handle_tinymce_image_upload()
{
    if (!empty($_FILES['file'])) {
        $file = $_FILES['file'];

        // Use WordPress' built-in file handling
        $upload = wp_handle_upload($file, array('test_form' => false));

        if ($upload && !isset($upload['error'])) {
            $file_url = $upload['url']; // Get the file URL
            wp_send_json_success(array('url' => $file_url)); // Send the file URL back to TinyMCE
        } else {
            wp_send_json_error(array('message' => $upload['error']));
        }
    } else {
        wp_send_json_error(array('message' => 'No file uploaded.'));
    }
}
add_action('wp_ajax_upload_image', 'handle_tinymce_image_upload');



function custom_mime_types($mimes)
{
    // Add additional file types
    $mimes['jpg'] = 'image/jpeg';
    $mimes['jpeg'] = 'image/jpeg';
    $mimes['png'] = 'image/png';
    $mimes['gif'] = 'image/gif';
    $mimes['jfif'] = 'image/jpeg';
    $mimes['pdf'] = 'application/pdf';
    $mimes['doc'] = 'application/msword';
    $mimes['docx'] = 'application/vnd.openxmlformats-officedocument.wordprocessingml.document';
    $mimes['ppt'] = 'application/vnd.ms-powerpoint';
    $mimes['pptx'] = 'application/vnd.openxmlformats-officedocument.presentationml.presentation';
    // Add more types as needed

    return $mimes;
}
add_filter('upload_mimes', 'custom_mime_types');

function create_industries_post_type()
{
    $labels = array(
        'name'                  => _x('Industries', 'Post type general name'),
        'singular_name'         => _x('Industry', 'Post type singular name'),
        'menu_name'             => _x('Industries', 'Admin Menu text'),
        'name_admin_bar'        => _x('Industry', 'Add New on Toolbar'),
        'add_new'               => __('Add New'),
        'add_new_item'          => __('Add New Industry'),
        'new_item'              => __('New Industry'),
        'edit_item'             => __('Edit Industry'),
        'view_item'             => __('View Industry'),
        'all_items'             => __('All Industries'),
        'search_items'          => __('Search Industries'),
        'not_found'             => __('No industries found.'),
        'not_found_in_trash'    => __('No industries found in Trash.'),
        'featured_image'        => _x('Industry Cover Image', 'Overrides the “Featured Image” phrase for this post type.'),
        'set_featured_image'    => _x('Set cover image', 'Overrides the “Set featured image” phrase for this post type.'),
        'remove_featured_image' => _x('Remove cover image', 'Overrides the “Remove featured image” phrase for this post type.'),
        'use_featured_image'    => _x('Use as cover image', 'Overrides the “Use as featured image” phrase for this post type.'),
        'archives'              => _x('Industry Archives', 'The post type archive label'),
        'insert_into_item'      => _x('Insert into industry', 'Overrides the “Insert into post” phrase for this post type.'),
        'uploaded_to_this_item' => _x('Uploaded to this industry', 'Overrides the “Uploaded to this post” phrase for this post type.'),
    );

    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'has_archive'        => true,
        'rewrite'            => array('slug' => 'industries'), // URL slug
        'show_in_rest'       => true, // Enable Gutenberg editor support
        'supports'           => array('title', 'editor', 'thumbnail'),
        'taxonomies'         => array('category', 'post_tag'), // You can add custom taxonomies later
        'show_in_menu'       => true,
        'menu_position'      => 5,
    );

    register_post_type('industries', $args);
}
add_action('init', 'create_industries_post_type');



function create_new_post()
{
    global $wpdb;

    // Verify the request
    if (
        isset($_POST['post_content']) &&
        isset($_POST['industry_slug']) &&
        isset($_POST['addtext']) &&
        isset($_POST['country'])
    ) {
        $post_content = $_POST['post_content'];
        $industry_slug = sanitize_text_field($_POST['industry_slug']);
        $addtext = sanitize_text_field($_POST['addtext']);
        $country = sanitize_text_field($_POST['country']);

        // Get the category by slug
        $category = get_category_by_slug($industry_slug);

        if (!$category) {
            wp_send_json_error(array('message' => 'Invalid category selected.'));
            wp_die();
        }

        // Generate the initial slug
        $slug = sanitize_title($addtext);
        $original_slug = $slug;

        // Check if the slug already exists
        $increment = 1;
        while (post_exists('', '', '', 'industries', $slug) || term_exists($slug, 'category')) { // Check if the slug exists for post or category
            $slug = $original_slug . '-' . $increment;
            $increment++;
        }

        // Create the post
        $post_id = wp_insert_post(array(
            'post_title'    => $addtext,
            'post_content'  => $post_content,
            'post_status'   => 'publish',
            'post_author'   => get_current_user_id(),
            'post_type'     => 'industries',
            'post_category' => array($category->term_id),
            'post_name'     => $slug, // Set the slug here
        ));

        if (is_wp_error($post_id)) {
            wp_send_json_error(array('message' => $post_id->get_error_message()));
        } else {
            update_post_meta($post_id, 'selected_country', $country);
            $post_url = get_permalink($post_id);
            wp_send_json_success(array('message' => 'Post created successfully!', 'post_id' => $post_id, 'post_slug' => $slug, 'post_url' => $post_url));
        }
    } else {
        wp_send_json_error(array('message' => 'Invalid input.'));
    }

    wp_die(); // Important to close the AJAX request
}
add_action('wp_ajax_create_new_post', 'create_new_post');
add_action('wp_ajax_nopriv_create_new_post', 'create_new_post');

// For non-logged-in users


function load_single_post_content()
{
    if (isset($_POST['post_id'])) {
        $post_id = intval($_POST['post_id']);
        $post = get_post($post_id);

        if ($post) {
            echo '<div class="industry_heading">' . '<h2>' . '<strong>' . esc_html($post->post_title) . '</strong>' . '</h2>' . '</div>';
            echo '<div class="industry_content">' . apply_filters('get_the_content', $post->post_content) . '</div>';
        } else {
            echo 'Post not found.';
        }
    }

    wp_die(); // This is required to terminate immediately and return the response
}

add_action('wp_ajax_load_single_post_content', 'load_single_post_content');
add_action('wp_ajax_nopriv_load_single_post_content', 'load_single_post_content');


function filter_categories_by_country()
{
    if (isset($_POST['country'])) {
        $selected_country = sanitize_text_field($_POST['country']);

        // Query to get posts that match the selected country
        $args = array(
            'post_type' => 'industries',
            'meta_query' => array(
                array(
                    'key' => 'selected_country', // Meta key where the country is saved
                    'value' => $selected_country,
                    'compare' => '='
                )
            ),
            'tax_query' => array(
                array(
                    'taxonomy' => 'category',
                    'field'    => 'term_id',
                    'terms'    => wp_list_pluck(get_categories(), 'term_id'), // Filter categories that have posts in the selected country
                ),
            ),
        );

        $filtered_posts = new WP_Query($args);
        $categories = array(); // Initialize an array to hold the category IDs

        // Fetch categories that have posts in the selected country
        if ($filtered_posts->have_posts()) {
            while ($filtered_posts->have_posts()) {
                $filtered_posts->the_post();
                $post_categories = wp_get_post_categories(get_the_ID());
                foreach ($post_categories as $category) {
                    $categories[] = $category;
                }
            }
        }

        // Remove duplicates
        $categories = array_unique($categories);

        // Return the categories
        $response = array();
        foreach ($categories as $cat_id) {
            $category = get_category($cat_id);
            $response[] = array('id' => $category->term_id, 'name' => $category->name);
        }

        wp_send_json_success($response);
    }

    wp_die();
}
add_action('wp_ajax_filter_categories_by_country', 'filter_categories_by_country');
add_action('wp_ajax_nopriv_filter_categories_by_country', 'filter_categories_by_country');



function load_posts_by_category_and_country()
{
    if (isset($_POST['category_id']) && isset($_POST['country'])) {
        $category_id = sanitize_text_field($_POST['category_id']);
        $selected_country = sanitize_text_field($_POST['country']);

        // Query to get posts that match the selected category and country
        $args = array(
            'post_type' => 'industries',
            'tax_query' => array(
                array(
                    'taxonomy' => 'category',
                    'field'    => 'term_id',
                    'terms'    => $category_id
                ),
            ),
            'meta_query' => array(
                array(
                    'key'     => 'selected_country',
                    'value'   => $selected_country,
                    'compare' => '='
                ),
            ),
        );

        $posts = new WP_Query($args);

        if ($posts->have_posts()) {
            $response = '';
            while ($posts->have_posts()) {
                $posts->the_post();
                $response .= '<li class="indust-cat-post" id="post-' . get_the_ID() . '">';
                $response .= '<h3><a href="' . get_permalink() . '" class="ajax-post-link" data-post-id="' . get_the_ID() . '">' . get_the_title() . '</a></h3>';
                $response .= '<p>' . wp_trim_words(get_the_excerpt(), 10) . '</p>';
                $response .= '</li>';
            }
            wp_reset_postdata();
            wp_send_json_success($response);
        } else {
            wp_send_json_error(array('message' => 'No posts found.'));
        }
    } else {
        wp_send_json_error(array('message' => 'Invalid request.'));
    }

    wp_die(); // Necessary to end the AJAX request properly
}
add_action('wp_ajax_load_posts_by_category_and_country', 'load_posts_by_category_and_country');
add_action('wp_ajax_nopriv_load_posts_by_category_and_country', 'load_posts_by_category_and_country');



// update_like_count

function update_like_status()
{
    if (!is_user_logged_in()) {
        wp_send_json_error("You must be logged in to like posts.");
        return;
    }

    if (isset($_POST['post_id']) && isset($_POST['user_id']) && isset($_POST['like_status'])) {
        $post_id = intval($_POST['post_id']);
        $user_id = intval($_POST['user_id']);
        $like_status = filter_var($_POST['like_status'], FILTER_VALIDATE_BOOLEAN);

        $likes = get_post_meta($post_id, '_user_likes', true) ?: [];

        if ($like_status) {
            if (!in_array($user_id, $likes)) {
                $likes[] = $user_id;
            }
        } else {
            $likes = array_diff($likes, [$user_id]);
        }

        update_post_meta($post_id, '_user_likes', $likes);

        // Return the updated like count
        wp_send_json_success(['like_count' => count($likes)]);
    } else {
        wp_send_json_error("Invalid data.");
    }
}
add_action('wp_ajax_update_like_status', 'update_like_status');
add_action('wp_ajax_nopriv_update_like_status', 'update_like_status');



add_action('wp_ajax_update_node_like_status', 'update_node_like_status');
add_action('wp_ajax_nopriv_update_node_like_status', 'update_node_like_status');

function update_node_like_status()
{
    $post_id = intval($_POST['post_id']);
    $node_id = sanitize_text_field($_POST['node_id']);
    $user_id = get_current_user_id();
    $like_key = "_user_likes_{$node_id}";
    $like_status = filter_var($_POST['like_status'], FILTER_VALIDATE_BOOLEAN);

    if ($user_id && $post_id && $node_id) {
        $likes = get_post_meta($post_id, $like_key, true) ?: [];

        if ($like_status && !in_array($user_id, $likes)) {
            $likes[] = $user_id;
        } elseif (!$like_status && in_array($user_id, $likes)) {
            $likes = array_diff($likes, [$user_id]);
        }

        update_post_meta($post_id, $like_key, $likes);

        wp_send_json_success(['like_count' => count($likes)]);
    } else {
        wp_send_json_error('Invalid request');
    }
}





// Register AJAX action for logged-in and non-logged-in users
add_action('wp_ajax_submit_node_comment', 'submit_node_comment');
add_action('wp_ajax_nopriv_submit_node_comment', 'submit_node_comment');

function submit_node_comment()
{
    // Check if the user is logged in
    if (!is_user_logged_in()) {
        wp_send_json_error(['message' => 'Please log in to comment.']);
        wp_die();
    }

    // Sanitize and validate the POST data
    $post_id = isset($_POST['post_id']) ? intval($_POST['post_id']) : 0;
    $node_id = isset($_POST['node_id']) ? sanitize_text_field($_POST['node_id']) : '';
    $comment_text = isset($_POST['comment_text']) ? sanitize_textarea_field($_POST['comment_text']) : '';

    if (empty($post_id) || empty($node_id) || empty($comment_text)) {
        wp_send_json_error(['message' => 'Incomplete data provided.']);
        wp_die();
    }

    // Get the current user details
    $current_user = wp_get_current_user();
    $comment_data = [
        'user_id' => $current_user->ID,
        'user_name' => $current_user->display_name,
        'comment_text' => $comment_text,
        // 'timestamp' => current_time('mysql')
        'timestamp' => date('d-m-Y')
    ];

    // Retrieve existing comments from post meta
    $node_comments = get_post_meta($post_id, 'node_comments_' . $node_id, true);

    if (!$node_comments) {
        $node_comments = []; // Initialize as an empty array if no comments exist
    }

    // Add the new comment to the array
    $node_comments[] = $comment_data;

    // Update post meta with the new comment array
    update_post_meta($post_id, 'node_comments_' . $node_id, $node_comments);

    // Check if the current user is an admin and whether they are the author of the comment
    $is_admin = current_user_can('administrator');  // Check if the user is an admin
    $is_author = ($current_user->ID == $comment_data['user_id']);  // Check if the user is the author of the comment

    wp_send_json_success([
        'message' => 'Comment submitted successfully!',
        'comment_data' => $comment_data,
        'is_admin' => $is_admin,  // Add this field
        'is_author' => $is_author // Add this field
    ]);

    wp_die();
}

// Handle delete_node_comment action, restricted to admin users
add_action('wp_ajax_delete_node_comment', 'delete_node_comment');
function delete_node_comment()
{
    if (!current_user_can('manage_options')) {
        wp_send_json_error(['message' => 'You do not have permission to delete comments.']);
        return;
    }

    $post_id = intval($_POST['post_id']);
    $node_id = sanitize_text_field($_POST['node_id']);
    $comment_index = intval($_POST['comment_index']);

    $comments = get_post_meta($post_id, "node_comments_{$node_id}", true) ?: [];

    if (isset($comments[$comment_index])) {
        unset($comments[$comment_index]);
        $comments = array_values($comments); // Re-index the array after deletion
        update_post_meta($post_id, "node_comments_{$node_id}", $comments);

        wp_send_json_success(['message' => 'Comment deleted successfully.']);
    } else {
        wp_send_json_error(['message' => 'Comment not found.']);
    }
}

// Include is_author flag in get_node_comments
add_action('wp_ajax_get_node_comments', 'get_node_comments');
add_action('wp_ajax_nopriv_get_node_comments', 'get_node_comments');
function get_node_comments()
{
    $post_id = intval($_POST['post_id']);
    $node_id = sanitize_text_field($_POST['node_id']);
    $current_user_id = get_current_user_id();

    // Retrieve comments for the node
    $comments = get_post_meta($post_id, "node_comments_{$node_id}", true) ?: [];

    // Add is_author flag to each comment
    foreach ($comments as &$comment) {
        $comment['is_author'] = ($comment['user_id'] === $current_user_id);
    }

    wp_send_json_success([
        'comments' => $comments,
        'is_admin' => current_user_can('manage_options')
    ]);
}

// Handle edit_node_comment action, restricted to comment authors
add_action('wp_ajax_edit_node_comment', 'edit_node_comment');
function edit_node_comment()
{
    $comment_index = intval($_POST['comment_index']);
    $post_id = intval($_POST['post_id']);
    $node_id = sanitize_text_field($_POST['node_id']);
    $new_text = sanitize_text_field($_POST['comment_text']);
    $current_user_id = get_current_user_id();

    // Retrieve comments
    $comments = get_post_meta($post_id, "node_comments_{$node_id}", true) ?: [];

    // Check if the comment exists and the current user is the author
    if (isset($comments[$comment_index]) && $comments[$comment_index]['user_id'] === $current_user_id) {
        $comments[$comment_index]['comment_text'] = $new_text;
        update_post_meta($post_id, "node_comments_{$node_id}", $comments);

        wp_send_json_success(['message' => 'Comment updated successfully.', 'comment_text' => $new_text]);
    } else {
        wp_send_json_error(['message' => 'You do not have permission to edit this comment.']);
    }
}



// Profile picture upload

function upload_profile_picture()
{
    if (isset($_FILES['profile_pic']) && !empty($_FILES['profile_pic']['name'])) {
        $user_id = get_current_user_id();
        $file = $_FILES['profile_pic'];

        // Check if file is an image
        if (getimagesize($file['tmp_name'])) {
            require_once(ABSPATH . 'wp-admin/includes/file.php');
            $upload_overrides = ['test_form' => false];
            $uploaded_file = wp_handle_upload($file, $upload_overrides);

            if ($uploaded_file && !isset($uploaded_file['error'])) {
                $image_url = $uploaded_file['url'];
                update_user_meta($user_id, 'profile_picture', $image_url); // Save the image URL in user meta

                wp_send_json_success(['image_url' => $image_url]);
            } else {
                wp_send_json_error(['message' => 'Error uploading file.']);
            }
        } else {
            wp_send_json_error(['message' => 'File is not an image.']);
        }
    } else {
        wp_send_json_error(['message' => 'No file selected.']);
    }
}
add_action('wp_ajax_upload_profile_picture', 'upload_profile_picture');


// Account Delete of User

// Check if the user has already requested account deletion
function check_existing_deletion_request() {
    // Ensure the user is logged in
    if (is_user_logged_in()) {
        $user_id = intval($_POST['user_id']);

        // Check if the user has an existing deletion request
        $existing_request = get_user_meta($user_id, 'account_deletion_request', true);

        if ($existing_request) {
            // If deletion request exists, return a success response
            wp_send_json_success(array('message' => 'Deletion request already exists.'));
        } else {
            // If no deletion request exists, allow the user to submit a new request
            wp_send_json_error(array('message' => 'No existing deletion request.'));
        }
    } else {
        wp_send_json_error(array('message' => 'You must be logged in to check for deletion requests.'));
    }
}
add_action('wp_ajax_check_existing_deletion_request', 'check_existing_deletion_request');

// Handle the deletion request (as per your existing handler)
function handle_account_deletion_request() {
    if (is_user_logged_in()) {
        $user_id = intval($_POST['user_id']);
        $user_name = sanitize_text_field($_POST['user_name']);
        $user_role = sanitize_text_field($_POST['user_role']);

        // Store the deletion request in the user's metadata
        $deletion_request = array(
            'requested_by' => $user_name,
            'role' => $user_role,
            'date_requested' => current_time('mysql')
        );

        // Only store a new request if no existing request is found
        $existing_request = get_user_meta($user_id, 'account_deletion_request', true);
        if ($existing_request) {
            wp_send_json_error(array('message' => 'You have already requested account deletion.'));
        }

        update_user_meta($user_id, 'account_deletion_request', $deletion_request);

        wp_send_json_success(array('message' => 'Your account deletion request has been sent!'));
    } else {
        wp_send_json_error(array('message' => 'You must be logged in to make a deletion request.'));
    }
}
add_action('wp_ajax_delete_account_request', 'handle_account_deletion_request');

function handle_user_account_request() {
    if (!current_user_can('administrator')) {
        wp_send_json_error(array('message' => 'You do not have permission to perform this action.'));
    }

    $user_id = intval($_POST['user_id']);
    $action_type = sanitize_text_field($_POST['action_type']);

    if ($user_id && get_userdata($user_id)) {
        if ($action_type === 'delete') {
            // Delete the user account
            wp_delete_user($user_id);
            wp_send_json_success(array('message' => 'User account has been deleted.'));
        } elseif ($action_type === 'reject') {
            // Remove the deletion request metadata
            delete_user_meta($user_id, 'account_deletion_request');
            wp_send_json_success(array('message' => 'Account deletion request has been rejected.'));
        } else {
            wp_send_json_error(array('message' => 'Invalid action type.'));
        }
    } else {
        wp_send_json_error(array('message' => 'Invalid user ID.'));
    }
}
add_action('wp_ajax_handle_user_account_request', 'handle_user_account_request');


//REports
// Register AJAX action for logged-in and non-logged-in users
add_action('wp_ajax_submit_node_report', 'submit_node_report');
add_action('wp_ajax_nopriv_submit_node_report', 'submit_node_report');

function submit_node_report()
{
    // Check if the user is logged in
    if (!is_user_logged_in()) {
        wp_send_json_error(['message' => 'Please log in to report.']);
        wp_die();
    }

    // Sanitize and validate the POST data
    $post_id = isset($_POST['post_id']) ? intval($_POST['post_id']) : 0;
    $node_id = isset($_POST['node_id']) ? sanitize_text_field($_POST['node_id']) : '';
    $report_text = isset($_POST['report_text']) ? sanitize_textarea_field($_POST['report_text']) : '';

    if (empty($post_id) || empty($node_id) || empty($report_text)) {
        wp_send_json_error(['message' => 'Incomplete data provided.']);
        wp_die();
    }

    // Get the current user details
    $current_user = wp_get_current_user();
    $user_id = $current_user->ID;
    $report_data = [
        'user_id' => $current_user->ID,
        'user_name' => $current_user->display_name,
        'report_text' => $report_text,
        // 'timestamp' => current_time('mysql')
        'timestamp' => date('d-m-Y')
    ];

    // Retrieve existing comments from post meta
    $node_reports = get_post_meta($post_id, 'node_reports_' . $node_id, true);

    if (!$node_reports) {
        $node_reports = []; // Initialize as an empty array if no comments exist
    }



    // Check if the user has already reported
    foreach ($node_reports as $report) {
        if ($report['user_id'] == $user_id) {
            wp_send_json_error(['message' => 'You have already submitted a report for this node.']);
            wp_die();
        }
    }

    // Add the new report
    $report_data = [
        'user_id' => $user_id,
        'user_name' => $current_user->display_name,
        'report_text' => $report_text,
        'timestamp' => date('d-m-Y'),
    ];

    $node_reports[] = $report_data;

    // Update post meta
    update_post_meta($post_id, 'node_reports_' . $node_id, $node_reports);

    wp_send_json_success([
        'message' => 'Report submitted successfully!',
        'report_data' => $report_data,
    ]);

    // // Add the new comment to the array
    // $node_reports[] = $report_data;


    // // Update post meta with the new comment array
    // update_post_meta($post_id, 'node_reports_' . $node_id, $node_reports);

    // // Check if the current user is an admin and whether they are the author of the comment
    // $is_admin = current_user_can('administrator');  // Check if the user is an admin
    // $is_author = ($current_user->ID == $report_data['user_id']);  // Check if the user is the author of the comment

    // wp_send_json_success([
    //     'message' => 'Report submitted successfully!',
    //     'report_data' => $report_data,
    //     'is_admin' => $is_admin,  // Add this field
    //     'is_author' => $is_author // Add this field
    // ]);

    wp_die();
}

// Handle delete_node_comment action, restricted to admin users
add_action('wp_ajax_delete_node_report', 'delete_node_report');
function delete_node_report()
{
    if (!current_user_can('manage_options')) {
        wp_send_json_error(['message' => 'You do not have permission to delete reports.']);
        return;
    }

    $post_id = intval($_POST['post_id']);
    $node_id = sanitize_text_field($_POST['node_id']);
    $report_index = intval($_POST['report_index']);

    $reports = get_post_meta($post_id, "node_reports_{$node_id}", true) ?: [];

    if (isset($reports[$report_index])) {
        unset($reports[$report_index]);
        $reports = array_values($reports); // Re-index the array after deletion
        update_post_meta($post_id, "node_reports_{$node_id}", $reports);

        wp_send_json_success(['message' => 'report deleted successfully.']);
    } else {
        wp_send_json_error(['message' => 'report not found.']);
    }
}

// Include is_author flag in get_node_comments
add_action('wp_ajax_get_node_reports', 'get_node_reports');
add_action('wp_ajax_nopriv_get_node_reports', 'get_node_reports');
function get_node_reports()
{
    $post_id = intval($_POST['post_id']);
    $node_id = sanitize_text_field($_POST['node_id']);
    $current_user_id = get_current_user_id();

    // Retrieve comments for the node
    $reports = get_post_meta($post_id, "node_reports_{$node_id}", true) ?: [];
    $user_has_reported = false;

    // Add is_author flag to each comment
    foreach ($reports as &$report) {
        // $report['is_author'] = ($report['user_id'] === $current_user_id);
        if ($report['user_id'] == $current_user_id) {
            $user_has_reported = true;
            break;
        }
    }

    wp_send_json_success([
        'reports' => $reports,
        'is_admin' => current_user_can('manage_options'),
        'user_has_reported' => $user_has_reported,
    ]);
}


// Search on Indusries
add_action('wp_ajax_search_categories', 'search_categories_callback');
add_action('wp_ajax_nopriv_search_categories', 'search_categories_callback');

function search_categories_callback() {
    // Get the search term from the AJAX request
    $search_term = sanitize_text_field($_POST['search_term']);
    
    // Search categories by name
    $categories = get_categories(array(
        'taxonomy' => 'category',
        'orderby' => 'name',
        'order' => 'ASC',
        'hide_empty' => false,
        'search' => $search_term, // Search term here
    ));

    $results = array();

    if (!empty($categories)) {
        foreach ($categories as $category) {
            $results[] = array(
                'id' => $category->term_id,
                'name' => esc_html($category->name),
                'slug' => esc_attr($category->slug),
            );
        }
    }

    // Return results as JSON
    wp_send_json_success($results);
}
