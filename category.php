<?php get_header(); ?>

<div class="category-posts">
    <header class="category-header">
        <h1 class="category-title"><?php single_cat_title(); ?></h1>
        <div class="category-description">
            <?php echo category_description(); // Display category description if it exists ?>
        </div>
    </header>

    <?php if (have_posts()) : ?>
        <div class="posts-list">
            <?php while (have_posts()) : the_post(); ?>
                <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                    <header class="entry-header">
                        <h2 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                    </header>
                    <div class="entry-summary">
                        <?php the_excerpt(); // Display post excerpt ?>
                    </div>
                    <footer class="entry-footer">
                        <a href="<?php the_permalink(); ?>" class="read-more">Read More</a>
                    </footer>
                </article>
            <?php endwhile; ?>
        </div>

        <div class="pagination">
            <?php
            // Display pagination if there are more posts than can fit on one page
            the_posts_pagination(array(
                'prev_text' => __('Previous', 'textdomain'),
                'next_text' => __('Next', 'textdomain'),
            ));
            ?>
        </div>
    <?php else : ?>
        <p>No posts found in this category.</p>
    <?php endif; ?>
</div>


<?php get_footer(); ?>
