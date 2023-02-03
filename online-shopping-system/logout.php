<?php

session_start();

unset($_SESSION["uid"]);
unset($_SESSION["name"]);

$backToMyPage = filter_var($backToMyPage, FILTER_VALIDATE_URL);
$trustedURLs = array('https://example.com', 'https://example.org');

if ($backToMyPage && in_array($backToMyPage, $trustedURLs)) {
    header('Location: '.$backToMyPage);
} else {
    header('Location: https://example.com');
}

exit;

?>
