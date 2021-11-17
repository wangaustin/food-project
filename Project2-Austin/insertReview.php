<?php
if (isset($_POST['field_submit'])) {

    require_once("conn.php");

    $var_recipe_id = $_POST['field_recipe_id'];
    $var_author_id = $_POST['field_author_id'];
    $var_rating = $_POST['field_rating'];
    $var_review = $_POST['field_review'];

    $query = "CALL add_review(:recipe_id, :author_id, :rating, :review);";

    try {
        $prepared_stmt = $dbo->prepare($query);
        $prepared_stmt->bindValue(':recipe_id', $_POST['key'], PDO::PARAM_STR);
        $prepared_stmt->bindValue(':author_id', $var_author_id, PDO::PARAM_STR);
        $prepared_stmt->bindValue(':rating', $var_rating, PDO::PARAM_STR);
        $prepared_stmt->bindValue(':review', $car_review, PDO::PARAM_STR);
        $result = $prepared_stmt->execute();
    } catch (PDOException $ex) { // Error in database processing.
        echo $sql . "<br>" . $error->getMessage(); // HTTP 500 - Internal Server Error
    }
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
            <li><a href="deleteRecipe.php">Delete Recipe</a></li>
            <li><a href="showRecipe.php">All Recipe</a></li>
        </ul>
    </div>

    <h1>Insert Review</h1>

    <form method="post">
        <hr style="width:50%">
        <h2>Review Details</h2>
        <?php $var_recipe_id1 = $_POST['key']; ?>
        <p>Recipe ID: <?php echo $_POST['key']; ?> </p>
        <p>Author ID: <?php echo $_POST['field_author_id']; ?> </p>
        <p>Rating: <?php echo $_POST['field_rating']; ?> </p>
        <p>Review: <?php echo $_POST['field_review']; ?> </p>
        <input type="hidden" name="field_author_id" value=<?php echo $var_recipe_id1; ?>>
        <input type="text" name="field_author_id" placeholder="Reviewer ID..." required>
        <br><br>
        <input type="text" name="field_rating" placeholder="Rating..." required>
        <br><br>
        <input type="text" name="field_review" placeholder="Write review here..." value="">
        <br><br>
        <input type="submit" name="field_submit" value="Submit">
    </form>
    <?php
    if (isset($_POST['field_submit'])) {
        if ($result) {
    ?>
            Review was inserted successfully.
        <?php
        } else {
        ?>
            <h3> Sorry, there was an error. Review data was not inserted. </h3>
    <?php
        }
    }
    ?>



</body>

</html>