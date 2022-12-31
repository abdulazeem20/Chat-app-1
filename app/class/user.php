<?php
$database = new Database;

class User
{
    public $username, $password, $firstname, $lastname, $gender, $phonenumber, $email, $status, $image;
    private $ussid;

    /**
     * construct
     *
     * @param $user = []
     *
     */
    public function __construct($user = [])
    {
        foreach ($user as $key => $detail) {
            $this->$key = $detail;
        }
        $this->ussid = $this->generateUssid();
    }

    public function insertUser()
    {
        $data = [];
        $data['ussid'] = $this->ussid;
        $data['firstname'] = $this->firstname;
        $data['lastname'] = $this->lastname;
        $data['email'] = $this->email;
        $data['gender'] = $this->gender;
        $data['phonenumber'] = $this->phonenumber;
        $data['username'] = $this->username;
        $data['password'] = md5($this->password1);
        $query = "INSERT INTO users(ussid, first_name, last_name, gender, email, phone_number, username, password) VALUES(:ussid, :firstname, :lastname, :gender, :email, :phonenumber, :username, :password)";
        $result = $GLOBALS['database']->insert($query, $data);
        return $result;
    }

    /**
     * checkIfUsernameExists
     * 
     * 
     *
     */
    public function checkIfUsernameExists()
    {
        $data = ['username' => $this->username];
        $query = "SELECT COUNT(*) FROM users_v WHERE username = :username";
        $result = $GLOBALS['database']->countItem($query, $data,);
        return $result;
    }

    public function checkIfEmailExists()
    {
        $data = ['email' => $this->email];
        $query = "SELECT COUNT(*) FROM users_v WHERE email = :email";
        $result = $GLOBALS['database']->countItem($query, $data,);
        return $result;
    }

    public function checkIfPhonenumberExists()
    {
        $data = ['phonenumber' => $this->phonenumber];
        $query = "SELECT COUNT(*) FROM users_v WHERE phone_number = :phonenumber";
        $result = $GLOBALS['database']->countItem($query, $data,);
        return $result;
    }

    public function fetchUser()
    {
        $data = ['username' => $this->username];
        $query = "SELECT * FROM users_v WHERE username = :username";
        $result = $GLOBALS['database']->fetchOne($query, $data,);
        return $result;
    }

    public function fetchUserById($data)
    {
        $query = "SELECT * FROM users_v WHERE ussid = :ussid";
        $result = $GLOBALS['database']->fetchOne($query, $data,);
        return $result;
    }

    private function generateUssid()
    {
        $uniqueId = uniqid($this->username, 1);
        $ussid = md5($uniqueId);
        return $ussid;
    }

    public function updateProfileImage($data)
    {
        $query = "UPDATE users SET image = :image WHERE ussid = :ussid";
        $result = $GLOBALS['database']->insert($query, $data,);
        return $result;
    }

    public function searchForUsers($ussid)
    {
        $query = "SELECT * FROM users_v WHERE username LIKE :username AND ussid != :ussid";
        $data = ['username' => '%' . $this->username . '%', 'ussid' => $ussid];
        $result = $GLOBALS['database']->fetchA($query, $data);
        return $result;
    }

    public function getOtherUsers($data)
    {
        $query = "SELECT * FROM users_v WHERE ussid != :ussid";
        $result = $GLOBALS['database']->fetchA($query, $data,);
        return $result;
    }

    public function saveOnline($ussid)
    {
        $data = ['ussid' => $ussid];
        $query = "UPDATE users SET status = 1 WHERE ussid = :ussid";
        $result = $GLOBALS['database']->insert($query, $data);
        return $result;
    }

    public function saveOffline($ussid)
    {
        $data = ['ussid' => $ussid];
        $query = "UPDATE users SET status = 0 WHERE ussid = :ussid";
        $result = $GLOBALS['database']->insert($query, $data);
        return $result;
    }

    public function updateProfile($ussid)
    {
        $data['firstname'] = $this->firstname;
        $data['lastname'] = $this->lastname;
        $data['email'] = $this->email;
        $data['username'] = $this->username;
        $data['phonenumber'] = $this->phonenumber;
        $data['ussid'] = $ussid;
        $query = " UPDATE users SET first_name = :firstname, last_name = :lastname, email = :email, username = :username, phone_number = :phonenumber WHERE ussid = :ussid ";
        return $GLOBALS['database']->insert($query, $data);
    }
}
