<?php
  
  session_start();
  $conn=mysqli_connect('sophia.cs.hku.hk', 'chwoo', 'jasonxd0211', 'chwoo') or die ('Error! '.mysqli_connect_error($conn));

  if($_POST['show'] =='all') {
    $query = "SELECT * FROM book";
    $result = mysqli_query($conn, $query) or die ('Failed to query '.mysqli_error($conn));
    if (mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_array($result)) {
            if ($row['New_Arrival']=='Yes'){
                $newArrival = true;
            }
            else{
                $newArrival = false;
            }
            print "<div id=".$row['BookId']." class='books' style='display: block;'>";
            print "<a class='bookName' onclick='detailedShown(".$row['BookId'].");displayController(3);'>".$row['BookName']."</a>";
            print"<img src='upload_image/book_".$row['BookId']."' alt='book Image'>";
            if ($newArrival){
                print "<p class='newArrival'> NEW ARRIVAL! </p>";
            }
            print "<p> Author: ".$row['Author']."</p>";
            print "<p> Publisher: ".$row['Publisher']."</p>";
            print "<p> Price: $ ".$row['Price']."</p>";
            print "</div>";
        }
    }
    mysqli_free_result($result);
  }
  else if ($_POST['show'] =='filter'){
    $type = $_POST['type'];
    // build query base on what is needed
    $query = "SELECT * FROM book WHERE Category='$type'";
    $result = mysqli_query($conn, $query) or die ('Failed to query '.mysqli_error($conn));
    while($row = mysqli_fetch_array($result)) {
      if ($row['New_Arrival']=='Yes'){
          $newArrival = true;
      }
      else{
          $newArrival = false;
      }
      print "<div id=".$row['BookId']." class='books' style='display: block;'>";
      print "<a class='bookName' onclick='detailedShown(".$row['BookId'].");displayController(3);'>".$row['BookName']."</a>";
      print"<img src='upload_image/book_".$row['BookId']."' alt='book Image'>";
      if ($newArrival){
          print "<p class='newArrival'> NEW ARRIVAL! </p>";
      }
      print "<p> Author: ".$row['Author']."</p>";
      print "<p> Publisher: ".$row['Publisher']."</p>";
      print "<p> Price: $ ".$row['Price']."</p>";
      print "</div>";
    }
    mysqli_free_result($result);
  }
  
  else if ($_POST['show'] =='sortPrice'){
    $query = "SELECT * FROM book ORDER BY Price DESC";
    $result = mysqli_query($conn, $query) or die ('Failed to query '.mysqli_error($conn));
    if (mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_array($result)) {
            if ($row['New_Arrival']=='Yes'){
                $newArrival = true;
            }
            else{
                $newArrival = false;
            }
            print "<div id=".$row['BookId']." class='books' style='display: block;'>";
            print "<a class='bookName' onclick='detailedShown(".$row['BookId'].");displayController(3);'>".$row['BookName']."</a>";
            print"<img src='upload_image/book_".$row['BookId']."' alt='book Image'>";
            if ($newArrival){
                print "<p class='newArrival'> NEW ARRIVAL! </p>";
            }
            print "<p> Author: ".$row['Author']."</p>";
            print "<p> Publisher: ".$row['Publisher']."</p>";
            print "<p> Price: $ ".$row['Price']."</p>";
            print "</div>";
        }
    }
    mysqli_free_result($result);
  }
  else if ($_POST['show'] =='searching'){
    $kwcleaned = $_POST['keyword'];
    $pieces = explode("-", $kwcleaned);
    $query = "SELECT * FROM book WHERE ";
    foreach ($pieces as $kw){
      $query = $query."BookName LIKE BINARY '%".$kw."%' OR Author LIKE BINARY '%".$kw."%' OR ";
    }
    $query = substr($query, 0, -3);
    $result = mysqli_query($conn, $query) or die ('Failed to query '.mysqli_error($conn));
    if (mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_array($result)) {
            if ($row['New_Arrival']=='Yes'){
                $newArrival = true;
            }
            else{
                $newArrival = false;
            }
            print "<div id=".$row['BookId']." class='books' style='display: block;'>";
            print "<a class='bookName' onclick='detailedShown(".$row['BookId'].");displayController(3);'>".$row['BookName']."</a>";
            print"<img src='upload_image/book_".$row['BookId']."' alt='book Image'>";
            if ($newArrival){
                print "<p class='newArrival'> NEW ARRIVAL! </p>";
            }
            print "<p> Author: ".$row['Author']."</p>";
            print "<p> Publisher: ".$row['Publisher']."</p>";
            print "<p> Price: $ ".$row['Price']."</p>";
            print "</div>";
        }
    }
    mysqli_free_result($result);
  }
  mysqli_close($conn);    
?>