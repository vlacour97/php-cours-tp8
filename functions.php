<?php
/**
 * Created by PhpStorm.
 * User: valentinlacour
 * Date: 09/05/2018
 * Time: 21:15
 */

define('ARTICLE_DATA_PATH', 'data/articles.json');
define('UPLOAD_DIR', 'data/img');

/**
 * Generate file article.json if not exist
 */
function createArticleFile()
{
    if (!file_exists(ARTICLE_DATA_PATH)) {
        file_put_contents(ARTICLE_DATA_PATH, '{}');
    }
}

/**
 * Return all articles in array
 *
 * @return array
 */
function getAllArticles()
{
    return json_decode(file_get_contents(ARTICLE_DATA_PATH), JSON_OBJECT_AS_ARRAY);
}

/**
 * Push all articles into JSON file
 *
 * @param array $articles
 * @return int
 */
function pushArticles(array $articles)
{
    return file_put_contents(ARTICLE_DATA_PATH, json_encode($articles, JSON_PRETTY_PRINT));
}

/**
 * Delete article in JSON file
 *
 * @param string $slug
 */
function deleteArticle($slug)
{
    $articles = getAllArticles();

    unset($articles[$slug]);

    pushArticles($articles);
}

/**
 * Insert or replace article in JSON file
 *
 * @param string $slug
 * @param string $title
 * @param string $content
 * @param string $imgPath
 * @param string $tags
 */
function insertOrReplaceArticle($slug, $title, $content, $imgPath, $tags)
{
    $datas = getAllArticles();

    if (isset($datas[$slug])) {
        $creation_date = $datas[$slug]['creation_date'];
    } else {
        $creation_date = date('d-m-Y');
    }

    $datas[$slug] = array(
        'title' => $title,
        'content' => $content,
        'img' => $imgPath,
        'tags' => $tags,
        'creation_date' => $creation_date,
        'modification_date' => date('d-m-Y')
    );

    pushArticles($datas);

}

/**
 * Generate slug with title
 *
 * @param string $string
 * @return string
 */
function generateSlug($string)
{
    $slug = str_replace([' ', 'é', 'à', 'è', '\'', '"', '&', '='], ['_', 'e', 'a', 'e', '', '', '', ''], $string);

    $ite = 2;
    while (isset(getAllArticles()[$slug])) {
        $slug .= $ite++;
    }

    return $slug;
}

/**
 * Determined if MIME Type is img
 *
 * @param string $mimeType
 * @return bool
 */
function is_img($mimeType)
{
    return (bool)preg_match('/^image\/\w*$/', $mimeType);
}

/**
 * Make an upload directory
 *
 * @param string $path
 */
function mkUploadDir($path)
{
    $dirName = getDirName($path);

    if (!is_dir($dirName)) {
        mkdir($dirName);
    }
}

/**
 * Generate a directory name
 *
 * @param string $path
 * @return string
 */
function getDirName($path)
{
    return $path.'/'.date('Y-m-d');
}

/**
 * Upload an img
 *
 * @param array $file
 * @return bool|string
 */
function uploadImg($file)
{
    mkUploadDir(UPLOAD_DIR);

    $currentName = $file['name'];
    $currentType = $file['type'];
    $currentTmpName = $file['tmp_name'];
    $currentError = $file['error'];

    if ($currentError) {
        return false;
    }

    if (is_img($currentType)) {
        if (!move_uploaded_file($currentTmpName, getDirName(UPLOAD_DIR).'/'.$currentName)) {
            return false;
        }
    } else {
        return false;
    }

    return getDirName(UPLOAD_DIR).'/'.$currentName;
}

/**
 * Cut string and add a delimiter if string is so long
 *
 * @param string $string
 * @param int $length
 * @param string $delimiter
 * @return string
 */
function cutString($string, $length, $delimiter = "")
{
    if (strlen($string) > $length) {
        $string = substr($string, 0, $length) . $delimiter;
    }

    return $string;
}