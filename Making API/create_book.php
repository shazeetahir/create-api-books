<?php
// Get input data (you should perform proper validation and sanitation)
$title = $_GET['title'];
$authorId = $_GET['Author']; // Use 'Author' as it appears in your URL parameter

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

// Prepare and execute the SQL query to insert the book
$sqlInsertBook = "INSERT INTO books (name, author) VALUES ('$title', $authorId)";
if ($conn->query($sqlInsertBook) === TRUE) {
    // Retrieve the last inserted book
    $lastInsertedId = $conn->insert_id;

    // Prepare and execute the SQL query to get the created book
    $sqlGetBook = "SELECT books.id, books.name AS title, author.id AS author_id, author.name AS author_name
                    FROM books
                    INNER JOIN author ON books.author = author.id
                    WHERE books.id = $lastInsertedId";
    $resultGetBook = $conn->query($sqlGetBook);

    // Fetch the result as JSON
    if ($resultGetBook->num_rows > 0) {
        $row = $resultGetBook->fetch_assoc();
        $bookData = [
            "data" => [
                "id" => $row["id"],
                "type" => "book",
                "title" => $row["title"],
                "author" => [
                    "id" => $row["author_id"],
                    "name" => $row["author_name"]
                ]
            ]
        ];
        echo json_encode($bookData);
    } else {
        echo json_encode(["error" => "Error fetching created book"]);
    }
} else {
    echo json_encode(["error" => "Error creating book"]);
}

$conn->close();


?>
