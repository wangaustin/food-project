<?php
// If the all the variables are set when the Submit button is clicked...
if (isset($_POST['field_submit'])) {
  require_once("conn.php");

  $var_recipe_name = $_POST['field_recipe_id'];
  $var_recipe_limit = $_POST['field_recipe_limit'];
  $var_recipe_filter = $_POST['field_recipe_filter'];
  $var_recipe_order = $_POST['field_recipe_order'];

  if ($var_recipe_filter == "time") {
    $query = "CALL show_by_time(:ph_recipe, :ph_order, :ph_row_limit);";
  } else if ($var_recipe_filter == "calories") {
    $query = "CALL show_by_calories(:ph_recipe, :ph_order, :ph_row_limit);";
  } else {
    $query = "CALL show_by_time(:ph_recipe, :ph_order, :ph_row_limit);";
  }

  try {
    // Create a prepared statement. Prepared statements are a way to eliminate SQL INJECTION.
    $prepared_stmt = $dbo->prepare($query);
    //bind the value saved in the variable $var_recipe_name to the place holder :ph_director  
    // Use PDO::PARAM_STR to sanitize user string.
    $prepared_stmt->bindValue(':ph_recipe', $var_recipe_name, PDO::PARAM_STR);
    $prepared_stmt->bindValue(':ph_row_limit', $var_recipe_limit, PDO::PARAM_STR);
    $prepared_stmt->bindValue(':ph_order', $var_recipe_order, PDO::PARAM_STR);
    $prepared_stmt->execute();
    // Fetch all the values based on query and save that to variable $result
    $result = $prepared_stmt->fetchAll();
  } catch (PDOException $ex) { // Error in database processing.
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
      <li><a href="addAuthor.php">Register</a></li>
    </ul>
  </div>

  <h1>Search Recipe (Keyword)</h1>
  <h4>What magic will you cook today?</h4>

  <form method="post">
    <input type="text" name="field_recipe_id" id="search_bar" placeholder="Search keyword..."
    value="cookies">
    <!-- How many rows? -->
    <select name="field_recipe_limit">
      <option value="-1">All Rows</option>
      <option value="50">50 Rows</option>
      <option value="100">100 Rows</option>
      <option value="500">500 Rows</option>
      <option value="1000">1000 Rows</option>
    </select>
    <!-- Filter by what? -->
    <select name="field_recipe_filter">
      <option value="time">Time</option>
      <option value="calories">Calories</option>
    </select>
    <!-- Order by what? -->
    <select name="field_recipe_order">
      <option value="0">Descend</option>
      <option value="1">Ascend</option>
    </select>

    <br>
    <br>
    <input type="submit" name="field_submit" value="Submit">
    <!-- SEARCH BY AUTHOR INSTEAD -->
  </form>


  <form method="post" action="getRecipeByAuthor.php">
    <input type="submit" name="indiv_recipe" value="Search by Author Instead">
  </form>

  <form method="post" action="topRecipes.php">
    <input type="submit" name="indiv_recipe" value="Top Recipes">
  </form>


  <?php
  if (isset($_POST['field_submit'])) {
  ?>
    <h2>Results</h2>

    <body id="light">You searched for: "<?php echo $var_recipe_name ?>"</body><br>
    <body id="light">Limit is: "<?php echo $var_recipe_limit ?>"</body><br>
    <body id="light">Filter is: "<?php echo $var_recipe_filter ?>"</body><br>
    <body id="light">Order is: "<?php echo $var_recipe_order ?>"</body><br>

    <?php
    if ($result && $prepared_stmt->rowCount() > 0) { ?>
      <!-- first show the header RESULT -->
      <?php $query_count = $prepared_stmt->rowCount(); ?>

      <body>Row count: <?php echo $query_count; ?></body>
      <p><br></p>
      <!-- THen create a table like structure. See the project.css how table is stylized. -->
      <table style="width:60%">
        <!-- Create the first row of table as table head (thead). -->
        <thead>
          <!-- The top row is table head with four columns named -- ID, Title ... -->
          <tr>
            <th>Recipe ID</th>
            <th>Recipe Name</th>
            <th>Date Published</th>
            <th>Calories</th>
            <th>Details</th>
            <th>Reviews</th>
            <th>Delete</th>
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
              <td><?php echo $row["calories"]; ?></td>
              <td>
                <form method="post" action="currentRecipe.php">
                  <input type="hidden" name="key" value=<?php echo $row["recipe_id"]; ?>>
                  <input type="submit" name="indiv_recipe" value="View">
                </form>
              </td>
              <td>
                <form method="post" action="currentReview.php">
                  <input type="hidden" name="key" value=<?php echo $row["recipe_id"]; ?>>
                  <input type="submit" name="indiv_recipe" value="Reviews">
                </form>
              </td>
              <td>
                <form method="post" action="deleteRecipe.php">
                  <input type="hidden" name="key" value=<?php echo $row["recipe_id"]; ?>>
                  <input type="submit" name="indiv_recipe" value="Delete">
                </form>
              </td>
              <!-- End first row. Note this will repeat for each row in the $result variable-->
            </tr>
          <?php } ?>
          <!-- End table body -->
        </tbody>
        <!-- End table -->
      </table>
      <br>
      <p>(End of data)</p>
      <br>
      <br>

    <?php } else { ?>
      <!-- IF query execution resulted in error display the following message-->
      <h3>Sorry, no results found for recipe "<?php echo $_POST['field_recipe_id']; ?>". </h3>
  <?php }
  } ?>
</body>

</html>