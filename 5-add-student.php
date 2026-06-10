<!-- php -->
<?php
include('1-auth.php');
include('3-config.php');

//   Error Variables
$nameError = "";
$emailError = "";
$genderError = "";
$phoneError = "";
$courseError = "";
$addressError = "";
$fileError = "";
$errorMsg = "";

//  if adbtn button click
if (isset($_POST['addBtn'])) {
  // get values from form
  $name = $_POST['name'];
  $email = $_POST['email'];
  $gender = $_POST['gender'];
  $phone = $_POST['phone'];
  $course = $_POST['course'];
  $address = $_POST['address'];
  //  image
  $fileName = $_FILES['file']['name'];
  $tempName = $_FILES['file']['tmp_name'];
  $fileType = $_FILES['file']['type'];
  $fileSize = $_FILES['file']['size'];
  // folder setup
  $folder = "uploads2/" . $fileName;

  //  validations of form data

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
  } else {
    $checkEmail = "select * from students2 where email = '$email'";
    $result = mysqli_query($conn, $checkEmail);

    if (mysqli_num_rows($result) > 0) {
      $emailError = "Email Already exist";
    }
  }

  // gender
  if (empty($gender)) {
    $genderError = "Please select gender";
  }

  // phone
  if (empty($phone)) {
    $phoneError = "phone number required";
  } elseif (strlen($phone) != 10) {
    $phoneError = "phone numner must be 10 digits";
  } elseif (!is_numeric($phone)) {
    $phoneError = "Only numbers allowed";
  } else {
    $checkPhone = "SELECT * FROM students2 WHERE phone='$phone'";
    $phoneData = mysqli_query($conn, $checkPhone);
    if (mysqli_num_rows($phoneData) > 0) {
      $phoneError = "Phone already exists";
    }
  }

  // course
  if (empty($course)) {
    $courseError = "Please select course";
  }

  // address
  if (empty($address)) {
    $addressError = "address required";
  }

  // file
  // find file extension
  $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

  //  create array and fill valid extension 
  $allowedExt = ['jpg', 'jpeg', 'png'];

  if (empty($fileName)) {
    $fileError = "Please select an image";

  } elseif (!in_array($fileExt, $allowedExt)) {
    $fileError = "Only jpg jpeg png allowed";
    
  } elseif ($fileSize > 2000000) {
    $fileError = "File too large";
  }

  // if all data in correct form
  if (
    $nameError == "" &&
    $emailError == "" &&
    $genderError == "" &&
    $phoneError == "" &&
    $courseError == "" &&
    $addressError == "" &&
    $fileError == ""
  )
  // then move temp img to folder and start insert query
  {
    move_uploaded_file($tempName, $folder);
    $query = "insert into students2(name,email,gender,phone,course,address,file) values('$name','$email','$gender','$phone', '$course','$address','$folder')";

    $result = mysqli_query($conn, $query);

    if ($result) {
      header("Location:6-display-student.php?msg=added");
      exit();
    } else {
      $errorMsg = "Failed" . mysqli_error($conn);
    }
  }
}
?>

<!-- html -->
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Add student</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</head>

<body class="bg-body-secondary" style='padding-top:100px;'>
  <?php include('navbar.php'); ?>

  <div class="container-fluid bg-secondary-subtle px-0">
    <div class="container-lg">
      <?php
      if ($errorMsg != "") {
      ?>
        <div class="alert alert-danger mt-3">
          <?php echo $errorMsg; ?>
        </div>
      <?php
      }
      ?>
      <form class="row g-3 bg-white border border-light  rounded-3 px-4 pb-4 mb-5" action="#" method="post" enctype="multipart/form-data">
        <h2 class="mb-2 text-center">Add Student</h2>

        <div class="col-md-6">
          <label for="inputEmail4" class="form-label">Student Name</label>
          <input type="text" name="name" value="<?php echo $name ?? ""; ?>" class="form-control">
          <span style="color: red;">
            <?php echo $nameError; ?>
          </span>
        </div>

        <div class="col-md-6">
          <label for="inputEmail4" class="form-label">Email</label>
          <input type="email" name="email" value="<?php echo $email ?? ""; ?>" class="form-control">
          <span style="color: red;">
            <?php echo $emailError; ?>
          </span>
        </div>

        <div class="col-md-6">
          <label for="inputPassword4" class="form-label">Gender</label>
          <select name="gender" class="form-select">
            <option value="">Select Gender</option>
            <option value="Male">Male</option>
            <option value="Female">Female</option>
          </select>
          <span style="color: red;">
            <?php echo $genderError; ?>
          </span>
        </div>

        <div class="col-md-6">
          <label for="inputEmail4" class="form-label">Phone</label>
          <input type="tel" name="phone" value="<?php echo $phone ?? ""; ?>" class="form-control">
          <span style="color: red;">
            <?php echo $phoneError; ?>
          </span>
        </div>

        <div class="col-12">
          <label for="inputAddress" class="form-label">Address</label>
          <textarea name="address" name="address" class="form-control" rows="3"><?php echo $address ?? ""; ?></textarea>
          <span style="color: red;">
            <?php echo $addressError; ?>
          </span>
        </div>

        <div class="col-md-6">
          <label for="inputState" class="form-label">Course</label>
          <select name="course" class="form-select">
            <option value="">Select course</option>
            <option value="BCA">BCA</option>
            <option value="BSc IT">BSc IT</option>
            <option value="MCA">MCA</option>
          </select>
          <span style="color: red;">
            <?php echo $courseError; ?>
          </span>
        </div>

        <div class="col-12">
          <label class="form-label">Upload Image</label>
          <input type="file" name="file" class="form-control">
          <span style="color: red;">
            <?php echo $fileError; ?>
          </span>
        </div>
        <div class="col-12">
          <div class="form-check">
            <input class="form-check-input" type="checkbox" id="gridCheck">
            <label class="form-check-label" for="gridCheck">
              Check me out
            </label>
          </div>
        </div>
        <div class="col-12">
          <button type="submit" name="addBtn" class="btn btn-dark w-100">Add student</button>
        </div>
      </form>
    </div>
  </div>
  <?php include('footer.php') ?>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>

</html>