<?php /* Template Name:local-test*/ ?>
<?php get_header(); ?>

<div id="drop-area">
    <!-- Drop area where the HTML will be displayed -->
</div>

<button id="submit-child-node-test">Save Drop Area Content</button>

<script>
    jQuery(document).ready(function($) {
        // Retrieve the stored HTML from local storage on page load
        var savedContent = localStorage.getItem('dropAreaContent');

        if (savedContent) {
            // Insert the saved content into the drop area
            $('#drop-area').html(savedContent);
        }

        // Save the HTML to local storage when the button is clicked
        $('#submit-child-node-test').click(function() {
            var dropAreaHTML = $('#drop-area').html();
            localStorage.setItem('dropAreaContent', dropAreaHTML);
            alert("Drop area content has been saved to local storage!");
        });
    });
</script>

<?php get_footer(); ?>