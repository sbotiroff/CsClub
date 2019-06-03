<?php
class AdminModel extends DBConnect
{
    public function getAdmin($adminInfo){
    $admin = $this->dbConnection()->query("SELECT * FROM `admin`");
    $result = $admin->fetchAll(PDO::FETCH_ASSOC);
    $username = $adminInfo['username'];
    $password = $adminInfo['password'];
    
    if($this->adminChecker($username,$password,$result)){

        $_SESSION['token'] = md5($username+""+$password);
        return [
            "payload" =>[
                "token" => md5($username+""+$password)
            ],
            "status" =>"success"
        ];
    }else {
        return [
            "payload" =>"Username or Password not matching",
            "status" =>"failed"
        ];
    }
 
 
    }

    public function adminChecker($username, $password, $result){
        $correctUser = false;
        $password = md5($password);
        foreach($result as $admin){
            if(($admin['username'] === $username) && ($admin['password'] === $password)){
                $correctUser = true;
            }
        }
        if($correctUser){
            return true;
        }else {return false;}
    }
}
