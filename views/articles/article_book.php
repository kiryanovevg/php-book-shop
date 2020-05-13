<article>

    <div class="item corners elevation">
        <?php if ($params['book']->image): ?>
            <img src="<?= $params['book']->image ?>" alt="book image">
        <?php endif ?>
        <div class="item-content">
            <div class="name"><?= $params['book']->name ?></div>
            <div class="description"><?= $params['book']->author ?></div>
            <div class="price"><?= $params['book']->price ?></div>
            <br>
            <?php if ($params['book']->description): ?>
            <div><?= $params['book']->description ?></div>
            <?php endif ?>
        </div>
    </div>

</article>