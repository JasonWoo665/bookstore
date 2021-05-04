<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        #yorder{
            border-top: solid;
            border-color: grey;
        }

    </style>
    <script src="main.js"></script>
</head>
<body>
        
    <section>
        <!-- special handler in create.php is needed -->
        <?php
            if (!$_SESSION['UserId'] || $_SESSION['UserId']==''){
                echo "<form name='ADCForm' action='invoicePage.php' method='post' onsubmit='return validateFCForm()'>";
            }else{
                echo  "<form name='ADCForm' action='invoicePage.php' method='post' onsubmit='return validateFCFormLGED()'>";
            }
        ?>
            <?php
                if (!$_SESSION['UserId']){
                    echo "
                    <h1>I'm a new customer&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;I'm already a customer</h1>
                    <p>Please Checkout Below&nbsp;&nbsp;&nbsp;&nbsp;or &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href='index.html?login=yes'>Sign In </a></p>
                    <h1>Creatae Account: </h1>
                    <label for='fcname'>Username</label>
                    <input type='text' id='fcname' name='fcname' placeholder='Desired Username' onblur='moveoutCheckDuplicate(event)'><span id='redWarningSpan' style='color: red; visibility: hidden;'>Username Duplicated</span>
                    <br>
                    <label for='fcpassword'>Password</label>
                    <input type='password' id='fcpassword' name='fcpassword' placeholder='Desired Password'>
                    <br>";
                }
            ?>
            
            <h2>Delivery Address:</h2>
            <label for="fullname">Full Name</label>
            <input type="text" id="fullname" name="fullname" placeholder="Required">
            <br>
            <label for="companyname">Company Name</label>
            <input type="text" id="companyname" name="companyname">
            <br>
            <label for="ad1">Address Line 1</label>
            <input type="text" id="ad1" name="ad1" placeholder="Required">
            <br>
            <label for="ad2">Address Line 2</label>
            <input type="text" id="ad2" name="ad2">
            <br>
            <label for="city">City</label>
            <input type="text" id="city" name="city" placeholder="Required">
            <br>
            <label for="region">Region State District</label>
            <input type="text" id="region" name="region">
            <br>
            <label for="country">Country</label>
            <input type="text" id="country" name="country" placeholder="Required">
            <br>
            <label for="postcode">Postcode Zip Code</label>
            <input type="text" id="postcode" name="postcode" placeholder="Required">
            <br>   
    
            <p id="yorder">Your order <a href="index.html?cart=yes">(change)</a> </p>
            <br> <br>
            <p><b> Free Standard Shipping</b></p>

            <?php
                $sum=0;
                $dubugger = '';
                $conn=mysqli_connect('sophia.cs.hku.hk', 'chwoo', 'jasonxd0211', 'chwoo') or die ('Error! '.mysqli_connect_error($conn));
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
                    $BookName = $row['BookName'];
                    // calculate the sum of total cost
                    $sum += ((int)$Quantity) * ((int)$Price);
                    $dubugger .= '+'.$Quantity.'*'.$Price.'+';
                    mysqli_free_result($result);
                    echo "<span>".$Quantity." X </span>"; // quantity
                    echo "<span>".$BookName." &nbsp;&nbsp;</span>"; // bookname
                    echo "<span> HK$ ".$Price."</span>"; // quantity
                    echo "<br>";
                }
                mysqli_close($conn); 
                echo "<br> <br>";
                echo "<p><b>Total Price: HK$ ".$sum."</b></p>";  
            ?>

            <input type="submit" id="ADcsubmit" name="ADcsubmit" value="Comfirm">
        </form>
    </section>

</body>
</html>
