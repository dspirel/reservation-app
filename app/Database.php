<?php

namespace App;

use DateInterval;
use DateTime;
use \PDO;
use \PDOException;
use App\Controllers\HomeController;

use function PHPSTORM_META\type;

class Database {
    private static ?Database $instance = null;
    private PDO $conn;

    private function __construct() {
        $this->connect();
    }

    public static function getInstance(): Database {
        if (self::$instance === null) {
            self::$instance = new Database();
        }
        return self::$instance;
    }

    private function connect() {
        $dsn = DB_DRIVER.':host='.DB_HOST.';dbname='.DB_NAME.';charset='.DB_CHARSET;
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ];

        try{
            $this->conn = new PDO($dsn, DB_USER, DB_PASS, $options);
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function getConnection(): PDO {
        return $this->conn;
    }

    public function addUser($data) {
        $sql = "INSERT INTO user (email, password) VALUES (?,?)";

        $stmt = $this->conn->prepare($sql);

        try {
            $stmt->execute(array_values($data));
        } catch (PDOException $e) {
            echo $e;
        }
    }

    public function getUserByEmail($email): array|bool {
        $sql = "SELECT id,email,password FROM user WHERE email = ?";

        $stmt = $this->conn->prepare($sql);

        $stmt->bindParam(1, $email, PDO::PARAM_STR);

        try {
            $stmt->execute();
        } catch (PDOException $e) {
            echo $e;
        }

        $user = $stmt->fetchAll();
        if ($user) {
            return $user[0];
        } else {
            return false;
        }
    }

    public function getReservationById($id) {
        $sql = "SELECT id,last_name,contact_info,date_start,time_start,duration,group_size FROM reservation WHERE id = ? AND userID = ?";

        $stmt = $this->conn->prepare($sql);

        $stmt->bindParam(1, $id, PDO::PARAM_STR);
        $stmt->bindParam(2, $_SESSION["user"], PDO::PARAM_STR);

        try {
            $stmt->execute();
        } catch (PDOException $e) {
            echo $e;
        }

        return $stmt->fetchAll();
    }

    public function getReservationsByDate($date){
        $sql = "SELECT id,last_name,contact_info,date_start,time_start,duration,group_size FROM reservation WHERE date_start = ? AND userID = ?";

        $stmt = $this->conn->prepare($sql);

        $stmt->bindParam(1, $date, PDO::PARAM_STR);
        $stmt->bindParam(2, $_SESSION["user"], PDO::PARAM_STR);

        try {
            $stmt->execute();
        } catch (PDOException $e) {
            echo $e;
        }

        return $stmt->fetchAll();
    }

    public function addReservation($data) {
        $sql = "INSERT INTO reservation (last_name, contact_info, date_start, time_start, duration, group_size, userID) VALUES (?,?,?,?,?,?,?)";

        $stmt = $this->conn->prepare($sql);

        $data["duration"] = intval($data["duration"]);
        $data["group_size"] = intval($data["group_size"]);
        $data["user_id"] = intval($data["user_id"]);

        $stmt->bindParam(1, $data["last_name"], PDO::PARAM_STR);
        $stmt->bindParam(2, $data["contact_info"], PDO::PARAM_STR);
        $stmt->bindParam(3, $data["date_start"], PDO::PARAM_STR);
        $stmt->bindParam(4, $data["time_start"], PDO::PARAM_STR);
        $stmt->bindParam(5, $data["duration"], PDO::PARAM_INT);
        $stmt->bindParam(6, $data["group_size"], PDO::PARAM_STR);
        $stmt->bindParam(7, $data["user_id"], PDO::PARAM_INT);

        try {
            $stmt->execute();
        } catch (PDOException $e) {
            echo $e;
        }
    }

    public function updateReservation($columns, $id) {
        $sqlColumns = "";
        foreach ($columns as $key => $col) {
            $sqlColumns .= "$key = ?,";
        }
        $sqlColumns = rtrim($sqlColumns, ",");

        $sql = "UPDATE reservation SET " . $sqlColumns . " WHERE id = ? AND userID = ?";

        $stmt = $this->conn->prepare($sql);

        //bind columns
        $i = 1;
        foreach ($columns as $key => $col) {
            if ($key == "duration" || $key == "user_id") {
                $stmt->bindParam($i, $columns[$key], PDO::PARAM_INT);
            } else {
                $stmt->bindParam($i, $columns[$key], PDO::PARAM_STR);
            }
            $i++;
        }
        //bind id,userID
        $stmt->bindParam($i, $id, PDO::PARAM_STR);
        $stmt->bindParam($i+1, $_SESSION["user"], PDO::PARAM_STR);


        try {
            $stmt->execute();
        } catch (PDOException $e) {
            echo $e;
        }
    }
}