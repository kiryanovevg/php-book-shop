<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?=$view->title?></title>
    <link rel="stylesheet" href="../../views/css/main.css">
    <link rel="stylesheet" href="../../views/css/nav.css">
    <link rel="stylesheet" href="../../views/css/header.css">
    <link rel="stylesheet" href="../../views/css/footer.css">

    <?php if ($view->style): ?>
        <link rel="stylesheet" href="<?= $view->style ?>">
    <?php endif ?>
</head>
<body>

<?=$view->navigation?>

<div class="main-container">

    <?=$view->header?>
    <?=$view->content?>
    <?=$view->footer?>

</div>

</body>
</html>