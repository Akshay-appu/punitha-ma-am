<?php
  /**
   * Requires the "PHP Email Form" library
   * The "PHP Email Form" library is available only in the pro version of the template
   * The library should be uploaded to: vendor/php-email-form/php-email-form.php
   * For more info and help: https://bootstrapmade.com/php-email-form/
   */

  // Allow requests from any origin (CORS)
  header("Access-Control-Allow-Origin: *");
  header("Access-Control-Allow-Methods: POST");
  header("Access-Control-Allow-Headers: Content-Type");

  // Replace with your real receiving email address
  $receiving_email_address = 'akshaykumarappu100@gmail.com';

  // Corrected path for PHP Email Form library
  if (file_exists($php_email_form = 'assets/vendor/php-email-form/validate.js')) {
    include($php_email_form);
  } else {
    die('Unable to load the "PHP Email Form" Library!');
  }

  $contact = new PHP_Email_Form;
  $contact->ajax = true;

  // Check if POST data is available
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $contact->to = $receiving_email_address;
    $contact->from_name = isset($_POST['name']) ? $_POST['name'] : '';
    $contact->from_email = isset($_POST['email']) ? $_POST['email'] : '';
    $contact->subject = isset($_POST['subject']) ? $_POST['subject'] : '';

    $contact->add_message($contact->from_name, 'From');
    $contact->add_message($contact->from_email, 'Email');

    if (isset($_POST['phone'])) {
      $contact->add_message($_POST['phone'], 'Phone');
    }

    $contact->add_message(isset($_POST['message']) ? $_POST['message'] : '', 'Message', 10);

    // Send the email
    echo $contact->send();
  } else {
    // If not a POST request
    http_response_code(405);
    echo json_encode(['error' => 'Method Not Allowed']);
  }
?>
