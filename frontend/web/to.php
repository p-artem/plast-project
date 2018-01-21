<?php
if (empty($_GET["url"])){
    exit;
}
$url = $_GET["url"];
header("Location: $url");
?>