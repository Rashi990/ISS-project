<?php

session_start();

unset($_SESSION["uid"]);
unset($_SESSION["name"]);

$backToMyPage = filter_var($backToMyPage, FILTER_VALIDATE_URL);
$trustedURLs = array('index.php ');

if ($backToMyPage && in_array($backToMyPage, $trustedURLs)) {
    header('Location: '.$backToMyPage);
} else {
    header('Location:index.php ');
}

exit;

?>
