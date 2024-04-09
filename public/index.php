<?php

if (isset($_POST)){
    echo "OK";
}
else{
    echo "NO";
}

$txt=$_SERVER['REQUEST_URI'];
//$txt = "home/index?name=sake&phone=123&password=456&address=nukus";
$txt = trim($txt,'/');
$arr = explode('?', $txt);
$attributes = null;
if (isset($arr[1])){
    $str = $arr[1];
    $arr2 = explode('&', $str);
    $attributes = getAttributes($arr2);
}

function getAttributes($data){
    $list = array();
    foreach ($data as $d){
        $temp = explode("=",$d);
        array_push($list, $temp[1]);
    }
    return $list;
}

define('ROOT', dirname(__DIR__));

spl_autoload_register(function ($class){
    $file = ROOT . '/' . str_replace('\\', '/', $class).".php";

    if (file_exists($file)){
        require $file;
    }
});

$request = trim($_SERVER['REQUEST_URI'], '/');
$requestPart = explode("?",$request);
$requestPart = explode("/",$requestPart[0]);

$controller = isset($requestPart[0]) ? $requestPart[0] : "home";
$action = isset($requestPart[1]) ? $requestPart[1] : "index";

//echo $controller;
$controller = ucfirst(strtolower($controller)) . "Controller";
$controller = "App\controllers\\$controller";
//$controller = ROOT."/App\controllers\\$controller".".php";

if (file_exists(ROOT ."/".$controller.".php") && method_exists($controller, $action)){
    $obj = new $controller;
    call_user_func_array([$obj, $action],$attributes != null ? $attributes : []);
}else{
    require ROOT."/config/404.php";
}

