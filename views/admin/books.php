<article>
    <table>
        <!--    --><?php //if ($settings['products'] != null && count($settings['products']) != 0): ?>
        <tr>
            <th>Категория</th>
            <th>Название</th>
            <th>Author</th>
            <th>Цена</th>
            <th><a href='/edit/books/add'>Добавить</a><br></th>
        </tr>
        <?php foreach ($params['books'] as $item): ?>
            <tr>
                <td><?= $item->category_name ?></td>
                <td><?= $item->name ?></td>
                <td><?= $item->author ?></td>
                <td><?= $item->price ?></td>
                <td>
                    <a href='?controller=product&action=update&id=<?/*= $product['id'] */?>'>Изменить</a><br>
                    <a href='?controller=product&action=delete&id=<?/*= $product['id'] */?>'>Удалить</a>
                </td>
            </tr>
        <?php endforeach ?>
        <!--    --><?php //endif ?>
    </table>
</article>