<?php
session_start();

if (!isset($_GET['section']) OR $_GET['section'] == 'authentification')
    {
        include_once(dirname(__FILE__) . '/controller/authentification.php');
    }
else
    {
        if (file_exists(dirname(__FILE__) . '/controller/'.strtolower($_GET['section']).'.php'))
            include_once(dirname(__FILE__) . '/controller/'.strtolower($_GET['section']).'.php');
        else
            include_once(dirname(__FILE__) . '/controller/404.php');
    }

?>
