<?php
    // put your code here
    $errors=array();
    if($_SERVER['REQUEST_METHOD']=="POST"){
        
        $usn=$_POST['usn'];
        $password=$_POST['password'];
        
        $con=mysqli_connect("localhost","root","","library");

        if($con->connect_error){array_push($errors,$con->connect_error);}
        if (empty($password)) { array_push($errors, "Password is required"); }
        if (empty($usn)) { array_push($errors, "USN is required"); }
        
        $user_check_query="select * from students where USN='$usn' and Password='$password'";
        $result = mysqli_query($con, $user_check_query);

        $user = mysqli_fetch_assoc($result);
        
        if ($user) { // if user exists
           
          session_start();
          $_SESSION['name']=$user['Name'];
          $_SESSION['usn']=$user['USN'];
          $_SESSION['email']=$user['Email'];
        
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