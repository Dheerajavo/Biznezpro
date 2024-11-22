<?php /* Template Name: Account */ ?>
<?php get_header(); ?>

<!-- main content area start -->
<div class="main-content-area">
    <div class="industry">
        <div class="top-bar">
            <div class="top-bar-wrap">
                <!-- <a href="index.html" class="logo">
                            <div class="logo-holder">
                                <img src="images/site-logo.png" alt="site-logo">
                            </div>
                        </a> -->
                <select id="country" name="country" class="input-control">
                    <option value="AF">Afghanistan</option>
                    <option value="AL">Albania</option>
                    <option value="DZ">Algeria</option>
                    <option value="AS">American Samoa</option>
                    <option value="AD">Andorra</option>
                    <option value="AO">Angola</option>
                    <option value="AI">Anguilla</option>
                    <option value="AQ">Antarctica</option>
                    <option value="AG">Antigua and Barbuda</option>
                    <option value="AR">Argentina</option>
                    <option value="AM">Armenia</option>
                    <option value="AW">Aruba</option>
                    <option value="AU">Australia</option>
                    <option value="AT">Austria</option>
                    <option value="AZ">Azerbaijan</option>
                    <option value="BS">Bahamas</option>
                    <option value="BH">Bahrain</option>
                    <option value="BD">Bangladesh</option>
                    <option value="BB">Barbados</option>
                    <option value="BY">Belarus</option>
                    <option value="BE">Belgium</option>
                    <option value="BZ">Belize</option>
                    <option value="BJ">Benin</option>
                    <option value="BM">Bermuda</option>
                    <option value="BT">Bhutan</option>
                    <option value="BO">Bolivia</option>
                    <option value="BA">Bosnia and Herzegovina</option>
                    <option value="BW">Botswana</option>
                    <option value="BR">Brazil</option>
                    <option value="IO">British Indian Ocean Territory</option>
                    <option value="BN">Brunei Darussalam</option>
                    <option value="BG">Bulgaria</option>
                    <option value="BF">Burkina Faso</option>
                    <option value="BI">Burundi</option>
                    <option value="KH">Cambodia</option>
                    <option value="CM">Cameroon</option>
                    <option value="CA">Canada</option>
                    <option value="CV">Cape Verde</option>
                    <option value="KY">Cayman Islands</option>
                    <option value="CF">Central African Republic</option>
                    <option value="TD">Chad</option>
                    <option value="CL">Chile</option>
                    <option value="CN">China</option>
                    <option value="CX">Christmas Island</option>
                    <option value="CC">Cocos (Keeling) Islands</option>
                    <option value="CO">Colombia</option>
                    <option value="KM">Comoros</option>
                    <option value="CG">Congo</option>
                    <option value="CD">Congo, The Democratic Republic of The</option>
                    <option value="CK">Cook Islands</option>
                    <option value="CR">Costa Rica</option>
                    <option value="CI">Cote D'ivoire</option>
                    <option value="HR">Croatia</option>
                    <option value="CU">Cuba</option>
                    <option value="CY">Cyprus</option>
                    <option value="CZ">Czech Republic</option>
                    <option value="DK">Denmark</option>
                    <option value="DJ">Djibouti</option>
                    <option value="DM">Dominica</option>
                    <option value="DO">Dominican Republic</option>
                    <option value="EC">Ecuador</option>
                    <option value="EG">Egypt</option>
                    <option value="SV">El Salvador</option>
                    <option value="GQ">Equatorial Guinea</option>
                    <option value="ER">Eritrea</option>
                    <option value="EE">Estonia</option>
                    <option value="ET">Ethiopia</option>
                    <option value="FK">Falkland Islands (Malvinas)</option>
                    <option value="FO">Faroe Islands</option>
                    <option value="FJ">Fiji</option>
                    <option value="FI">Finland</option>
                    <option value="FR">France</option>
                    <option value="GF">French Guiana</option>
                    <option value="PF">French Polynesia</option>
                    <option value="TF">French Southern Territories</option>
                    <option value="GA">Gabon</option>
                    <option value="GM">Gambia</option>
                    <option value="GE">Georgia</option>
                    <option value="DE">Germany</option>
                    <option value="GH">Ghana</option>
                    <option value="GI">Gibraltar</option>
                    <option value="GR">Greece</option>
                    <option value="GL">Greenland</option>
                    <option value="GD">Grenada</option>
                    <option value="GP">Guadeloupe</option>
                    <option value="GU">Guam</option>
                    <option value="GT">Guatemala</option>
                    <option value="GG">Guernsey</option>
                    <option value="GN">Guinea</option>
                    <option value="GW">Guinea-bissau</option>
                    <option value="GY">Guyana</option>
                    <option value="HT">Haiti</option>
                    <option value="VA">Holy See (Vatican City State)</option>
                    <option value="HN">Honduras</option>
                    <option value="HK">Hong Kong</option>
                    <option value="HU">Hungary</option>
                    <option value="IS">Iceland</option>
                    <option value="IN">India</option>
                    <option value="ID">Indonesia</option>
                    <option value="IR">Iran, Islamic Republic of</option>
                    <option value="IQ">Iraq</option>
                    <option value="IE">Ireland</option>
                    <option value="IM">Isle of Man</option>
                    <option value="IL">Israel</option>
                    <option value="IT">Italy</option>
                    <option value="JM">Jamaica</option>
                    <option value="JP">Japan</option>
                    <option value="JE">Jersey</option>
                    <option value="JO">Jordan</option>
                    <option value="KZ">Kazakhstan</option>
                    <option value="KE">Kenya</option>
                    <option value="KI">Kiribati</option>
                    <option value="KP">Korea, Democratic People's Republic of</option>
                    <option value="KR">Korea, Republic of</option>
                    <option value="KW">Kuwait</option>
                    <option value="KG">Kyrgyzstan</option>
                    <option value="LA">Lao People's Democratic Republic</option>
                    <option value="LV">Latvia</option>
                    <option value="LB">Lebanon</option>
                    <option value="LS">Lesotho</option>
                    <option value="LR">Liberia</option>
                    <option value="LY">Libya</option>
                    <option value="LI">Liechtenstein</option>
                    <option value="LT">Lithuania</option>
                    <option value="LU">Luxembourg</option>
                    <option value="MO">Macao</option>
                    <option value="MK">Macedonia, The Former Yugoslav Republic of</option>
                    <option value="MG">Madagascar</option>
                    <option value="MW">Malawi</option>
                    <option value="MY">Malaysia</option>
                    <option value="MV">Maldives</option>
                    <option value="ML">Mali</option>
                    <option value="MT">Malta</option>
                    <option value="MH">Marshall Islands</option>
                    <option value="MQ">Martinique</option>
                    <option value="MR">Mauritania</option>
                    <option value="MU">Mauritius</option>
                    <option value="YT">Mayotte</option>
                    <option value="MX">Mexico</option>
                    <option value="FM">Micronesia, Federated States of</option>
                    <option value="MD">Moldova, Republic of</option>
                    <option value="MC">Monaco</option>
                    <option value="MN">Mongolia</option>
                    <option value="ME">Montenegro</option>
                    <option value="MS">Montserrat</option>
                    <option value="MA">Morocco</option>
                    <option value="MZ">Mozambique</option>
                    <option value="MM">Myanmar</option>
                    <option value="NA">Namibia</option>
                    <option value="NR">Nauru</option>
                    <option value="NP">Nepal</option>
                    <option value="NL">Netherlands</option>
                    <option value="NC">New Caledonia</option>
                    <option value="NZ">New Zealand</option>
                    <option value="NI">Nicaragua</option>
                    <option value="NE">Niger</option>
                    <option value="NG">Nigeria</option>
                    <option value="NU">Niue</option>
                    <option value="NF">Norfolk Island</option>
                    <option value="MP">Northern Mariana Islands</option>
                    <option value="NO">Norway</option>
                    <option value="OM">Oman</option>
                    <option value="PK">Pakistan</option>
                    <option value="PW">Palau</option>
                    <option value="PS">Palestinian Territory, Occupied</option>
                    <option value="PA">Panama</option>
                    <option value="PG">Papua New Guinea</option>
                    <option value="PY">Paraguay</option>
                    <option value="PE">Peru</option>
                    <option value="PH">Philippines</option>
                    <option value="PN">Pitcairn</option>
                    <option value="PL">Poland</option>
                    <option value="PT">Portugal</option>
                    <option value="PR">Puerto Rico</option>
                    <option value="QA">Qatar</option>
                    <option value="RE">Reunion</option>
                    <option value="RO">Romania</option>
                    <option value="RU">Russian Federation</option>
                    <option value="RW">Rwanda</option>
                    <option value="SH">Saint Helena</option>
                    <option value="KN">Saint Kitts and Nevis</option>
                    <option value="LC">Saint Lucia</option>
                    <option value="PM">Saint Pierre and Miquelon</option>
                    <option value="VC">Saint Vincent and The Grenadines</option>
                    <option value="WS">Samoa</option>
                    <option value="SM">San Marino</option>
                    <option value="ST">Sao Tome and Principe</option>
                    <option value="SA">Saudi Arabia</option>
                    <option value="SN">Senegal</option>
                    <option value="RS">Serbia</option>
                    <option value="SC">Seychelles</option>
                    <option value="SL">Sierra Leone</option>
                    <option value="SG">Singapore</option>
                    <option value="SK">Slovakia</option>
                    <option value="SI">Slovenia</option>
                    <option value="SB">Solomon Islands</option>
                    <option value="SO">Somalia</option>
                    <option value="ZA">South Africa</option>
                    <option value="GS">South Georgia and The South Sandwich Islands</option>
                    <option value="ES">Spain</option>
                    <option value="LK">Sri Lanka</option>
                    <option value="SD">Sudan</option>
                    <option value="SR">Suriname</option>
                    <option value="SJ">Svalbard and Jan Mayen</option>
                    <option value="SZ">Swaziland</option>
                    <option value="SE">Sweden</option>
                    <option value="CH">Switzerland</option>
                    <option value="SY">Syrian Arab Republic</option>
                    <option value="TW">Taiwan, Province of China</option>
                    <option value="TJ">Tajikistan</option>
                    <option value="TZ">Tanzania, United Republic of</option>
                    <option value="TH">Thailand</option>
                    <option value="TL">Timor-leste</option>
                    <option value="TG">Togo</option>
                    <option value="TK">Tokelau</option>
                    <option value="TO">Tonga</option>
                    <option value="TT">Trinidad and Tobago</option>
                    <option value="TN">Tunisia</option>
                    <option value="TR">Turkey</option>
                    <option value="TM">Turkmenistan</option>
                    <option value="TC">Turks and Caicos Islands</option>
                    <option value="TV">Tuvalu</option>
                    <option value="UG">Uganda</option>
                    <option value="UA">Ukraine</option>
                    <option value="AE">United Arab Emirates</option>
                    <option value="GB">United Kingdom</option>
                    <option value="US">United States</option>
                    <option value="UY">Uruguay</option>
                    <option value="UZ">Uzbekistan</option>
                    <option value="VU">Vanuatu</option>
                    <option value="VE">Venezuela</option>
                    <option value="VN">Viet Nam</option>
                    <option value="VG">Virgin Islands, British</option>
                    <option value="VI">Virgin Islands, U.S.</option>
                    <option value="WF">Wallis and Futuna</option>
                    <option value="EH">Western Sahara</option>
                    <option value="YE">Yemen</option>
                    <option value="ZM">Zambia</option>
                    <option value="ZW">Zimbabwe</option>
                </select>
                <input type="text" class="input-control" placeholder="Search...">
            </div>
        </div>
        <div class="industry-content">

            <div class="tab-content-main">
                <div class="grid">
                    <div class="item">
                        <h4 class="sub-heading">Account</h4>
                        <ul class="nav nav-tabs flex-column" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact-tab-pane" type="button" role="tab" aria-controls="contact-tab-pane" aria-selected="true">Profile</button>
                            </li>
                            <li class="nav-item" id="admin_editor" role="presentation">
                                <button class="nav-link admin_editor" id="home-tab" data-bs-toggle="tab" data-bs-target="#home-tab-pane" type="button" role="tab" aria-controls="home-tab-pane" aria-selected="false">Process</button>
                            </li>
                            <li class="nav-item" id="admin_only" role="presentation">
                                <button class="nav-link" id="disabled-tab" data-bs-toggle="tab" data-bs-target="#dlt-str-tab-pane" type="button" role="tab" aria-controls="dlt-str-tab-pane" aria-selected="false">Structures Delete Requests</button>
                            </li>
                            <li class="nav-item" id="admin_only" role="presentation">
                                <button class="nav-link" id="disabled-tab" data-bs-toggle="tab" data-bs-target="#childpage-tab-pane" type="button" role="tab" aria-controls="childpage-tab-pane" aria-selected="false">Sub-Structures</button>
                            </li>
                            <li class="nav-item " id="admin_only" role="presentation">
                                <button class="nav-link admin_editor" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile-tab-pane" type="button" role="tab" aria-controls="profile-tab-pane" aria-selected="false">Editors and Subscriber List</button>
                            </li>
                            <li class="nav-item" id="admin_only" role="presentation">
                                <button class="nav-link" id="disabled-tab" data-bs-toggle="tab" data-bs-target="#dlt-acc-tab-pane" type="button" role="tab" aria-controls="dlt-acc-tab-pane" aria-selected="false">Account Delete Requests</button>
                            </li>
                            <li class="nav-item" id="admin_only" role="presentation">
                                <button class="nav-link" id="user-req" data-bs-toggle="tab" data-bs-target="#user-req-tab-pane" type="button" role="tab" aria-controls="user-req-tab-pane" aria-selected="false">Become Editor Requests</button>
                            </li>
                            <li class="nav-item" id="admin_editor" role="presentation">
                                <button class="nav-link" id="disabled-tab" data-bs-toggle="tab" data-bs-target="#category-tab-pane" type="button" role="tab" aria-controls="category-tab-pane" aria-selected="false">All Industry Categories</button>
                            </li>
                            <li class="nav-item" id="admin_only" role="presentation">
                                <button class="nav-link" id="dlt-req" data-bs-toggle="tab" data-bs-target="#dlt-industry-tab-pane" type="button" role="tab" aria-controls="dlt-industry-tab-pane" aria-selected="false">Delete Category Requests</button>
                            </li>

                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="disabled-tab" data-bs-toggle="tab" data-bs-target="#disabled-tab-pane" type="button" role="tab" aria-controls="disabled-tab-pane" aria-selected="false">Help</button>
                            </li>

                        </ul>

                        <div class="log-btn">
                            <a class="nav-link" id="Log-tab" href="<?php echo wp_logout_url(home_url('/sign-in/')) ?>">Log Out</a>
                        </div>
                    </div>
                    <div class="item">
                        <div class="tab-content" id="myTabContent">
                            <?php include get_stylesheet_directory() . '/template-parts/profile.php'; ?>
                            <?php include get_stylesheet_directory() . '/template-parts/process.php'; ?>
                            <?php include get_stylesheet_directory() . '/template-parts/dlt-str-req.php'; ?>
                            <div class="tab-pane fade" id="profile-tab-pane" role="tabpanel" aria-labelledby="profile-tab" tabindex="0">
                                <div class="mod-wrap">
                                    <div class="container">
                                        <div class="three">
                                            <div class="oned">
                                                <div class="user">Username</div>
                                                <div class="roots">Role</div>
                                            </div>
                                            <!-- <div class="Add-new">
                                                <a href="#" target="_blank">Add New Category</a>
                                            </div> -->
                                        </div>
                                        <?php
                                        $args = array(
                                            'role__in' => array('editor', 'subscriber')
                                        );

                                        $users = get_users($args);

                                        // If users are found
                                        if (!empty($users)) {
                                            foreach ($users as $user) {

                                                // Second row for edit and delete options
                                                echo '<div class="twoth">
                                                        <div class="rolling">
                                                            <div class="agri">' . esc_html($user->display_name) . '</div>
                                                            <div class="adri">' . implode(', ', $user->roles) . '</div>
                                                        </div>
                                                        <div class="mod-list-btns">
                                                            <a class="edit" href="#"></a>
                                                            <a class="dis delete-user" href="#" data-user-id="' . $user->ID . '"><i class="fas fa-trash-alt"></i></a>
                                                        </div>
                                                    </div>';

                                                // Close container div
                                            }
                                        } else {
                                            echo '<p>No editors or subscribers found.</p>';
                                        } ?>
                                    </div>
                                </div>
                            </div>
                            <?php include get_stylesheet_directory() . '/template-parts/dlt-acc-req.php'; ?>
                            <?php include get_stylesheet_directory() . '/template-parts/user_req.php'; ?>
                            <?php include get_stylesheet_directory() . '/template-parts/dlt-category-req.php'; ?>
                            <div class="tab-pane fade" id="disabled-tab-pane" role="tabpanel" aria-labelledby="disabled-tab" tabindex="0">Lorem, ipsum dolor sit amet <p>consectetur adipisicing elit. Neque quidem explicabo architecto tenetur illum eum expedita dignissimos repellendus natus? Illo maiores ex nesciunt alias non iusto fugit voluptatum adipisci rem.consectetur adipisicing elit. Neque quidem explicabo architecto tenetur illum eum expedita dignissimos repellendus natus? Illo maiores ex nesciunt alias non iusto fugit voluptatum adipisci rem.</p>
                            </div>
                            <div class="tab-pane fade" id="childpage-tab-pane" role="tabpanel" aria-labelledby="disabled-tab" tabindex="0">
                                <div class="content-wrap">
                                    <?php
                                    $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
                                    echo get_pages_with_template('node-child-view.php');
                                    ?>
                                </div>
                            </div>
                            <?php
                            function get_pages_with_template($template_file = 'node-child-view.php', $paged = 1, $posts_per_page = 5)
                            {
                                // Arguments for the query
                                $args = array(
                                    'post_type'      => 'page',
                                    'post_status'    => 'publish',
                                    'meta_key'       => '_wp_page_template',
                                    'meta_value'     => $template_file,  // Template file name (as stored in the database)
                                    'posts_per_page' => $posts_per_page, // Number of posts per page
                                    'paged'          => $paged, // Current page number
                                );

                                // Create a new WP_Query
                                $template_query = new WP_Query($args);

                                $output = '';

                                // Check if pages with the template exist
                                if ($template_query->have_posts()) {
                                    $output .= '<div class="process-main"><ul class="mod-list">';

                                    // Loop through the pages and add them to the output
                                    while ($template_query->have_posts()) {
                                        $template_query->the_post();

                                        // Get the delete URL (nonce for security)
                                        $delete_url = wp_nonce_url(
                                            admin_url('admin-post.php?action=delete_page&post_id=' . get_the_ID()),
                                            'delete_page_' . get_the_ID()
                                        );

                                        // Add each page title with a delete button
                                        $output .= '<li>';
                                        $output .= '<span>' . get_the_title() . '</span>';
                                        $output .= '<div class="mod-list-btns">';
                                        $output .= '<a href="' . get_permalink() . '">View</a>';
                                        $output .= '<a href="' . esc_url($delete_url) . '" class="delete-button">';
                                        $output .= '<i class="fas fa-trash-alt"></i>';  // FontAwesome delete icon
                                        $output .= '</a>';

                                        $output .= '</div>';
                                        $output .= '</li>';
                                    }

                                    $output .= '</ul></div>';

                                    // Pagination
                                    $big = 999999999; // need an unlikely integer
                                    $output .= '<div class="pagination_two">';
                                    $output .= paginate_links(array(
                                        'base'      => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
                                        'format'    => '?paged=%#%',
                                        'current'   => max(1, $paged),
                                        'total'     => $template_query->max_num_pages,
                                        'prev_text' => __('« Prev'),
                                        'next_text' => __('Next »'),
                                    ));
                                    $output .= '</div>';
                                } else {
                                    // No pages found
                                    $output .= '<p>No pages found with the ' . esc_html($template_file) . ' template.</p>';
                                }

                                // Restore original Post Data
                                wp_reset_postdata();

                                return $output; // Return the generated HTML
                            }
                            ?>


                            <?php include get_stylesheet_directory() . '/template-parts/category.php'; ?>

                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

</main>
<style>
    .pagination_two {
        justify-content: center;
        align-items: center;
        gap: 10px;
        margin-top: 25px;
    }

    /*
    .pagination_two .page-numbers.current {
        color: var(--theme1);
        border: 2px solid;
        border-radius: 50%;
        padding: 5px;
    } */
    .pagination_two .page-numbers.current {
        background-color: var(--theme1);
        color: #fff;
        border: 2px solid transparent;
        border-radius: 5px;
        padding: 5px;
        width: 30px;
        text-align: center;
        height: 32px;
    }

    .pagination_two a.next,
    .pagination_two a.prev {
        color: var(--theme1);
    }

    .Add-new a {
        font-size: 14px;
        text-transform: uppercase;
        padding: 13px 20px;
        background-color: #57c8ca;
        border: 1px solid #57c8ca;
        transition: all 0.3s linear;
        color: #fff;
        font-weight: 500;
        display: inline-block;
        border-radius: 40px;
    }

    .fade:not(.show) {
        opacity: 1;
    }

    .three {
        display: flex;
        justify-content: space-between;
        background: #fafafa;
        padding: 20px;
    }

    .oned {
        justify-content: space-between;
        width: 60%;
        align-items: center;
        display: grid;
        grid-template-columns: 1fr 1fr;
    }

    .twoth {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 30px 20px;
        border-bottom: 1px solid #ededed;
    }

    .dis {
        display: flex;
        justify-content: space-between;
        gap: 20px;
    }

    .rolling {
        justify-content: space-between;
        width: 60%;
        align-items: center;
        display: grid;
        grid-template-columns: 1fr 1fr;
    }
</style>
<script>
    var isAdmin = <?php echo json_encode(current_user_can('administrator')); ?>;
    var isEditor = <?php echo json_encode(current_user_can('editor')); ?>;
    jQuery(document).ready(function($) {

        // Function to load categories via AJAX and handle pagination
        function loadCategories(paged) {
            $.ajax({
                url: '<?php echo admin_url("admin-ajax.php"); ?>',
                type: 'POST',
                data: {
                    action: 'load_categories',
                    paged: paged
                },
                success: function(response) {
                    if (response.success) {
                        $('#category-tab-pane').html(response.data);
                        rebindEvents(); // Rebind events for new content
                    } else {
                        Swal.fire('Error!', 'Unable to load categories.', 'error');
                    }
                },
                error: function() {
                    Swal.fire('Error!', 'AJAX request failed.', 'error');
                }
            });
        }

        // Rebind all events after pagination or new content is loaded
        function rebindEvents() {

            // Use event delegation to bind the Add New Category button
            $(document).off('click', '#open-category-popup').on('click', '#open-category-popup', function() {
                $('#category-name').val('');
                $('#category-id').val('');
                $('#popup-title').text('Add New Industry');
                $('#submit-button').val('Add Industry');
                $('#category-popup').fadeIn(); // Show the popup
            });

            // Close popup
            $(document).off('click', '#close-popup').on('click', '#close-popup', function() {
                $('#category-popup').fadeOut(); // Hide the popup
            });

            // Handle form submission for adding/editing categories
            $(document).off('submit', '#category-form').on('submit', '#category-form', function(e) {
                e.preventDefault();
                var categoryName = $('#category-name').val();
                var categoryId = $('#category-id').val();

                $.ajax({
                    url: '<?php echo admin_url("admin-ajax.php"); ?>',
                    type: 'POST',
                    data: {
                        action: categoryId ? 'edit_category' : 'add_new_category',
                        category_name: categoryName,
                        category_id: categoryId
                    },
                    success: function(response) {
                        if (response.success) {
                            Swal.fire('Success!', 'Industry updated successfully!', 'success');
                            $('#category-popup').fadeOut(); // Hide the popup
                            loadCategories(1); // Reload the first page of categories
                        } else {
                            Swal.fire('Error!', response.data, 'error');
                        }
                    },
                    error: function() {
                        Swal.fire('Error!', 'AJAX request failed', 'error');
                    }
                });
            });

            // Handle edit category
            $(document).off('click', '.edit-category').on('click', '.edit-category', function(e) {
                e.preventDefault();
                var categoryId = $(this).data('id');

                $.ajax({
                    url: '<?php echo admin_url("admin-ajax.php"); ?>',
                    type: 'POST',
                    data: {
                        action: 'get_category_details',
                        category_id: categoryId
                    },
                    success: function(response) {
                        if (response.success) {
                            $('#category-name').val(response.data.name);
                            $('#category-id').val(categoryId);
                            $('#popup-title').text('Update Industry');
                            $('#submit-button').val('Update Industry');
                            $('#category-popup').fadeIn(); // Show the popup
                        } else {
                            Swal.fire('Error!', response.data, 'error');
                        }
                    },
                    error: function() {
                        Swal.fire('Error!', 'AJAX request failed.', 'error');
                    }
                });
            });

            // Handle delete category
            $(document).off('click', '.delete-category').on('click', '.delete-category', function(e) {
                e.preventDefault();
                var categoryId = $(this).data('id');
                // Check user role
                if (isEditor) {
                    // If the user is an editor, send a request to notify the admin
                    $.ajax({
                        url: '<?php echo admin_url("admin-ajax.php"); ?>',
                        type: 'POST',
                        data: {
                            action: 'notify_admin_category_delete',
                            category_id: categoryId
                        },
                        success: function(response) {
                            if (response.success) {
                                Swal.fire('Request Sent', 'Your request to delete this category has been sent to the admin.', 'info');
                            } else {
                                Swal.fire('Error!', response.data, 'error');
                            }
                        },
                        error: function() {
                            Swal.fire('Error!', 'AJAX request failed.', 'error');
                        }
                    });
                } else if (isAdmin) {

                    Swal.fire({
                        title: 'Are you sure?',
                        text: "This action cannot be undone!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, delete it!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                url: '<?php echo admin_url("admin-ajax.php"); ?>',
                                type: 'POST',
                                data: {
                                    action: 'delete_category',
                                    category_id: categoryId
                                },
                                success: function(response) {
                                    if (response.success) {
                                        Swal.fire('Deleted!', 'Industry has been deleted.', 'success');
                                        loadCategories(1); // Reload the first page
                                    } else {
                                        Swal.fire('Error!', response.data, 'error');
                                    }
                                },
                                error: function() {
                                    Swal.fire('Error!', 'AJAX request failed.', 'error');
                                }
                            });
                        }
                    });

                }
            });
        }

        // Initial binding of events
        rebindEvents();

        // Handle pagination click events
        $(document).on('click', '.pagination a', function(e) {
            e.preventDefault();
            var paged = $(this).attr('href').split('page/')[1];
            loadCategories(paged);
        });



        function loadchilpages(page) {
            $.ajax({
                type: 'POST',
                url: '<?php echo admin_url("admin-ajax.php"); ?>',
                data: {
                    action: 'ajax_pagination',
                    page: page
                },
                beforeSend: function() {
                    // Optional: Add a loading spinner or animation here
                    $('#childpage-tab-pane').html('<p>Loading...</p>');
                },
                success: function(response) {
                    if (response.success) {
                        // Replace the content inside the #childpage-tab-pane div
                        $('#childpage-tab-pane').html(response.data);
                    } else {
                        $('#childpage-tab-pane').html('<p>Something went wrong. Please try again.</p>');
                    }
                },
                error: function() {
                    $('#childpage-tab-pane').html('<p>Something went wrong. Please try again.</p>');
                }
            });
        }

        $(document).on('click', '.pagination_two a', function(e) {
            e.preventDefault();
            var page = $(this).attr('href').split('page/')[1];
            loadchilpages(page);
        });

        $('body').on('click', '.delete-button', function(e) {
            e.preventDefault(); // Prevent the default anchor behavior

            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    var deleteUrl = $(this).attr('href');

                    $.ajax({
                        type: 'GET',
                        url: deleteUrl,
                        success: function() {
                            // Optionally, remove the item from the list without page reload
                            $(e.target).closest('li').fadeOut();
                            Swal.fire(
                                'Deleted!',
                                'Your page has been deleted.',
                                'success'
                            );
                        },
                        error: function() {
                            Swal.fire(
                                'Error!',
                                'An error occurred while trying to delete the page.',
                                'error'
                            );
                        }
                    });

                    return false; // Ensure no default behavior is triggered
                }
            });

            return false; // Ensure no default behavior is triggered
        });
        jQuery(document).ready(function($) {
            $('.delete-user').on('click', function(e) {
                e.preventDefault();

                var userId = $(this).data('user-id');
                var userRow = '#user-' + userId;

                // SweetAlert confirmation dialog
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: '<?php echo admin_url("admin-ajax.php"); ?>', // Provided by WordPress for admin AJAX calls
                            type: 'POST',
                            data: {
                                action: 'delete_user',
                                user_id: userId
                            },
                            success: function(response) {
                                if (response.success) {
                                    // SweetAlert success message
                                    Swal.fire(
                                        'Deleted!',
                                        'The user has been deleted.',
                                        'success'
                                    ).then(() => {
                                        $(userRow).remove();
                                    });
                                } else {
                                    // SweetAlert error message
                                    Swal.fire(
                                        'Error!',
                                        'Failed to delete the user.',
                                        'error'
                                    );
                                }
                            },
                            error: function() {
                                // SweetAlert error message for AJAX failure
                                Swal.fire(
                                    'Error!',
                                    'An error occurred during the deletion process.',
                                    'error'
                                );
                            }
                        });
                    }
                });
            });
        });

    });

    jQuery(document).ready(function($) {
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



</script>

<?php get_footer(); ?>