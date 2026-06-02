<?php
$firstName = 'Maksym';
$greeting = 'hello, ';

echo $greeting . $firstName . "\n";

$message = $greeting . $firstName;

echo "message:\n";
echo $message . "\n";

$to = 'superoriginaladress@gmail.com';
$subject = 'MY TEST EMAIL';
$headers = 'From: m.i.lytvynenko@student.khai.edu';

if(mail($to, $subject, $message, $headers)) {
    echo "The email was sent successfully!\n";
} else {
    echo "Email sending error.\n";
}
