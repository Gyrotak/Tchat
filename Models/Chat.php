<?php

namespace Models\Chat;

use App\Service\FieldVerification;

class Chat
{

    /*
     * @var instance of class field verification
     */
    public $field_verification; 

    /*
     * @var get config
     */
    private $config;

    /*
     * @var instance of db
     */
    private $db;
    
    /*
     * Constructor of Chat
     * Get instance of field_verification and store them
     */
    public function __construct()
    {
        $database_config = [
            "database_name" => "TChat",
            "host" => "127.0.0.1",
            "user" => "TChat",
            "password" => "TChat"
        ];

        $this->config = $database_config;
        $this->db = $this->dbConnect();
        $this->field_verification = new FieldVerification\field_verification();
    }
    
    /*
     * Send message to chat
     * @paremter string($message))
     * @paremter string($user)
     * @return bool
     */
    public function sendMessage($message, $user)
    {
        if (($newText = $this->field_verification->checkText($message)) != false) {
            $stmt = $this->db->prepare("INSERT INTO Chat (ID_User, Message, Created_at) VALUES (:id, :message, NOW())");
            $stmt->bindParam(":id", $user);
            $stmt->bindParam(":message", $newText);
            $stmt->execute();
        }
    }

    /*
     * Get all message send to chat
     * @return array|null
     */
    public function getAllMessage()
    {
        $stmt = $this->db->prepare("SELECT * FROM Chat");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    /*
     * Get count of all message
     * @return int
     */
    public function getCountMessage()
    {
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM Chat");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    /*
     * Get Message with limit to 10 and by pages
     * @parameter int($page_number)
     * @return array|null
     */
    public function getMessagePerPage($page_number)
    {
        // if page == 1
        // SELECT * FROM Products WHERE id BETWEEN 0 AND 10;
        // else if > 1
        // SELECT * FROM Products WHERE id BETWEEN 10 * (number_page - 1) + 1 and 10 * number_page;
        // else
        // null
    }

    /*                           
     * Database connection                                                                             
     * @return PDO instance                                                                            
     */
    private function dbConnect()
    {
        $dsn = 'mysql:host='.$this->config["host"].';dbname='.$this->config["database_name"].';charset=utf8';
        return new \PDO($dsn, $this->config["user"], $this->config["password"]);
    }
}

?>