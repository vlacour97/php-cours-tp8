<?php
/**
 * Created by PhpStorm.
 * User: valentinlacour
 * Date: 09/05/2018
 * Time: 21:11
 */

$articles = getAllArticles();
?>

<div class="container">

    <!-- Page Heading -->
    <h1 class="my-4">Articles</h1>

    <div class="col-xs-12 m-3">
        <a class="btn btn-primary" href="?nav=create">Créer un article</a>
    </div>

    <div class="row">
    <?php foreach ($articles as $key=>$article) { ?>
        <div class="col-lg-4 col-sm-6 portfolio-item">
            <div class="card h-100">
                <a href="?nav=view&article=<?= $key ?>"><img class="card-img-top" src="<?= $article['img'] ?>" alt=""></a>
                <div class="card-body">
                    <h4 class="card-title">
                        <a href="#"><?= $article['title'] ?></a>
                    </h4>
                    <p class="card-text"><?= cutString($article['content'], 50, '...') ?></p>
                    <div>
                        <?php foreach ($article['tags'] as $tag)  {?>
                            <span class="badge badge-secondary"><?= $tag ?></span>
                        <?php } ?>
                    </div>
                    <a class="btn btn-info" href="?nav=edit&article=<?= $key ?>">Modifier</a>
                    <a class="btn btn-warning" href="?nav=delete&article=<?= $key ?>">Supprimer</a>
                </div>
            </div>
        </div>
    <?php } ?>
    </div>

</div>
