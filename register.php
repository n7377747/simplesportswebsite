<?php
// put your code here
$errors = array();

if ($_SERVER['REQUEST_METHOD'] == "POST") {

  $name = $_POST['name'];
  $email = $_POST['email'];
  $contact = $_POST['contact'];
  $password = $_POST['password'];
  $address = "{$_POST['address']} , {$_POST['city']} , {$_POST['state']}-{$_POST['zipcode']}";

  $con = mysqli_connect("localhost", "root", "", "sports");

  if ($con->connect_error) {
    array_push($errors, $con->connect_error);
  }

  if (empty($name)) {
    array_push($errors, "Username is required");
  }
  if (empty($email)) {
    array_push($errors, "Email is required");
  }
  if (empty($password)) {
    array_push($errors, "Password is required");
  }
  if (empty($contact)) {
    array_push($errors, "contact is required");
  }

  $user_check_query = "select * from users where email='$email'";
  $result = mysqli_query($con, $user_check_query);

  if (mysqli_fetch_assoc($result)) {
    array_push($errors, "Email already exists");
  }

  if (count($errors) == 0) {
    echo ("connected successfully!");

    $query = "INSERT INTO `users` (`name`,`email`,`password`,`contact`,`address`)
                         values('$name','$email','$password','$contact','$address')";

    $result = mysqli_query($con, $query);
    if ($result) {
      header("Location: ./login.php");
    } else {
      echo ("Registration failed :(  </br>... Please Try again ....");
    }
  } else {
    foreach ($errors as $error) {
      echo $error;
      echo "</br>";
    }
  }
}
