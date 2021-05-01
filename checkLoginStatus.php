<?php
    session_start();
    if (isset($_POST['action'])){
        if (!$_SESSION['UserId'] || $_SESSION['UserId']==''){
            print "
            <form action='index.html'><button type='submit'>Sign in</button></form>
            <form action='createAC.html'><button type='submit'>Register</button></form>
            ";
        }
        else{
            print "
            <form action='logout.php'><button type='submit'>Logout</button></form>
            ";
        }
    }
?>