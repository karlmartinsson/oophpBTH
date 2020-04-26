<?php

namespace Karl\Dice1;

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
class DiceController implements AppInjectableInterface
{
    use AppInjectableTrait;


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
        $title = "Tärningsspelet";
        $this->app->page->add("dice1/start");
        return $this->app->page->render([
            "title" => $title,
        ]);
    }


    /**
     * Add the request method to the method name to limit what request methods
     * the handler supports.
     * GET mountpoint/info
     *
     * @return string
     */
    public function initActionPost() : object
    {
        $opponents = $this->app->request->getPost("opponents");
        $dices = $this->app->request->getPost("dices");
        $this->app->session->set("dice-game", new DiceGame($opponents, $dices));
        return $this->app->response->redirect("dice1/play");
    }



    /**
     * This sample method action it the handler for route:
     * GET mountpoint/create
     *
     * @return string
     */
    public function playActionGet() : object
    {
        $title = "Play the game";
        $game = $this->app->session->get("dice-game");

        $this->app->page->add("dice1/play");
    
        return $this->app->page->render([
            "game" => $game,
            "title" => $title,
        ]);
    }

    /**
     * This sample method action it the handler for route:
     * GET mountpoint/create
     *
     * @return string
     */
    public function rollActionGet() : object
    {
        $this->app->session->get("dice-game")->play(true);
 
        return $this->app->response->redirect("dice1/play");
    }

     /**
     * This sample method action it the handler for route:
     * GET mountpoint/create
     *
     * @return string
     */
    public function saveActionGet() : object
    {
        $this->app->session->get("dice-game")->play(false);
        return $this->app->response->redirect("dice1/play");
    }
}
