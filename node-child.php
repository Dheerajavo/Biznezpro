<?php
if ( !is_user_logged_in() ) {
    // Redirect to the login page if the user is not logged in
    wp_redirect( home_url('/sign-in/') );
    exit;
} elseif ( !current_user_can( 'editor' ) && !current_user_can( 'administrator' ) ) {
    // Redirect to the homepage if the user is not an editor or administrator
    wp_redirect( home_url() );
    exit;
}
?>

<?php /* Template Name:Node-child*/ ?>
<?php get_header(); ?>
<!-- main content area start -->
<div class="main-content-area">
    <div class="home-page">
        <div class="node-header">
            <style>
                nav.node-nav li label,
                nav.node-nav li button {
                    font-weight: 700;
                }

                .node-child-box {
                    border: 2px dashed #ccc;
                    padding: 20px;
                    min-height: 100vh;
                    min-width: 100%;
                    position: relative;
                    overflow: hidden;
                    margin-bottom: 40px;
                    box-sizing: border-box;
                    background: var(--background-color);
                    background-size: 25px 25px;
                    background-image: linear-gradient(to right, #f1f1f1 1px, transparent 1px),
                        linear-gradient(to bottom, #f1f1f1 1px, transparent 1px);
                }

                .drawflow-node {
                    position: absolute;
                    z-index: 10;
                }

                .circle-node,
                .rectangle-node {
                    background-color: white;
                    border: 2px solid #000;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    position: absolute;
                    text-align: center;
                    background-size: cover;
                    background-position: center;
                    cursor: pointer;
                }

                .circle-node {
                    width: 150px;
                    height: 150px;
                    border-radius: 50%;
                }

                .rectangle-node {
                    width: 250px;
                    height: 150px;
                }

                .node-text {
                    color: white;
                    font-size: 25px;
                    font-weight: bold;
                }

                .line-container {
                    position: absolute;
                    top: 0;
                    left: 0;
                    height: 100%;
                    width: 100%;
                    z-index: 1;
                    pointer-events: none;
                }

                .btn-clear#clear-nodes {
                    float: right;
                    position: absolute;
                    color: white;
                    background: var(--theme1);
                    padding: 5px 20px;
                    cursor: pointer;
                    z-index: 5;
                    margin: 20px;
                    border: 1px solid #F5F5F5;
                    border-radius: 40px;
                    background-size: 10px;
                }

                /* Hover Edit Button */
                .node-child .add-node-btns {
                    position: absolute;
                    top: 10px;
                    right: 10px;
                    display: none;
                    background: rgba(0, 0, 0, 0.5);
                    color: white;
                    border-radius: 50%;
                    padding: 5px;
                    cursor: pointer;
                }

                .node-child:hover .add-node-btns {
                    display: block;
                }

                .styled-select,
                .styled-input {
                    padding: 8px;
                    border: 2px solid #ccc;
                    border-radius: 4px;
                    width: 110%;
                    max-width: 200px;
                    /* Limit width */
                    font-size: 14px;
                    margin-top: 5px;
                }

                .styled-select:focus,
                .styled-input:focus {
                    border-color: #66afe9;
                    outline: none;
                }

                /*
                .styled-button {
                    padding: 10px 15px;
                    background-color: var(--theme1);
                    color: white;
                    border: none;
                    border-radius: 4px;
                    cursor: pointer;
                }

                .styled-button:hover {
                    background-color: darken(var(--theme1), 10%);
                } */
                .tox-dialog__body-content p {
                    display: none !important;
                }

                .tox-dialog__footer {
                    justify-content: center !important;
                }

                .tox .tox-promotion {
                    display: none !important;
                }

                span.tox-statusbar__branding {
                    display: none !important;
                }

                .tox.tox-tinymce {
                    height: 600px !important;
                }

                .child_section_content {
                    display: grid;
                    grid-template-columns: repeat(auto-fill, minmax(400px, 1fr));
                    grid-gap: 20px;
                }

                .child_section_content .industry_cnt {
                    width: 100%;
                }

                .child_section_content select {
                    width: 100% !important;
                }



                .child_section_content .country_cnt button {
                    width: 100% !important;
                    border-radius: 0;
                    background: transparent;
                    color: #000;
                    font-weight: 500;
                    border-color: #000;
                }

                .child_section_content select {
                    width: 100% !important;
                    height: 44px;
                }
            </style>

            <?php
            $category_name = isset($_POST['category_name']) ? sanitize_text_field($_POST['category_name']) : 'Node Childs';
            $image_src = isset($_POST['image_src']) ? sanitize_text_field($_POST['image_src']) : 'image_src Childs';
            $page_id = isset($_POST['pageId']) ? intval($_POST['pageId']) : 0;

            ?>
            <script src="<?php echo get_stylesheet_directory_uri(); ?>/assets/tinymce/tinymce.min.js"></script>
            <script>
                jQuery(document).ready(function($) {

                    $('#numCircles').on('input', function() {
                        let numShapes = parseInt($(this).val());
                        let minShapes = parseInt($(this).attr('min'));
                        let maxShapes = parseInt($(this).attr('max'));

                        if (numShapes <= minShapes) {
                            Swal.fire({
                                icon: 'warning',
                                title: 'Minimum Shapes Required',
                                text: `The number of outer shapes must be at least ${minShapes}.`,
                                confirmButtonText: 'Okay'
                            });
                            $(this).val(minShapes);
                        }

                        if (numShapes >= maxShapes) {
                            Swal.fire({
                                icon: 'warning',
                                title: 'Maximum Reached',
                                text: `You have reached the maximum number of shapes (${maxShapes}).`,
                                confirmButtonText: 'Okay'
                            });
                            $(this).val(maxShapes);
                        }
                    });
                });
            </script>
            <script>
                jQuery(document).ready(function($) {
                    let $currentNodeChild;
                    var categoryName = <?php echo json_encode($category_name); ?>;
                    var imageSrc = <?php echo json_encode($image_src); ?>;

                    // Restrict user input based on shape type
                    $('#shapeType').on('change', function() {
                        const shapeType = $(this).val();
                        if (shapeType === 'circle-node') {
                            $('#numCircles').attr('max', 10).val(4);
                        } else if (shapeType === 'rectangle-node') {
                            $('#numCircles').attr('max', 8).val(4);
                        } else if (shapeType === 'full-screen-structure') {
                            $('#numCircles').attr('max', 8).val(8); // Full-screen layout defaults to 8
                        }
                    });

                    // Clear nodes when button is clicked
                    $('#clear-nodes').click(function() {
                        $('#drop-area .line-container, #drop-area .drawflow-node').remove();
                    });

                    // Generate Circles and Rectangles based on input
                    $('#generate-circles').on('click', function(e) {
                        e.preventDefault();


                        let numShapes = parseInt($('#numCircles').val());
                        let shapeType = $('#shapeType').val();
                        let container = $('#drop-area');
                        let containerWidth = container.width();
                        let containerHeight = container.height();
                        //let x = containerWidth / 2; // Central X position
                        // let y = containerHeight / 2; // Central Y position
                        let x = container.width() / 2;
                        let y = container.height() / 2;

                        // Clear existing nodes
                        $('#drop-area .line-container, #drop-area .drawflow-node').remove();

                        // Call the function to add the nodes based on the input value
                        if (shapeType === 'full-screen-structure') {
                            createFullScreenStructure(x, y, containerWidth, containerHeight, numShapes);
                        } else {
                            addNodeToDrawFlow(shapeType, x, y, numShapes);
                        }
                        //addNodeToDrawFlow(shapeType, x, y, numShapes);
                    });

                    function createFullScreenStructure(x, y, containerWidth, containerHeight, numShapes) {
                        var imageSrcouter = '<?php echo home_url(); ?>/wp-content/uploads/2024/08/no-image-default.png';
                        let width = 250; // Width of each outer rectangle
                        let height = 150; // Height of each outer rectangle
                        var background = imageSrc; // Dummy image
                        var textfull = categoryName;

                        // Create the central node with dummy image
                        let centralNode = `<div class="drawflow-node outerwithoutline rectangle-node" style="left: ${x - width / 4}px; top: ${y - height / 6}px; width: ${width}px; height: ${height}px; background-image: url(${background}); background-size: cover;">
                            <div class="node-text">${textfull}</div>
                            <div class="add-node-btns"><i class="ri-edit-box-line"></i></div>
                        </div>`;
                        $('#drop-area').append(centralNode);

                        // Define positions for outer rectangles based on user input (numShapes)
                        let outerPositions = [];
                        let possiblePositions = [{
                                left: containerWidth / 3.5 - width / 1,
                                top: containerHeight / 4 - height / 2
                            }, // Top-left
                            {
                                left: containerWidth / 2 - width / 4,
                                top: containerHeight / 4 - height / 2
                            }, // Top-center
                            {
                                left: containerWidth - width,
                                top: containerHeight / 4 - height / 2
                            }, // Top-right
                            {
                                left: containerWidth / 3.5 - width / 1,
                                top: containerHeight / 2 - height / 6
                            }, // Center-left
                            {
                                left: containerWidth - width,
                                top: containerHeight / 2 - height / 6
                            }, // Center-right
                            {
                                left: containerWidth / 3.5 - width / 1,
                                top: containerHeight - height
                            }, // Bottom-left
                            {
                                left: containerWidth / 2 - width / 4,
                                top: containerHeight - height
                            }, // Bottom-center
                            {
                                left: containerWidth - width,
                                top: containerHeight - height
                            } // Bottom-right
                        ];

                        // Only take the number of shapes specified by user input
                        outerPositions = possiblePositions.slice(0, numShapes);

                        // Append outer rectangles with dummy image and edit icon
                        outerPositions.forEach(pos => {
                            let outerNode = `<div class="drawflow-node outerwithoutline rectangle-node node-child" style="left: ${pos.left}px; top: ${pos.top}px; width: ${width}px; height: ${height}px; background-image: url(${imageSrcouter}); background-size: cover;">
                                <div class="node-text"></div>
                                <div class="add-node-btns"><i class="ri-edit-box-line"></i></div>
                            </div>`;
                            $('#drop-area').append(outerNode);
                        });

                        // Handle edit functionality on hover
                        $('.node-child .add-node-btns').click(function() {
                            $currentNodeChild = $(this).closest('.node-child');

                            // Retrieve the existing text and background image from the node
                            const bgImage = $currentNodeChild.css('background-image');
                            const text = $currentNodeChild.find('.node-text').text();
                            const imgSrc = bgImage ? bgImage.replace(/^url\(["']?/, '').replace(/["']?\)$/, '') : '';

                            $('#addimage').val(''); // Clear previous image
                            $('#addimage').data('imgSrc', imgSrc); // Store current image
                            var $currentNode = $(this).closest('.node-child');

                            $('#popup-form').data('currentNode', $currentNode);

                            $('#addtext').val(text); // Store current text in input
                            $('#exampleModalToggle').modal('show'); // Show the modal
                        });
                    }


                    function addNodeToDrawFlow(shape, x, y, numShapes) {
                        let shapeDimensions = {
                            'circle-node': {
                                width: 150,
                                height: 150,
                                background: '<?php echo home_url(); ?>/wp-content/uploads/2024/08/no-image-default.png',
                                text: categoryName
                            },
                            'rectangle-node': {
                                width: 250,
                                height: 150,
                                background: '<?php echo home_url(); ?>/wp-content/uploads/2024/08/no-image-default.png',
                                text: categoryName
                            }
                        };

                        let {
                            width,
                            height,
                            background,
                            text
                        } = shapeDimensions[shape];

                        let centralNodeWidth = 200;
                        let centralNodeHeight = 200;
                        let radius = centralNodeWidth / 2;
                        let distance = 250;

                        // Create the central node
                        let centralNode = `<div class="drawflow-node ${shape}" style="left: ${x - radius}px; top: ${y - centralNodeHeight / 2}px; width: ${centralNodeWidth}px; height: ${centralNodeHeight}px; background-image:url(${imageSrc}); background-size: cover;">
                            <div class="node-text">${text}</div>
                        </div>`;
                        $('#drop-area').append(centralNode);

                        // Create SVG container for lines
                        let svgLines = `<svg class="line-container" width="100%" height="100%" xmlns="http://www.w3.org/2000/svg">`;

                        let positions = [];

                        if (shape === 'rectangle-node') {
                            switch (numShapes) {
                                case 2:
                                    positions = [{
                                            left: x - width / 2,
                                            top: y - distance - height / 2
                                        },
                                        {
                                            left: x - width / 2,
                                            top: y + distance - height / 2
                                        }
                                    ];
                                    break;
                                case 3:
                                    positions = [{
                                            left: x - width / 2,
                                            top: y - distance - height / 2
                                        },
                                        {
                                            left: x - width / 2,
                                            top: y + distance - height / 2
                                        },
                                        {
                                            left: x + distance - width / 1.5,
                                            top: y - height / 2
                                        }
                                    ];
                                    break;
                                case 4:
                                    positions = [{
                                            left: x - width / 2,
                                            top: y - distance - height / 2
                                        },
                                        {
                                            left: x - width / 2,
                                            top: y + distance - height / 2
                                        },
                                        {
                                            left: x - distance - width / 1.5,
                                            top: y - height / 2
                                        },
                                        {
                                            left: x + distance - width / 3,
                                            top: y - height / 2
                                        }
                                    ];
                                    break;
                                case 5:
                                    positions = [{
                                            left: x - width / 2,
                                            top: y - distance - height / 2
                                        },
                                        {
                                            left: x - width / 2,
                                            top: y + distance - height / 2
                                        },
                                        {
                                            left: x - distance - width / 1.5,
                                            top: y - height / 2
                                        },
                                        {
                                            left: x + distance - width / 3,
                                            top: y - height / 2
                                        },
                                        {
                                            left: x + distance / 1 - width / 3,
                                            top: y - distance - height / 2
                                        }
                                    ];
                                    break;
                                case 6:
                                    positions = [{
                                            left: x - width / 2,
                                            top: y - distance - height / 2
                                        },
                                        {
                                            left: x - width / 2,
                                            top: y + distance - height / 2
                                        },
                                        {
                                            left: x - distance - width / 1.5,
                                            top: y - height / 2
                                        },
                                        {
                                            left: x + distance - width / 3,
                                            top: y - height / 2
                                        },
                                        {
                                            left: x - distance / 1 - width / 1.5,
                                            top: y - distance - height / 2
                                        },
                                        {
                                            left: x + distance / 1 - width / 3,
                                            top: y - distance - height / 2
                                        }
                                    ];
                                    break;
                                case 7:
                                    positions = [{
                                            left: x - width / 2,
                                            top: y - distance - height / 2
                                        },
                                        {
                                            left: x - width / 2,
                                            top: y + distance - height / 2
                                        },
                                        {
                                            left: x - distance - width / 1.5,
                                            top: y - height / 2
                                        },
                                        {
                                            left: x + distance - width / 3,
                                            top: y - height / 2
                                        },
                                        {
                                            left: x - distance / 1 - width / 1.5,
                                            top: y - distance - height / 2
                                        },
                                        {
                                            left: x + distance / 1 - width / 3,
                                            top: y - distance - height / 2
                                        },
                                        {
                                            left: x - distance / 1 - width / 1.5,
                                            top: y + distance - height / 2
                                        }
                                    ];
                                    break;
                                case 8:
                                    positions = [{
                                            left: x - width / 2,
                                            top: y - distance - height / 2
                                        },
                                        {
                                            left: x - width / 2,
                                            top: y + distance - height / 2
                                        },
                                        {
                                            left: x - distance - width / 1.5,
                                            top: y - height / 2
                                        },
                                        {
                                            left: x + distance - width / 3,
                                            top: y - height / 2
                                        },
                                        {
                                            left: x - distance / 1 - width / 1.5,
                                            top: y - distance - height / 2
                                        },
                                        {
                                            left: x + distance / 1 - width / 3,
                                            top: y - distance - height / 2
                                        },
                                        {
                                            left: x - distance / 1 - width / 1.5,
                                            top: y + distance - height / 2
                                        },
                                        {
                                            left: x + distance / 1 - width / 3,
                                            top: y + distance - height / 2
                                        }
                                    ];
                                    break;
                            }

                            positions.forEach(pos => {
                                let surroundingNode = `<div class="drawflow-node ${shape} node-child" style="left: ${pos.left}px; top: ${pos.top}px; width: ${width}px; height: ${height}px; background-image: url(${background}); background-size: cover;">
                                    <div class="node-text"></div>
                                    <div class="add-node-btns"><i class="ri-edit-box-line"></i></div>
                                </div>`;
                                $('#drop-area').append(surroundingNode);

                                // Correct line positions for X and Y axis (using center points)
                                let centerX = pos.left + width / 2;
                                let centerY = pos.top + height / 2;

                                // Add lines to connect the central node to the surrounding nodes
                                svgLines += `<line x1="${x}" y1="${y}" x2="${centerX}" y2="${centerY}" stroke="black" stroke-width="2" />`;
                            });

                        } else {
                            // Circles use radial positioning
                            let angleIncrement = 360 / numShapes;

                            for (let i = 0; i < numShapes; i++) {
                                let angle = i * angleIncrement;
                                let radian = (angle * Math.PI) / 180;
                                let outerX = x + distance * Math.cos(radian);
                                let outerY = y + distance * Math.sin(radian);

                                // Create outer nodes
                                let surroundingNode = `<div class="drawflow-node ${shape} node-child" style="left: ${outerX - width / 2}px; top: ${outerY - height / 2}px; width: ${width}px; height: ${height}px; background-image: url(${background}); background-size: cover;">
                                    <div class="node-text"></div>
                                    <div class="add-node-btns"><i class="ri-edit-box-line"></i></div>
                                </div>`;
                                $('#drop-area').append(surroundingNode);

                                // Add lines to connect the central node to the surrounding nodes
                                svgLines += `<line x1="${x}" y1="${y}" x2="${outerX}" y2="${outerY}" stroke="black" stroke-width="2" />`;
                            }
                        }

                        // Close the SVG and append it
                        svgLines += `</svg>`;
                        $('#drop-area').append(svgLines);
                        console.log($('#drop-area').html());
                        // Handle edit functionality

                        $('.node-child .add-node-btns').click(function() {
                            $currentNodeChild = $(this).closest('.node-child');

                            // Retrieve the existing text and background image from the node
                            const bgImage = $currentNodeChild.css('background-image');
                            const text = $currentNodeChild.find('.node-text').text();
                            const imgSrc = bgImage ? bgImage.replace(/^url\(["']?/, '').replace(/["']?\)$/, '') : '';

                            $('#addimage').val(''); // Clear previous image
                            $('#addimage').data('imgSrc', imgSrc); // Store current image
                            var $currentNode = $(this).closest('.node-child');

                            $('#popup-form').data('currentNode', $currentNode);

                            $('#addtext').val(text); // Store current text in input
                            $('#exampleModalToggle').modal('show'); // Show the modal
                            //$('#submit-text-node').show();
                        });
                    }

                    // Save the edited data when "Submit" is clicked in modal
                    $('#submit-addons button').click(function() {
                        const imageFile = $('#addimage')[0].files[0];
                        const newText = $('#addtext').val().trim();
                        const currentText = $currentNodeChild.find('.node-text').text().trim();
                        const storedImgSrc = $('#addimage').data('imgSrc');
                        const currentBgImage = $currentNodeChild.css('background-image');
                        const currentImgSrc = currentBgImage ? currentBgImage.replace(/^url\(["']?/, '').replace(/["']?\)$/, '') : '';

                        // Check if either the image or text has changed
                        const isImageChanged = imageFile || (!imageFile && storedImgSrc !== currentImgSrc);
                        const isTextChanged = newText !== currentText;

                        if (isImageChanged || isTextChanged) {
                            if (imageFile) {
                                const reader = new FileReader();
                                reader.onload = function(e) {
                                    const imgSrc = e.target.result;
                                    $currentNodeChild.css('background-image', `url(${imgSrc})`);
                                    $currentNodeChild.find('.node-text').text(newText);
                                };
                                reader.readAsDataURL(imageFile);
                            } else if (storedImgSrc) {
                                $currentNodeChild.css('background-image', `url(${storedImgSrc})`);
                                $currentNodeChild.find('.node-text').text(newText);
                            }
                            $('#exampleModalToggle').modal('hide'); // Hide the modal
                        }
                    });

                    $('#save-node-child-data-button').on('click', function(e) {
                        e.preventDefault();

                        let hasEmptyNodeText = false;
                        $('.drawflow-node.node-child .node-text').each(function() {
                            if ($(this).text().trim() === "") {
                                hasEmptyNodeText = true;
                            }
                        });

                        // If there's an empty .node-text, show an error message and stop the AJAX call
                        if (hasEmptyNodeText) {
                            Swal.fire({
                                title: "Error!",
                                text: "One or more node text fields are empty. Please fill all the fields before saving.",
                                icon: "error",
                                showConfirmButton: true,
                                confirmButtonText: 'Close'
                            });
                            return; // Stop further execution of the function
                        }


                        let page_id = "<?php echo esc_js($page_id); ?>";
                        let imageSrc = "<?php echo esc_js($image_src); ?>";
                        let category_name = "<?php echo esc_js($category_name); ?>";

                        // Array to hold the node group data
                        let nodeChildGroupData = [];
                        $('.node-shape-group').each(function() {
                            let $this = $(this);
                            let top = $this.css('top');
                            let left = $this.css('left');
                            let nodeGroupData = {
                                id: $this.attr('id'),
                                top: top,
                                left: left,
                                center_bg_url: imageSrc,
                                center_text: category_name,
                            };
                            nodeChildGroupData.push(nodeGroupData);
                        });

                        // Array to hold child node data

                        let childNodes = [];
                        $('.drawflow-node').each(function() {
                            let $node = $(this);

                            let nodeClass = $node.attr('class').split(' ');
                            let index = nodeClass.indexOf('drawflow-node');
                            let afterClasses = nodeClass.slice(index + 1);

                            let bgImageUrl = $node.css('background-image');
                            let urlMatch = bgImageUrl.match(/url\(["']?(.*?)["']?\)/);
                            let imageUrl = urlMatch ? urlMatch[1] : '';
                            let nodeChildData = {

                                element_bgimage_url: imageUrl,
                                element_text: $node.find('.node-text').text(),
                                element_post_id: $node.find('span.post_id').text(),
                                node_class: afterClasses,
                                element_left: $node.css('left'),
                                element_top: $node.css('top'),
                                element_height: $node.css('height'),
                                element_width: $node.css('width'),

                            };
                            childNodes.push(nodeChildData);
                        });

                        // Collect SVG line data
                        let lineData = [];
                        $('#drop-area .line-container line').each(function() {
                            let $line = $(this);
                            lineData.push({
                                x1: $line.attr('x1'),
                                y1: $line.attr('y1'),
                                x2: $line.attr('x2'),
                                y2: $line.attr('y2')
                            });
                        });
                        console.log(lineData);

                        let ajaxData = {
                            action: 'save_child_node_data',
                            nonce: my_ajax_object.nonce, // Ensure this nonce is correct
                            nodeGroupData: nodeChildGroupData,
                            nodeChildData: childNodes,
                            lineData: lineData,
                            parentnodename: categoryName,
                            page_id: page_id
                        };

                        // Send data to server via AJAX
                        $.ajax({
                            url: '<?php echo admin_url("admin-ajax.php"); ?>', // replace with your server URL
                            type: 'POST',
                            data: ajaxData,
                            success: function(response) {
                                Swal.fire({
                                    title: "Success!",
                                    text: "Child Node data saved successfully!",
                                    icon: "success",
                                    showConfirmButton: true,
                                    confirmButtonText: 'Close Tab'
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        window.close(); // Close the current browser tab
                                    }
                                });
                                console.log('Response:', response);
                            },

                            error: function(xhr, status, error) {
                                Swal.fire("Error!", "An error occurred while saving node data.", "error");
                                console.log('Error:', error);
                            }
                        });
                    });


                    // Function to initialize TinyMCE with media options
                    function initializeEditor() {
                        tinymce.init({
                            selector: '#post-content', // Target the textarea
                            height: 300,
                            plugins: 'image media link', // Include image, media, and link plugins
                            toolbar: 'undo redo | formatselect | bold italic | image media link',
                            automatic_uploads: true,
                            images_upload_handler: function(blobInfo, success, failure) {
                                var formData = new FormData();
                                formData.append('file', blobInfo.blob(), blobInfo.filename()); // Append the image file
                                formData.append('action', 'upload_image'); // WordPress AJAX action for image upload

                                // Send the image to the server using AJAX
                                $.ajax({
                                    url: '<?php echo admin_url("admin-ajax.php"); ?>', // WordPress AJAX URL
                                    type: 'POST',
                                    data: formData,
                                    processData: false,
                                    contentType: false,
                                    success: function(response) {
                                        console.log('AJAX success: Image URL is ', response.data.url); // Debugging the image URL

                                        if (response.success) {
                                            // Directly insert the image into the TinyMCE editor
                                            tinymce.activeEditor.insertContent('<img src="' + response.data.url + '" />');

                                            // Automatically close the image selection dialog, if needed
                                            tinymce.activeEditor.windowManager.close(); // Close any modal, if open
                                        } else {
                                            failure(response.data.message || 'Image upload failed.');
                                        }
                                    },
                                    error: function() {
                                        failure('Image upload failed due to a server error.');
                                    }
                                });
                            }
                        });
                    }

                    function resetPopupFields() {
                        tinymce.get('post-content').setContent('');
                        $('#industry').val('');
                    }
                    // When the "Add Description" button is clicked
                    $('#submit-text-node').on('click', function() {
                        var image = $('#addimage').val();
                        var text = $('#addtext').val();


                        if (!image || !text) {

                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: 'Please enter both text and image!',
                            });

                        } else {

                            $('#submit-addons button').click();
                            $('#popup-form').fadeIn();
                            setTimeout(function() {
                                initializeEditor();
                            }, 200);
                        }
                    });
                    $('#close-popup').on('click', function() {
                        $('#popup-form').fadeOut();
                        $('#exampleModalToggle').modal('show');
                    });

                    $('#dropdownMenuButton2').on('click', function() {
                        $('#country-list').toggle(); // Toggle visibility of country list
                    });

                    // Handle country selection
                    $('#country-list .dropdown-item').on('click', function() {
                        var selectedCountry = $(this).data('value');
                        var selectedCountryText = $(this).text();

                        $('#selected-country').val(selectedCountry); // Store country value in hidden input
                        $('#dropdownMenuButton2').text(selectedCountryText); // Update button text to show selected country

                        $('#country-list').hide(); // Hide the country list after selection
                    });

                    $('#submit-post').on('click', function() {
                        var $currentNode = $('#popup-form').data('currentNode');
                        var postContent = tinymce.get('post-content').getContent();
                        var industrySlug = $('#industry').val();
                        var selectedCountry = $('#selected-country').val();
                        var addtext = $('#addtext').val();

                        if (!postContent.trim()) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: 'Please enter the post content!',
                            });
                            return;
                        }

                        if (!industrySlug) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: 'Please select an industry!',
                            });
                            return;
                        }

                        var data = {
                            action: 'create_new_post',
                            post_content: postContent,
                            industry_slug: industrySlug,
                            country: selectedCountry,
                            addtext: addtext,
                        };

                        $.post('<?php echo admin_url('admin-ajax.php'); ?>', data, function(response) {
                            if (response.success) {
                                $currentNode.find('.node-text').after('<span class="post_id" style="display:none";>' + response.data.post_url + '</span>');
                                $currentNode.find('.add-node-btns').hide();
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Post Created',
                                    text: 'Your post was created successfully!',
                                });
                                $('#popup-form').fadeOut();
                                resetPopupFields();
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: 'Failed to create post: ' + response.data.message,
                                });
                            }
                        }).fail(function() {
                            $currentNode.find('.add-node-btns').hide();
                            Swal.fire({
                                icon: 'success',
                                title: 'Post Created',
                                text: 'Your post was created successfully!',
                            });
                            $('#popup-form').fadeOut();
                            resetPopupFields();
                        });
                    });
                });
            </script>

            <div>
                <nav class="node-nav">
                    <ul class="node-shapes">
                        <li>
                            <label for="numCircles">Number of outer shapes</label>
                            <input type="number" id="numCircles" value="8" min="1" max="8" class="styled-input" />
                        </li>
                        <li>
                            <label for="shapeType">Shape Type</label>
                            <select id="shapeType" class="styled-select">
                                <option value="rectangle-node">Rectangle</option>
                                <option value="circle-node">Circle</option>
                                <option value="full-screen-structure">Full Screen Structure</option>
                            </select>
                        </li>
                        <li>
                            <button id="generate-circles" class="styled-button">Generate</button>
                        </li>
                        <li>
                            <?php
                            $category_name = isset($_POST['category_name']) ? sanitize_text_field($_POST['category_name']) : '';
                            if (!empty($category_name)) {
                                echo '<h1>' . esc_html($category_name) . '</h1>';
                            } else {
                                echo '<h1>Node Childs</h1>'; // Default heading if no category name is provided
                            } ?>
                        </li>
                    </ul>
                    <button id="save-node-child-data-button" class="primary-btn">Save</button>
                </nav>
            </div>


            <div class="btn-clear" id="clear-nodes">Clear</div>
            <div class="add-node node-child-box" id="drop-area">
                <div class="node-shape-group" draggable="true">
                    <div class="line-container" id="line-container">
                        <!-- Dynamic nodes and lines will be added here -->
                    </div>
                </div>
            </div>

            <!-- Modal for editing nodes -->
            <div class="modal fade addNode" id="exampleModalToggle" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="grid grid-cols-2">
                                <div class="item">
                                    <div class="form-group">
                                        <label for="image">Add Image</label>
                                        <input type="file" name="image" id="addimage" class="input-control">
                                    </div>
                                </div>
                                <div class="item">
                                    <label for="addtext">Add Text</label>
                                    <input type="text" id="addtext" class="input-control" placeholder="Type Here...">
                                </div>
                            </div>
                            <div class="grid grid-cols-2">
                                <div class="add-text-node" id="submit-text-node">
                                    <button type="submit">Add Description</button>
                                </div>
                                <div class="submit-addons " id="submit-addons">
                                    <button type="submit">Submit</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Full-page overlay form -->
            <div id="popup-form" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.8); z-index: 1000; overflow: auto;">
                <div style="background-color: white; margin: 5% auto; padding: 20px; border-radius: 10px; width: 90%; max-width: 1199px;">
                    <h4>Enter Details</h4>
                    <form id="new-post-form">
                        <label for="post-content">Enter Description:</label><br>
                        <textarea id="post-content" name="post-content" rows="10" style="width: 100%;"></textarea><br><br>
                        <div class="child_section_content">
                            <div class="industry_cnt">
                                <label for="industry">Select Industry:</label><br>
                                <?php
                                $uncategorized = get_category_by_slug('uncategorized');
                                $exclude_category = $uncategorized ? array($uncategorized->term_id) : array();

                                $terms = get_terms([
                                    'post_type'  => 'industries',
                                    'taxonomy'   => 'category',
                                    'orderby'    => 'name',
                                    'order'      => 'ASC',
                                    'hide_empty' => false,
                                    'exclude'    => $exclude_category,
                                ]);
                                ?>
                                <select id="industry" name="industry" style="width: 50%; padding: 5px;">
                                    <option value="">Select Industry</option>
                                    <?php foreach ($terms as $cat) { ?>
                                        <option value="<?php echo $cat->slug; ?>"><?php echo $cat->name; ?></option>
                                    <?php } ?>
                                </select><br><br>
                            </div>
                            <div class="country_cnt">
                                <label for="country">Select Country:</label><br>
                                <button type="button" id="dropdownMenuButton2" style="padding: 10px; width: 50%;" class="dropdown-toggle">Select Country</button>
                                <input type="hidden" id="selected-country" name="selected-country" value="">
                                <ul id="country-list" class="dropdown-menu" style="display: none; max-height: 200px; overflow-y: auto; border: 1px solid #ccc; padding: 10px;">

                                    <li class="dropdown-item" data-value="AF">Afghanistan</li>
                                    <li class="dropdown-item" data-value="AL">Albania</li>
                                    <li class="dropdown-item" data-value="DZ">Algeria</li>
                                    <li class="dropdown-item" data-value="AS">American Samoa</li>
                                    <li class="dropdown-item" data-value="AD">Andorra</li>
                                    <li class="dropdown-item" data-value="AO">Angola</li>
                                    <li class="dropdown-item" data-value="AI">Anguilla</li>
                                    <li class="dropdown-item" data-value="AQ">Antarctica</li>
                                    <li class="dropdown-item" data-value="AG">Antigua and Barbuda</li>
                                    <li class="dropdown-item" data-value="AR">Argentina</li>
                                    <li class="dropdown-item" data-value="AM">Armenia</li>
                                    <li class="dropdown-item" data-value="AW">Aruba</li>
                                    <li class="dropdown-item" data-value="AU">Australia</li>
                                    <li class="dropdown-item" data-value="AT">Austria</li>
                                    <li class="dropdown-item" data-value="AZ">Azerbaijan</li>
                                    <li class="dropdown-item" data-value="BS">Bahamas</li>
                                    <li class="dropdown-item" data-value="BH">Bahrain</li>
                                    <li class="dropdown-item" data-value="BD">Bangladesh</li>
                                    <li class="dropdown-item" data-value="BB">Barbados</li>
                                    <li class="dropdown-item" data-value="BY">Belarus</li>
                                    <li class="dropdown-item" data-value="BE">Belgium</li>
                                    <li class="dropdown-item" data-value="BZ">Belize</li>
                                    <li class="dropdown-item" data-value="BJ">Benin</li>
                                    <li class="dropdown-item" data-value="BM">Bermuda</li>
                                    <li class="dropdown-item" data-value="BT">Bhutan</li>
                                    <li class="dropdown-item" data-value="BO">Bolivia</li>
                                    <li class="dropdown-item" data-value="BA">Bosnia and Herzegovina</li>
                                    <li class="dropdown-item" data-value="BW">Botswana</li>
                                    <li class="dropdown-item" data-value="BV">Bouvet Island</li>
                                    <li class="dropdown-item" data-value="BR">Brazil</li>
                                    <li class="dropdown-item" data-value="IO">British Indian Ocean Territory</li>
                                    <li class="dropdown-item" data-value="BN">Brunei Darussalam</li>
                                    <li class="dropdown-item" data-value="BG">Bulgaria</li>
                                    <li class="dropdown-item" data-value="BF">Burkina Faso</li>
                                    <li class="dropdown-item" data-value="BI">Burundi</li>
                                    <li class="dropdown-item" data-value="KH">Cambodia</li>
                                    <li class="dropdown-item" data-value="CM">Cameroon</li>
                                    <li class="dropdown-item" data-value="CA">Canada</li>
                                    <li class="dropdown-item" data-value="CV">Cape Verde</li>
                                    <li class="dropdown-item" data-value="KY">Cayman Islands</li>
                                    <li class="dropdown-item" data-value="CF">Central African Republic</li>
                                    <li class="dropdown-item" data-value="TD">Chad</li>
                                    <li class="dropdown-item" data-value="CL">Chile</li>
                                    <li class="dropdown-item" data-value="CN">China</li>
                                    <li class="dropdown-item" data-value="CX">Christmas Island</li>
                                    <li class="dropdown-item" data-value="CC">Cocos (Keeling) Islands</li>
                                    <li class="dropdown-item" data-value="CO">Colombia</li>
                                    <li class="dropdown-item" data-value="KM">Comoros</li>
                                    <li class="dropdown-item" data-value="CG">Congo</li>
                                    <li class="dropdown-item" data-value="CD">Congo, The Democratic Republic of The</li>
                                    <li class="dropdown-item" data-value="CK">Cook Islands</li>
                                    <li class="dropdown-item" data-value="CR">Costa Rica</li>
                                    <li class="dropdown-item" data-value="CI">Cote D'Ivoire</li>
                                    <li class="dropdown-item" data-value="HR">Croatia</li>
                                    <li class="dropdown-item" data-value="CU">Cuba</li>
                                    <li class="dropdown-item" data-value="CY">Cyprus</li>
                                    <li class="dropdown-item" data-value="CZ">Czech Republic</li>
                                    <li class="dropdown-item" data-value="DK">Denmark</li>
                                    <li class="dropdown-item" data-value="DJ">Djibouti</li>
                                    <li class="dropdown-item" data-value="DM">Dominica</li>
                                    <li class="dropdown-item" data-value="DO">Dominican Republic</li>
                                    <li class="dropdown-item" data-value="EC">Ecuador</li>
                                    <li class="dropdown-item" data-value="EG">Egypt</li>
                                    <li class="dropdown-item" data-value="SV">El Salvador</li>
                                    <li class="dropdown-item" data-value="GQ">Equatorial Guinea</li>
                                    <li class="dropdown-item" data-value="ER">Eritrea</li>
                                    <li class="dropdown-item" data-value="EE">Estonia</li>
                                    <li class="dropdown-item" data-value="ET">Ethiopia</li>
                                    <li class="dropdown-item" data-value="FK">Falkland Islands (Malvinas)</li>
                                    <li class="dropdown-item" data-value="FO">Faroe Islands</li>
                                    <li class="dropdown-item" data-value="FJ">Fiji</li>
                                    <li class="dropdown-item" data-value="FI">Finland</li>
                                    <li class="dropdown-item" data-value="FR">France</li>
                                    <li class="dropdown-item" data-value="GF">French Guiana</li>
                                    <li class="dropdown-item" data-value="PF">French Polynesia</li>
                                    <li class="dropdown-item" data-value="TF">French Southern Territories</li>
                                    <li class="dropdown-item" data-value="GA">Gabon</li>
                                    <li class="dropdown-item" data-value="GM">Gambia</li>
                                    <li class="dropdown-item" data-value="GE">Georgia</li>
                                    <li class="dropdown-item" data-value="DE">Germany</li>
                                    <li class="dropdown-item" data-value="GH">Ghana</li>
                                    <li class="dropdown-item" data-value="GI">Gibraltar</li>
                                    <li class="dropdown-item" data-value="GR">Greece</li>
                                    <li class="dropdown-item" data-value="GL">Greenland</li>
                                    <li class="dropdown-item" data-value="GD">Grenada</li>
                                    <li class="dropdown-item" data-value="GP">Guadeloupe</li>
                                    <li class="dropdown-item" data-value="GU">Guam</li>
                                    <li class="dropdown-item" data-value="GT">Guatemala</li>
                                    <li class="dropdown-item" data-value="GG">Guernsey</li>
                                    <li class="dropdown-item" data-value="GN">Guinea</li>
                                    <li class="dropdown-item" data-value="GW">Guinea-bissau</li>
                                    <li class="dropdown-item" data-value="GY">Guyana</li>
                                    <li class="dropdown-item" data-value="HT">Haiti</li>
                                    <li class="dropdown-item" data-value="HM">Heard Island and Mcdonald Islands</li>
                                    <li class="dropdown-item" data-value="VA">Holy See (Vatican City State)</li>
                                    <li class="dropdown-item" data-value="HN">Honduras</li>
                                    <li class="dropdown-item" data-value="HK">Hong Kong</li>
                                    <li class="dropdown-item" data-value="HU">Hungary</li>
                                    <li class="dropdown-item" data-value="IS">Iceland</li>
                                    <li class="dropdown-item" data-value="IN">India</li>
                                    <li class="dropdown-item" data-value="ID">Indonesia</li>
                                    <li class="dropdown-item" data-value="IR">Iran, Islamic Republic of</li>
                                    <li class="dropdown-item" data-value="IQ">Iraq</li>
                                    <li class="dropdown-item" data-value="IE">Ireland</li>
                                    <li class="dropdown-item" data-value="IM">Isle of Man</li>
                                    <li class="dropdown-item" data-value="IL">Israel</li>
                                    <li class="dropdown-item" data-value="IT">Italy</li>
                                    <li class="dropdown-item" data-value="JM">Jamaica</li>
                                    <li class="dropdown-item" data-value="JP">Japan</li>
                                    <li class="dropdown-item" data-value="JE">Jersey</li>
                                    <li class="dropdown-item" data-value="JO">Jordan</li>
                                    <li class="dropdown-item" data-value="KZ">Kazakhstan</li>
                                    <li class="dropdown-item" data-value="KE">Kenya</li>
                                    <li class="dropdown-item" data-value="KI">Kiribati</li>
                                    <li class="dropdown-item" data-value="KP">Korea, Democratic People's Republic of</li>
                                    <li class="dropdown-item" data-value="KR">Korea, Republic of</li>
                                    <li class="dropdown-item" data-value="KW">Kuwait</li>
                                    <li class="dropdown-item" data-value="KG">Kyrgyzstan</li>
                                    <li class="dropdown-item" data-value="LA">Lao People's Democratic Republic</li>
                                    <li class="dropdown-item" data-value="LV">Latvia</li>
                                    <li class="dropdown-item" data-value="LB">Lebanon</li>
                                    <li class="dropdown-item" data-value="LS">Lesotho</li>
                                    <li class="dropdown-item" data-value="LR">Liberia</li>
                                    <li class="dropdown-item" data-value="LY">Libyan Arab Jamahiriya</li>
                                    <li class="dropdown-item" data-value="LI">Liechtenstein</li>
                                    <li class="dropdown-item" data-value="LT">Lithuania</li>
                                    <li class="dropdown-item" data-value="LU">Luxembourg</li>
                                    <li class="dropdown-item" data-value="MO">Macao</li>
                                    <li class="dropdown-item" data-value="MK">Macedonia, The Former Yugoslav Republic of</li>
                                    <li class="dropdown-item" data-value="MG">Madagascar</li>
                                    <li class="dropdown-item" data-value="MW">Malawi</li>
                                    <li class="dropdown-item" data-value="MY">Malaysia</li>
                                    <li class="dropdown-item" data-value="MV">Maldives</li>
                                    <li class="dropdown-item" data-value="ML">Mali</li>
                                    <li class="dropdown-item" data-value="MT">Malta</li>
                                    <li class="dropdown-item" data-value="MH">Marshall Islands</li>
                                    <li class="dropdown-item" data-value="MQ">Martinique</li>
                                    <li class="dropdown-item" data-value="MR">Mauritania</li>
                                    <li class="dropdown-item" data-value="MU">Mauritius</li>
                                    <li class="dropdown-item" data-value="YT">Mayotte</li>
                                    <li class="dropdown-item" data-value="MX">Mexico</li>
                                    <li class="dropdown-item" data-value="FM">Micronesia, Federated States of</li>
                                    <li class="dropdown-item" data-value="MD">Moldova, Republic of</li>
                                    <li class="dropdown-item" data-value="MC">Monaco</li>
                                    <li class="dropdown-item" data-value="MN">Mongolia</li>
                                    <li class="dropdown-item" data-value="ME">Montenegro</li>
                                    <li class="dropdown-item" data-value="MS">Montserrat</li>
                                    <li class="dropdown-item" data-value="MA">Morocco</li>
                                    <li class="dropdown-item" data-value="MZ">Mozambique</li>
                                    <li class="dropdown-item" data-value="MM">Myanmar</li>
                                    <li class="dropdown-item" data-value="NA">Namibia</li>
                                    <li class="dropdown-item" data-value="NR">Nauru</li>
                                    <li class="dropdown-item" data-value="NP">Nepal</li>
                                    <li class="dropdown-item" data-value="NL">Netherlands</li>
                                    <li class="dropdown-item" data-value="AN">Netherlands Antilles</li>
                                    <li class="dropdown-item" data-value="NC">New Caledonia</li>
                                    <li class="dropdown-item" data-value="NZ">New Zealand</li>
                                    <li class="dropdown-item" data-value="NI">Nicaragua</li>
                                    <li class="dropdown-item" data-value="NE">Niger</li>
                                    <li class="dropdown-item" data-value="NG">Nigeria</li>
                                    <li class="dropdown-item" data-value="NU">Niue</li>
                                    <li class="dropdown-item" data-value="NF">Norfolk Island</li>
                                    <li class="dropdown-item" data-value="MP">Northern Mariana Islands</li>
                                    <li class="dropdown-item" data-value="NO">Norway</li>
                                    <li class="dropdown-item" data-value="OM">Oman</li>
                                    <li class="dropdown-item" data-value="PK">Pakistan</li>
                                    <li class="dropdown-item" data-value="PW">Palau</li>
                                    <li class="dropdown-item" data-value="PS">Palestinian Territory, Occupied</li>
                                    <li class="dropdown-item" data-value="PA">Panama</li>
                                    <li class="dropdown-item" data-value="PG">Papua New Guinea</li>
                                    <li class="dropdown-item" data-value="PY">Paraguay</li>
                                    <li class="dropdown-item" data-value="PE">Peru</li>
                                    <li class="dropdown-item" data-value="PH">Philippines</li>
                                    <li class="dropdown-item" data-value="PN">Pitcairn</li>
                                    <li class="dropdown-item" data-value="PL">Poland</li>
                                    <li class="dropdown-item" data-value="PT">Portugal</li>
                                    <li class="dropdown-item" data-value="PR">Puerto Rico</li>
                                    <li class="dropdown-item" data-value="QA">Qatar</li>
                                    <li class="dropdown-item" data-value="RE">Reunion</li>
                                    <li class="dropdown-item" data-value="RO">Romania</li>
                                    <li class="dropdown-item" data-value="RU">Russian Federation</li>
                                    <li class="dropdown-item" data-value="RW">Rwanda</li>
                                    <li class="dropdown-item" data-value="SH">Saint Helena</li>
                                    <li class="dropdown-item" data-value="KN">Saint Kitts and Nevis</li>
                                    <li class="dropdown-item" data-value="LC">Saint Lucia</li>
                                    <li class="dropdown-item" data-value="PM">Saint Pierre and Miquelon</li>
                                    <li class="dropdown-item" data-value="VC">Saint Vincent and The Grenadines</li>
                                    <li class="dropdown-item" data-value="WS">Samoa</li>
                                    <li class="dropdown-item" data-value="SM">San Marino</li>
                                    <li class="dropdown-item" data-value="ST">Sao Tome and Principe</li>
                                    <li class="dropdown-item" data-value="SA">Saudi Arabia</li>
                                    <li class="dropdown-item" data-value="SN">Senegal</li>
                                    <li class="dropdown-item" data-value="RS">Serbia</li>
                                    <li class="dropdown-item" data-value="SC">Seychelles</li>
                                    <li class="dropdown-item" data-value="SL">Sierra Leone</li>
                                    <li class="dropdown-item" data-value="SG">Singapore</li>
                                    <li class="dropdown-item" data-value="SK">Slovakia</li>
                                    <li class="dropdown-item" data-value="SI">Slovenia</li>
                                    <li class="dropdown-item" data-value="SB">Solomon Islands</li>
                                    <li class="dropdown-item" data-value="SO">Somalia</li>
                                    <li class="dropdown-item" data-value="ZA">South Africa</li>
                                    <li class="dropdown-item" data-value="GS">South Georgia and The South Sandwich Islands</li>
                                    <li class="dropdown-item" data-value="ES">Spain</li>
                                    <li class="dropdown-item" data-value="LK">Sri Lanka</li>
                                    <li class="dropdown-item" data-value="SD">Sudan</li>
                                    <li class="dropdown-item" data-value="SR">Suriname</li>
                                    <li class="dropdown-item" data-value="SJ">Svalbard and Jan Mayen</li>
                                    <li class="dropdown-item" data-value="SZ">Swaziland</li>
                                    <li class="dropdown-item" data-value="SE">Sweden</li>
                                    <li class="dropdown-item" data-value="CH">Switzerland</li>
                                    <li class="dropdown-item" data-value="SY">Syrian Arab Republic</li>
                                    <li class="dropdown-item" data-value="TW">Taiwan, Province of China</li>
                                    <li class="dropdown-item" data-value="TJ">Tajikistan</li>
                                    <li class="dropdown-item" data-value="TZ">Tanzania, United Republic of</li>
                                    <li class="dropdown-item" data-value="TH">Thailand</li>
                                    <li class="dropdown-item" data-value="TL">Timor-leste</li>
                                    <li class="dropdown-item" data-value="TG">Togo</li>
                                    <li class="dropdown-item" data-value="TK">Tokelau</li>
                                    <li class="dropdown-item" data-value="TO">Tonga</li>
                                    <li class="dropdown-item" data-value="TT">Trinidad and Tobago</li>
                                    <li class="dropdown-item" data-value="TN">Tunisia</li>
                                    <li class="dropdown-item" data-value="TR">Turkey</li>
                                    <li class="dropdown-item" data-value="TM">Turkmenistan</li>
                                    <li class="dropdown-item" data-value="TC">Turks and Caicos Islands</li>
                                    <li class="dropdown-item" data-value="TV">Tuvalu</li>
                                    <li class="dropdown-item" data-value="UG">Uganda</li>
                                    <li class="dropdown-item" data-value="UA">Ukraine</li>
                                    <li class="dropdown-item" data-value="AE">United Arab Emirates</li>
                                    <li class="dropdown-item" data-value="GB">United Kingdom</li>
                                    <li class="dropdown-item" data-value="US">United States</li>
                                    <li class="dropdown-item" data-value="UM">United States Minor Outlying Islands</li>
                                    <li class="dropdown-item" data-value="UY">Uruguay</li>
                                    <li class="dropdown-item" data-value="UZ">Uzbekistan</li>
                                    <li class="dropdown-item" data-value="VU">Vanuatu</li>
                                    <li class="dropdown-item" data-value="VE">Venezuela</li>
                                    <li class="dropdown-item" data-value="VN">Viet Nam</li>
                                    <li class="dropdown-item" data-value="VG">Virgin Islands, British</li>
                                    <li class="dropdown-item" data-value="VI">Virgin Islands, U.S.</li>
                                    <li class="dropdown-item" data-value="WF">Wallis and Futuna</li>
                                    <li class="dropdown-item" data-value="EH">Western Sahara</li>
                                    <li class="dropdown-item" data-value="YE">Yemen</li>
                                    <li class="dropdown-item" data-value="ZM">Zambia</li>
                                    <li class="dropdown-item" data-value="ZW">Zimbabwe</li>
                                </ul><br><br>
                            </div>
                        </div>

                        <button type="button" id="submit-post" style="padding: 10px 20px;">Save Post</button>
                        <button type="button" id="close-popup" style="padding: 10px 20px; background-color: red; color: white; border: none;">Cancel</button>
                    </form>
                </div>
            </div>

            <?php get_footer(); ?>