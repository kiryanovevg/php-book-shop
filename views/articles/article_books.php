<?php

use function Views\ImagesDir;

?>
<article>

    <?= count($params['categories']) == 0 ? 'Кинг пока нет...' : '' ?>

    <div class="category">
        <?php foreach ($params['categories'] as $item): ?>
            <a
                    class="chip <?= $params['selectedCategoryId'] == $item->id ? 'chip-active"' : '' ?>"
                    href="<?= '/books/' . $item->id ?>"
            >
                <?= $item->name ?>
            </a>
        <?php endforeach ?>
    </div>

    <div class="items">
        <?php foreach ($params['books'] as $item): ?>

            <a class="item corners elevation" href="/book/<?= $item->id ?>">

                <?php if ($item->image): ?>
                    <img src="<?= ImagesDir() . $item->image ?>" alt="book image">
                <?php endif ?>

                <div class="item-content">
                    <div class="name"><?= $item->name ?></div>
                    <div class="description"><?= $item->author ?></div>
                    <div class="price"><?= $item->price ?></div>
                </div>
            </a>

        <?php endforeach ?>
    </div>
</article>