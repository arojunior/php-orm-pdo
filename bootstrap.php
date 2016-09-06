<?php

require_once __DIR__ . '/model/Model.php';
require_once __DIR__ . '/controller/Controller.php';
require_once __DIR__ . '/helper/Helper.php';

if (!empty($_GET['pg'])):
    $src = explode('/', $_GET['pg']);
    $model = ucfirst($src[0]);
    $controller = $model.'Controller';
    $method = (isset($src[1])) ? $src[1] : 'index';

    /*
    * require files of current Model/Controller
    */
    require_once __DIR__ . '/model/'.$model.'.php';
    require_once __DIR__ . '/controller/'.$controller.'.php';

    /*
    * call current class/method
    */
    $set = call_user_func_array(array(new $controller, $method), $_POST);

    /*
    * Declare all variables if passed in return
    */
    if (!empty($set) && is_array($set)) {
        foreach ($set as $k => $v) {
            ${$k} = $v;
        }
    }

    /*
    * If method has a view file, include
    */
    $view = __DIR__ . '/view/' . $model . '/' . $method . '.php';

    if (file_exists($view)) {
        include ($view);
    }

endif;
