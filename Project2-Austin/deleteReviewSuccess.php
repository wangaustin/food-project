<?php
session_start();
require_once("conn.php");

$var_recipe_name = $_POST['key'];
$var_recipe_id = $_SESSION["session_recipe_id"];
$query = "CALL delete_review(:review_id);";
// $query = "DELETE FROM review WHERE review_id = :review_id;";

try {
    $prepared_stmt = $dbo->prepare($query);
    $prepared_stmt->bindValue(':review_id', $var_recipe_name, PDO::PARAM_STR);
    $prepared_stmt->execute();
    $result = $prepared_stmt->fetch();
} catch (PDOException $ex) { // Error in database processing.
    echo $sql . "<br>" . $error->getMessage(); // HTTP 500 - Internal Server Error
}
?>

<html>

<head>
    <link rel="stylesheet" type="text/css" href="project.css" />
</head>

<body>
    <div id="navbar">
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="getRecipe.php">Search Recipe</a></li>
            <li><a href="insertRecipe.php">Insert Recipe</a></li>
            <li><a href="addAuthor.php">Register</a></li>
        </ul>
    </div>
    <p id="light">Review ID <?php echo $var_recipe_name?> has been successfully deleted.</p>
    <p id="light">Vera: <?php echo $result[0];?></p>
    <form method="post" action="currentReview.php">
        <input type="hidden" name="key" value=<?php echo $var_recipe_id; ?>>
        <input type="submit" value="Return to Recipe">
    </form>

</body>

</html>