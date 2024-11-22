<div class="tab-pane fade" id="dlt-str-tab-pane" role="tabpanel" aria-labelledby="dlt-str-tab" tabindex="0">
    <div class="user-details-main">
        <h1>Request for Delete Structure</h1>

        <?php if (current_user_can('administrator')): ?>
            <table class="user-details-table">
                <thead>
                    <tr>
                        <th>User Name</th>
                        <th>Industry Name</th>
                        <th>Request Date</th>
                        <th class="us_action">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Query for users who have any deletion request
                    $args = array(
                        'meta_key'     => '_deletion_request', // Ensures users with any deletion request are fetched
                        'meta_compare' => 'EXISTS'
                    );
                    $users_with_requests = get_users($args);
                    if ($users_with_requests) {
                        foreach ($users_with_requests as $user) {
                            // Get all deletion requests from user meta
                            $user_requests = get_user_meta($user->ID, '_deletion_request', true);

                            // Check if user has deletion requests
                            if ($user_requests && is_array($user_requests)) {
                                foreach ($user_requests as $request) {
                                    // Extract request details
                                    $user_name = $user->display_name;
                                    $company_name = esc_html($request['company_name']);
                                    $request_date = esc_html($request['request_date']);
                                    $post_id = esc_html($request['post_id']); // Assuming the post ID is part of the request data
                    ?>

                                    <tr>
                                        <td><?php echo $user_name; ?></td>
                                        <td><?php echo $company_name; ?></td>
                                        <td><?php echo $request_date; ?></td>
                                        <td class="us_action_btn">
                                            <!-- <a href="?action=delete&user_id=<?php // echo $user->ID; ?>&post_id=<?php //echo $post_id; ?>&company_name=<?php //echo urlencode($company_name); ?>" class="btn">Delete</a> -->
                                            <!-- <a href="?action=reject&user_id=<?php //echo $user->ID; ?>&post_id=<?php //echo $post_id; ?>&company_name=<?php //echo urlencode($company_name); ?>" class="btn">Reject</a> -->
                                            <button data-post-id=<?php echo $post_id; ?> data-company-name=<?php echo urlencode($company_name); ?> id="dlt-str">Delete</button>
                                                <button data-post-id=<?php echo $post_id; ?> data-company-name=<?php echo urlencode($company_name); ?>  id="rjt-str">Reject</button>

                                        </td>
                                    </tr>
                    <?php
                                }
                            }
                        }
                    } else {
                        echo '<tr><td colspan="4">No deletion requests found.</td></tr>';
                    }
                    ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>You do not have permission to view this page.</p>
        <?php endif; ?>
    </div>
</div>

<script>
    jQuery(document).ready(function($) {
        // Combined handler for delete and reject actions
        $('body').on('click', '#dlt-str, #rjt-str', function(e) {
            e.preventDefault(); // Prevent default button behavior

            var postId = $(this).data('post-id'); // Get the post ID
            var companyName = $(this).data('company-name'); // Get the company name
            var action = $(this).attr('id') === 'dlt-str' ? 'delete' : 'reject'; // Determine action based on button ID
            var requestRow = $(this).closest('tr'); // Get the request row to modify later if needed

            // SweetAlert2 confirmation dialog
            Swal.fire({
                title: 'Are you sure?',
                text: action === 'delete' ?
                    'You are about to delete the request for ' + companyName :
                    'You are about to reject the request for ' + companyName,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, ' + action + ' it!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Send AJAX request based on the action
                    $.ajax({
                        url: '<?php echo admin_url("admin-ajax.php"); ?>', // Use WordPress's localized AJAX URL
                        method: 'POST',
                        data: {
                            // action: action === 'delete' ? 'admin_delete_request' : 'admin_reject_request', // Action hook
                            action: 'admin_handle_request_action',
                            post_id: postId,
                            company_name: companyName,
                            request_action: action
                        },
                        success: function(response) {
                            if (response.success) {
                                Swal.fire({
                                    title: action.charAt(0).toUpperCase() + action.slice(1) + 'd!',
                                    text: 'The request has been ' + action + 'ed.',
                                    icon: 'success'
                                }).then(() => {
                                    // Optionally fade out the row and reload
                                    // requestRow.fadeOut('slow', function() {
                                    //     $(this).remove();

                                        var activeTabId = $('.tab-pane.active').attr('id');
                                        localStorage.setItem('activeTabId', activeTabId);

                                        location.reload(); // Reload the page to update the table
                                    // });
                                });
                            } else {
                                Swal.fire('Error', response.data, 'error');
                            }
                        },
                        error: function() {
                            Swal.fire('Error', 'An error occurred. Please try again later.', 'error');
                        }
                    });
                }
            });
        });
    });
</script>