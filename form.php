<!DOCTYPE HTML>
<html>
<head>
    <title>Загрузка изображения</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>
<body>
<h1>Загрузка изображения</h1>
<?php

// Пути загрузки файлов
$path = 'i/';
$tmp_path = 'tmp/';
// Массив допустимых значений типа файла
$types = array('image/jpeg');
// Максимальный размер файла
$size = 1024000;

// Обработка запроса
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    @$imagedetails = getimagesize($path . $_FILES['picture']['name']);
    $width = $imagedetails[0];
    $height = $imagedetails[1];
    // Проверяем тип файла
    if (!in_array($_FILES['picture']['type'], $types)) {
        die('<p>Запрещённый тип файла. Выберете изображение с расширением jpeg <a href="?">Попробовать другой файл?</a></p>');
    }
    // Проверяем размер файла
    if ($_FILES['picture']['size'] > $size) {
        die('<p>Слишком большой размер файла. <a href="?">Попробовать другой файл?</a></p>');
    }
    // Загрузка файла и вывод сообщения
    if (!@copy($_FILES['picture']['tmp_name'], $path . $_FILES['picture']['name'])){
        echo 'Что-то пошло не так';
    }
    else {
        //echo '<img src="' . $path . $_FILES['picture']['name'] . '">' . ' ';
        //echo $width. " ";
        //echo $height;
        list($width, $height) = getimagesize($path . $_FILES['picture']['name']);
        $newwidth = 200;
        $newheight = 100;


        $thumb_width = 250;
        $thumb_height = 170;
        $original_aspect = $width / $height;
        $thumb_aspect = $thumb_width / $thumb_height;


        $original_aspect = $width / $height;
        $thumb_aspect = $thumb_width / $thumb_height;

        if ($original_aspect >= $thumb_aspect) {
            // If image is wider than thumbnail (in aspect ratio sense)
            $new_height = $thumb_height;
            $new_width = $width / ($height / $thumb_height);
        } else {
            // If the thumbnail is wider than the image
            $new_width = $thumb_width;
            $new_height = $height / ($width / $thumb_width);
        }

        // загрузка
        $thumb = imagecreatetruecolor($thumb_width, $thumb_height);
        $source = imagecreatefromjpeg($path . $_FILES['picture']['name']);

        // изменение размера
        imagecopyresized($thumb, $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);

        imagecopyresampled($thumb, $source,
            0 - ($new_width - $thumb_width) / 2, // Center the image horizontally
            0 - ($new_height - $thumb_height) / 2, // Center the image vertically
            0, 0,
            $new_width, $new_height,
            $width, $height);
        imagejpeg($thumb, "file.jpeg", 100);


        // вывод
        /*imagejpeg($thumb, "file.jpeg");
        echo '<img src="file.jpeg">'. ' ';

        list($widthmin, $heightmin) = getimagesize("file.jpeg");
        $newwidthmin = 150;
        $newheightmin = 150;

        // загрузка
        $thumbmin = imagecreatetruecolor($newwidthmin, $newheightmin);
        $sourcemin = imagecreatefromjpeg($path . $_FILES['picture']['name']);

        // изменение размера
        imagecopyresized($thumbmin, $sourcemin, 0, 0, 0, 0, $newwidthmin, $newheightmin, $widthmin, $heightmin);

        // вывод
        imagejpeg($thumbmin, "mini.jpeg");
        echo '<img src="mini.jpeg">';*/
        echo '<img src="file.jpeg">' . ' ';



        list($width_min, $height_min) = getimagesize($path . $_FILES['picture']['name']);
        $newwidth_min = 200;
        $newheight_min = 100;


        $thumb_width_min = 150;
        $thumb_height_min = 150;
        $original_aspect = $width_min / $height_min;
        $thumb_aspect_min = $thumb_width_min / $thumb_height_min;


        $original_aspect_min = $width_min / $height_min;
        $thumb_aspect_min = $thumb_width_min / $thumb_height_min;

        if ($original_aspect_min >= $thumb_aspect_min) {
            // If image is wider than thumbnail (in aspect ratio sense)
            $new_height_min = $thumb_height_min;
            $new_width_min = $width_min / ($height_min / $thumb_height_min);
        } else {
            // If the thumbnail is wider than the image
            $new_width_min = $thumb_width_min;
            $new_height_min = $height_min / ($width_min / $thumb_width_min);
        }

        // загрузка
        $thumb_min = imagecreatetruecolor($thumb_width_min, $thumb_height_min);
        $source_min = imagecreatefromjpeg($path . $_FILES['picture']['name']);

        // изменение размера
        //imagecopyresized($thumb, $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);

        imagecopyresampled($thumb_min, $source_min,
            0 - ($new_width_min - $thumb_width_min) / 2, // Center the image horizontally
            0 - ($new_height_min - $thumb_height_min) / 2, // Center the image vertically
            0, 0,
            $new_width_min, $new_height_min,
            $width_min, $height_min);
        imagejpeg($thumb_min, "min.jpeg", 100);

        echo '<img src="min.jpeg">';
    }
}
?>
<form method="post" enctype="multipart/form-data">
    <input type="file" name="picture">
    <input type="submit" value="Загрузить">
</form>
</body>
</html>