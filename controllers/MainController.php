<?php

use Views\NavigationView;
use Views\PageView;

class MainController extends ViewController {

    function actionMain($page) {
        $result = Db::query("select * from page where name = '$page' limit 1");
        if (count($result) != 0) {
            $item = $result[0];
            $selectedItem = NavigationView::getSelectedItemNum($item->name);
            $this->showView(new PageView($selectedItem, $item->name, $item->content));
        } else header("Location: /");
        return true;
    }
}