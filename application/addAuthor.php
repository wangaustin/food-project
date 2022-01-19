<?php

if (isset($_POST['f_submit'])) {

    require_once("conn.php");

    $var_author = $_POST['author_name'];
    $query = "CALL add_author(:ph_author);";

    try
    {
      $prepared_stmt = $dbo->prepare($query);
      $prepared_stmt->bindValue(':ph_author', $var_author, PDO::PARAM_STR);
      $result = $prepared_stmt->execute();
      $result = $prepared_stmt->fetch();

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
        <li><a href="addAuthor.php">Register</a></li>
      </ul>
    </div>

<h1>Register</h1>

    <form method="post">
    	<input type="text" name="author_name" id="author_name" placeholder="Your name..."> 
    	<br>
    	<input type="submit" name="f_submit" value="Submit">
    </form>
    <?php
      if (isset($_POST['f_submit'])) {
        if ($result) { 
    ?>
    <body id="light">
        <?php echo $var_author; ?> was successfully added.
    </body>
    <br>
    <p id="light"></p><?php echo $result[0]; ?><?php 
    } else { 
    ?>
          <h3 id="light"> Sorry, there was an error. '<?php echo $_POST['author_name']; ?>' was not inserted. </h3>
    <?php 
        }
      } 
    ?>


    
  </body>
</html>