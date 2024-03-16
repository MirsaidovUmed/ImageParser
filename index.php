<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Парсер картинок</title>
</head>
<body>
<p>Введите URL для парсинга:</p>
<form action="index.php" method="post">
    <input type="text" name="url" placeholder="введите Url">
    <input type="submit" value="Отправить">
</form>
<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!empty($_POST['url'])) {
        $ch = curl_init();
        $data = array('url' => $_POST['url']);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_URL, 'http://localhost/example_home_project/module_18/HTMLProcessor.php');

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        curl_close($ch);

        if ($httpCode == 200) {
            $responseData = json_decode($response, true);
            $images = $responseData;
            if (!empty($images)) {
                echo "<div>";
                foreach ($images as $image) {
                    echo "<img src=\"$image\">";
                }
                echo "</div>";
            } else {
                echo "Картинки не найдены";
            }
        } else {
            echo "Ошибка: $httpCode";
        }
    }
}
?>
</body>
</html>

