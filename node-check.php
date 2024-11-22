<?php /* Template Name:node-check*/ ?>
<?php get_header(); ?>
<?php // include get_stylesheet_directory() . '/template-parts/node_data_store.php';
?>

<div class="main-content-area">
    <div class="home-page">
        <div class="node-header">
            <nav class="node-nav">
                <ul class="nav-mesnu-scroll">

                    <li style="display:none;" class="drag-drawflow" draggable="true" ondragstart="drag(event)" data-node="add_node">
                        <span id="add-node-button"> add node<i class="ri-add-large-line"></i> </span>
                    </li>
                    <li id="logo-container">
                        <label for="company-logo">add company logo <i class="ri-add-large-line"></i></label>
                        <input type="file" id="company-logo" class="input-control" accept="image/*">
                    </li>
                    <li id="company-logo-img" class="company-logo-img">
                        <img src="<?php echo home_url(); ?>/wp-content/uploads/2024/08/no-image-default.png" alt="company-logo" id="company-logo-image">
                        <!-- <button id="close-company-logo">Close</button> -->
                        <button type="button" id="close-company-logo" class="btn-close" aria-label="Close"><i class="ri-close-large-line"></i></button>
                    </li>
                    <li id="company-name-text">
                        <label for="company-name" class="company-name">add company name <i class="ri-add-large-line"></i></label>
                        <input type="text" id="company-name" class="input-control" placeholder="Type Here...">
                    </li>
                    <li id="company-name-display">
                        <p></p>
                        <button type="button" id="close-company-name" class="btn-close" aria-label="Close"><i class="ri-close-large-line"></i></button>
                    </li>
                    <li class="all-shapes">
                        <span id="add-node-btn"> add node shapes <i class="ri-add-large-line"></i></span>
                        <ul id="shapes-dropdown" style="display: none;">
                            <li class="drag-drawflow rectangle" draggable="true" ondragstart="drag(event)" data-node="add_node">
                            </li>
                            <li class="drag-drawflow circle" draggable="true" ondragstart="drag(event)" data-node="circle">
                            </li>
                            <li class="drag-drawflow diamond" draggable="true" ondragstart="drag(event)" data-node="diamond">
                            </li>
                            <li class="drag-drawflow parallel" draggable="true" ondragstart="drag(event)" data-node="parallel">
                            </li>
                            <li class="drag-drawflow rhombus" draggable="true" ondragstart="drag(event)" data-node="rhombus">
                                <svg viewBox="0 5 100 90">
                                    <path d="M50,10 L90,50 L50,90 L10,50 Z" fill="none" stroke="black" stroke-width="2" />
                                </svg>
                            </li>
                            <li class="drag-drawflow ocatgon" draggable="true" ondragstart="drag(event)" data-node="ocatgon">
                                <svg viewBox="0 5 100 90">
                                    <path d="M30,10 L70,10 L90,30 L90,70 L70,90 L30,90 L10,70 L10,30 Z" fill="none" stroke="black" stroke-width="2" />
                                </svg>
                            </li>
                        </ul>
                    </li>
                    <li class="company-dec">
                        <span id="openTextAreaBtn">Add Short Detail <i class="ri-add-large-line"></i></span>
                        <ul id="textAreabox" style="display:none;">
                            <li id="textAreaContainer">
                                <textarea id="textArea" rows="4.5" cols="21" placeholder="Enter your text here..."></textarea>
                            </li>
                        </ul>
                    </li>

                    <li class="company-cat" id="company-options">
                        <button class="dropdown-toggle" type="button" id="dropdownMenuButton1" aria-expanded="true">Select Industry</button>
                        <ul class="dropdown-menu" style="display: none;" aria-labelledby="dropdownMenuButton1">
                            <?php
                            $uncategorized = get_category_by_slug('uncategorized');
                            $exclude_category = $uncategorized ? array($uncategorized->term_id) : array();

                            $terms = get_terms([
                                'taxonomy'   => 'category',
                                'orderby'    => 'name',
                                'order'      => 'ASC',
                                'hide_empty' => false,
                                'exclude'    => $exclude_category,
                            ]);

                            // $terms = get_terms(['post_type' => 'post', 'taxonomy' => 'category', 'order' => 'DESC', 'hide_empty' => false]);
                            ?>
                            <!-- <li class="dropdown-toggle" data-value="1">All Category</li> -->
                            <?php foreach ($terms as $cat) { ?>
                                <li class="dropdown-item" data-text="<?php echo $cat->slug; ?>" data-value="<?php echo $cat->term_id; ?>"><?php echo $cat->name; ?></li>
                            <?php } ?>
                        </ul>
                    </li>
                    <li class="company-country" id="country-options" class="dropdown">
                        <button class="dropdown-toggle" type="button" id="dropdownMenuButton2" aria-expanded="true">
                           Select Country
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
                <script>
                    jQuery(document).ready(function($) {


                    });
                </script>
                <button id="save-node-data-button" class="primary-btn">publish</button>
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
                <div class="grid grid-cols-2">
                    <div class="submit-addons child-node" id="submit-child-node">
                        <button type="submit">Create Child Node</button>
                    </div>
                    <div class="submit-addons" id="submit-addons">
                        <button type="submit">Submit</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- add node popup end  -->

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

                }
            },

        }
    }
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
                  <p class="node-text">Text</p>
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
                  <p class="node-text">Text</p>
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
                  <p class="node-text">Text</p>
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
                  <p class="node-text">Text</p>
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
                  <p class="node-text">Text</p>
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
                  <p class="node-text">Text</p>
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
                  <p class="node-text">Text</p>
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
<?php get_footer(); ?>