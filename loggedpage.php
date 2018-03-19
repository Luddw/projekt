<?php

session_start();
include "../config.php";
$db = new PDO("mysql:host=localhost;dbname={$dbprefix}projektdb;charset=utf8",
    $username, $password);
    $message = "";

$loggeduser = $_SESSION['username'];


 ?>
<!doctype html>
<html lang="sv">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="css/reset.css">
    <link rel="stylesheet" type="text/css" href="css/theme.css">
    <title>Projekt</title>
</head>


<header class="header">
    <h1>
    <?php
    if (isset($_SESSION['username'])) {
        echo "Hello $loggeduser";
    }
    else {
        $loggeduser = "";
    }
    ?>
    </h1>
</header>
<ul class="navigation">
  <li><a href="#">Home</a></li>
  <li><a href="#">About</a></li>
  <li><a href="#">Products</a></li>
  <li><a href="#">Contact</a></li>
</ul>
<div class="holygrail-body">

<div class="content">

        <div class="usercontrol">



            <div class="content-item-left">

                <form method="post">
                    <textarea name="postText" class="postText" cols="48" rows="4" tabindex="4" wrap="soft">
                    </textarea>
                    <input type="submit" name="send" value="Post">
                </form>

            </div>






        </div>

      <div class="content-bottom">
          <article>
              <?php

              $sql = "SELECT * FROM posts";
              $ps = $db->prepare($sql);
              $ps->execute();

              // Hämta rad-för-rad så länge det finns
              // någon rad att hämta
              while ($row = $ps->fetch()) {
                  $id = $row['postID'];
                  $user = $row['user'];
                  $text = $row['text'];
                  $img = $row['img'];
                  $date = $row['date'];



                  echo "<p>ID:$id User: $user Date: $date </p>";
                  echo "<img src='$img'>";
                  echo " $text ";
              }


              ?>


          </article>
      </div>
</div>






</div>
<footer class="footer">Footer</footer>
</body>
</html>
