<?php
use TestPress\DefaultController;
$controller = DefaultController::getInstance();

routes(array(
    '/\//' => array($controller, 'indexAction')
));
