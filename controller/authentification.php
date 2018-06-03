<?php

include_once(dirname(__DIR__) . "/model/field_verification.php");
include_once(dirname(__DIR__) . "/model/credential.php");

if (isset($_SESSION["email"])) {
    header('Location: ?section=chat');
    exit;
}

if (isset($_POST["email"]) && isset($_POST["password"])) {
    $error = [];
    $verif = new field_verification();
    $email = $_POST["email"];
    $password = $_POST["password"];
    
    if (!$verif->checkEmail($email))
        $error["email_error"] =  "L'adresse email inseré n'est pas valide !";
    if (!$verif->checkPassword($password))
        $error["password_error"] = "Le mot de passe doit faire 8 caractere au minimum !";

    if (count($error) == 0) {
        $account = new credential();
        if ($account->CheckExistUser($email)) {
            $data = $account->userConnection($email, $password);
            if (count($data["error"]) == 0) {
                $_SESSION["connected"] = true;
                $_SESSION["id_user"] = $data["data"];
                $_SESSION["email"] = $email;
                header('Location: ?section=chat');
                exit;
            } else
                $error["password_error"] = $data["error"];
        } else {
            $id_user = $account->createUser($email, $password);
            $_SESSION["connected"] = true;
            $_SESSION["id_user"] = $id_user;
            $_SESSION["email"] = $email;
            header('Location: ?section=chat');
            exit;
        }
    }
}


include_once(dirname(__DIR__) . '/view/Authentification.php');

?>
