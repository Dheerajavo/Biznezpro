<!DOCTYPE html>
<html lang="<?php language_attributes(); ?>">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/fav-icon.png" type="image/x-icon">
    <link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri(); ?>/assets/css/bootstrap.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boo/tstrap-select@1.14.0-beta2/dist/css/bootstrap-select.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.3.0/fonts/remixicon.css" rel="stylesheet" />
    <link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri(); ?>/assets/css/style.css?<?php echo time(); ?>">
    <link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri(); ?>/assets/css/additional.css?<?php echo time(); ?>">
    <link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri(); ?>/assets/css/custom.css?<?php echo time(); ?>">
    <link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri(); ?>/assets/css/responsive.css?<?php echo time(); ?>">
    <?php if (is_page(['node', 'test', 'node-check', 'node-update'])): ?>
        <link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri(); ?>/node-functionality/node-css.css?<?php echo time(); ?>">
    <?php endif; ?>
    <!-- , 'node-child' -->


    <title><?php echo get_the_title(); ?></title>
    <?php wp_head() ?>
</head>

<body <?php body_class('header'); ?>>
    <?php wp_body_open(); ?>
    <main class="dash-wrapper">
        <aside class="page-sidebar">

            <div class="site-logo">
                <span class="menu-toggle">
                    <i class="ri-menu-2-fill"></i>
                </span>
                <a href="<?php echo site_url('/'); ?>">
                    <div class="logo-holder">
                        <img src="<?php echo esc_url(wp_get_attachment_url(get_theme_mod('custom_logo'))); ?>" alt="site-logo">
                    </div>
                    <p class="beta-version">Beta Version</p>
                </a>
            </div>
            <div class="dash-menu">
                <?php
                wp_nav_menu(array(
                    'menu' => 'Header Top',
                    // 'theme_location' => 'primary',
                    'container'            => "false",
                    'walker' => new Custom_Walker_Nav_Menu()
                ));
                ?>
                <div class="sign_out">
                    <?php
                    wp_nav_menu(array(
                        'menu' => 'Header Middle',
                        'container'            => "div",
                        'walker' => new Custom_Walker_Nav_Menu()
                    ));
                    ?>
                    <?php if (is_user_logged_in()) { ?>
                        <div class="sign-out-details">
                            <a href="<?php echo home_url('/account/') ?>" class="dash-nav ">
                                <?php $user_id = get_current_user_id();
                                $profile_pic_url = get_user_meta($user_id, 'profile_picture', true);
                                $image_url = !empty($profile_pic_url) ? $profile_pic_url : '';
                                ?>
                                <div class="svg-ico">
                                    <!-- <i class="ri-account-circle-line"></i> -->
                                    <?php if (!empty($image_url)) : ?>
                                        <img src="<?php echo esc_url($image_url); ?>" alt="profile-pic" id="profile-pic">
                                    <?php else : ?>
                                        <i class="ri-account-circle-line"></i>
                                    <?php endif; ?>
                                </div>


                                <div class="profile-details">
                                    <span>
                                        <?php
                                        $current_user = wp_get_current_user();
                                        $current_user_id = $current_user->ID;
                                        if ($current_user->exists()) {
                                            $fullname = get_user_meta($current_user_id, 'fullname', true);
                                            $first_name = get_user_meta($current_user_id, 'first_name', true);
                                            $display_name = !empty($fullname) ? $fullname : $first_name;
                                            echo $display_name;
                                        }
                                        ?>
                                    </span>
                                    <p>
                                        <?php $user_roles = $current_user->roles;
                                        if (!empty($user_roles)) {
                                            $primary_role = $user_roles[0];
                                            echo  $primary_role;
                                        } ?>
                                    </p>
                                    <!-- <p>Manage Profile</p> -->
                                </div>
                            </a>
                            <a href="<?php echo wp_logout_url(home_url('/sign-in/')) ?>" class="sign_out-icon">
                                <i class="ri-logout-circle-line"></i>
                            </a>
                        </div>
                    <?php } ?>
                </div>
                <div class="doc-pages">
                    <?php
                    wp_nav_menu(array(
                        'menu' => 'Header Bottom',
                        'container'            => "false",
                        'walker' => new Custom_Walker_Nav_Menu()
                    ));
                    ?>
                </div>


                <div class="copyright">
                    <p>Copyright © Biznezpro 2024,
                        All Rights Reserved</p>
                </div>
            </div>
        </aside>