<?php


use Views\AdminPageView;
use function Views\ArticlesDir;
use function Views\GetIncludeContents;

class PageController extends ViewController {

    private function getPageContent(string $page): string {
        $result = Db::query("select * from page where name = '$page' limit 1");
        if (count($result) != 0) {
            return $result[0]->content;
        } else die("Page doesn't exist");
    }

    function actionEditMain() {
        session_start();
        if (!User::isAuthorized()) {
            header("Location: /admin");
            return true;
        }

        $page = "main";
        $content = $this->getPageContent($page);
        $this->showView(new AdminPageView(0, $page, $content));
        return true;
    }

    function actionEditCompany() {
        session_start();
        if (!User::isAuthorized()) {
            header("Location: /admin");
            return true;
        }

        $page = "company";
        $content = $this->getPageContent($page);
        $this->showView(new AdminPageView(1, $page, $content));
        return true;
    }

    function actionEditDeveloper() {
        session_start();
        if (!User::isAuthorized()) {
            header("Location: /admin");
            return true;
        }

        $page = "developer";
        $content = $this->getPageContent($page);
        $this->showView(new AdminPageView(2, $page, $content));
        return true;
    }

    function actionRestore($page) {
        session_start();
        if (!User::isAuthorized()) {
            header("Location: /admin");
            return true;
        }

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