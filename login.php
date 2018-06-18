<?php

    session_start();
    echo "logged in";
    if($_SESSION['email'])
    {
        echo "you are logged in";
    }

?>