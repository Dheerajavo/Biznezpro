<?php get_header(); ?>
<?php $tax = $wp_query->get_queried_object(); ?>
<p><?php echo $tax->name; ?></p>
<!-- main content area start -->
<div class="main-content-area">
    <div class="home-page">
        <div class="top-head">
            <div class="left-logo logo_result"><?php get_template_part('template-parts/common-top-logo'); ?></div>
            <div class="right-logo"><a href="#"><img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/mec-d.png"></a></div>
        </div>
        <div class="result-banner">
            <a href="/result-tree/"><img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/02.png" alt="img"></a>
        </div>

    </div>
</div>
</main>
<?php get_footer();?>
