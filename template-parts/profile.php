<?php
if (!is_user_logged_in()) {
    // Redirect to the login page if the user is not logged in
    wp_redirect(home_url('/sign-in/'));
    exit;
}
?>

<style>
    .close-acc {
        text-align: end;
    }

    .close-acc i {
        margin-left: 5px;
    }


    .user-profile-pic img {
        border-radius: 50%;
        height: 150px;
        width: 100%;
        max-width: 150px;
        object-fit: cover;

    }

    .user-profile-pic #edit-profile-pic {
        width: 30px;
        position: absolute;
        top: 28px;
        /* left: 122px; */
        right: 40%;
    }

    p.pending_text {
        font-weight: 500;
        font-size: 25px;
    }

    .typing {
        display: inline-flex;
        align-items: baseline;
        gap: 5px;

        .dot {
            display: inline-block;
            height: 7px;
            width: 7px;
            background: #3b5998;
            border-radius: 50%;
            animation: blink 1.5s infinite both;

            &:nth-child(2) {
                animation-delay: .2s;
            }

            &:nth-child(3) {
                animation-delay: .4s;
            }
        }
    }

    @keyframes blink {
        0% {
            opacity: .1;
        }

        20% {
            opacity: 1;
        }

        100% {
            opacity: .1;
        }
    }
</style>

<div class="tab-pane fade active show" id="contact-tab-pane" role="tabpanel" aria-labelledby="contact-tab" tabindex="0">
    <div class="mod-wrap">
        <div class="card-body">

            <?php
            $user_id = get_current_user_id();
            $profile_pic_url = get_user_meta($user_id, 'profile_picture', true);
            $default_image_url = home_url('/wp-content/uploads/2024/08/no-image-default.png');

            // $image_url = !empty($profile_pic_url) ? $profile_pic_url : $default_image_url;
            $image_url = !empty($profile_pic_url) ? $profile_pic_url : '';
            ?>
            <form id="profile-pic-form" enctype="multipart/form-data" style="display: none;">
                <input type="file" name="profile_pic" id="profile-pic-upload" accept="image/*" style="display: none;">
            </form>
            <div class="user-profile-pic" style="text-align: center">
                <?php if (!empty($image_url)) : ?>
                    <img src="<?php echo esc_url($image_url); ?>" alt="profile-pic" id="profile-pic">
                <?php else : ?>
                    <i class="ri-account-circle-line" id="profile-pic-icon" style="font-size: 100px;"></i>
                <?php endif; ?>
                <!-- <img src="<?php //echo esc_url($image_url); ?>" alt="profile-pic" id="profile-pic"> -->
                <div class="edit-btn" id="edit-profile-pic">
                    <a href="#"><i class="ri-pencil-line"></i></a>
                </div>
            </div>

            <div class="close-acc">
                <?php //if (!current_user_can('administrator') || $current_user->ID == 1) :
                ?>
                <?php if (!current_user_can('administrator')) : ?>
                    <button type="button" class="primary-btn" id="closeAcc"
                        data-user-id="<?php echo $current_user->ID; ?>"
                        data-user-name="<?php echo $current_user->user_login; ?>"
                        data-user-role="<?php echo implode(', ', $current_user->roles); ?>">
                        Delete My Account <i class="fa fa-trash"></i>
                    </button>
                    <!-- <button type="submit" class="primary-btn" id="closeAcc"
                        data-user-id="<?php //echo get_current_user_id();
                                        ?>"
                        data-user-name="<?php //echo wp_get_current_user()->user_login;
                                        ?>"
                        data-user-role="<?php //echo wp_get_current_user()->roles[0];
                                        ?>">
                        Delete My Account <i class="fa fa-trash"></i>
                    </button> -->
                <?php endif; ?>
            </div>


            <form class="grid">
                <?php
                // Define the country codes and their full names
                $countries = [
                    'AF' => 'Afghanistan',
                    'AL' => 'Albania',
                    'DZ' => 'Algeria',
                    'AS' => 'American Samoa',
                    'AD' => 'Andorra',
                    'AO' => 'Angola',
                    'AI' => 'Anguilla',
                    'AQ' => 'Antarctica',
                    'AG' => 'Antigua and Barbuda',
                    'AR' => 'Argentina',
                    'AM' => 'Armenia',
                    'AW' => 'Aruba',
                    'AU' => 'Australia',
                    'AT' => 'Austria',
                    'AZ' => 'Azerbaijan',
                    'BS' => 'Bahamas',
                    'BH' => 'Bahrain',
                    'BD' => 'Bangladesh',
                    'BB' => 'Barbados',
                    'BY' => 'Belarus',
                    'BE' => 'Belgium',
                    'BZ' => 'Belize',
                    'BJ' => 'Benin',
                    'BM' => 'Bermuda',
                    'BT' => 'Bhutan',
                    'BO' => 'Bolivia',
                    'BA' => 'Bosnia and Herzegovina',
                    'BW' => 'Botswana',
                    'BR' => 'Brazil',
                    'IO' => 'British Indian Ocean Territory',
                    'BN' => 'Brunei Darussalam',
                    'BG' => 'Bulgaria',
                    'BF' => 'Burkina Faso',
                    'BI' => 'Burundi',
                    'KH' => 'Cambodia',
                    'CM' => 'Cameroon',
                    'CA' => 'Canada',
                    'CV' => 'Cape Verde',
                    'KY' => 'Cayman Islands',
                    'CF' => 'Central African Republic',
                    'TD' => 'Chad',
                    'CL' => 'Chile',
                    'CN' => 'China',
                    'CX' => 'Christmas Island',
                    'CC' => 'Cocos (Keeling) Islands',
                    'CO' => 'Colombia',
                    'KM' => 'Comoros',
                    'CG' => 'Congo',
                    'CD' => 'Congo, The Democratic Republic of The',
                    'CK' => 'Cook Islands',
                    'CR' => 'Costa Rica',
                    'CI' => 'Cote D\'ivoire',
                    'HR' => 'Croatia',
                    'CU' => 'Cuba',
                    'CY' => 'Cyprus',
                    'CZ' => 'Czech Republic',
                    'DK' => 'Denmark',
                    'DJ' => 'Djibouti',
                    'DM' => 'Dominica',
                    'DO' => 'Dominican Republic',
                    'EC' => 'Ecuador',
                    'EG' => 'Egypt',
                    'SV' => 'El Salvador',
                    'GQ' => 'Equatorial Guinea',
                    'ER' => 'Eritrea',
                    'EE' => 'Estonia',
                    'ET' => 'Ethiopia',
                    'FK' => 'Falkland Islands (Malvinas)',
                    'FO' => 'Faroe Islands',
                    'FJ' => 'Fiji',
                    'FI' => 'Finland',
                    'FR' => 'France',
                    'GF' => 'French Guiana',
                    'PF' => 'French Polynesia',
                    'TF' => 'French Southern Territories',
                    'GA' => 'Gabon',
                    'GM' => 'Gambia',
                    'GE' => 'Georgia',
                    'DE' => 'Germany',
                    'GH' => 'Ghana',
                    'GI' => 'Gibraltar',
                    'GR' => 'Greece',
                    'GL' => 'Greenland',
                    'GD' => 'Grenada',
                    'GP' => 'Guadeloupe',
                    'GU' => 'Guam',
                    'GT' => 'Guatemala',
                    'GG' => 'Guernsey',
                    'GN' => 'Guinea',
                    'GW' => 'Guinea-bissau',
                    'GY' => 'Guyana',
                    'HT' => 'Haiti',
                    'VA' => 'Holy See (Vatican City State)',
                    'HN' => 'Honduras',
                    'HK' => 'Hong Kong',
                    'HU' => 'Hungary',
                    'IS' => 'Iceland',
                    'IN' => 'India',
                    'ID' => 'Indonesia',
                    'IR' => 'Iran, Islamic Republic of',
                    'IQ' => 'Iraq',
                    'IE' => 'Ireland',
                    'IM' => 'Isle of Man',
                    'IL' => 'Israel',
                    'IT' => 'Italy',
                    'JM' => 'Jamaica',
                    'JP' => 'Japan',
                    'JE' => 'Jersey',
                    'JO' => 'Jordan',
                    'KZ' => 'Kazakhstan',
                    'KE' => 'Kenya',
                    'KI' => 'Kiribati',
                    'KP' => 'Korea, Democratic People\'s Republic of',
                    'KR' => 'Korea, Republic of',
                    'KW' => 'Kuwait',
                    'KG' => 'Kyrgyzstan',
                    'LA' => 'Lao People\'s Democratic Republic',
                    'LV' => 'Latvia',
                    'LB' => 'Lebanon',
                    'LS' => 'Lesotho',
                    'LR' => 'Liberia',
                    'LY' => 'Libya',
                    'LI' => 'Liechtenstein',
                    'LT' => 'Lithuania',
                    'LU' => 'Luxembourg',
                    'MO' => 'Macao',
                    'MK' => 'Macedonia, The Former Yugoslav Republic of',
                    'MG' => 'Madagascar',
                    'MW' => 'Malawi',
                    'MY' => 'Malaysia',
                    'MV' => 'Maldives',
                    'ML' => 'Mali',
                    'MT' => 'Malta',
                    'MH' => 'Marshall Islands',
                    'MQ' => 'Martinique',
                    'MR' => 'Mauritania',
                    'MU' => 'Mauritius',
                    'YT' => 'Mayotte',
                    'MX' => 'Mexico',
                    'FM' => 'Micronesia, Federated States of',
                    'MD' => 'Moldova, Republic of',
                    'MC' => 'Monaco',
                    'MN' => 'Mongolia',
                    'ME' => 'Montenegro',
                    'MS' => 'Montserrat',
                    'MA' => 'Morocco',
                    'MZ' => 'Mozambique',
                    'MM' => 'Myanmar',
                    'NA' => 'Namibia',
                    'NR' => 'Nauru',
                    'NP' => 'Nepal',
                    'NL' => 'Netherlands',
                    'NC' => 'New Caledonia',
                    'NZ' => 'New Zealand',
                    'NI' => 'Nicaragua',
                    'NE' => 'Niger',
                    'NG' => 'Nigeria',
                    'NU' => 'Niue',
                    'NF' => 'Norfolk Island',
                    'MP' => 'Northern Mariana Islands',
                    'NO' => 'Norway',
                    'OM' => 'Oman',
                    'PK' => 'Pakistan',
                    'PW' => 'Palau',
                    'PS' => 'Palestinian Territory, Occupied',
                    'PA' => 'Panama',
                    'PG' => 'Papua New Guinea',
                    'PY' => 'Paraguay',
                    'PE' => 'Peru',
                    'PH' => 'Philippines',
                    'PN' => 'Pitcairn',
                    'PL' => 'Poland',
                    'PT' => 'Portugal',
                    'PR' => 'Puerto Rico',
                    'QA' => 'Qatar',
                    'RE' => 'Reunion',
                    'RO' => 'Romania',
                    'RU' => 'Russian Federation',
                    'RW' => 'Rwanda',
                    'SH' => 'Saint Helena',
                    'KN' => 'Saint Kitts and Nevis',
                    'LC' => 'Saint Lucia',
                    'PM' => 'Saint Pierre and Miquelon',
                    'VC' => 'Saint Vincent and The Grenadines',
                    'WS' => 'Samoa',
                    'SM' => 'San Marino',
                    'ST' => 'Sao Tome and Principe',
                    'SA' => 'Saudi Arabia',
                    'SN' => 'Senegal',
                    'RS' => 'Serbia',
                    'SC' => 'Seychelles',
                    'SL' => 'Sierra Leone',
                    'SG' => 'Singapore',
                    'SK' => 'Slovakia',
                    'SI' => 'Slovenia',
                    'SB' => 'Solomon Islands',
                    'SO' => 'Somalia',
                    'ZA' => 'South Africa',
                    'GS' => 'South Georgia and The South Sandwich Islands',
                    'ES' => 'Spain',
                    'LK' => 'Sri Lanka',
                    'SD' => 'Sudan',
                    'SR' => 'Suriname',
                    'SJ' => 'Svalbard and Jan Mayen',
                    'SZ' => 'Swaziland',
                    'SE' => 'Sweden',
                    'CH' => 'Switzerland',
                    'SY' => 'Syrian Arab Republic',
                    'TW' => 'Taiwan, Province of China',
                    'TJ' => 'Tajikistan',
                    'TZ' => 'Tanzania, United Republic of',
                    'TH' => 'Thailand',
                    'TL' => 'Timor-leste',
                    'TG' => 'Togo',
                    'TK' => 'Tokelau',
                    'TO' => 'Tonga',
                    'TT' => 'Trinidad and Tobago',
                    'TN' => 'Tunisia',
                    'TR' => 'Turkey',
                    'TM' => 'Turkmenistan',
                    'TC' => 'Turks and Caicos Islands',
                    'TV' => 'Tuvalu',
                    'UG' => 'Uganda',
                    'UA' => 'Ukraine',
                    'AE' => 'United Arab Emirates',
                    'GB' => 'United Kingdom',
                    'US' => 'United States',
                    'UY' => 'Uruguay',
                    'UZ' => 'Uzbekistan',
                    'VU' => 'Vanuatu',
                    'VE' => 'Venezuela',
                    'VN' => 'Viet Nam',
                    'VG' => 'Virgin Islands, British',
                    'VI' => 'Virgin Islands, U.S.',
                    'WF' => 'Wallis and Futuna',
                    'EH' => 'Western Sahara',
                    'YE' => 'Yemen',
                    'ZM' => 'Zambia',
                    'ZW' => 'Zimbabwe',
                ];
                $current_user = wp_get_current_user();
                $is_admin = in_array('administrator', $current_user->roles);

                //for Current User
                $user_id = $current_user->ID;
                $fullname = get_user_meta($user_id, 'fullname', true);
                $first_name = get_user_meta($user_id, 'first_name', true);
                $display_name = !empty($fullname) ? $fullname : $first_name;
                $country_code = get_user_meta($user_id, 'country', true);
                $country_name = isset($countries[$country_code]) ? $countries[$country_code] : 'Unknown';
                $mobile_number = get_user_meta($user_id, 'mobile_number', true);
                $user_email = $current_user->user_email;
                $user_roles = implode(', ', $current_user->roles);

                // Fill empty fields with "Admin" if the current user is an admin
                if ($is_admin) {
                    $country_name = $country_name === 'Unknown' ? 'Admin' : $country_name;
                    $mobile_number = !empty($mobile_number) ? $mobile_number : 'Admin';
                }
                ?>
                <div class="item">
                    <div class="user-info">
                        <span>USER ID</span>
                        <h4><?php echo $user_id; ?></h4>
                    </div>
                </div>
                <div class="item">
                    <div class="user-info">
                        <span>USER NAME</span>
                        <h4 class="cap_text"><?php echo $display_name; ?></h4>
                    </div>
                </div>
                <div class="item">
                    <div class="user-info">
                        <span>EMAIL ADDRESS</span>
                        <h4><?php echo $user_email; ?></h4>
                    </div>
                </div>
                <div class="item">
                    <div class="user-info">
                        <span>COUNTRY OF RESIDENCE</span>
                        <h4><?php echo $country_name; ?></h4>
                    </div>
                </div>
                <div class="item">
                    <div class="user-info">
                        <span>MOBILE</span>
                        <h4><?php echo $mobile_number; ?></h4>
                    </div>
                </div>
                <div class="item">
                    <div class="user-info">
                        <span>ROLE</span>
                        <h4 class="cap_text"><?php echo $user_roles; ?></h4>
                    </div>
                </div>

                <?php
                $current_user = wp_get_current_user();
                $editor_request_status = get_user_meta($current_user->ID, 'editor_request', true);
                if (in_array('subscriber', $current_user->roles) || (in_array('administrator', $current_user->roles) && $current_user->ID == 1)) {

                ?>
                    <div class="item bcm_editor">
                        <div class="become_editor" <?php if ($editor_request_status === 'requested') echo 'style="display:none;"'; ?>>
                            <button type="submit" class="primary-btn" id="become-editor-btn">Become an Editor</button>
                        </div>
                        <p class="pending_text typing" id="req_bcm_editor" <?php if ($editor_request_status !== 'requested') echo 'style="display:none;"'; ?>>
                            Your request to become an editor is pending<span class="dot"></span><span class="dot"></span><span class="dot"></span>
                        </p>
                    </div>
                <?php } ?>
            </form>
        </div>
        <div class="edit-btn hide-pencil" style="display:none;"><a href="#"><i class="ri-pencil-line"></i></a></div>
    </div>
</div>


<script>
    jQuery(document).ready(function($) {
        $('#closeAcc').on('click', function() {
            // Get user data from the button's data-* attributes
            var userId = $(this).data('user-id');
            var userName = $(this).data('user-name');
            var userRole = $(this).data('user-role');

            // Prepare data to send via AJAX
            var data = {
                action: 'delete_account_request', // WordPress action hook
                user_id: userId,
                user_name: userName,
                user_role: userRole
            };

            // Check if user has already requested account deletion
            $.ajax({
                url: my_ajax_object.ajax_url, // WordPress AJAX URL
                method: 'POST',
                data: {
                    action: 'check_existing_deletion_request', // New action to check for existing request
                    user_id: userId
                },
                success: function(response) {
                    if (response.success) {
                        // If a deletion request already exists, show SweetAlert warning
                        Swal.fire({
                            title: 'Request Already Sent',
                            text: 'You have already requested account deletion. Please wait for further action.',
                            icon: 'warning',
                            confirmButtonText: 'OK',
                        });
                    } else {
                        // Proceed with sending the new deletion request
                        $.ajax({
                            url: my_ajax_object.ajax_url, // WordPress AJAX URL
                            method: 'POST',
                            data: data,
                            success: function(response) {
                                if (response.success) {
                                    Swal.fire({
                                        title: 'Request Sent',
                                        text: 'Your account deletion request has been sent!',
                                        icon: 'success',
                                        confirmButtonText: 'OK',
                                    });
                                }
                            },
                            error: function(xhr, status, error) {
                                Swal.fire({
                                    title: 'Error!',
                                    text: 'Unable to send request.',
                                    icon: 'error',
                                    confirmButtonText: 'OK',
                                });
                            }
                        });
                    }
                }
            });
        });
    });
</script>

<script type="text/javascript">
    jQuery(document).ready(function($) {
        $('#become-editor-btn').on('click', function(e) {
            e.preventDefault();
            const $button = $(this);

            $.ajax({
                url: '<?php echo admin_url('admin-ajax.php'); ?>',
                method: 'POST',
                data: {
                    action: 'editor_request',
                    nonce: '<?php echo wp_create_nonce('editor_request_nonce'); ?>'
                },
                success: function(response) {
                    Swal.fire({
                        icon: response.success ? 'success' : 'error',
                        title: response.success ? 'Success' : 'Error',
                        text: response.data.message
                    });

                    if (response.success) {
                        // Hide the button and show the pending message
                        $button.hide();
                        $('#req_bcm_editor').show();
                    }
                },
                error: function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'There was an error processing your request.'
                    });
                }
            });
        });
    });
</script>
<script>
    jQuery(document).ready(function($) {
        // Open file dialog when clicking the pencil icon
        $('#edit-profile-pic').on('click', function(event) {
            event.preventDefault();
            $('#profile-pic-upload').click();
        });

        // Handle file selection and upload via AJAX
        $('#profile-pic-upload').on('change', function() {
            if (this.files && this.files[0]) {
                var formData = new FormData();
                formData.append('profile_pic', this.files[0]);
                formData.append('action', 'upload_profile_picture'); // Custom AJAX action

                $.ajax({
                    url: '<?php echo admin_url("admin-ajax.php"); ?>',
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if (response.success) {
                            // Update the profile picture source
                            $('#profile-pic').attr('src', response.data.image_url);
                        } else {
                            alert(response.data.message);
                        }
                    }
                });
            }
        });
    });
</script>