<?php
// Refer to conn.php file and open a connection.
require_once("conn.php");
// Will get the value typed in the form text field and save into variable
$var_recipe_name = $_POST['key'];
// Save the query into variable called $query. Note that :ph_director is a place holder
$query = "SELECT * FROM recipe_mega WHERE recipe_id = :ph_recipe;";

try {
    // Create a prepared statement. Prepared statements are a way to eliminate SQL INJECTION.
    $prepared_stmt = $dbo->prepare($query);
    //bind the value saved in the variable $var_recipe_name to the place holder :ph_director  
    // Use PDO::PARAM_STR to sanitize user string.
    $prepared_stmt->bindValue(':ph_recipe', $var_recipe_name, PDO::PARAM_STR);
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
            <li><a href="deleteRecipe.php">Delete Recipe</a></li>
            <li><a href="showRecipe.php">All Recipe</a></li>
        </ul>
    </div>
    <h1><?php echo $result["recipe_name"]; ?></h1>
    <h4>This looks delicious!</h4>
    <p>Experiment table</p>
    <table style="width:40%">
        <thead>
            <th>Key</th>
            <th>Value</th>
        </thead>
        <tbody>
            <tr>
                <th scope="row">Recipe ID</th>
                <td><?php echo $result["recipe_id"]; ?></td>
            </tr>
            <tr>
                <th scope="row">Recipe Name</th>
                <td><?php echo $result["recipe_name"]; ?></td>
            </tr>
            <tr>
                <th scope="row">Author ID</th>
                <td><?php echo $result["author_id"]; ?></td>
            </tr>
            <tr>
                <th scope="row">Author Name</th>
                <td><?php echo $result["author_name"]; ?></td>
            </tr>
            <tr>
                <th scope="row">Cook Time</th>
                <td><?php echo $result["cook_time"]; ?></td>
            </tr>
            <tr>
                <th scope="row">Prep Time</th>
                <td><?php echo $result["prep_time"]; ?></td>
            </tr>
                        <tr>
                <th scope="row">Total Time</th>
                <td><?php echo $result["total_time"]; ?></td>
            </tr>
            <tr>
                <th scope="row">Details</th>
                <td><?php echo $result["recipe_description"]; ?></td>
            </tr>
            <tr>
                <th scope="row">Recipe Servings</th>
                <td><?php echo $result["recipe_servings"]; ?></td>
            </tr>
            <tr>
                <th scope="row">Recipe Yield</th>
                <td><?php echo $result["recipe_yield"]; ?></td>
            </tr>
            <tr>
                <th scope="row">Instructions</th>
                <td><?php echo $result["recipe_instructions"]; ?></td>
            </tr>
            <tr>
                <th scope="row">Date Published</th>
                <td><?php echo $result["date_published"]; ?></td>
            </tr>
            <tr>
                <th scope="row">Image URL</th>
                <td><?php echo $result["image_url"]; ?></td>
            </tr>
            <tr>
                <th scope="row">Category</th>
                <td><?php echo $result["recipe_category"]; ?></td>
            </tr>
            <tr>
                <th scope="row">Keywords</th>
                <td><?php echo $result["keywords"]; ?></td>
            </tr>
            <tr>
                <th scope="row">Ingredient Quantity</th>
                <td><?php echo $result["recipe_ingredient_quantity"]; ?></td>
            </tr>
            <tr>
                <th scope="row">Ingredient Parts</th>
                <td><?php echo $result["recipe_ingredient_parts"]; ?></td>
            </tr>
            <tr>
                <th scope="row">Aggregated Rating</th>
                <td><?php echo $result["aggregated_rating"]; ?></td>
            </tr>
            <tr>
                <th scope="row">Review Count</th>
                <td><?php echo $result["review_count"]; ?></td>
            </tr>
            <tr>
                <th scope="row">Calories</th>
                <td><?php echo $result["calories"]; ?></td>
            </tr>
            <tr>
                <th scope="row">Fat</th>
                <td><?php echo $result["fat_content"]; ?></td>
            </tr>
            <tr>
                <th scope="row">Saturated Fat</th>
                <td><?php echo $result["saturated_fat"]; ?></td>
            </tr>
            <tr>
                <th scope="row">Cholesterol</th>
                <td><?php echo $result["cholesterol"]; ?></td>
            </tr>
            <tr>
                <th scope="row">Sodium</th>
                <td><?php echo $result["sodium"]; ?></td>
            </tr>
            <tr>
                <th scope="row">Carbohydrate</th>
                <td><?php echo $result["carbohydrate"]; ?></td>
            </tr>
            <tr>
                <th scope="row">Fiber</th>
                <td><?php echo $result["fiber"]; ?></td>
            </tr>
            <tr>
                <th scope="row">Sugar</th>
                <td><?php echo $result["sugar"]; ?></td>
            </tr>
            <tr>
                <th scope="row">Protein</th>
                <td><?php echo $result["protein"]; ?></td>
            </tr>
        </tbody>
    </table>
    <br>


    <p>Below is the default table.</p>
    <table style="width:60%">
        <thead>
            <tr>
                <th>Recipe ID</th>
                <th>Recipe Name</th>
                <th>Author ID</th>
                <th>Author Name</th>
                <th>Cook Time</th>
                <th>Prep Time</th>
                <th>Details</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><?php echo $result["recipe_id"]; ?></td>
                <td><strong><?php echo $result["recipe_name"]; ?></strong></td>
                <td><?php echo $result["author_id"]; ?></td>
                <td><?php echo $result["author_name"]; ?></td>
                <td><?php echo $result["cook_time"]; ?></td>
                <td><?php echo $result["prep_time"]; ?></td>
                <td><?php echo $result["recipe_description"]; ?></td>
            </tr>
        </tbody>
    </table>
</body>

</html>