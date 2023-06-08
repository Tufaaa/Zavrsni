<?php 
include ('header.php'); 

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "blog";

try {
    $connection = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo $e->getMessage();
}

if (isset($_GET['id'])) {
    $postId = $_GET['id'];

$sql = "SELECT * FROM posts WHERE id = $postId";
$statement = $connection->prepare($sql);
$statement->execute();
$post = $statement->fetch(PDO::FETCH_ASSOC);

if ($post) {
    ?>
        <h2><?php echo $post['title']; ?></h2>
        <p><?php echo $post['body']; ?></p>
        <p>Author: <?php echo $post['author']; ?></p>
        <p>Created at: <?php echo $post['created_at']; ?></p>
    

<h3>Comments</h3>
    <?php

$sql = "SELECT * FROM comments WHERE post_id = :post_id";
$statement = $connection->prepare($sql);
$statement->bindParam(':post_id', $postId);
$statement->execute();
$comments = $statement->fetchAll(PDO::FETCH_ASSOC);

if ($comments) {
    ?>
    <ul>
    <?php
    foreach ($comments as $comment) {
    ?>
        <li>
            <p>Author: <?php echo $comment['author']; ?></p>
            <p><?php echo $comment['text']; ?></p>
            <hr>
        </li>
    <?php
    }
    ?>
    </ul>
    <?php
} else {
    echo "Nema komentara.";
}
} else {
    echo "Post nije pronadjen.";
}
} else {
    echo "Greska.";
}

include ('sidebar.php');
include ('footer.php');
?>