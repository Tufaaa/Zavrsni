<?php 
include ('header.php');

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "blog";

try {
    $connection = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e){
    echo $e->getMessage();
}

$sql = "SELECT * FROM posts ORDER BY created_at DESC";
$statement = $connection->prepare($sql);
$statement->execute();
$posts = $statement->fetchALL(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $title = $_POST['title'];
    $body = $_POST['body'];
    $author = $_POST['author'];
    $created_at = $_POST['created_at'];
  
    $sql = "insert into posts (title, body, author, created_at,) values ('{$title}', '{$body}', '{$author}', '{$created_at}')";
    $statement = $connection->prepare($sql);
    $statement->execute();
}

if ($posts) {
    foreach ($posts as $post) {
    ?>
        <h2><?php echo $post['title']; ?></h2>
        <p><?php echo $post['body']; ?></p>
        <p>Author: <?php echo $post['author']; ?></p>
        <p>Created at: <?php echo $post['created_at']; ?></p>
    <?php
    }
} else {
?>
    <p>Post nije pronadjen.</p>
<?php
}
    include ('sidebar.php');
    include ('footer.php');
?>   