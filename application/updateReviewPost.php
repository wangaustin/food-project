<?php
// Refer to conn.php file and open a connection.
require_once("conn.php");
// Will get the value typed in the form text field and save into variable
$var_recipe_id = $_POST['field_recipe_id'];
$var_review_id = $_POST['field_review_id'];
$var_rating = $_POST['field_rating'];
$var_review_details = $_POST['field_review'];

$query = "CALL update_review(:review_id, :rating, :review_details);";

try {
    $prepared_stmt = $dbo->prepare($query);

    $prepared_stmt->bindValue(':review_id', $var_review_id, PDO::PARAM_STR);
    $prepared_stmt->bindValue(':rating', $var_rating, PDO::PARAM_STR);
    $prepared_stmt->bindValue(':review_details', $var_review_details, PDO::PARAM_STR);

    $result = $prepared_stmt->execute();
    $result = $prepared_stmt->fetch();
} catch (PDOException $ex) { // Error in database processing.
    echo $sql . "<br>" . $error->getMessage(); // HTTP 500 - Internal Server Error
}
?>

<html>

<head>
    <!-- THe following is the stylesheet file. The CSS file decides look and feel -->
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
    <p id="light"><?php echo $result[0]; ?></p>
    <p id="light">Review ID <?php echo $var_review_id ?> has been successfully updated.</p>
    <p id="light">Recipe ID: <?php echo $var_recipe_id ?></p>

    <form method="post" action="currentRecipe.php">
        <input type="hidden" name="key" value=<?php echo $var_recipe_id; ?>>
        <input type="submit" value="Return to Recipe">
    </form>

</body>

</html>