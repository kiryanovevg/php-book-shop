<article>
    <form method="POST" enctype="multipart/form-data">
        <?php if($params['error']):?>
            <div class="error"><?= $params['error'] ?></div>
        <?php endif?>
        <table>
            <tr>
                <td><label>Название: <input type="text" name="name" value="<?= $params['book']->name ?>"></label></td>
                <td><label>Категория: <input type="text" name="category" value="<?= $params['book']->category ?>"></label></td>
                <td><label>Автор: <input type="text" name="author" value="<?= $params['book']->author ?>"></label></td>
            </tr>
            <tr>
                <td><label>Цена: <input type="number" name="price" value="<?= $params['book']->price ?>"></label></td>
                <td><label>Картинка: <input name="image" type="file"></label></td>
                <td></td>
            </tr>
            <tr>
                <td>
                    <label>Описание:<br>
                        <textarea rows="15" cols="50" name="description"><?= $params['book']->description ?></textarea>
                    </label>
                </td>
            </tr>
        </table>
        <input type="submit" value="Сохранить">
    </form>
</article>