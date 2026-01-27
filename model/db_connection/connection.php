<?php

class DBConnection
{

 private $con,$PDO; // store connection here

    // Create connection
    public function ConnectToMYSQL()
    {
        $this->con = mysqli_connect("localhost","sandsl23_school_user","S@nds1@b","sandsl23_school_db");

        if (mysqli_connect_errno()) {
            echo "Failed to connect to MySQL: " . mysqli_connect_error();
        }

        return $this->con;
    }
    
    public function PDOConnection()
    {
        try {
                $this->PDO = new PDO(
                    "mysql:host=localhost;dbname=sandsl23_school_db",
                    "sandsl23_school_user",
                    "S@nds1@b",
                    [
                        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
                    ]
                );
            
            } catch (Exception $e) {
                echo "ERROR: " . $e->getMessage();
            }
            return $this->PDO;
    }
   

    public function close()
    {
        if ($this->con) {
            mysqli_close($this->con);
            $this->con = null; // optional: clear variable
        }
    }
}


?>
