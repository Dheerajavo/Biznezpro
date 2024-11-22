<?php /* Template Name: Node Child View*/ ?>
<?php get_header(); ?>
<!-- main content area start -->
 <?php $current_pageID = get_the_ID();
 // Query to get node_data from anv_node_data table
$node_data_results = $wpdb->get_results( "SELECT node_data FROM anv_node_data", ARRAY_A );

$page_id_results = $wpdb->get_results( "SELECT page_id FROM anv_nodechild_data WHERE page_id = $current_pageID", ARRAY_A );

if ( empty( $page_id_results ) ) {
    echo 'No page found with page_id ' . $current_pageID;
    return;
}

$company_logo = '';

// Iterate through all the rows of node_data
foreach ( $node_data_results as $row ) {

    $unserialized_data = maybe_unserialize( $row['node_data'] );
    if ( is_array( $unserialized_data ) ) {
        foreach ( $unserialized_data as $node ) {
            if ( isset( $node['element_text_id'] ) ) {
                $element_text_id = explode(',', $node['element_text_id'])[0];
                if ( intval($element_text_id) === intval($current_pageID) ) {
                    $company_logo = $node['company_logo'];
                    break 2;
                }
            }
        }
    }
}

?>

<div class="main-content-area">
    <div class="home-page">
        <div class="top-head">
            <div class="left-logo logo_result"><?php get_template_part('template-parts/common-top-logo'); ?></div>
            <div class="right-logo"><a href="#"><img src="<?php echo $company_logo; ?>"></a></div>
        </div>
        <a href="javascript:history.back()" class="go-back-text">← Go Back</a>

        <!-- Section to display the node structure -->
        <div class="node-child-box bg_grad_color" id="drop-area">
            <div class="warpper">

            </div>
        </div>
    </div>
</div>

<!-- PHP logic to fetch and unserialize the node structure from the database -->
<?php
$current_pageID = get_the_ID();

function get_node_structure_from_db($page_id)
{
    global $wpdb;
    $table_name = $wpdb->prefix . 'nodechild_data'; // Replace with your actual table name

    // Fetch row where page_id matches the current page
    $result = $wpdb->get_row($wpdb->prepare("SELECT * FROM $table_name WHERE page_id = %d", $page_id));

    if ($result) {
        // Unserialize each field if they are serialized arrays
        $node_group_data = maybe_unserialize($result->nodechild_groupdata);
        $node_child_data = maybe_unserialize($result->nodechild_data);
        $child_svgline_data = maybe_unserialize($result->child_svgline_data);

        return [
            'pageID' => $result->page_id,
            'group_data' => $node_group_data,
            'child_data' => $node_child_data,
            'svgline_data' => $child_svgline_data
        ];
    } else {
        return null;
    }
}

$node_structure = get_node_structure_from_db($current_pageID);

if ($node_structure) {
    $node_data = $node_structure['child_data']; // Assuming 'child_data' contains the nodes
    $line_data = $node_structure['svgline_data']; // Assuming 'svgline_data' contains the lines
    // foreach ($node_data as $node) {
    //     $node['slug'] = get_slug_from_post_id($node['element_post_id']);
    // }
} else {
    $node_data = [];
    $line_data = [];
}
?>

<script>
   jQuery(document).ready(function($) {
    var lineData = <?php echo json_encode($line_data); ?>;
// Fetch the node data from the database
var nodeData = <?php echo json_encode($node_data); ?>;
console.log(nodeData);
// Check if we have any nodes to process
if (nodeData.length > 0) {
    // First node data (to be displayed in the central node)
    const firstNode = nodeData[0];
//  left: ${firstNode.element_left}; top: ${firstNode.element_top};
    // Central Node (first node data)
    const centralNodeHtml = `
    <div class="drawflow-node ${firstNode.node_class[0]} central-node "
         style="
    top: ${firstNode.element_top};left:${firstNode.element_left};

                width: ${firstNode.element_width}; height: ${firstNode.element_height};
                background-image:url(${firstNode.element_bgimage_url});
                background-size: cover; background-position: center;">
        <div class="node-text">${firstNode.element_text}</div>
    </div>`;
    $('#drop-area .warpper').append(centralNodeHtml);

    // Rest of the nodes (surrounding the central node)
    var radius = 300; // Adjust radius for proper spacing
    var totalNodes = nodeData.length - 1; // Total surrounding nodes (excluding the first one)
    var angleStep = 360 / totalNodes; // Angle between nodes

    // Center coordinates of the container (adjust for central node size)
    var centerX = $('#drop-area').width() / 2;
    var centerY = $('#drop-area').height() / 2;

    var currentAngle = 0;

    // Loop through the remaining nodes (starting from the second one)
    nodeData.slice(1).forEach(function(node, index) {
        // Calculate position for surrounding nodes using trigonometry
        var radian = (currentAngle * Math.PI) / 180; // Convert angle to radians
        var nodeX = centerX + radius * Math.cos(radian) - 75; // Adjust offset for centering nodes (width = 150px)
        var nodeY = centerY + radius * Math.sin(radian) - 75; // Adjust offset for centering nodes (height = 150px)
        //const postUrl = `https://poojas.sg-host.com/phpapplication/industries/${node.slug}/`;
        // Add surrounding node
        var nodeHtml;

        // Check if element_post_id is not empty
        if (node.element_post_id) {
            // Create the HTML with the anchor tag
            nodeHtml = `
            <a href="${node.element_post_id}">
                <div class="drawflow-node ${node.node_class[0]} node-child"
                    style="left: ${node.element_left}; top: ${node.element_top}; width: ${node.element_width}; height: ${node.element_height};
                            background-image:url(${node.element_bgimage_url});
                            background-size: cover; background-position: center;">
                    <div class="node-text">
                        <span class="text-background">${node.element_text}</span>
                    </div>
                </div>
            </a>`;
        }
        else {
            // Create the HTML without the anchor tag
            nodeHtml = `
            <div class="drawflow-node ${node.node_class[0]} node-child"
                style="left: ${node.element_left}; top: ${node.element_top}; width: ${node.element_width}; height: ${node.element_height};
                        background-image:url(${node.element_bgimage_url});
                        background-size: cover; background-position: center;">
                <div class="node-text">
                    <span class="text-background">${node.element_text}</span>
                </div>
            </div>`;
        }

        // Append the HTML to the drop-area
        $('#drop-area .warpper').append(nodeHtml);

        if (lineData[index]) {
        // Use lineData[index] to get the x1, y1, x2, y2 values
        var lineX1 = lineData[index].x1; // x1 from lineData
        var lineY1 = lineData[index].y1; // y1 from lineData
        var lineX2 = lineData[index].x2; // x2 from lineData
        var lineY2 = lineData[index].y2; // y2 from lineData

        // Add SVG line to connect the central node with the surrounding node
        var lineHtml = `
        <svg class="line-container" width="100%" height="100%">
            <line x1="${lineX1}" y1="${lineY1}" x2="${lineX2}" y2="${lineY2}" stroke="black" stroke-width="2" />
        </svg>`;
        $('#drop-area .warpper').append(lineHtml);
    }


        // Add SVG line to connect the central node with the surrounding node
        // var lineHtml = `
        // <svg class="line-container" width="100%" height="100%">
        //     <line x1="${lineData.x1}" y1="${lineData.y1}" x2="${lineData.x2}" y2="${lineData.y2}" stroke="black" stroke-width="2" />
        // </svg>`;
        // $('#drop-area').append(lineHtml);

        // Update angle for the next node
        currentAngle += angleStep;
    });
}
});

</script>

<!-- Add some basic CSS to style the nodes -->
<style>
    .go-back-text {
        font-size: 18px;
        color: #000; /* Change color if needed */
        text-decoration: none;
        font-family: Arial, sans-serif;
    }

    .go-back-text:hover {
        text-decoration: underline;
        color: rgb(87, 200, 202);
    }
    #drop-area {
        position: relative;
        width: 100%;
        min-height: 100vh;
        /* background-color: #f9f9f9; */
    }
    .drawflow-node {
    border: 2px solid white;
    border-radius: 20px;
    }

    a .node-text span:hover {
        text-decoration: underline;
        color: rgb(87, 200, 202);
    }

    a.outerwithoutline,a.circle-node, a.rectangle-node {
        cursor: pointer;
    }

    .circle-node{
        border-radius: 50%;
    }

    .outerwithoutline, .circle-node, .rectangle-node {
        background-color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        position: absolute;
        text-align: center;
        background-size: cover;
        background-position: center;
        cursor: default;
    }
    .outerwithoutline .node-text {
        top: 70%;
    }

        /* .circle-node, .rectangle-node {
        background-color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        position: absolute;
        text-align: center;
        background-size: cover;
        background-position: center;
        cursor: pointer;
    } */

    .drawflow-node {
        position: absolute;
        z-index: 3;
    }

    #drop-area .warpper {
    position: relative;
    height: 100vh;
    display: flex;
    justify-content: center;
    width: 100%;
    max-width: 1270px;
    margin: 0 auto;
}

    .node-text {
        color: white;
        font-weight: 400;
        font-size: 25px;
        line-height: 1.5;
        position: relative;
        z-index: 2;
        text-transform: capitalize;

    }
    svg {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
    }
</style>

<?php get_footer(); ?>