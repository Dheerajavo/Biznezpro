<div class="tab-pane fade" id="user-req-tab-pane" role="tabpanel" aria-labelledby="user-req-tab" tabindex="0">
     <!-- //test -->
     <?php echo do_shortcode('[user_requests]'); ?>
</div>
<script>
jQuery(document).ready(function($) {
    $('.accept-btn, .reject-btn').on('click', function() {
        var userId = $(this).data('user-id');
        var action = $(this).hasClass('accept-btn') ? 'accept' : 'reject';
        // console.log(my_ajax_object.ajax_url);
        $.ajax({
            url: my_ajax_object.ajax_url,
            type: 'POST',
            data: {
                action: 'handle_admin_editor_request',
                user_id: userId,
                request_action: action
            },
                   success: function(response) {
               var title = action === 'accept' ? 'Accepted Successfully' : 'Rejected Successfully';

                if (response.success) {
                    Swal.fire({
                        icon: 'success',
                        title: title,
                        text: response.message,
                        timer: 2000,
                        showConfirmButton: false
                    }).then(function() {
                        location.reload();
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: response.message
                    });
                }
            },
            error: function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'An unexpected error occurred. Please try again.'
                });
            }
        });
    });
});
</script>