<?php

session_start();
include "../config.php";
$db = new PDO("mysql:host=localhost;dbname={$dbprefix}projektdb;charset=utf8",
    $username, $password);
    $message = "";
    $msg = "";
$loggeduser = $_SESSION['username'];
$timezone = date_default_timezone_get();
$date = date('m/d/Y h:i:s a', time());
    if (isset($_POST['send'])) {
        // path to store the uploaded image
        $target = "uploads/".basename($_FILES['file']['name']);

        // image data
        $image = $_FILES['file']['name'];

        $sql = "INSERT INTO posts (user, posttext, img, postdate) VALUES (:user, :ptext, '$image', '$date')";
        mysqli_query($db, $sql);


        if (move_uploaded_file($_FILES['file']['tmp_name'], $target))
        {
            $msg = "Image Uploaded success";
        }
        else {
            $msg = "Image Upload Failed";
        }


        echo "$sql";
        echo "<br>$msg";
        $ps = $db->prepare($sql);





        $ps->bindValue(':user', $loggeduser);
        $ps->bindValue(':ptext', $_POST['textarea']);

        $ps->execute();
    }





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
  <li><a href="#">1</a></li>
  <li><a href="#">2</a></li>
  <li><a href="#">3</a></li>
  <li><a href="#">4</a></li>
</ul>
<div class="holygrail-body">

<div class="content">

        <div class="usercontrol">



            <div class="content-item-left">

                <form method="post" action="index.php" enctype="multipart/form-data">
                    <input type="hidden" name="size" value="1000000">
                    <div>
                        <input type="file" name="file">
                    </div>
                </form>

                <form method="post">
                    <textarea name="textarea" class="postText" cols="48" rows="4" wrap="soft">
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
                  $text = $row['posttext'];
                  $img = $row['img'];
                  $date = $row['postdate'];



                  echo "<p>ID:$id User: $user Date: $date </p>";
                  echo "<img src='$img'>";
                  echo " $text ";
                  echo " <br> <br> <br> ";
              }


              ?>


          </article>
      </div>
</div>






</div>
<footer class="footer">Footer</footer>
</body>
</html>
