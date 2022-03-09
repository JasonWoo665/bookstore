<?php
    session_start();
    if ($_POST['showCart'] == 'all') {
        // produce content for different books chosen by a person
        // get all (book id, quantity) set from database

        $returnString = "";
        $loopcount = 0;
        $conn=mysqli_connect('sophia.cs.hku.hk', 'username', 'password', 'username') or die ('Error! '.mysqli_connect_error($conn));
        foreach ($_SESSION['cartID'] as $key => $value){
            // select one cart of the user            SELECT * FROM book WHERE BookId = (SELECT BookId FROM cart WHERE CartId = 90)
            $loopcount+=1;
            $DesiredCartID = $value;
            if ($_SESSION['UserId'] && $_SESSION['UserId']!=''){
                $query = "SELECT * FROM cart WHERE CartId = '$DesiredCartID'";
            }
            else{
                $query = "SELECT * FROM cartNotLoggedIn WHERE CartId = '$DesiredCartID'";
            }
            $result = mysqli_query($conn, $query) or die ('Failed to query '.mysqli_error($conn));
            // manipulate each cart's information
            while ($row = mysqli_fetch_array($result)){
                $BookId = $row['BookId'];
                $Quantity = $row['Quantity'];
                mysqli_free_result($result);
                // search book name for the particular book id
                $query = "SELECT * FROM book WHERE BookId = '$BookId'";
                $result = mysqli_query($conn, $query) or die ('Failed to query '.mysqli_error($conn));
                $row = mysqli_fetch_array($result);
                $BookName = $row['BookName'];
    
                $returnString .= "<div id='DesiredCartID-".$DesiredCartID."'>
                                    <p class='BookName'> Book Name: ".$BookName."</p> 
                                    <p class='Quan'> Quantity: ".$Quantity."</p>
                                    <button id='deletebutt' onclick='deleteItem(".$DesiredCartID.")'>Delete</button>
                                    </div>
                                ";
            }
        }
        //compile the text for javascript        
        mysqli_free_result($result);
        mysqli_close($conn);   
        print $returnString;
        // print var_dump($_SESSION).'something';
    } else if ($_POST['action'] == 'delete'){
        $returnmsg = '';
        $del_val = $_POST['deleteid'];
        if (($key = array_search($del_val, $_SESSION['cartID'])) !== false) {
            unset($_SESSION['cartID'][$key]);
            // also remove it from database
            $conn=mysqli_connect('sophia.cs.hku.hk', 'username', 'password', 'username') or die ('Error! '.mysqli_connect_error($conn));
            if ($_SESSION['UserId'] && $_SESSION['UserId']!=''){
                $query = "DELETE FROM cart WHERE CartId='".$del_val."'";
            }
            else{
                $query = "DELETE FROM cartNotLoggedIn WHERE CartId='".$del_val."'";
            }
            if (mysqli_query($conn, $query)) {
                $returnmsg .= $query;
            }
            mysqli_close($conn); 
        }
        
        print $returnmsg.':'.var_dump($_SESSION['cartID']);
    } else if ($_POST['action'] == 'testing'){
        print var_dump(session_id()).'with value'.var_dump($_SESSION);
    } else if ($_POST['action'] == 'getcost'){
        $sum=0;
        $dubugger = '';
        $conn=mysqli_connect('sophia.cs.hku.hk', 'username', 'password', 'username') or die ('Error! '.mysqli_connect_error($conn));
        foreach ($_SESSION['cartID'] as $key => $value){
            // select one cart of the user
            $DesiredCartID = $value;
            if ($_SESSION['UserId'] && $_SESSION['UserId']!=''){
                $query = "SELECT * FROM cart WHERE CartId = '$DesiredCartID'";
                $result = mysqli_query($conn, $query) or die (print "SELECT * FROM cart WHERE CartId = '$DesiredCartID'".mysqli_error($conn));
            }
            else{
                $query = "SELECT * FROM cartNotLoggedIn WHERE CartId = '$DesiredCartID'";
                $result = mysqli_query($conn, $query) or die (print "SELECT * FROM cartNotLoggedIn WHERE CartId = '$DesiredCartID'".mysqli_error($conn));
            }
            // manipulate each cart's information
            $row = mysqli_fetch_array($result);
            $BookId = $row['BookId'];
            $Quantity = $row['Quantity'];
            mysqli_free_result($result);
            // search book name for the particular book id
            $query = "SELECT * FROM book WHERE BookId = '$BookId'";
            $result = mysqli_query($conn, $query) or die ('Failed to query 2'.mysqli_error($conn));
            $row = mysqli_fetch_array($result);
            $Price = $row['Price'];
            // calculate the sum of total cost
            $sum += ((int)$Quantity) * ((int)$Price);
            $dubugger .= '+'.$Quantity.'*'.$Price.'+';
            mysqli_free_result($result);
        }
        mysqli_close($conn); 
        print '$'.$sum;
    } 
?>