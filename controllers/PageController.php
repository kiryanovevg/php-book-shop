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

        /*if (!empty($_POST['content'])) {
            $page->name = htmlspecialchars($_POST['name']);
            $page->content = $_POST['content'];
            $query = "UPDATE _page SET name = \"{$page->name}\", content = \"{$page->content}\" WHERE id = {$page->id}";
            $result = Utility\DBQuery($db, $query);
            if ($result) {
                header("Location: http://".$_SERVER['HTTP_HOST']."/");
                exit();
            }
        }*/

        $result = Db::query("select * from page where name = '$page' limit 1");
        if (count($result) != 0) {
            $item = $result[0];

            if (!empty($_POST['content'])) {
                $content = $_POST['content'];
                Db::query("UPDATE page SET content = '$content' WHERE name = '$item->name';");
                header("Location: /admin/edit" . ucfirst($item->name));
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
            header("Location: /admin/edit" . ucfirst($page));
        } else {
            header("Location: /admin");
        }

        return true;
    }
}