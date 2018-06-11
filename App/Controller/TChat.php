<?php
namespace App\Controller;

use App\Service\ViewLoad as load;
use Models\Chat;
use Models\Credential;

class TChat {

    public function __constructor() {
        if (!isset($_SESSION["email"])) {
            header("location: /");
            exit;
        }
    }

    /*
     * Get index view when router call /Tchat
     */
    public function index() {
        if (!isset($_SESSION['email'])) {
            header('Location: /');
            exit;
        }
        $load = new load\ViewLoad();
        $chat = new Chat\Chat();
        $account = new Credential\credential();
        
        $data['allMessages'] = $chat->getAllMessage();
        $data['UserConnected'] = $account->getUserConnected();
        
        $load->load_view(dirname(__DIR__) . "/Views/chat.php", $data);
    }

    /*
     * Send message with post method router
     */
    public function send() {
        $chat = new Chat\Chat();
        if (isset($_POST["text"])) {
            $chat->sendMessage($_POST["text"], $_SESSION["id_user"]);
            header("Location: /TChat");
            exit;
        }
    }

    /*
     * Deconnect user
     */
    public function deconnexion() {
        $account = new Credential\credential();
        
        $account->disconnectUser($_SESSION["id_user"]);
        session_destroy();
        header("location: /");
        exit;
    }
    
}

?>