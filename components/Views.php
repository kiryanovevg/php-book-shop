<?php
namespace Views;

function ViewDir() {
    return ROOT . '/views/';
}

function ArticlesDir() {
    return ViewDir() . "/articles/";
}

function StylesDir() {
    return "../../views/css";
}

function ImagesDir() {
//    return ROOT . '/../frontend/web/images/';
}

function AdminViewDir() {
    return ViewDir() . "/admin/";
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
    var ?string $style;

    function __construct(int $selectedItem, bool $isAdmin = false, bool $isAuthorized = false) {
        $navigationView = new NavigationView($selectedItem, $isAdmin, $isAuthorized);

        $this->title = $navigationView->getSelectedItem()->getName();
        $this->navigation = $navigationView->getView();
        $this->header = HeaderView($this->title);
        $this->footer = FooterView();
        $this->style = $this->getStyle();
    }

    abstract function getStyle(): ?string;
}

class MainView extends View {

    function __construct() {
        parent::__construct(0);
        $this->content = GetIncludeContents(ArticlesDir() . "/article_main.php");
    }

    function getStyle(): string {
        return StylesDir() . "/article_main.css";
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

    function getStyle(): string {
        return StylesDir() . "/article_books.css";
    }
}

class BookView extends View {

    function __construct($book) {
        parent::__construct(1);
        $this->content = GetIncludeContents(ArticlesDir() . "/article_book.php", [
            'book' => $book
        ]);
    }

    function getStyle(): string {
        return StylesDir() . "/article_book.css";
    }
}

class CompanyView extends View {

    function __construct() {
        parent::__construct(2);
        $this->content = GetIncludeContents(ArticlesDir() . "/article_company.php");
    }

    function getStyle(): string {
        return StylesDir() . "/article_company.css";
    }
}

class DeveloperView extends View {

    function __construct() {
        parent::__construct(3);
        $this->content = GetIncludeContents(ArticlesDir() . "/article_developer.php");
    }

    function getStyle(): string {
        return StylesDir() . "/article_developer.css";
    }
}

abstract class AdminView extends View {

    public function __construct(int $selectedItem, bool $isAuthorized) {
        parent::__construct($selectedItem, true, $isAuthorized);
    }
}

class AdminLoginView extends AdminView {

    public function __construct(?string $error) {
        parent::__construct(0, false);
        $this->content = GetIncludeContents(AdminViewDir() . "/login.php", [
            'error' => $error
        ]);
    }

    function getStyle(): ?string {
        return StylesDir() . "/login.css";
    }
}

class AdminRegistrationView extends AdminView {

    public function __construct() {
        parent::__construct(1, false);
        $this->content = GetIncludeContents(AdminViewDir() . "/sign_up.php");
    }

    function getStyle(): ?string {
        return null;
    }
}

class AdminPageView extends AdminView {

    public function __construct($selectedItem, $page, $content) {
        parent::__construct($selectedItem, true);
        $this->content = GetIncludeContents(AdminViewDir() . "/page.php", [
            'page' => $page,
            'content' => $content
        ]);
    }

    function getStyle(): ?string {
        return null;
    }
}

class NavigationView {

    private array $items;
    private NavigationItem $selectedItem;
    private string $view;

    public function __construct(int $selectedItem, bool $isAdmin, bool $isAuthorized) {
        $this->items = $this->getNavigationItems($isAdmin, $isAuthorized);
        $this->selectedItem = $this->items[$selectedItem];

        $this->view = GetIncludeContents(ViewDir() . "/layouts/navigation.php", [
            'items' => $this->items,
            'selectedItem' => $this->selectedItem
        ]);
    }

    private static function getNavigationItems(bool $isAdmin, bool $isAuthorized) {
        if ($isAdmin) return self::getAdminNavigationItems($isAuthorized);
        else return array(
            new NavigationItem("/", "Главная"),
            new NavigationItem("/books", "Книги"),
            new NavigationItem("/company", "О компании"),
            new NavigationItem("/developer", "Об авторе")
        );
    }

    private static function getAdminNavigationItems(bool $isAuthorized) {
        if ($isAuthorized) return array(
            new NavigationItem("/edit/main", "Главная"),
            new NavigationItem("/edit/company", "О компании"),
            new NavigationItem("/edit/developer", "Об авторе"),
            new NavigationItem("/admin/logOut", "Выйти"),
        );
        else return array(
            new NavigationItem("/admin/signIn", "Войти"),
            new NavigationItem("/admin/signUp", "Регистрация"),
        );
    }

    public static function getSelectedItemNumForAdmin(string $page): int {
        $items = self::getAdminNavigationItems(true);

        for ($i = 0; $i < count($items); $i++) {
            $item = $items[$i];

            if (strpos($item->getLink(), $page) !== false) {
                return $i;
            }
        }

        return 0;
    }

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