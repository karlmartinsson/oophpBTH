<?php

namespace Karl\Dice1;

use Anax\Response\ResponseUtility;
use Anax\DI\DIMagic;
use PHPUnit\Framework\TestCase;

/**
 * Test the controller like it would be used from the router,
 * simulating the actual router paths and calling it directly.
 */
class DiceControllerTest extends TestCase
{

    private $controller;
    private $app;


    /**
     * Setup the controller, before each testcase, just like the router
     * would set it up.
     */
    protected function setUp(): void
    {
        global $di;

        // Init service container $di to contain $app as a service
        $di = new DIMagic();
        $di->loadServices(ANAX_INSTALL_PATH . "/config/di");
        $app = $di;
        $this->app = $di;
        $di->set("app", $app);

        // Create and initiate the controller
        $this->controller = new DiceController();
        $this->controller->setApp($app);
    }



    /**
     * Call the controller index action.
     */
    public function testIndexAction()
    {

        $res = $this->controller->indexAction();
        $this->assertInstanceOf(ResponseUtility::class, $res);
        //$this->assertStringEndsWith("active", $res);
    }

    /**
     * Call the controller init action with a post.
     */
    public function testInitActionPost()
    {
        $this->app->request->setPost("dices", 2);
        $this->app->request->setPost("opponents", 2);
        $res = $this->controller->initActionPost();
        $this->assertInstanceOf(ResponseUtility::class, $res);
        //$this->assertStringEndsWith("active", $res);
    }

    /**
     * Call the Play action.
     */
    public function testPlayActionGet()
    {
        $this->app->session->set("dice-game", new DiceGame(2, 2));
        $res = $this->controller->PlayActionGet();
        $this->assertInstanceOf(ResponseUtility::class, $res);
        //$this->assertStringEndsWith("active", $res);
    }

    /**
     * Call the Roll action.
     */
    public function testRollActionGet()
    {
        $this->app->session->set("dice-game", new DiceGame(2, 2));
        $res = $this->controller->RollActionGet();
        $this->assertInstanceOf(ResponseUtility::class, $res);
        //$this->assertStringEndsWith("active", $res);
    }

    /**
     * Call the Save action.
     */
    public function testSaveActionGet()
    {
        $this->app->session->set("dice-game", new DiceGame(2, 2));
        $res = $this->controller->SaveActionGet();
        $this->assertInstanceOf(ResponseUtility::class, $res);
        //$this->assertStringEndsWith("active", $res);
    }
}
