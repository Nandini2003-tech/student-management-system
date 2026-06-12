<?php
session_start();
include('3-config.php');
$loginError ="";

if (isset($_POST['login'])) {

// get values from form
    $email = $_POST['email'];
    $password = $_POST['password'];

    //  validation 
    if(empty($email)||empty($password)) {
        $loginError= "All fields are required";
    } else {
        // query
        $query = "select * from admin where email ='$email' && password ='$password'";
        $data = mysqli_query($conn, $query);

        if(mysqli_num_rows($data) > 0) {

            $_SESSION['admin'] = $email;
            header("Location:4-dashboard.php");
        } else {
           $loginError ="invalid email or password";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</head>

<body class="bg-secondary-subtle d-flex flex-column  justify-content-center align-items-center vh-100 px-2">
    <div class="login-box bg-white p-4 rounded-4 shadow" style="width:100%; max-width:450px;">
    <div class="text-center mb-3">
   <i class="bi bi-person-circle fs-1"></i>
</div>
        <h2 class="text-center mb-1 fw-bold">Admin Login</h2>
        <form action="" method="post">
    <?php
              if($loginError != ""){
                ?>
                  <div class="mb-3 alert alert-danger p-2" id="loginError">
                     <?php echo $loginError ?>
                 </div>
         <?php 
              }
            ?>  
            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" placeholder="Email" name="email" class="form-control py-2">
            </div>
            <div class="mb-3">
                <label class="form-label">Password</label>
                <input type="password" placeholder="Password" name="password" class="form-control">
            </div>
             
            <input type="submit" value="Login" name="login" class="btn btn-dark w-100 py-2 fw-bold">
        </form>

        <div class="alert alert-info mt-3 mb-0 py-2">
                    <strong>Demo Credentials:</strong><br>
                   Email : admin@gmail.com <br>
                   Password : 12345
        </div>
    </div>

    <script>

        let  loginError = document.querySelector('#loginError');
        if(loginError){
        setTimeout(() => {
            loginError.style.display ='none';
        },2000);
}
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
