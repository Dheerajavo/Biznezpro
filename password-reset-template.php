<?php
/* Template Name: Custom Password Reset */

get_header();
?>

<?php
// Always display the form to admins
if (current_user_can('administrator')) {
?>
    <div class="main-content-area">
        <div class="sign_in reset_pass">
            <div class="contact-form">
                <?php get_template_part('template-parts/common-top-logo'); ?>
                <form method="post">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="password">New Password</label>
                                <input type="password" id="password" name="password" class="input-control">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <button type="submit" class="sign-btn reset_btn">
                                    <i class="ri-account-circle-line"></i>
                                    Reset Password
                                </button>
                            </div>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
    </main>
    <?php
} else {

    if (isset($_GET['key']) && isset($_GET['login'])) {
        $reset_key = sanitize_text_field($_GET['key']);
        $login = sanitize_text_field($_GET['login']);

        // Validate the reset key
        $user = check_password_reset_key($reset_key, $login);

        if (is_wp_error($user)) {
            echo '<p>Invalid password reset link.</p>';
        } else {
            if (isset($_POST['password'])) {
                $password = $_POST['password'];
                reset_password($user, $password);
                // echo '<p>Password has been reset. You can now <a href="' . wp_login_url() . '">login</a>.</p>';
                // Redirect to custom page after successful reset
                // wp_redirect(home_url('/sign-in/'));
    ?>
                <script>
                    jQuery(document).ready(function($) {
                        Swal.fire({
                            title: 'Success!',
                            text: 'Your password has been reset successfully.',
                            icon: 'success',
                            confirmButtonText: 'OK',
                            timer: 2000 // Show the alert for 3 seconds
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = '<?php echo home_url('/sign-in/'); ?>';
                            }
                        });
                    });
                </script>
                <!-- exit; -->
            <?php  } else {
            ?>
                <div class="main-content-area">
                    <div class="sign_in reset_pass">
                        <div class="contact-form">
                            <?php get_template_part('template-parts/common-top-logo'); ?>
                            <form method="post">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="password">New Password</label>
                                            <input type="password" id="password" name="password" class="input-control">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <button type="submit" class="sign-btn reset_btn">
                                                <i class="ri-account-circle-line"></i>
                                                Reset Password
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                </main>

        <?php
            }
        }
    } else { ?>
        <div class="main-content-area">
            <div class="sign_in reset_msg">
                <div class="contact-form">
                    <p>Invalid request.</p>
                </div>
            </div>
        </div>
        </main>
<?php
    }
}
get_footer();
?>