<?php
	$showForm = true;
	$result = '';
 	$err = '';
	// Check if name has been entered
	if (!$_POST['name']) $err = 'Please enter your name.';
	// Check if email has been entered and is valid
	if (!$_POST['email'] || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) $err = 'Please enter a valid email address.';
	//Check if message has been entered
	if (!$_POST['message']) $err = 'Please enter your message.';
	//Check if simple anti-bot test is correct
	//if ($human !== 5) $err = 'Your anti-spam is incorrect';

	// If there are no errors, send the email
	if ($err === '') {
		$showForm = false;
		$name = $_POST['name'];
		$email = $_POST['email'];
		$message = $_POST['message'];
		$from = ($name . ' <' . $email . '>');
		$to = 'Eric Zuckerman <ericthezuck@gmail.com>';
		$subject = 'Webmail Contact';
		$body = stripslashes("From: $name\nE-Mail: $email\nMessage:\n$message");

		$headers = "X-Mailer: PHP/" . phpversion() . "\n";
		$headers .= "X-Priority: 3\n";
		$headers .= "Return-Path: " . $from . "\n";
		$headers .= "Reply-To: " . $from . "\n";
		$headers .= "From: " . $from . "\n";
		$headers .= "X-Sender: " . $from;
		$mail_sent = mail($to, $subject, $body, $headers); //this may succeed but you may not get the email if your server is not setup to allow messages from the domain the user entered
		if ($mail_sent) {
			$result = '<div class="alert alert-success">Thank You! I will be in touch.</div>';
		} else {
			$result = '<div class="alert alert-danger">Sorry there was an error sending your message.<br><br>Please try again later.</div>';
		}
	} else {
		$result = '<div class="alert alert-danger">Sorry there was an error with your submission:<br><br>' . $err . '<br><br>Please try again.</div>';
	}
	echo ('{"showForm":' . (($showForm) ? 'true' : 'false') . ',"result":"' . addslashes($result) . '"}');
?>