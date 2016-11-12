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
    die("file unreadable!");
}

$path_parts = pathinfo($file);
$extension = $path_parts['extension'];

$allowedExtensions = ['png', 'jpg', 'jpeg', 'gif'];

if (!in_array($extension, $allowedExtensions)) {
    die("file type not allowed!");
}


$title = $path_parts['filename'] . "." . $path_parts['extension'];

$file = "https://" . $_SERVER['SERVER_NAME'] . "/{$file}";

?>

<html>
<head>
    <title><?php echo $title ?></title>

    <meta property="og:title" content="file : <?php echo $title ?>">
    <meta property="og:image" content="<?php echo $file; ?>">
    <meta property="og:description" content="This is a public image on vissale.com.">
    <meta property="og:url" content="<?php echo $file; ?>">
</head>
<body>
<img src="<?php echo $file ?>">
</body>
</html>

