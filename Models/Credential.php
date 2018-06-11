<?php

namespace Models\Credential;

class Credential
{

    /*
     * @var db instance
     */
    private $db;

    /*
     * @var config
     */
    private $config;

    public function __construct()
    {
        $database_config = [
            "database_name" => "TChat",
            "host" => "127.0.0.1",
            "user" => "",
            "password" => ""
        ];
        
        $this->config = $database_config;
        $this->db = $this->dbConnect();
    }

    /*
     * Get user by ID
     * @Parameter int($id)
     * @Return Array|null
     */
    public function getUserById($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM User WHERE ID = :id");
        $stmt->bindParam(':id', $id, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    /*
     * Connect user to chat
     * @parameter string($email)
     * @parameter string($password)
     * @return array (id user)
     */
    public function userConnection($email, $password)
    {
        $password_hash = hash("sha256", $password);

        $stmt = $this->db->prepare("SELECT * FROM User WHERE email = :email");
        $stmt->bindParam(':email', $email, \PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetchAll();

        if (@$result[0][2] == $password_hash) {
            $stmt = $this->db->prepare("UPDATE User SET Connected = 1 WHERE ID = :id");
            $stmt->bindParam(":id", $result[0]["ID"]);
            $stmt->execute();
            $array["data"] = $result[0]["ID"];
            $array["error"] = null;
            return $array;
        } else {
            $array["data"] = null;
            $array["error"] = "Aucune correspondance entre email et mot de passe !";
            return $array;
        }
        return [];
    }

    /*
     * Deconnexion de l'utilisateur actuel
     * @parameter int($id)
     */
    public function disconnectUser($id) {
        $stmt = $this->db->prepare("UPDATE User SET Connected = 0 WHERE ID = :id");
        $stmt->bindParam(":id", $id);
        $stmt->execute();
    }

    /*
     * Create user with data send by form
     * @Parameter array($data)
     * @return int (id user)
     */
    public function createUser($email, $password)
    {
        $password_hash = hash("sha256", $password);
        $stmt = $this->db->prepare("INSERT INTO User (email, password, connected) VALUES (:email, :password, 1)");
        $stmt->bindParam(':email', $email, \PDO::PARAM_STR);
        $stmt->bindParam(':password', $password_hash, \PDO::PARAM_STR);
        $stmt->execute();

        $stmt = $this->db->prepare("SELECT MAX(id) FROM User");
        $stmt->execute();
        $result = $stmt->fetchAll();
        return $result[0]["MAX(ID)"];
    }

    /*
     * Return all user connected
     * @return array
     */
    public function getUserConnected()
    {
        $stmt = $this->db->prepare("SELECT * FROM User WHERE Connected = 1");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    /*
     * Check if email is used
     * @return bool
     */
    public function CheckExistUser($email)
    {
        $stmt = $this->db->prepare("SELECT * FROM User WHERE email = :email");
        $stmt->bindParam(':email', $email, \PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetchAll();

        if (count($result) > 0)
            return 1;
        return 0;
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