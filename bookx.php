<?php
    session_start();
?>

<style>
    * {
        border-style: solid;
        background-color: blanchedalmond;
        padding: 0;
        margin: 0;
    }
    section, nav, div, aside {
        display: flex;
        align-content: stretch;
    }
    #mainShowBookArea{
        /* display: block; */
        flex-wrap: wrap;
        align-content: stretch;
    }
    .books{
        width: 20%;
    }
    .books img{
        max-width: 100%;
        display: block;
    }
</style>

<?php
    if ($_GET['action'] == 'specific') {
        $id = (int)$_GET['bookid'];
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
        ?>

        <section style="flex-direction: column; width: 99vw;">
            <nav style="height: 100px; justify-content: center; flex-direction: column;">
                <form action="post" style="align-self: center;">
                    <input type="text" placeholder="Keyword(s)" style="float: left; width: 70vw;">
                    <input type="submit" name="searching" id="searching" value="Search">
                </form>
                <div class="loginOptions" style="flex-direction: row; justify-content: flex-end;">
                    <div id="loginCheckArea">
                    
                    </div>
                    <form action="myshoppingCartShow.html"><button type="submit">Cart</button></form>
                </div>
            </nav>
            <div class="inner" style="flex-direction: row; height: min-content;">
                <div id="mainShowBookWrapper" style="display: block; width: 100vw;">
                    <a href="index.html">home</a> <span> > </span> <a><?php echo $BookName?></a>
                    <h3> <?php echo $BookName ?> </h3>
                    <img src='upload_image/book_<?php echo $id ?>' alt='book Image'>
                    <p>
                        Author: <?php echo $Author ?>
                    </p>
                    <p>
                        Published: <?php echo $Published ?>
                    </p>
                    <p>
                        Publisher: <?php echo $Publisher ?>
                    </p>
                    <p>
                        Category: <?php echo $Category ?>
                    </p>
                    <p>
                        Language: <?php echo $Lang ?>
                    </p>
                    <p>
                        Description: <?php echo $Description ?>
                    </p>
                    <p>
                        Price: <?php echo $Price ?>
                    </p>
                </div>
            </div>
            <form name="cartForm" action="saveCartIdToSection.php" method="post">
                <input type="text" id="ordernum" name="ordernum">
                <input type="hidden" id="bookidsubmit" name="bookidsubmit" value="<?php echo $id?>">
                <input type="submit" id="cartsubmit" name="cartsubmit" value="Add to Cart">
            </form>
            <script>
                function checkLogin(){
                    // check login status
                    var xmlhttp = new XMLHttpRequest();
                    xmlhttp.onreadystatechange = function () {
                        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                            var loginCheckArea = document.getElementById("loginCheckArea");
                            console.log(xmlhttp.responseText);
                            loginCheckArea.innerHTML = xmlhttp.responseText;
                        }
                    }
                    xmlhttp.open("POST", "checkLoginStatus.php", true);
                    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                    xmlhttp.send("action=checklogin");
                }
                window.onload = function() {
                    checkLogin();
                }
            </script>
        </section>


        <?php
    }
?>

