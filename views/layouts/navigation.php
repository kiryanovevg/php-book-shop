<nav>
    <div class="nav_title">Магистр</div>
    <div class="links">
        <?php foreach ($params['items'] as $item): ?>
        <a <?=$params['selectedItem'] === $item ? 'class="active"' : ''?> href="<?=$item->getLink() ?>">
            <?= $item->getName() ?>
        </a>
        <?php endforeach ?>
    </div>
</nav>