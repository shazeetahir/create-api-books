<?php

$endpoint = $_SERVER['REQUEST_URI'];

// Remove query parameters from the endpoint
$endpoint = strtok($endpoint, '?');

// Extract the book ID from the endpoint
$pattern = '/\/API-ME\/get_book.php\/(\d+)/';
if (preg_match($pattern, $endpoint, $matches)) {
    $bookId = $matches[1];
} else {
    // Handle the case where the book ID is not found in the endpoint
    http_response_code(400); // Bad Request
    echo json_encode(["error" => "Book ID not specified"]);
    exit; // Stop further execution
}

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

// Prepare and execute the SQL query
$sql = "SELECT books.id, books.name AS title, author.id AS author_id, author.name AS author_name
        FROM books
        INNER JOIN author ON books.author = author.id
        WHERE books.id = $bookId";
$result = $conn->query($sql);

// Fetch the result as JSON
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
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
    echo json_encode(["error" => "Book not found"]);
}

$conn->close();


?>