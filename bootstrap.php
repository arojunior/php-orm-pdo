<?php

include_once './model/Model.php';
include_once './controller/Controller.php';
include_once './helper/Helper.php';

if (!empty($_GET['pg'])):
    $src = explode('/', $_GET['pg']);
    $model = ucfirst($src[0]);
    $controller = $model.'Controller';
    $action = (isset($src[1])) ? $src[1] : 'index';

    include './model/'.$model.'.php';
    include './controller/'.$controller.'.php';

    $class = new $controller();

    if (!empty($_POST)):
        $class->{$action}($_POST);
    else:
        $class->{$action}();
    endif;

endif;
