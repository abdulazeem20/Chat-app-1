<?php

class Database
{


    private $conn;

    /**
     * construct
     *
     */
    public function __construct()
    {
        $this->conn = $this->connect();
    }

    /**
     * connect
     *
     */
    private function connect()
    {
        try {
            $conn = new PDO("mysql:host=" . DBHOST . ";dbname=" . DBNAME, DBUSER, DBPASS);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            // echo "connected";
            return $conn;
        } catch (PDOException $e) {
            echo "Error When Connecting to database " . $e->getMessage();
        }
    }


    /**
     * insert
     *
     * @param mixed $query
     * @param $data = []
     *
     */
    public function insert($query, $data = [])
    {

        try {
            $stmt = $this->conn->prepare($query);
            $array = [];
            foreach ($data as $key => $item) {
                $array[':' . $key] = $item;
            }
            $stmt->execute($array);
            return true;
        } catch (PDOException $e) {
            echo "Error When Fetching " . $e->getMessage();
        }
    }


    /**
     * fetchOne
     *
     * @param mixed $query
     * @param $data = []
     *
     */
    public function fetchOne($query, $data = [])
    {
        try {
            $stmt = $this->conn->prepare($query);
            $array = [];
            foreach ($data as $key => $item) {
                $array[':' . $key] = $item;
            }
            $stmt->execute($array);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result;
        } catch (PDOException $e) {
            echo "Error When Fetching All " . $e->getMessage();
        }
    }


    public function fetchA($query, $data = [])
    {
        try {
            $stmt = $this->conn->prepare($query);
            $array = [];
            foreach ($data as $key => $item) {
                $array[':' . $key] = $item;
            }
            $stmt->execute($array);
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        } catch (PDOException $e) {
            echo "Error When Fetching All " . $e->getMessage();
        }
    }

    /**
     * count
     *
     * @param mixed $query
     * @param $data = []
     *
     */
    public function countItem($query, $data = [])
    {
        try {
            $stmt = $this->conn->prepare($query);
            $array = [];
            foreach ($data as $key => $item) {
                $array[':' . $key] = $item;
            }
            $stmt->execute($array);
            $result = $stmt->fetch(PDO::FETCH_COLUMN);
            return $result;
        } catch (PDOException $e) {
            echo "Error When COunting " . $e->getMessage();
        }
    }

    public function __destruct()
    {
        $this->conn = "";
    }
}
