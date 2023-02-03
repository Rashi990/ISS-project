<?php

session_start();

unset($_SESSION["uid"]);
unset($_SESSION["name"]);

$backToMyPage = $_SERVER['HTTP_REFERER'];
$trustedURLs = array('https://example.com', 'https://example.org');

if (isset($backToMyPage) && in_array($backToMyPage, $trustedURLs)) {
    header('Location: '.$backToMyPage);
} else {
    header('Location: index.php'); // default page
}

exit;

?>
