<?php
    // put your code here
    $errors=array();
    if($_SERVER['REQUEST_METHOD']=="POST"){
        
        $email=$_POST['email'];
        $password=$_POST['password'];
        
        $con=mysqli_connect("localhost","root","","sports");

        if($con->connect_error){array_push($errors,$con->connect_error);}
        if (empty($usn)) { array_push($errors, "Email is required"); }
        if (empty($password)) { array_push($errors, "Password is required"); }
        
        $user_check_query="select * from users where email='$email' and password='$password'";
        $result = mysqli_query($con, $user_check_query);

        $user = mysqli_fetch_assoc($result);
        
        if ($user) { // if user exists
           
          session_start();
          $_SESSION['user_id']=$user['user_id'];
          $_SESSION['name']=$user['name'];
          $_SESSION['email']=$user['email'];
          $_SESSION['address']=$user['address'];
          $_SESSION['contact']=$user['contact'];
          
          header('Location: ./home.php');

          }
          else{
            array_push($errors, "Account does not exist");
          }
        $result=NULL;
        $user=NULL;
       
        if(count($errors)>0){
                 foreach ($errors as $error) {
                      echo $error; 
                      echo "</br>";
                 }
                 
        }
}

    ?>