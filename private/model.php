<?php
session_start();

function make_connection()
{
    $mysqli = new mysqli('localhost', 'root', 'root', 'myband23698_db');
    if ($mysqli->connect_errno) {
        die('Connection error: ' . $mysqli->connect_errno . '<br>');
    }
    return $mysqli;
}


function get_articles() {
    $mysqli = make_connection();
    $query = "SELECT title FROM articles";
    $stmt = $mysqli->prepare($query) or die ('Error preparing 1.');
    $stmt->bind_result($title) or die ('Error binding results 1.');
    $stmt->execute() or die ('Error executing 1.');
    $results = array();
    while ($stmt->fetch()) {
        $results[] = $title;
    }
    return $results;
}


function get_some_articles() {
    global $pageno, $searchterm;
    $mysqli = make_connection();
    $number_of_pages = calculate_pages() or die ('Error calculating.');
    $firstrow = ($pageno - 1) * ARTICLES_PER_PAGE;
    $per_page = ARTICLES_PER_PAGE;
    $query =    "SELECT title, content, imagelink ";
    $query .=   "FROM articles ";
    $query .=   "WHERE title LIKE ? OR ";
    $query .=   "content LIKE ? ";
    $query .=   "ORDER BY article_id ";
    $query .=   "DESC LIMIT $firstrow,$per_page ";
    $stmt = $mysqli->prepare($query) or die ('Error preparing 1.');
    $stmt->bind_param('ss', $searchterm, $searchterm) or die ('Error binding searchterm');
    $stmt->bind_result($title, $content, $imagelink) or die ('Error binding results 1.');
    $stmt->execute() or die ('Error executing 1.');
    $results = array();
    while ($stmt->fetch()) {
        $article = array();
        $article[] = $title;
        $article[] = $content;
        $article[] = $imagelink;
        $results[] = $article;
    }

    return $results;
}


function get_number_of_pages() {
    $number_of_pages = calculate_pages() or die ('Error calculating.');
    return $number_of_pages;
}


function calculate_pages() {
    $mysqli = make_connection();
    $query = "SELECT * FROM articles";
    $result = $mysqli->query($query) or die ('Error querying 2.');
    $rows = $result->num_rows;
    $number_of_pages = ceil($rows / ARTICLES_PER_PAGE);
    return $number_of_pages;
}


function check_login() {
    $mysqli = make_connection();
    $query = "SELECT userid, hash, active FROM users WHERE username = ? AND password = ?";
    $stmt = $mysqli->prepare($query) or die ('Error preparing.');
    $stmt->bind_param('ss', $username, $password) or die ('Error binding param');
    $stmt->bind_result($userid,$hash,$active) or die ('Error binding results');
    $username = $_POST['username'];
    $password = $_POST['password'];
    $password = hash('sha512',$password) or die ('Error hashing.');
    $stmt->execute() or die('Error executing');
    $fetch_success = $stmt->fetch();

    if (!$fetch_success) {
      header('location ?page=admin');
    }

    setcookie( 'userid',$userid, time() + (3600 * 24 * 7));
    $_SESSION['userid'] = $userid;
    setcookie('hash',$hash, time() + (3600 * 24 * 7));
    $_SESSION['hash'] = $hash;
    header('location: ?page=cms');
}

function check_cookie() {
    $mysqli = make_connection();
    $query = "SELECT userid FROM users WHERE username = ? AND hash = ?";
    $stmt = $mysqli->prepare($query) or die ('Error preparing.');
    $stmt->bind_param('is', $userid, $hash) or die ('Error binding param');
    $userid = $_COOKIE['userid'];
    $hash = $_COOKIE['hash'];
    $stmt->execute() or die ('Error executing');
    $fetch_success = $stmt->fetch();

    if (!$fetch_success) {
        header('Location: ?page=admin');
    }
    return $cookiechecker;
}

function check_logout() {
    $_SESSION = array();
    session_destroy();
}

function get_all_articles() {
    $mysqli = make_connection();
    $query = "SELECT * FROM articles";
    $result = mysqli_query($mysqli,$query) or die ('Error querying.');
    $articles = array();
    while ($row = mysqli_fetch_array($result)) {
        $article_id = $row['article_id'];
        $title = $row['title'];
        $content = $row['content'];
        $article = [$article_id, $title, $content];
        $articles[] = $article;
    }
    return $articles;
}



function delete_article(){
    $mysqli = make_connection();
    $id = $_POST['delete_function_id'];
    $query = "DELETE FROM articles WHERE article_id = '$id'";
    $result = mysqli_query($mysqli,$query) or die ('Error Deleting.');
    header('location ?page=cms');
}


function add_article() {
    $mysqli = make_connection();
    $id = 0;
    $title = $_POST['title'];
    $content = $_POST['content'];

    $temp_location = $_FILES['imagelink']['tmp_name'];
    $imagelink = 'images/upload/' . time() . $_FILES['imagelink']['name'];

    if ($_FILES['imagelink']['size'] < 2000000) {
        move_uploaded_file($temp_location, $imagelink);
    } else {
        echo "Image size is te groot";
    }

    $query = "INSERT INTO articles VALUES (?,?,?,?)";
    $stmt = $mysqli->prepare($query) or die ("Error preparing query");
    $stmt->bind_param('isss', $id, $title, $content, $imagelink) or die ("Error binding param");
    $stmt->execute() or die ("Error executing");
}

function get_edit_info($article_id) {
    $mysqli = make_connection();
    $query = "SELECT * FROM articles WHERE article_id = $article_id";
    $stmt = $mysqli->prepare($query) or die ('Error getting articles');
    $stmt->bind_result($article_id, $title, $content, $imagelink);
    $stmt->execute() or die('Error executing');
    $results = array();
    while ($stmt->fetch()) {
        $article = array();
        $article[] = $article_id;
        $article[] = $title;
        $article[] = $content;
        $article[] = $imagelink;
        $results = $article;
    }
    return $results;
}

function process_edit() {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $article_id = $_POST['article_id'];

    if (empty($_POST['title']) OR empty($_POST['content'])) {
        return exit('Fields are empty you fgt');
    }

    $mysqli = make_connection();
    $query = "UPDATE articles SET title = ?, content = ? WHERE article_id = $article_id";
    $stmt = $mysqli->prepare($query) or die ('Error preparing query');
    $stmt->bind_param('ss', $title, $content) or die ('Error binding params');
    $stmt->execute() or die ('Error executing');
}




