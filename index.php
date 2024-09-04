<?php
require_once('Books.php');
include('DbConnect.php');

$conn = new DbConnect();
$dbConnection = $conn->connect();
$instanceBooks = new Books($dbConnection);
$books = $instanceBooks->getBooks();

if (isset($_GET['lastname']) || isset($_GET['firstname']) || isset($_GET['title']) || isset($_GET['isbn'])) {
    $selLastname = $_GET['lastname'];
    $selFirstname = $_GET['firstname'];
    $selTitle = $_GET['title'];
    $selIsbn = $_GET['isbn'];


    $selBooks = $instanceBooks->filterBooks($selLastname, $selFirstname, $selTitle, $selIsbn);
} else {
    $selBooks = $books;
}
if (isset($_GET['delete'])) {
    $bookId = $_GET['delete'];
    $instanceBooks->deleteBook($bookId);
    header("Location: index.php");
    exit();
}

?>

</html>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Books</title>
   
    
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

    <?php
    if (sizeof($selBooks) > 0) {

    ?>
        <table class="table my-2">
            <tr>
                <th>ID</th>
                <th>ISBN</th>
                <th>Jméno</th> 
                <th>Příjmení</th>
                <th>Název knihy</th>
                <th>Popis</th>
                <th>Akce</th> 
            </tr>
            <?php foreach ($selBooks as $book): ?>
                <tr>
                    <td><?php echo htmlspecialchars($book['id']); ?></td>
                    <td><?php echo htmlspecialchars($book['isbn']); ?></td>
                    <td><?php echo htmlspecialchars($book['firstname']); ?></td>
                    <td><?php echo htmlspecialchars($book['lastname']); ?></td>
                    <td><?php echo htmlspecialchars($book['title']); ?></td>
                    <td><?php echo htmlspecialchars($book['description']); ?></td>
                    <td>
                        <a class="btn btn-danger" href="index.php?delete=<?php echo urlencode($book['id']); ?>" onclick="return confirm('Opravdu chcete smazat tuto knihu?');">Smazat</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php
    } else { ?>
        <p>Žádné knihy k zobrazení</p>
    <?php
    }
    ?>

    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>