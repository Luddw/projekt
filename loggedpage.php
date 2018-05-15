<?php

session_start();
include "../config.php";
$db = new PDO("mysql:host=localhost;dbname={$dbprefix}projektdb;charset=utf8",
    $username, $password);
    $message = "";
    $msg = "";

$loggeduser = $_SESSION['username'];
$date = date("Y-m-d");

if (!isset($_SESSION['username'])) {
    unset($_SESSION['username']);
    header('Location: index.php');

    exit;
}

    if (isset($_POST['send'])) {

        $image = $_FILES['image']['name'];
        $target = "uploads/".basename($image);

        $sql = "INSERT INTO posts (user, posttext, img, postdate) VALUES (:user, :ptext, '$image', '$date')";


        $ps = $db->prepare($sql);



        $ps->bindValue(':user', $loggeduser);
        $ps->bindValue(':ptext', $_POST['textarea']);


        $ps->execute();

        if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
  		$msg = "Image uploaded successfully";

  	    }

        else {
  		$msg = "Failed to upload image";

        }
    }





 ?>
<!DOCTYPE html>
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

<div class="holygrail-body">

<div class="content">

        <div class="usercontrol">

            <div class="content-item-left">

                <form method="post" action="loggedpage.php" enctype="multipart/form-data">

                    <input  type="hidden" name"size" value="1000000">

                        <input type="file" name="image" accept="image/*">


                    <textarea name="textarea" class="postText" maxlength="185" placeholder="Text here..." wrap="softs" rows="5"></textarea>
                    <input type="submit" name="send" value="Post">

                </form>

                <form method="post">
                    <?php
                    if (isset($_POST['logout'])) {
                        # code...

                    unset($_SESSION['username']);
                    header('Location: loggedpage.php');

                    exit;
                    }
                    ?>
                    <input type="submit" name="logout" value="Log out">
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
                  $text = $row['posttext'];
                  $img = $row['img'];
                  $date = $row['postdate'];


                  echo "<div class='posts'>";

                      echo "<div class='textinfo'>";
                          echo "<p>ID:$id User: $user Date:$date</p>";
                      echo "</div>";
                      echo "<hr>";
                      echo "<div class='postcontent'>";
                      echo "<img class='postsimg'src='uploads/$img'>";
                      echo "<br><p class='textPost'>$text</p>";
                      echo "</div>";
                  echo "</div>";



                  echo " <br> <br>  ";
              }


              ?>


          </article>
      </div>
</div>






</div>
<!---<footer class="footer">Footer</footer> --->
</body>
</html>
