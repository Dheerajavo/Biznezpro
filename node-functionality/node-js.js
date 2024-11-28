// jQuery(document).ready(function($) {
//     // Initially show the company-logo div and hide the company-logo-img div
//     $('#logo-container').css('display', 'block');
//     $('#company-logo-img').css('display', 'none');

//     // Show the #company-name-text and hide the #company-name-display
//     $('#company-name-text').css('display', 'block');
//     $('#company-name-display').css('display', 'none');

//     $('#company-logo').on('change', function(event) {
//         var file = event.target.files[0];
//         if (file) {
//             var reader = new FileReader();
//             reader.onload = function(e) {
//                 $('#company-logo-img img').attr('src', e.target.result);
//                 $('#company-logo-img img').attr('alt', 'Company Logo');
//                 $('#logo-container').css('display', 'none');
//                 $('#company-logo-img').css('display', 'block');
//             };
//             reader.readAsDataURL(file);
//         }
//     });

//     $('#close-company-logo').on('click', function() {
//         $('#company-logo-img').css('display', 'none');
//         $('#logo-container').css('display', 'block');
//         $('#company-logo').val('');
//     });

//     function displayCompanyName() {
//         var companyName = $('#company-name').val();
//         if (companyName.trim() !== "") {
//             $('#company-name-display p').text(companyName);
//             $('#company-name-display').css('display', 'block');
//             $('#company-name-text').css('display', 'none');
//         }
//     }

//     $('#company-name').on('keydown', function(event) {
//         if (event.key === 'Enter') {
//             event.preventDefault();
//             displayCompanyName();
//             $(this).blur();
//         }
//     });

//     $('#company-name').on('blur', function() {
//         displayCompanyName();
//     });

//     $('#close-company-name').on('click', function() {
//         $('#company-name-display').css('display', 'none');
//         $('#company-name-text').css('display', 'block');
//     });

//     // Add node button
//     $('#add-node-btn').on('click', function() {
//         $('#shapes-dropdown').slideToggle();
//         $('#textAreabox').hide(); // Close other dropdowns
//     });

//     // Open text area dropdown
//     $('#openTextAreaBtn').on('click', function() {
//         $('#textAreabox').slideToggle();
//         $('#shapes-dropdown').hide(); // Close other dropdowns
//     });

//     // Filters dropdown
//     $('#dropdownMenuButton1').click(function() {
//         $('#company-options .dropdown-menu').slideToggle();
//         $('#shapes-dropdown, #textAreabox').hide(); // Close other dropdowns
//     });

//     $('#company-options .dropdown-item').on('click', function() {
//         var selectedOption = $(this).data('value');
//         $('#company-options .dropdown-item').removeClass('selected');
//         $(this).addClass('selected');
//         $('#company-options .dropdown-toggle').text($(this).text());
//         $('#company-options .dropdown-menu').hide();
//     });

//     $(document).on('click', function(e) {
//         if (!$(e.target).closest('#company-options').length) {
//             $('#company-options .dropdown-menu').hide();
//         }
//         if (!$(e.target).closest('#add-node-btn').length) {
//             $('#shapes-dropdown').hide();
//         }
//         if (!$(e.target).closest('#openTextAreaBtn').length) {
//             $('#textAreabox').hide();
//         }
//     });
// });

jQuery(document).ready(function ($) {
    // Click event on specific buttons to toggle nested <ul>
    // $('#add-node-btn, #openTextAreaBtn').click(function(event) {
    //     event.stopPropagation();

    //     // Toggle the visibility of the next <ul> element (the dropdown)
    //     $(this).siblings('ul').toggle();

    //     // Hide all other nested <ul> elements within the main menu
    //     $('ul.nav-mesnu-scroll ul').not($(this).siblings('ul')).hide();
    // });

    // // Close all open nested <ul> elements when clicking outside of the menu
    // $(document).click(function(event) {
    //     if (!$(event.target).closest('ul.nav-mesnu-scroll').length) {
    //         $('ul.nav-mesnu-scroll ul').hide();
    //     }
    // });
});


jQuery(document).ready(function ($) {
    // li Button Hide show
    // Initially show the company-logo div and hide the company-logo-img div
    $('#logo-container').css('display', 'block');
    $('#company-logo-img').css('display', 'none');

    // Show the #company-name-text and hide the #company-name-display
    $('#company-name-text').css('display', 'block');
    $('#company-name-display').css('display', 'none');

    $('#company-logo').on('change', function (event) {
        var file = event.target.files[0];
        if (file) {
            var reader = new FileReader();
            reader.onload = function (e) {
                // Set the src attribute of the img tag inside #company-logo-img
                $('#company-logo-img img').attr('src', e.target.result);
                $('#company-logo-img img').attr('alt', 'Company Logo'); // Optional: Set an alt text

                // Hide the company-logo div and show the company-logo-img div
                $('#logo-container').css('display', 'none');
                $('#company-logo-img').css('display', 'block');
            };
            reader.readAsDataURL(file);
        }
    });

    // Handle the close button click event for the company logo
    $('#close-company-logo').on('click', function () {
        // $('#company-logo-img').hide(); // Hide the company logo image div
        // $('#logo-container').show(); // Show the company logo input div
        $('#company-logo-img').css('display', 'none');
        $('#logo-container').css('display', 'block');
        $('#company-logo').val(''); // Clear the file input value
    });

    // Function to handle displaying the company name
    function displayCompanyName() {
        var companyName = $('#company-name').val(); // Get the value of the input
        if (companyName.trim() !== "") { // Check if the input is not empty
            // Display the company name in the designated area
            $('#company-name-display p').text(companyName);
            // $('#company-name-display').show();
            // $('#company-name-text').hide();
            $('#company-name-display').css('display', 'block');
            $('#company-name-text').css('display', 'none');
        }
    }

    // Handle the Enter key event in the company-name input
    $('#company-name').on('keydown', function (event) {
        if (event.key === 'Enter') {
            event.preventDefault(); // Prevent the default form submission behavior
            displayCompanyName(); // Call the function to display the company name
            $(this).blur(); // Trigger the blur event to save the input
        }
    });

    // Handle the blur event on the company-name input
    $('#company-name').on('blur', function () {
        displayCompanyName(); // Call the function to display the company name
    });

    // Handle the close button click event for the company name
    $('#close-company-name').on('click', function () {
        $('#company-name-display').css('display', 'none'); // Hide the company name display div
        $('#company-name-text').css('display', 'block');
    });

    // Add node button
    $('#add-node-btn').on('click', function () {
        $('#shapes-dropdown').slideToggle(); // Toggle the dropdown with a slide effect
    });
    // Dropdown in top
    $('#openTextAreaBtn').on('click', function () {
        // $('#textAreaContainer').show();
        $('#textAreabox').slideToggle();
    });

    // ----filters start----
    $('#dropdownMenuButton1').click(function () {
        $('#company-options .dropdown-menu').slideToggle();
    });
    // Handle selection from the dropdown
    $('#company-options .dropdown-item').on('click', function () {
        var selectedOption = $(this).data('value');

        // Remove 'select' class from all <li> elements and add it to the clicked one
        $('#company-options .dropdown-item').removeClass('selected');
        $(this).addClass('selected');

        $('#company-options .dropdown-toggle').text($(this).text());
        $('#company-options .dropdown-menu').hide();

    });
    // // Hide the dropdown if clicked outside
    $(document).on('click', function (e) {
        if (!$(e.target).closest('#company-options').length) {
            $('#company-options .dropdown-menu').hide();
        }
    });

    $('#dropdownMenuButton2').click(function () {
        $('#country-options .dropdown-menu').slideToggle();
    });
    // Handle selection from the dropdown
    $('#country-options .dropdown-item').on('click', function () {
        var selectedOption = $(this).data('value');

        // Remove 'select' class from all <li> elements and add it to the clicked one
        $('#country-options .dropdown-item').removeClass('selected');
        $(this).addClass('selected');

        $('#country-options .dropdown-toggle').text($(this).text());
        $('#country-options .dropdown-menu').hide();

    });
    // // Hide the dropdown if clicked outside
    $(document).on('click', function (e) {
        if (!$(e.target).closest('#country-options').length) {
            $('#country-options .dropdown-menu').hide();
        }
    });
    // ----filters ends----
});


jQuery(document).ready(function ($) {
    let startX, startY, startWidth, startHeight, startLeft, startTop, handle;
    let $resizing;
    $(document).on('mousedown', '.resize-handle', function (e) {
        e.preventDefault();
        handle = $(this).attr('class');
        // $resizing = $(this).closest('.parent-node .drawflow-node.add_node');
        $resizing = $(this).closest('.parent-node .drawflow-node.add_node, .parent-node .drawflow-node.circle, .parent-node .drawflow-node.diamond, .parent-node .drawflow-node.parallel, .parent-node .drawflow-node.rhombus, .parent-node .drawflow-node.ocatgon ');

        startX = e.pageX;
        startY = e.pageY;
        startWidth = parseInt($resizing.css('width'), 10);
        startHeight = parseInt($resizing.css('height'), 10);
        startLeft = parseInt($resizing.css('left'), 10);
        startTop = parseInt($resizing.css('top'), 10);

        $(document).on('mousemove', resize);
        $(document).on('mouseup', stopResize);
    });

    function resize(e) {
        const offsetX = e.pageX - startX;
        const offsetY = e.pageY - startY;

        let newWidth = startWidth;
        let newHeight = startHeight;
        let newLeft = startLeft;
        let newTop = startTop;

        if (handle.includes('resize-handle-bottom')) {
            newHeight = startHeight + offsetY;
        } else if (handle.includes('resize-handle-right')) {
            newWidth = startWidth + offsetX;
        } else if (handle.includes('resize-handle-top')) {
            newHeight = startHeight - offsetY;
            newTop = startTop + offsetY;
        } else if (handle.includes('resize-handle-left')) {
            newWidth = startWidth - offsetX;
            newLeft = startLeft + offsetX;
        }

        if (newHeight >= 50) {
            $resizing.css({
                height: newHeight + 'px',
                top: newTop + 'px'
            });
        }
        if (newWidth >= 50) {
            $resizing.css({
                width: newWidth + 'px',
                left: newLeft + 'px'
            });
        }
    }

    function stopResize() {
        $(document).off('mousemove', resize);
        $(document).off('mouseup', stopResize);
    }
});

jQuery(document).ready(function ($) {
    // All Submit of node page
    // Handle edit button click to set the current node-child
    $('#drop-area').on('click', '.add-node-btns', function () {
        $currentNodeChild = $(this).closest('.node-child');
        const imgSrc = $currentNodeChild.find('.node-image').attr('src');
        const text = $currentNodeChild.find('.node-text').text();
        if (imgSrc) {
            $('#addimage').val(''); // Clear any previous image selection
            $('#addimage').data('imgSrc', imgSrc); // Store existing image source in data attribute
        }
        $('#addtext').val(text);
    });


    let imgSrc = '';
    // Handle submit button in the modal
    $('#submit-addons').on('click', function (e) {
        e.preventDefault();

        const imageFile = $('#addimage')[0].files[0];
        const newText = $('#addtext').val().trim();
        const currentText = $currentNodeChild.find('.node-text').text().trim();


        // Use previously stored image src if no new image is selected
        const storedImgSrc = $('#addimage').data('imgSrc');
        const currentImgSrc = $currentNodeChild.find('.node-image').attr('src');

        // Check if either the image or text has changed
        const isImageChanged = imageFile || (!imageFile && storedImgSrc !== currentImgSrc);
        const isTextChanged = newText !== currentText;

        if (isImageChanged || isTextChanged) {
            if (imageFile) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    imgSrc = e.target.result;
                    $currentNodeChild.find('.node-image').attr('src', imgSrc);
                    $currentNodeChild.find('.node-text').text(newText);
                };
                reader.readAsDataURL(imageFile);
            } else {
                // If no new image is selected, use the stored image source
                if (storedImgSrc) {
                    $currentNodeChild.find('.node-image').attr('src', storedImgSrc);
                }
                $currentNodeChild.find('.node-text').text(newText);
            }

            // Close the modal
            $('#exampleModalToggle').modal('hide');
            $('.modal-backdrop').hide();

        } else {
            Swal.fire({
                title: 'No Changes Detected',
                text: 'No Changes Detected.',
                icon: 'info'
            }).then(() => {
                // Close modal after acknowledging the alert
                $('#exampleModalToggle').modal('hide');
                $('.modal-backdrop').hide();

            });
        }
    });




    // Create child-node
    $('#submit-child-node').on('click', function (e) {
        e.preventDefault();

        if ($('#addtext').val().trim() !== '') {
            $('.drawflow-node.selected .add-node-btns').off('mouseenter mouseleave').hide();
            $('#exampleModalToggle').modal('hide');
            $('.modal-backdrop').hide();
        } else {
            $('.drawflow-node.selected .add-node-btns').off('mouseenter mouseleave').show();
            $('#exampleModalToggle').modal('show');
            $('.modal-backdrop').show();
        }
        var nodes = [];
        $('.parent-node .drawflow-node').each(function () {
            var node = $(this);
            var nodeClass = node.attr('class').split(' ');
            var index = nodeClass.indexOf('drawflow-node');
            var afterClasses = nodeClass.slice(index + 1);

            var nodeData = {
                element_image_url: node.find('.node-image').attr('src'),
                element_text: node.find('.node-text').text(),
                element_text_url: node.find('.node-text-url a').attr('href'),
                node_class: afterClasses,
                element_left: node.css('left'),
                element_top: node.css('top'),
                element_height: node.css('height'),
                element_width: node.css('width')
            };

            nodes.push(nodeData);
        });


        $('#submit-addons').trigger('click');

        var childnodeName = $('#addtext').val().trim();
        if (childnodeName === '') {
            Swal.fire({
                title: 'Error',
                text: 'Please enter a Node-child name.',
                icon: 'error'
            });
            return;
        }
        $.ajax({
            url: my_ajax_object.ajax_url,
            type: 'POST',
            data: {
                action: 'create_nodechild_page',
                category_name: childnodeName,
                image_src: imgSrc
            },
            success: function (response) {
                // if (response.success == true) {
                //     // Create a hidden form and submit it
                //     var form = $('<form>', {
                //         'action': my_ajax_object.homeUrl + '/node-child/',
                //         'method': 'POST'
                //     }).append($('<input>', {
                //         'type': 'hidden',
                //         'name': 'category_name',
                //         'value': childnodeName
                //     })).append($('<input>', {
                //         'type': 'hidden',
                //         'name': 'image_src',
                //         'value': imgSrc // Include the image data in the form
                //     }));

                //     $('body').append(form);
                //     form.submit();

                if (response.success) {
                    var pageId = response.data.page_id;
                    // var targetDiv = document.getElementById('chididdata');
                    // targetDiv.innerHTML += 'Page ID: ' + pageId + '<br>Child Node Name: ' + childnodeName;
                    // $currentNodeChild.find('.node-text').append(spanElement);

                    var spanElement = `<span class="node-text-id" style="display:none;">${pageId}, ${childnodeName}</span>`;
                    $currentNodeChild.find('.node-text').after(spanElement);
                    var newTab = window.open(my_ajax_object.homeUrl + '/node-child/', '_blank');
                    // Create a form to send data to the new tab
                    newTab.document.write('<form id="dataForm" action="' + my_ajax_object.homeUrl + '/node-child/" method="POST">');
                    newTab.document.write('<input type="hidden" name="category_name" value="' + childnodeName + '">');
                    newTab.document.write('<input type="hidden" name="image_src" value="' + imgSrc + '">');
                    newTab.document.write('<input type="hidden" name="pageId" value="' + pageId + '">');
                    newTab.document.write('</form>');
                    newTab.document.getElementById('dataForm').submit();


                } else {
                    Swal.fire({
                        title: 'Error',
                        text: response.data.message,
                        icon: 'error'
                    });

                }
            },
            error: function () {
                Swal.fire({
                    title: 'Error',
                    text: 'An error occurred while processing the request.',
                    icon: 'error'
                });

            }
        });
    });



    // Last pulish/ save to data base
    $('#save-node-data-button').on('click', function (e) {
        e.preventDefault();

        // Collect company name and check if it's empty
        var companyName = $('#company-name').val().trim();
        if (companyName === '') {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Company name is required.',
                // timer: 500
            });
            return;
        }
        var getText = $('#textAreaContainer #textAreabox').val();
        if (getText === '') {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Please add short detail.',
                // timer: 500
            });
            return;
        }
        var getCat = $('.company-cat li.selected').attr('data-text');
        if (typeof getCat === 'undefined' || getCat === null || getCat === '') {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Please select a Industry.',
            });
            return;
        }
        var getCountry = $('.edit-country .filter-option').text().trim();
        if (getCountry === 'Select Country' || getCountry === '') {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Please select a Country.',
            });
            return;
        }

        var nodes = [];
        $('.parent-node .drawflow-node').each(function () {
            var node = $(this);
            var nodeClass = node.attr('class').split(' ');
            var index = nodeClass.indexOf('drawflow-node');
            var afterClasses = nodeClass.slice(index + 1);

            var nodeData = {
                company_logo: $('#company-logo-image').attr('src'),
                company_name: companyName,
                element_image_url: node.find('.node-image').attr('src'),
                element_text: node.find('.node-text').text(),
                element_text_id: node.find('.node-text-id').text(),
                element_text_url: node.find('.node-text-url a').attr('href'),
                node_class: afterClasses,
                element_left: node.css('left'),
                element_top: node.css('top'),
                element_height: node.css('height'),
                element_width: node.css('width')
            };

            nodes.push(nodeData);
        });

        // Collect SVG data
        let svgData = [];
        $('.drawflow svg').each(function () {
            const svgClass = $(this).attr('class');
            const pathDValues = $(this).find('path.main-path').map(function () {
                return $(this).attr('d');
            }).get();

            svgData.push({
                svgClass: svgClass,
                pathDValues: pathDValues
            });
        });

        let drawflowtranslateValues = [];
        $('.drawflow').each(function () {
            const transformStyle = $(this).attr('style');
            // Check if transformStyle is non-empty and contains a 'translate' transformation
            if (transformStyle && transformStyle.includes('translate')) {
                const translateMatch = transformStyle.match(/translate\(([^)]+)\)/);
                if (translateMatch) {
                    const translateValues = translateMatch[1].split(',');
                    const translateX = parseFloat(translateValues[0]);
                    const translateY = parseFloat(translateValues[1]);

                    // Push the values to the array
                    drawflowtranslateValues.push({
                        translateX: translateX,
                        translateY: translateY
                    });
                }
            }
        });


        // Prepare data for AJAX
        let ajaxData = {
            action: 'save_node_data',
            nonce: my_ajax_object.nonce, // Ensure this nonce is correct
            // current_user_id:allUserData.user_id,
            company_name: companyName,
            node_text: getText,
            node_cat: getCat,
            node_country: getCountry,
            nodes: nodes,
            svg_data: svgData
        };

        // Add drawflow_translate_values only if the array is not empty
        if (drawflowtranslateValues.length > 0) {
            ajaxData.drawflow_translate_values = drawflowtranslateValues;
        }

        $.ajax({
            url: my_ajax_object.ajax_url, // Ensure this URL is correct
            type: 'POST',
            data: ajaxData,
            beforeSend: function () {
                Swal.fire({
                    title: 'Please wait...',
                    text: 'Saving your data...',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
            },
            success: function (response) {
                Swal.close();
                if (response.success) {
                    Swal.fire({
                        title: 'Success',
                        text: response.data,
                        icon: 'success'
                    }).then(function () {
                        window.location.href = my_ajax_object.homeUrl + '/account/?tab=process';
                        // window.location.href = my_ajax_object.homeUrl + '/account/';
                    });
                } else {
                    Swal.fire('Error', response.data, 'error');
                }
            },
            error: function (xhr, status, error) {
                Swal.close();
                Swal.fire('Error', 'An error occurred: ' + error, 'error');
            }
        });
    });
});

// node end
jQuery(document).ready(function ($) {
    // Get URL parameter 'tab'
    const urlParams = new URLSearchParams(window.location.search);
    const tab = urlParams.get('tab');

    // If 'tab' is 'process', activate the "Process" tab
    if (tab === 'process') {
        // Deactivate all tabs
        $('.nav-link').removeClass('active');
        $('.tab-pane').removeClass('active show');

        // Activate the "Process" tab and its content pane
        $('#home-tab').addClass('active');
        $('#home-tab-pane').addClass('active show');
    }
});





// for nodechild start
jQuery(document).ready(function ($) {
    // Modal handle
    // Handle edit button click to set the current node-child
    $('#drop-area').on('click', '.add-node-btns', function () {
        $currentNodeChild = $(this).closest('.node-child');
        const imgSrc = $currentNodeChild.find('.node-image').attr('src');
        const text = $currentNodeChild.find('.node-text').text();

        if (imgSrc) {
            $('#addimage').val(''); // Clear any previous image selection
            $('#addimage').data('imgSrc', imgSrc); // Store existing image source in data attribute
        }
        $('#addtext').val(text);
    });
    // Handle submit button in the modal
    $('#submit-child-addons').on('click', function (e) {
        e.preventDefault();

        const imageFile = $('#addimage')[0].files[0];
        const newText = $('#addtext').val().trim();
        const currentText = $currentNodeChild.find('.node-text').text().trim();

        // Use previously stored image src if no new image is selected
        const storedImgSrc = $('#addimage').data('imgSrc');
        const currentImgSrc = $currentNodeChild.find('.node-image').attr('src');

        // Check if either the image or text has changed
        const isImageChanged = imageFile || (!imageFile && storedImgSrc !== currentImgSrc);
        const isTextChanged = newText !== currentText;

        if (isImageChanged || isTextChanged) {
            if (imageFile) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    const imgSrc = e.target.result;
                    $currentNodeChild.find('.node-image').attr('src', imgSrc);
                    $currentNodeChild.find('.node-text').text(newText);
                };
                reader.readAsDataURL(imageFile);
            } else {
                // If no new image is selected, use the stored image source
                if (storedImgSrc) {
                    $currentNodeChild.find('.node-image').attr('src', storedImgSrc);
                }
                $currentNodeChild.find('.node-text').text(newText);
            }
            // Close the modal
            $('#exampleModalToggle').modal('hide');
            $('.modal-backdrop').hide();

        } else {
            Swal.fire({
                title: 'No Changes Detected',
                text: 'No Changes Detected.',
                icon: 'info'
            }).then(() => {
                // Close modal after acknowledging the alert
                $('#exampleModalToggle').modal('hide');
                $('.modal-backdrop').hide();
            });
        }
    });
});