<?php

/**
 * @throws Exception
 * @throws SmartyException
 */
function homepage_action() {
    // MODEL
    global $smarty;
    $articles = get_articles();
    $smarty->assign('articles',$articles);
    // VIEWS
    $smarty->display('header.tpl');
    $smarty->display('home.tpl');
    $smarty->display('footer.tpl');
}

function page_not_found_action() {
    global $smarty;
    $smarty->display('notfound.tpl');
}

function contact_action() {
    global $smarty;
    // MODEL

    // VIEWS
    $smarty->display('header.tpl');
    $smarty->display('contact.tpl');
    $smarty->display('footer.tpl');
}

function news_action() {

    global $smarty;
    global $pageno;
    global $searchterm;
    // MODEL
    $articles = get_some_articles();
    $number_of_pages = get_number_of_pages();
    $smarty->assign('current_page',$pageno);
    $smarty->assign('number_of_pages',$number_of_pages);
    $smarty->assign('articles',$articles);
    // VIEWS
    $smarty->display('header.tpl');
    $smarty->display('news.tpl');
    $smarty->display('footer.tpl');
}

function admin_action() {
    global $smarty;
    $smarty->display('header.tpl');
    $smarty->display('loginform.tpl');
    $smarty->display('footer.tpl');
}

function login_action() {
    check_login();
}

function logout_action() {
    check_logout();
}

function cookie_action() {
    check_cookie();
}

function cms_action() {
    global $smarty;
    $articles = get_all_articles();
    $smarty->assign('articles',$articles);
    $smarty->display('header.tpl');
    $smarty->display('cms.tpl');
    $smarty->display('footer.tpl');
}

function delete_action() {
    delete_article();
}

function edit_action() {
    $article_id = $_GET['article_id'];
    $articles = get_edit_info($article_id);
    global $smarty;
    $smarty->assign('articles',$articles);
    $smarty->assign('article_id',$article_id);
    $smarty->display('header.tpl');
    $smarty->display('edit.tpl');
    $smarty->display('footer.tpl');
}

function submit_edit_action() {
    process_edit();
}

function addarticle_action() {
    add_article();
}


function add_action() {
    global $smarty;
    $smarty->display('header.tpl');
    $smarty->display('add.tpl');
    $smarty->display('footer.tpl');
}

function about_action() {
    global $smarty;
    $smarty->display('header.tpl');
    $smarty->display('about.tpl');
    $smarty->display('footer.tpl');
}

