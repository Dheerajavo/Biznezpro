<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta2/dist/js/bootstrap-select.min.js"></script>
<script>
    //     jQuery(document).ready(function($) {
    //     // Wait until the DOM is fully loaded to avoid any race conditions with Bootstrap tab functionality

    //     // Function to activate the saved tab or default tab
    //     function activateTab() {
    //         var activeTabId = localStorage.getItem('activeTabId');

    //         // If an active tab ID is saved in localStorage, activate that tab
    //         if (activeTabId) {
    //             $('.tab-pane').removeClass('active show');
    //             $('.nav-link').removeClass('active');

    //             // Activate the saved tab pane and tab link
    //             $(activeTabId).addClass('active show');
    //             $('button[data-bs-target="' + activeTabId + '"]').addClass('active');
    //         } else {
    //             // If no active tab is saved, show the default tab
    //             $('.tab-pane:first').addClass('active show');
    //             $('.nav-link:first').addClass('active');
    //         }
    //     }

    //     // Activate the tab when the page loads
    //     activateTab();

    //     // When a tab is clicked, save its ID to localStorage
    //     $('button[data-bs-toggle="tab"]').on('shown.bs.tab', function(e) {
    //         var activeTabId = $(e.target).attr('data-bs-target');
    //         localStorage.setItem('activeTabId', activeTabId);
    //     });
    // });

    jQuery(document).ready(function($) {
        // Restore the active tab and corresponding button on page load
        var activeTabId = localStorage.getItem('activeTabId');
        if (activeTabId) {
            // Show the saved tab and hide others
            $('.tab-pane').removeClass('show active');
            $('#' + activeTabId).addClass('show active');

            // Activate the corresponding tab button (nav-link)
            $('.nav-link').removeClass('active');
            $('button[data-bs-target="#' + activeTabId + '"]').addClass('active');

            // Clear the stored tab ID after restoring
            localStorage.removeItem('activeTabId');
        }
    });
</script>

<?php wp_footer(); ?>
</body>

</html>