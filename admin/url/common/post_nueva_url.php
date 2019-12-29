<?php
require "ControlUrls.php";

$control_urls = new ControlUrls();
$urlpatters = parse_url($_POST['url']);
$scheme = $urlpatters['scheme'];
if ($scheme !== 'https') {
    echo json_encode(htmlspecialchars("url inválida"));
    return;
} else {
    echo json_encode($control_urls->insert_url($_POST['url']));
}