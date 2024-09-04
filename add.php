<?php
require_once('Books.php');
include('DbConnect.php');

$conn = new DbConnect();
$dbConnection = $conn->connect();
$instanceBooks = new Books($dbConnection);

if (isset($_POST['add'])) {

    $isbn = $_POST['isbn'];
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $title = $_POST['title'];
    $description = $_POST['description'];


    $instanceBooks->addBook($isbn, $firstname, $lastname, $title, $description);
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Přidání knihy</title>
</head>

<body>
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php">Databáze Knih</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="index.php">Seznam knih</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="look.php">Vyhledávání</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="add.php">Přidej knihu</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container">
        <h2 class="h2">Přidání nové knihy</h2>
        <form action="add.php" method="post">
            <input class="form-control my-2" name="isbn" type="text" placeholder="Zadejte ISBN" required />
            <input class="form-control my-2" name="firstname" type="text" placeholder="Zadejte jméno" required />
            <input class="form-control my-2" name="lastname" type="text" placeholder="Zadejte příjmení" required />
            <input class="form-control my-2" name="title" type="text" placeholder="Zadejte název knihy" required />
            <textarea class="form-control my-2" name="description" placeholder="Zadejte popis knihy" required></textarea>
            <input class="btn btn-primary my-2" type="submit" name="add" value="Vlož knihu" />
        </form>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>