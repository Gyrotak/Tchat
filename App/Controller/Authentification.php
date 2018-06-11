<?php
namespace App\Controller;

use App\Service\ViewLoad;
use App\Service\FieldVerification;
use Models\Credential;

class Authentification {

    public function __constructor() {
        if (isset($_SESSION['email'])) {
            header('Locatioon: /TChat');
            exit;
        }
    }

    /*
     * Get index for authentificate
     */
    public function index() {
        if (isset($_SESSION['email'])) {
            header('Locatioon: /TChat');
            exit;
        }
        (new \App\Service\ViewLoad\ViewLoad())->load_view(dirname(__DIR__) . "/Views/Authentification.php");
    }

    /*
     * Connect/Register user
     */
    public function connect() {
        if (isset($_POST["email"]) && isset($_POST["password"])) {
            $error = [];
            $verif = new \App\Service\FieldVerification\field_verification();
            $email = $_POST["email"];
            $password = $_POST["password"];
            
            if (!$verif->checkEmail($email))
                $error["email_error"] =  "L'adresse email inserer n'est pas valide !";
            if (!$verif->checkPassword($password))
                $error["password_error"] = "Le mot de passe doit faire 8 caractere au minimum !";
            
            if (count($error) == 0) {
                $account = new \Models\Credential\Credential();
                if ($account->CheckExistUser($email)) {
                    $data = $account->userConnection($email, $password);
                    if (count($data["error"]) == 0) {
                        $_SESSION["connected"] = true;
                        $_SESSION["id_user"] = $data["data"];
                        $_SESSION["email"] = $email;
                        header('Location: /TChat');
                        exit;
                    } else
                        $error["password_error"] = $data["error"];
                } else {
                    $id_user = $account->createUser($email, $password);
                    $_SESSION["connected"] = true;
                    $_SESSION["id_user"] = $id_user;
                    $_SESSION["email"] = $email;
                    header('Location: /TChat');
                    exit;
                }
            }
        }
        (new \App\Service\ViewLoad\ViewLoad())->load_view(dirname(__DIR__) . "/Views/Authentification.php", $error);
    }
}

?>