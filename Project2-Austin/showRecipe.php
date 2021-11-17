<?php
// If the all the variables are set when the Submit button is clicked...

// /****************************/
// /****************************/
// in stored procedure, we can just pass selection of order
// /****************************/
// /****************************/
if (isset($_POST['field_submit_recent'])||isset($_POST['field_submit_old'])) {
    // Refer to conn.php file and open a connection.
    require_once("conn.php");
    if (isset($_POST['field_submit_old'])) {
      // CALL(date_published, asc)
      $query = "SELECT * FROM recipe_mega ORDER BY date_published ASC LIMIT 50";
    }
    else if (isset($_POST['field_submit_recent'])) {
      // CALL(date_published, desc)
      $query = "SELECT * FROM recipe_mega ORDER BY date_published DESC LIMIT 50";
    }
    else {
      // CALL(recipe_id, desc)
      $query = "SELECT * FROM recipe_mega ORDER BY recipe_id DESC LIMIT 50";
    }
    // Save the query into variable called $query. Note that :ph_director is a place holder


try
    {
      // Create a prepared statement. Prepared statements are a way to eliminate SQL INJECTION.
      $prepared_stmt = $dbo->prepare($query);
      //bind the value saved in the variable $var_director to the place holder :ph_director  
      // Use PDO::PARAM_STR to sanitize user string.
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
    
    <h1>Show All Recipes</h1>
    <p>By default, only the first 50 entries are shown.</p>
    <!-- This is the start of the form. This form has one text field and one button.
      See the project.css file to note how form is stylized.-->
    <p>Order by ...</p>
    <form method="post">
      <input type="submit" name="field_submit_recent" value="Most Recent">
      <input type="submit" name="field_submit_old" value="Oldest">
    </form>
    
    <?php
      if (isset($_POST['field_submit_recent'])||isset($_POST['field_submit_old'])) {
        // If the query executed (result is true) and the row count returned from the query is greater than 0 then...
        if ($result && $prepared_stmt->rowCount() > 0) { ?>
              <!-- first show the header RESULT -->
              <h2>Results</h2>
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
                    <th>More Info</th>
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
          <h3>Sorry, no results found for director <?php echo $_POST['field_director']; ?>. </h3>
        <?php }
    } ?>


    
  </body>
</html>






