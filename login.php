<?php
    session_start();
    
    $connection = @new mysqli("localhost", "root", "", "recipes");
    
    if ($connection->connect_errno == 0)
    {        
        $sql = "SELECT * FROM users Where username='".$_POST['username']."'"."AND password='".hash('sha256', $_POST['password'])."'";

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
                unset($_SESSION['connectionFault']);
                header('Location: index.php');
            }
        }

    }
    else
    {
        $_SESSION['logFail'] = TRUE;
        $_SESSION['connectionFault'] = TRUE;
        header('Location: index.php');
    }

?>