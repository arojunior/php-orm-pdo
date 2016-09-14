<?php

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept');

require_once __DIR__ . '/model/Model.php';
require_once __DIR__ . '/controller/Controller.php';
require_once __DIR__ . '/helper/Helper.php';

$uri = $_SERVER['REQUEST_URI'];

if ($uri == '/') {

    echo "No file selected";

} else {
    $src = explode('/', $uri);
    $model = ucfirst($src[1]);
    $controller = $model.'Controller';
    $method = (isset($src[2])) ? $src[2] : 'index';

    /*
    * require files of current Model/Controller
    */
    $model_file = __DIR__ . '/model/'.$model.'.php';

    if (file_exists($model_file)) {
        require_once $model_file;
    }

    $controller_file = __DIR__ . '/controller/'.$controller.'.php';

    if (file_exists($controller_file)) {
        require_once $controller_file;
    } else {
        throw new Exception('Controller ' . $controller . ' Not Found');
    }

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
    $view_file = __DIR__ . '/view/' . $model . '/' . $method . '.php';

    if (file_exists($view_file)) {
        include ($view_file);
    }
}
