<?php
namespace Views;

function ViewDir() {
    return ROOT . '/views/';
}

function ArticlesDir() {
    return ViewDir() . "/articles/";
}

function ImagesDir() {
//    return ROOT . '/../frontend/web/images/';
}

function AdminViewDir() {
//    return ROOT . '/../admin/views/';
}

function GetIncludeContents($filename, $params = null) {
    if (is_file($filename)) {
        ob_start();
        include $filename;
        return ob_get_clean();
    }
    return false;
}

function HeaderView($title) {
    return GetIncludeContents(ViewDir() . "/layouts/header.php", ['title' => $title]);
}

function FooterView() {
    return GetIncludeContents(ViewDir() . "/layouts/footer.php");
}

abstract class View {

    var string $navigation;
    var string $header;
    var string $content;
    var string $footer;

    var string $title;

    function __construct(int $selectedItem) {
        $navigationView = new NavigationView($selectedItem);

        $this->title = $navigationView->getSelectedItem()->getName();
        $this->navigation = $navigationView->getView();
        $this->header = HeaderView($this->title);
        $this->footer = FooterView();
    }
}

class MainView extends View {

    function __construct() {
        parent::__construct(0);
        $this->content = GetIncludeContents(ArticlesDir() . "/article_main.php");
    }
}

class BookListView extends View {

    function __construct(array $categories, int $selectedCategoryId, array $books) {
        parent::__construct(1);
        $this->content = GetIncludeContents(ArticlesDir() . "/article_books.php", [
            'categories' => $categories,
            'selectedCategoryId' => $selectedCategoryId,
            'books' => $books
        ]);
    }
}

class CompanyView extends View {

    function __construct() {
        parent::__construct(2);
        $this->content = GetIncludeContents(ArticlesDir() . "/article_company.php");
    }
}

class DeveloperView extends View {

    function __construct() {
        parent::__construct(3);
        $this->content = GetIncludeContents(ArticlesDir() . "/article_developer.php");
    }
}

class NavigationView {

    private array $items;
    private NavigationItem $selectedItem;
    private string $view;

    public function __construct(int $selectedItem) {
        $this->items = $this->getNavigationItems();
        $this->selectedItem = $this->items[$selectedItem];

        $this->view = GetIncludeContents(ViewDir() . "/layouts/navigation.php", [
            'items' => $this->items,
            'selectedItem' => $this->selectedItem
        ]);
    }

    private function getNavigationItems() {
        return array(
            new NavigationItem("/", "Главная"),
            new NavigationItem("/books", "Книги"),
            new NavigationItem("/company", "О компании"),
            new NavigationItem("/developer", "Об авторе")
        );
    }

    /*private function findSelectedItem() {
        $uri = Router::getURI();

        foreach ($this->items as $item) {
            if ($item->getLink() == '/'.$uri) {
                return $item;
            }
        }

        return $this->items[0];
    }*/

    function getView() {
        return $this->view;
    }

    function getSelectedItem(): NavigationItem {
        return $this->selectedItem;
    }
}

class NavigationItem {

    private string $link;
    private string $name;

    function __construct($link, $name) {
        $this->link = $link;
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getLink(): string
    {
        return $this->link;
    }
}