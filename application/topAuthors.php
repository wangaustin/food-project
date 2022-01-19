<?php
  require_once("conn.php");

  $query = "SELECT * FROM top_author;";

  try {
    // Create a prepared statement. Prepared statements are a way to eliminate SQL INJECTION.
    $prepared_stmt = $dbo->prepare($query);
    //bind the value saved in the variable $var_recipe_name to the place holder :ph_director  
    // Use PDO::PARAM_STR to sanitize user string.
    $prepared_stmt->execute();
    // Fetch all the values based on query and save that to variable $result
    $result = $prepared_stmt->fetchAll();
  } catch (PDOException $ex) { // Error in database processing.
    echo $sql . "<br>" . $error->getMessage(); // HTTP 500 - Internal Server Error
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
      <li><a href="addAuthor.php">Register</a></li>
    </ul>
  </div>

  <h1>Top Authors</h1>
  <table style="width:60%">
        <!-- Create the first row of table as table head (thead). -->
        <thead>
          <!-- The top row is table head with four columns named -- ID, Title ... -->
          <tr>
            <th>Author Name</th>
            <th>Number of Recipes</th>
            <th>Average Rating</th>
          </tr>
        </thead>
        <!-- Create rest of the the body of the table -->
        <tbody>
          <!-- For each row saved in the $result variable ... -->
          <?php foreach ($result as $row) { ?>
            <tr>
              <!-- Print (echo) the value of mID in first column of table -->
              <td><?php echo $row["author_name"]; ?></td>
              <!-- Print (echo) the value of title in second column of table -->
              <td><?php echo $row["number_of_recipes"]; ?></td>
              <!-- Print (echo) the value of movieYear in third column of table and so on... -->
              <td><?php echo $row["average_rating"]; ?></td>
              <!-- End first row. Note this will repeat for each row in the $result variable-->
            </tr>
          <?php } ?>
          <!-- End table body -->
        </tbody>
        <!-- End table -->
      </table>
      <br><br>
</body>

</html>