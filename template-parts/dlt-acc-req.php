<div class="tab-pane fade" id="dlt-acc-tab-pane" role="tabpanel" aria-labelledby="dlt-acc-tab" tabindex="0">
     <div class="user-details-main">
          <h1>Request for Delete Account</h1>
          <?php if (current_user_can('administrator')): ?>
               <table class="user-details-table">
                    <thead>
                         <tr>
                              <th>User ID</th>
                              <th>User Name</th>
                              <th>User Role</th>
                              <th class="us_action">Actions</th>
                         </tr>
                    </thead>
                    <tbody>
                         <?php
                         // Query for users who have account deletion requests
                         $users = get_users(array(
                             'meta_key'   => 'account_deletion_request',
                             'meta_value' => '' // We want only those users who have made a deletion request
                         ));

                         // Loop through each user with a deletion request
                         foreach ($users as $user):
                             $user_id = $user->ID;
                             $user_name = $user->user_login;
                             $user_role = implode(', ', $user->roles); // To handle multiple roles
                             $deletion_request = get_user_meta($user_id, 'account_deletion_request', true);
                             ?>
                             <tr>
                                  <td><?php echo $user_id; ?></td>
                                  <td><?php echo $user_name; ?></td>
                                  <td><?php echo $user_role; ?></td>
                                  <td class="us_action_btn">
                                       <button id="dlt-acc" data-user-id="<?php echo $user_id; ?>">Delete</button>
                                       <button id="rjt-acc" data-user-id="<?php echo $user_id; ?>">Reject</button>
                                  </td>
                             </tr>
                         <?php endforeach; ?>
                    </tbody>
               </table>
          <?php else: ?>
               <p>You do not have permission to view this page.</p>
          <?php endif; ?>


     </div>

</div>

<script>
     jQuery(document).ready(function ($) {
    // Handle both deletion and rejection
    $(document).on('click', '#dlt-acc, #rjt-acc', function () {
        var userId = $(this).data('user-id');
        var actionType = $(this).attr('id') === 'dlt-acc' ? 'delete' : 'reject';
        var confirmText = actionType === 'delete' ? 'Are you sure you want to delete this account?' : 'Reject the deletion request?';
        var successText = actionType === 'delete' ? 'Account deleted!' : 'Request rejected!';

        Swal.fire({
            title: confirmText,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, proceed!',
            cancelButtonText: 'Cancel',
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: my_ajax_object.ajax_url,
                    method: 'POST',
                    data: {
                        action: 'handle_user_account_request', // Combined action
                        user_id: userId,
                        action_type: actionType, // Pass the action type
                    },
                    success: function (response) {
                        if (response.success) {
                            Swal.fire(successText, response.data.message, 'success');
                            // Remove the user row from the table
                            $(`#${actionType === 'delete' ? 'dlt-acc' : 'rjt-acc'}[data-user-id="${userId}"]`)
                                .closest('tr')
                                .remove();
                        } else {
                            Swal.fire('Error!', response.data.message, 'error');
                        }
                    },
                });
            }
        });
    });
});

</script>