<?php
//file to connect with database and execute queries
class Database
{
    private $user;
    private $host;
    private $pass;
    private $db;
    private $mySqli;

    public function __construct()
    {
        $this->user = "root";
        $this->host = "localhost";
        $this->pass = "";
        $this->db = "englishpro";
    }

    public function getServerName()
    {
        return $this->host;
    }

    public function getUser()
    {
        return $this->user;
    }

    public function establishConnection() //connect with db
    {
        $this->mySqli = @new mysqli($this->host, $this->user, $this->pass, $this->db);
        if ($this->mySqli->connect_error) {
            throw new Exception("<p>Error: Could not connect to database.<br/>Please try again later.</p>", 1);
        }
        return $this->mySqli;
    }

    public function closeConnection()
    {
        if ($this->mySqli) {
            $this->mySqli->close();
        }
    }

    public function query_exexute($sql)
    {
        $result = $this->mySqli->query($sql);
        if (!$result) {
            throw new Exception($this->mySqli->error);
        }
        return $result;
    }

    public function getLastInsertId()
    {
        return $this->mySqli->insert_id;
    }

    public function startTransaction()
    {
        if (!$this->mySqli) {
            throw new Exception("Database connection not established.");
        }
        mysqli_autocommit($this->mySqli, false);
    }

    public function commit()
    {
        if (!$this->mySqli) {
            throw new Exception("Database connection not established.");
        }
        mysqli_commit($this->mySqli); // Commit the transaction
        mysqli_autocommit($this->mySqli, true);
    }

    public function rollback()
    {
        if (!$this->mySqli) {
            throw new Exception("Database connection not established.");
        }
        mysqli_rollback($this->mySqli);
        mysqli_autocommit($this->mySqli, true);
    }
}
?>
