<?php
    session_start();

    require_once "db_connect_data.php";

    $connection = @new mysqli("localhost", $db_user, $db_passwd, $db_name);
    
    if ($connection->connect_errno == 0)
    {
        $login = $_POST['login'];
        $password = hash('sha256', $_POST['password']);
        
        $sql = "SELECT * FROM users Where username='$login' AND password='$password'";

        if($result = @$connection->query($sql))
        {
            $count = $result->num_rows;
            if($count>0)
            {
                $user_data = $result->fetch_assoc();
                $result->free();
                $_SESSION['username'] = $user_data['username'];

                unset($_SESSION['logFail']);
                $_SESSION['logged'] = TRUE;
                header('Location: site.php');
            }
            else
            {
                $_SESSION['logFail'] = TRUE;
                $_SESSION['connectionFault'] = FALSE;
                header('Location: index.php');
            }
        }

        $connection->close();
    }
    else
    {
        $_SESSION['logFail'] = TRUE;
        $_SESSION['connectionFault'] = TRUE;
        header('Location: index.php');
    }

?>