<?php
/* Template Name: Sign Up */
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $fullname = sanitize_text_field($_POST['fullname']);
    $country = sanitize_text_field($_POST['country']);
    $mobile_number = sanitize_text_field($_POST['mobile-number']);
    $email = sanitize_email($_POST['email']);
    $password = $_POST['password'];
    $re_enter_password = $_POST['re-enter_password'];

    $errors = array();

    if (empty($fullname)) {
        $errors[] = 'Full name is required.';
    }
    if (empty($country)) {
        $errors[] = 'Country is required.';
    }
    if (!is_email($email)) {
        $errors[] = 'Valid email is required.';
    }
    if (empty($password)) {
        $errors[] = 'Password is required.';
    }
    if ($password !== $re_enter_password) {
        $errors[] = 'Passwords do not match.';
    }

    if (empty($errors)) {
        $user_id = wp_create_user($email, $password, $email);
        
        if (!is_wp_error($user_id)) {
         // Split full name into first and last name
         $name_parts = explode(' ', $fullname, 2);
         $first_name = $name_parts[0];
         $last_name = isset($name_parts[1]) ? $name_parts[1] : '';

         // Update user with first and last name, country, and mobile number
         wp_update_user([
             'ID' => $user_id,
             'first_name' => $first_name,
             'last_name' => $last_name,
             'display_name' => $fullname
         ]);



            update_user_meta($user_id, 'fullname', $fullname);
            update_user_meta($user_id, 'country', $country);
            update_user_meta($user_id, 'mobile_number', $mobile_number);
            wp_set_current_user($user_id);
            wp_set_auth_cookie($user_id);
            // wp_redirect(home_url());
            wp_redirect(home_url('/?registration_success=true'));
            exit;
        } else {
            $errors[] = 'Error creating user: ' . $user_id->get_error_message();
        }
    }
}
?>
<?php get_header(); ?>
<!-- main content area start -->
<div class="main-content-area">
    <div class="sign_in">
        <div class="contact-form">
            <?php get_template_part('template-parts/common-top-logo'); ?>
            <form action="<?php echo esc_url($_SERVER['REQUEST_URI']); ?>" method="post">
                <?php if (!empty($errors)) : ?>
                    <div class="errors">
                        <?php foreach ($errors as $error) : ?>
                            <p><?php echo esc_html($error); ?></p>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="fullname">Full Name <sup>*</sup></label>
                            <input type="text" id="fullname" name="fullname" placeholder="Type Here..." class="input-control" value="<?php echo isset($_POST['fullname']) ? esc_attr($_POST['fullname']) : ''; ?>">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="country">Choose a country <sup>*</sup></label>
                            <select id="country" name="country" class="input-control">
                                <option value="">Select a country...</option>
                                <option value="AF" <?php echo isset($_POST['country']) && $_POST['country'] == 'AF' ? 'selected' : ''; ?>>Afghanistan</option>
                                <option value="AL" <?php echo isset($_POST['country']) && $_POST['country'] == 'AL' ? 'selected' : ''; ?>>Albania</option>
                                <option value="DZ" <?php echo isset($_POST['country']) && $_POST['country'] == 'DZ' ? 'selected' : ''; ?>>Algeria</option>
                                <option value="AS" <?php echo isset($_POST['country']) && $_POST['country'] == 'AS' ? 'selected' : ''; ?>>American Samoa</option>
                                <option value="AD" <?php echo isset($_POST['country']) && $_POST['country'] == 'AD' ? 'selected' : ''; ?>>Andorra</option>
                                <option value="AO" <?php echo isset($_POST['country']) && $_POST['country'] == 'AO' ? 'selected' : ''; ?>>Angola</option>
                                <option value="AI" <?php echo isset($_POST['country']) && $_POST['country'] == 'AI' ? 'selected' : ''; ?>>Anguilla</option>
                                <option value="AQ" <?php echo isset($_POST['country']) && $_POST['country'] == 'AQ' ? 'selected' : ''; ?>>Antarctica</option>
                                <option value="AG" <?php echo isset($_POST['country']) && $_POST['country'] == 'AG' ? 'selected' : ''; ?>>Antigua and Barbuda</option>
                                <option value="AR" <?php echo isset($_POST['country']) && $_POST['country'] == 'AR' ? 'selected' : ''; ?>>Argentina</option>
                                <option value="AM" <?php echo isset($_POST['country']) && $_POST['country'] == 'AM' ? 'selected' : ''; ?>>Armenia</option>
                                <option value="AW" <?php echo isset($_POST['country']) && $_POST['country'] == 'AW' ? 'selected' : ''; ?>>Aruba</option>
                                <option value="AU" <?php echo isset($_POST['country']) && $_POST['country'] == 'AU' ? 'selected' : ''; ?>>Australia</option>
                                <option value="AT" <?php echo isset($_POST['country']) && $_POST['country'] == 'AT' ? 'selected' : ''; ?>>Austria</option>
                                <option value="AZ" <?php echo isset($_POST['country']) && $_POST['country'] == 'AZ' ? 'selected' : ''; ?>>Azerbaijan</option>
                                <option value="BS" <?php echo isset($_POST['country']) && $_POST['country'] == 'BS' ? 'selected' : ''; ?>>Bahamas</option>
                                <option value="BH" <?php echo isset($_POST['country']) && $_POST['country'] == 'BH' ? 'selected' : ''; ?>>Bahrain</option>
                                <option value="BD" <?php echo isset($_POST['country']) && $_POST['country'] == 'BD' ? 'selected' : ''; ?>>Bangladesh</option>
                                <option value="BB" <?php echo isset($_POST['country']) && $_POST['country'] == 'BB' ? 'selected' : ''; ?>>Barbados</option>
                                <option value="BY" <?php echo isset($_POST['country']) && $_POST['country'] == 'BY' ? 'selected' : ''; ?>>Belarus</option>
                                <option value="BE" <?php echo isset($_POST['country']) && $_POST['country'] == 'BE' ? 'selected' : ''; ?>>Belgium</option>
                                <option value="BZ" <?php echo isset($_POST['country']) && $_POST['country'] == 'BZ' ? 'selected' : ''; ?>>Belize</option>
                                <option value="BJ" <?php echo isset($_POST['country']) && $_POST['country'] == 'BJ' ? 'selected' : ''; ?>>Benin</option>
                                <option value="BM" <?php echo isset($_POST['country']) && $_POST['country'] == 'BM' ? 'selected' : ''; ?>>Bermuda</option>
                                <option value="BT" <?php echo isset($_POST['country']) && $_POST['country'] == 'BT' ? 'selected' : ''; ?>>Bhutan</option>
                                <option value="BO" <?php echo isset($_POST['country']) && $_POST['country'] == 'BO' ? 'selected' : ''; ?>>Bolivia</option>
                                <option value="BA" <?php echo isset($_POST['country']) && $_POST['country'] == 'BA' ? 'selected' : ''; ?>>Bosnia and Herzegovina</option>
                                <option value="BW" <?php echo isset($_POST['country']) && $_POST['country'] == 'BW' ? 'selected' : ''; ?>>Botswana</option>
                                <option value="BR" <?php echo isset($_POST['country']) && $_POST['country'] == 'BR' ? 'selected' : ''; ?>>Brazil</option>
                                <option value="IO" <?php echo isset($_POST['country']) && $_POST['country'] == 'IO' ? 'selected' : ''; ?>>British Indian Ocean Territory</option>
                                <option value="BN" <?php echo isset($_POST['country']) && $_POST['country'] == 'BN' ? 'selected' : ''; ?>>Brunei Darussalam</option>
                                <option value="BG" <?php echo isset($_POST['country']) && $_POST['country'] == 'BG' ? 'selected' : ''; ?>>Bulgaria</option>
                                <option value="BF" <?php echo isset($_POST['country']) && $_POST['country'] == 'BF' ? 'selected' : ''; ?>>Burkina Faso</option>
                                <option value="BI" <?php echo isset($_POST['country']) && $_POST['country'] == 'BI' ? 'selected' : ''; ?>>Burundi</option>
                                <option value="KH" <?php echo isset($_POST['country']) && $_POST['country'] == 'KH' ? 'selected' : ''; ?>>Cambodia</option>
                                <option value="CM" <?php echo isset($_POST['country']) && $_POST['country'] == 'CM' ? 'selected' : ''; ?>>Cameroon</option>
                                <option value="CA" <?php echo isset($_POST['country']) && $_POST['country'] == 'CA' ? 'selected' : ''; ?>>Canada</option>
                                <option value="CV" <?php echo isset($_POST['country']) && $_POST['country'] == 'CV' ? 'selected' : ''; ?>>Cape Verde</option>
                                <option value="KY" <?php echo isset($_POST['country']) && $_POST['country'] == 'KY' ? 'selected' : ''; ?>>Cayman Islands</option>
                                <option value="CF" <?php echo isset($_POST['country']) && $_POST['country'] == 'CF' ? 'selected' : ''; ?>>Central African Republic</option>
                                <option value="TD" <?php echo isset($_POST['country']) && $_POST['country'] == 'TD' ? 'selected' : ''; ?>>Chad</option>
                                <option value="CL" <?php echo isset($_POST['country']) && $_POST['country'] == 'CL' ? 'selected' : ''; ?>>Chile</option>
                                <option value="CN" <?php echo isset($_POST['country']) && $_POST['country'] == 'CN' ? 'selected' : ''; ?>>China</option>
                                <option value="CX" <?php echo isset($_POST['country']) && $_POST['country'] == 'CX' ? 'selected' : ''; ?>>Christmas Island</option>
                                <option value="CC" <?php echo isset($_POST['country']) && $_POST['country'] == 'CC' ? 'selected' : ''; ?>>Cocos (Keeling) Islands</option>
                                <option value="CO" <?php echo isset($_POST['country']) && $_POST['country'] == 'CO' ? 'selected' : ''; ?>>Colombia</option>
                                <option value="KM" <?php echo isset($_POST['country']) && $_POST['country'] == 'KM' ? 'selected' : ''; ?>>Comoros</option>
                                <option value="CG" <?php echo isset($_POST['country']) && $_POST['country'] == 'CG' ? 'selected' : ''; ?>>Congo</option>
                                <option value="CD" <?php echo isset($_POST['country']) && $_POST['country'] == 'CD' ? 'selected' : ''; ?>>Congo, The Democratic Republic of The</option>
                                <option value="CK" <?php echo isset($_POST['country']) && $_POST['country'] == 'CK' ? 'selected' : ''; ?>>Cook Islands</option>
                                <option value="CR" <?php echo isset($_POST['country']) && $_POST['country'] == 'CR' ? 'selected' : ''; ?>>Costa Rica</option>
                                <option value="CI" <?php echo isset($_POST['country']) && $_POST['country'] == 'CI' ? 'selected' : ''; ?>>Cote D'ivoire</option>
                                <option value="HR" <?php echo isset($_POST['country']) && $_POST['country'] == 'HR' ? 'selected' : ''; ?>>Croatia</option>
                                <option value="CU" <?php echo isset($_POST['country']) && $_POST['country'] == 'CU' ? 'selected' : ''; ?>>Cuba</option>
                                <option value="CY" <?php echo isset($_POST['country']) && $_POST['country'] == 'CY' ? 'selected' : ''; ?>>Cyprus</option>
                                <option value="CZ" <?php echo isset($_POST['country']) && $_POST['country'] == 'CZ' ? 'selected' : ''; ?>>Czech Republic</option>
                                <option value="DK" <?php echo isset($_POST['country']) && $_POST['country'] == 'DK' ? 'selected' : ''; ?>>Denmark</option>
                                <option value="DJ" <?php echo isset($_POST['country']) && $_POST['country'] == 'DJ' ? 'selected' : ''; ?>>Djibouti</option>
                                <option value="DM" <?php echo isset($_POST['country']) && $_POST['country'] == 'DM' ? 'selected' : ''; ?>>Dominica</option>
                                <option value="DO" <?php echo isset($_POST['country']) && $_POST['country'] == 'DO' ? 'selected' : ''; ?>>Dominican Republic</option>
                                <option value="EC" <?php echo isset($_POST['country']) && $_POST['country'] == 'EC' ? 'selected' : ''; ?>>Ecuador</option>
                                <option value="EG" <?php echo isset($_POST['country']) && $_POST['country'] == 'EG' ? 'selected' : ''; ?>>Egypt</option>
                                <option value="SV" <?php echo isset($_POST['country']) && $_POST['country'] == 'SV' ? 'selected' : ''; ?>>El Salvador</option>
                                <option value="GQ" <?php echo isset($_POST['country']) && $_POST['country'] == 'GQ' ? 'selected' : ''; ?>>Equatorial Guinea</option>
                                <option value="ER" <?php echo isset($_POST['country']) && $_POST['country'] == 'ER' ? 'selected' : ''; ?>>Eritrea</option>
                                <option value="EE" <?php echo isset($_POST['country']) && $_POST['country'] == 'EE' ? 'selected' : ''; ?>>Estonia</option>
                                <option value="ET" <?php echo isset($_POST['country']) && $_POST['country'] == 'ET' ? 'selected' : ''; ?>>Ethiopia</option>
                                <option value="FK" <?php echo isset($_POST['country']) && $_POST['country'] == 'FK' ? 'selected' : ''; ?>>Falkland Islands (Malvinas)</option>
                                <option value="FO" <?php echo isset($_POST['country']) && $_POST['country'] == 'FO' ? 'selected' : ''; ?>>Faroe Islands</option>
                                <option value="FJ" <?php echo isset($_POST['country']) && $_POST['country'] == 'FJ' ? 'selected' : ''; ?>>Fiji</option>
                                <option value="FI" <?php echo isset($_POST['country']) && $_POST['country'] == 'FI' ? 'selected' : ''; ?>>Finland</option>
                                <option value="FR" <?php echo isset($_POST['country']) && $_POST['country'] == 'FR' ? 'selected' : ''; ?>>France</option>
                                <option value="GF" <?php echo isset($_POST['country']) && $_POST['country'] == 'GF' ? 'selected' : ''; ?>>French Guiana</option>
                                <option value="PF" <?php echo isset($_POST['country']) && $_POST['country'] == 'PF' ? 'selected' : ''; ?>>French Polynesia</option>
                                <option value="TF" <?php echo isset($_POST['country']) && $_POST['country'] == 'TF' ? 'selected' : ''; ?>>French Southern Territories</option>
                                <option value="GA" <?php echo isset($_POST['country']) && $_POST['country'] == 'GA' ? 'selected' : ''; ?>>Gabon</option>
                                <option value="GM" <?php echo isset($_POST['country']) && $_POST['country'] == 'GM' ? 'selected' : ''; ?>>Gambia</option>
                                <option value="GE" <?php echo isset($_POST['country']) && $_POST['country'] == 'GE' ? 'selected' : ''; ?>>Georgia</option>
                                <option value="DE" <?php echo isset($_POST['country']) && $_POST['country'] == 'DE' ? 'selected' : ''; ?>>Germany</option>
                                <option value="GH" <?php echo isset($_POST['country']) && $_POST['country'] == 'GH' ? 'selected' : ''; ?>>Ghana</option>
                                <option value="GI" <?php echo isset($_POST['country']) && $_POST['country'] == 'GI' ? 'selected' : ''; ?>>Gibraltar</option>
                                <option value="GR" <?php echo isset($_POST['country']) && $_POST['country'] == 'GR' ? 'selected' : ''; ?>>Greece</option>
                                <option value="GL" <?php echo isset($_POST['country']) && $_POST['country'] == 'GL' ? 'selected' : ''; ?>>Greenland</option>
                                <option value="GD" <?php echo isset($_POST['country']) && $_POST['country'] == 'GD' ? 'selected' : ''; ?>>Grenada</option>
                                <option value="GP" <?php echo isset($_POST['country']) && $_POST['country'] == 'GP' ? 'selected' : ''; ?>>Guadeloupe</option>
                                <option value="GU" <?php echo isset($_POST['country']) && $_POST['country'] == 'GU' ? 'selected' : ''; ?>>Guam</option>
                                <option value="GT" <?php echo isset($_POST['country']) && $_POST['country'] == 'GT' ? 'selected' : ''; ?>>Guatemala</option>
                                <option value="GG" <?php echo isset($_POST['country']) && $_POST['country'] == 'GG' ? 'selected' : ''; ?>>Guernsey</option>
                                <option value="GN" <?php echo isset($_POST['country']) && $_POST['country'] == 'GN' ? 'selected' : ''; ?>>Guinea</option>
                                <option value="GW" <?php echo isset($_POST['country']) && $_POST['country'] == 'GW' ? 'selected' : ''; ?>>Guinea-bissau</option>
                                <option value="GY" <?php echo isset($_POST['country']) && $_POST['country'] == 'GY' ? 'selected' : ''; ?>>Guyana</option>
                                <option value="HT" <?php echo isset($_POST['country']) && $_POST['country'] == 'HT' ? 'selected' : ''; ?>>Haiti</option>
                                <option value="VA" <?php echo isset($_POST['country']) && $_POST['country'] == 'VA' ? 'selected' : ''; ?>>Holy See (Vatican City State)</option>
                                <option value="HN" <?php echo isset($_POST['country']) && $_POST['country'] == 'HN' ? 'selected' : ''; ?>>Honduras</option>
                                <option value="HK" <?php echo isset($_POST['country']) && $_POST['country'] == 'HK' ? 'selected' : ''; ?>>Hong Kong</option>
                                <option value="HU" <?php echo isset($_POST['country']) && $_POST['country'] == 'HU' ? 'selected' : ''; ?>>Hungary</option>
                                <option value="IS" <?php echo isset($_POST['country']) && $_POST['country'] == 'IS' ? 'selected' : ''; ?>>Iceland</option>
                                <option value="IN" <?php echo isset($_POST['country']) && $_POST['country'] == 'IN' ? 'selected' : ''; ?>>India</option>
                                <option value="ID" <?php echo isset($_POST['country']) && $_POST['country'] == 'ID' ? 'selected' : ''; ?>>Indonesia</option>
                                <option value="IR" <?php echo isset($_POST['country']) && $_POST['country'] == 'IR' ? 'selected' : ''; ?>>Iran, Islamic Republic of</option>
                                <option value="IQ" <?php echo isset($_POST['country']) && $_POST['country'] == 'IQ' ? 'selected' : ''; ?>>Iraq</option>
                                <option value="IE" <?php echo isset($_POST['country']) && $_POST['country'] == 'IE' ? 'selected' : ''; ?>>Ireland</option>
                                <option value="IM" <?php echo isset($_POST['country']) && $_POST['country'] == 'IM' ? 'selected' : ''; ?>>Isle of Man</option>
                                <option value="IL" <?php echo isset($_POST['country']) && $_POST['country'] == 'IL' ? 'selected' : ''; ?>>Israel</option>
                                <option value="IT" <?php echo isset($_POST['country']) && $_POST['country'] == 'IT' ? 'selected' : ''; ?>>Italy</option>
                                <option value="JM" <?php echo isset($_POST['country']) && $_POST['country'] == 'JM' ? 'selected' : ''; ?>>Jamaica</option>
                                <option value="JP" <?php echo isset($_POST['country']) && $_POST['country'] == 'JP' ? 'selected' : ''; ?>>Japan</option>
                                <option value="JE" <?php echo isset($_POST['country']) && $_POST['country'] == 'JE' ? 'selected' : ''; ?>>Jersey</option>
                                <option value="JO" <?php echo isset($_POST['country']) && $_POST['country'] == 'JO' ? 'selected' : ''; ?>>Jordan</option>
                                <option value="KZ" <?php echo isset($_POST['country']) && $_POST['country'] == 'KZ' ? 'selected' : ''; ?>>Kazakhstan</option>
                                <option value="KE" <?php echo isset($_POST['country']) && $_POST['country'] == 'KE' ? 'selected' : ''; ?>>Kenya</option>
                                <option value="KI" <?php echo isset($_POST['country']) && $_POST['country'] == 'KI' ? 'selected' : ''; ?>>Kiribati</option>
                                <option value="KP" <?php echo isset($_POST['country']) && $_POST['country'] == 'KP' ? 'selected' : ''; ?>>Korea, Democratic People's Republic of</option>
                                <option value="KR" <?php echo isset($_POST['country']) && $_POST['country'] == 'KR' ? 'selected' : ''; ?>>Korea, Republic of</option>
                                <option value="KW" <?php echo isset($_POST['country']) && $_POST['country'] == 'KW' ? 'selected' : ''; ?>>Kuwait</option>
                                <option value="KG" <?php echo isset($_POST['country']) && $_POST['country'] == 'KG' ? 'selected' : ''; ?>>Kyrgyzstan</option>
                                <option value="LA" <?php echo isset($_POST['country']) && $_POST['country'] == 'LA' ? 'selected' : ''; ?>>Lao People's Democratic Republic</option>
                                <option value="LV" <?php echo isset($_POST['country']) && $_POST['country'] == 'LV' ? 'selected' : ''; ?>>Latvia</option>
                                <option value="LB" <?php echo isset($_POST['country']) && $_POST['country'] == 'LB' ? 'selected' : ''; ?>>Lebanon</option>
                                <option value="LS" <?php echo isset($_POST['country']) && $_POST['country'] == 'LS' ? 'selected' : ''; ?>>Lesotho</option>
                                <option value="LR" <?php echo isset($_POST['country']) && $_POST['country'] == 'LR' ? 'selected' : ''; ?>>Liberia</option>
                                <option value="LY" <?php echo isset($_POST['country']) && $_POST['country'] == 'LY' ? 'selected' : ''; ?>>Libya</option>
                                <option value="LI" <?php echo isset($_POST['country']) && $_POST['country'] == 'LI' ? 'selected' : ''; ?>>Liechtenstein</option>
                                <option value="LT" <?php echo isset($_POST['country']) && $_POST['country'] == 'LT' ? 'selected' : ''; ?>>Lithuania</option>
                                <option value="LU" <?php echo isset($_POST['country']) && $_POST['country'] == 'LU' ? 'selected' : ''; ?>>Luxembourg</option>
                                <option value="MO" <?php echo isset($_POST['country']) && $_POST['country'] == 'MO' ? 'selected' : ''; ?>>Macao</option>
                                <option value="MK" <?php echo isset($_POST['country']) && $_POST['country'] == 'MK' ? 'selected' : ''; ?>>Macedonia, The Former Yugoslav Republic of</option>
                                <option value="MG" <?php echo isset($_POST['country']) && $_POST['country'] == 'MG' ? 'selected' : ''; ?>>Madagascar</option>
                                <option value="MW" <?php echo isset($_POST['country']) && $_POST['country'] == 'MW' ? 'selected' : ''; ?>>Malawi</option>
                                <option value="MY" <?php echo isset($_POST['country']) && $_POST['country'] == 'MY' ? 'selected' : ''; ?>>Malaysia</option>
                                <option value="MV" <?php echo isset($_POST['country']) && $_POST['country'] == 'MV' ? 'selected' : ''; ?>>Maldives</option>
                                <option value="ML" <?php echo isset($_POST['country']) && $_POST['country'] == 'ML' ? 'selected' : ''; ?>>Mali</option>
                                <option value="MT" <?php echo isset($_POST['country']) && $_POST['country'] == 'MT' ? 'selected' : ''; ?>>Malta</option>
                                <option value="MH" <?php echo isset($_POST['country']) && $_POST['country'] == 'MH' ? 'selected' : ''; ?>>Marshall Islands</option>
                                <option value="MQ" <?php echo isset($_POST['country']) && $_POST['country'] == 'MQ' ? 'selected' : ''; ?>>Martinique</option>
                                <option value="MR" <?php echo isset($_POST['country']) && $_POST['country'] == 'MR' ? 'selected' : ''; ?>>Mauritania</option>
                                <option value="MU" <?php echo isset($_POST['country']) && $_POST['country'] == 'MU' ? 'selected' : ''; ?>>Mauritius</option>
                                <option value="YT" <?php echo isset($_POST['country']) && $_POST['country'] == 'YT' ? 'selected' : ''; ?>>Mayotte</option>
                                <option value="MX" <?php echo isset($_POST['country']) && $_POST['country'] == 'MX' ? 'selected' : ''; ?>>Mexico</option>
                                <option value="FM" <?php echo isset($_POST['country']) && $_POST['country'] == 'FM' ? 'selected' : ''; ?>>Micronesia, Federated States of</option>
                                <option value="MD" <?php echo isset($_POST['country']) && $_POST['country'] == 'MD' ? 'selected' : ''; ?>>Moldova, Republic of</option>
                                <option value="MC" <?php echo isset($_POST['country']) && $_POST['country'] == 'MC' ? 'selected' : ''; ?>>Monaco</option>
                                <option value="MN" <?php echo isset($_POST['country']) && $_POST['country'] == 'MN' ? 'selected' : ''; ?>>Mongolia</option>
                                <option value="ME" <?php echo isset($_POST['country']) && $_POST['country'] == 'ME' ? 'selected' : ''; ?>>Montenegro</option>
                                <option value="MS" <?php echo isset($_POST['country']) && $_POST['country'] == 'MS' ? 'selected' : ''; ?>>Montserrat</option>
                                <option value="MA" <?php echo isset($_POST['country']) && $_POST['country'] == 'MA' ? 'selected' : ''; ?>>Morocco</option>
                                <option value="MZ" <?php echo isset($_POST['country']) && $_POST['country'] == 'MZ' ? 'selected' : ''; ?>>Mozambique</option>
                                <option value="MM" <?php echo isset($_POST['country']) && $_POST['country'] == 'MM' ? 'selected' : ''; ?>>Myanmar</option>
                                <option value="NA" <?php echo isset($_POST['country']) && $_POST['country'] == 'NA' ? 'selected' : ''; ?>>Namibia</option>
                                <option value="NR" <?php echo isset($_POST['country']) && $_POST['country'] == 'NR' ? 'selected' : ''; ?>>Nauru</option>
                                <option value="NP" <?php echo isset($_POST['country']) && $_POST['country'] == 'NP' ? 'selected' : ''; ?>>Nepal</option>
                                <option value="NL" <?php echo isset($_POST['country']) && $_POST['country'] == 'NL' ? 'selected' : ''; ?>>Netherlands</option>
                                <option value="NC" <?php echo isset($_POST['country']) && $_POST['country'] == 'NC' ? 'selected' : ''; ?>>New Caledonia</option>
                                <option value="NZ" <?php echo isset($_POST['country']) && $_POST['country'] == 'NZ' ? 'selected' : ''; ?>>New Zealand</option>
                                <option value="NI" <?php echo isset($_POST['country']) && $_POST['country'] == 'NI' ? 'selected' : ''; ?>>Nicaragua</option>
                                <option value="NE" <?php echo isset($_POST['country']) && $_POST['country'] == 'NE' ? 'selected' : ''; ?>>Niger</option>
                                <option value="NG" <?php echo isset($_POST['country']) && $_POST['country'] == 'NG' ? 'selected' : ''; ?>>Nigeria</option>
                                <option value="NU" <?php echo isset($_POST['country']) && $_POST['country'] == 'NU' ? 'selected' : ''; ?>>Niue</option>
                                <option value="NF" <?php echo isset($_POST['country']) && $_POST['country'] == 'NF' ? 'selected' : ''; ?>>Norfolk Island</option>
                                <option value="MP" <?php echo isset($_POST['country']) && $_POST['country'] == 'MP' ? 'selected' : ''; ?>>Northern Mariana Islands</option>
                                <option value="NO" <?php echo isset($_POST['country']) && $_POST['country'] == 'NO' ? 'selected' : ''; ?>>Norway</option>
                                <option value="OM" <?php echo isset($_POST['country']) && $_POST['country'] == 'OM' ? 'selected' : ''; ?>>Oman</option>
                                <option value="PK" <?php echo isset($_POST['country']) && $_POST['country'] == 'PK' ? 'selected' : ''; ?>>Pakistan</option>
                                <option value="PW" <?php echo isset($_POST['country']) && $_POST['country'] == 'PW' ? 'selected' : ''; ?>>Palau</option>
                                <option value="PS" <?php echo isset($_POST['country']) && $_POST['country'] == 'PS' ? 'selected' : ''; ?>>Palestinian Territory, Occupied</option>
                                <option value="PA" <?php echo isset($_POST['country']) && $_POST['country'] == 'PA' ? 'selected' : ''; ?>>Panama</option>
                                <option value="PG" <?php echo isset($_POST['country']) && $_POST['country'] == 'PG' ? 'selected' : ''; ?>>Papua New Guinea</option>
                                <option value="PY" <?php echo isset($_POST['country']) && $_POST['country'] == 'PY' ? 'selected' : ''; ?>>Paraguay</option>
                                <option value="PE" <?php echo isset($_POST['country']) && $_POST['country'] == 'PE' ? 'selected' : ''; ?>>Peru</option>
                                <option value="PH" <?php echo isset($_POST['country']) && $_POST['country'] == 'PH' ? 'selected' : ''; ?>>Philippines</option>
                                <option value="PN" <?php echo isset($_POST['country']) && $_POST['country'] == 'PN' ? 'selected' : ''; ?>>Pitcairn</option>
                                <option value="PL" <?php echo isset($_POST['country']) && $_POST['country'] == 'PL' ? 'selected' : ''; ?>>Poland</option>
                                <option value="PT" <?php echo isset($_POST['country']) && $_POST['country'] == 'PT' ? 'selected' : ''; ?>>Portugal</option>
                                <option value="PR" <?php echo isset($_POST['country']) && $_POST['country'] == 'PR' ? 'selected' : ''; ?>>Puerto Rico</option>
                                <option value="QA" <?php echo isset($_POST['country']) && $_POST['country'] == 'QA' ? 'selected' : ''; ?>>Qatar</option>
                                <option value="RE" <?php echo isset($_POST['country']) && $_POST['country'] == 'RE' ? 'selected' : ''; ?>>Reunion</option>
                                <option value="RO" <?php echo isset($_POST['country']) && $_POST['country'] == 'RO' ? 'selected' : ''; ?>>Romania</option>
                                <option value="RU" <?php echo isset($_POST['country']) && $_POST['country'] == 'RU' ? 'selected' : ''; ?>>Russian Federation</option>
                                <option value="RW" <?php echo isset($_POST['country']) && $_POST['country'] == 'RW' ? 'selected' : ''; ?>>Rwanda</option>
                                <option value="BL" <?php echo isset($_POST['country']) && $_POST['country'] == 'BL' ? 'selected' : ''; ?>>Saint Barthelemy</option>
                                <option value="SH" <?php echo isset($_POST['country']) && $_POST['country'] == 'SH' ? 'selected' : ''; ?>>Saint Helena, Ascension and Tristan da Cunha</option>
                                <option value="KN" <?php echo isset($_POST['country']) && $_POST['country'] == 'KN' ? 'selected' : ''; ?>>Saint Kitts and Nevis</option>
                                <option value="LC" <?php echo isset($_POST['country']) && $_POST['country'] == 'LC' ? 'selected' : ''; ?>>Saint Lucia</option>
                                <option value="MF" <?php echo isset($_POST['country']) && $_POST['country'] == 'MF' ? 'selected' : ''; ?>>Saint Martin (French part)</option>
                                <option value="PM" <?php echo isset($_POST['country']) && $_POST['country'] == 'PM' ? 'selected' : ''; ?>>Saint Pierre and Miquelon</option>
                                <option value="VC" <?php echo isset($_POST['country']) && $_POST['country'] == 'VC' ? 'selected' : ''; ?>>Saint Vincent and The Grenadines</option>
                                <option value="WS" <?php echo isset($_POST['country']) && $_POST['country'] == 'WS' ? 'selected' : ''; ?>>Samoa</option>
                                <option value="SM" <?php echo isset($_POST['country']) && $_POST['country'] == 'SM' ? 'selected' : ''; ?>>San Marino</option>
                                <option value="ST" <?php echo isset($_POST['country']) && $_POST['country'] == 'ST' ? 'selected' : ''; ?>>Sao Tome and Principe</option>
                                <option value="SA" <?php echo isset($_POST['country']) && $_POST['country'] == 'SA' ? 'selected' : ''; ?>>Saudi Arabia</option>
                                <option value="SN" <?php echo isset($_POST['country']) && $_POST['country'] == 'SN' ? 'selected' : ''; ?>>Senegal</option>
                                <option value="RS" <?php echo isset($_POST['country']) && $_POST['country'] == 'RS' ? 'selected' : ''; ?>>Serbia</option>
                                <option value="SC" <?php echo isset($_POST['country']) && $_POST['country'] == 'SC' ? 'selected' : ''; ?>>Seychelles</option>
                                <option value="SL" <?php echo isset($_POST['country']) && $_POST['country'] == 'SL' ? 'selected' : ''; ?>>Sierra Leone</option>
                                <option value="SG" <?php echo isset($_POST['country']) && $_POST['country'] == 'SG' ? 'selected' : ''; ?>>Singapore</option>
                                <option value="SX" <?php echo isset($_POST['country']) && $_POST['country'] == 'SX' ? 'selected' : ''; ?>>Sint Maarten (Dutch part)</option>
                                <option value="SK" <?php echo isset($_POST['country']) && $_POST['country'] == 'SK' ? 'selected' : ''; ?>>Slovakia</option>
                                <option value="SI" <?php echo isset($_POST['country']) && $_POST['country'] == 'SI' ? 'selected' : ''; ?>>Slovenia</option>
                                <option value="SB" <?php echo isset($_POST['country']) && $_POST['country'] == 'SB' ? 'selected' : ''; ?>>Solomon Islands</option>
                                <option value="SO" <?php echo isset($_POST['country']) && $_POST['country'] == 'SO' ? 'selected' : ''; ?>>Somalia</option>
                                <option value="ZA" <?php echo isset($_POST['country']) && $_POST['country'] == 'ZA' ? 'selected' : ''; ?>>South Africa</option>
                                <option value="GS" <?php echo isset($_POST['country']) && $_POST['country'] == 'GS' ? 'selected' : ''; ?>>South Georgia and The South Sandwich Islands</option>
                                <option value="SS" <?php echo isset($_POST['country']) && $_POST['country'] == 'SS' ? 'selected' : ''; ?>>South Sudan</option>
                                <option value="ES" <?php echo isset($_POST['country']) && $_POST['country'] == 'ES' ? 'selected' : ''; ?>>Spain</option>
                                <option value="LK" <?php echo isset($_POST['country']) && $_POST['country'] == 'LK' ? 'selected' : ''; ?>>Sri Lanka</option>
                                <option value="SD" <?php echo isset($_POST['country']) && $_POST['country'] == 'SD' ? 'selected' : ''; ?>>Sudan</option>
                                <option value="SR" <?php echo isset($_POST['country']) && $_POST['country'] == 'SR' ? 'selected' : ''; ?>>Suriname</option>
                                <option value="SJ" <?php echo isset($_POST['country']) && $_POST['country'] == 'SJ' ? 'selected' : ''; ?>>Svalbard and Jan Mayen</option>
                                <option value="SZ" <?php echo isset($_POST['country']) && $_POST['country'] == 'SZ' ? 'selected' : ''; ?>>Swaziland</option>
                                <option value="SE" <?php echo isset($_POST['country']) && $_POST['country'] == 'SE' ? 'selected' : ''; ?>>Sweden</option>
                                <option value="CH" <?php echo isset($_POST['country']) && $_POST['country'] == 'CH' ? 'selected' : ''; ?>>Switzerland</option>
                                <option value="SY" <?php echo isset($_POST['country']) && $_POST['country'] == 'SY' ? 'selected' : ''; ?>>Syrian Arab Republic</option>
                                <option value="TW" <?php echo isset($_POST['country']) && $_POST['country'] == 'TW' ? 'selected' : ''; ?>>Taiwan, Province of China</option>
                                <option value="TJ" <?php echo isset($_POST['country']) && $_POST['country'] == 'TJ' ? 'selected' : ''; ?>>Tajikistan</option>
                                <option value="TZ" <?php echo isset($_POST['country']) && $_POST['country'] == 'TZ' ? 'selected' : ''; ?>>Tanzania, United Republic of</option>
                                <option value="TH" <?php echo isset($_POST['country']) && $_POST['country'] == 'TH' ? 'selected' : ''; ?>>Thailand</option>
                                <option value="TL" <?php echo isset($_POST['country']) && $_POST['country'] == 'TL' ? 'selected' : ''; ?>>Timor-leste</option>
                                <option value="TG" <?php echo isset($_POST['country']) && $_POST['country'] == 'TG' ? 'selected' : ''; ?>>Togo</option>
                                <option value="TK" <?php echo isset($_POST['country']) && $_POST['country'] == 'TK' ? 'selected' : ''; ?>>Tokelau</option>
                                <option value="TO" <?php echo isset($_POST['country']) && $_POST['country'] == 'TO' ? 'selected' : ''; ?>>Tonga</option>
                                <option value="TT" <?php echo isset($_POST['country']) && $_POST['country'] == 'TT' ? 'selected' : ''; ?>>Trinidad and Tobago</option>
                                <option value="TN" <?php echo isset($_POST['country']) && $_POST['country'] == 'TN' ? 'selected' : ''; ?>>Tunisia</option>
                                <option value="TR" <?php echo isset($_POST['country']) && $_POST['country'] == 'TR' ? 'selected' : ''; ?>>Turkey</option>
                                <option value="TM" <?php echo isset($_POST['country']) && $_POST['country'] == 'TM' ? 'selected' : ''; ?>>Turkmenistan</option>
                                <option value="TC" <?php echo isset($_POST['country']) && $_POST['country'] == 'TC' ? 'selected' : ''; ?>>Turks and Caicos Islands</option>
                                <option value="TV" <?php echo isset($_POST['country']) && $_POST['country'] == 'TV' ? 'selected' : ''; ?>>Tuvalu</option>
                                <option value="UG" <?php echo isset($_POST['country']) && $_POST['country'] == 'UG' ? 'selected' : ''; ?>>Uganda</option>
                                <option value="UA" <?php echo isset($_POST['country']) && $_POST['country'] == 'UA' ? 'selected' : ''; ?>>Ukraine</option>
                                <option value="AE" <?php echo isset($_POST['country']) && $_POST['country'] == 'AE' ? 'selected' : ''; ?>>United Arab Emirates</option>
                                <option value="GB" <?php echo isset($_POST['country']) && $_POST['country'] == 'GB' ? 'selected' : ''; ?>>United Kingdom</option>
                                <option value="US" <?php echo isset($_POST['country']) && $_POST['country'] == 'US' ? 'selected' : ''; ?>>United States</option>
                                <option value="UM" <?php echo isset($_POST['country']) && $_POST['country'] == 'UM' ? 'selected' : ''; ?>>United States Minor Outlying Islands</option>
                                <option value="UY" <?php echo isset($_POST['country']) && $_POST['country'] == 'UY' ? 'selected' : ''; ?>>Uruguay</option>
                                <option value="UZ" <?php echo isset($_POST['country']) && $_POST['country'] == 'UZ' ? 'selected' : ''; ?>>Uzbekistan</option>
                                <option value="VU" <?php echo isset($_POST['country']) && $_POST['country'] == 'VU' ? 'selected' : ''; ?>>Vanuatu</option>
                                <option value="VE" <?php echo isset($_POST['country']) && $_POST['country'] == 'VE' ? 'selected' : ''; ?>>Venezuela, Bolivarian Republic of</option>
                                <option value="VN" <?php echo isset($_POST['country']) && $_POST['country'] == 'VN' ? 'selected' : ''; ?>>Viet Nam</option>
                                <option value="VG" <?php echo isset($_POST['country']) && $_POST['country'] == 'VG' ? 'selected' : ''; ?>>Virgin Islands, British</option>
                                <option value="VI" <?php echo isset($_POST['country']) && $_POST['country'] == 'VI' ? 'selected' : ''; ?>>Virgin Islands, U.S.</option>
                                <option value="WF" <?php echo isset($_POST['country']) && $_POST['country'] == 'WF' ? 'selected' : ''; ?>>Wallis and Futuna</option>
                                <option value="EH" <?php echo isset($_POST['country']) && $_POST['country'] == 'EH' ? 'selected' : ''; ?>>Western Sahara</option>
                                <option value="YE" <?php echo isset($_POST['country']) && $_POST['country'] == 'YE' ? 'selected' : ''; ?>>Yemen</option>
                                <option value="ZM" <?php echo isset($_POST['country']) && $_POST['country'] == 'ZM' ? 'selected' : ''; ?>>Zambia</option>
                                <option value="ZW" <?php echo isset($_POST['country']) && $_POST['country'] == 'ZW' ? 'selected' : ''; ?>>Zimbabwe</option>

                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="mobile-number">Mobile Number</label>
                            <input type="text" id="mobile-number" name="mobile-number" placeholder="Type Here..." class="input-control" value="<?php echo isset($_POST['mobile-number']) ? esc_attr($_POST['mobile-number']) : ''; ?>">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="email">Email <sup>*</sup></label>
                            <input type="text" id="email" name="email" placeholder="Type Here..." class="input-control" value="<?php echo isset($_POST['email']) ? esc_attr($_POST['email']) : ''; ?>">
                        </div>
                    </div>
                    <!-- <div class="col-md-6">
                        <div class="form-group">
                            <label for="password">Password <sup>*</sup></label>
                            <input type="password" id="password" name="password" placeholder="Type Here..." class="input-control">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="re-enter_password">Re-enter Password <sup>*</sup></label>
                            <input type="password" id="re-enter_password" name="re-enter_password" placeholder="Type Here..." class="input-control">
                        </div>
                    </div> -->


                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="password">Password <sup>*</sup></label>
                            <div class="password-wrapper">
                                <input type="password" id="password" name="password" placeholder="Type Here..." class="input-control">
                                <span toggle="#password" class="toggle-password"><i class="ri-eye-line"></i></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="re-enter_password">Re-enter Password <sup>*</sup></label>
                            <div class="password-wrapper">
                                <input type="password" id="re-enter_password" name="re-enter_password" placeholder="Type Here..." class="input-control">
                                <span toggle="#re-enter_password" class="toggle-password"><i class="ri-eye-line"></i></span>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <button type="submit" class="sign-btn">
                                <i class="ri-account-circle-line"></i>
                                Sign Up
                            </button>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <p>Don't have an account?<a class="txt-hv" href="<?php echo esc_url(home_url('/sign-in/')); ?>">Sign in</a></p>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
</main>
<style>
    /* .password-wrapper {
    position: relative;
}

.toggle-password {
    position: absolute;
    top: 50%;
    right: 10px;
    transform: translateY(-50%);
    cursor: pointer;
} */
</style>
<script>
    jQuery(document).ready(function($) {
        // $('.toggle-password').click(function() {
        //     // Select the previous input field relative to the clicked toggle icon
        //     var inputField = $(this).siblings('input');

        //     if (inputField.attr('type') === 'password') {
        //         inputField.attr('type', 'text');
        //         $(this).html('<i class="ri-eye-off-line"></i>'); // Change to 'eye-off' icon when showing
        //     } else {
        //         inputField.attr('type', 'password');
        //         $(this).html('<i class="ri-eye-line"></i>'); // Change back to 'eye' icon when hiding
        //     }
        // });
    });
</script>
<script>
    jQuery(document).ready(function($) {
        // Check if the URL contains the registration_success query parameter
        var urlParams = new URLSearchParams(window.location.search);
        if (urlParams.has('registration_success') && urlParams.get('registration_success') === 'true') {
            Swal.fire({
                position: 'center center',
                icon: 'success',
                title: 'Registration Successful',
                showConfirmButton: true,
                timer: 1500
            });
        }
    });
</script>
<?php get_footer(); ?>