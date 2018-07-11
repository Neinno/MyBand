<?php



require ('../private/smarty/Smarty.class.php');
require ('../private/model.php');
require ('../private/controller.php');

$smarty = new Smarty();
$smarty->setCompileDir('../private/tmp');
$smarty->setTemplateDir('../private/views');

define('ARTICLES_PER_PAGE',5);

// TERNARY OPERATOR
$page = isset($_GET['page']) ? $_GET['page'] : 'home';
$pageno = isset($_GET['pageno']) ? $_GET['pageno'] : '1';
$searchterm = isset($_GET['searchterm']) ? '%' . $_GET['searchterm'] . '%' : '%';


if (isset($_POST['submit_edit'])) {
    submit_edit_action();
    cms_action();
    exit();
}

if (isset($_POST['submit_login'])) {
    login_action();
}

if (isset($_POST['add_submit'])) {
    addarticle_action();
    exit();
}


if (isset($_SESSION['loggedin'])) {
    check_cookie();
    cms_action();
    exit();
}

if (isset($_POST['logout'])) {
    logout_action();
    news_action();
    exit();
}

if (isset($_POST['add'])) {
    add_action();
    exit();
}

if (isset($_POST['delete_submit'])) {
    delete_action();
    cms_action();
    exit();
}


switch ($page) {
    case 'about': about_action(); break;
    case 'add': add_action(); break;
    case 'edit': edit_action(); break;
    case 'admin': admin_action(); break;
    case 'cms': cms_action(); break;
    case 'home': homepage_action($smarty); break;
    case 'news': news_action(); break;
    case 'contact': contact_action(); break;
    default: page_not_found_action($smarty); break;
}

