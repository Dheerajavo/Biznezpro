// jQuery(document).ready(function ($) {

//     if ($("body").hasClass("page-template-node") || $("body").hasClass("page-template-node-child")) {
//         $(".page-sidebar").addClass("open");
//         $(".dash-wrapper").addClass("toggle");
//     }

//     $(".menu-toggle").click(function () {
//         $(".dash-wrapper").toggleClass("toggle");
//     });

//     $(".menu-toggle").click(function () {
//         $(".page-sidebar").toggleClass("open");
//     });

//     $(".company-name").click(function () {
//         $(this).next().slideToggle();
//     });

jQuery(document).ready(function ($) {
    // Initialize sidebar and wrapper if body has specific classes
    if ($("body").is(".page-template-node, .page-template-node-child, .page-template-node-update")) {
        $(".page-sidebar").addClass("open");
        $(".dash-wrapper").addClass("toggle");
    }

    // Function to adjust SVG icon size
    function adjustSvgSize() {
        const size = ($(".dash-wrapper").hasClass("toggle") && $(".page-sidebar").hasClass("open")) ? 25 : 40;
        $(".svg-ico img").css({
            height: size + "px",
            width: size + "px"
        });
    }

    // Initial SVG size adjustment
    adjustSvgSize();

    // Toggle sidebar and wrapper classes on menu toggle click
    $(".menu-toggle").click(function () {
        $(".dash-wrapper").toggleClass("toggle");
        $(".page-sidebar").toggleClass("open");

        // Recalculate SVG icon size after toggle
        adjustSvgSize();
    });

    // Toggle visibility of the next element after `.company-name` when clicked
    $(".company-name").click(function () {
        $(this).next().slideToggle();
    });



    var flag = 0
    var MenuToggle = document.querySelector(".menu-toggle")
    MenuToggle.addEventListener("click", function () {
        if (flag == 0) {
            MenuToggle.innerHTML = `<i class="ri-close-large-line"></i>`
            flag = 1
        }
        else {
            MenuToggle.innerHTML = `<i class="ri-menu-2-fill"></i>`
            flag = 0
        }
    });

    // eye on password
    $('.toggle-password').click(function () {
        // Select the previous input field relative to the clicked toggle icon
        var inputField = $(this).siblings('input');

        if (inputField.attr('type') === 'password') {
            inputField.attr('type', 'text');
            $(this).html('<i class="ri-eye-off-line"></i>'); // Change to 'eye-off' icon when showing
        } else {
            inputField.attr('type', 'password');
            $(this).html('<i class="ri-eye-line"></i>'); // Change back to 'eye' icon when hiding
        }
    });

    // Check if the body has any of the three classes
    //  if ($('body').hasClass('single-post') || $('body').hasClass('page-template-node-child-view') || $('body').hasClass('single-industries') || $('body').hasClass('page-template-node') || $('body').hasClass('page-template-node-child')) {
    if ($('body').is('.single-post, .page-template-node-child-view, .single-industries')) {
        $("aside.page-sidebar").hide();
        $("main.dash-wrapper").css("padding", "0px");
        // $(".main-content-area").css("padding-right", "20px");
    }


    // $(".close").on("click", function () {
    //     $(".modal.fade.show").modal("hide");
    // });
    $(".close").on("click", function () {
        $(this).closest('.modal').modal("hide");
    });


});

// jQuery(document).ready(function ($) {
//     $(".node-content-image img").each(function () {
//         // Check if the image's 'src' attribute is empty or undefined
//         if (!$(this).attr("src") || $(this).attr("src").trim() === "") {
//             // Hide the image to avoid showing a broken or empty placeholder
//             $(this).hide();
//         } else {
//             // Handle cases where the 'src' attribute points to a broken image
//             $(this).on("error", function () {
//                 $(this).hide(); // Hide the broken image
//             });
//         }
//     });
// });






