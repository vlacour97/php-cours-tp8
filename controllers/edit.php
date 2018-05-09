<?php
/**
 * Created by PhpStorm.
 * User: valentinlacour
 * Date: 09/05/2018
 * Time: 22:08
 */

$article = getAllArticles()[$_GET['article']];

$title = 'Modification de l\'article : ' . $article['title'];

if (is_null($article)) {
    http_response_code(404);
    include 'controllers/404.php';
    return;
}

if ($_POST['submitCreate'] && isset($_POST['title'], $_POST['content'])) {

    $slug = $_GET['article'];
    $tags = array_map('trim', explode(',', $_POST['tags']));

    if ($_FILES['img']['name']) {
        $img = uploadImg($_FILES['img']);
    } else {
        $img = $article['img'];
    }

    insertOrReplaceArticle($slug, $_POST['title'], $_POST['content'], $img, $tags);

    header('Location: /');
}

?>

<div class="container">
    <a class="btn btn-info mt-4" href="/">Retour</a>

    <h1 class="my-4">Créer un article</h1>

    <form method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label for="title">Titre</label>
            <input class="form-control" id="title" type="text" name="title" value="<?= $article['title'] ?>">
        </div>
        <div class="form-group">
            <label for="tags">Tags</label>
            <input class="form-control" id="tags" type="text" name="tags" value="<?= implode(',', $article['tags']) ?>">
        </div>
        <div class="form-group">
            <label for="img">Image</label>
            <input class="form-control" id="img" type="file" name="img">
        </div>
        <div class="form-group">
            <label for="content">Contenu</label>
            <textarea class="form-control" id="content" name="content"><?= $article['content'] ?></textarea>
        </div>
        <button class="btn btn-primary" name="submitCreate" value="true">Enregistrer</button>
    </form>
</div>