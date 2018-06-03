<?php

require (dirname(__DIR__) . "/config/database.php");
require (dirname(__DIR__) . "/model/field_verification.php");

class chat
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
        global $config;
        
        $this->config = $config;
        $this->db = $this->dbConnect();
        $this->field_verification = new field_verification();
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
     * Get Message with limit to 10 by default and by pages
     * @parameter int($page_number)
     * @return array|null
     */
    public function getMessagePerPage($page_number, $limit = 10)
    {
        $messages = [];
        if ($page_number == 1) {
            $query = "SELECT * FROM Products WHERE id BETWEEN 0 AND ". $limit;
        }
        else if ($page_number > 1) {
            $query = "SELECT * FROM Products WHERE id BETWEEN ". $limit ." * (" . $number_page . " - 1) + 1 and " . $limit . " * " . $number_page;
        }
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        $messages = $stmt->fetchAll();
        return $messages;
    }

    /*                           
     * Database connection                                                                             
     * @return PDO instance                                                                            
     */
    private function dbConnect()
    {
        $dsn = 'mysql:host='.$this->config["host"].';dbname='.$this->config["database_name"].';charset=utf8';
        return new PDO($dsn, $this->config["user"], $this->config["password"]);
    }
}

?>