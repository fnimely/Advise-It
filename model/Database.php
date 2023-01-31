<?php
require $_SERVER['DOCUMENT_ROOT'].'/../db-creds-adviseIt.php';

class Database {
//    DB connection object
    private $_dbh;
    private $_sql;

    function __construct(){
        try{
            $this->_dbh = new PDO(DB_DSN ,DB_USERNAME, DB_PASSWORD);
        } catch(PDOException $e){
            echo "Error connecting to DB " . $e->getMessage();
        }
    }

    function addToken($token): string{
        $this->_sql = "INSERT INTO student_schedule(token) VALUES (:token)";

        $statement = $this->_dbh->prepare($this->_sql);

        $statement->bindParam(':token', $token);
        $statement->execute();

        $id = $this->_dbh->lastInsertId();
        return $id;
    }

    function getPlan($token){
        $this->_sql = "SELECT * FROM student_schedule WHERE token = :token";

        $statement = $this->_dbh->prepare($this->_sql);
        $statement->bindParam(':token', $token);
        $statement->execute();

        $row = $statement->fetch(PDO::FETCH_ASSOC);
        return $row;
    }

    function addPlan($studentPlan){
        $this->_sql = "UPDATE student_schedule SET 
                    fall=:fall, winter=:winter, spring=:spring, summer=:summer 
                    WHERE token = :token";

        $statement = $this->_dbh->prepare($this->_sql);
        $statement->bindParam(':fall', $studentPlan->getFall());
        $statement->bindParam(':winter', $studentPlan->getWinter());
        $statement->bindParam(':spring', $studentPlan->getSpring());
        $statement->bindParam(':summer', $studentPlan->getSummer());

        $success = $statement->execute();
        if(!$success){
            throw new Exception("Error code: " . $statement->errorCode() .
                " Error info: " . implode(", ", $statement->errorInfo()));
        }
    }
}