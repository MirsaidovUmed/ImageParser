<?php

namespace App;

use DOMDocument;

function getHTMLFromURL(string $url): string
{
    return file_get_contents($url);
}

function parseImagesFromHTML(string $html): array|string
{
    $doc = new DOMDocument();
    $doc->loadHTML($html);
    $tags = $doc->getElementsByTagName('img');
    $images = [];
    foreach ($tags as $tag) {
        $images[] = $tag->getAttribute('src');
    }
    return $images;
}


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['url'])) {
    $url = $_POST['url'];
    $html = getHTMLFromURL($url);
    $images = parseImagesFromHTML($html);

    if (!empty($images)) {
        http_response_code(200);
        echo json_encode($images);
    } else {
        http_response_code(404);
        echo json_encode(['error' => 'Картинки не найдены']);
    }
}
