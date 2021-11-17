<?php
// Refer to conn.php file and open a connection.
require_once("conn.php");
// Will get the value typed in the form text field and save into variable
$var_recipe_name = $_POST['key'];
// Save the query into variable called $query. Note that :ph_director is a place holder
$query = "CALL show_reviews(:ph_recipe);";

try {
    // Create a prepared statement. Prepared statements are a way to eliminate SQL INJECTION.
    $prepared_stmt = $dbo->prepare($query);
    //bind the value saved in the variable $var_recipe_name to the place holder :ph_director  
    // Use PDO::PARAM_STR to sanitize user string.
    $prepared_stmt->bindValue(':ph_recipe', $var_recipe_name, PDO::PARAM_STR);
    $prepared_stmt->execute();
    // Fetch all the values based on query and save that to variable $result
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
            <li><a href="deleteRecipe.php">Delete Recipe</a></li>
            <li><a href="showRecipe.php">All Recipe</a></li>
        </ul>
    </div>
    <h1><?php echo $result["recipe_id"]; ?></h1>
    <h4>This is the review page.</h4>
    <form method="post" action="insertReview.php">
        <input type="hidden" name="key" value=<?php echo $var_recipe_name; ?>>
        <input type="submit" name="add_review" value="Add Review">
        <br><br>
        <!-- SEARCH BY AUTHOR INSTEAD -->
    </form>
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
                </tr>
            <?php } ?>
        </tbody>
    </table>
    <br>
    <p>(End of data)</p>
    <br>
    <br>
</body>

</html>