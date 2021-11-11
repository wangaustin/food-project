<?php
// If the all the variables are set when the Submit button is clicked...
if (isset($_POST['field_submit'])) {
    // Refer to conn.php file and open a connection.
    require_once("conn.php");
    // Will get the value typed in the form text field and save into variable
    $var_recipe_name = $_POST['field_recipe_id'];
    // Save the query into variable called $query. Note that :ph_director is a place holder
    $query = "SELECT * FROM recipe_mega WHERE recipe_name LIKE CONCAT('%', :ph_recipe, '%');";
   
    try
    {
      // Create a prepared statement. Prepared statements are a way to eliminate SQL INJECTION.
      $prepared_stmt = $dbo->prepare($query);
      //bind the value saved in the variable $var_recipe_name to the place holder :ph_director  
      // Use PDO::PARAM_STR to sanitize user string.
      $prepared_stmt->bindValue(':ph_recipe', $var_recipe_name, PDO::PARAM_STR);
      $prepared_stmt->execute();
      // Fetch all the values based on query and save that to variable $result
      $result = $prepared_stmt->fetchAll();
    }
    catch (PDOException $ex)
    { // Error in database processing.
      echo $sql . "<br>" . $error->getMessage(); // HTTP 500 - Internal Server Error
    }
}
?>

<html>
<!-- Any thing inside the HEAD tags are not visible on page.-->
  <head>
    <!-- THe following is the stylesheet file. The CSS file decides look and feel -->
    <link rel="stylesheet" type="text/css" href="project.css" />
  </head> 
<!-- Everything inside the BODY tags are visible on page.-->
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
    
    <h1>Search Recipe</h1>
    <h4>What magic will you cook today?</h4>
    <!-- This is the start of the form. This form has one text field and one button.
      See the project.css file to note how form is stylized.-->
    <form method="post">
      <!-- The input type is a text field. Note the name and id. The name attribute
        is referred above on line 7. $var_director = $_POST['field_director']; id attribute is referred in label tag above on line 52-->
      <input type="text" name="field_recipe_id" id = "id_recipe" placeholder = "Search...">
      <br>
      <!-- The input type is a submit button. Note the name and value. The value attribute decides what will be dispalyed on Button. In this case the button shows Submit.
      The name attribute is referred  on line 3 and line 61. -->
      <input type="submit" name="field_submit" value="Submit">
    </form>
    <?php
      if (isset($_POST['field_submit'])) {
        ?><body>You searched for: "<?php echo $var_recipe_name ?>"</body><br><?php
        // If the query executed (result is true) and the row count returned from the query is greater than 0 then...

        if ($result && $prepared_stmt->rowCount() > 0) { ?>
              <!-- first show the header RESULT -->
              <h2>Results</h2>
              <?php $query_count = $prepared_stmt->rowCount(); ?>
              <body>Row count: <?php echo $query_count; ?> </body>
              <br>
                <!-- THen create a table like structure. See the project.css how table is stylized. -->
                <table style="width:60%">
                    <!-- Create the first row of table as table head (thead). -->
                    <thead>
                      <!-- The top row is table head with four columns named -- ID, Title ... -->
                      <tr>
                        <th>Recipe ID</th>
                        <th>Recipe Name</th>
                        <th>Date Published</th>
                        <th>Author Name</th>
                        <th>Details</th>
                      </tr>
                    </thead>
                    <!-- Create rest of the the body of the table -->
                    <tbody>
                      <!-- For each row saved in the $result variable ... -->
                      <?php foreach ($result as $row) { ?>
                        <tr>
                          <!-- Print (echo) the value of mID in first column of table -->
                          <td><?php echo $row["recipe_id"]; ?></td>
                          <!-- Print (echo) the value of title in second column of table -->
                          <td><strong><?php echo $row["recipe_name"]; ?></strong></td>
                          <!-- Print (echo) the value of movieYear in third column of table and so on... -->
                          <td><?php echo $row["date_published"]; ?></td>
                          <td><?php echo $row["author_name"]; ?></td>
                          <td>
                            <form method="post" action="currentRecipe.php">
                              <input type="hidden" name="key" value=<?php echo $row["recipe_id"]; ?>>
                              <input type="submit" name="indiv_recipe" value="View">
                            </form>
                          </td>
                        <!-- End first row. Note this will repeat for each row in the $result variable-->
                        </tr>
                      <?php } ?>
                      <!-- End table body -->
                    </tbody>
                    <!-- End table -->
                </table>
  
        <?php } else { ?>
          <!-- IF query execution resulted in error display the following message-->
          <h3>Sorry, no results found for recipe "<?php echo $_POST['field_recipe_id']; ?>". </h3>
        <?php }
    } ?>


    
  </body>
</html>






