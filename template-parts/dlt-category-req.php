<div class="tab-pane fade" id="dlt-industry-tab-pane" role="tabpanel" aria-labelledby="dlt-industry-tab" tabindex="0">
     <div class="user-details-main">
          <h1>Request for Delete Categories</h1>

          <?php
          if (current_user_can('administrator')) {
               // Always display the table heading for admins
               echo '<table class="user-details-table">';
               echo '<thead><tr><th>Category Name</th><th>Request</th><th class="us_action">Actions</th></tr></thead><tbody>';

               // Fetch categories with pending delete requests for the industries post type
               $args = array(
                    'taxonomy' => 'category',
                    'meta_query' => array(
                         array(
                              'key' => 'delete_request_status',
                              'value' => 'pending',
                              'compare' => '='
                         )
                    ),
                    'hide_empty' => false
               );
               $categories = get_terms($args);  // Fetch categories based on the condition

               // If there are pending delete requests, display them
               if (!empty($categories)) {
                    foreach ($categories as $category) {
                         echo '<tr>';
                         echo '<td>' . esc_html($category->name) . '</td>';
                         echo '<td>Delete Request</td>';
                         echo '<td class="us_action_btn">';
                         echo '<button class="approve-request" data-id="' . esc_attr($category->term_id) . '">Accept</button>';
                         echo '<button class="reject-request" data-id="' . esc_attr($category->term_id) . '">Reject</button>';
                         echo '</td>';
                         echo '</tr>';
                    }
               } else {
                    // If no categories are pending, display a message
                    echo '<tr><td colspan="3">No pending delete requests.</td></tr>';
               }

               // Close the table body
               echo '</tbody></table>';
          } else {
               // Optionally, you can handle the case when the user is not an administrator
               echo 'You do not have permission to view this page.';
          }
          ?>
     </div>
     <!-- Include JavaScript for AJAX functionality -->
     <script>
          jQuery(document).ready(function($) {
               // Functionality for handling requests (approve/reject)
               $('.approve-request, .reject-request').on('click', function(e) {
                    e.preventDefault();
                    var categoryId = $(this).data('id');
                    var action = $(this).hasClass('approve-request') ? 'approve' : 'reject';

                    // Show SweetAlert confirmation
                    Swal.fire({
                         title: 'Are you sure?',
                         text: action === 'approve' ? 'You are about to approve this request.' : 'You are about to reject this request.',
                         icon: 'warning',
                         showCancelButton: true,
                         confirmButtonText: 'Yes, proceed!',
                         cancelButtonText: 'Cancel'
                    }).then((result) => {
                         if (result.isConfirmed) {
                              // Proceed with AJAX request if user confirms
                              $.ajax({
                                   url: '<?php echo admin_url('admin-ajax.php'); ?>',
                                   type: 'POST',
                                   data: {
                                        action: 'dlt_handle_request_action',
                                        category_id: categoryId,
                                        request_action: action,
                                   },
                                   success: function(response) {
                                        // Show success message on SweetAlert
                                        Swal.fire({
                                             title: 'Success!',
                                             text: action === 'approve' ? 'Request approved successfully!' : 'Request rejected successfully!',
                                             icon: 'success',
                                             confirmButtonText: 'OK'
                                        }).then(() => {
                                             // Save the current tab ID in localStorage before reloading
                                             var activeTabId = $('.tab-pane.active').attr('id');
                                             localStorage.setItem('activeTabId', activeTabId);
                                             location.reload(); // Reload the page to update the table
                                        });
                                   },
                                   error: function() {
                                        // Show error message if something goes wrong
                                        Swal.fire({
                                             title: 'Error!',
                                             text: 'There was an error processing your request. Please try again.',
                                             icon: 'error',
                                             confirmButtonText: 'OK'
                                        });
                                   }
                              });
                         }
                    });
               });
          });
     </script>

</div>