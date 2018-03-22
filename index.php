<?php
session_start();
include "../config.php";
$db = new PDO("mysql:host=localhost;dbname={$dbprefix}projektdb;charset=utf8",
    $username, $password);
    $message = "";


    if (isset($_POST['login'])) {
        $username = htmlspecialchars($_POST['username'], ENT_QUOTES);
        $password = htmlspecialchars($_POST['password'], ENT_QUOTES);

        $sql = "SELECT * FROM user
            WHERE username=:username AND password=:password";

            $ps = $db->prepare($sql);
            $ps->bindValue(':username', $username);
            $ps->bindValue(':password', $password);
            $ps->execute();

        if ($ps->fetch())
        {
            $_SESSION['username'] = $username;
            header('Location: loggedpage.php');

            exit;
        }
    }
?>

<!DOCTYPE html>
<html lang='sv'>
<head>
    <title>Log In</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="css/reset.css">
    <link rel="stylesheet" type="text/css" href="css/logtheme.css">
</head>

<body>
    <div class="flex-container">

        <form class='flex-item' method='post'>
              <div class='logText'>
                  <p>
                      Username:
                      <input type='text' name='username' placeholder="Username">
                  </p>

                  <p>
                      Password:
                      <input type='password' name='password' placeholder="Password">
                  </p>
              </div>
                    <br>
                    <input type='submit' name='login' value='Logga in'>
          </form>

          <form class='flex-item' method='post'>
                <div class='logText'>
                    <p>
                        Username:
                        <input type='text' name='username' placeholder="Username">
                    </p>

                    <p>
                        Password:
                        <input type='password' name='password' placeholder="Password">
                    </p>
                </div>
                      <br>
                      <input type='submit' name='login' value='Logga in'>
            </form>

    </div>


</body>
</html>
