<?php get_header(); ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/drawflow/dist/drawflow.min.css">
<!-- <script src="https://cdn.jsdelivr.net/npm/drawflow/dist/drawflow.min.js"></script> -->

<style>
    .blue-btn-hv {
        transition: all 0.2s ease-in-out;
        color: #fff;
        background: #57c8ca;
        font-size: 14px;
    }

    button.comment-btn {
        padding: 8px 15px;
    }

    .comment-wrapper,
    .report-wrapper {
        display: flex;
        align-items: center;
    }


    .modal-title {
        font-size: 18px;
        font-weight: 600;
    }

    .comment-content,
    .report-content {
        background: #fff;
        padding: 15px 10px;
        margin-top: 0;
        box-shadow: rgba(100, 100, 111, 0.2) 0px 7px 29px 0px;
        border-radius: 6px;
        min-height: 75px;
    }

    .comment-user,
    .report-user {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 10px;
    }

    .comment-item,
    .report-item {
        margin-top: 20px;
    }

    .comment-text,
    .report-text {
        font-size: 16px;
        font-weight: 400;
        line-height: 140%;
        color: var(--black);
        text-transform: none;
        font-family: "Poppins", sans-serif;
        margin-bottom: 0;
        white-space: pre-line;
    }

    .edit-comment-text.form-control {
        margin-bottom: 10px;
        font-size: 14px;
    }

    .comment-user span,
    .report-user span {
        font-size: 14px;
    }
</style>


<style>
    #drop-area {
        position: relative;
        min-height: 100vh;
    }

    .drawflow-node {
        border: 2px solid white !important;
    }

    p.node-text {
        color: #000;
        text-transform: capitalize;
    }

    p.node-text a:hover {
        text-decoration: underline;
        color: rgb(87, 200, 202);
    }

    .wrapper {
        width: 100%;
        display: flex;
        overflow: auto;
        box-sizing: border-box;
    }

    #drawflow {
        width: 100%;
        height: 100%;
    }

    .add-node {
        padding: 0px;
        align-items: unset;
        max-width: 100%;
    }

    .parent-drawflow {
        overflow-x: auto;
    }

    .node-content-image img.node-image {
        height: 100%;
        width: 100%;
    }

    .node-child .node-content-image {
        height: 100%;
    }

    .drawflow_content_node .node-child {
        height: 100%;
    }

    .drawflow .drawflow-node .drawflow_content_node {
        height: 100%;
    }

    .node-child p {
        text-align: center;
        margin: 0;
        padding: 10px 0;
    }

    .drawflow .drawflow-node.add_node {
        background: #ddd !important;
        box-sizing: border-box;
        padding: 0px !important;
        cursor: auto;
    }

    .btn-clear.edit {
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
</style>
<style>
    .drawflow .connection .main-path {
        /* stroke: black !important;
        stroke-width: 2px !important;
        pointer-events: auto !important; */

        stroke: #57c8ca !important;
        stroke-width: 4px !important;
        pointer-events: auto !important;
    }

    .parent-drawflow .drawflow .drawflow-node:hover {
        cursor: auto;
    }

    .parent-node .drawflow-node .inputs .input {
        height: 0px;
        width: 0px;
        border: none;
    }

    .drawflow .drawflow-node .inputs .input.inputConnected {
        /* width: 0;
        height: 0;
        border-style: solid;
        border-width: 12px 0 12px 12px;
        border-color: transparent transparent transparent black;
        background: transparent;
        border-radius: 0px;
        margin-left: 15px;
        cursor: auto; */


        width: 0;
        height: 0;
        border-style: dashed;
        border-width: 12px 0 12px 15px;
        border-color: transparent transparent transparent #57c8ca;
        background: transparent;
        border-radius: 0px;
        margin-left: 12px;
        cursor: auto;
    }

    .parent-drawflow .drawflow .drawflow-node.selected {
        background: none;
    }

    .parent-drawflow .drawflow .drawflow-node {
        background: none;
        padding: 0;
    }

    .rectangle {
        display: inline-block;
        width: 60px;
        height: 40px;
    }

    .drag-drawflow.circle {
        display: inline-block;
        width: 40px;
        height: 40px;
        border-radius: 50%;
    }

    .drawflow .drawflow-node.circle {
        width: 150px;
        height: 150px;
        background: #ddd !important;
        box-sizing: border-box;
        padding: 0px !important;
        border-radius: 50%;
    }

    .drawflow-node.circle .node-content-image .node-image {
        border-radius: 50%;
    }

    .shape-svg {
        display: block;
        margin: auto;
        max-width: 100%;
        height: auto;
    }

    .drag-drawflow.diamond {
        border-radius: 5px 90px 90px 5px;
        width: 50px;
        height: 40px;
    }

    .drawflow .drawflow-node.diamond {
        border-radius: 5px 90px 90px 5px;
        padding: 0 !important;
        height: 150px;
        width: 160px;
    }

    .drawflow-node.diamond .node-content img.node-image {
        height: 100%;
        border-radius: 5px 90px 90px 5px;
    }

    .drawflow-node.diamond .node-content-image img.node-image {
        height: 100%;
        border-radius: 5px 90px 90px 5px;
    }

    .drag-drawflow.parallel {
        transform: skew(-20deg);
        padding: 0;
        width: 40px;
        height: 40px;
    }

    .drawflow .drawflow-node.parallel {
        width: 160px;
        height: 150px;
        transform: skew(-20deg);
        padding: 0;
    }

    .drawflow-node.parallel .node-child p.node-text {
        transform: skew(20deg);
    }

    .drag-drawflow.rhombus {
        width: 48px;
    }

    .drawflow .drawflow-node.rhombus {
        width: 200px;
        height: 180px;
        background: transparent !important;
        float: 0;
        border: 0;
    }

    .drawflow-node.rhombus .node-content-image {
        clip-path: polygon(50% 0%, 100% 50%, 50% 100%, 0% 50%);
        background: black;
        padding: 2px;
    }

    .drawflow-node.rhombus img.node-image {
        clip-path: polygon(50% 0%, 100% 50%, 50% 100%, 0% 50%);
    }

    .drawflow-node.rhombus.selected {
        box-shadow: none;
    }

    .drag-drawflow.ocatgon {
        width: 49px;
    }

    .drawflow .drawflow-node.ocatgon {
        width: 200px;
        height: 180px;
        /* float: 0; */
        border: 0;
    }

    .drawflow-node.ocatgon .node-content-image {
        clip-path: polygon(30% 0%, 70% 0%, 100% 30%, 100% 70%, 70% 100%, 30% 100%, 0% 70%, 0% 30%);
        background: black;
        padding: 2px;
    }

    .drawflow-node.ocatgon img.node-image {
        clip-path: polygon(30% 0%, 70% 0%, 100% 30%, 100% 70%, 70% 100%, 30% 100%, 0% 70%, 0% 30%);

    }

    .drawflow .drawflow-node.ocatgon.selected {
        box-shadow: none;
    }
</style>
<style>
    /* Style for the icons container */
    .hover-icons {
        position: absolute;
        bottom: 10px;
        left: 0;
        /* transform: translateX(-50%); */
        display: flex;
        flex-direction: column;
        gap: 10px;
        opacity: 0;
        transition: opacity 0.3s ease;
        background: #ffffff85;
        width: 100%;
        justify-content: center;
        align-items: center;
        bottom: 0;
        top: 0;
        backdrop-filter: blur(1px);

    }

    /* Show icons on hover */
    .node-content-image:hover .hover-icons {
        opacity: 1;
    }

    .hover-icons i {
        background-color: rgba(0, 0, 0, 0.6);
        padding: 5px 10px;
        border-radius: 5px;
        font-size: 12px;
        cursor: pointer;
    }

    /* Default icon color */
    .hover-icons i {
        background-color: rgb(0 0 0 / 77%);
        padding: 5px 10px;
        border-radius: 5px;
        font-size: 12px;
        cursor: pointer;
        color: #fff;
    }

    /* Liked state for the "like" icon */
    .hover-icons .like-icon.liked {
        color: #f72626;
    }

    /* Style for the like count */
    .like-count {
        color: white;
        /* margin-left: 5px; */
        font-size: 14px;
        background-color: rgb(0 0 0 / 77%);
        padding: 5px 10px;
        border-radius: 5px;
        text-align: center;
    }

    .hover-icons .like-count,
    .hover-icons i {
        width: 26px;
        height: 26px;
        display: flex;
        align-items: center;
        padding: 2px;
        justify-content: center;
    }
</style>
<?php

global $wpdb;
$post_slug = get_post_field('post_name', get_post());
$table_name = $wpdb->prefix . 'node_data';

// Fetch node data for this post
$nodes = $wpdb->get_results(
    $wpdb->prepare("SELECT * FROM $table_name WHERE company_slug = %s", $post_slug)
);
$post_id = get_the_ID();
?>
<!-- main content area start -->
<?php $current_user = wp_get_current_user();
$comment_data = [
    'user_id' => $current_user->ID,
    'user_name' => $current_user->display_name,
    'comment_text' => $comment_text,
    'timestamp' => current_time('mysql')
];
// var_dump($current_user);
// echo $current_user->display_name;
?>
<div class="main-content-area">
    <div class="home-page">
        <div class="top-head">
            <div class="left-logo logo_result">
                <?php get_template_part('template-parts/common-top-logo'); ?>
            </div>

            <div class="right-logo">
                <a type="button" style="cursor: auto;">
                    <?php

                    if (!empty($nodes)) {
                        // Deserialize the node data
                        $node_data = maybe_unserialize($nodes[0]->node_data);
                        $company_logo = esc_url($node_data[0]['company_logo']);
                        echo '<img src="' . $company_logo . '" alt="Company Logo">';
                    }
                    ?>
                </a>
            </div>
        </div>

        <div class="add-node bg_grad_color" id="drop-area">
            <div class="wrapper wrap-node">
                <div id="drawflow" ondrop="drop(event)" ondragover="allowDrop(event)" class="parent-drawflow " tabindex="0">
                    <div class="btn-clear edit" id="node_edit">Edit</div>
                    <?php
                    $drawflow_translate_values = maybe_unserialize($nodes[0]->drawflow_translate_values);  // Unserialize if needed

                    if (!empty($drawflow_translate_values)) {
                        foreach ($drawflow_translate_values as $drawflow_translate) {
                            $translateX = $drawflow_translate['translateX'] ?? 0;
                            $translateY = $drawflow_translate['translateY'] ?? 0;

                            // Build the transform style
                            $transformStyle = "translate({$translateX}px, {$translateY}px) scale(1)";
                    ?>

                            <div class="drawflow" style="transform: <?= $transformStyle; ?>;">


                        <?php       }
                    } else {
                        echo ' <div class="drawflow" style="">';
                    }
                        ?>
                        <?php if (!empty($nodes)) {
                            // Deserialize the node data
                            $node_data = maybe_unserialize($nodes[0]->node_data);
                            $node_count = 1;

                            foreach ($node_data as $node) {
                                $node_id = $node_count; // Unique node ID
                                // Extract node data
                                $company_logo = esc_url($node['company_logo']);
                                // $node_class: afterClasses
                                $node_class = $node['node_class'];
                                $element_image_url = esc_url($node['element_image_url']);
                                $element_text = esc_html($node['element_text']);
                                $element_text_id = esc_html($node['element_text_id']);
                                // $element_text_url = esc_url($node['element_text_url']);
                                $element_top = esc_attr($node['element_top']);
                                $element_left = esc_attr($node['element_left']);
                                $element_height = esc_attr($node['element_height']);
                                $element_width = esc_attr($node['element_width']);

                                // Get like data for each specific node
                                $like_key = "_user_likes_{$node_id}";
                                $likes = get_post_meta($post_id, $like_key, true) ?: [];
                                $like_count = count($likes);
                                $is_liked = in_array(get_current_user_id(), $likes);
                        ?>
                                <div class="parent-node" data-post-id="<?php echo $post_id; ?> " data-node-id="<?php echo $node_id; ?>">
                                    <div id="node-<?php echo $node_count; ?>" class="drawflow-node <?php echo $node_class[0]; ?>" style="top:<?php echo $element_top; ?>; left: <?php echo $element_left; ?>; height: <?php echo $element_height; ?>; width: <?php echo $element_width; ?>;">
                                        <div class="inputs">
                                            <div class="input input_1 "></div>
                                        </div>
                                        <div class="drawflow_content_node">
                                            <div class="node-child <?php echo $node_class[0]; ?>-node">
                                                <div class="node-content-image">
                                                    <img src="<?php echo $element_image_url; ?>" alt="Upload Image" class="node-image" style="width:100%; height:100%;">
                                                    <div class="hover-icons">
                                                        <i class="ri-more-2-fill" id="likeShare"></i>
                                                    </div>
                                                </div>

                                                <?php
                                                $page_ID = $element_text_id;
                                                $page_Slug = get_post_field('post_name', $page_ID);
                                                ?>
                                                <?php
                                                // Split the string by comma
                                                $parts = explode(',', $element_text_id);
                                                $page_id = trim($parts[0]);
                                                if (is_numeric($page_id)) {
                                                    $page_slug = get_post_field('post_name', $page_id);
                                                    $page_url = get_permalink($page_id);
                                                ?>

                                                    <p class="node-text">
                                                        <a href="<?php echo esc_url($page_url); ?>"><?php echo esc_html($element_text); ?></a>
                                                    </p>
                                                <?php
                                                } else {
                                                ?>
                                                    <p class="node-text"><?php echo esc_html($element_text); ?></p>
                                                <?php
                                                }
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="cst-pop-up" style="display: none;">
                                        <div class="cst-pop-up2">
                                            <div class="cst-pop-up3">
                                                <div class="pop-up-header">
                                                    <h5 class="title"><?php echo esc_html($element_text); ?></h5>
                                                    <div class="post-likes">
                                                        <i id="like-icon" class="fa fa-heart <?php echo $is_liked ? 'liked' : ''; ?> like-icon"></i>
                                                        <div class="like-count"><?php echo $like_count; ?></div>
                                                    </div>

                                                    <button type="button" class="pop-up-close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="share-options">
                                                    <a href="#" class="btn share-facebook com-btn" target="_blank">
                                                        <i class="ri-facebook-circle-line"></i>
                                                    </a>
                                                    <a href="#" class="btn share-twitter com-btn" target="_blank">
                                                        <i class="ri-twitter-x-fill"></i>
                                                    </a>
                                                    <a href="#" class="btn share-whatsapp com-btn" target="_blank">
                                                        <i class="ri-whatsapp-line"></i>
                                                    </a>
                                                    <a href="#" class="btn share-email com-btn">
                                                        <i class="ri-mail-line"></i>
                                                    </a>
                                                    <button class="btn copy-link com-btn">
                                                        <i class="ri-file-copy-line"></i>
                                                    </button>
                                                    <?php if (is_user_logged_in()) : ?>
                                                        <button class="btn share-report com-btn">
                                                            <i class="ri-file-warning-line"></i>
                                                        </button>
                                                    <?php endif; ?>
                                                </div>
                                                <div class="wrapper-comment mb-3">
                                                    <span id="userName" class="me-2"><b><?php echo wp_get_current_user()->display_name; ?></b></span> <!-- User's Name -->
                                                    <div class="comment-wrapper">
                                                        <textarea id="commentText" class="commentText form-control me-2" rows="1" placeholder="Write your comment here..."></textarea>
                                                        <button type="button" class="comment-btn blue-btn-hv" id="submitComment">Comment</button>
                                                    </div>
                                                </div>
                                                <div class="modal-header px-0">
                                                    <h5 class="modal-title" id="commentModalLabel">Comments <span id="commentCount">(0)</span></h5>
                                                </div>
                                                <div id="commentList" class="commentList mt-2">
                                                    <!-- Comments will be appended here -->
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                        <?php $node_count++;
                            }
                            $svg_data = maybe_unserialize($nodes[0]->svg_data);  // Unserialize if needed

                            if (!empty($svg_data)) {
                                foreach ($svg_data as $svg) {
                                    $svg_class = esc_attr($svg['svgClass']);
                                    foreach ($svg['pathDValues'] as $d_value) {
                                        $d_value = esc_attr($d_value);
                                        echo '<svg class="' . $svg_class . '"><path class="main-path" d="' . $d_value . '"></path></svg>';
                                    }
                                }
                            }
                        } else {
                            echo '<p>No node data found.</p>';
                        }
                        ?>
                            </div>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Comment Modal -->
<div class="modal fade" id="reportModal" tabindex="-1" aria-labelledby="reportModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="reportModalLabel">Report</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Display the current user's name above the textarea -->
                <div class="wrapper-report mb-3">
                    <span id="userName" class="me-2"><b><?php echo wp_get_current_user()->display_name; ?></b></span> <!-- User's Name -->
                    <div class="comment-wrapper report-wrapper">
                        <textarea id="reportText" class="form-control me-2" rows="1" placeholder="Write your report here..."></textarea>
                        <button type="button" class="report-btn blue-btn-hv" id="submitReport">Submit</button>
                    </div>
                </div>

                <div class="modal-header px-0 admin_only">
                    <h5 class="modal-title" id="reportModalLabel">Reports <span id="reportCount">(0)</span></h5>
                </div>
                <div id="reportList" class="mt-2 admin_only">
                    <!-- Comments will be appended here -->
                </div>

            </div>
        </div>
    </div>
</div>
</main>
<!-- Popup Modals -->

<script>
    jQuery(document).ready(function($) {
        // Ensure the popup is initially hidden
        $(".cst-pop-up").hide();

        // Toggle the popup on click of the #likeShare icon
        $("body").on("click", ".parent-node #likeShare", function() {
            const $likeShare = $(this);
            const $parentNode = $likeShare.closest(".parent-node");
            const $popup = $parentNode.find(".cst-pop-up");
            const postId = $parentNode.data("post-id");
            const nodeId = $parentNode.data("node-id");
            const currentUserId = "<?php echo get_current_user_id(); ?>";

            // Toggle the visibility of the popup
            $popup.toggle();

            // Manage modal visibility and body class
            if ($popup.is(":visible")) {
                $popup.addClass("open");
                $("body").addClass("cst-modal-open");
            } else {
                $popup.removeClass("open");
                $("body").removeClass("cst-modal-open");
            }

            // Validate that required data is present
            if (!postId || !nodeId) {
                console.warn("Missing postId or nodeId. Share URL cannot be generated.");
                return;
            }

            // Retrieve the slug for the post dynamically
            const postSlug = "<?php echo get_post_field('post_name', $post_id); ?>";
            if (!postSlug) {
                console.warn("Post slug not found for postId:", postId);
                return;
            }

            // Generate the share URL dynamically
            const shareUrl = `<?php echo home_url(); ?>/${postSlug}`;
            const encodedUrl = encodeURIComponent(shareUrl);
            // Update share links in the modal
            $popup.find(".share-facebook").attr("href", `https://www.facebook.com/sharer/sharer.php?u=${encodedUrl}`);
            $popup.find(".share-twitter").attr("href", `https://twitter.com/intent/tweet?url=${encodedUrl}&text=Check this out!`);
            $popup.find(".share-whatsapp").attr("href", `https://api.whatsapp.com/send?text=Check this out: ${shareUrl}`);
            $popup.find(".copy-link").data("clipboard-text", shareUrl);

            // Email sharing
            const emailSubject = "Check this out!";
            const emailBody = `I thought you might find this interesting: ${shareUrl}`;
            $popup.find(".share-email").attr("href", `mailto:?subject=${encodeURIComponent(emailSubject)}&body=${encodeURIComponent(emailBody)}`);
            // Copy link functionality
            $popup.find(".copy-link").off("click").on("click", function() {
                const textToCopy = $(this).data("clipboard-text");
                if (!textToCopy) {
                    Swal.fire({
                        icon: "error",
                        title: "Copy Failed",
                        text: "No link available to copy.",
                        confirmButtonText: "OK",
                    });
                    return;
                }

                navigator.clipboard.writeText(textToCopy).then(
                    () => {
                        Swal.fire({
                            icon: "success",
                            title: "Link Copied",
                            text: "The link has been copied to your clipboard!",
                            confirmButtonText: "OK",
                        });
                    },
                    (err) => {
                        Swal.fire({
                            icon: "error",
                            title: "Copy Failed",
                            text: "Unable to copy the link.",
                            confirmButtonText: "OK",
                        });
                    }
                );
            });

            // Fetch existing comments
            $.ajax({
                url: my_ajax_object.ajax_url,
                type: "POST",
                data: {
                    action: "get_node_comments",
                    post_id: postId,
                    node_id: nodeId,
                },
                success: function(response) {
                    if (response.success) {
                        const comments = response.data.comments;
                        const commentCount = comments.length;
                        const isAdmin = response.data.is_admin;

                        $popup.find("#commentCount").text(`(${commentCount})`);
                        const $commentList = $popup.find("#commentList").empty();

                        if (commentCount > 0) {
                            comments.forEach((comment, index) => {
                                const deleteButton = isAdmin ?
                                    `<button class="btn btn-sm delete-comment blue-btn-hv" data-index="${index}" data-comment-id="${comment.comment_id}"><i class="fa fa-trash"></i></button>` :
                                    "";
                                const editButton = comment.is_author ?
                                    `<button class="btn btn-sm edit-comment blue-btn-hv" data-index="${index}" data-comment-id="${comment.comment_id}"><i class="fa fa-edit"></i></button>` :
                                    "";

                                $commentList.prepend(`
                                <div class="comment-item">
                                    <div class="comment-user">
                                        <div><b>${comment.user_name}</b> <span>${comment.timestamp}</span></div>
                                        <div>${deleteButton} ${editButton}</div>
                                    </div>
                                    <div class="comment-content">
                                        <pre class="comment-text">${comment.comment_text}</pre>
                                    </div>
                                </div>
                            `);
                            });
                        } else {
                            $commentList.append(`<p class="empty-comment" >No comments yet. Be the first to comment!</p>`);
                        }
                    } else {
                        console.log("Error:", response.data);
                    }
                },
                error: function(error) {
                    console.log("Error fetching comments:", error);
                },
            });

            // Submit a comment
            const isUserLoggedIn = "<?php echo is_user_logged_in() ? 'true' : 'false'; ?>";
            $(".comment-wrapper").off("click", ".comment-btn").on("click", ".comment-btn", function() {
                const commentText = $popup.find(".commentText").val();
                // Check for empty comment
                if (!commentText.trim()) {
                    Swal.fire({
                        icon: "warning",
                        title: "Empty Comment",
                        text: "Please enter a comment.",
                        // confirmButtonColor: "#3085d6",
                        confirmButtonText: "OK"
                    });
                    return;
                }

                // Check if the user is logged in
                if (isUserLoggedIn !== 'true') {
                    Swal.fire({
                        icon: "warning",
                        title: "Login Required",
                        text: "Please login to comment.",
                        // confirmButtonColor: "#3085d6",
                        confirmButtonText: "OK"
                    });
                    return;
                }

                // Send AJAX request
                $.ajax({
                    url: my_ajax_object.ajax_url,
                    type: "POST",
                    data: {
                        action: "submit_node_comment",
                        post_id: postId,
                        node_id: nodeId,
                        comment_text: commentText
                    },
                    success: function(response) {
                        if (response.success) {
                            // console.log(response.data);
                            const comment = response.data.comment_data;
                            const isAdmin = response.data.is_admin;
                            const isAuthor = response.data.is_author;
                            // Construct delete and edit buttons based on user permissions
                            const deleteButton = isAdmin ?
                                `<button class="btn btn-sm delete-comment blue-btn-hv" data-index="new" data-post-id="${postId}" data-node-id="${nodeId}"><i class="fa fa-trash"></i></button>` :
                                '';
                            const editButton = isAuthor ?
                                `<button class="btn btn-sm edit-comment blue-btn-hv" data-index="new" data-post-id="${postId}" data-node-id="${nodeId}"><i class="fa fa-edit"></i></button>` :
                                '';
                            // Clear the input field
                            $popup.find(".commentText").val("");

                            // Prepend the new comment with the delete and edit buttons
                            $popup.find(".commentList").prepend(
                                `<div class="comment-item">
                            <div class="comment-user">
                                <div><b>${comment.user_name}</b> <span>${comment.timestamp}</span></div>
                                <div>${deleteButton} ${editButton}</div>
                            </div>
                            <div class="comment-content">
                                <pre class="comment-text">${comment.comment_text}</pre>
                            </div>
                        </div>`
                            );
                            // Update the comment count
                            const currentCountText = $popup.find("#commentCount").text().match(/\d+/);
                            const currentCount = currentCountText ? parseInt(currentCountText[0], 10) : 0;
                            $popup.find("#commentCount").text(`(${currentCount + 1})`);
                            $popup.find(".empty-comment").hide();


                        } else {
                            Swal.fire({
                                icon: "error",
                                title: "Failed to Add Comment",
                                text: response.data.message || "Please try again.",
                                confirmButtonText: "OK",
                            });
                        }
                    },
                    error: function(error) {
                        console.error("Error adding comment:", error);
                        Swal.fire({
                            icon: "error",
                            title: "Server Error",
                            text: "Could not add the comment. Please try again later.",
                            confirmButtonText: "OK",
                        });
                    },
                });
            });

            // Edit a comment
            $(".commentList").off("click", ".edit-comment").on("click", ".edit-comment", function() {
                // $("body").on("click", ".edit-comment", function() {
                const $button = $(this);
                const commentId = $button.data("comment-id");
                const commentIndex = $button.data("index");
                const $commentItem = $button.closest(".comment-item");
                const $commentText = $commentItem.find(".comment-text");
                const originalText = $commentText.text();
                const $originalEditButton = $button;
                $commentText.hide();
                $button.hide();
                $commentText.after(`
                <textarea class="edit-comment-text form-control">${originalText}</textarea>
                <button class="btn btn-sm save-comment blue-btn-hv">Save</button>
                <button class="btn btn-sm cancel-comment blue-btn-hv">Cancel</button>
            `);
                // const newCommentText = prompt("Edit your comment:", $commentText.text().trim());
                $commentItem.off("click", ".save-comment").on("click", ".save-comment", function() {
                    const newText = $commentItem.find(".edit-comment-text").val();
                    // if (newCommentText === null) return; // User canceled
                    if (newText && newText.trim() !== originalText) {
                        $.ajax({
                            url: my_ajax_object.ajax_url,
                            type: "POST",
                            data: {
                                action: "edit_node_comment",
                                post_id: postId,
                                node_id: nodeId,
                                comment_index: commentIndex,
                                comment_text: newText
                            },
                            success: function(response) {
                                if (response.success) {
                                    $commentText.text(newText).show();
                                    $commentItem.find(".edit-comment-text, .save-comment, .cancel-comment").remove();
                                    $originalEditButton.show();
                                } else {
                                    alert(response.data.message);
                                }
                            },
                            error: function(error) {
                                console.log("Error editing comment:", error);
                            }
                        });
                    }
                });
                $commentItem.off("click", ".cancel-comment").on("click", ".cancel-comment", function() {
                    $commentItem.find(".edit-comment-text, .save-comment, .cancel-comment").remove();
                    $commentText.show();
                    $originalEditButton.show();
                });
            });

            // Delete comment functionality (for admins only)
            $(".commentList").off("click", ".delete-comment").on("click", ".delete-comment", function() {
                const $button = $(this);
                const commentId = $button.data("comment-id");
                const commentIndex = $button.data("index")
                const $popup = $button.closest(".cst-pop-up");
                Swal.fire({
                    title: "Are you sure?",
                    text: "This action will permanently delete the comment.",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Yes, delete it!"
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: my_ajax_object.ajax_url,
                            type: "POST",
                            data: {
                                action: "delete_node_comment",
                                post_id: postId,
                                node_id: nodeId,
                                comment_index: commentIndex
                            },
                            success: function(response) {
                                if (response.success) {
                                    $button.closest(".comment-item").remove();
                                    const commentCount = parseInt($popup.find("#commentCount").text().match(/\d+/)[0], 10) - 1;
                                    // const currentCount = parseInt($("#commentCount").text().replace(/[()]/g, '')) - 1;
                                    $popup.find("#commentCount").text(`(${commentCount})`);
                                    if (commentCount === 0) {
                                        $popup.find(".empty-comment").show(); // Show when no comments
                                    } else {
                                        $popup.find(".empty-comment").hide(); // Hide when comments exist
                                    }
                                    // SweetAlert success message
                                    Swal.fire({
                                        icon: "success",
                                        title: "Comment Deleted",
                                        text: "The comment has been successfully deleted.",
                                        timer: 1500,
                                        showConfirmButton: false
                                    });

                                } else {
                                    Swal.fire({
                                        icon: "error",
                                        title: "Error",
                                        text: response.data.message || "Unable to delete the comment."
                                    });
                                    // alert(response.data.message);
                                }
                            },
                            error: function(error) {
                                console.log("Error deleting comment:", error);
                                Swal.fire({
                                    icon: "error",
                                    title: "Error",
                                    text: "An error occurred while attempting to delete the comment."
                                });
                            },
                        });
                    }
                });
            });

            // Report errors
            $popup.find(".share-report").off("click").on("click", function() {
                $("#reportModal").modal("show");

                $.ajax({
                    url: my_ajax_object.ajax_url,
                    type: "POST",
                    data: {
                        action: "get_node_reports",
                        post_id: postId,
                        node_id: nodeId,
                    },
                    success: function(response) {
                        if (response.success) {
                            const reports = response.data.reports;
                            const reportCount = reports.length;
                            const isAdmin = response.data.is_admin;
                            const userHasReported = response.data.user_has_reported;

                            $("#reportModal").find("#reportCount").text(`(${reportCount})`);
                            const $reportList = $("#reportModal").find("#reportList").empty();

                            if (userHasReported) {
                                $("#reportModal")
                                    .find("#submitReportButton")
                                    .prop("disabled", true)
                                    .text("You have already reported this post.");
                            } else {
                                $("#reportModal")
                                    .find("#submitReportButton")
                                    .prop("disabled", false)
                                    .text("Submit Report");
                            }

                            if (reportCount > 0) {
                                reports.forEach((report, index) => {
                                    const deleteButton = isAdmin ?
                                        `<button class="btn btn-sm delete-report blue-btn-hv" data-index="${index}" data-report-id="${report.comment_id}"><i class="fa fa-trash"></i></button>` :
                                        "";
                                    const editButton = report.is_author ?
                                        `<button class="btn btn-sm edit-report blue-btn-hv" data-index="${index}" style="display:none;" data-report-id="${report.comment_id}"><i class="fa fa-edit"></i></button>` :
                                        "";

                                    $reportList.prepend(`
                                <div data-index="${index}" class="report-item ">
                                    <div class="report-user">
                                        <div><b>${report.user_name}</b> <span>${report.timestamp}</span></div>
                                        <div>${deleteButton} ${editButton}</div>
                                    </div>
                                    <div class="comment-content report-content">
                                        <pre class="report-text">${report.report_text}</pre>
                                    </div>
                                </div>
                            `);
                                });

                            }
                        } else {
                            console.log("Error:", response.data);
                        }
                    },
                    error: function(error) {
                        console.log("Error fetching comments:", error);
                    },
                });
            });

            $("#reportModal").off("click").on("click", ".report-btn", function() {
                const reportText = $("#reportText").val().trim();

                if (!reportText) {
                    Swal.fire({
                        icon: "warning",
                        title: "Empty",
                        text: "Please enter a report before submitting.",
                        confirmButtonText: "OK"
                    });
                    return;
                }

                if (isUserLoggedIn !== "true") {
                    Swal.fire({
                        icon: "warning",
                        title: "Login Required",
                        text: "Please login to submit.",
                        confirmButtonText: "OK"
                    });
                    return;
                }

                const $reportButton = $(this);
                $reportButton.prop("disabled", true).text("Submitting...");

                $.ajax({
                    url: my_ajax_object.ajax_url,
                    type: "POST",
                    data: {
                        action: "submit_node_report",
                        post_id: postId,
                        node_id: nodeId,
                        report_text: reportText
                    },
                    success: function(response) {
                        if (response.success) {
                            const {
                                report_data,
                                is_admin,
                                is_author
                            } = response.data;
                            const deleteButton = is_admin ? `<button class="btn btn-sm delete-report blue-btn-hv" data-index="new" data-post-id="${postId}" data-node-id="${nodeId}"><i class="fa fa-trash"></i></button>` : "";
                            const editButton = is_author ? `<button class="btn btn-sm edit-report blue-btn-hv" style="display:none;" data-index="new" data-post-id="${postId}" data-node-id="${nodeId}"><i class="fa fa-edit"></i></button>` : "";

                            $("#reportList").prepend(
                                `<div class="report-item">
                        <div class="report-user">
                            <div><b>${report_data.user_name}</b> <span>${report_data.timestamp}</span></div>
                            <div>${deleteButton} ${editButton}</div>
                        </div>
                        <div class="report-content">
                            <pre class="report-text">${report_data.report_text}</pre>
                        </div>
                    </div>`
                            );

                            const currentCount = parseInt($("#reportCount").text().replace(/[()]/g, "")) + 1;
                            $("#reportCount").text(`(${currentCount})`);
                            $("#reportText").val("");

                            Swal.fire({
                                icon: "success",
                                title: "Report Submitted",
                                text: "Your report has been successfully submitted.",
                                timer: 1500,
                                showConfirmButton: false
                            });

                            $("#reportModal").modal("hide");
                            // Disable the report button for this user
                            // $(".share-report").prop("disabled", true).text("Report Submitted");

                        } else {
                            Swal.fire({
                                icon: "error",
                                title: "Error",
                                text: response.data.message || "Failed to submit the report."
                            });
                        }
                    },
                    error: function(error) {
                        Swal.fire({
                            icon: "error",
                            title: "Error",
                            text: "Unable to submit your report. Please try again."
                        });
                    },
                    complete: function() {
                        $reportButton.prop("disabled", false).text("Report");
                    }
                });
            });



            // Delete report functionality (for admins only)
            $("#reportList").off("click", ".delete-report").on("click", ".delete-report", function() {
                const $button = $(this);
                const reportIndex = $button.data("index");
                const $popup = $button.closest(".cst-pop-up");

                // SweetAlert2 Confirmation
                Swal.fire({
                    title: "Are you sure?",
                    text: "Do you want to delete this report? This action cannot be undone.",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Yes, delete it!",
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Proceed with deletion
                        $.ajax({
                            url: my_ajax_object.ajax_url,
                            type: "POST",
                            data: {
                                action: "delete_node_report",
                                post_id: postId,
                                node_id: nodeId,
                                report_index: reportIndex,
                            },
                            success: function(response) {
                                if (response.success) {
                                    // Remove the report item
                                    $button.closest(".report-item").remove();
                                    // const reportCount = parseInt($("#reportList").find("#reportCount").text().match(/\d+/)[0], 10) - 1;
                                    const reportCount = parseInt($("#reportCount").text().replace(/[()]/g, '')) - 1;
                                    $("#reportModal").find("#reportCount").text(`(${reportCount})`);
                                    console.log(reportCount);

                                    // Success Alert
                                    Swal.fire({
                                        title: "Deleted!",
                                        text: "The report has been deleted successfully.",
                                        icon: "success",
                                        timer: 2000,
                                        showConfirmButton: false,
                                    });
                                } else {
                                    // Error Alert
                                    Swal.fire({
                                        title: "Error!",
                                        text: response.data.message,
                                        icon: "error",
                                    });
                                }
                            },
                            error: function(error) {
                                console.log("Error deleting report:", error);
                                Swal.fire({
                                    title: "Error!",
                                    text: "An error occurred while deleting the report.",
                                    icon: "error",
                                });
                            },
                        });
                    }
                });
            });
        });

        // Close the popup
        $("body").on("click", ".pop-up-close", function() {
            const $closeButton = $(this);
            const $popup = $closeButton.closest(".cst-pop-up");

            $popup.hide().removeClass("open");
            $("body").removeClass("cst-modal-open");
        });
    });
</script>
<script>
    // like on posts
    jQuery(document).ready(function($) {
        const isUserLoggedIn = "<?php echo is_user_logged_in() ? 'true' : 'false'; ?>";

        // Disable pointer-events and cursor style for non-logged-in users
        if (isUserLoggedIn !== 'true') {
            $(".post-likes .like-icon").css({
                "pointer-events": "none",
            });
        } else {
            $(".post-likes .like-icon").css({
                // "pointer-events": "auto",
                "cursor": "pointer",
            });
        }
        $(".parent-node").on("click", ".like-icon", function() {
            const $likeIcon = $(this);
            const $parentNode = $likeIcon.closest(".parent-node");
            const postId = $parentNode.data("post-id");
            const nodeId = $parentNode.data("node-id");
            const currentUserId = "<?php echo get_current_user_id(); ?>";

            if (isUserLoggedIn !== 'true') {
                Swal.fire({
                    title: 'Login Required',
                    text: 'Please log in to like this node.',
                    icon: 'warning',
                    confirmButtonText: 'OK'
                });
                return;
            }
            const isLiked = $likeIcon.hasClass("liked");
            $likeIcon.toggleClass("liked");
            // AJAX request to update like status
            $.ajax({
                url: my_ajax_object.ajax_url,
                type: "POST",
                data: {
                    action: "update_node_like_status",
                    post_id: postId,
                    node_id: nodeId,
                    user_id: currentUserId,
                    like_status: !isLiked // Toggle like status
                },
                success: function(response) {
                    if (response.success) {
                        // Update the like count text
                        $parentNode.find(".like-count").text(response.data.like_count);
                    } else {
                        console.log("Error:", response.data);
                    }
                },
                error: function(error) {
                    console.log("Error updating like status:", error);
                }
            });
        });
    });
    // like on posts end
</script>

<script>
    jQuery(document).ready(function($) {

        // $('.drawflow-node').find('.input.input_1').first().addClass('inputConnected');
        var skipFirst = true;

        $('.drawflow-node').each(function() {
            // Find the first `.input.input_1` within the current node
            var inputElement = $(this).find('.input.input_1').first();

            // Skip the first time, but add the class for subsequent nodes
            if (!skipFirst) {
                inputElement.addClass('inputConnected');
            } else {
                skipFirst = false; // Set the flag to false after the first iteration
            }
        });
    });
</script>


<script>
    jQuery(document).ready(function($) {
        $('#node_edit').on('click', function() {
            // Get the base URL dynamically from a PHP variable
            var siteUrl = "<?php echo esc_url(home_url()); ?>";

            // PHP variables for post data
            var postSlug = "<?php echo esc_js(isset($post->post_name) ? $post->post_name : ''); ?>";
            var postCategory = "<?php echo esc_js(!empty(get_the_category($post->ID)) ? get_the_category($post->ID)[0]->slug : ''); ?>";
            var postCategoryname = "<?php echo esc_js(!empty(get_the_category($post->ID)) ? get_the_category($post->ID)[0]->name : ''); ?>";
            var postExcerpt = "<?php echo esc_js(wp_strip_all_tags(get_the_excerpt($post->ID))); ?>";

            // Create a hidden form element
            var form = $('<form>', {
                'method': 'POST',
                'action': siteUrl + '/node-update/', // Use the dynamic site URL
                'style': 'display: none;' // Hidden for debugging
            });

            // Append hidden inputs for each data
            form.append($('<input>', {
                'type': 'hidden',
                'name': 'post_slug',
                'value': postSlug
            }));
            form.append($('<input>', {
                'type': 'hidden',
                'name': 'post_category',
                'value': postCategory
            }));
            form.append($('<input>', {
                'type': 'hidden',
                'name': 'post_category_name',
                'value': postCategoryname
            }));
            form.append($('<input>', {
                'type': 'hidden',
                'name': 'post_excerpt',
                'value': postExcerpt
            }));

            // Append form to the body and submit it
            $('body').append(form);
            form.submit();
        });
    });






    // jQuery(document).ready(function($) {
    //     $('#node_edit').on('click', function() {
    //         // Get the base URL dynamically from a PHP variable
    //         var siteUrl = "<?php echo esc_url(home_url()); ?>";

    //         // PHP variables for post data
    //         var postSlug = "<?php echo esc_js($post->post_name); ?>";
    //         var postCategory = "<?php echo esc_js(get_the_category($post->ID)[0]->slug); ?>";
    //         var postCategoryname = "<?php echo esc_js(get_the_category($post->ID)[0]->name); ?>";
    //         var postExcerpt = "<?php echo esc_js(wp_strip_all_tags(get_the_excerpt($post->ID))); ?>";

    //         // Create a hidden form element
    //         var form = $('<form>', {
    //             'method': 'POST',
    //             'action': siteUrl + '/node-update/', // Use the dynamic site URL
    //             'style': 'display: none;' // Hidden for debugging
    //         });

    //         // Append hidden inputs for each data
    //         form.append($('<input>', {
    //             'type': 'hidden',
    //             'name': 'post_slug',
    //             'value': postSlug
    //         }));
    //         form.append($('<input>', {
    //             'type': 'hidden',
    //             'name': 'post_category',
    //             'value': postCategory
    //         }));
    //         form.append($('<input>', {
    //             'type': 'hidden',
    //             'name': 'post_category_name',
    //             'value': postCategoryname
    //         }));
    //         form.append($('<input>', {
    //             'type': 'hidden',
    //             'name': 'post_excerpt',
    //             'value': postExcerpt
    //         }));

    //         // Append form to the body and submit it
    //         $('body').append(form);
    //         form.submit();
    //     });
    // });








    // jQuery(document).ready(function($) {
    //     $('#node_edit').on('click', function() {
    //         // Get the base URL dynamically from a PHP variable
    //         var siteUrl = "<?php echo esc_url(home_url()); ?>";
    //         var postSlug = "<?php echo esc_js($post_slug); ?>";
    //         var companyName = "<?php echo esc_js($post_slug); ?>";
    //         var nodeData = <?php echo json_encode($node_data); ?>;
    //         var svgData = <?php echo json_encode($svg_data); ?>;

    //         // Create a form element
    //         var form = $('<form>', {
    //             'method': 'POST',
    //             'action': siteUrl + '/node-update/', // Use the dynamic site URL
    //             'style': 'display: none;' // Hidden for debugging
    //         });

    //         // Add inputs for serialized data
    //         $('<input>', {
    //             'type': 'hidden',
    //             'name': 'postSlug',
    //             'value': postSlug
    //         }).appendTo(form);

    //         $('<input>', {
    //             'type': 'hidden',
    //             'name': 'company_name',
    //             'value': companyName
    //         }).appendTo(form);

    //         $('<input>', {
    //             'type': 'hidden',
    //             'name': 'node_data',
    //             'value': JSON.stringify(nodeData)
    //         }).appendTo(form);

    //         $('<input>', {
    //             'type': 'hidden',
    //             'name': 'svg_data',
    //             'value': JSON.stringify(svgData)
    //         }).appendTo(form);

    //         // Append the form to the body and submit it
    //         form.appendTo('body').submit();
    //     });
    // });
</script>





<?php get_footer(); ?>