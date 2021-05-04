<?php
    session_start();

$cname = '';
$cpassword = '';
if (isset($_POST['csubmit'])){
    if (checkCreate()) { // account didn't exist
        //redirect to main page after 3sec
        ?>
        <h1 class="congrat7head">
            <?php echo 'Account created! Welcome' ?>
        </h1>
        <?php
        header("refresh:3;url=index.html?login=true");
    }
    else{ //account existed already
        //redirect to main page after 3sec
        ?>
        <h1 class="congrat7head">
            <?php echo 'Account already existed' ?>
        </h1>
        <?php
        header("refresh:3;url=index.html?create=true");
    }
}
else if ($_POST['action'] == 'fastcsubmit'){
    if (checkCreate()){
        print "success";
    }
    else{
        print "NOTsuccess";
    }
}
else if ($_POST['action'] == 'checkcsubmit'){
    if (checkFCreate()){
        print "success";
    }
    else{
        print "NOTsuccess";
    }
}
function checkFCreate() {
    global $cname,$cpassword;
    $cname = $_POST['cname'];
    if (isset($_POST['cname'])) {
        //check if database already have it
        // open the database
        $conn=mysqli_connect('sophia.cs.hku.hk', 'chwoo', 'jasonxd0211', 'chwoo') or die ('Error! '.mysqli_connect_error($conn));
        $query = "SELECT * FROM login WHERE UserId = '$cname'";
        $result = mysqli_query($conn, $query) or die ('Failed to query '.mysqli_error($conn));
        
        if (mysqli_num_rows($result) > 0) { //result already exists
            mysqli_free_result($result);
            mysqli_close($conn); 
            return false;
        }
        else{ //save the result(ac name and pw) to database
            mysqli_free_result($result);
            mysqli_close($conn); 
            return true;
        }  
        // close database 
    }
}

function checkCreate() {
    global $cname,$cpassword;
    $cname = $_POST['cname'];
    $cpassword = $_POST['cpassword'];
    if (isset($_POST['cname']) && isset($_POST['cpassword'])) {
        //check if database already have it
        // open the database
        $conn=mysqli_connect('sophia.cs.hku.hk', 'chwoo', 'jasonxd0211', 'chwoo') or die ('Error! '.mysqli_connect_error($conn));
        $query = "SELECT * FROM login WHERE UserId = '$cname'";
        $result = mysqli_query($conn, $query) or die ('Failed to query '.mysqli_error($conn));
        
        if (mysqli_num_rows($result) > 0) { //result already exists
            mysqli_free_result($result);
            mysqli_close($conn); 
            return false;
        }
        else{ //save the result(ac name and pw) to database
            $query="INSERT INTO login (UserID, PW) VALUES ('$cname', '$cpassword')";
            if (!mysqli_query($conn, $query)) {
                ?>
                <p class="addnewac">
                    <?php echo 'Error insert!!'.mysqli_error($conn) ?>
                </p>
                <?php
            }
            else{
                mysqli_free_result($result);
                mysqli_close($conn); 
                return true;
            }
        }  
        // close database 
    }
}

?>