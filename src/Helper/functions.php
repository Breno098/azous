<?php 

if (! function_exists('putenvs')) {
    function putenvs(){
        $env = $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . '.env';
        if(!file_exists($env)){
            return false;
        }
        foreach (file($env) as $env) {
            if($varibleEnv = trim($env)){
                $envExplode = explode('=', $varibleEnv);
                $GLOBALS[$envExplode[0]] = $envExplode[1];
            }
        }
        return true;
    }
}

if (! function_exists('env')) {
    function env($value, $default = ''){
        return isset($GLOBALS[$value]) ? $GLOBALS[$value] : $default;
    }
}

if (! function_exists('set_header')) {
    function set_header(){
        ini_set('display_errors', 1); 
        ini_set('display_startup_errors', 1);

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
            header('Access-Control-Allow-Credentials: true');
            header('Access-Control-Max-Age: 86400');
        }
    }
}

if (! function_exists('response')) {
    function response(){
        return new Azuos\Http\Response();
    }
}

if (! function_exists('hash_token')) {
    function hash_token($word){
        return password_hash($word, PASSWORD_BCRYPT);
    }
}

if (! function_exists('hash_token')) {
    function verify_token($word, $token){
        return password_verify($word, $token);
    }
}

if (! function_exists('start_app')) {
    function start_app(){
        set_header();
        putenvs();
    }
}

start_app();
