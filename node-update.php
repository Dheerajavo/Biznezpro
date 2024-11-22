<?php /* Template Name:Node_update */ ?>
<?php get_header(); ?>

<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $company_name = isset($_POST['company_name']) ? $_POST['company_name'] : 'Not Provided';
    $raw_node_data = isset($_POST['node_data']) ? $_POST['node_data'] : 'Not Provided';
    $raw_svg_data = isset($_POST['svg_data']) ? $_POST['svg_data'] : 'Not Provided';


    // Decode JSON data
    $noder_data =  json_decode(str_replace('\\"', '"', $raw_node_data));


    // Decode JSON data
    $nodes_data = json_decode(stripslashes($raw_node_data), true);
    //    echo  $node_data[0]['company_name'] . '<br>';
    //    echo  $node_data[0]['company_logo'] . '<br>';
    //        echo  $node_data[0]['element_image_url'] . '<br>';

}

global $wpdb;
$table_name = $wpdb->prefix . 'node_data';

// Fetch node data for the provided company name
$nodes = $wpdb->get_results(
    $wpdb->prepare("SELECT * FROM $table_name WHERE company_name = %s", $company_name)
);

if (!empty($nodes)) {
    // Assuming you want to retrieve data from the first matched record
    // $noddde_data = json_decode($nodes[0]->node_data, true); // Decode JSON if needed
    $node_data = maybe_unserialize($nodes[0]->node_data); // Decode JSON if needed

    // Extract and sanitize node data
    foreach ($node_data as $node) {
        $company_logo = esc_url($node['company_logo']);
        $element_image_url = esc_url($node['element_image_url']);
        $element_text = esc_html($node['element_text']);
        $element_text_url = esc_url($node['element_text_url']);
        $element_top = esc_attr($node['element_top']);
        $element_left = esc_attr($node['element_left']);
        $element_height = esc_attr($node['element_height']);
        $element_width = esc_attr($node['element_width']);

        // Do something with the extracted data
        // echo 'Company Logo: ' . $company_logo . '<br>';
        // echo 'Element Image URL: ' . $element_image_url . '<br>';
        // echo 'Element Text: ' . $element_text . '<br>';
        // echo 'Element Text URL: ' . $element_text_url . '<br>';
        // echo 'Element Top: ' . $element_top . '<br>';
        // echo 'Element Left: ' . $element_left . '<br>';
        // echo 'Element Height: ' . $element_height . '<br>';
        // echo 'Element Width: ' . $element_width . '<br>';
    }
}

$svg_data = maybe_unserialize($nodes[0]->svg_data);  // Unserialize if needed

if (!empty($svg_data)) {
    foreach ($svg_data as $svg) {
        $svg_class = esc_attr($svg['svgClass']);
        foreach ($svg['pathDValues'] as $d_value) {
            $d_value = esc_attr($d_value);
            //     echo '<svg class="' . $svg_class . '"><path class="main-path" d="' . $d_value . '"></path></svg>';
        }
    }
}

?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<div class="main-content-area">
    <div class="home-page">
        <div class="node-header">
            <style>
                nav.node-nav #company-name-text input#company-name {
                    position: static;
                }

                .company-logo-img img {
                    width: 100px;
                    height: 80px;
                    padding: 0 25px 0 0
                }
            </style>
            <script>
                jQuery(document).ready(function($) {
                    // Initially show the company-logo div and hide the company-logo-img div based on the presence of an image
                    if ($('#company-logo-img #company-logo-image').attr('src')) {
                        $('#logo-container').css('display', 'none');
                        $('#company-logo-img').css('display', 'block');
                    } else {
                        $('#logo-container').css('display', 'block');
                        $('#company-logo-img').css('display', 'none');
                    }

                    // Handle the change event for the file input
                    $('#company-logo').on('change', function(event) {
                        var file = event.target.files[0];

                        if (file) {
                            var reader = new FileReader();

                            reader.onload = function(e) {
                                // Set the src attribute of the img tag inside #company-logo-img
                                $('#company-logo-image').attr('src', e.target.result);
                                $('#company-logo-image').attr('alt', 'Company Logo');

                                // Show the image and hide the file input
                                $('#logo-container').css('display', 'none');
                                $('#company-logo-img').css('display', 'block');
                            };

                            reader.readAsDataURL(file);
                        }
                    });

                    // Handle the close button click event for the company logo
                    $('#close-company-logo').on('click', function() {
                        $('#company-logo-img').css('display', 'none');
                        $('#logo-container').css('display', 'block');
                        $('#company-logo').val(''); // Clear the file input
                    });
                });
            </script>
            <style>
                nav.node-nav li span {
                    padding: 5px 20px;
                    border: 1px solid #F5F5F5;
                    font-size: 14px;
                    border-radius: 40px;
                    text-transform: capitalize;
                    display: block;
                    background: var(--theme1);
                    color: #fff;
                }

                .add-node {
                    padding: 0px;
                    align-items: unset;
                    max-width: 100%;

                }



                button#close-company-logo {
                    position: absolute;
                    right: 0;
                    z-index: 1;
                    opacity: 1;
                    background-size: 10px;
                    border: 1px solid #F5F5F5;
                    border-radius: 40px;
                    background: var(--theme1);
                    color: #fff;
                    display: inline-flex;
                    align-items: center;
                    justify-content: center;
                    background-image: none;
                }

                button#close-company-name {
                    position: absolute;
                    right: 0;
                    top: 0;
                    z-index: 1;
                    opacity: 1;
                    background-size: 10px;
                    border: 1px solid #F5F5F5;
                    border-radius: 40px;
                    background: var(--theme1);
                    color: #fff;
                    display: inline-flex;
                    align-items: center;
                    justify-content: center;
                    background-image: none;
                }

                li.company-name-display p {
                    padding: 0 25px 0 0;
                    text-transform: uppercase;
                    font-size: 28px;
                    font-weight: 500;
                    color: var(--theme1);
                }
            </style>

            <nav class="node-nav">
                <ul>

                    <li class="drag-drawflow" draggable="true" ondragstart="drag(event)" data-node="add_node">
                        <span id="add-node-button"> add node<i class="ri-add-large-line"></i> </span>
                    </li>

                    <!-- <li>
                        <a href="#" id="add-node-button" draggable="true">add node <i class="ri-add-large-line"></i></a>
                    </li> -->
                    <li id="logo-container">

                        <label for="company-logo">add company logo <i class="ri-add-large-line"></i></label>
                        <input type="file" id="company-logo" class="input-control" accept="image/*">
                    </li>
                    <li id="company-logo-img" class="company-logo-img">

                        <img src=" <?php echo  $nodes_data[0]['company_logo']; ?>" alt="company-logo" id="company-logo-image">
                        <!-- <button id="close-company-logo">Close</button> -->
                        <button type="button" id="close-company-logo" class="btn-close" aria-label="Close"><i class="ri-close-large-line"></i></button>
                    </li>
                    <li style="display:none;" id="company-name-text">
                        <label for="company-name" class="company-name">add company name <i class="ri-add-large-line"></i></label>
                        <input type="text" id="company-name" class="input-control" placeholder="Type Here...">

                    </li>
                    <li class="company-name-display" id="company-name-display-fix">
                        <p><?php echo $company_name; ?></p>

                        <button style="display:none;" type="button" id="close-company-name" class="btn-close" aria-label="Close"><i class="ri-close-large-line"></i></button>
                    </li>
                </ul>
                <!-- <a href="#" id ="save-node-data-button" class="primary-btn">publish</a> -->

                <button id="update-node-data-button" class="primary-btn">Update</button>
            </nav>
        </div>
        <div class="add-node" id="drop-area">
            <div class="wrapper">
                <div id="drawflow" ondrop="drop(event)" ondragover="allowDrop(event)">
                    <div class="btn-clear" onclick="editor.clearModuleSelected()">Clear</div>

                    <div class="bar-zoom">
                        <i class="fas fa-search-minus" onclick="editor.zoom_out()"></i>
                        <i class="fas fa-search" onclick="editor.zoom_reset()"></i>
                        <i class="fas fa-search-plus" onclick="editor.zoom_in()"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

</main>
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

        // Modal handle
        // Handle edit button click to set the current node-child
        $('#drop-area').on('click', '.add-node-btns', function() {
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
        $('#submit-addons').on('click', function() {
            const imageFile = $('#addimage')[0].files[0];
            const text = $('#addtext').val();
            const reader = new FileReader();


            if ($currentNodeChild) {
                if (imageFile) {
                    reader.onload = function(e) {
                        const imgSrc = e.target.result;
                        $currentNodeChild.find('.node-image').attr('src', imgSrc);
                        $currentNodeChild.find('.node-text').text(text);
                    };
                    reader.readAsDataURL(imageFile);
                } else {
                    // Use previously stored image src if no new image is selected
                    const storedImgSrc = $('#addimage').data('imgSrc');
                    const a = $('#addimage').val('imgSrc');
                    alert(a);
                    if (storedImgSrc) {
                        $currentNodeChild.find('.node-image').attr('src', storedImgSrc);
                    }
                    $currentNodeChild.find('.node-text').text(text);
                }

                // Close the modal
                $('#exampleModalToggle').modal('hide');
            }
        });
    });
</script>


<style>
    .them-edit-link {
        position: absolute;
        top: 10px;
        right: 100px;
        color: black;
        font-size: 40px;
    }

    .them-edit-link a {
        text-decoration: none;
    }

    .github-link {
        position: absolute;
        top: 10px;
        right: 20px;
        color: black;
    }


    /* .wrapper {
        width: 100%;
        height: calc(100vh - 67px);
        display: flex;
        border: 2px dashed #ccc;
        min-height: 100vh;
        min-width: 100%;
        overflow: auto;
        margin-bottom: 40px;
        box-sizing: border-box;
    } */
    .wrapper {
        width: 100%;
        /* height: calc(100vh - 67px); */
        display: flex;
        border: 2px dashed #ccc;
        overflow: auto;
        /* Ensure overflow is set to auto */
        margin-bottom: 30px;
        box-sizing: border-box;
    }



    .drag-drawflow {
        /* line-height: 50px;
        border-bottom: 1px solid var(--border-color); */
        padding-left: 20px;
        cursor: move;
        user-select: none;
    }



    .btn-clear {
        float: right;
        position: absolute;
        top: 20px;
        left: 10px;
        color: white;
        background: var(--theme1);
        padding: 5px 20px;
        cursor: pointer;
        z-index: 5;
        border: 1px solid #F5F5F5;
        border-radius: 40px;
        background-size: 10px;
    }

    .swal-wide {
        width: 80% !important;
    }



    .bar-zoom {
        float: right;
        position: absolute;
        /* bottom: 10px; */
        bottom: 60px;
        right: 10px;
        display: flex;
        font-size: 24px;
        color: white;
        padding: 5px 10px;
        background: #555555;
        border-radius: 4px;
        border-right: 1px solid var(--border-color);
        z-index: 5;
    }

    .bar-zoom svg {
        cursor: pointer;
        padding-left: 10px;
    }

    .bar-zoom svg:nth-child(1) {
        padding-left: 0px;
    }

    #drawflow {
        /* position: relative; */
        width: 100%;
        height: 100%;
        /* width: calc(100vw - 301px);
        height: calc(100% - 50px); */
        /* top: 40px; */
        background: var(--background-color);
        background-size: 25px 25px;
        background-image:
            linear-gradient(to right, #f1f1f1 1px, transparent 1px),
            linear-gradient(to bottom, #f1f1f1 1px, transparent 1px);
    }



    @media only screen and (max-width: 768px) {



        #drawflow {
            width: calc(100vw - 51px);
        }
    }



    /* Editing Drawflow */
    .drawflow .drawflow-node.add_node {
        width: 250px;
        height: 150px;
        background: #ddd !important;
        box-sizing: border-box;
        padding: 0px !important;
    }

    .drawflow .drawflow-node {
        background: var(--background-color);
        border: 1px solid var(--border-color);
        -webkit-box-shadow: 0 2px 15px 2px var(--border-color);
        box-shadow: 0 2px 15px 2px var(--border-color);

    }

    /* #drop-area .drawflow-node.add_node {
    width: 500px;
} */

    .drawflow .drawflow-node .drawflow_content_node {
        height: 100%;
    }

    .drawflow_content_node .node-child {
        height: 100%;
    }

    .node-child .node-content {
        height: 100%;
    }

    .node-content img.node-image {
        height: 100%;
    }


    .drawflow .drawflow-node.selected {
        background: white;
        border: 1px solid #4ea9ff;
        -webkit-box-shadow: 0 2px 20px 2px #4ea9ff;
        box-shadow: 0 2px 20px 2px #4ea9ff;
    }

    .drawflow .drawflow-node.selected .title-box {
        color: #22598c;
        /*border-bottom: 1px solid #4ea9ff;*/
    }

    .drawflow .connection .main-path {
        stroke: #4ea9ff;
        stroke-width: 3px;
    }

    .drawflow .drawflow-node .input,
    .drawflow .drawflow-node .output {
        height: 15px;
        width: 15px;
        border: 2px solid var(--border-color);
    }

    .drawflow .drawflow-node .input:hover,
    .drawflow .drawflow-node .output:hover {
        background: #4ea9ff;
    }

    .drawflow .drawflow-node .output {
        right: 10px !important;
    }

    .drawflow .drawflow-node .input {
        left: -10px !important;
        background: white;
    }

    .parent-node .drawflow-delete {
        top: -15px;
        left: -15px;
    }

    .drawflow>.drawflow-delete {
        border: 2px solid #43b993;
        background: white;
        color: #43b993;
        -webkit-box-shadow: 0 2px 20px 2px #43b993;
        box-shadow: 0 2px 20px 2px #43b993;
    }

    .drawflow-delete {
        border: none !important;
        background: white;
        background: var(--theme1) !important;
        color: #4ea9ff;
        -webkit-box-shadow: 0 2px 20px 2px #4ea9ff;
        box-shadow: 0 2px 20px 2px #4ea9ff;
    }

    .drawflow-node .title-box {
        height: 50px;
        line-height: 50px;
        background: var(--background-box-title);
        border-bottom: 1px solid #e9e9e9;
        border-radius: 4px 4px 0px 0px;
        padding-left: 10px;
    }

    .drawflow .title-box svg {
        position: initial;
    }

    .drawflow-node .box {
        padding: 10px 20px 20px 20px;
        font-size: 14px;
        color: #555555;

    }

    .drawflow-node .box p {
        margin-top: 5px;
        margin-bottom: 5px;
    }

    .drawflow-node.welcome {
        width: 250px;
    }

    .drawflow-node.slack .title-box {
        border-radius: 4px;
    }

    .drawflow-node input,
    .drawflow-node select,
    .drawflow-node textarea {
        border-radius: 4px;
        border: 1px solid var(--border-color);
        height: 30px;
        line-height: 30px;
        font-size: 16px;
        width: 158px;
        color: #555555;
    }

    .drawflow-node textarea {
        height: 100px;
    }


    .drawflow-node.personalized {
        background: red;
        height: 200px;
        text-align: center;
        color: white;
    }

    .drawflow-node.personalized .input {
        background: yellow;
    }

    .drawflow-node.personalized .output {
        background: green;
    }

    .drawflow-node.personalized.selected {
        background: blue;
    }

    .drawflow .connection .point {
        stroke: var(--border-color);
        stroke-width: 2;
        fill: white;
        transform: translate(-9999px, -9999px);
    }

    .drawflow .connection .point.selected,
    .drawflow .connection .point:hover {
        fill: #4ea9ff;
    }
</style>






<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/drawflow/dist/drawflow.min.css">
<script src="https://cdn.jsdelivr.net/npm/drawflow/dist/drawflow.min.js"></script>


<script>
    var id = document.getElementById("drawflow");
    const editor = new Drawflow(id);
    editor.reroute = true;
    editor.drawflow = {
        "drawflow": {
            "Home": {
                "data": {
                    "1": {
                        "id": 1,
                        "name": "add_node",
                        "data": {},
                        "class": "add_node",
                        "html": `<div class="node-child">
    <div class="add-node-btns" data-bs-target="#exampleModalToggle" data-bs-toggle="modal">
        <i class="ri-edit-box-line"></i>
    </div>
    <div class="node-content">
        <img src="<?php echo $element_image_url; ?>" alt="Upload Image" class="node-image" style="width:100%; height:100%;">


        <!-- <div class="node-image-url">
                                                        <a href="<?php // echo $element_text_url;
                                                                    ?>" target="_blank"><?php // echo $element_text_url;
                                                                                        ?></a>
                                                    </div> -->
        <p class="node-text"><?php echo $element_text; ?></p>
    </div>
</div>
<div class="resize-handle resize-handle-top"></div>
<div class="resize-handle resize-handle-right"></div>
<div class="resize-handle resize-handle-bottom"></div>
<div class="resize-handle resize-handle-left"></div> `,
                        "typenode": false,
                        "inputs": {
                            "input_1": {
                                "connections": [{
                                        "node": "3",
                                        "input": "output_1"
                                    },
                                    {
                                        "node": "3",
                                        "input": "output_2"
                                    },
                                    {
                                        "node": "3",
                                        "input": "output_3"
                                    },
                                    {
                                        "node": "3",
                                        "input": "output_4"
                                    }
                                ]
                            }
                        },
                        "outputs": {
                            "output_1": {
                                "connections": [{
                                    "node": "2",
                                    "output": "input_1"
                                }]
                            }
                        },
                        "pos_x": 764,
                        "pos_y": 227
                    },
                    "2": {
                        "id": 2,
                        "name": "dbclick",
                        "data": {
                            "name": "Hello World!!"
                        },
                        "class": "dbclick",
                        "html": "\n            <div>\n            <div class=\"title-box\"><i class=\"fas fa-mouse\"></i> Db Click</div>\n              <div class=\"box dbclickbox\" ondblclick=\"showpopup(event)\">\n                Db Click here\n                <div class=\"modal\" style=\"display:none\">\n                  <div class=\"modal-content\">\n                    <span class=\"close\" onclick=\"closemodal(event)\">&times;</span>\n                    Change your variable {name} !\n                    <input type=\"text\" df-name>\n                  </div>\n\n                </div>\n              </div>\n            </div>\n            ",
                        "typenode": false,
                        "inputs": {
                            "input_1": {
                                "connections": [{
                                    "node": "1",
                                    "input": "output_1"
                                }]
                            }
                        },
                        "outputs": {
                            "output_1": {
                                "connections": [{
                                    "node": "3",
                                    "output": "input_2"
                                }]
                            }
                        },
                        "pos_x": 209,
                        "pos_y": 38
                    },
                    "3": {
                        "id": 3,
                        "name": "multiple",
                        "data": {},
                        "class": "multiple",
                        "html": "\n            <div>\n              <div class=\"box\">\n                Multiple!\n              </div>\n            </div>\n            ",
                        "typenode": false,
                        "inputs": {
                            "input_1": {
                                "connections": []
                            },
                            "input_2": {
                                "connections": [{
                                    "node": "2",
                                    "input": "output_1"
                                }]
                            },
                            "input_3": {
                                "connections": []
                            }
                        },
                        "outputs": {
                            "output_1": {
                                "connections": [{
                                    "node": "1",
                                    "output": "input_1"
                                }]
                            },
                            "output_2": {
                                "connections": [{
                                    "node": "1",
                                    "output": "input_1"
                                }]
                            },
                            "output_3": {
                                "connections": [{
                                    "node": "1",
                                    "output": "input_1"
                                }]
                            },
                            "output_4": {
                                "connections": [{
                                    "node": "1",
                                    "output": "input_1"
                                }]
                            }
                        },
                        "pos_x": 179,
                        "pos_y": 272
                    }
                }
            }
        }
    }
    // editor.drawflow = {
    //     "drawflow": {
    //         "Home": {
    //             "data": {


    //             }
    //         },

    //     }
    // }
    editor.start();


    // Events!
    editor.on('nodeCreated', function(id) {
        console.log("Node created " + id);
    })

    editor.on('nodeRemoved', function(id) {
        console.log("Node removed " + id);
    })

    editor.on('nodeSelected', function(id) {
        console.log("Node selected " + id);
    })

    editor.on('moduleCreated', function(name) {
        console.log("Module Created " + name);
    })

    editor.on('moduleChanged', function(name) {
        console.log("Module Changed " + name);
    })

    editor.on('connectionCreated', function(connection) {
        console.log('Connection created');
        console.log(connection);
    })

    editor.on('connectionRemoved', function(connection) {
        console.log('Connection removed');
        console.log(connection);
    })

    editor.on('mouseMove', function(position) {
        console.log('Position mouse x:' + position.x + ' y:' + position.y);
    })

    editor.on('nodeMoved', function(id) {
        console.log("Node moved " + id);
    })

    editor.on('zoom', function(zoom) {
        console.log('Zoom level ' + zoom);
    })

    editor.on('translate', function(position) {
        console.log('Translate x:' + position.x + ' y:' + position.y);
    })

    editor.on('addReroute', function(id) {
        console.log("Reroute added " + id);
    })

    editor.on('removeReroute', function(id) {
        console.log("Reroute removed " + id);
    })

    /* DRAG EVENT */

    /* Mouse and Touch Actions */

    var elements = document.getElementsByClassName('drag-drawflow');
    for (var i = 0; i < elements.length; i++) {
        elements[i].addEventListener('touchend', drop, false);
        elements[i].addEventListener('touchmove', positionMobile, false);
        elements[i].addEventListener('touchstart', drag, false);
    }

    var mobile_item_selec = '';
    var mobile_last_move = null;

    function positionMobile(ev) {
        mobile_last_move = event;
    }

    function allowDrop(ev) {
        ev.preventDefault();
    }

    function drag(ev) {
        if (ev.type === "touchstart") {
            mobile_item_selec = ev.target.closest(".drag-drawflow").getAttribute('data-node');
        } else {
            ev.dataTransfer.setData("node", ev.target.getAttribute('data-node'));
        }
    }

    function drop(ev) {
        if (ev.type === "touchend") {
            var parentdrawflow = document.elementFromPoint(mobile_last_move.touches[0].clientX, mobile_last_move.touches[0].clientY).closest("#drawflow");
            if (parentdrawflow != null) {
                addNodeToDrawFlow(mobile_item_selec, mobile_last_move.touches[0].clientX, mobile_last_move.touches[0].clientY);
            }
            mobile_item_selec = '';
        } else {
            ev.preventDefault();
            var data = ev.dataTransfer.getData("node");
            addNodeToDrawFlow(data, ev.clientX, ev.clientY);
        }

    }

    function addNodeToDrawFlow(name, pos_x, pos_y) {
        if (editor.editor_mode === 'fixed') {
            return false;
        }
        pos_x = pos_x * (editor.precanvas.clientWidth / (editor.precanvas.clientWidth * editor.zoom)) - (editor.precanvas.getBoundingClientRect().x * (editor.precanvas.clientWidth / (editor.precanvas.clientWidth * editor.zoom)));
        pos_y = pos_y * (editor.precanvas.clientHeight / (editor.precanvas.clientHeight * editor.zoom)) - (editor.precanvas.getBoundingClientRect().y * (editor.precanvas.clientHeight / (editor.precanvas.clientHeight * editor.zoom)));




        switch (name) {

            case 'multiple':
                var multiple = `
            <div>
              <div class="box">
                Multiple!
              </div>
            </div>
            `;
                editor.addNode('multiple', 3, 4, pos_x, pos_y, 'multiple', {}, multiple);
                break;
            case 'personalized':
                var personalized = `
            <div>
              Personalized
            </div>
            `;
                editor.addNode('personalized', 1, 1, pos_x, pos_y, 'personalized', {}, personalized);
                break;
            case 'dbclick':
                var dbclick = `
            <div>
            <div class="title-box"><i class="fas fa-mouse"></i> Db Click</div>
              <div class="box dbclickbox" ondblclick="showpopup(event)">
                Db Click here
                <div class="modal" style="display:none">
                  <div class="modal-content">
                    <span class="close" onclick="closemodal(event)">&times;</span>
                    Change your variable {name} !
                    <input type="text" df-name>
                  </div>

                </div>
              </div>
            </div>
            `;
                editor.addNode('dbclick', 1, 1, pos_x, pos_y, 'dbclick', {
                    name: ''
                }, dbclick);
                break;
            case 'add_node':
                var add_node = `
                  <div class="node-child">
                  <div class="add-node-btns" data-bs-target="#exampleModalToggle" data-bs-toggle="modal">
                  <i class="ri-edit-box-line"></i>
                  </div>
                  <div class="node-content">
                  <img src="<?php echo home_url(); ?>/wp-content/uploads/2024/08/no-image-default.png" alt="Upload Image" class="node-image">
                   <div class="node-image-url"></div>
                  <p class="node-text">Text</p>
                  </div>
                  </div>
                  <div class="resize-handle resize-handle-top"></div>
        <div class="resize-handle resize-handle-right"></div>
        <div class="resize-handle resize-handle-bottom"></div>
        <div class="resize-handle resize-handle-left"></div>
            `;
                editor.addNode('add_node', 1, 1, pos_x, pos_y, 'add_node', {}, add_node);
                break;

            default:
        }



    }

    var transform = '';

    function showpopup(e) {
        e.target.closest(".drawflow-node").style.zIndex = "9999";
        e.target.children[0].style.display = "block";
        //document.getElementById("modalfix").style.display = "block";

        //e.target.children[0].style.transform = 'translate('+translate.x+'px, '+translate.y+'px)';
        transform = editor.precanvas.style.transform;
        editor.precanvas.style.transform = '';
        editor.precanvas.style.left = editor.canvas_x + 'px';
        editor.precanvas.style.top = editor.canvas_y + 'px';
        console.log(transform);

        //e.target.children[0].style.top  =  -editor.canvas_y - editor.container.offsetTop +'px';
        //e.target.children[0].style.left  =  -editor.canvas_x  - editor.container.offsetLeft +'px';
        editor.editor_mode = "fixed";

    }

    function closemodal(e) {
        e.target.closest(".drawflow-node").style.zIndex = "2";
        e.target.parentElement.parentElement.style.display = "none";
        //document.getElementById("modalfix").style.display = "none";
        editor.precanvas.style.transform = transform;
        editor.precanvas.style.left = '0px';
        editor.precanvas.style.top = '0px';
        editor.editor_mode = "edit";
    }

    function changeModule(event) {
        var all = document.querySelectorAll(".menu ul li");
        for (var i = 0; i < all.length; i++) {
            all[i].classList.remove('selected');
        }
        event.target.classList.add('selected');
    }

    function changeMode(option) {

        //console.log(lock.id);
        if (option == 'lock') {
            lock.style.display = 'none';
            unlock.style.display = 'block';
        } else {
            lock.style.display = 'block';
            unlock.style.display = 'none';
        }

    }
</script>


<style>
    .node-child .node-content p {
        text-align: center;
        margin: 0;
        padding: 10px 0;
    }

    #drop-area {
        position: relative;
        min-height: 100vh;
        /* background: var(--background-color);
    background-size: 25px 25px;
    background-image: linear-gradient(to right, #f1f1f1 1px, transparent 1px),
            linear-gradient(to bottom, #f1f1f1 1px, transparent 1px); */
    }

    .add-node img {
        width: 100%;
        height: 100%;
    }

    #drawflow.parent-drawflow {
        overflow: auto;

    }



    .drawflow {
        position: relative;
        /* overflow: auto; */
    }

    .parent-node {
        position: absolute;
    }

    .resize-handle {
        position: absolute;
        /* background: #000; */
        cursor: pointer;
        opacity: 0.5;
        z-index: 0;
    }

    .resize-handle-top,
    .resize-handle-bottom {
        height: 10px;
        left: 0;
        right: 0;
    }

    .resize-handle-top {
        top: -5px;
        cursor: n-resize;
    }

    .resize-handle-bottom {
        bottom: -5px;
        cursor: s-resize;
    }

    .resize-handle-left,
    .resize-handle-right {
        width: 10px;
        top: 0;
        bottom: 0;
    }

    .resize-handle-left {
        left: -5px;
        cursor: w-resize;
    }

    .resize-handle-right {
        right: -5px;
        cursor: e-resize;
    }
</style>
<script>
    jQuery(document).ready(function($) {

        let startX, startY, startWidth, startHeight, startLeft, startTop, handle;
        let $resizing;

        $(document).on('mousedown', '.resize-handle', function(e) {
            e.preventDefault();
            handle = $(this).attr('class');
            $resizing = $(this).closest('.parent-node .drawflow-node.add_node');

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
</script>




<script>
    jQuery(document).ready(function($) {
        $('#update-node-data-button').on('click', function(e) {
            e.preventDefault();

            // Collect company name and check if it's empty
            var companyName = $('#company-name').val().trim();


            // Collect node data
            var nodes = [];
            $('.parent-node .drawflow-node').each(function() {
                var node = $(this);
                var nodeData = {
                    company_logo: $('#company-logo-image').attr('src'),
                    company_name: companyName,
                    element_image_url: node.find('.node-image').attr('src'),
                    element_text: node.find('.node-text').text(),
                    element_text_url: node.find('.node-text-url a').attr('href'),
                    element_left: node.css('left'),
                    element_top: node.css('top'),
                    element_height: node.css('height'),
                    element_width: node.css('width')
                };

                nodes.push(nodeData);
            });


            // Collect SVG data
            let svgData = [];
            $('.drawflow svg').each(function() {
                const svgClass = $(this).attr('class');
                const pathDValues = $(this).find('path.main-path').map(function() {
                    return $(this).attr('d');
                }).get();

                svgData.push({
                    svgClass: svgClass,
                    pathDValues: pathDValues
                });
            });

            // Prepare data for AJAX
            $.ajax({
                url: my_ajax_object.ajax_url, // Ensure this URL is correct
                type: 'POST',
                data: {
                    action: 'update_node_data',
                    nonce: my_ajax_object.nonce, // Ensure this nonce is correct
                    company_name: companyName,
                    nodes: nodes,
                    svg_data: svgData
                },
                success: function(response) {
                    if (response.success) {
                        Swal.fire('Success', response.data, 'success');
                    } else {
                        Swal.fire('Error', response.data, 'error');
                    }
                },
                error: function(xhr, status, error) {
                    Swal.fire('Error', 'An error occurred: ' + error, 'error');
                }
            });
        });
    });
</script>


<?php get_footer(); ?>