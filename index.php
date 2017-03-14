<html>
    <head><link rel='stylesheet' type='text/css' href='cmstyle.css'></head>
    <?php include "nav.php"; ?>
    <body>
<?php

$servername = "localhost";
$username = "root";
$password ="";
$dbname ="classicmodels";

//create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);
//check connection
if (!$conn) {
    die("Connection Failed: " . mysqli_connect_error());
    echo "<p>We have failed to connect to the database</p>";
}

$sql = "SELECT productLine, textDescription FROM productlines";
$productlines = mysqli_query($conn, $sql);

if (mysqli_num_rows($productlines) > 0) {
    //output data of each row
    while($row = mysqli_fetch_assoc($productlines)) {
        $line = $row["productLine"];
        $desc = $row["textDescription"];
        echo "<div><table id='home'><caption>$line</caption><tr><td rowspan='4'><img src='/dev/pamela_kelly_A3_COMP30680/images/".$line.".jpg'></td><td>$desc</td></tr></table></div>";
        //echo "<div><p>Product Line: " . $row["productLine"]. "</p><p>Line Description: " . $row["textDescription"]. "</p></div>";
    }
} else {
    echo "0 results";
}

mysqli_close($conn);
?>
    </body>
    <?php include "footer.php"; ?>
    
</html>