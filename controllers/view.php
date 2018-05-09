<?php
/**
 * Created by PhpStorm.
 * User: valentinlacour
 * Date: 09/05/2018
 * Time: 23:09
 */

$article = getAllArticles()[$_GET['article']];

$title = $article['title'];

if (is_null($article)) {
    http_response_code(404);
    include 'controllers/404.php';
    return;
}

?>

<div class="container">
    <h1 class="mr-4 text-center"><?= $article['title'] ?></h1>
    <img  class="col-md-6 offset-md-3" src="<?= $article['img'] ?>">
    <div class="mt-4 mb-4">
        <?php foreach ($article['tags'] as $tag)  {?>
            <span class="badge badge-secondary"><?= $tag ?></span>
        <?php } ?>
    </div>
    <p><?= $article['content']?></p>
    <a class="btn btn-primary mb-4" href="/">Retour</a>
</div>
