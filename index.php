<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="http://localhost:3000/webroot/css/bootstrap.css" />
    <script src="http://localhost:3000/webroot/js/bootstrap.js"></script>
    <script src="http://localhost:3000/webroot/js/jquery-3.6.0.js"></script>
    <title>Pie PHP</title>
</head>
<body>
    
    <?php
    define ('BASE_URI ', str_replace ('\\ ', '/', substr ( __DIR__ , strlen($_SERVER['DOCUMENT_ROOT']))));
    require_once (implode(DIRECTORY_SEPARATOR , ['Core', 'autoload.php']));
    autoload("Core/Core");
    require_once 'src/routes.php';
    $app = new Core\Core();
    $app->run ();
    ?>
</body>
</html>