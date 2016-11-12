<?php
/**
 * Created by PhpStorm.
 * User: dinhkk
 * Date: 11/12/16
 * Time: 2:23 PM
 */

if (empty($_GET['path'])) {
    die('file not found');
}
$path = $_GET['path'];
$file = "files/{$path}";
if (!is_readable($file)) {
    die("file not found!");
}

$path_parts = pathinfo($file);
$extension = $path_parts['extension'];

$allowedExtensions = ['png', 'jpg', 'jpeg', 'gif'];

if (!in_array($extension, $allowedExtensions)) {
    die("file not found!");
}


$title = $path_parts['filename'] . "." . $path_parts['extension'];

?>

<html>
<head>
    <title><?php echo $title ?></title>

    <meta property="og:title" content="Example Page">
    <meta property="og:image" content="<?php echo $file; ?>">
    <meta property="og:description" content="This is a publish image on vissale.com.">
    <meta property="og:url" content="<?php echo $title; ?>">
</head>
<body>
<img src="<?php echo $file ?>">
</body>
</html>

