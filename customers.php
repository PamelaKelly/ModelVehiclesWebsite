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

$sql = "SELECT * FROM customers ORDER BY country";
$customers = mysqli_query($conn, $sql);

if (mysqli_num_rows($customers) > 0) {
    //output data of each row
    $cname = array();
    $country = array();
    $city = array();
    $phone = array();
    while($row = mysqli_fetch_assoc($customers)) {
        array_push($cname, $row["customerName"]);
        array_push($country, $row["country"]);
        array_push($city, $row["city"]);
        array_push($phone, $row["phone"]);
    }
    $customerArray = array($cname, $phone, $city, $country);
    echo "<div><table class = 'fulltable'><caption>Customer Details</caption><th>Customer Name</th><th>Contact Number</th><th>City</th><th>Country</th>";
    for ($rows = 0; $rows < count($cname); $rows++) {
        echo "<tr>";
        for ($columns = 0; $columns < count($customerArray); $columns++) {
            echo "<td>".$customerArray[$columns][$rows]."</td>";
        }
        echo "</tr>";
    }
    echo "</table></div>";
} else {
    echo "0 results";
}

mysqli_close($conn);
?>
</body>    
    <?php include "footer.php"; ?>
</html>