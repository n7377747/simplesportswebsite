<?php
    // put your code here
    $errors=array();

    if($_SERVER['REQUEST_METHOD']=="POST"){
        
        $name=$_POST['name'];
        $email=$_POST['email'];
        $usn=$_POST['usn'];
        $password=$_POST['password'];
        
        $con=mysqli_connect("localhost","root","","library");

        if($con->connect_error){
            array_push($errors,$con->connect_error);
        }
        if (empty($name)) { array_push($errors, "Username is required"); }
        if (empty($email)) { array_push($errors, "Email is required"); }
        if (empty($password)) { array_push($errors, "Password is required"); }
        if (empty($usn)) { array_push($errors, "USN is required"); }
        
        $user_check_query="select * from students where usn='$usn' or email='$email";
        $result = mysqli_query($con, $user_check_query);
        $user = mysqli_fetch_assoc( $result);

        if ($user) { // if user exists
            if ($user['usn'] === $usn) {
              array_push($errors, "Usn already exists");
            }
        
            if ($user['email'] === $email) {
              array_push($errors, "email already exists");
            }
          }
        
        if (count($errors) == 0) {
            echo ("connected successfully!");
                
            $query="INSERT INTO STUDENTS (name,email,password,usn)
                         values('$name','$email','$password','$usn')";
        
            $result=mysqli_query($con,$query);
            if($result){
                header("Location: ./login.php"); 

            }
            else{
                echo("Registration failed :(  </br>... Please Try again ....");
            }
        }
        else{
                 foreach ($errors as $error) {
                      echo $error; 
                      echo "</br>";
                 }
        }
}

    ?>