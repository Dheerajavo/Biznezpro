<?php /* Template Name: Homepage */ ?>
<?php get_header(); ?>
<style>
    /* form.searchForm {
        width: 100%;
    } */
</style>
<style>
    /* .suggestions-container {

        background: #fff;
        border: 1px solid #ddd;
        max-height: 200px;
        overflow-y: auto;
        z-index: 1000;
        width: 100%;
        display: none;
    }

    .suggestion-item {
        padding: 8px 12px;
        cursor: pointer;
    }

    .suggestion-item:hover {
        background-color: #f0f0f0;
    } */
</style>

<!-- main content area start -->
<div class="main-content-area">
    <div class="home-page">
        <div class="hero-banner">
            <?php get_template_part('template-parts/common-top-logo'); ?>
            <h1>Connecting the Global Economy</h1>
            <p>Interactive Infographic Digital Intelligence</p>
            <form id="searchForm" class="searchForm" action="<?php echo esc_url(home_url('/')); ?>" method="get">
                <div class="search-bar">
                    <input type="text" id="searchInput" name="s" class="input-control" placeholder="Search posts here" autocomplete="off">
                    <input type="hidden" name="post_type" value="post">
                    <button type="submit" class="primary-btn">Go</button>
                    <div id="suggestions" class="suggestions-container"></div>
                </div>
            </form>


        </div>
    </div>
</div>
</main>


<script>

    jQuery(document).ready(function($) {
    var selectedPostUrl = '';

    // Fetch suggestions as the user types
    $('#searchInput').on('input', function() {
        var searchQuery = $(this).val().trim();

        if (searchQuery.length === 0) {
            $('#suggestions').empty().hide();
            selectedPostUrl = '';
            return;
        }

        $.ajax({
            url: my_ajax_object.ajax_url,
            // url: '<?php //echo admin_url("admin-ajax.php"); ?>',
            type: 'POST',
            data: {
                action: 'handle_post_search',
                mode: 'suggestions',
                query: searchQuery
            },
            success: function(response) {
                if (response.success && response.data.suggestions.length > 0) {
                    var suggestionsHtml = '';
                    response.data.suggestions.forEach(function(post) {
                        suggestionsHtml += '<div class="suggestion-item" data-url="' + post.url + '">' + post.title + '</div>';
                    });
                    $('#suggestions').html(suggestionsHtml).show();
                } else {
                    $('#suggestions').empty().hide();
                }
            },
            error: function() {
                $('#suggestions').empty().hide();
            }
        });
    });

    // Handle click on suggestion item
    $(document).on('click', '.suggestion-item', function() {
        var postTitle = $(this).text();
        selectedPostUrl = $(this).data('url');
        $('#searchInput').val(postTitle);
        $('#suggestions').empty().hide();
    });

    // Handle form submission
    $('#searchForm').on('submit', function(event) {
        event.preventDefault();

        var searchQuery = $('#searchInput').val().trim();

        if (selectedPostUrl) {
            // Redirect to the selected post URL
            window.location.href = selectedPostUrl;
        } else if (searchQuery.length === 0) {
            Swal.fire({
                title: 'Error',
                text: 'Please enter a search item.',
                icon: 'error'
            });
            return;
        } else {
            // If no suggestion was clicked, check if the entered title matches a post
            $.ajax({
                url: my_ajax_object.ajax_url,
                // url: '<?php // echo admin_url("admin-ajax.php"); ?>',
                type: 'POST',
                data: {
                    action: 'handle_post_search',
                    mode: 'check_title',
                    query: searchQuery
                },
                success: function(response) {
                    if (response.success && response.data.post_url) {
                        window.location.href = response.data.post_url;
                    } else {
                        Swal.fire({
                            title: 'No Data Found',
                            text: 'No matching post found.',
                            icon: 'info'
                        });
                    }
                },
                error: function() {
                    Swal.fire({
                        title: 'Error',
                        text: 'There was an error processing your request.',
                        icon: 'error'
                    });
                }
            });
        }
    });

    // Hide suggestions when clicking outside
    $(document).on('click', function(event) {
        if (!$(event.target).closest('#searchInput, #suggestions').length) {
            $('#suggestions').empty().hide();
        }
    });
});

</script>

<?php get_footer(); ?>