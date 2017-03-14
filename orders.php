<html>
<head><link rel='stylesheet' type='text/css' href='cmstyle.css'></head>
    <?php include "nav.php"; ?>
<body>
    <h1>Please select an order number to view the details for that order</h1>

<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname="classicmodels";

//create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);
//check connection
if (!$conn) {
    die("Connection Failed: ".mysqli_connect_error());
}
echo "<section id='main'>";

$sql = "
SELECT *
FROM orders
WHERE status = 'In Process';
";

$currentOrders = mysqli_query($conn, $sql);
if (mysqli_num_rows($currentOrders) > 0) {
    //output data for each row
    echo "<table><caption>Orders Currently Being Processed</caption><th>Order Number</th><th>Order Date</th><th>Order Status</th>";
    $orderNums = array();
    while($row = mysqli_fetch_assoc($currentOrders)) {
        $order = $row["orderNumber"];
        $comment = $row["comments"];
        echo "<tr><td><a href= 'orders.php?order=".$order."'>".$row["orderNumber"]."</a></td><td>".$row["orderDate"]."</td><td>".$row["status"]."</td></tr>";
        array_push($orderNums, $order);
    }
    echo "</table>";
} else {
    echo "0 results";
}
    
$sql2 = "
SELECT * 
FROM orders
WHERE `status` = 'Cancelled'";
$cancelledOrders = mysqli_query($conn, $sql2);

if (mysqli_num_rows($cancelledOrders) > 0) {
    //output data for each row
    echo "<table><caption>Cancelled Orders</caption><th>Order Number</th><th>Order Date</th><th>Order Status</th>";
    $orderNums2 = array();
    while($row = mysqli_fetch_assoc($cancelledOrders)) {
        $order = $row["orderNumber"];
        echo "<tr><td><a href= 'orders.php?order=".$order."'</a>".$row["orderNumber"]."</td><td>".$row["orderDate"]."</td><td>".$row["status"]."</td></tr>";
        array_push($orderNums2, $order);
    }
    echo "</table>";
} else {
    echo "0 results";
}
    
$sql3 = "
SELECT * 
FROM orders
ORDER BY orderDate DESC LIMIT 20";
$last20orders = mysqli_query($conn, $sql3);

if (mysqli_num_rows($last20orders) > 0) {
   //output data for each row
    echo "<table><caption>Last 20 Orders</caption><th>Order Number</th><th>Order Date</th><th>Order Status</th>";
    $orderNums3 = array();
    while($row = mysqli_fetch_assoc($last20orders)) {
        $order = $row["orderNumber"];
        echo "<tr><td><a href= 'orders.php?order=".$order."'</a>".$row["orderNumber"]."</td><td>".$row["orderDate"]."</td><td>".$row["status"]."</td></tr>";
        array_push($orderNums3, $order);
    }
    echo "</table>";
} else {
    echo "0 results"; 
}

echo "</section>";
    
echo "<section id = 'detail'>";
if (isset($_GET["order"])) {
    $order = htmlspecialchars($_GET["order"]);
    $orderQuery = "
    SELECT 
    orders.orderNumber,
    orders.orderDate,
    orders.`status`,
    orders.comments,
    orderdetails.productCode,
    productName,
    productLine
    FROM orders, orderdetails, products
    WHERE orders.orderNumber = orderdetails.orderNumber and orderdetails.productCode = products.productCode and orders.orderNumber = ".$order.";";
    $orderDetails = mysqli_query($conn, $orderQuery);
    if (mysqli_num_rows($orderDetails)>0) {
        echo "<table><caption>Order Number ".$order." Details</caption><th>Product Code</th><th>Product Name</th><th>Product Line</th>";
        $comment = "Comments: ";
        $check = 0;
        while ($row = mysqli_fetch_assoc($orderDetails)) {
            $Code = $row["productCode"];
            $Name = $row["productName"];
            $Line = $row["productLine"];
            echo "<tr><td>".$Code."</td><td>".$Name."</td><td>".$Line."</td></tr>";
            if ($check == 0) {
                if ($row["comments"] != NULL) {
                    $comment = $comment.$row["comments"];
                    $check += 1;
                } else {
                    $comment = "No comments with this order";
                    $check +=1;
                }
            }
            
        }
        echo "<tr><td colspan ='3'>".$comment."</td></tr></table>";
    }
}

echo "</section>";
mysqli_close($conn);
?>
  
</body>
    <?php include "footer.php"; ?>
</html>

