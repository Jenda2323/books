<?php
require_once('Books.php');
include('DbConnect.php');

$conn = new DbConnect();
$dbConnection = $conn->connect();
$instanceBooks = new Books($dbConnection);

$selBooks = [];

if ((isset($_GET['lastname']) && $_GET['lastname'] != "") ||
    (isset($_GET['firstname']) && $_GET['firstname'] != "") ||
    (isset($_GET['title']) && $_GET['title'] != "") ||
    (isset($_GET['isbn']) && $_GET['isbn'] != "")
) {

    $selLastname = $_GET['lastname'];
    $selFirstname = $_GET['firstname'];
    $selTitle = $_GET['title'];
    $selIsbn = $_GET['isbn'];

    $selBooks = $instanceBooks->filterBooks($selLastname, $selFirstname, $selTitle, $selIsbn);
}
if (isset($_GET['delete'])) {
    $bookId = $_GET['delete'];
    $instanceBooks->deleteBook($bookId);
    header("Location: look.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vyhledávání</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        @font-face {
            font-family: "pacifico";
            src: url("./Pacifico.ttf");
        }

        @font-face {
            font-family: "caveat";
            src: url("./Caveat.ttf");

        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background-color: #f4f1ea;
            color: #333;
        }

        h2 {
            font-family: "pacifico";
        }

        .navbar {
            background-color: #5a3e2b;

            color: black !important;
            font-family: "pacifico";

        }

        a.nav-link:hover {
            font-weight: bold !important;

        }

        .container-fluid {
            background-color: #d4c2a5;
        }

        .table {
            background-color: #fff;
            border: 1px solid #ccc;
            margin: 20px auto;
            width: 95%;
            text-align: center;
            vertical-align: middle;
            font-family: monospace;
            font-weight: bolder;
        }

        .table th {
            background-color: #f4e3d7;
            color: #5a3e2b;
        }

        .table td {
            border: 1px solid #ddd;
        }

        .btn-danger {
            background-color: #9c3b30;
            border: none;
        }

        .btn-danger:hover {
            background-color: #ba4b3c;
        }
    </style>
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
                        <a class="nav-link " aria-current="page" href="index.php">Seznam knih</a>
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
        <h2 class="h2">Vyhledávání</h2>
        <p></p>
        <form action="look.php" method="get">
            <input class="form-control my-2" name="lastname" type="text" placeholder="Zadejte příjmení autora" />
            <input class="form-control my-2" name="firstname" type="text" placeholder="Zadejte jméno autora" />
            <input class="form-control my-2" name="title" type="text" placeholder="Zadejte název knihy" />
            <input class="form-control my-2" name="isbn" type="text" placeholder="Zadejte ISBN" />
            <input class="btn btn-primary my-2" type="submit" value="Vyhledat" />
        </form>

        <!-- Zobrazení výsledků pouze pokud proběhlo vyhledávání -->
        <?php if (!empty($selBooks)) : ?>
            <h3>Výsledky hledání</h3>
            <table class="table">
                <tr>
                    <th>ID</th>
                    <th>ISBN</th>
                    <th>Jméno</th>
                    <th>Příjmení</th>
                    <th>Název knihy</th>
                    <th>Popis</th>
                    <th>Akce</th>
                </tr>
                <?php foreach ($selBooks as $book) : ?>
                    <tr>
                        <td><?php echo htmlspecialchars($book['id']); ?></td>
                        <td><?php echo htmlspecialchars($book['isbn']); ?></td>
                        <td><?php echo htmlspecialchars($book['firstname']); ?></td>
                        <td><?php echo htmlspecialchars($book['lastname']); ?></td>
                        <td><?php echo htmlspecialchars($book['title']); ?></td>
                        <td><?php echo htmlspecialchars($book['description']); ?></td>
                        <td>
                            <a class="btn btn-danger" href="look.php?delete=<?php echo $book['id']; ?>" onclick="return confirm('Opravdu chcete smazat tuto knihu?');">Smazat</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>
        <?php elseif ($_SERVER['REQUEST_METHOD'] == 'GET' && (isset($_GET['lastname']) || isset($_GET['firstname']) || isset($_GET['title']) || isset($_GET['isbn']))) : ?>
            <p>Žádné knihy nebyly nalezeny.</p>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>