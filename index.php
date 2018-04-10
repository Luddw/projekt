<?php
session_start();
include "../config.php";
$db = new PDO("mysql:host=localhost;dbname={$dbprefix}projektdb;charset=utf8",
    $username, $password);
    $message = "";
    $password = "";
    $username = "";
    $email = "";


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

    if (isset($_POST['signup']))
    {
        if(isset($_POST['name']) && !empty($_POST['name']) AND isset($_POST['password']) && !empty($_POST[password])
        AND isset($_POST['email']) && !empty($_POST['email']))
        {
            if ($_POST['password'] == $_POST['passwordconf'])
            {
                $name = mysql_escape_string($_POST['name']);
                $password = mysql_escape_string($_POST['password']);
                $email = mysql_escape_string($_POST['email']);

                if(!eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $email)) {
                // Error - Invalid mail
                $msg = 'The email you have entered is invalid, please try again.';
                }
                else {
                // Success - Valid mail
                $msg = 'Your account has been made, <br> please verify it by clicking the activation link that has been send to your email.';
                }

            }
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
    <?php
        if (isset($msg)) {
            echo $msg;
        }
    ?>
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
                    <input type='submit' name='login' value='Log in'>
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
                    <p>
                        Password Confirm:
                        <input type='password' name='passwordconf' placeholder="Password (again)">
                    </p>

                    <p>
                        E-mail:
                        <input type='text' name='email' placeholder="E-mail">
                    </p>
                </div>
                      <br>
                      <input type='submit' name='signup' value='Sign up'>
            </form>

    </div>


</body>
</html>
