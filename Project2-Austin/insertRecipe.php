<?php

if (isset($_POST['field_submit'])) {

    require_once("conn.php");

    $var_recipe_name = $_POST['field_recipe_name'];
    $var_author_id = $_POST['field_author_id'];
    $var_recipe_desc = $_POST['field_recipe_desc'];
    $var_cook_time = $_POST['field_cook_time'];
    $var_prep_time = $_POST['field_prep_time'];
    $var_total_time = $_POST['field_total_time'];
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
    $var_recipe_servings = $_POST['field_recipe_servings'];
    $var_recipe_yield = $_POST['field_recipe_yield'];
    $var_recipe_instructions = $_POST['field_recipe_instruction'];

    // 23 attributes
    // cook_time SOMETHING WRONG HERE!!!!
    $query = "CALL add_recipe(:recipe_name, :author_id, :cook_time, :prep_time, :total_time,
                              :recipe_desc, :image_url, :recipe_category, :keywords,
                              :recipe_ingredient_quantity, :recipe_ingredient_parts,
                              :calories, :fat_content, :saturated_fat, :cholesterol,
                              :sodium, :carbohydrate, :fiber, :sugar, :protein,
                              :recipe_servings, :recipe_yield, :recipe_instructions);";

    try
    {
      $prepared_stmt = $dbo->prepare($query);
      $prepared_stmt->bindValue(':recipe_name', $var_recipe_name, PDO::PARAM_STR);
      $prepared_stmt->bindValue(':author_id', $var_author_id, PDO::PARAM_STR);
      $prepared_stmt->bindValue(':recipe_desc', $var_recipe_desc, PDO::PARAM_STR);
      $prepared_stmt->bindValue(':cook_time', $var_cook_time, PDO::PARAM_STR);
      $prepared_stmt->bindValue(':prep_time', $var_prep_time, PDO::PARAM_STR);
      $prepared_stmt->bindValue(':total_time', $var_total_time, PDO::PARAM_STR);
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

    }
    catch (PDOException $ex)
    { // Error in database processing.
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

<h1>Insert Recipe</h1>

    <form method="post">
      <hr style="width:50%">
      <h2>Recipe Description</h2>
    	<input type="text" name="field_recipe_name" placeholder="Recipe name..." required> 
      <br><br>
    	<input type="text" name="field_author_id" placeholder="Author ID..." required>
      <br><br>
    	<input type="text" name="field_recipe_desc" placeholder="Recipe description..." required>
      <br><br>
      <input type="text" name="field_recipe_category" placeholder="Recipe category..." value="">
      <br><br>
      <input type="text" name="field_keywords" placeholder="Keywords..." value="">
      <br><br>
      <input type="text" name="field_cook_time" placeholder="Cook time..." value="">
      <br><br>
      <input type="text" name="field_prep_time" placeholder="Preparation time..." value="">
      <br><br>
      <input type="text" name="field_total_time" placeholder="Total time..." value="">
      <br><br>
      <input type="text" name="field_recipe_ingredient_quantity" placeholder="Recipe ingredient quantity..." value="">
      <br><br>
      <input type="text" name="field_recipe_ingredient_parts" placeholder="Recipe ingredient parts..." value="">
      <br><br>
      <input type="text" name="field_recipe_yield" placeholder="Recipe yield..." value="">
      <br><br>
      <input type="text" name="field_recipe_instructions" placeholder="Recipe instructions..." value="">
      <br><br>
      <input type="text" name="field_image_url" placeholder="Image URL..." value="">
      <br><br>
      <hr style="width:50%">
      <h2>Nutritional Information</h2>
      <label for="id_recipe_servings">Recipe Serving</label>
      <input type="text" name="field_recipe_servings" id="id_recipe_servings" placeholder="Recipe servings..." value=0>
      <br><br>
      <label for="id_calories">Calories</label>
      <input type="text" name="field_calories" id="id_calories" placeholder="Calories..." value=0>
      <br><br>
      <label for="id_fat_content">Fat Content</label>
      <input type="text" name="field_fat_content" id="id_fat_content" placeholder="Fat content..." value=0>
      <br><br>
      <label for="id_saturated_fat">Saturated Fat</label>
      <input type="text" name="field_saturated_fat" id="id_saturated_fat" placeholder="Saturated fat..." value=0>
      <br><br>
      <label for="id_cholesterol">Cholesterol</label>
      <input type="text" name="field_cholesterol" id="id_cholesterol" placeholder="Cholesterol..." value=0>
      <br><br>
      <label for="id_sodium">Sodium</label>
      <input type="text" name="field_sodium" id="id_sodium" placeholder="Sodium..." value=0>
      <br><br>
      <label for="id_carbohydrate">Carbohydrate</label>
      <input type="text" name="field_carbohydrate" id="carbohydrate" placeholder="Carbohydrate..." value=0>
      <br><br>
      <label for="id_fiber">Fiber</label>
      <input type="text" name="field_fiber" id="id_fiber" placeholder="Fiber..." value=0>
      <br><br>
      <label for="id_sugar">Sugar</label>
      <input type="text" name="field_sugar" id="id_sugar" placeholder="Sugar..." value=0>
      <br><br>
      <label for="id_protein">Protein</label>
      <input type="text" name="field_protein" id="id_protein" placeholder="Protein..." value=0>
      <br><br>
      <input type="submit" name="field_submit" value="Submit">
    

    </form>
    <?php
      if (isset($_POST['field_submit'])) {
        if ($result) { 
    ?>
          Movie data was inserted successfully.
    <?php 
        } else { 
    ?>
          <h3> Sorry, there was an error. Recipe data was not inserted. </h3>
    <?php 
        }
      } 
    ?>


    
  </body>
</html>