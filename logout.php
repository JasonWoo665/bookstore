<?php
    session_start();
    session_unset();
    echo "<p> Logging out</p>";
    header("refresh:3;url=main.html");
?>