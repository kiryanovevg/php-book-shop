<?php


use Views\AdminLoginView;
use Views\AdminRegistrationView;

class AdminController extends ViewController {

    private function checkAuthorization() {
        session_start();
        if (User::isAuthorized()) {
            header("Location: /admin");
            exit();
        }
    }

    function actionSignIn() {
        $this->checkAuthorization();

        $error = null;

        if (!empty($_POST['login']) && !empty($_POST['password'])) {
            $login = $_POST['login'];
            $password = $_POST['password'];

            $result = Db::query("select * from user_table where login = '$login' limit 1");
            if (count($result) != 0) {
                $user = $result[0];

                if (!password_verify($password, $user->password)) $error = "Wrong password";
                else if ($user->confirmed == 0) $error = "User doesn't confirmed";

                if ($error == null) {
                    $_SESSION['userId'] = $user->id;
                    header("Location: /admin");
                }
            } else $error = "User not found";
        }

        $this->showView(new AdminLoginView($error));
        return true;
    }

    function actionSignUp() {
        $this->checkAuthorization();

        if (!empty($_POST['login']) && !empty($_POST['password'])) {
            $login = $_POST['login'];
            $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

            Db::query("INSERT INTO user_table(login, password) VALUES ($login, '$password')");
            header("Location: /admin/signIn");
        }

        $this->showView(new AdminRegistrationView());
        return true;
    }

    function actionLogOut() {
        session_start();
        session_destroy();
        header("Location: /admin");
        return true;
    }

    function actionMain() {
        session_start();
        if (!User::isAuthorized()) header("Location: /admin/signIn");
        else header("Location: /edit/main");

        return true;
    }
}