<?php
$categories_per_page = 5;
$paged_cat = (get_query_var('paged')) ? absint(get_query_var('paged')) : 1;
$offset = ($paged_cat - 1) * $categories_per_page;
$args = array(
    'taxonomy' => 'category',
    'orderby' => 'name',
    'order' => 'ASC',
    'number' => $categories_per_page,
    'offset' => $offset,
    'hide_empty' => false,
);

$term_query = new WP_Term_Query($args);
$categories = $term_query->terms;
$total_categories = wp_count_terms(array('taxonomy' => 'category'));
$total_pages_cat = ceil($total_categories / $categories_per_page);
?>

<div class="tab-pane fade" id="category-tab-pane" role="tabpanel" aria-labelledby="disabled-tab" tabindex="0">
    <div class="cont-head">
        <div class="add-btn blue-btn-hv" id="open-category-popup">Add New Industry</div>
    </div>

    <div id="category-popup" class="category-popup" style="display: none;">
        <div class="popup-content">
            <h3 id="popup-title">Add New Industry</h3>
            <form id="category-form">
                <label for="category-name">Industry Name</label>
                <input type="text" id="category-name" name="category_name" class="input-control" required>
                <!-- Hidden field to store category ID when editing -->
                <input type="hidden" id="category-id" name="category_id">
                <input type="submit" id="submit-button" value="Add Industry">
            </form>
            <button class="blue-btn-hv" id="close-popup">Close</button>
        </div>
    </div>

    <?php if (!empty($categories)) : ?>
        <ul>
            <?php foreach ($categories as $category) : ?>
                <li>
                    <?php echo esc_html($category->name); ?>
                    <a href="#" class="edit-category blue-btn-hv" data-id="<?php echo esc_attr($category->term_id); ?>" title="Edit">
                        <i class="fa fa-edit"></i>
                    </a>
                    <a href="#" class="delete-category blue-btn-hv" data-id="<?php echo esc_attr($category->term_id); ?>" title="Delete">
                        <i class="fa fa-trash"></i>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>

        <?php if ($total_pages_cat > 1) : ?>
            <nav class="pagination">
                <?php
                echo paginate_links(array(
                    'base'      => '%_%',
                    'format'    => 'page/%#%/',
                    'current'   => $paged_cat,
                    'total'     => $total_pages_cat,
                    'prev_text' => __('&laquo; Prev'),
                    'next_text' => __('Next &raquo;'),
                ));
                ?>
            </nav>
        <?php endif; ?>
    <?php else : ?>
        <p>No categories found.</p>
    <?php endif; ?>
</div>
<style>
    .pagination {
        justify-content: center;
        align-items: center;
        gap: 10px;
        margin-top: 25px;
    }

    .pagination .page-numbers.current {
        background-color: var(--theme1);
        color: #fff;
        border: 2px solid transparent;
        border-radius: 5px;
        padding: 5px;
        width: 30px;
        text-align: center;
        height: 32px;
    }

    .pagination a.next,
    .pagination a.prev {
        color: var(--theme1);
    }
</style>