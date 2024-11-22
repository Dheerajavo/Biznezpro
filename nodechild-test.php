<?php /* Template Name: Node Child Test Page */ ?>
<?php get_header(); ?>
<!-- main content area start -->
<div class="main-content-area">
    <div class="home-page">
        <div class="node-header">

            <style>
                .node-options {
                    display: flex;
                    gap: 10px;
                }

                .node-shape {
                    cursor: pointer;
                    width: 50px;
                    height: 50px;
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


            </style>
            <script>
                jQuery(document).ready(function($) {
                    let selectedNode; // Declare the variable globally to be used in different functions
                    let originalText, originalImage; // Variables to hold the original values



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
                        let offsetX = e.originalEvent.offsetX;
                        let offsetY = e.originalEvent.offsetY;

                        addNodeToDrawFlow(shapeType, offsetX, offsetY);
                    });

                    function addNodeToDrawFlow(shape, x, y) {
                        let shapeDimensions = {
                            'circle-node': {
                                width: 150,
                                height: 150,
                                background: 'none',
                                text: 'Text'
                            },
                            'rectangle-node': {
                                width: 250,
                                height: 150,
                                background: 'none',
                                text: 'Text'
                            }
                        };

                        let {
                            width,
                            height,
                            background,
                            text
                        } = shapeDimensions[shape];
                        let radius = width / 2;
                        let distance = 150; // Adjust distance as needed

                        // Create the central node
                        let centralNode = `<div class="drawflow-node ${shape}" style="left: ${x - radius}px; top: ${y - height / 2}px; width: ${width}px; height: ${height}px; background-image: ${background}; background-size: cover;">
                <div class="node-text">${text}</div>
            </div>`;

                        $('#drop-area .line-container').append(centralNode);


                        // Define positions for surrounding nodes
                        let positions = [{
                                x: x - distance - width / 2,
                                y: y
                            }, // Left
                            {
                                x: x + distance + width / 2,
                                y: y
                            }, // Right
                            {
                                x: x,
                                y: y - distance - height / 2
                            }, // Top
                            {
                                x: x,
                                y: y + distance + height / 2
                            } // Bottom
                            {
                                x: x,
                                y: y + distance + height / 2
                            } // Bottom
                            {
                                x: x,
                                y: y + distance + height / 2
                            } // Bottom
                            {
                                x: x,
                                y: y + distance + height / 2
                            } // Bottom
                            {
                                x: x,
                                y: y + distance + height / 2
                            } // Bottom
                            {
                                x: x,
                                y: y + distance + height / 2
                            } // Bottom
                        ];

                        // Create and connect surrounding nodes
                        positions.forEach((pos) => {
                            let surroundingNode = `
                <div class="node-child drawflow-node ${shape}" style="left: ${pos.x - width / 2}px; top: ${pos.y - height / 2}px; width: ${width}px; height: ${height}px; background-image: ${background}; background-size: cover;">
                    <div class="add-node-btns" data-bs-target="#exampleModalToggle" data-bs-toggle="modal"><i class="ri-edit-box-line"></i></div>
                    <div class="node-text">${text}</div>
                </div>`;
                            $('#drop-area .line-container').append(surroundingNode);

                            // Draw lines to connect central shape with surrounding shapes
                            $('#drop-area .line-container').append(`<svg width="100%" height="100%" style="position:absolute; left:0; top:0;">
                    <line x1="${x}" y1="${y}" x2="${pos.x}" y2="${pos.y}" stroke="black" stroke-width="2" />
                </svg>`);
                        });


                        // Reinitialize drag-and-drop for newly added nodes
                        $('.drawflow-node-group').draggable({
                            containment: "#drop-area",
                            stop: function(event, ui) {
                                let draggedNode = $(this);
                                let newLeft = ui.position.left;
                                let newTop = ui.position.top;
                                draggedNode.css({
                                    left: newLeft,
                                    top: newTop,
                                    width: draggedNode.width() + 'px',
                                    height: draggedNode.height() + 'px'
                                });
                            }
                        });


                        // Attach click event to open the modal and edit the node
                        $('.node-child .add-node-btns').click(function() {
                            selectedNode = $(this).closest('.node-child');
                            originalText = selectedNode.find('.node-text').text();
                            originalImage = selectedNode.css('background-image').replace('url("', '').replace('")', ''); // Get the current background image URL

                            $('#addtext').val(originalText);
                            $('#addimage').val(''); // Clear the file input

                            // Handle image preview
                            if (originalImage && originalImage !== 'none') {
                                $('#addimage').after(`<img src="${originalImage}" alt="Current Image" style="max-width: 100px; margin-top: 10px;">`);
                            }
                        });
                    }


                    // Handle modal submit
                    $('#submit-addons button').click(function() {
                        if (selectedNode) {
                            let newText = $('#addtext').val();
                            let newImage = $('#addimage')[0].files[0]; // Handle image file

                            let changesDetected = false;

                            if (newText !== originalText) {
                                selectedNode.find('.node-text').text(newText);
                                changesDetected = true;
                            }

                            if (newImage) {
                                let reader = new FileReader();
                                reader.onload = function(e) {
                                    selectedNode.css('background-image', `url(${e.target.result})`);
                                    changesDetected = true;
                                };
                                reader.readAsDataURL(newImage);
                            }

                            if (!changesDetected) {
                                // Show SweetAlert notification for no changes
                                Swal.fire({
                                    icon: 'info',
                                    title: 'No Changes Detected',
                                    // text: 'You have not made any changes to the node.',
                                    confirmButtonText: 'OK'
                                });
                            } else {
                                // Hide the modal
                                $('#exampleModalToggle').modal('hide');
                            }
                        } else {
                            Swal.fire({
                                title: 'Error',
                                text: 'No node selected for editing.',
                                icon: 'error',
                                confirmButtonText: 'OK'
                            });

                        }
                    });

                    $('#clear-nodes').click(function() {
                        $('#drop-area .line-container').empty();
                         // Removes all child elements from the line container
                    });

                });
            </script>



            <nav class="node-nav">
                <ul>
                    <li>
                        <a type="button" id="node-button">node <i class="ri-add-large-line"></i></a>
                    </li>
                    <div class="node-options" id="node-options" style="display: none;">
                        <div id="circle-node" class="node-shape" draggable="true">
                            <svg width="50" height="50">
                                <circle cx="25" cy="25" r="20" fill="none" stroke="black" stroke-width="2" />
                            </svg>
                        </div>
                        <div id="rectangle-node" class="node-shape" draggable="true">
                            <svg width="50" height="50">
                                <rect width="50" height="30" fill="none" stroke="black" stroke-width="2" />
                            </svg>
                        </div>
                    </div>
                </ul>
                <a href="#" class="primary-btn">publish</a>
            </nav>
        </div>
        <style>


        </style>
        <div class="btn-clear" id="clear-nodes">Clear</div>
        <div class="add-node node-child-box" id="drop-area">

            <div class="drawflow-node-group">
                <div class="line-container">
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

<!-- Include jQuery UI CSS -->
<!-- <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css"> -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

<!-- Include jQuery UI JS -->
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<?php get_footer(); ?>