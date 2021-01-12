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
            <form action="" method="post">
                <input type="text" placeholder="search for" name="product_name">
                <button class="btn-dark btn-sm text-white" type="submit" name="search" value="search">
                    Search</button>
                <input type="int" placeholder="product ID " name="product_id">

                <button class="btn-dark btn-sm text-white" type="submit" name="reserve" value="reserve">
                    Reserve</button>
                <form>
        </div>
    </div>
    <?php
    $errors = array();
    session_start();
    if (!isset($_SESSION['name']) || isset($_POST['logout'])) {
        session_destroy();
        header("Location: ./login.php");
    }
    ?>
    <center>
        <div class='card' style='width: 25rem;'>
            <div class='card-body'>

                </br>
                <h5 class='card-title'><?php echo "Hello {$_SESSION['name']}" ?></h5>
                <strong>Contact:</strong> <?php echo $_SESSION['contact']; ?>
                </br>
                <strong>Email: </strong> <?php echo $_SESSION['email']; ?>
                </br>
                <strong> Address: </strong> <?php echo $_SESSION['address']; ?>
                </br>

                </br>
                <form action='' method='post'>
                    <button class='btn-dark btn-sm text-white' type='submit' name='logout' value='logout'>
                        Logout</button>
                    <button class='btn-secondary btn-sm text-white' name='orders' value='orders'>
                    <a class='text-white'  href='./orders.php'>
                        My orders</a></button></br>

                </form>
            </div>
        </div>
    </center>

    </br>

    <?php

function product_card($product_id,$name,$mrp,$manufacturer,$description,$units){
    $availability=$units==0?"<span class='text-danger'>Out of Stock</span>":
                            "<span class='text-success'>$units in stock</span";

    echo "
    <div class='row'>
        <div class='col-12'>
            <div class='card'>
                <div class='card-body'>
                    <h6 class='card-title'>{$product_id} . {$name}</h6>
                    <span class='text-secondary'>by {$manufacturer}</span>
                    </br>
                    <span style='margin:5px 0px;'>{$description}</span>
                    </br>
                    {$availability}
                    </br>
                    <h6>&#8377;{$mrp}</h6> 
                </div>
            </div>
        </div>
   </div>
    ";
   }

    if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == "POST") {

        $con = mysqli_connect("localhost", "root", "", "sports");
        if ($con->connect_error) {
            array_push($errors, $con->connect_error);
            exit();
        }

        if (isset($_POST['reserve'])) {
            $book_query = "select * from products where product_id={$_POST['product_id']}";
            $result = mysqli_query($con, $book_query);

            if ($result) {
                $row = mysqli_fetch_assoc($result);
                if ($row['units'] > 0) {
                    $row['units'] -= 1;
                    $update_query = "UPDATE products SET units={$row['units']} WHERE product_id={$_POST['product_id']}";
                    $result = mysqli_query($con, $update_query);
                    $reserve_query = "INSERT INTO orders ( user_id, product_id, date) VALUES ( {$_SESSION['user_id']}, {$_POST['product_id']}, CURRENT_DATE())";
                    $result = mysqli_query($con, $reserve_query);
                    echo "<script>
                        alert('Order placed successfully');
                        </script>";
                } else {
                    echo "<script>
                        alert('This product is out of stock....  please try again tomorrow');
                        </script>";
                }
            } else {
                echo "<script>
                    alert('please enter a valid product ID');
                    </script>";
            }
            unset($_POST['reserve']);
        }
else if (isset($_POST['search']) && isset($_POST['product_name'])) {

            $title = $_POST['product_name'];
            $user_check_query = "select * from products where name like '%$title%'";
            $result = mysqli_query($con, $user_check_query);
            if ($result) {
                echo 
                "<div class='container bg-white' style='padding:10px;'>
                <div class='row'>
                    <div class='col-12'>
                    <h4>Search results</h4>
                    </div>
                </div>";
                while ($row = mysqli_fetch_assoc($result)) {
                    product_card($row['product_id'],$row['name'],$row['MRP'],$row['manufacturer'],$row['description'],$row['units']);  
                }
                echo "</div>";
            } else {
                echo "No Books available right now";
            }
            mysqli_close($con);
        }
        unset($_POST['search']);
        unset($_POST['product_name']);
    }
    else{
        $con = mysqli_connect("localhost", "root", "", "sports");
        $all_query = "SELECT * from products"; 
        $result = mysqli_query($con, $all_query);
        if ($result) {
            echo 
            "<div class='container-fluid bg-white' style='padding:10px;'>
            <div class='row'>
                <div class='col-12'>
                <h4>Products</h4>
                </div>
            </div>";
            while ($row = mysqli_fetch_assoc($result)) {
                product_card($row['product_id'],$row['name'],$row['MRP'],$row['manufacturer'],$row['description'],$row['units']); 
            }
            echo '</div>';
            mysqli_close($con);
    }
}
    
    if (count($errors) > 0) {
        foreach ($errors as $error) {
            echo $error;
            echo "</br>";
        }
    }
    ?>
</body>

</html>