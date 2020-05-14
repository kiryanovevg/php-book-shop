<article>
    <form method="POST" action="/admin/signIn">
        <table>
            <tr>
                <td>
                    <label>Логин: </label><input type="text" name="login"><br>
                </td>
            </tr>
            <tr>
                <td>
                    <label>Пароль: </label><input type="password" name="password"><br>
                </td>
            </tr>
        </table>
        <div class="buttons">
            <input type="submit" value="Войти">
        </div>

        <?php if ($params['error']): ?>
            <?= $params['error'] ?>
        <?php endif ?>
    </form>
</article>