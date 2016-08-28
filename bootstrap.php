<?php

include_once './model/Model.php';
include_once './controller/Controller.php';
include_once './helper/Helper.php';

if (!empty($_GET['pg'])):
    $src = explode('/', $_GET['pg']);
    $controller = ucfirst($src[0]);
    $action = $src[1];

    include './model/'.$controller.'.php';
    include './controller/'.$controller.'Controller.php';

    $controller .= 'Controller';

    $class = new $controller();

    if (!empty($_POST)):
        $class->{$action}($_POST);
    else:
        $class->{$action}();
    endif;

endif;
