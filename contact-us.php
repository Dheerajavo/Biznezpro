<?php /* Template Name: Contact Us */ ?>
<?php get_header(); ?>

<!-- main content area start -->
<div class="main-content-area">
    <div class="contact-us">
        <div class="contact-form">
        <?php get_template_part('template-parts/common-top-logo'); ?>

            <?php
            // Check if form was submitted
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                // Sanitize and validate form data
                $name = sanitize_text_field($_POST['name']);
                $contact_number = sanitize_text_field($_POST['contact_number']);
                $email = sanitize_email($_POST['email']);
                $title = sanitize_text_field($_POST['title']);
                $description = sanitize_textarea_field($_POST['description']);
                
                // Prepare email content
                $to = 'devavology12@gmail.com'; // Sends to site admin email by default
                $subject = "New Contact Us Form Submission: " . $title;
                $message = "Name: $name\n";
                $message .= "Contact Number: $contact_number\n";
                $message .= "Email: $email\n";
                $message .= "Title: $title\n";
                $message .= "Description:\n$description\n";
                $headers = "From: $email";

                // Send the email
                if (wp_mail($to, $subject, $message, $headers)) {
                    echo '<p class="success-message">Thank you for contacting us! We will get back to you shortly.</p>';
                } else {
                    echo '<p class="error-message">There was an issue sending your message. Please try again later.</p>';
                }
            }
            ?>

            <form method="POST" action="">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name">Name <sup>*</sup></label>
                            <input type="text" id="name" name="name" placeholder="Type Here..." class="input-control" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="contact-number">Contact Number <sup>*</sup></label>
                            <input type="text" id="contact-number" name="contact_number" placeholder="Type Here..." class="input-control" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="email">Email <sup>*</sup></label>
                            <input type="email" id="email" name="email" placeholder="Type Here..." class="input-control" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="title">Title <sup>*</sup></label>
                            <input type="text" id="title" name="title" placeholder="Type Here..." class="input-control" required>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="description">Description <sup>*</sup></label>
                            <textarea name="description" id="description" placeholder="Type Here..." class="input-control" required></textarea>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="submit-btn">
                            <button type="submit" class="primary-btn">Submit</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
</main>
<?php get_footer(); ?>
