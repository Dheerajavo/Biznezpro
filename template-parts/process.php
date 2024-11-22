<div class="tab-pane fade" id="home-tab-pane" role="tabpanel" aria-labelledby="home-tab" tabindex="0">
    <div class="content-wrap">
        <div class="cont-head">
            <h2>Lorem, ipsum dolor sit amet consectetur adipisicing elit</h2>
            <div class="add-btn"><a href="<?php echo home_url('/node/') ?>" class="btn">Add New Process</a></div>
        </div>
        <?php
        // Handle delete action
        if (current_user_can('administrator') && isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['company_name'])) {
            // if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['company_name'])) {
            global $wpdb;

            $company_name = sanitize_text_field($_GET['company_name']);
            $table_name = $wpdb->prefix . 'node_data';

            // Delete the record from the custom table
            $deleted = $wpdb->delete($table_name, array('company_name' => $company_name));

            // Find the corresponding post by title (company name)
            $post = get_page_by_title($company_name, OBJECT, 'post');

            // Delete the post if it exists
            if ($post) {
                wp_delete_post($post->ID, true);
            }

            if ($deleted !== false) {
                // Success
                echo "<script>
            jQuery(document).ready(function($) {
                Swal.fire({
                    title: 'Deleted!',
                    text: 'The record has been deleted successfully.',
                    icon: 'success',
                    confirmButtonText: 'OK'
                }).then(function() {
                    window.location.href = '" . esc_url(home_url('/account/')) . "';
                });
            });
            </script>";
            } else {
                // Error
                echo "<script>
            jQuery(document).ready(function($) {
                Swal.fire({
                    title: 'Error!',
                    text: 'There was an error deleting the record. Please try again.',
                    icon: 'error',
                    confirmButtonText: 'OK'
                }).then(function() {
                    window.location.href = '" .  esc_url(home_url('/account/')) . "';
                });
            });
            </script>";
            }
        }
        ?>

        <!-- Add this script in the HTML part where you output the delete link -->
        <script>
            jQuery(document).ready(function($) {
                $('.delete-record').on('click', function(event) {
                    event.preventDefault();

                    var deleteUrl = $(this).attr('href');
                    var companyName = $(this).data('company-name');

                    // Check if the user is an admin
                    <?php if (current_user_can('administrator')): ?>
                        // Admin deletion
                        Swal.fire({
                            title: 'Are you sure?',
                            text: 'Do you really want to delete?',
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonText: 'Yes, delete it!',
                            cancelButtonText: 'No, cancel!'
                        }).then(function(result) {
                            if (result.isConfirmed) {
                                window.location.href = deleteUrl;
                            }
                        });
                    <?php else: ?>
                        // Non-admin: request deletion
                        // Send an AJAX request to check if the user has already requested deletion
                        $.ajax({
                            url: '<?php echo admin_url('admin-ajax.php'); ?>',
                            type: 'POST',
                            data: {
                                action: 'check_deletion_request',
                                company_name: companyName
                            },
                            success: function(response) {
                                if (response.success) {
                                    // If no request has been made yet, ask for confirmation to request deletion
                                    Swal.fire({
                                        title: 'Request Deletion',
                                        text: 'Do you want to request deletion from the admin?',
                                        icon: 'info',
                                        showCancelButton: true,
                                        confirmButtonText: 'Yes, request it!',
                                        cancelButtonText: 'No, cancel!'
                                    }).then(function(result) {
                                        if (result.isConfirmed) {
                                            // Send the deletion request
                                            $.ajax({
                                                url: '<?php echo admin_url('admin-ajax.php'); ?>',
                                                type: 'POST',
                                                data: {
                                                    action: 'request_delete',
                                                    company_name: companyName
                                                },
                                                success: function(response) {
                                                    if (response.success) {
                                                        Swal.fire({
                                                            title: 'Request Sent',
                                                            text: 'Your deletion request has been sent to the admin.',
                                                            icon: 'success',
                                                            confirmButtonText: 'OK'
                                                        });
                                                    }
                                                },
                                                error: function() {
                                                    Swal.fire({
                                                        title: 'Error',
                                                        text: 'Unable to send request. Please try again.',
                                                        icon: 'error',
                                                        confirmButtonText: 'OK'
                                                    });
                                                }
                                            });
                                        }
                                    });
                                } else {
                                    // If request has already been sent, directly show the "Already Sent" message
                                    Swal.fire({
                                        title: 'Already Sent',
                                        text: response.data.message,
                                        icon: 'info',
                                        confirmButtonText: 'OK'
                                    });
                                }
                            },
                            error: function() {
                                Swal.fire({
                                    title: 'Error',
                                    text: 'Unable to check the request status. Please try again.',
                                    icon: 'error',
                                    confirmButtonText: 'OK'
                                });
                            }
                        });
                    <?php endif; ?>
                });
            });

            // jQuery(document).ready(function($) {
            //     $('.delete-record').on('click', function(event) {
            //         event.preventDefault();

            //         var deleteUrl = $(this).attr('href');
            //         var companyName = $(this).data('company-name');
            //         // Check if the user is an admin
            //         <?php //if (current_user_can('administrator')):
                        ?>
            //             // Admin deletion
            //             Swal.fire({
            //                 title: 'Are you sure?',
            //                 text: 'Do you really want to delete?',
            //                 icon: 'warning',
            //                 showCancelButton: true,
            //                 confirmButtonText: 'Yes, delete it!',
            //                 cancelButtonText: 'No, cancel!'
            //             }).then(function(result) {
            //                 if (result.isConfirmed) {
            //                     window.location.href = deleteUrl;
            //                 }
            //             });
            //         <?php //else:
                        ?>
            //             // Non-admin: request deletion
            //             Swal.fire({
            //                 title: 'Request Deletion',
            //                 text: 'Do you want to request deletion from the admin?',
            //                 icon: 'info',
            //                 showCancelButton: true,
            //                 confirmButtonText: 'Yes, request it!',
            //                 cancelButtonText: 'No, cancel!'
            //             }).then(function(result) {
            //                 if (result.isConfirmed) {
            //                     // Send an AJAX request to save the deletion request
            //                     $.ajax({
            //                         url: '<?php //echo admin_url('admin-ajax.php');
                                                ?>',
            //                         type: 'POST',
            //                         data: {
            //                             action: 'request_delete',
            //                             company_name: companyName
            //                         },
            //                         success: function(response) {
            //                             if (response.success) {
            //                                 Swal.fire({
            //                                     title: 'Request Sent',
            //                                     text: 'Your deletion request has been sent to the admin.',
            //                                     icon: 'success',
            //                                     confirmButtonText: 'OK'
            //                                 });
            //                             } else {
            //                                 // If request already exists
            //                                 Swal.fire({
            //                                     title: 'Already Sent',
            //                                     text: response.data.message,
            //                                     icon: 'info',
            //                                     confirmButtonText: 'OK'
            //                                 });
            //                             }
            //                         },
            //                         error: function() {
            //                             Swal.fire({
            //                                 title: 'Error',
            //                                 text: 'Unable to send request. Please try again.',
            //                                 icon: 'error',
            //                                 confirmButtonText: 'OK'
            //                             });
            //                         }
            //                     });
            //                 }
            //             });
            //         <?php //endif;
                        ?>
            //     });
            // });

            // jQuery(document).ready(function($) {
            //     $('.delete-record').on('click', function(event) {
            //         event.preventDefault();

            //         var deleteUrl = $(this).attr('href');

            //         // Check if the user is an admin
            //         <?php //if (current_user_can('administrator')):
                        ?>
            //             // Show direct delete confirmation for admin
            //             Swal.fire({
            //                 title: 'Are you sure?',
            //                 text: 'Do you really want to delete?',
            //                 icon: 'warning',
            //                 showCancelButton: true,
            //                 confirmButtonText: 'Yes, delete it!',
            //                 cancelButtonText: 'No, cancel!'
            //             }).then(function(result) {
            //                 if (result.isConfirmed) {
            //                     window.location.href = deleteUrl;
            //                 }
            //             });
            //         <?php //else:
                        ?>
            //             // For regular users, show request confirmation
            //             Swal.fire({
            //                 title: 'Request Deletion',
            //                 text: 'Do you want to request deletion from the admin?',
            //                 icon: 'info',
            //                 showCancelButton: true,
            //                 confirmButtonText: 'Yes, request it!',
            //                 cancelButtonText: 'No, cancel!'
            //             }).then(function(result) {
            //                 if (result.isConfirmed) {
            //                     // Send an AJAX request to save the deletion request
            //                     $.ajax({
            //                         url: '<?php // echo admin_url('admin-ajax.php');
                                                ?>',
            //                         type: 'POST',
            //                         data: {
            //                             action: 'request_delete',
            //                             company_name: '<?php //echo $title;
                                                            ?>'
            //                         },
            //                         success: function(response) {
            //                             if (response.success) {
            //                                 Swal.fire({
            //                                     title: 'Request Sent',
            //                                     text: 'Your deletion request has been sent to the admin.',
            //                                     icon: 'success',
            //                                     confirmButtonText: 'OK'
            //                                 });
            //                             } else {
            //                                 // If request already exists
            //                                 Swal.fire({
            //                                     title: 'Already Sent',
            //                                     text: response.data.message,
            //                                     icon: 'info',
            //                                     confirmButtonText: 'OK'
            //                                 });
            //                             }
            //                         },
            //                         error: function() {
            //                             Swal.fire({
            //                                 title: 'Error',
            //                                 text: 'Unable to send request. Please try again.',
            //                                 icon: 'error',
            //                                 confirmButtonText: 'OK'
            //                             });
            //                         }
            //                     });
            //                 }
            //             });
            //         <?php //endif;
                        ?>
            //     });
            // });
        </script>


        <!-- Example delete link -->



        <div class="process-main">
            <div class="structure-heading" style="text-align: center; margin: 34px 0;">
                <h2>All Structures </h2>
            </div>
            <ul class="mod-list">

                <?php
                $current_user_id = get_current_user_id();
                $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
                $args = array(
                    'post_type' => 'post',
                    'post_status' => 'publish',
                    'posts_per_page' => 6,
                    'orderby' => 'date',
                    // 'author' => $current_user_id,
                    'order' => 'DESC',  // Changed to DESC for new posts first
                    // 'category_name' => 'node',
                    'paged' => $paged,
                );
                if (!current_user_can('administrator')) {
                    $args['author'] = $current_user_id;
                }

                $node_posts = new WP_Query($args);
                if ($node_posts->have_posts()) {
                    while ($node_posts->have_posts()) {
                        $node_posts->the_post();
                        $title = get_the_title();
                        $link = get_permalink();
                        $author_name = get_the_author(); // Get the author's name
                        $author_id = get_the_author_meta('ID'); // Get the author's ID
                ?>
                        <li><span><?php echo $title; ?></span>
                            <div class="mod-list-btns">
                                <?php if (current_user_can('administrator') && $current_user_id == 1): ?>
                                    <a class="blue-btn-hv" style="color:white;" type="button"><?php echo esc_html($author_name); ?></a>
                                <?php endif; ?>
                                <!-- <a class="blue-btn-hv" style="color:white;" type="button"><?php echo esc_html($author_name); ?></a> -->
                                <a href="<?php echo $link; ?>">View</a>
                                <a href="?action=delete&company_name=<?php echo urlencode($title); ?>" class="dlt-btn delete-record" data-company-name="<?php echo esc_attr($title); ?>">
                                    <i class="ri-delete-bin-7-line"></i>

                                </a>


                            </div>
                        </li>
                <?php
                    }
                    wp_reset_postdata();
                } else {
                    echo '<li>No posts found.</li>';
                }
                ?>
                <li><span> Here is Domino's complete process</span>
                    <div class="mod-list-btns"><a href="<?php echo home_url('/result/'); ?>">View </a> <a class="dlt-btn"><i class="ri-delete-bin-7-line"></i></a></div>
                </li>
            </ul>
        </div>

        <!-- Pagination -->
        <div class="pagination_one">
            <?php
            echo paginate_links(array(
                'total' => $node_posts->max_num_pages,
                'current' => $paged,
                'format' => '?paged=%#%',
                'prev_text' => __('<< Prev'),
                'next_text' => __('Next >>'),
            ));
            ?>
        </div>
    </div>
</div>
<style>
    .pagination_one {
        justify-content: center;
        align-items: center;
        gap: 10px;
        margin-top: 25px;
    }


    /* .pagination_one .page-numbers.current {
        color: var(--theme1);
        border: 2px solid;
        border-radius: 50%;
        padding: 5px;
    } */
    .pagination_one .page-numbers.current {
        background-color: var(--theme1);
        color: #fff;
        border: 2px solid transparent;
        border-radius: 5px;
        padding: 5px;
        width: 30px;
        text-align: center;
        height: 32px;
    }

    .pagination_one a.next,
    .pagination_one a.prev {
        color: var(--theme1);
    }
</style>