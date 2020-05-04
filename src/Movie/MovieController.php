<?php

namespace Karl\Movie;

use Anax\Commons\AppInjectableInterface;
use Anax\Commons\AppInjectableTrait;

// use Anax\Route\Exception\ForbiddenException;
// use Anax\Route\Exception\NotFoundException;
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
class MovieController implements AppInjectableInterface
{
    use AppInjectableTrait;


    private $title = "Filmdatabasen";
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
        $orderBy = $this->app->request->getGet("orderBy");
        if (!isset($orderBy)) {
            $orderBy = "id";
        }
        $order = $this->app->request->getGet("order");
        if (!isset($order)) {
            $order = "asc";
        }

        $movieDatabase = new Movie($this->app);
        $page = $this->app->request->getGet("page");
        if (!isset($page)) {
            $page = 1;
        }

        $hits = $this->app->request->getGet("hits");
        if (!isset($hits)) {
            $hits = 4;
        }

        $result = $movieDatabase->showAllPaginate($hits, $page, $orderBy, $order);
        $output = ["res" => $result["res"], "max" => $result["max"]];
        
        $this->app->page->add("movie/header");
        $this->app->page->add("movie/index", $output);

        return $this->app->page->render([
            "title" => $this->title,
        ]);
    }


    /**
     * Search method
     *
     * @return object
     */
    public function searchActionGet() : object
    {
        $this->app->page->add("movie/header");
        $this->app->page->add("movie/search", [
            "title" => $this->app->request->getGet("searchTitle"),
            "year1" => $this->app->request->getGet("year1"),
            "year2" => $this->app->request->getGet("year2"),
        ]);
        
        $movieDatabase = new Movie($this->app);
        $res = $movieDatabase->search();

        $this->app->page->add("movie/index-search", [
            "res" => $res,
        ]);

        return $this->app->page->render([
            "title" => $this->title,
        ]);
    }



    /**
     * Edit method
     *
     * @return object
     */
    public function editActionGet($id) : object
    {
        $this->app->page->add("movie/header");

        $movieDatabase = new Movie($this->app);
        $res = $movieDatabase->showMovie($id);          

        $this->app->page->add("movie/edit-add", [
            "res" => $res,
        ]);
        
        return $this->app->page->render([
            "title" => $this->title,
        ]);
    }

    /**
     * Create method
     *
     * @return object
     */
    public function createActionGet() : object
    {
        $this->app->page->add("movie/header");

        $this->app->page->add("movie/edit-add", []);
        
        return $this->app->page->render([
            "title" => $this->title,
        ]);
    }

    /**
     * Save method
     *
     * @return object
     */
    public function saveActionPost() : object
    {
        $movieDatabase = new Movie($this->app);
        $movieDatabase->saveChanges();

        return $this->app->response->redirect("movie");
    }

    /**
     * delete method to get delete site.
     *
     * @return object
     */
    public function deleteActionGet($id) : object
    {
        $this->app->page->add("movie/header");

        $movieDatabase = new Movie($this->app);
        $res = $movieDatabase->showMovie($id);          

        $this->app->page->add("movie/delete", [
            "res" => $res,
        ]);
        
        return $this->app->page->render([
            "title" => $this->title,
        ]);
    }

    /**
     * Delete post method to actually delete
     *
     * @return object
     */
    public function deleteActionPost() : object
    {
        $movieDatabase = new Movie($this->app);
        $movieDatabase->deleteMovie();

        return $this->app->response->redirect("movie");
    }

    /**
     * Reset the database site
     *
     * @return object
     */
    public function resetActionGet() : object
    {
        $output = null;

        $this->app->page->add("movie/header");
        $this->app->page->add("movie/reset", [
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
        $movieDatabase = new Movie($this->app);
        $output = $movieDatabase->resetDatabase();

        $this->app->page->add("movie/header");
        $this->app->page->add("movie/reset", [
            "res" => $output,
        ]);
        return $this->app->page->render([
            "title" => $this->title,
        ]);
    }
}
