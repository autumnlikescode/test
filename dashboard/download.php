<?php
error_reporting(0);

require '../keyauth.php';
require '../credentials.php';

session_start();



if (!isset($_SESSION['user_data'])) // if user not logged in
{
    header("Location: ../");
    exit();
}


$length = 16;
$randomString = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, $length);
$fileName = $randomString . ".zip";
$fileUrl = "https://cdn.discordapp.com/attachments/977167884033867827/977168128050073610/Jrilla_-_somebody_I_used_to_drill_BASS_BOOSTED.mp3"; // replace with your actual file URL

header("Content-disposition: attachment; filename=$fileName");
header("Content-type: application/zip");
readfile($fileUrl);
?>