<?php
session_start();
include "../config.php";
$db = new PDO("mysql:host=localhost;dbname={$dbprefix}projektdb;charset=utf8",
    $username, $password);
    $message = "";
    $password = "";
    $username = "";
    $email = "";
    $name = "";


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
        if(strlen($_POST['username']) > 0 && strlen($_POST['password']) > 0 && strlen($_POST['email']) > 0)
        {
            echo "success success success success success success success success success success success ";
            if ($_POST['password'] == $_POST['passwordconf'])
            {



                if(filter_var($_POST['email'] , FILTER_VALIDATE_EMAIL)) {
                // Error - Invalid mail
                echo 'Your account has been made, <br> please verify it by clicking the activation link that has been send to your email.';

                $to = 'kingboo8@hotmail.com';
                $subject = 'E-mail Verification';
                $message = '
                Thanks for signing up!
                Your account has been created

                Account info:
                ------------------------
                Username: '.$name.'
                Password: '.$password.'
                ------------------------

                Please click this link to activate your account:
                https://www.google.se/
                '; // Our message above including the link
                    // http://www.yourwebsite.com/verify.php?email='.$email.'&hash='.$hash.'
                $headers = 'From:noreply@luddw.com' . "\r\n";
                mail($to, $subject, $message, $headers);







                }
                else {
                // Success - Valid mail
                echo 'The email you have entered is invalid, please try again.';

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
