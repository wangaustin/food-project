<?php
// Refer to conn.php file and open a connection.
require_once("conn.php");
// Will get the value typed in the form text field and save into variable
$var_recipe_name = $_POST['key'];
// Save the query into variable called $query. Note that :ph_director is a place holder
$query = "SELECT * FROM review WHERE review_id = :review_id;";

try {
    // Create a prepared statement. Prepared statements are a way to eliminate SQL INJECTION.
    $prepared_stmt = $dbo->prepare($query);
    //bind the value saved in the variable $var_recipe_name to the place holder :ph_director  
    // Use PDO::PARAM_STR to sanitize user string.
    $prepared_stmt->bindValue(':review_id', $var_recipe_name, PDO::PARAM_STR);
    $prepared_stmt->execute();
    // Fetch all the values based on query and save that to variable $result
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
    <h1>Update Review</h1>
    <br><br>

    <form method="post" action="currentReview.php">
        <input type="hidden" name="key" value=<?php echo $result["recipe_id"]; ?>>
        <input type="submit" name="add_review" value="Reviews">
    </form>

    

    <form method="POST" action="updateReviewPost.php">
        <table style="width:40%">
            <thead>
                <th>Key</th>
                <th>Value</th>
                <th>New Value</th>
            </thead>
            <tbody>
                <tr>
                    <th scope="row">Review ID</th>
                    <td><?php echo $result["review_id"]; ?></td>
                    <td>N/A</td>
                    <input type="hidden" name="field_recipe_id" value=<?php echo $result["recipe_id"]; ?>>
                    <input type="hidden" name="field_review_id" value=<?php echo $result["review_id"]; ?>>
                </tr>
                <tr>
                    <th scope="row">Author ID</th>
                    <td><?php echo $result["author_id"]; ?></td>
                    <td>N/A</td>
                </tr>
                <tr>
                    <th scope="row">Rating</th>
                    <td><?php echo $result["rating"]; ?></td>
                    <td><input type="range" name="field_rating" min="0" max="5" required></td>
                </tr>
                <tr>
                    <th scope="row">Review Details</th>
                    <td><?php echo $result["review"]; ?></td>
                    <td><input type="text" name="field_review"
                    id="nogap"
                    value="<?php echo $result["review"]; ?>""></td>
                </tr>
                <tr>
                    <th scope="row">Date Submitted</th>
                    <td><?php echo $result["date_submitted"]; ?></td>
                    <td>N/A</td>
                </tr>
                <tr>
                    <th scope="row">Date Modified</th>
                    <td><?php echo $result["date_modified"]; ?></td>
                    <td>N/A</td>
                </tr>

            </tbody>
        </table>
        <br><br>
        <input type="submit" name="field_submit" value="Update">
    </form>
    <br>
    <p id="light">(End of data)</p>
    <br>
    <br>
</body>

</html>