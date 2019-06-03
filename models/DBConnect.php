<?php
class DBConnect{
    protected $dbname;
    protected $hostname;
    protected $username;
    protected $password;

    protected function dbConnection(){
		$this->dbname = "groupDB";
		$this->username = "sbotiroff";
        $this->hostname = "localhost";
		$this->password = "Ingame1995";
		try{
			$dsn = "mysql:host=".$this->hostname.";dbname=".$this->dbname;
			$pdo = new PDO($dsn,$this->username,$this->password);
            $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
			return $pdo;
		}catch(PDOException $e){
			echo "Failed to connect: " .$e->getMessage();
		}
	}

} 
?>