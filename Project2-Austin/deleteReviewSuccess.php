<?php
// Refer to conn.php file and open a connection.
require_once("conn.php");
// Will get the value typed in the form text field and save into variable
$var_recipe_name = $_POST['key'];
// Save the query into variable called $query. Note that :ph_director is a place holder
$query = "CALL delete_review(:ph_recipe);";
$query = "DELETE from review WHERE review_id = :ph_recipe;";

try {
    $prepared_stmt = $dbo->prepare($query);
    $prepared_stmt->bindValue(':ph_recipe', $var_recipe_name, PDO::PARAM_STR);
    $prepared_stmt->execute();
    $result = $prepared_stmt->fetchAll();
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
</body>

</html>