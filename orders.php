<html>

<head>
    <meta charset="UTF-8">
    <title>Home</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <style href="./styles.css">
    </style>
    <style>
        .center {
            text-align: center;
        }
    </style>
</head>

<body background="https://thumbs.dreamstime.com/b/icon-set-black-simple-silhouette-sports-equipment-flat-design-vector-illustration-info-graphic-web-banners-71303689.jpg">
    <div class='navbar d-sm-flex flex-row  justify-content-between' style='background-color:black;color:white;padding:3px;'>
        <h3>1sports.com</h3>
        <div>
            <form action="./home.php" method="post">
                <button class="btn-dark btn-sm text-white" type="submit" name="back" value="back">
                    Back</button>
                <form>
        </div>
    </div>
    <?php
    session_start();
    if (!isset($_SESSION['name']) || isset($_POST['logout'])) {
        session_destroy();
        header("Location: ./login.php");
    }
    function product_card($product_id, $name, $mrp, $manufacturer, $description, $order_id,$order_date)
    {
        echo "
    <div class='row'>
        <div class='col-12'>
            <div class='card'>
                <div class='card-body'>
                    <h6 class='card-title'> Order-id: #{$order_id} {$name}</h6>
                    <span class='text-secondary'>by {$manufacturer}</span>
                    </br>
                    <span style='margin:5px 0px;'>{$description}</span>
                    </br>
                    <span class='text-secondary'>Ordered on {$order_date}</span>
                    </br>
                    <h6>&#8377;{$mrp}</h6> 
                </div>
            </div>
        </div>
   </div>
    ";
    }
    $con = mysqli_connect("localhost", "root", "", "sports");
$orders_query = "select * from orders join products where orders.user_id={$_SESSION['user_id']} and orders.product_id=products.product_id";
            $result = mysqli_query($con, $orders_query);
            if ($result) {
                echo 
                "<div class='container bg-white' style='padding:10px;'>
                <div class='row'>
                    <div class='col-12'>
                    <h4>Your orders</h4>
                    </div>
                </div>";
                while ($row = mysqli_fetch_assoc($result)) {
                    product_card($row['product_id'],$row['name'],$row['MRP'],$row['manufacturer'],$row['description'],$row['order_id'],$row['date']);  
                }
                echo "</div>";
            } else {
                echo "No Books available right now";
            }
            mysqli_close($con);
        
    ?>
</body>