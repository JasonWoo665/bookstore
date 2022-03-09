<?php
        session_start();

        // store the desired amount into SQL
        $ordernum = $_POST['ordernum'];
        $bookidsubmit = $_POST['bookidsubmit'];
        $conn=mysqli_connect('sophia.cs.hku.hk', 'username', 'password', 'username') or die ('Error! '.mysqli_connect_error($conn));
        // insert the data first
        if ($_SESSION['UserId'] && $_SESSION['UserId']!=''){
            $username = $_SESSION['UserId'];
            $query="INSERT INTO cart (BookId, UserId, Quantity) VALUES ('$bookidsubmit', '$username' , '$ordernum')";
        }
        else{
            $username = "let's suppose that no one will use such user name and using such user name is a sin";
            $query="INSERT INTO cartNotLoggedIn (BookId, Quantity) VALUES ('$bookidsubmit' , '$ordernum')";
        }
        if (!mysqli_query($conn, $query)) {
            // return false message
        }
        else{
            // take the id of the cart out, and assign to session
            if ($_SESSION['UserId'] && $_SESSION['UserId']!=''){
                $query = "SELECT * FROM cart WHERE CartId=(SELECT max(CartId) FROM cart)";
            }
            else{
                $query = "SELECT * FROM cartNotLoggedIn WHERE CartId=(SELECT max(CartId) FROM cartNotLoggedIn)";
            }
            $result = mysqli_query($conn, $query) or die ('Failed to query '.mysqli_error($conn));
            while($row = mysqli_fetch_array($result)) {
                if (!isset($_SESSION['cartID'])) {
                    static $cartsOfOne = array();
                    $_SESSION['cartID'] = $cartsOfOne;
                    array_push($_SESSION['cartID'], $row['CartId']);
                }
                else{
                    array_push($_SESSION['cartID'], $row['CartId']);
                }
                if (!isset($_SESSION['count'])) {
                    $_SESSION['count']=1;
                }
                else{
                    $_SESSION['count']+=1;
                }
            }
        }
        mysqli_free_result($result);
        mysqli_close($conn);
        print var_dump($_SESSION).' with session id='.var_dump(session_id()).'with val '.var_dump($_SESSION['cartID']);
        // header("location: myshoppingCartShow.html");
    
?>

