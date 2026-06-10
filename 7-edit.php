<?php
include('3-config.php');
include('1-auth.php');

// getting id from url
$id = $_GET['id'];
$query = "select * from students2 where id ='$id'";
$data = mysqli_query($conn, $query);
$result = mysqli_fetch_assoc($data);

//   Error Variables
$nameError = "";
$emailError = "";
$genderError = "";
$phoneError = "";
$courseError = "";
$addressError = "";
$fileError = "";
$errorMsg ="";

// if update button click 
if(isset($_POST['updateBtn'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
     $gender = $_POST['gender'];
    $phone = $_POST['phone'];
    $course = $_POST['course'];
    $address = $_POST['address'];

    //  image
    $fileName = $_FILES['newFile']['name'];
    $tempName = $_FILES['newFile']['tmp_name'];
    $folder = "uploads2/" . $fileName;

    //  validation 

    //   name validation
    if (empty($name)) {
        $nameError = "Name is required";
    } elseif (strlen($name) < 3) {
        $nameError = "Minimum 3 charaters";
    } elseif (!preg_match("/^[a-zA-Z ]*$/", $name)) {
        $nameError = "Only letters allowed";
    }

    // email
    if (empty($email)) {
        $emailError = "Email required";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $emailError = "Invalid Email";
    }
    // phone
    if (empty($phone)) {
        $phoneError = "phone number required";

    } elseif (!is_numeric($phone)) {
        $phoneError = "Only numbers allowed";
    }  elseif (strlen($phone) != 10) {
        $phoneError = "Minimum 10 digits required";
    }
    // course
    if (empty($course)) {
        $courseError = "Please select course";
    }
    // gender
    if (empty($gender)) {
        $genderError = "Please select gender";
    }
    // address
    if (empty($address)) {
        $addressError = "address required";
    }

    // file validation
    if($fileName != ""){
    $fileType = $_FILES['newFile']['type'];
    $fileSize = $_FILES['newFile']['size'];

   // find file extension
   $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

  //  create array and fill valid extension 
    $allowedExt = ['jpg','jpeg','png'];

      if(!in_array($fileExt,$allowedExt)){
       $fileError = "Only jpg jpeg png allowed";
   }elseif ($fileSize > 2000000) {
         $fileError = "File too large";
 }
}

if (
    $nameError == "" &&
    $emailError == "" &&
    $phoneError == "" &&
    $courseError == "" &&
    $genderError == "" &&
    $addressError == "" &&
    $fileError == ""
)
 {

    // file update
    if ($fileName != "") {
        // new file data store
        unlink($result['file']);
        move_uploaded_file($tempName, $folder);
       } else{
          $folder = $result['file'];
    }
        $query = "update students2 set 
        name = '$name',
        email='$email',
        gender= '$gender',
        phone='$phone',
        course='$course',
        address='$address',
        file ='$folder' where id ='$id' ";

        $result = mysqli_query($conn, $query);

        if ($result) {
            header("Location:6-display-student.php?msg=success");
            exit();
        } else {
            $errorMsg ="Error: failed to Update" . mysqli_error($conn);
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
    <link rel="stylesheet" href="style.css">
</head>
<body class="bg-secondary-subtle" style="padding-top:95px; padding-bottom:50px;">
 <?php include('navbar.php') ?>
  <div class="container-fluid bg-secondary-subtle px-0">
    <div class="container-lg">
      <form class="row g-3 shadow rounded-3 px-4 pb-4  bg-white" action="#" method="post" enctype="multipart/form-data">

        <?php 
         if($errorMsg != ""){
          ?>
          <div class=" alert alert-danger mt-2">
          <?php  echo $errorMsg; ?>
            </div>
            <?php
         }
         ?>

        <h2 class="mb-2 text-center">Update Student</h2>

        <div class="col-md-6">
          <label class="form-label">Student Name</label>
          <input type="text" name="name" value="<?php echo $result['name']  ?? ""; ?>" class="form-control">
          <span style="color: red;">
            <?php echo $nameError; ?>
          </span>
        </div>

        <div class="col-md-6">
          <label  class="form-label">Email</label>
           <input type="email" name="email"  value="<?php echo $result['email']  ?? ""; ?>" class="form-control">
                         <span style="color: red;">
                            <?php echo $emailError; ?>
                        </span>
        </div>

        <div class="col-md-6">
          <label  class="form-label">Phone</label>
            <input type="tel" name="phone" value="<?php echo $result['phone']  ?? ""; ?>" class="form-control">
                         <span style="color: red;">
                            <?php echo $phoneError; ?>
                        </span>
        </div>

        <div class="col-md-6">
          <label class="form-label">Gender</label>
           <select name="gender" class="form-select">
                            <option value="">Select Gender</option>
                            <option value="Male"
                             <?php 
                               if($result['gender'] == "Male"){
                                 echo"selected";
                               }
                             ?>
                            >Male</option>
                            <option value="Female"
                              <?php 
                               if($result['gender'] == "Female"){
                                 echo"selected";
                               }
                             ?>
                            >Female</option>
                        </select>
                        <span style="color: red;">
                            <?php echo $genderError; ?>
                        </span>
        </div>

        <div class="col-12">
          <label class="form-label">Address</label>
           <textarea  name="address"  class="form-control" rows="3"><?php echo $result['address'] ?? ""; ?></textarea>
                        <span style="color: red;">
                            <?php echo $addressError; ?>
                        </span>
        </div>
      
        <div class="col-md-6">
          <label  class="form-label">Course</label>
             <select name="course" class="form-select">
                            <option value="">Select course</option>
                            <option value="BCA" 
                               <?php 
                               if($result['course'] == "BCA"){
                                 echo"selected";
                               }
                             ?>
                            >BCA</option>

                            <option value="BSc IT"
                              <?php 
                               if($result['course'] == "BSc IT"){
                                 echo"selected";
                               }
                             ?>
                            >BSc IT</option>
                            <option value="MCA"
                              <?php 
                               if($result['course'] == "MCA"){
                                 echo"selected";
                               }
                             ?>
                            >MCA</option>
                        </select>
                         <span style="color: red;">
                            <?php echo $courseError; ?>
                        </span>
        </div>

        <!-- file -->
         <div class="col-12">
           <label class="form-label">Old File</label>
              <img src="<?php echo $result['file'] ?>" alt="" width="200">
        </div>
        
         <div class="col-12">
           <label class="form-label"> Select New File</label>
                        <input type="file" name="newFile" class="form-control">
                        <span style="color: red;">
                            <?php echo $fileError; ?>
                        </span>
        </div>

        <div class="col-12">
          <button type="submit" name="updateBtn" class="btn btn-dark w-100">Update</button>
        </div>
      </form>
    </div>
  </div>
  <?php include('footer.php') ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>
</html>