<?php
    session_start();
?>

<?php
    $id = (int)$_POST['bookid'];
    // get data from sql of the specific book
    $conn=mysqli_connect('sophia.cs.hku.hk', 'chwoo', 'jasonxd0211', 'chwoo') or die ('Error! '.mysqli_connect_error($conn));
    $query = "SELECT * FROM book WHERE BookId = '$id'";
    $result = mysqli_query($conn, $query) or die ('Failed to query '.mysqli_error($conn));
    if (mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_array($result)) {
            $BookName = $row['BookName'];
            $Author = $row['Author'];
            $Publisher = $row['Publisher'];
            $Published = $row['Published'];
            $Category = $row['Category'];
            $Lang = $row['Lang'];
            $Description = $row['Description'];
            $Price = (int)$row['Price'];
        }
    }
    mysqli_free_result($result);
    mysqli_close($conn);   

    print "
    <div id='mainShowBookWrapper' style='display: block; width: 100vw;'>
        <a onclick='displayController(2)'>home</a> <span> > </span> <a>".$BookName."</a>
        <h3> ".$BookName." </h3>
        <img src='upload_image/book_".$id."' alt='book Image'>
        <p>
            Author: ".$Author."
        </p>
        <p>
            Published: ".$Published."
        </p>
        <p>
            Publisher: ".$Publisher."
        </p>
        <p>
            Category: ".$Category."
        </p>
        <p>
            Language: ".$Lang."
        </p>
        <p>
            Description: ".$Description."
        </p>
        <p>
            Price: ".$Price."
        </p>
    </div>
    <span id='orderspan'>Order: </span>
    <input type='text' id='ordernum' name='ordernum'>
    <button type='button' onclick='displayController(4);passAmount_ID(".$id.");showAllCarts();printTotalCost();'>Add&nbsp;to&nbsp;Cart</button>
    
    ";
?>


