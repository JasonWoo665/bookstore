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
        *{
            border-style: solid;
        }
    </style>
</head>
<body>
    <section>
        <h1>Invoice Page </h1>
        <!-- special handler in create.php is needed -->
        <br> <br>
        <?php
            if (isset($_POST['ADcsubmit'])){
                if (isset($_POST['companyname']) && ($_POST['companyname']!='')){
                    echo "<p>Full Name: ".$_POST['fullname']."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Company:".$_POST['companyname']."</p>";
                }
                else{
                    echo "<p>Full Name: ".$_POST['fullname']."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Company: NA </p>";
                }
                
                echo "<p>Address Line 1: ".$_POST['ad1']."</p>";
                if (isset($_POST['ad2']) && ($_POST['ad2']!='')){
                    echo "<p>Address Line 2: ".$_POST['ad2']."</p>";
                }
                else{
                    echo "<p>Address Line 2: NA</p>";
                }
                if (isset($_POST['region']) && ($_POST['region']!='')){
                    echo "<p>City: ".$_POST['city']."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Region: ".$_POST['region']."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Country: ".$_POST['country']."</p>";
                }
                else{
                    echo "<p>City: ".$_POST['city']."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Region: NA &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Country: ".$_POST['country']."</p>";
                }
                echo "<p>Postcode: ".$_POST['postcode']."</p>";
            }
        ?>
        <br> <br>
        <?php
            $sum=0;
            $dubugger = '';
            $conn=mysqli_connect('sophia.cs.hku.hk', 'chwoo', 'jasonxd0211', 'chwoo') or die ('Error! '.mysqli_connect_error($conn));
            foreach ($_SESSION['cartID'] as $key => $value){
                // select one cart of the user
                $DesiredCartID = $value;
                $query = "SELECT * FROM cart WHERE CartId = '$DesiredCartID'";
                $result = mysqli_query($conn, $query) or die (print "SELECT * FROM cart WHERE CartId = '$DesiredCartID'".mysqli_error($conn));
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
            echo "<br>";
            echo "<p>Total Price: HK$ ".$sum."</p>";  
        ?>
        <p style="text-align: center;">Thanks for ordering.  Your books will be delivered within 7 working days.</p>
        <form name="invoiceForm" action="main.html" method="post" style="display: flex; justify-content: center;">
            <input type="submit" id="ADcsubmit" name="ADcsubmit" value="OK">
        </form>
    </section>

</body>
</html>
