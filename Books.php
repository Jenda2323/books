<?php

class Books
{
    private $dbConn;

    public function __construct($dbConn)
    {
        $this->dbConn = $dbConn;
    }
    public function getBooks()
    {
        $stmt = $this->dbConn->prepare("SELECT * FROM books");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function filterBooks($lastname, $firstname, $title, $isbn)
    {
        $sql = "SELECT * FROM books WHERE 1=1";
        $params = [];

        if (!empty($lastname)) {
            $sql .= " AND lastname LIKE :lastname";
            $params[':lastname'] = '%' . $lastname . '%';
        }

        if (!empty($firstname)) {
            $sql .= " AND firstname LIKE :firstname";
            $params[':firstname'] = '%' . $firstname . '%';
        }

        if (!empty($title)) {
            $sql .= " AND title LIKE :title";
            $params[':title'] = '%' . $title . '%';
        }
        if (!empty($isbn)) {
            $sql .= " AND isbn LIKE :isbn";
            $params[':isbn'] = '%' . $isbn . '%';
        }

        $stmt = $this->dbConn->prepare($sql);

        foreach ($params as $param => $value) {
            $stmt->bindValue($param, $value, PDO::PARAM_STR);
        }

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function addBook($isbn, $firstname, $lastname, $title, $description)
    {
        $sql = "INSERT INTO books (isbn, firstname, lastname,title ,description) VALUES (:isbn, :firstname, :lastname, :title, :description)";
        $stmt = $this->dbConn->prepare($sql);
        $stmt->bindParam(':isbn', $isbn, PDO::PARAM_STR);
        $stmt->bindParam(':firstname', $firstname, PDO::PARAM_STR);
        $stmt->bindParam(':lastname', $lastname, PDO::PARAM_STR);
        $stmt->bindParam(':title', $title, PDO::PARAM_STR);
        $stmt->bindParam(':description', $description, PDO::PARAM_STR);
        return $stmt->execute();
    }

    public function deleteBook($id)
    {
        $sql = "DELETE FROM books WHERE id = :id";
        $stmt = $this->dbConn->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }
}
