<?php
session_start();
require_once("conn.php");

$var_recipe_name = $_POST['key'];
$_SESSION["session_recipe_id"] = $var_recipe_name;
$query = "CALL show_reviews(:ph_recipe);";

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
    <h1>Reviews</h1>
    <form method="post" action="insertReview.php">
        <input type="hidden" name="key" value=<?php echo $var_recipe_name; ?>>
        <input type="submit" name="add_review" value="Add Review">
    </form>

    <form method="post" action="currentRecipe.php">
        <input type="hidden" name="key" value=<?php echo $var_recipe_name; ?>>
        <input type="submit" name="add_review" value="Return to Recipe">
    </form>
    <br><br>

    <table style="width:60%">
        <thead>
            <tr>
                <th>Review ID</th>
                <th>Author ID</th>
                <th>Author Name</th>
                <th>Rating</th>
                <th>Review</th>
                <th>Date Submitted</th>
                <th>Date Modified</th>
                <th>Details</th>
                <th>Delete</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($result as $row) { ?>
                <tr>
                    <td><?php echo $row["review_id"]; ?></td>
                    <td><?php echo $row["author_id"]; ?></td>
                    <td><?php echo $row["author_name"]; ?></td>
                    <td><?php echo $row["rating"]; ?></td>
                    <td><?php echo $row["review"]; ?></td>
                    <td><?php echo $row["date_submitted"]; ?></td>
                    <td><?php echo $row["date_modified"]; ?></td>
                    <td>
                        <form method="post" action="updateReview.php">
                            <input type="hidden" name="key" value=<?php echo $row["review_id"]; ?>>
                            <input type="submit" name="field_update" value="View">
                        </form>
                    </td>
                    <td>
                        <form method="post" action="deleteReviewSuccess.php">
                            <input type="hidden" name="key" value=<?php echo $row["review_id"]; ?>>
                            <input type="submit" name="field_delete" value="Delete">
                        </form>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
    <br>
    <p id="light">(End of data)</p>
    <br>
    <br>
</body>

</html>