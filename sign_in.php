<?php /* Template Name: Sign In */ ?>
<?php get_header(); ?>

<?php


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = sanitize_email($_POST['email']);
    $password = $_POST['password'];
    $remember = isset($_POST['remember']) ? true : false;

    $user = wp_authenticate($email, $password);

    if (is_wp_error($user)) {
        // Determine the specific error message
        switch ($user->get_error_code()) {
            case 'empty_username':
                $error = 'Please enter your email address.';
                break;
            case 'empty_password':
                $error = 'Please enter your password.';
                break;
            case 'invalid_email':
                $error = 'The email address is not valid.';
                break;
            case 'invalid_username':
            case 'incorrect_password':
                $error = 'The email address or password is incorrect.';
                break;
            default:
                $error = 'An unexpected error occurred. Please try again.';
                break;
        }
    } else {
        wp_set_current_user($user->ID);
        wp_set_auth_cookie($user->ID, $remember);
        // Redirect to the same page with a success query parameter
        wp_redirect(add_query_arg('login', 'success', $_SERVER['REQUEST_URI']));
        exit;
    }
}
?>


<!-- main content area start -->
<div class="main-content-area">
    <div class="sign_in">
        <div class="contact-form">
            <?php get_template_part('template-parts/common-top-logo'); ?>
            <form action="<?php echo esc_url($_SERVER['REQUEST_URI']); ?>" method="post">

                <?php if (isset($_GET['login']) && $_GET['login'] == 'success') : ?>
                    <script>
                        jQuery(document).ready(function($) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Success!',
                                text: 'You have been successfully logged in.',
                                timer: 1000, // 3 seconds
                                // timerProgressBar: true,
                                // showCloseButton: true,
                                showConfirmButton: true,
                                // confirmButtonText: 'OK',
                                didOpen: () => {
                                    setTimeout(() => {
                                        window.location.href = '<?php echo home_url(); ?>';
                                    }, 1000);
                                },
                                preConfirm: () => {
                                    // Redirect immediately when "OK" is clicked
                                    window.location.href = '<?php echo home_url(); ?>';
                                },
                                willClose: () => {
                                    // Redirect after timeout if not clicked
                                    window.location.href = '<?php echo home_url(); ?>';
                                }
                            });
                        });
                    </script>
                <?php endif; ?>
                <?php if (isset($error) && $error) : ?>
                    <script>
                        jQuery(document).ready(function($) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: '<?php echo esc_js(strip_tags($error)); ?>'
                            });
                        });
                    </script>
                <?php endif; ?>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="text" id="email" name="email" placeholder="Type Here..." class="input-control" value="<?php echo isset($_POST['email']) ? esc_attr($_POST['email']) : ''; ?>">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="password">Password</label>
                            <div class="password-wrapper">
                                <input type="password" id="password" name="password" placeholder="Type Here..." class="input-control">
                                <span toggle="#rpassword" class="toggle-password"><i class="ri-eye-line"></i></span>
                            </div>
                        </div>
                    </div>
                    <!-- <div class="col-md-12">
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" id="password" name="password" placeholder="Type Here..." class="input-control">
                        </div>
                    </div> -->
                    <div class="col-md-12">
                        <div class="form-group forget-pwd">
                            <div class="checkbox txt-hv">
                                <input type="checkbox" id="remember" name="remember">
                                <label for="remember">Remember me</label>
                            </div>
                            <div class="forget-paassword">
                                <button type="button" class="forget-paassword-btn txt-hv" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                    Forgot Password?
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <button type="submit" class="sign-btn" id="sign-in-form">
                                <i class="ri-account-circle-line"></i>
                                Sign In
                            </button>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <p>Don't have an account?<a class="txt-hv" href="<?php echo home_url('/sign-up/') ?>">Sign Up</a></p>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
</main>

<div class="modal fade forget-password-modal" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                <h4 class="forget_text">Forgot your Password?</h4>
                <form id="password-reset-form" method="post">
                    <div class="form-group">
                        <label for="reset-email">Email</label>
                        <input type="text" id="reset-email" placeholder="Type Here..." class="input-control">
                    </div>
                    <div class="form-group">
                        <button type="submit" class="primary-btn">Request Password Reset</button>
                    </div>
                    <div id="reset-message" class="form-group"></div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    jQuery(document).ready(function($) {
        jQuery('#password-reset-form').on('submit', function(event) {
            event.preventDefault(); // Prevent the default form submission
            var email = $('#reset-email').val();
            $.ajax({
                url: '<?php echo admin_url('admin-ajax.php') ?>',
                type: 'POST',
                data: {
                    action: 'request_password_reset',
                    email: email
                },
                success: function(response) {
                    if (response.success) {
                        Swal.fire({
                            title: "Success",
                            text: response.data.message,
                            icon: "success",
                            button: "OK",
                        });
                    } else {
                        Swal.fire({
                            title: "Error!",
                            text: response.data.message,
                            icon: "error",
                            button: "OK",
                        });
                    }
                },
                error: function() {
                    Swal.fire({
                        title: "Error!",
                        text: "An error occurred. Please try again.",
                        icon: "error",
                        button: "OK",
                    });
                }
            });
        });
    });
</script>

<?php get_footer(); ?>