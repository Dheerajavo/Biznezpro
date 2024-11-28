<?php /* Template Name: Industry */ ?>
<?php get_header(); ?>
<style>
    .industry .ind-search {
        position: relative;
    }

    .industry #ind-suggestions {
        position: absolute;
        left: 0;
        right: 0;
        top: 47px;
    }


    .indust-cat-post h3 {
        font-size: 17px;
    }

    .indust-cat-post h3 a.ajax-post-link {
        text-decoration: underline;
        color: var(--theme1);
        text-transform: capitalize;
    }

    li.indust-cat-post {
        padding-bottom: 20px;
    }

    li.indust-cat-post p {
        padding: 10px 0;
    }

    .industry_content,
    .industry_content p {
        font-size: 13px;
    }

    .industry_content h2 {
        font-size: 20px;
    }

    .industry_content strong {
        font-size: 16px;
    }

    .industry_content a {
        color: #57c8ca;
        text-decoration: underline;
        cursor: pointer;
    }

    .industry_heading h2 {
        text-transform: capitalize;
        font-size: 40px;
        padding: 30px 0;
    }

    .single_industry_content {
        margin: 50px 0;
        padding: 20px;
    }

    .industry-content .nav-tabs.ind-scroll {
        max-height: 80vh;
        overflow-y: auto;
        overflow-x: hidden;
        display: block;
        scrollbar-width: thin;
        scrollbar-color: var(--theme1) #f1f1f1;
    }

    .tab-pane .cat-name {
        color: #000;
        margin: 10px 0 25px 0;
    }

    ul.indust-cat-posts {
        counter-reset: my-sec-counter;
    }

    .tab-content-main .item:first-child {
        position: sticky;
        top: 20px;
    }



    ul.indust-cat-posts li {
        display: block;
        gap: 5px;
        margin-bottom: 10px;
    }

    ul.indust-cat-posts li h4 {
        font-size: 18px;
        text-transform: capitalize;
    }

    ul.indust-cat-posts li h4:hover a {
        color: var(--theme1);
        text-decoration: underline;
    }

    ul.indust-cat-posts li p {
        margin: 0;
    }

    .back-button {
        display: inline-block;
        margin-bottom: 20px;
        background: none;
        border: none;
        font-size: 16px;
        cursor: pointer;
        color: black;
    }

    .back-button i {
        font-size: 20px;
        margin-right: 5px;
    }

    .single-post-content {
        padding: 20px;
        background-color: #f9f9f9;
        border: 1px solid #ddd;
        margin-top: 20px;
    }

    .indust-cat-posts {
        list-style: none;
        padding-left: 0;
        margin-top: 20px;
    }

    .indust-cat-posts li {
        margin-bottom: 20px;
    }

    .indust-cat-posts h4 {
        font-size: 18px;
        margin-bottom: 5px;
    }

    .indust-cat-posts p {
        margin: 0;
        color: #666;
        font-size: 14px;
    }

    .indust-cat-posts li {
        margin-bottom: 20px;
    }

    .indust-cat-posts h4 {
        font-size: 18px;
        margin-bottom: 5px;
    }

    .indust-cat-posts p {
        margin: 0;
        color: #666;
        font-size: 14px;
    }
</style>
<!-- main content area start -->
<div class="main-content-area">
    <div class="industry">
        <div class="top-bar">
            <div class="top-bar-wrap">
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
                <div class="ind-search">
                    <input type="text" class="input-control" placeholder="Search..." id="ind_search">
                    <div id="ind-suggestions" class="suggestions-container industry"></div>
                </div>
                <!-- <input type="text" class="input-control" placeholder="Search..."> -->
            </div>
        </div>
        <div class="industry-content">
            <div class="tab-content-main">
                <div class="grid">
                    <div class="item">
                        <h4 class="sub-heading">List of Industries</h4>
                        <ul class="nav nav-tabs flex-column ind-scroll" id="myTab" role="tablist">
                            <?php
                            $uncategorized = get_category_by_slug('uncategorized');
                            $exclude_category = $uncategorized ? array($uncategorized->term_id) : array();
                            $categories = get_categories(array(
                                'taxonomy' => 'category',
                                'orderby' => 'name',
                                'order' => 'ASC',
                                'hide_empty' => false,
                                'exclude' => $exclude_category
                            ));

                            if (!empty($categories)) {
                                $first = true;
                                foreach ($categories as $category) {
                                    $category_name = esc_html($category->name);
                                    $category_slug = esc_attr($category->slug);
                            ?>
                                    <li class="nav-item" role="presentation">
                                        <button
                                            class="nav-link <?php echo $first ? 'active' : ''; ?>"
                                            id="<?php echo $category_slug; ?>-tab"
                                            data-bs-toggle="tab"
                                            data-bs-target="#<?php echo $category_slug; ?>-tab-pane"
                                            type="button"
                                            role="tab"
                                            aria-controls="<?php echo $category_slug; ?>-tab-pane"
                                            aria-selected="<?php echo $first ? 'true' : 'false'; ?>">
                                            <?php echo $category_name; ?>
                                        </button>
                                    </li>
                                <?php
                                    $first = false;
                                }
                                ?>
                        </ul>
                    </div>

                    <div class="item">
                        <div class="tab-content" id="myTabContent">
                            <?php
                                $first = true; // Reset to set the first content as active
                                foreach ($categories as $category) {
                                    $category_slug = esc_attr($category->slug);
                                    $category_posts = new WP_Query(array(
                                        // 'post_type' => 'industries', // Specify your custom post type
                                        'post_type' => 'post',
                                        'tax_query' => array(
                                            array(
                                                'taxonomy' => 'category',
                                                'field' => 'term_id',
                                                'terms' => $category->term_id,
                                            ),
                                        ),
                                        'orderby' => 'date',
                                        'order' => 'ASC',
                                        'posts_per_page' => -1 // Display all posts
                                    ));
                            ?>
                                <div class="tab-pane fade <?php echo $first ? 'show active' : ''; ?>" id="<?php echo $category_slug; ?>-tab-pane" role="tabpanel" aria-labelledby="<?php echo $category_slug; ?>-tab" tabindex="0">
                                    <div class="cat-name">
                                        <h4><?php echo $category->name; ?>:</h4>
                                    </div>

                                    <!-- Container for single post content with back button (initially hidden) -->
                                    <div class="single-post-container" style="display:none;">
                                        <button class="back-button">
                                            <i class="fa fa-arrow-left"></i> Back
                                        </button>
                                        <div class="single-post-content">

                                        </div>
                                    </div>

                                    <!-- List of posts for this category -->
                                    <ul class="indust-cat-posts">
                                        <?php $i = 1;
                                        if ($category_posts->have_posts()) :
                                            while ($category_posts->have_posts()) : $category_posts->the_post(); ?>
                                                <li class="indust-cat-post" id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                                                    <h3>
                                                        <span><?php echo $i; ?>. </span> <a href="<?php the_permalink(); ?>" class="ajax-post-link" data-post-id="<?php the_ID(); ?>"><?php the_title(); ?></a>
                                                    </h3>
                                                    <p>
                                                        <?php
                                                        // Show first 40 words of the content/excerpt
                                                        echo wp_trim_words(get_the_excerpt(), 10, '');
                                                        ?>
                                                    </p>
                                                </li>

                                        <?php $i++;
                                            endwhile;
                                        else : echo 'No post found';
                                        endif;
                                        wp_reset_postdata(); ?>
                                    </ul>
                                </div>

                            <?php
                                    $first = false;
                                }
                            ?>
                        </div>
                    </div>

                <?php
                            } else {
                                echo '<li>No industries found.</li>';
                            }
                ?>

                </div>
            </div>

        </div>
    </div>
</div>
</main>
<script>
    jQuery(document).ready(function($) {
        // Search Input Event
        $('#ind_search').on('input', function() {
            var searchTerm = $(this).val();

            if (searchTerm.length > 2) { // Trigger only after 3 characters
                $.ajax({
                    type: 'POST',
                    url: my_ajax_object.ajax_url,
                    data: {
                        action: 'search_categories',
                        search_term: searchTerm
                    },
                    success: function(response) {
                        if (response.success && response.data.length > 0) {
                            var suggestionsHtml = '';
                            $.each(response.data, function(index, category) {
                                suggestionsHtml += `<div class="suggestion-item" data-category-id="${category.id}" data-category-slug="${category.slug}">
                                ${category.name}
                            </div>`;
                            });
                            $('#ind-suggestions').html(suggestionsHtml).show();
                        } else {
                            $('#ind-suggestions').html('<div>No results found.</div>').show();
                        }
                    },
                    error: function() {
                        console.error('Error fetching categories.');
                    }
                });
            } else {
                $('#ind-suggestions').hide(); // Hide suggestions if input is empty
            }
        });

        // Handle Suggestion Click
        $('.industry').on('click', '.suggestion-item', function() {
            var categorySlug = $(this).data('category-slug');
            var categoryName = $(this).text().trim(); // Get the suggestion text
            // Fill the search input with the selected suggestion
            $('#ind_search').val(categoryName);

            // Highlight the corresponding tab
            $('.nav-link').removeClass('active');
            $(`#${categorySlug}-tab`).addClass('active').click();
            $('.tab-pane').removeClass('show active');
            $(`#${categorySlug}-tab-pane`).addClass('show active').click();

            // Hide suggestions
            $('#ind-suggestions').hide();
        });

        // Hide suggestions when clicking outside
        $(document).on('click', function(e) {
            if (!$(e.target).closest('#ind_search, #ind-suggestions').length) {
                $('#ind-suggestions').hide();
            }
        });
    });




    // jQuery(document).ready(function($) {
    //     // Search Input Event
    //     $('#ind_search').on('input', function() {
    //         var searchTerm = $(this).val();
    //         // var ajaxUrl = "<?php //echo admin_url('admin-ajax.php');
                                    ?>";

    //         if (searchTerm.length > 2) { // Trigger only after 3 characters
    //             $.ajax({
    //                 type: 'POST',
    //                 url: my_ajax_object.ajax_url,
    //                 data: {
    //                     action: 'search_categories',
    //                     search_term: searchTerm
    //                 },
    //                 success: function(response) {
    //                     if (response.success && response.data.length > 0) {
    //                         var suggestionsHtml = '';
    //                         $.each(response.data, function(index, category) {
    //                             suggestionsHtml += `<div class="suggestion-item" data-category-id="${category.id}" data-category-slug="${category.slug}">
    //                                 ${category.name}
    //                             </div>`;
    //                         });
    //                         $('#ind-suggestions').html(suggestionsHtml).show();
    //                     } else {
    //                         $('#ind-suggestions').html('<div>No results found.</div>').show();
    //                     }
    //                 },
    //                 error: function() {
    //                     console.error('Error fetching categories.');
    //                 }
    //             });
    //         } else {
    //             $('#ind-suggestions').hide(); // Hide suggestions if input is empty
    //         }
    //     });

    //     // Handle Suggestion Click
    //     $('.industry').on('click', '.suggestion-item', function() {
    //         var categorySlug = $(this).data('category-slug');

    //         // Highlight the corresponding tab
    //         $('.nav-link').removeClass('active');
    //         $('.tab-pane').removeClass('show active');
    //         $(`#${categorySlug}-tab-pane`).addClass('show active').click();

    //         // Hide suggestions
    //         $('#ind-suggestions').hide();
    //     });

    //     // Hide suggestions when clicking outside
    //     $(document).on('click', function(e) {
    //         if (!$(e.target).closest('#ind_search, #ind-suggestions').length) {
    //             $('#ind-suggestions').hide();
    //         }
    //     });
    // });
</script>


<script>
    jQuery(document).ready(function($) {
        // Delegate the click event to dynamically loaded post titles
        $('body').on('click', '.ajax-postt-link', function(e) {
            e.preventDefault(); // Prevent default link behavior

            var post_id = $(this).data('post-id');
            var ajax_url = "<?php echo admin_url('admin-ajax.php'); ?>";
            var tabPane = $(this).closest('.tab-pane'); // Get the current tab's pane

            // Hide the list and show the post content container for the current tab
            tabPane.find('.indust-cat-posts').hide(); // Hide the list of posts
            tabPane.find('.single-post-container').show(); // Show the single post container

            // Make AJAX request to fetch the single post content
            $.ajax({
                type: "POST",
                url: ajax_url,
                data: {
                    action: 'load_single_post_content',
                    post_id: post_id
                },
                success: function(response) {
                    // Display the post content inside the correct tab
                    tabPane.find('.single-post-content').html(response);
                },
                error: function() {
                    alert('Failed to load post content.');
                }
            });
        });

        // Delegate the back button to show the post list again
        $('body').on('click', '.back-button', function(e) {
            e.preventDefault();

            var tabPane = $(this).closest('.tab-pane'); // Get the current tab's pane
            tabPane.find('.single-post-container').hide(); // Hide the post content
            tabPane.find('.indust-cat-posts').show(); // Show the list of posts again
        });
    });
</script>
<?php get_footer(); ?>