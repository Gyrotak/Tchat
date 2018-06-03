<?php

require (dirname(__DIR__) . "/model/chat.php");
require (dirname(__DIR__) . "/model/credential.php");

if (!isset($_SESSION["email"])) {
    header("location: /");
    exit;
}

$chat = new chat();
$account = new credential();

$allMessages = $chat->getAllMessage();
$UserConnected = $account->getUserConnected();

if (isset($_POST["send"])) {
    if (isset($_POST["text"])) {
        $chat->sendMessage($_POST["text"], $_SESSION["id_user"]);
        header("Refresh:0");
        exit;
    }
}

if (isset($_POST["deconnexion"])) {
    $account->disconnectUser($_SESSION["id_user"]);
    session_destroy();
    header("location: /");
    exit;
}

include_once(dirname(__DIR__) . '/view/chat.php');

?>