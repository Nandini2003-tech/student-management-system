<?php
include('1-auth.php');
include('3-config.php');

// total students 
$totalQuery = "select * from students2";
$totalData = mysqli_query($conn, $totalQuery);
$totalStudents = mysqli_num_rows($totalData);

// male Students
$maleQuery = "select * from students2 where gender= 'Male'";
$maleData = mysqli_query($conn, $maleQuery);
$totalMale = mysqli_num_rows($maleData);

// female Students
$femaleQuery = "select * from students2 where gender='Female'";
$femaleData = mysqli_query($conn, $femaleQuery);
$totalFemale = mysqli_num_rows($femaleData);

//  course
$courseQuery = "select distinct course from students2";
$courseData = mysqli_query($conn, $courseQuery);
$totalCourses = mysqli_num_rows($courseData);
?>

<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>dashboard</title>

  <!-- cdn -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
  <style>
    .dashboard-box {
      min-height: 85vh;
    }

    .card {
      transition: 0.3s;
    }

    .card:hover {
      transform: translateY(-5px) scale(1.02);
    }
  </style>
</head>

<body class="bg-body-secondary" style="padding-top: 80px;">
  <!-- navbar -->
  <?php include('navbar.php'); ?>

  <!-- container -->
  <div class="container">
    <h1 class=" text-center">Admin Dashboard</h1>
    <div class="row g-4 text-center mt-1">

      <div class="col-md-4 text-decoration-none">
        <div class="card bg-dark text-white shadow border-0 h-100">
          <div class="card-body text-center">
            <i class="bi bi-people-fill fs-1 mb-2"></i>
            <h5 class="card-title">Total Students</h5>
            <p class="display-5 fw-bold"><?php echo $totalStudents ?></p>
          </div>
        </div>
      </div>

      <div class="col-md-4 text-decoration-none text-dark">
        <div class="card  bg-primary text-white shadow border-0 h-100">
          <div class="card-body text-center">
            <i class="bi bi-person-fill fs-1 mb-2"></i>
            <h5 class="card-title">Male Students</h5>
            <p class="display-5 fw-bold"><?php echo $totalMale ?></p>
          </div>
        </div>
      </div>

      <div class="col-md-4 text-decoration-none text-dark">
        <div class="card bg-danger text-white shadow border-0 h-100">
          <div class="card-body text-center">
            <i class="bi bi-person-hearts fs-1 mb-2"></i>
            <h5 class="card-title">Female Students</h5>
            <p class="display-5 fw-bold"><?php echo $totalFemale ?></p>
          </div>
        </div>
      </div>

      <div class="col-md-4 text-decoration-none text-dark">
        <div class="card bg-success text-white shadow border-0 h-100">
          <div class="card-body text-center">
            <i class="bi bi-book-fill fs-1 mb-2"></i>
            <h5 class="card-title">Total Courses</h5>
            <p class="display-5 fw-bold"><?php echo $totalCourses ?></p>
          </div>
        </div>
      </div>


      <div class="col-md-4">
        <a href="5-add-student.php" class="text-decoration-none text-dark">
          <div class="card bg-success-subtle shadow border-0 h-100">
            <div class="card-body text-center">
              <i class="bi bi-person-fill-add fs-1 mb-2"></i>
              <h5 class="card-title">Add Student</h5>
            </div>
          </div>
        </a>
      </div>

      <div class="col-md-4">
        <a href="6-display-student.php" class="text-decoration-none text-dark">
          <div class="card bg-info-subtle shadow border-0 h-100">
            <div class="card-body text-center">
              <i class="bi bi-display-fill fs-1 mb-2"></i>
              <h5 class="card-title ">View Students</h5>
            </div>
          </div>
        </a>
      </div>

    </div>
  </div>
  <?php include('footer.php') ?>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>

</html>