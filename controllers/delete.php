<?php
/**
 * Created by PhpStorm.
 * User: valentinlacour
 * Date: 09/05/2018
 * Time: 22:20
 */


$article = getAllArticles()[$_GET['article']];

if (is_null($article)) {
    http_response_code(404);
    include 'controllers/404.php';
    die;
}

deleteArticle($_GET['article']);

header('Location: /');