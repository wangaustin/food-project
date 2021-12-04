<?php
// Refer to conn.php file and open a connection.
require_once("conn.php");
// Will get the value typed in the form text field and save into variable
$var_recipe_id = $_POST['field_recipe_id'];
$var_cook_time = $_POST['field_cook_time'];
$var_prep_time = $_POST['field_prep_time'];
$var_total_time = $_POST['field_total_time'];
$var_recipe_desc = $_POST['field_recipe_desc'];
$var_recipe_servings = $_POST['field_recipe_servings'];
$var_recipe_yield = $_POST['field_recipe_yield'];
$var_recipe_instructions = $_POST['field_recipe_instruction'];
$var_image_url = $_POST['field_image_url'];
$var_recipe_category = $_POST['field_recipe_category'];
$var_keywords = $_POST['field_keywords'];
$var_recipe_ingredient_quantity = $_POST['field_recipe_ingredient_quantity'];
$var_recipe_ingredient_parts = $_POST['field_recipe_ingredient_parts'];
$var_calories = $_POST['field_calories'];
$var_fat_content = $_POST['field_fat_content'];
$var_saturated_fat = $_POST['field_saturated_fat'];
$var_cholesterol = $_POST['field_cholesterol'];
$var_sodium = $_POST['field_sodium'];
$var_carbohydrate = $_POST['field_carbohydrate'];
$var_fiber = $_POST['field_fiber'];
$var_sugar = $_POST['field_sugar'];
$var_protein = $_POST['field_protein'];


// Save the query into variable called $query. Note that :ph_director is a place holder
$query = "CALL update_recipe(:recipe_id, :cook_time, :prep_time, :total_time, :recipe_desc,
                             :image_url, :recipe_category, :keywords, :recipe_ingredient_quantity,
                             :recipe_ingredient_parts, :calories, :fat_content, :saturated_fat,
                             :cholesterol, :sodium, :carbohydrate, :fiber, :sugar, :protein,
                             :recipe_servings, :recipe_yield, :recipe_instructions);";

try {
    $prepared_stmt = $dbo->prepare($query);

    $prepared_stmt->bindValue(':recipe_id', $var_recipe_id, PDO::PARAM_STR);
    $prepared_stmt->bindValue(':cook_time', $var_cook_time, PDO::PARAM_STR);
    $prepared_stmt->bindValue(':prep_time', $var_prep_time, PDO::PARAM_STR);
    $prepared_stmt->bindValue(':total_time', $var_total_time, PDO::PARAM_STR);
    $prepared_stmt->bindValue(':recipe_desc', $var_recipe_desc, PDO::PARAM_STR);
    $prepared_stmt->bindValue(':image_url', $var_image_url, PDO::PARAM_STR);
    $prepared_stmt->bindValue(':recipe_category', $var_recipe_category, PDO::PARAM_STR);
    $prepared_stmt->bindValue(':keywords', $var_keywords, PDO::PARAM_STR);
    $prepared_stmt->bindValue(':recipe_ingredient_quantity', $var_recipe_ingredient_quantity, PDO::PARAM_STR);
    $prepared_stmt->bindValue(':recipe_ingredient_parts', $var_recipe_ingredient_parts, PDO::PARAM_STR);
    $prepared_stmt->bindValue(':calories', $var_calories, PDO::PARAM_STR);
    $prepared_stmt->bindValue(':fat_content', $var_fat_content, PDO::PARAM_STR);
    $prepared_stmt->bindValue(':saturated_fat', $var_saturated_fat, PDO::PARAM_STR);
    $prepared_stmt->bindValue(':cholesterol', $var_cholesterol, PDO::PARAM_STR);
    $prepared_stmt->bindValue(':sodium', $var_sodium, PDO::PARAM_STR);
    $prepared_stmt->bindValue(':carbohydrate', $var_carbohydrate, PDO::PARAM_STR);
    $prepared_stmt->bindValue(':fiber', $var_fiber, PDO::PARAM_STR);
    $prepared_stmt->bindValue(':sugar', $var_sugar, PDO::PARAM_STR);
    $prepared_stmt->bindValue(':protein', $var_protein, PDO::PARAM_STR);
    $prepared_stmt->bindValue(':recipe_servings', $var_recipe_servings, PDO::PARAM_STR);
    $prepared_stmt->bindValue(':recipe_yield', $var_recipe_yield, PDO::PARAM_STR);
    $prepared_stmt->bindValue(':recipe_instructions', $var_recipe_instructions, PDO::PARAM_STR);
    
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
    <p id="light">Vera: <?php echo $result[0];?></p>
    
    <p id="light">Austin: Recipe ID <?php echo $var_recipe_id?> has been successfully updated.</p>
</body>

</html>