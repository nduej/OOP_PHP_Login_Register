<?php

//Set Up Initialization File before going into Coding Proper
session_start();

//Set Up Config
$GLOBALS['config'] = array(
    'mysql' => array(
        'host' => '127.0.0.1',
        'username' => 'root',
        'password' => '',
        'db' => 'form_oop'
    ),

    //This is going to be Key names in the Cookie Expiry, for how long Users should be remembered
    'remember' => array(
        'cookie_name' => 'hash',
        'cookie_expiry' => '2,628,288'
    ),

    // Basically Session name and Token used
    'session' => array(
        'session_name' => 'user',
        'token_name' => 'token'
    ),
);

//Allows you to pass in a function that runs anytime a class is Accessed
spl_autoload_register(function($class){
    require_once 'classes/' . $class . '.php';
});

require_once 'functions/sanitize.php';

if(Cookie::exists(Config::get('remember/cookie_name')) && !Session::exists(Config::get('session/session_name')))
{
//Getting the Cookie from the Terminal, using Chrome Inspector tool!
$hash = Cookie::get(Config::get('remember/cookie_name'));
$hashCheck = DB::getInstance()->get('users_session', array('hash', '=', $hash));

if($hashCheck->count())
{
   //Instead to echo 'Hash matches, log user in!.';
   $user = new User($hashCheck->first()->user_id);
   $user->login();
}
}