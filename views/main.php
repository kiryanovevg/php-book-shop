<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
    <link rel="stylesheet" href="../templates/css/main.css">
    <link rel="stylesheet" href="../templates/css/nav.css">
    <link rel="stylesheet" href="../templates/css/header.css">
    <link rel="stylesheet" href="../templates/css/footer.css">

    <link rel="stylesheet" href="../templates/css/article_main.css">
</head>
<body>

<?php include ROOT . '/views/navigation.php'?>

<div class="main-container">

    <?php include ROOT . '/views/header.php'?>

    <?php include ROOT . '/views/articles/' . $content ?>

    <?php include ROOT . '/views/footer.php'?>

</div>

</body>
</html>