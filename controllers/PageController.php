<?php


use Views\AdminPageView;
use Views\NavigationView;
use function Views\ArticlesDir;
use function Views\GetIncludeContents;

class PageController extends ViewController {

    private function checkAuthorization() {
        session_start();
        if (!User::isAuthorized()) {
            header("Location: /admin");
            exit();
        }
    }

    function actionEdit($page) {
        $this->checkAuthorization();

        $result = Db::query("select * from page where name = '$page' limit 1");
        if (count($result) != 0) {
            $item = $result[0];

            if (!empty($_POST['content'])) {
                $content = $_POST['content'];
                Db::query("UPDATE page SET content = '$content' WHERE name = '$item->name';");
                header("Location: /edit/" . $item->name);
                return true;
            }

            $selectedItem = NavigationView::getSelectedItemNumForAdmin($item->name);
            $this->showView(new AdminPageView($selectedItem, $item->name, $item->content));
        } else header("Location: /admin");

        return true;
    }

    function actionRestore($page) {
        $this->checkAuthorization();

        $content = GetIncludeContents(ArticlesDir() . "/article_$page.php");
        if ($content) {
            Db::query("UPDATE page SET content = '$content' WHERE name = '$page'");
            header("Location: /edit/" . $page);
        } else {
            header("Location: /admin");
        }

        return true;
    }
}