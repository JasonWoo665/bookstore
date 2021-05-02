<?php
    session_start();
    if (isset($_POST['action'])){
        if (!$_SESSION['UserId'] || $_SESSION['UserId']==''){
            print "
            <button type='button' onclick='displayController(1)'>Sign in</button>
            <button type='button' onclick='displayController(0)'>Register</button>
            ";
        }
        else{
            print "
            <form action='logout.php'><button type='submit'>Logout</button></form>
            ";
        }
    }
?>