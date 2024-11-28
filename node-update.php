<?php
if (!is_user_logged_in()) {
    // Redirect to the login page if the user is not logged in
    wp_redirect(home_url('/sign-in/'));
    exit;
    // } elseif ( !current_user_can( 'editor' ) && !current_user_can( 'administrator' ) ) {
} elseif (!current_user_can('administrator')) {
    // Redirect to the homepage if the user is not an editor or administrator
    wp_redirect(home_url());
    exit;
}
?>
<?php /* Template Name:Node_update */ ?>
<?php get_header(); ?>

<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitize and retrieve the POST data
    $postSlug = isset($_POST['post_slug']) ? sanitize_text_field($_POST['post_slug']) : 'Not Provided';
    $postCategory = isset($_POST['post_category']) ? sanitize_text_field($_POST['post_category']) : 'Not Provided';
    $postCategoryName = isset($_POST['post_category_name']) ? sanitize_text_field($_POST['post_category_name']) : 'Not Provided';
    $postExcerpt = isset($_POST['post_excerpt']) ? sanitize_textarea_field($_POST['post_excerpt']) : 'Not Provided';

    // $postSlug = isset($_POST['postSlug']) ? $_POST['postSlug'] : 'Not Provided';
    // echo $postExcerpt;

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

$cst_post_data = $wpdb->get_results(
    $wpdb->prepare("SELECT * FROM $table_name WHERE company_slug = %s", $postSlug)
);

if (!empty($cst_post_data)) {
    // Get the first result row
    $data_row = $cst_post_data[0];

    // Print fields outside node_data
    // echo "Fields outside node_data:\n";
    // echo "ID: " . ($data_row->id ?? '') . "\n";
    // echo "Company Name: " . ($data_row->company_name ?? '') . "\n";
    // echo "Company Slug: " . ($data_row->company_slug ?? '') . "\n";
    // echo "Node Category: " . ($data_row->node_cat ?? '') . "\n";
    // echo "Node Country: " . ($data_row->node_country ?? '') . "\n";
    // echo "\n";

    // Store fields in individual variables
    $companyName = $data_row->company_name;
    $companyCat = $data_row->node_cat;
    $companyCountry = $data_row->node_country;

    // Print the stored variables
    // echo $companyName . '<br>' . $companyCat . '<br>' . $companyCountry . '<br>';

    // Extract node_data
    $node_data = maybe_unserialize($data_row->node_data);

    $formatted_node_data = [
        'data' => [] // Initialize the structure with "data"
    ];

    if (is_array($node_data)) {
        foreach ($node_data as $index => $node) {
            // Ensure proper string conversion for the class
            $node_class = isset($node['node_class'])
                ? (is_array($node['node_class']) ? implode(' ', $node['node_class']) : $node['node_class'])
                : 'add_node';

            // Add the node data to the array
            $formatted_node_data['data'][$index + 1] = [
                'id' => $index + 1, // Start IDs from 1
                'name' => $node_class,
                'data' => [],
                'class' => $node_class,
                'html' => '
                <div class="node-child ' . htmlspecialchars($node_class) . '-node">
                    <div class="add-node-btns" data-bs-target="#exampleModalToggle" data-bs-toggle="modal">
                        <i class="ri-edit-box-line"></i>
                    </div>
                    <div class="node-content">
                        <img src="' . htmlspecialchars($node['element_image_url'] ?? '') . '" alt="Upload Image" class="node-image" style="width:100%; height:100%;">
                        <p class="node-text">' . htmlspecialchars($node['element_text'] ?? '') . '</p>
                    </div>
                </div>
                <div class="resize-handle resize-handle-top"></div>
                <div class="resize-handle resize-handle-right"></div>
                <div class="resize-handle resize-handle-bottom"></div>
                <div class="resize-handle resize-handle-left"></div>
                ',
                'typenode' => false,
                'inputs' => [
                    'input_1' => [
                        'connections' => []
                    ]
                ],
                'outputs' => [
                    'output_1' => [
                        'connections' => []
                    ]
                ],
                'pos_x' => $node['element_left'] ?? '100px',
                'pos_y' => $node['element_top'] ?? '100px',
                'style' => [
                    'width' => $node['element_width'] ?? '100px',
                    'height' => $node['element_height'] ?? '150px'
                ]
            ];
        }
    }

    // Pass PHP array as JSON to JavaScript
    echo '<script>var phpNodeData = ' . json_encode($formatted_node_data['data']) . ';</script>';


    // Print node_data
    if (is_array($node_data)) {
        foreach ($node_data as $index => $node) {
            // Extract values for the current node
            $company_logo = $node['company_logo'] ?? '';
            $company_name = $node['company_name'] ?? '';
            $element_image_url = $node['element_image_url'] ?? '';
            $element_text = $node['element_text'] ?? '';
            $element_text_id = $node['element_text_id'] ?? '';
            $node_class = $node['node_class'] ?? [];
            $element_left = $node['element_left'] ?? '';
            $element_top = $node['element_top'] ?? '';
            $element_height = $node['element_height'] ?? '';
            $element_width = $node['element_width'] ?? '';

            // Print each node's data
            // echo "<div class='node-details'>";
            // echo "<h3>Node $index</h3>";
            // echo "<p><strong>Company Logo:</strong> <img src='$company_logo' alt='Company Logo' style='width:50px; height:50px;'></p>";
            // echo "<p><strong>Company Name:</strong> $company_name</p>";
            // echo "<p><strong>Element Image URL:</strong> <img src='$element_image_url' alt='Element Image' style='width:50px; height:50px;'></p>";
            // echo "<p><strong>Element Text:</strong> $element_text</p>";
            // echo "<p><strong>Element Text ID:</strong> $element_text_id</p>";
            // echo "<p><strong>Node Class:</strong> " . implode(', ', $node_class) . "</p>";
            // echo "<p><strong>Position:</strong> Left: $element_left, Top: $element_top</p>";
            // echo "<p><strong>Size:</strong> Height: $element_height, Width: $element_width</p>";
            // echo "</div>";
        }
    } else {
        echo "No valid node data found.\n";
    }

    $svg_data = maybe_unserialize($data_row->svg_data);  // Unserialize if needed
    $svgElements = ''; // Variable to store the generated SVG elements
    if (!empty($svg_data)) {
        foreach ($svg_data as $svg) {
            $svg_class = esc_attr($svg['svgClass']);
            foreach ($svg['pathDValues'] as $d_value) {
                $d_value = esc_attr($d_value);
                // echo '<svg class="' . $svg_class . '"><path class="main-path" d="' . $d_value . '"></path></svg>';
                $svgElements .= '<svg class="' . $svg_class . '"><path class="main-path" d="' . $d_value . '"></path></svg>';
            }
        }
    }

    // Pass the SVG elements as a JavaScript variable
    echo '<script> var svgElementsData = ' . esc_js($svgElements) . '; </script>';


    $drawflow_translate_values = maybe_unserialize($data_row->drawflow_translate_values);  // Unserialize if needed
    if (!empty($drawflow_translate_values)) {
        foreach ($drawflow_translate_values as $drawflow_translate) {
            $translateX = $drawflow_translate['translateX'] ?? 0;
            $translateY = $drawflow_translate['translateY'] ?? 0;
            // Build the transform style
            $transformStyle = "translate({$translateX}px, {$translateY}px) scale(1)";
        }
    }
    // Pass the transform style to JavaScript

    echo '<script> var drawflow_translate_values = "' . esc_js($transformStyle) . '"; </script>';
} else {
    echo "No data found for the given company_slug: $postSlug.\n";
}





// Fetch node data for the provided company name
// $nodes = $wpdb->get_results(
//     $wpdb->prepare("SELECT * FROM $table_name WHERE company_name = %s", $company_name)
// );

// if (!empty($nodes)) {
//     // Assuming you want to retrieve data from the first matched record
//     // $noddde_data = json_decode($nodes[0]->node_data, true); // Decode JSON if needed
//     $node_data = maybe_unserialize($nodes[0]->node_data); // Decode JSON if needed

//     // Extract and sanitize node data
//     foreach ($node_data as $node) {
//         $company_logo = esc_url($node['company_logo']);
//         $element_image_url = esc_url($node['element_image_url']);
//         $element_text = esc_html($node['element_text']);
//         $element_text_url = esc_url($node['element_text_url']);
//         $element_top = esc_attr($node['element_top']);
//         $element_left = esc_attr($node['element_left']);
//         $element_height = esc_attr($node['element_height']);
//         $element_width = esc_attr($node['element_width']);

//         // Do something with the extracted data
//         // echo 'Company Logo: ' . $company_logo . '<br>';
//         // echo 'Element Image URL: ' . $element_image_url . '<br>';
//         // echo 'Element Text: ' . $element_text . '<br>';
//         // echo 'Element Text URL: ' . $element_text_url . '<br>';
//         // echo 'Element Top: ' . $element_top . '<br>';
//         // echo 'Element Left: ' . $element_left . '<br>';
//         // echo 'Element Height: ' . $element_height . '<br>';
//         // echo 'Element Width: ' . $element_width . '<br>';
//     }
// }

// $svg_data = maybe_unserialize($nodes[0]->svg_data);  // Unserialize if needed

// if (!empty($svg_data)) {
//     foreach ($svg_data as $svg) {
//         $svg_class = esc_attr($svg['svgClass']);
//         foreach ($svg['pathDValues'] as $d_value) {
//             $d_value = esc_attr($d_value);
//             //     echo '<svg class="' . $svg_class . '"><path class="main-path" d="' . $d_value . '"></path></svg>';
//         }
//     }
// }

?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<div class="main-content-area">
    <div class="home-page">
        <div class="node-header">

            <nav class="node-nav">
                <ul class="nav-mesnu-scroll">
                    <li id="logo-container">
                        <label for="company-logo">Add Company Logo <i class="ri-add-large-line"></i></label>
                        <input type="file" id="company-logo" class="input-control" accept="image/*">
                    </li>
                    <li class="company-logo-img" id="company-logo-img">
                        <img src="<?php echo $company_logo;
                                    ?>" alt="company-logo" id="company-logo-image">
                        <button type="button" id="close-company-logo" class="btn-close" aria-label="Close"><i class="ri-close-large-line"></i></button>
                    </li>

                    <li id="company-name-text">
                        <label for="company-name" class="company-name">add company name <i class="ri-add-large-line"></i></label>
                        <input type="text" id="company-name" class="input-control" placeholder="Type Here...">
                    </li>
                    <li id="company-name-display">
                        <p><?php echo $company_name; ?></p>
                        <button type="button" id="close-company-name" class="btn-close" aria-label="Close"><i class="ri-close-large-line"></i></button>
                    </li>
                    <li class="company-dec">
                        <span id="openTextAreaBtn">Add Short Detail <i class="ri-add-large-line"></i></span>
                        <ul id="textArea">
                            <li id="textAreaContainer">
                                <textarea style="display:none;" id="textAreabox" rows="4.5" cols="22" placeholder="Enter your text here..."><?php echo $postExcerpt; ?></textarea>
                            </li>
                        </ul>
                    </li>
                    <li class="all-shapes">
                        <span id="add-node-btn"> add shape <i class="ri-add-large-line"></i></span>
                        <ul id="shapes-dropdown" style="display: none;">
                            <li class="drag-drawflow rectangle" draggable="true" ondragstart="drag(event)" data-node="add_node">
                            </li>
                            <li class="drag-drawflow circle" draggable="true" ondragstart="drag(event)" data-node="circle">
                            </li>
                            <li class="drag-drawflow diamond dis-none" draggable="true" ondragstart="drag(event)" data-node="diamond">
                            </li>
                            <li class="drag-drawflow parallel dis-none" draggable="true" ondragstart="drag(event)" data-node="parallel">
                            </li>
                            <li class="drag-drawflow rhombus dis-none" draggable="true" ondragstart="drag(event)" data-node="rhombus">
                                <svg viewBox="0 5 100 90">
                                    <path d="M50,10 L90,50 L50,90 L10,50 Z" fill="none" stroke="black" stroke-width="2" />
                                </svg>
                            </li>
                            <li class="drag-drawflow ocatgon dis-none" draggable="true" ondragstart="drag(event)" data-node="ocatgon">
                                <svg viewBox="0 5 100 90">
                                    <path d="M30,10 L70,10 L90,30 L90,70 L70,90 L30,90 L10,70 L10,30 Z" fill="none" stroke="black" stroke-width="2" />
                                </svg>
                            </li>
                        </ul>
                    </li>

                    <li class="company-cat" id="company-options">
                        <button class="dropdown-toggle" type="button" id="dropdownMenuButton1" aria-expanded="true">
                            <?php if (!empty($companyCat)) {
                                echo $companyCat;
                            } else {
                                echo "Select Category";
                            } ?>
                        </button>
                        <ul class="dropdown-menu" style="display: none;" aria-labelledby="dropdownMenuButton1">
                            <?php
                            // $uncategorized = get_category_by_slug('uncategorized');
                            // $exclude_category = $uncategorized ? array($uncategorized->term_id) : array();

                            $exclude_slugs = array('uncategorized', 'user-test-category');

                            // Get the term IDs based on slugs
                            $exclude_category = array();

                            foreach ($exclude_slugs as $slug) {
                                $term = get_term_by('slug', $slug, 'category');
                                if ($term) {
                                    $exclude_category[] = $term->term_id;
                                }
                            }


                            $terms = get_terms([
                                'taxonomy'   => 'category',
                                'orderby'    => 'name',
                                'order'      => 'ASC',
                                'hide_empty' => false,
                                'exclude'    => $exclude_category,
                            ]);

                            $terms = get_terms(['post_type' => 'post', 'taxonomy' => 'category', 'order' => 'DESC', 'hide_empty' => false]);
                            ?>

                            <?php foreach ($terms as $cat) { ?>
                                <li class="dropdown-item" data-text="<?php echo $cat->slug; ?>" data-value="<?php echo $cat->term_id; ?>"><?php echo $cat->name; ?></li>
                            <?php } ?>
                        </ul>
                    </li>
                    <li class="company-country edit-country" id="country-options" class="dropdown">
                        <button class="dropdown-toggle filter-option" type="button" id="dropdownMenuButton2" aria-expanded="true">
                            <?php if (!empty($companyCountry)) {
                                echo $companyCountry;
                            } else {
                                echo "Select Category";
                            } ?>
                        </button>
                        <ul id="country-list" class="dropdown-menu" style="display: none;" aria-labelledby="dropdownMenuButton2">

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
                        </ul>
                    </li>
                </ul>
                <!-- <a href="#" id ="save-node-data-button" class="primary-btn">publish</a> -->

                <button id="update-node-data-button" class="primary-btn">Update</button>
                <!-- <button id="save-node-data-button" class="primary-btn">publish</button> -->
            </nav>
        </div>
        <div id="chididdata"> </div>
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


<script>
    // Top line

    jQuery(document).ready(function($) {
        $('#logo-container').css('display', 'none');
        $('#company-logo-img').css('display', 'block');
        $('#company-name-text').css('display', 'none');
        $('#company-name-display').css('display', 'block');

        $('#company-logo').on('change', function(event) {
            var file = event.target.files[0];
            if (file) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    // Set the src attribute of the img tag inside #company-logo-img
                    $('#company-logo-img img').attr('src', e.target.result);
                    $('#company-logo-img img').attr('alt', 'Company Logo');

                    // Hide the company-logo div and show the company-logo-img div
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
            $('#company-logo').val(''); // Clear the file input value
        });


        // Function to handle displaying the company name
        function displayCompanyName() {
            var companyName = $('#company-name').val(); // Get the value of the input
            if (companyName.trim() !== "") { // Check if the input is not empty
                // Display the company name in the designated area
                $('#company-name-display p').text(companyName);
                $('#company-name-display').css('display', 'block');
                $('#company-name-text').css('display', 'none');
            }
        }

        // Handle the Enter key event in the company-name input
        $('#company-name').on('keydown', function(event) {
            if (event.key === 'Enter') {
                event.preventDefault(); // Prevent the default form submission behavior
                displayCompanyName(); // Call the function to display the company name
                $(this).blur(); // Trigger the blur event to save the input
            }
        });

        // Handle the blur event on the company-name input
        $('#company-name').on('blur', function() {
            displayCompanyName(); // Call the function to display the company name
        });

        // Handle the close button click event for the company name
        $('#close-company-name').on('click', function() {
            $('#company-name-display').css('display', 'none'); // Hide the company name display div
            $('#company-name-text').css('display', 'block');
        });

        // Add node button
        $('#add-node-btn').on('click', function() {
            $('#shapes-dropdown').slideToggle(); // Toggle the dropdown with a slide effect
        });
        // Dropdown in top
        $('#openTextAreaBtn').on('click', function() {
            // $('#textAreaContainer').show();
            $('#textAreabox').slideToggle();

        });

        // ----filters start----
        $('#dropdownMenuButton1').click(function() {
            $('#company-options .dropdown-menu').slideToggle();
        });
        // Handle selection from the dropdown
        $('#company-options .dropdown-item').on('click', function() {
            var selectedOption = $(this).data('value');

            // Remove 'select' class from all <li> elements and add it to the clicked one
            $('#company-options .dropdown-item').removeClass('selected');
            $(this).addClass('selected');

            $('#company-options .dropdown-toggle').text($(this).text());
            $('#company-options .dropdown-menu').hide();

        });
        // // Hide the dropdown if clicked outside
        $(document).on('click', function(e) {
            if (!$(e.target).closest('#company-options').length) {
                $('#company-options .dropdown-menu').hide();
            }
        });

        $('#dropdownMenuButton2').click(function() {
            $('#country-options .dropdown-menu').slideToggle();
        });
        // Handle selection from the dropdown
        $('#country-options .dropdown-item').on('click', function() {
            var selectedOption = $(this).data('value');

            // Remove 'select' class from all <li> elements and add it to the clicked one
            $('#country-options .dropdown-item').removeClass('selected');
            $(this).addClass('selected');

            $('#country-options .dropdown-toggle').text($(this).text());
            $('#country-options .dropdown-menu').hide();

        });
        // // Hide the dropdown if clicked outside
        $(document).on('click', function(e) {
            if (!$(e.target).closest('#country-options').length) {
                $('#country-options .dropdown-menu').hide();
            }
        });
        // ----filters ends----
    });



    // Modal handle
    jQuery(document).ready(function($) {
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
    setTimeout(function() {
        // Select the <div class="drawflow"> element
        // const drawflowElement = document.querySelector('.drawflow');
        // if (drawflowElement) {
        //     // drawflowElement.style.transform = 'translate(-17px, 27px) scale(1)';
        //     drawflowElement.style.transform = drawflow_translate_values;

        // } else {
        //     console.error('Element with class "drawflow" not found.');
        // }
    }, 1000);
</script>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/drawflow/dist/drawflow.min.css">
<script src="https://cdn.jsdelivr.net/npm/drawflow/dist/drawflow.min.js"></script>
<script>
    var id = document.getElementById("drawflow");
    const editor = new Drawflow(id);
    editor.reroute = true;
    // Initialize drawflow data
    editor.drawflow = {
        drawflow: {
            Home: {
                data: {}
            }
        }
    };

    // Ensure phpNodeData is correctly structured and not an array
    if (typeof phpNodeData !== "undefined" && phpNodeData !== null) {
        // console.log("Original PHP Node Data:", phpNodeData);

        // Reformat data if phpNodeData is an array (for added safety)
        if (Array.isArray(phpNodeData)) {
            const formattedNodeData = {};
            phpNodeData.forEach((node, index) => {
                formattedNodeData[index + 1] = {
                    id: index + 1,
                    ...node
                };
            });
            phpNodeData = formattedNodeData;
        }




        setTimeout(function() {
            // Select the <div class="drawflow"> element
            const drawflowElement = document.querySelector('.drawflow');
            if (drawflowElement) {
                // drawflowElement.style.transform = 'translate(-17px, 27px) scale(1)';
                drawflowElement.style.transform = drawflow_translate_values;

                // Now insert the SVGs after all the .parent-node divs
                // const parentNodes = drawflowElement.querySelectorAll('.parent-node');

                // if (parentNodes.length > 0 && svgElementsData) {
                //     // Loop through each parent node and insert SVG after it
                //     parentNodes.forEach(function(parentNode) {
                //         // Insert the SVG directly after each parent node
                //         // parentNode.insertAdjacentHTML('afterend', svgElementsData);
                //         // drawflowElement.insertAdjacentHTML('beforeend', svgElementsData);
                //     });
                //     // After all parent nodes, insert the SVGs
                //     drawflowElement.insertAdjacentHTML('beforeend', svgElementsData);
                // }
                // if (parentNodes.length > 0 && svgElementsData) {
                //     // Create a container for the SVGs if not already done
                //     // const svgContainer = document.createElement('div');
                //     // svgContainer.innerHTML = svgElementsData; // This will parse the string and turn it into DOM elements

                //     // After all parent nodes, append the SVG container
                //     // drawflowElement.appendChild(svgContainer);
                //     drawflowElement.appendChild(svgElementsData);
                // }

            } else {
                console.error('Element with class "drawflow" not found.');
            }
            // Now apply styles to each node after it's added to the drawflow
            for (const nodeId in phpNodeData) {
                const node = phpNodeData[nodeId];
                const nodeElement = document.getElementById(`node-${nodeId}`);
                // console.log('nodeElement:', nodeElement);
                // Apply positioning and sizing directly to the node's style
                if (nodeElement) {
                    nodeElement.style.top = `${node.pos_y}`;
                    nodeElement.style.left = `${node.pos_x}`;
                    nodeElement.style.width = node.style.width;
                    nodeElement.style.height = node.style.height;
                }
            }
        }, 500);

        // Populate editor.drawflow with reformatted data
        editor.drawflow.drawflow.Home.data = phpNodeData;
        // console.log("Updated Editor Drawflow:", editor.drawflow);
    } else {
        console.error("phpNodeData is not defined or is null.");
    }







    editor.drawf5low = {
        "drawflow": {
            "Home": {
                "data": {
                    "1": {
                        "id": 1,
                        "name": "add_node",
                        "data": {},
                        "class": "add_node",
                        "html": `
                            <div class="node-child">
                                <div class="add-node-btns" data-bs-target="#exampleModalToggle" data-bs-toggle="modal">
                                    <i class="ri-edit-box-line"></i>
                                </div>
                                <div class="node-content">
                                    <img src="<?php echo $element_image_url;
                                                ?>" alt="Upload Image" class="node-image" style="width:100%; height:100%;">
                                     <p class="node-text"><?php echo $element_text;
                                                            ?></p>
                                </div>
                            </div>
                            <div class="resize-handle resize-handle-top"></div>
                            <div class="resize-handle resize-handle-right"></div>
                            <div class="resize-handle resize-handle-bottom"></div>
                            <div class="resize-handle resize-handle-left"></div>
                        `,
                        "typenode": false,
                        "inputs": {
                            "input_1": {
                                "connections": []
                            }
                        },
                        "outputs": {
                            "output_1": {
                                "connections": [{
                                    "node": "2",
                                    "output": "input_1",
                                }]
                            }
                        },
                        "pos_x": 241,
                        "pos_y": 219
                    },
                    "2": {
                        "id": 2,
                        "name": "circle",
                        "data": {},
                        "class": "circle",
                        "html": `
                            <div class="node-child circle-node">
                                <div class="add-node-btns" data-bs-target="#exampleModalToggle" data-bs-toggle="modal">
                                    <i class="ri-edit-box-line"></i>
                                </div>
                                <div class="node-content">
                                     <img src="<?php echo $element_image_url;
                                                ?>" alt="Upload Image" class="node-image" style="width:100%; height:100%;">
                                     <p class="node-text"><?php echo $element_text;
                                                            ?></p>
                                </div>
                            </div>
                            <div class="resize-handle resize-handle-top"></div>
                            <div class="resize-handle resize-handle-right"></div>
                            <div class="resize-handle resize-handle-bottom"></div>
                            <div class="resize-handle resize-handle-left"></div>
                             `,
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
                                    "output": "input_1"
                                }]
                            }
                        },
                        "pos_x": 537,
                        "pos_y": 64
                    },
                    "3": {
                        "id": 3,
                        "name": "circle",
                        "data": {},
                        "class": "circle",
                        "html": `
                            <div class="node-child circle-node">
                                <div class="add-node-btns" data-bs-target="#exampleModalToggle" data-bs-toggle="modal">
                                    <i class="ri-edit-box-line"></i>
                                </div>
                                <div class="node-content">
                                    <img src="<?php echo $element_image_url;
                                                ?>" alt="Upload Image" class="node-image" style="width:100%; height:100%;">
                                     <p class="node-text"><?php echo $element_text;
                                                            ?></p>
                                </div>
                            </div>
                            <div class="resize-handle resize-handle-top"></div>
                            <div class="resize-handle resize-handle-right"></div>
                            <div class="resize-handle resize-handle-bottom"></div>
                            <div class="resize-handle resize-handle-left"></div>
                        `,
                        "typenode": false,
                        "inputs": {
                            "input_1": {
                                "connections": [{
                                    "node": "2",
                                    "input": "output_1"
                                }]
                            }
                        },
                        "outputs": {
                            "output_1": {
                                "connections": [{
                                    "node": "4",
                                    "output": "input_1"
                                }]
                            },
                        },
                        "pos_x": 884,
                        "pos_y": 22
                    },
                    "4": {
                        "id": 4,
                        "name": "add_node",
                        "data": {},
                        "class": "add_node",
                        "html": `
                            <div class="node-child add_node">
                                <div class="add-node-btns" data-bs-target="#exampleModalToggle" data-bs-toggle="modal">
                                    <i class="ri-edit-box-line"></i>
                                </div>
                                <div class="node-content">
                                    <img src="<?php echo $element_image_url;
                                                ?>" alt="Upload Image" class="node-image" style="width:100%; height:100%;">
                                    <p class="node-text"><?php echo $element_text;
                                                            ?></p>
                                </div>
                            </div>
                            <div class="resize-handle resize-handle-top"></div>
                            <div class="resize-handle resize-handle-right"></div>
                            <div class="resize-handle resize-handle-bottom"></div>
                            <div class="resize-handle resize-handle-left"></div>
                        `,
                        "typenode": false,
                        "inputs": {
                            "input_1": {
                                "connections": [{
                                        "node": "1",
                                        "input": "output_1"
                                    },
                                    {
                                        "node": "3",
                                        "input": "output_1"
                                    }

                                ]
                            }
                        },
                        "outputs": {
                            "output_1": {
                                "connections": []
                            }
                        },
                        "pos_x": 1168,
                        "pos_y": 148,
                        "style": {
                            "width": "500px",
                            "height": "500px"
                        }
                    },
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
        // jQuery('#node-' + connection.input_id + ' .' + connection.input_class).addClass('inputConnected');
        // jQuery('#node-' + connection.input_id + ' .' + connection.input_class).addClass('inputConnected');

        document.getElementById('node-' + connection.input_id).getElementsByClassName(connection.input_class)[0].classList.add('inputConnected');
    })

    editor.on('connectionRemoved', function(connection) {
        console.log('Connection removed');
        console.log(connection);
        document.getElementById('node-' + connection.input_id).getElementsByClassName(connection.input_class)[0].classList.remove('inputConnected');
    })

    editor.on('mouseMove', function(position) {
        // console.log('Position mouse x:' + position.x + ' y:' + position.y);
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
            case 'facebook':
                var facebook = `
        <div>
          <div class="title-box"><i class="fab fa-facebook"></i> Facebook Message</div>
        </div>
        `;
                editor.addNode('facebook', 0, 1, pos_x, pos_y, 'facebook', {}, facebook);
                break;
            case 'slack':
                var slackchat = `
          <div>
            <div class="title-box"><i class="fab fa-slack"></i> Slack chat message</div>
          </div>
          `
                editor.addNode('slack', 1, 0, pos_x, pos_y, 'slack', {}, slackchat);
                break;
            case 'personalized':
                var personalized = `
            <div>
              Personalized
            </div>
            `;
                editor.addNode('personalized', 1, 1, pos_x, pos_y, 'personalized', {}, personalized);
                break;

            case 'triangle':
                var triangleNode = `
            <div class="node-child triangle-node">
            <div class="add-node-btns" data-bs-target="#exampleModalToggle" data-bs-toggle="modal">
                  <i class="ri-edit-box-line"></i>
                  </div>

                  <div class="node-content-image">

                  <img src="<?php echo home_url(); ?>/wp-content/uploads/2024/08/no-image-default.png" alt="Upload Image" class="node-image">

                  </div>
                   <div class="node-image-url"></div>
                  <p class="node-text"></p>
                  </div>
                  <div class="resize-handle resize-handle-top"></div>
        <div class="resize-handle resize-handle-right"></div>
        <div class="resize-handle resize-handle-bottom"></div>
        <div class="resize-handle resize-handle-left"></div>
            </div>
            `;
                editor.addNode('triangle', 1, 1, pos_x, pos_y, 'triangle', {}, triangleNode);
                break;

            case 'circle':
                var circleNode = `
            <div class="node-child circle-node">
            <div class="add-node-btns" data-bs-target="#exampleModalToggle" data-bs-toggle="modal">
                  <i class="ri-edit-box-line"></i>
                  </div>
                  <div class="node-content-image">
                  <img src="<?php echo home_url(); ?>/wp-content/uploads/2024/08/no-image-default.png" alt="Upload Image" class="node-image">
                  </div>
                   <div class="node-image-url"></div>
                  <p class="node-text"></p>
                  </div>
                  <div class="resize-handle resize-handle-top"></div>
        <div class="resize-handle resize-handle-right"></div>
        <div class="resize-handle resize-handle-bottom"></div>
        <div class="resize-handle resize-handle-left"></div>
            `;
                editor.addNode('circle', 1, 1, pos_x, pos_y, 'circle', {}, circleNode);
                break;

            case 'diamond':
                var diamondNode = `
            <div class="node-child diamond-node">
                <div class="add-node-btns" data-bs-target="#exampleModalToggle" data-bs-toggle="modal">
                  <i class="ri-edit-box-line"></i>
                  </div>
                  <div class="node-content-image">
 <img src="<?php echo home_url(); ?>/wp-content/uploads/2024/08/no-image-default.png" alt="Upload Image" class="node-image">
                  </div>
                   <div class="node-image-url"></div>
                  <p class="node-text"></p>
                  </div>
                  <div class="resize-handle resize-handle-top"></div>
        <div class="resize-handle resize-handle-right"></div>
        <div class="resize-handle resize-handle-bottom"></div>
        <div class="resize-handle resize-handle-left"></div>
            </div>
            `;
                editor.addNode('diamond', 1, 1, pos_x, pos_y, 'diamond', {}, diamondNode);
                break;
            case 'parallel':
                var parallelNode = `
            <div class="node-child parallel-node">
                <div class="add-node-btns" data-bs-target="#exampleModalToggle" data-bs-toggle="modal">
                  <i class="ri-edit-box-line"></i>
                  </div>
                  <div class="node-content-image">
 <img src="<?php echo home_url(); ?>/wp-content/uploads/2024/08/no-image-default.png" alt="Upload Image" class="node-image">
                   <div class="node-image-url"></div>
                  <p class="node-text"></p>
                  </div>
                  <div class="resize-handle resize-handle-top"></div>
        <div class="resize-handle resize-handle-right"></div>
        <div class="resize-handle resize-handle-bottom"></div>
        <div class="resize-handle resize-handle-left"></div>
            </div>
            `;
                editor.addNode('parallel', 1, 1, pos_x, pos_y, 'parallel', {}, parallelNode);
                break;

            case 'rhombus':
                var rhombusNode = `
            <div class="node-child rhombus-node">
                <div class="add-node-btns" data-bs-target="#exampleModalToggle" data-bs-toggle="modal">
                  <i class="ri-edit-box-line"></i>
                  </div>
                  <div class="node-content-image">
 <img src="<?php echo home_url(); ?>/wp-content/uploads/2024/08/no-image-default.png" alt="Upload Image" class="node-image">
                  </div>
                   <div class="node-image-url"></div>
                  <p class="node-text"></p>
                  </div>
                  <div class="resize-handle resize-handle-top"></div>
        <div class="resize-handle resize-handle-right"></div>
        <div class="resize-handle resize-handle-bottom"></div>
        <div class="resize-handle resize-handle-left"></div>
            </div>
            `;
                editor.addNode('rhombus', 1, 1, pos_x, pos_y, 'rhombus', {}, rhombusNode);
                break;
            case 'ocatgon':
                var ocatgonNode = `
            <div class="node-child ocatgon-node">
                <div class="add-node-btns" data-bs-target="#exampleModalToggle" data-bs-toggle="modal">
                  <i class="ri-edit-box-line"></i>
                  </div>
                  <div class="node-content-image">
 <img src="<?php echo home_url(); ?>/wp-content/uploads/2024/08/no-image-default.png" alt="Upload Image" class="node-image">

                  </div>
                   <div class="node-image-url"></div>
                  <p class="node-text"></p>
                  </div>
                  <div class="resize-handle resize-handle-top"></div>
        <div class="resize-handle resize-handle-right"></div>
        <div class="resize-handle resize-handle-bottom"></div>
        <div class="resize-handle resize-handle-left"></div>
            </div>
            `;
                editor.addNode('ocatgon', 1, 1, pos_x, pos_y, 'ocatgon', {}, ocatgonNode);
                break;

            case 'add_node':
                var add_node = `
                  <div class="node-child">
                  <div class="add-node-btns" data-bs-target="#exampleModalToggle" data-bs-toggle="modal">
                  <i class="ri-edit-box-line"></i>
                  </div>
                  <div class="node-content-image">
                  <img src="<?php echo home_url(); ?>/wp-content/uploads/2024/08/no-image-default.png" alt="Upload Image" class="node-image">
                  </div>
                  <div class="node-image-url"></div>
                  <p class="node-text"></p>
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

<script>
    jQuery(document).ready(function($) {
        let startX, startY, startWidth, startHeight, startLeft, startTop, handle;
        let $resizing;
        $(document).on('mousedown', '.resize-handle', function(e) {
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