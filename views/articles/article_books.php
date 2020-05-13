<article>
    <div class="category">
<!--        <a class="chip chip-active" href="books_detective.html">Детектив</a>-->

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
        <div class="item corners elevation">
            <img src="<?= $item->image ?>" alt="book image">
            <div class="item-content">
                <div class="name"><?= $item->name ?></div>
                <div class="description"><?= $item->author ?></div>
                <div class="price"><?= $item->price ?></div>
            </div>
        </div>
        <?php endforeach ?>
    </div>
</article>