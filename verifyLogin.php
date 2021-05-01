<?php

#Source: www.zentut.com/php-tutorial/php-session/
#A simple login example
#lectur slide 08, p.76

session_start();

#Set the access counter
if (isset($_SESSION['counter'])) {
    $_SESSION['counter'] += 1;
} else {
    $_SESSION['counter'] = 1;
}

// $fname = $_POST['fname'];
// $fpassword = $_POST['fpassword'];

$fname = '';
$fpassword = '';
if (isset($_POST['fsubmit'])){
    if (authenticate()) {
        
        // remove temp carts given to session if any
        if ($_SESSION['cartID'] && $_SESSION['cartID']!=''){
            $conn=mysqli_connect('sophia.cs.hku.hk', 'chwoo', 'jasonxd0211', 'chwoo') or die ('Error! '.mysqli_connect_error($conn));
            foreach ($_SESSION['cartID'] as $key => $value){
                $del_val = $value;
                if (($key = array_search($del_val, $_SESSION['cartID'])) !== false) {
                    unset($_SESSION['cartID'][$key]);
                    // also remove it from database
                    $query = "DELETE FROM cartNotLoggedIn WHERE CartId='".$del_val."'";
                    if (!mysqli_query($conn, $query)) {
                        header("location: createAC.html");
                    }
                }
            }
            mysqli_close($conn); 
        }
        
        // save the result to session
        $_SESSION['UserId'] = $_POST['fname'];
        //redirect to main page
        header("location: main.html");
    }
    else{
        // fail to login
        ?>
        <h1 class="error">
            <?php echo 'Invalid login, please login again' ?>
        </h1>
        <?php
        header("refresh:3;url=index.html");
    }
} else if ($_POST['action'] == 'testing'){
    print var_dump(session_id()).'with value'.var_dump($_SESSION);
}

function authenticate() {
    global $fname,$fpassword;


    global $fname,$fpassword;
    $fname = $_POST['fname'];
    $fpassword = $_POST['fpassword'];
    if (isset($_POST['fname']) && isset($_POST['fpassword'])) {
        //check if database already have it
        // open the database
        $conn=mysqli_connect('sophia.cs.hku.hk', 'chwoo', 'jasonxd0211', 'chwoo') or die ('Error! '.mysqli_connect_error($conn));
        $query = "SELECT * FROM login WHERE UserId = '$fname'";
        $result = mysqli_query($conn, $query) or die ('Failed to query '.mysqli_error($conn));
        
        if (mysqli_num_rows($result) > 0) { //account exists
            //check if password correct
            $row=mysqli_fetch_array($result);
            if ($fname==$row['UserId'] && $fpassword==$row['PW']){
                // session_write_close(); //free session lock
                mysqli_free_result($result);
                mysqli_close($conn);
                return true; // correct pw
            }
            else{
                mysqli_free_result($result);
                mysqli_close($conn);
                return false; // wrong pw
            }
        }
        else{ // doesn't match any result
            mysqli_free_result($result);
            mysqli_close($conn);  
            return false;
        }
    }

    // if (isset($_SESSION['fname'])) { //if already authenticated
    //     return true;
    // }

}

?>