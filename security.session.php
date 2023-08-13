<?php
ini_set('session.use_only_cookies',1);

//ID of session can be only generated in website
ini_set('session.use_strict_mode',1);

//Delete session after 1800s , and use https only for security
session_set_cookie_params([
    "lifetime" => 1800,
    "domain" => 'localhost',
    'path' => '/',
    'secure' => TRUE,
    'httponly' => TRUE,
]);
session_start();

//generate a new id for current session and change id every 30 minute
if (!isset($_SESSION['last_regeneration'])) {
    session_regenerate_id(true);
    $_SESSION['last_regeneration']= time ();
}else {
    $interval=60*30;

    if (time()-$_SESSION['last_regeneration']>=$interval) {
        session_regenerate_id(true);
        $_SESSION['last_regeneration']= time ();
    }
}



