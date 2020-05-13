<article>
    <div class="category">
<!--        <a class="chip chip-active" href="books_detective.html">Детектив</a>-->

        <?php foreach ($params['categories'] as $item): ?>
            <a
                    class="chip <?= $params['$selectedCategoryId'] == $item->id ? 'chip-active"' : '' ?>"
                    href="<?= '/books/' . $item->id ?>"
            >
                <?= $item->name ?>
            </a>
        <?php endforeach ?>
    </div>

    <div class="items">
        <div class="item corners elevation">
            <img src="../../images/detective/book_1.jpg" alt="book image">
            <div class="item-content">
                <div class="name">Всегда вчерашнее завтра</div>
                <div class="description">Абдуллаев Ч.</div>
                <div class="price">152₽</div>
            </div>
        </div>

    </div>
</article>