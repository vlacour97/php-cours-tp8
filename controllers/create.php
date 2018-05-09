<?php
/**
 * Created by PhpStorm.
 * User: valentinlacour
 * Date: 09/05/2018
 * Time: 21:26
 */

$title = 'Créer un article';

if ($_POST['submitCreate'] && isset($_POST['title'], $_POST['content'])) {

    $slug = generateSlug($_POST['title']);
    $tags = array_map('trim', explode(',', $_POST['tags']));

    $img = uploadImg($_FILES['img']);

    if (!$img) {
        $img = "http://placehold.it/700x400";
    }

    insertOrReplaceArticle($slug, $_POST['title'], $_POST['content'], $img, $tags);

    header('Location: /');
}

?>

<div class="container">
    <a class="btn btn-info mt-4" href="/">Retour</a>

    <h1 class="my-4">Créer un articles</h1>

    <form method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label for="title">Titre</label>
            <input class="form-control" id="title" type="text" name="title">
        </div>
        <div class="form-group">
            <label for="tags">Tags</label>
            <input class="form-control" id="tags" type="text" name="tags">
        </div>
        <div class="form-group">
            <label for="img">Image</label>
            <input class="form-control" id="img" type="file" name="img">
        </div>
        <div class="form-group">
            <label for="content">Contenu</label>
            <textarea class="form-control" id="content" name="content"></textarea>
        </div>
        <button class="btn btn-primary" name="submitCreate" value="true">Enregistrer</button>
    </form>
</div>