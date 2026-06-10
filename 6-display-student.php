<?php
include('1-auth.php');
include('3-config.php');

// search botton logic
if (isset($_GET['search'])) {
    $search = $_GET['search'];
    $query = "select * from students2 where name like '%$search%'
    or email like '%$search%'
    or course like '%$search%'
    ";
} else {
    $query = "select * from students2";
}
$data = mysqli_query($conn, $query);
$total = mysqli_num_rows($data);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</head>

<body class="bg-body-secondary" style="padding-top:75px;">

  <?php include('navbar.php'); ?>

    <div class="container-fluid">
        <!-- content -->
        <?php
        if ($total > 0) {
        ?>
            <div class="table-responsive">
                <h2 class="m2-4 text-center text-uppercase">All Students</h2>

                <!-- search bar-->
                <form method="get" class="d-flex mb-3 ">
                    <input type="text"
                        class="form-control me-2"
                        placeholder="Search student"
                        name="search"
                        value="<?php echo $_GET['search'] ?? ''; ?>">
                    <button class="btn btn-dark">Search</button>
                </form>

                <!-- student added msg -->
                <?php
                if (isset($_GET['msg']) && $_GET['msg'] == "added") {
                ?>
                    <div id="successMsg" class="alert alert-success">
                        Student added successfully
                    </div>
                <?php
                }
                ?>

                <!-- student edited msg -->
                <?php
                if (isset($_GET['msg']) && $_GET['msg'] == "success") {
                ?>
                    <div id="editSuccess" class="alert alert-success">
                        Student edited successfully
                    </div>
                <?php
                }
                ?>

                <!-- student deleted msg -->
                <?php
                if (isset($_GET['msg']) && $_GET['msg'] == "delete") {
                ?>
                    <div id="deleteSuccess" class="alert alert-success">
                        Student deleted successfully
                    </div>
                <?php
                }
                ?>

                <table class="table table-secondary table-striped table-hover table-bordered table-sm mb-5 p-2 rounded-2">
                    <thead>
                        <tr class="table-dark">
                            <th>Id</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>gender</th>
                            <th>Phone</th>
                            <th>Course</th>
                            <th>address</th>
                            <th>file</th>
                            <th>Operations</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php
                        while ($row = mysqli_fetch_assoc($data)) {
                        ?>
                            <tr>
                                <td><?php echo $row['id'] ?></td>
                                <td><?php echo $row['name'] ?></td>
                                <td><?php echo $row['email'] ?></td>
                                <td><?php echo $row['gender'] ?></td>
                                <td><?php echo $row['phone'] ?></td>
                                <td><?php echo $row['course'] ?></td>
                                <td><?php echo $row['address'] ?></td>
                                <td><img src="<?php echo $row['file']; ?>" alt="<?php echo $row['name'] ?>" style="width:100px; height:60px; object-fit:cover; border-radius:10px;"></td>
                                <td class=" text-center">
                                    <a href="7-edit.php?id=<?php echo $row['id'] ?>"
                                        class="btn btn-sm btn-dark me-2 my-2">
                                        Edit
                                    </a>

                                    <a href="8-delete.php?id=<?php echo $row['id'] ?>"
                                        class="btn btn-sm btn-danger"
                                        onclick="return confirm('Are you sure?')">
                                        Delete
                                    </a>
                                </td>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        <?php
        } else {
        ?>
            <div class='alert alert-danger' id='noDataErr'>
                No Students Found
            </div>
        <?php
        }
        ?>
    </div>
    <?php include('footer.php') ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
    <script>

        // add student
        let successMsg = document.getElementById("successMsg");
        if(successMsg){
        setTimeout(() => {
          successMsg .style.display = "none";
        }, 3000);
}
      
        // edit
          let editSuccess = document.getElementById("editSuccess");
        setTimeout(() => {
            editSuccess.style.display = "none";
        }, 3000);

        // delete
        let deleteSuccess = document.getElementById("deleteSuccess");
        setTimeout(() => {
            document.getElementById("deleteSuccess").style.display = "none";
        }, 3000);
     

        setTimeout(() => {
            let noDataError = document.getElementById("noDataErr");
            if ($noDataError) {
                setTimeout(() => {
                    window.location.href = "6-display-student.php";
                })
            }
        }, 3000);
    </script>
</body>

</html>