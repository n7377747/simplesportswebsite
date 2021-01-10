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
    <div  class='d-sm-flex flex-row  justify-content-between' style='background-color:black;color:white;padding:3px;'>
    <h3>1sports.com</h3>
    <div>
    <form action="" method="post">
                    <input type="text" placeholder="Type here" name="product_name">
                    <button class="btn-dark btn-sm text-white" type="submit" name="search" value="search">
                        Search_</button>

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
        <div class='card' style='width: 18rem;'>
            <div class='card-body' >

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
                    <button class='btn-secondary btn-sm text-white' type='submit' name='orders' value='orders'>
                        My orders</button>    
                </form>
            </div>
        </div>
    </center>

    </br>
    <center>
        <div class="card" style='width:43rem;'>
            <div class="card-body" style='text-align: center;'>
                <form action="" method="post">
                    <input type="text" placeholder="Type here" name="product_name">
                    <button class="btn-dark btn-sm text-white" type="submit" name="search" value="search">
                        Search_</button>


                    <input type="int" placeholder="product ID " name="product_id">
                    <button class="btn-dark btn-sm text-white" type="submit" name="reserve" value="reserve">
                        Reserve</button>

                </form>
            </div>
        </div>

    </center>

    <?php
    if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == "POST") {
       
        $con = mysqli_connect("localhost", "root", "", "sports");
        if (isset($_POST['reserve'])) {
            $book_query = "select * from products where product_id={$_POST['product_id']}";
            $result = mysqli_query($con, $book_query);

            if ($result) {
                $row = mysqli_fetch_assoc($result);
                if ($row['units'] > 0) {
                    $row['units']-=1;
                    $book_update_query = "UPDATE Books SET units={$row['units']} WHERE product_id={$_POST['product_id']}";
                    $result = mysqli_query($con, $book_update_query);
                    $reserve_query = "INSERT INTO orders ( user_id, product_id, Reserved_on) VALUES ( '{$_SESSION['user_id']}', '{$_POST['book_id']}', CURRENT_DATE())";
                    $result = mysqli_query($con, $reserve_query);
                } else {
                    echo "<script>
                        alert('This product is out of stock....  please try again tomorrow');
                        </script>";
                }
            } else {
                echo "<script>
                    alert('please enter a valid book ID');
                    </script>";
            }
        }

        if ($con->connect_error) {
            array_push($errors, $con->connect_error);
        }

        if (isset($_POST['product_name'])) {
            $title = $_POST['product_name'];
            $user_check_query = "select * from products where name like '%$title%'";
            $result = mysqli_query($con, $user_check_query);

            if ($result) {

                echo "<center>
    <table class='table' style='width:50%' border='1'></center>
    <h4> List of Books</h4>
            <thead class='thead-dark'>
                    <tr>
                    <th>Book Id</th>
                    <th>Name</th>
                    <th>Author</th>       
                    <th>Availability</th>      
                    </tr>
            </thead>";

                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td><center>" . $row["Book_id"] . "</center></td>";
                    echo "<td><center>" . $row["Title"] . "</center></td>";
                    echo "<td><center>" . $row["Author"] . "</center></td>";
                    $reserved = ($row["Avalibility"] == 0) ? "Reserved" : "Available";
                    echo "<td><center>" . $reserved . "</center></td>";
                    echo "</tr>";
                }
            } else {
                echo "No Books available right now";
            }
            unset($_POST['submit'], $_POST['reserve'], $_POST['title']);
            mysqli_close($con);
        }
    }

    $con = mysqli_connect("localhost", "root", "", "library");
    $borrowed_books_query = "SELECT books.Book_id,books.Title,reservations.Reserved_on FROM books inner join reservations 
    ON reservations.Book_id=books.Book_id where USN='{$_SESSION['usn']}' ";
    $result = mysqli_query($con, $borrowed_books_query);
    if ($result) {
        echo "<center>
    <div class='row'>
    <table class='table' style='width:50%' border='1'></center>
    <h5>Books borrowed</h5>
            <thead class='thead-dark'>
                    <tr>
                    <th>Book ID</th>
                    <th>Book Title</th>
                    <th>Borrowed on</th>
                    </tr>
            </thead>";
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td><center>" . $row["Book_id"] . "</center></td>";
            echo "<td><center>" . $row["Title"] . "</center></td>";
            echo "<td><center>" . $row["Reserved_on"] . "</center></td>";
            echo "</tr>";
        }
        echo "</div>";
        $due_query = "SELECT DATEDIFF(CURRENT_DATE,reservations.Reserved_on) as NUM_DAYS FROM books inner join reservations 
    ON reservations.Book_id=books.Book_id where USN='{$_SESSION['usn']}'";
        $result = mysqli_query($con, $due_query);
        $dues = 0;
        while ($row = mysqli_fetch_assoc($result)) {
            $row['NUM_DAYS'] = ($row["NUM_DAYS"] > 2 ? $row["NUM_DAYS"] - 2 : 0) * 2;
            $dues += $row['NUM_DAYS'];
        }
        echo "<h5>Dues to be paid: $dues</h5>";
    } else {
        echo "</br><h5>You have reserved no books!</h5>";
    }

    mysqli_close($con);
    if (count($errors) > 0) {
        foreach ($errors as $error) {
            echo $error;
            echo "</br>";
        }
    }
    ?>
</body>

</html>