<?php
/*


// Define the base path of your application
// $basePath = '/API-ME';

// Retrieve the HTTP method and endpoint from the request
$httpMethod = $_SERVER['REQUEST_METHOD'];
$endpoint = $_SERVER['REQUEST_URI'];

// Remove query parameters from the endpoint
$endpoint = strtok($endpoint, '?');

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

// Define your routes and corresponding functions
$routes = [
    'GET /books' => 'getBooks',
    'GET /books/(\d+)' => 'getBook',
    'POST /books' => 'createBook',
    'GET /author/(\w+)/books' => 'getAuthorBooks',
];

// Find a matching route for the current request
$matchedRoute = null;
foreach ($routes as $route => $function) {
    $pattern = str_replace('/', '\/', $route); // Convert / to \/ for regex

    // var_dump($pattern);

    if (preg_match("/^$pattern$/", "$httpMethod $endpoint", $matches)) {
        $matchedRoute = $route;
        break;
    }
}
// var_dump($routes);
var_dump($matchedRoute);



// If a matching route is found, call the corresponding function
if ($matchedRoute) {
    $function = $routes[$matchedRoute];
    call_user_func_array($function, $matches);
} else {
    // Handle 404 Not Found
    http_response_code(404);
    echo 'Not Found';
}





// Close the database connection
$conn->close();



function getBooks($conn)
{
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
}

function getBook($conn, $bookId)
{
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
}

function createBook($conn)
{
    // Implement the logic for creating a book
    $title = $_POST['title']; // Assuming the title is sent via POST
    $authorId = $_POST['author']; // Assuming the author ID is sent via POST

    // Prepare and execute the SQL query
    $sql = "INSERT INTO books (name, author) VALUES ('$title', $authorId)";
    if ($conn->query($sql) === TRUE) {
        // Retrieve the last inserted book
        $lastInsertedId = $conn->insert_id;
        getBook($conn, $lastInsertedId); // Reuse the getBook function to fetch and return the created book
    } else {
        echo json_encode(["error" => "Error creating book"]);
    }
}

function getAuthorBooks($conn, $authorName)
{
    $authorName = strtolower(str_replace(' ', '_', $authorName));

    // Get input data (you should perform proper validation and sanitation)
    $order = isset($_GET['order']) && ($_GET['order'] == 'id' || $_GET['order'] == 'title') ? $_GET['order'] : 'title';

    // Prepare and execute the SQL query
    $sql = "SELECT books.id, books.name AS title
            FROM books
            INNER JOIN author ON books.author = author.id
            WHERE author.name = '$authorName'
            ORDER BY $order";

    $result = $conn->query($sql);

    // Fetch the result as JSON
    if ($result->num_rows > 0) {
        $booksData = ["data" => []];
        while ($row = $result->fetch_assoc()) {
            $booksData["data"][] = [
                "id" => $row["id"],
                "type" => "book",
                "title" => $row["title"]
            ];
        }
        echo json_encode($booksData);
    } else {
        echo json_encode(["error" => "No books found for the author"]);
    }
}

*/
?>
