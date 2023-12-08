<?php

// Connect to the database (replace these variables with your actual database credentials)
$servername = "localhost:3306";
$username = "root";
$password = "rootroot";
$dbname = "library";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Set the default order parameter
$order = isset($_GET['order']) && ($_GET['order'] == 'author' || $_GET['order'] == 'title') ? $_GET['order'] : 'title';

// Prepare and execute the SQL query
$sql = "SELECT books.id, books.name AS title, author.id AS author_id, author.name AS author_name
        FROM books
        INNER JOIN author ON books.author = author.id
        ORDER BY $order";

$result = $conn->query($sql);

// Fetch the result as JSON
if ($result->num_rows > 0) {
    $booksData = ["data" => []];
    while ($row = $result->fetch_assoc()) {
        $booksData["data"][] = [
            "id" => $row["id"],
            "type" => "book",
            "title" => $row["title"],
            "author" => [
                "id" => $row["author_id"],
                "name" => $row["author_name"]
            ]
        ];
    }
    echo json_encode($booksData);
} else {
    echo json_encode(["error" => "No books found"]);
}

$conn->close();
?>
