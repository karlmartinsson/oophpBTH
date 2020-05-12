<?php

namespace Karl\Content;

use Anax\Commons\AppInjectableInterface;
use Anax\Commons\AppInjectableTrait;

// use Anax\Route\Exception\ForbiddenException;
use Anax\Route\Exception\NotFoundException;

// use Anax\Route\Exception\InternalErrorException;

/**
 * A sample controller to show how a controller class can be implemented.
 * The controller will be injected with $di if implementing the interface
 * ContainerInjectableInterface, like this sample class does.
 * The controller is mounted on a particular route and can then handle all
 * requests for that mount point.
 *
 * @SuppressWarnings(PHPMD.TooManyPublicMethods)
 */
class ContentController implements AppInjectableInterface
{
    use AppInjectableTrait;


    private $title = "Blogg";
    private $db;
    /**
     * This is the index method action, it handles:
     * ANY METHOD mountpoint
     * ANY METHOD mountpoint/
     * ANY METHOD mountpoint/index
     *
     * @return string
     */

    public function indexAction() : object
    {   
        $title = "Visa allt innehåll";
        $db = $this->app->db;
        $content = new Content($db, "content");

        $res = $content->showAll();

        $this->app->page->add("content/header");
        $this->app->page->add("content/index", [
            "res" => $res,
        ]);

        return $this->app->page->render([
            "title" => $title ,
        ]);
    }

    public function adminActionGet() : object
    {   
        $title = "Admin";
        $db = $this->app->db;
        $content = new Content($db, "content");

        $res = $content->showAll();

        $this->app->page->add("content/header");
        $this->app->page->add("content/admin", [
            "res" => $res,
        ]);

        return $this->app->page->render([
            "title" => $title,
        ]);
    }

    public function pageActionGet($path) : object
    {   
        $db = $this->app->db;
        $content = new Content($db, "content");

        $res = $content->showPost($path, "path");
        
        if (!$res) {
            throw new NotFoundException();
        }
 
        $this->app->page->add("content/header");
        $this->app->page->add("content/blogpost", [
            "res" => $res,
        ]);

        return $this->app->page->render([
            "title" => $this->title,
        ]);
    }

    public function editActionGet($id) : object
    {   
        $db = $this->app->db;
        $content = new Content($db, "content");

        $res = $content->showPost($id, "id");

        if (!$res) {
            throw new NotFoundException();
        }

        $flashmessage = $this->app->session->get("flashmessage");

        $this->app->page->add("content/header");
        $this->app->page->add("content/edit-add", [
            "res" => $res,
            "flashmessage" => $flashmessage,
        ]);

        return $this->app->page->render([
            "title" => $this->title,
        ]);
    }

    public function editActionPost() : object
    {   
        $db = $this->app->db;
        $content = new Content($db, "content");

        $params = $content->getPost($this->app, [
                "contentTitle",
                "contentPath",
                "contentSlug",
                "contentData",
                "contentType",
                "contentFilter",
                "contentPublish",
                "contentId"
            ]);

        if (!$params["contentPath"]) {
            $params["contentPath"] = null;
        }

        if (!$params["contentSlug"]) {
            $params["contentSlug"] = null;
        }

        $error = $content->savePost($params);
        if ($error) {
            $this->app->session->set("flashmessage", "Du försökte använda en path eller slug som redan finns. Försök med en annan");
        }

        return $this->app->response->redirect("content/edit/" . $params["contentId"]);
    }

    public function blogActionGet() : object
    {   
        $title = "Visa alla blogginlägg";
        $db = $this->app->db;
        $content = new Content($db, "content");
        $res = $content->showAllBlogPost();
        $this->app->page->add("content/header");
        $this->app->page->add("content/blog", [
            "resultset" => $res,
        ]);

        return $this->app->page->render([
            "title" => $title,
        ]);
    }

    public function pagesActionGet() : object
    {   
        $title = "Visa alla sidor";
        $db = $this->app->db;
        $content = new Content($db, "content");
        $res = $content->showAllPages();
        $this->app->page->add("content/header");
        $this->app->page->add("content/pages", [
            "res" => $res,
        ]);

        return $this->app->page->render([
            "title" => $title,
        ]);
    }

    public function postActionGet($slug) : object
    {   
        $db = $this->app->db;
        $content = new Content($db, "content");

        $res = $content->showPost($slug, "slug");

        if (!$res) {
            throw new NotFoundException();
        }

        $this->app->page->add("content/header");
        $this->app->page->add("content/blogpost", [
            "res" => $res,
        ]);

        return $this->app->page->render([
            "title" => $this->title,
        ]);
    }

    public function deleteActionGet($id) : object
    {   
        $title = "Ta bort";
        $db = $this->app->db;
        $content = new Content($db, "content");

        $res = $content->showPost($id, "id");

        if (!$res) {
            throw new NotFoundException();
        }

        $this->app->page->add("content/header");
        $this->app->page->add("content/delete", [
            "res" => $res,
        ]);

        return $this->app->page->render([
            "title" => $title,
        ]);
    }

    public function deleteActionPost() : object
    {   
        $db = $this->app->db;
        $content = new Content($db, "content");

        $id = $content->getPost($this->app, "contentId");

        $content->deletePost($id);

        return $this->app->response->redirect("content/admin");
    }

    public function createActionGet() : object
    {   
        $title = "Skapa";

        $this->app->page->add("content/header");
        $this->app->page->add("content/create");

        return $this->app->page->render([
            "title" => $title,
        ]);
    }

    public function createActionPost() : object
    {   
        $db = $this->app->db;
        $content = new Content($db, "content");

        $title = $content->getPost($this->app, "contentTitle");

        $content->createPost($title);
        $id = $this->app->db->lastInsertId();

        return $this->app->response->redirect("content/edit/$id");
    }

    public function resetActionGet() : object
    {
        $output = null;

        $this->app->page->add("content/header");
        $this->app->page->add("content/reset", [
            "res" => $output,
        ]);
        return $this->app->page->render([
            "title" => $this->title,
        ]);
    }

    /**
     * Actually reset the database
     *
     * @return object
     */
    public function resetActionPost() : object
    {
        $title = "Reset";
        $config = require(ANAX_INSTALL_PATH . "/config/database.php");

        $db = $this->app->db;
        $content = new Content($db, "content");
        $output = $content->resetDatabase($config);

        $this->app->page->add("content/header");
        $this->app->page->add("content/reset", [
            "res" => $output,
        ]);
        return $this->app->page->render([
            "title" => $title,
        ]);
    }
}
