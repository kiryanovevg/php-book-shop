<article>
    <form method="POST">
        <table>
            <tr>
                <td>
                    <label>Тело:
                        <a href="/restore/<?= $params['page'] ?>">Восстановить</a>
                        <br><br>
                        <textarea rows="20" cols="90" name="content"><?= $params['content'] ?></textarea>
                    </label>
                </td>
            </tr>
        </table>
        <input type="submit" value="Сохранить">
    </form>
</article>