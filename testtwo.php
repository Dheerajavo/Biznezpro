<?php /* Template Name:Nodone-child*/ ?>
<?php get_header(); ?>
<!-- main content area start -->
<div class="main-content-area">
    <div class="home-page">
        <div class="node-header">

            <style>
                a#node-button {
                    padding: 5px 20px;
                    border: 1px solid #F5F5F5;
                    font-size: 14px;
                    border-radius: 40px;
                    text-transform: capitalize;
                    display: block;
                    background: var(--theme1);
                    color: #fff;
                    font-weight: 700;
                }

                .node-options {
                    display: flex;
                    gap: 10px;
                }

                .node-shape {
                    cursor: pointer;
                    /* width: 50px;
                    height: 50px; */
                }

                .node-child-box {
                    border: 2px dashed #ccc;
                    padding: 20px;
                    min-height: 100vh;
                    min-width: 100%;
                    position: relative;
                    overflow: auto;
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
                    /* Ensure nodes can stack on top of each other */
                }

                .circle-node {
                    width: 150px;
                    height: 150px;
                }

                .rectangle-node {
                    width: 250px;
                    height: 150px;
                }

                .circle-node {
                    width: 150px;
                    height: 150px;
                    border-radius: 50%;
                    background-color: white;
                    border: 2px solid #000;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    position: absolute;
                    text-align: center;
                    /* overflow: hidden; */
                    background-size: cover;
                    background-position: center;
                }

                .rectangle-node {
                    width: 250px;
                    height: 150px;
                    background-color: white;
                    border: 2px solid #000;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    position: absolute;
                    text-align: center;
                    /* overflow: hidden; */
                    background-size: cover;
                    background-position: center;
                }

                /* Optionally hide SVG for rectangle if not used */
                .rectangle-node svg {
                    display: none;
                }

                .node-text {
                    color: black;
                    font-size: 16px;
                    font-weight: bold;
                    text-shadow: none;
                }

                .line-container {
                    position: absolute;
                    top: 0;
                    left: 0;
                    min-height: 100vh;
                    width: 100vw;
                    height: 100%;
                    z-index: 1;
                }

                .node-shape-group.selectdragging {
                    cursor: move;
                }

                button#clear-button {
                    position: absolute;
                    margin: 20px;
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

                .resize-handle {
                    position: absolute;
                    /* background: rgba(0, 0, 0, 0.5); */
                    width: 18px;
                    height: 10px;
                }

                .resize-handle-bottom {
                    bottom: 0;
                    cursor: nwse-resize;
                }

                .resize-handle-right {
                    right: 0;
                    top: 50%;
                    cursor: ew-resize;
                }

                .resize-handle-top {
                    top: 0;
                    cursor: ns-resize;
                }

                .resize-handle-left {
                    left: 0;
                    top: 50%;
                    cursor: ew-resize;
                }
            </style>
            <?php
$category_name = isset($_POST['category_name']) ? sanitize_text_field($_POST['category_name']) : 'Node Childs';
$image_src = isset($_POST['image_src']) ? sanitize_text_field($_POST['image_src']) : 'image_src Childs';
?>

<script>
    jQuery(document).ready(function($) {
        let selectedNode;
        let originalText, originalImage;
        var categoryName = <?php echo json_encode($category_name); ?>;
        var imageSrc = <?php echo json_encode($image_src); ?>; // Pass the base64 image to JS

        // Show shape options when "Add Node" button is clicked
        $('#node-button').click(function(e) {
            e.preventDefault();
            $('#node-options').slideToggle();
        });

        // Handle drag-and-drop for shapes
        $('.node-shape').on('dragstart', function(e) {
            let shapeType = $(this).attr('id');
            e.originalEvent.dataTransfer.setData('shape', shapeType);
        });

        // Handle drop area
        $('#drop-area').on('dragover', function(e) {
            e.preventDefault();
        });

        $('#drop-area').on('drop', function(e) {
            e.preventDefault();

            let shapeType = e.originalEvent.dataTransfer.getData('shape');
            let dropAreaOffset = $(this).offset();
            let dropAreaWidth = $(this).width();
            let dropAreaHeight = $(this).height();
            let shapeDimensions = {
                'circle-node': {
                    width: 150,
                    height: 150
                },
                'rectangle-node': {
                    width: 250,
                    height: 150
                }
            };

            let {
                width,
                height
            } = shapeDimensions[shapeType];

            // Calculate the center position of the drop area
            let centerX = dropAreaWidth / 2;
            let centerY = dropAreaHeight / 2;

            // Calculate the top-left position for centering the shape
            let x = centerX - width / 2;
            let y = centerY - height / 2;

            addNodeToDrawFlow(shapeType, x, y);

            toggleNodeButtonVisibility();
        });
        $('#generate-circles').on('click', function(e) {
            e.preventDefault();

            // Get the number of outer circles from the input
            let numCircles = parseInt($('#numCircles').val());
            let shapeType = 'circle-node'; // or 'rectangle-node' depending on the shape
            let x = 400; // Central X position
            let y = 300; // Central Y position

            // Clear existing nodes
            $('#drop-area .line-container').empty();

            // Call the function to add the nodes based on the input value
            addNodeToDrawFlow(shapeType, x, y, numCircles);
        });

        function addNodeToDrawFlow(shape, x, y, numCircles) {
            let shapeDimensions = {
                'circle-node': {
                    width: 150,
                    height: 150,
                    background: '<?php echo home_url(); ?>/wp-content/uploads/2024/08/no-image-default.png', // Use base64 image
                    text: categoryName
                },
                'rectangle-node': {
                    width: 250,
                    height: 150,
                    background: '<?php echo home_url(); ?>/wp-content/uploads/2024/08/no-image-default.png', // Use base64 image
                    text: categoryName
                }
            };

            let {
                width,
                height,
                background,
                text
            } = shapeDimensions[shape];

            // Set specific dimensions for the central node
            let centralNodeWidth = 250;
            let centralNodeHeight = 250;
            let radius = centralNodeWidth / 2;
            let distance = 150;

            // Create the central node with specific dimensions
            let centralNode = `<div class="drawflow-node ${shape}" style="left: ${x - radius}px; top: ${y - centralNodeHeight / 2}px; width: ${centralNodeWidth}px; height: ${centralNodeHeight}px; background-image:url(${imageSrc}); background-size: cover;">
                <div class="node-text">${text}</div>
            </div>`;

            $('#drop-area .line-container').append(centralNode);

            let positions = [
                // Left
                {
                    x: x - distance - centralNodeWidth / 2,
                    y: y
                },
                // Right
                {
                    x: x + distance + centralNodeWidth / 2,
                    y: y
                },
                // Top
                {
                    x: x,
                    y: y - distance - centralNodeHeight / 2
                },
                // Bottom
                {
                    x: x,
                    y: y + distance + centralNodeHeight / 2
                }
            ];

            positions.forEach((pos) => {
                let surroundingNode = `<div class="node-child drawflow-node ${shape}" style="left: ${pos.x - width / 2}px; top: ${pos.y - height / 2}px; width: ${width}px; height: ${height}px; background-image: url(${background}); background-size: cover;">
                <div class="add-node-btns" data-bs-target="#exampleModalToggle" data-bs-toggle="modal"><i class="ri-edit-box-line"></i></div>
                <div class="node-text">${text}</div>

                <div class="resize-handle resize-handle-top"></div>
                <div class="resize-handle resize-handle-right"></div>
                <div class="resize-handle resize-handle-bottom"></div>
                <div class="resize-handle resize-handle-left"></div>
                </div>`;
                $('#drop-area .line-container').append(surroundingNode);

                $('#drop-area .line-container').append(`<svg width="100%" height="100%" style="position:absolute; ">
                <line x1="${x}" y1="${y}" x2="${pos.x}" y2="${pos.y}" stroke="black" stroke-width="2" />
            </svg>`);
            });
      

                        // Handle node editing
                        $('.node-child .add-node-btns').click(function() {
                            $currentNodeChild = $(this).closest('.node-child');

                            // Retrieve the background image URL from the .node-child element
                            const bgImage = $currentNodeChild.css('background-image');
                            const text = $currentNodeChild.find('.node-text').text();

                            // Extract the URL from the background-image property
                            const imgSrc = bgImage ? bgImage.replace(/^url\(["']?/, '').replace(/["']?\)$/, '') : '';

                            if (imgSrc) {
                                $('#addimage').val(''); // Clear any previous image selection
                                $('#addimage').data('imgSrc', imgSrc); // Store existing image URL in data attribute
                            }
                            $('#addtext').val(text);
                        });
                    }
                    $('#submit-addons button').click(function() {

                        const imageFile = $('#addimage')[0].files[0];
                        const newText = $('#addtext').val().trim();
                        const currentText = $currentNodeChild.find('.node-text').text().trim();

                        // Use previously stored image URL if no new image is selected
                        const storedImgSrc = $('#addimage').data('imgSrc');
                        const currentBgImage = $currentNodeChild.css('background-image');

                        // Extract the URL from the current background-image property
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
                            } else {
                                // If no new image is selected, use the stored image URL
                                if (storedImgSrc) {
                                    $currentNodeChild.css('background-image', `url(${storedImgSrc})`);
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




                    // Make line-container draggable
                    let startX, startY, startWidth, startHeight, startLeft, startTop, handle;
                    let $resizing, isResizing = false,
                        isDragging = false;

                    // Resizing functionality
                    $(document).on('mousedown', '.resize-handdle', function(e) {
                        e.preventDefault();
                        handle = $(this).attr('class');
                        $resizing = $(this).closest('.node-child');

                        startX = e.pageX;
                        startY = e.pageY;
                        startWidth = parseInt($resizing.css('width'), 10);
                        startHeight = parseInt($resizing.css('height'), 10);
                        startLeft = parseInt($resizing.css('left'), 10);
                        startTop = parseInt($resizing.css('top'), 10);

                        isResizing = true;

                        $(document).on('mousemove', resize);
                        $(document).on('mouseup', stopResize);
                    });

                    function resize(e) {
                        if (!isResizing) return;

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
                        isResizing = false;
                        $(document).off('mousemove', resize);
                        $(document).off('mouseup', stopResize);
                    }

                    // Dragging functionality
                    $(document).on('mousedown', '.node-shape-group', function(e) {
                        if (isResizing) return; // Prevent dragging while resizing

                        e.preventDefault();
                        startX = e.pageX;
                        startY = e.pageY;
                        startLeft = $(this).position().left;
                        startTop = $(this).position().top;

                        $(this).addClass('selectdragging');
                        isDragging = true;

                        $(document).on('mousemove', drag);
                        $(document).on('mouseup', stopDrag);
                    });

                    function drag(e) {
                        if (!isDragging) return;

                        let dx = e.pageX - startX;
                        let dy = e.pageY - startY;
                        $('.node-shape-group.selectdragging').css({
                            'left': startLeft + dx,
                            'top': startTop + dy,
                            'position': 'absolute'
                        });
                    }

                    function stopDrag() {
                        isDragging = false;
                        $('.node-shape-group').removeClass('selectdragging');
                        $(document).off('mousemove', drag);
                        $(document).off('mouseup', stopDrag);
                    }



                    $('#clear-nodes').click(function() {
                        $('#drop-area .line-container').empty();
                        toggleNodeButtonVisibility();
                    });

                    function toggleNodeButtonVisibility() {
                        if ($('#drop-area .line-container').children().length > 0) {
                            $('ul.node-shapes #node-button, ul.node-shapes #node-options').hide();
                        } else {
                            $('ul.node-shapes #node-button, ul.node-shapes #node-options').show();
                        }
                    }

                    toggleNodeButtonVisibility();
                });
            </script>



            <nav class="node-nav">
                <ul class="node-shapes">
                    <li>
                        <a type="button" id="node-button">node <i class="ri-add-large-line"></i></a>
                    </li>
                    <div class="node-options" id="node-options" style="display: none;">
                        <div id="circle-node" class="node-shape" draggable="true">
                            <svg width="50" height="50">
                                <circle cx="25" cy="25" r="23.5" fill="none" stroke="black" stroke-width="1" />
                            </svg>
                        </div>
                        <div id="rectangle-node" class="node-shape" draggable="true">
                            <svg width="80" height="50">
                                <rect width="80" height="50" fill="none" stroke="black" stroke-width="2" />
                            </svg>
                        </div>
                    </div>
                    <div>
                        <label for="numCircles">Number of outer circles:</label>
                        <input type="number" id="numCircles" value="4" min="1" max="20" />
                        <button id="generate-circles">Generate</button>
                    </div>
                    <li>
                        <?php $category_name = isset($_POST['category_name']) ? sanitize_text_field($_POST['category_name']) : '';
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
                <div class="line-container " id="line-container ">
                    <!-- Existing node-child elements will be added here dynamically -->

                </div>
            </div>

        </div>
    </div>
</div>
<!-- add node popup start  -->
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
                <div class="submit-addons" id="submit-addons">
                    <button type="submit">Submit</button>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- add node popup end  -->


<script>
    jQuery(document).ready(function($) {
        $('#save-node-child-data-button').on('click', function(e) {
            e.preventDefault();

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
                };
                nodeChildGroupData.push(nodeGroupData);
            });

            // Array to hold child node data
            let childNodes = [];
            $('.line-container .drawflow-node').each(function() {
                let $node = $(this);
                // Get classes after 'drawflow-node'
                let nodeClass = $node.attr('class').split(' ');
                let index = nodeClass.indexOf('drawflow-node');
                let afterClasses = nodeClass.slice(index + 1);

                let bgImageUrl = $node.css('background-image');
                let urlMatch = bgImageUrl.match(/url\(["']?(.*?)["']?\)/);
                let imageUrl = urlMatch ? urlMatch[1] : ''
                let nodeChildData = {
                    element_bgimage_url: imageUrl,
                    element_text: $node.find('.node-text').text(),
                    node_class: afterClasses,
                    element_left: $node.css('left'),
                    element_top: $node.css('top'),
                    element_height: $node.css('height'),
                    element_width: $node.css('width'),
                };
                childNodes.push(nodeChildData);
            });

            // Array to hold SVG line data
            let svgData = [];
            $('.line-container svg line').each(function() {
                let $svgline = $(this);

                let x1 = $svgline.attr('x1');
                let y1 = $svgline.attr('y1');
                let x2 = $svgline.attr('x2');
                let y2 = $svgline.attr('y2');

                svgData.push({
                    x1: x1,
                    y1: y1,
                    x2: x2,
                    y2: y2
                });
            });


            let ajaxData = {
                action: 'save_child_node_data',
                nonce: my_ajax_object.nonce, // Ensure this nonce is correct
                // company_name: companyName,
                nodeGroupData: nodeChildGroupData,
                nodeChildData: childNodes,
                lineData: svgData
            };
            // Optional: Send data to server via AJAX
            $.ajax({
                url: my_ajax_object.ajax_url, // replace with your server URL
                type: 'POST',
                data: ajaxData,
                success: function(response) {
                    // Handle successful response
                    alert('Node data saved successfully!');
                    console.log('Response:', response); // Debug: Output response
                },
                error: function(xhr, status, error) {
                    // Handle error response
                    alert('An error occurred while saving node data.');
                    console.log('Error:', error); // Debug: Output error
                }
            });
        });
    });
</script>




<?php get_footer(); ?>