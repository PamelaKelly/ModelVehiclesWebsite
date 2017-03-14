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
}

$sql = "SELECT productLine FROM productlines";
$productlines = mysqli_query($conn, $sql);
$lines = array();    
if (mysqli_num_rows($productlines) > 0) {
    //store data for each row in an array
    while($row = mysqli_fetch_assoc($productlines)) {
        array_push($lines, $row["productLine"]);
    }
}

echo "<h1>Classic Models - Product Lines</h1><div><p>Please Select A Product Line Below To See The Full Listings Of Items Available In Each Collection</p></div><ul>";
foreach ($lines as $line) {
    echo "<li><figure><img src='/dev/pamela_kelly_A3_COMP30680/images/".$line.".jpg'><figcaption><a href = 'products.php?line=".$line."' method = 'GET'>$line</figcaption></figure></li>";
    $name = $line[0];
}
echo "</ul>";
    
if (isset($_GET["line"])) {
    $line = $_GET["line"];
    $sqlp = "SELECT * FROM products WHERE productline ='$line'";
    $products = mysqli_query($conn, $sqlp);
    if (mysqli_num_rows($products) > 0) {
        echo "<div><table class='fulltable'><caption>$line</caption><th>Product Name</th><th>Description</th><th>Stock Level</th><th>Price</th><th>Product Code</th>";
        while($row = mysqli_fetch_assoc($products)) {
            echo "<tr><td>".$row["productName"]."</td><td>".$row["productDescription"]."</td><td>".$row["quantityInStock"]."</td><td>".$row["buyPrice"]."</td><td>".$row["productCode"]."</td></tr>";
        }
        echo "</table></div>";
    } else {
        echo "0 results from database query";
    }
}
    
mysqli_close($conn);
?>

</body>
    <?php include "footer.php"; ?>
</html>
