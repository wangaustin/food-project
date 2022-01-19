<!-- GETTING RECIPE ID FROM PREV PAGE BUT ONCE SUBMITTED DATA GOES AWAY -->
<!-- something wrong with $_POST/$_GET -->
<?php
session_start();

if (isset($_POST['field_submit'])) {

    require_once("conn.php");

    $var_recipe_id = $_SESSION["session_recipe_id"];
    $var_author_id = $_POST['field_author_id'];
    $var_rating = $_POST['field_rating'];
    $var_review = $_POST['field_review'];

    $query = "CALL add_review(:recipe_id, :author_id, :rating, :review);";

    try {
        $prepared_stmt = $dbo->prepare($query);
        $prepared_stmt->bindValue(':recipe_id', $var_recipe_id, PDO::PARAM_STR);
        $prepared_stmt->bindValue(':author_id', $var_author_id, PDO::PARAM_STR);
        $prepared_stmt->bindValue(':rating', $var_rating, PDO::PARAM_STR);
        $prepared_stmt->bindValue(':review', $var_review, PDO::PARAM_STR);
        $prepared_stmt->execute();
        $result = $prepared_stmt->fetch();
    } catch (PDOException $ex) { // Error in database processing.
        echo $sql . "<br>" . $error->getMessage(); // HTTP 500 - Internal Server Error
    }
}
?>

<html>

<head>
    <!-- The following is the stylesheet file. The CSS file decides look and feel -->
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

    <h1>Insert Review</h1>
    <?php
    if (isset($_POST['field_submit'])) {
        if ($result) {
    ?>
            <p id="light"><?php echo $result[0]; ?></p>
        <?php
        } else {
        ?>
            <h3 id="light">Sorry, there was an error. Review data was not inserted.</h3>
    <?php
        }
    }
    ?>
    <form method="post">
        <hr style="width:50%">
        <h2>Review Details</h2>
        <h3 id="light">Rating</h3>
        <input type="range" name="field_rating" min="0" max="5" value="4" required>
        <br><br>
        <input type="text" name="field_author_id" placeholder="Author ID..." required>
        <br><br>
        <input type="text" name="field_review" placeholder="Write review here..." value="">
        <br><br>
        <input type="submit" name="field_submit" value="Submit">
    </form>

    <form method="post" action="currentReview.php">
        <input type="hidden" name="key" value=<?php echo $_SESSION["session_recipe_id"]; ?>>
        <input type="submit" name="event_return_to_review" value="Return to Reviews">
    </form>

    <br><br>



</body>

</html>