<?php
namespace Views;

function ViewDir() {
    return ROOT . '/views/';
}

function ImagesDir() {
//    return ROOT . '/../frontend/web/images/';
}

function AdminViewDir() {
//    return ROOT . '/../admin/views/';
}

function GetIncludeContents($filename, $settings = null) {
    if (is_file($filename)) {
        ob_start();
        include $filename;
        return ob_get_clean();
    }
    return false;
}

function NavigationView() {
    return GetIncludeContents(ViewDir() . "/layouts/navigation.php");
}

function HeaderView() {
    return GetIncludeContents(ViewDir() . "/layouts/header.php");
}

function FooterView() {
    return GetIncludeContents(ViewDir() . "/layouts/footer.php");
}

class View {

    var string $navigation;
    var string $header;
    var string $content;
    var string $footer;

    function __construct() {
        $this->navigation = NavigationView();
        $this->header = HeaderView();
        $this->footer = FooterView();
    }
}