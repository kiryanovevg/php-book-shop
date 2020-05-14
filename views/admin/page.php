<article>
    <form method="POST">
        <table>
            <tr>
                <th>
                    <label>Название: </label><input type="text" name="name" value="<?= $params['name'] ?>"><br>
                </th>
            </tr>
            <tr>
                <td>
                    <label>Тело: </label><br><textarea rows="20" cols="90" name="content"><?= $params['content'] ?></textarea><br>
                </td>
            </tr>
        </table>
        <input type="submit" value="Сохранить">
    </form>
</article>