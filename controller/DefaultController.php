<?php
namespace TestPress;

class DefaultController {
    private static $instance;

    public static function getInstance()
    {
        if (!self::$instance) {
            self::$instance = new DefaultController();
        }
        return self::$instance;
    }

    public function indexAction()
    {
        get_partial('page/index');
    }
}