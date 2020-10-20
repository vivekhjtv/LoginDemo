<?php
class database{
    private $servername = "localhost";
    private $username = "root";
    private $dbpassword = "";
    private $dbname = "signup";
    private $conn;

    public function connect()
    {
        $this->conn = new mysqli($this->servername, $this->username, $this->dbpassword, $this->dbname);
        if ($this->conn->connect_error) {
            return ("Connection failed: " . $conn->connect_error);
        }
        return true;
    }
    public function emailExist($user)
    {
        $emailexist = "SELECT email FROM signup_tb WHERE email = '" . $user['email'] ."'";        
          
        $email_query = $this->conn->query($emailexist);        
        if ($email_query->num_rows > 0) {
            return true;
        }
        return false;
    }
    public function getUserById($id)
    {
        $select_data = "SELECT * FROM signup_tb  WHERE id = $id";
        $select_query = $this->conn->query($select_data);
        if ($select_query->num_rows > 0) {
            return $select_query->fetch_assoc();
        }
    }
    public function getByDetail($userId){
        $detail = "SELECT * FROM signup_tb WHERE id = '" . $userId . "'";
        $detail_query = $this->conn->query($detail);
        if ($detail_query->num_rows > 0) {  
            $user_detail = $detail_query->fetch_assoc();
            return $user_detail;
        }       
    }
    public function fileList()
    {
        $data = [];
        $select_data = "SELECT * FROM signup_tb";
        $select_query = $this->conn->query($select_data);
        if ($select_query->num_rows > 0) {
            while ($row = $select_query->fetch_assoc()) {
                $data[] = $row;
            }
        }
        return $data;
    }
    public function isPasswordValid($userId, $pass){
        $query = "SELECT pwd FROM signup_tb WHERE pwd = md5('" . $pass ."') AND id = '" . $userId . "'";
        $insert_query = $this->conn->query($query);
        return ($insert_query->num_rows > 0);
    }
    public function add($user)
    {  
        $id = "INSERT INTO signup_tb (firstname, lastname, email, pwd) VALUES ('".$user['firstname']."','".$user['lastname']."' , '".$user['email']."', md5('".$user['password']."'));";
        $insert_query = $this->conn->query($id);
        return $user;
    } 
    public function login($user)
    {  
        $emailexist = "SELECT * FROM signup_tb WHERE email = '" . $user['email'] ."' AND pwd = md5('" .$user['password']."');";
        $insert_query = $this->conn->query($emailexist);
        
        if ($insert_query->num_rows > 0) {  
            $user_detail = $insert_query->fetch_assoc();
            return $user_detail;
        }
        return false;
    }
    public function update($user)
    {
        $update_data = 'UPDATE signup_tb SET firstname="' . $user["firstname"] . '", lastname="' . $user["lastname"] . '", email="'. $user["email"] . '" WHERE id=' . $user["id"]. ';';
        $update_query = $this->conn->query($update_data);
        return $user;
    }
    public function admistrationUpdate($user)
    {
        $update_data = 'UPDATE signup_tb SET firstname="' . $user["firstname"] . '", lastname="' . $user["lastname"] . '" WHERE id=' . $user["id"]. ';';
        $update_query = $this->conn->query($update_data);
        return $user;
    }
    public function changePassword($userId, $password)
    {
        $update_data = 'UPDATE signup_tb SET pwd= md5("' . $password . '") WHERE id=' . $userId. ';';
        $update_query = $this->conn->query($update_data);
        return true;
    }
    public function deleteList($id)
    {
        $delete_data = "DELETE FROM signup_tb WHERE id = $id";
        $delete_query = $this->conn->query($delete_data);
    }
}




?>