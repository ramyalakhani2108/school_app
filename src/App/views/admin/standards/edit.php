<?php include $this->resolve("partials/admin/_header.php");


?>


<body>
    <div class="container-scroller">
        <!-- partial:partials/_sidebar.html -->
        <?php include $this->resolve("partials/admin/_sidebar.php"); ?>

        <!-- partial -->
        <div class="container-fluid page-body-wrapper">
            <!-- partial:partials/_navbar.html -->
            <?php include $this->resolve("partials/admin/_navbar.php"); ?>

            <!-- partial -->
            <div class="main-panel">
                <div class="content-wrapper">

                    <div class="row">
                        <div class="col-xl-4 col-sm-6 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-9">
                                            <div class="d-flex align-items-center align-self-start">
                                                <h3 class="mb-0"><?php echo e($total_subjects ?? ''); ?></h3>
                                                <!-- <p class="text-success ml-2 mb-0 font-weight-medium">+3.5%</p> -->
                                            </div>
                                        </div>
                                        <div class="col-3">
                                            <div class="icon icon-box-success ">
                                                <span class="mdi mdi-arrow-top-right icon-item"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <h6 class="text-muted font-weight-normal">Total Subjects</h6>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-4 col-sm-6 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-9">
                                            <div class="d-flex align-items-center align-self-start">
                                                <h3 class="mb-0"><?php echo e($total_students ?? '0'); ?></h3>

                                            </div>
                                        </div>
                                        <div class="col-3">
                                            <div class="icon icon-box-success">
                                                <span class="mdi mdi-arrow-top-right icon-item"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <h6 class="text-muted font-weight-normal">Total Students</h6>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-4 col-sm-6 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-9">
                                            <div class="d-flex align-items-center align-self-start">
                                                <h3 class="mb-0"><?php echo e($total_standards ?? '0'); ?></h3>
                                                <!-- <p class="text-danger ml-2 mb-0 font-weight-medium">-2.4%</p> -->
                                            </div>
                                        </div>
                                        <div class="col-3">
                                            <div class="icon icon-box-danger">
                                                <span class="mdi mdi-arrow-bottom-left icon-item"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <h6 class="text-muted font-weight-normal">Total Standards</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <!-- <div class="col-md-4 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">Transaction History</h4>
                                    <canvas id="transaction-history" class="transaction-chart"></canvas>
                                    <div class="bg-gray-dark d-flex d-md-block d-xl-flex flex-row py-3 px-4 px-md-3 px-xl-4 rounded mt-3">
                                        <div class="text-md-center text-xl-left">
                                            <h6 class="mb-1">Transfer to Paypal</h6>
                                            <p class="text-muted mb-0">07 Jan 2019, 09:12AM</p>
                                        </div>
                                        <div class="align-self-center flex-grow text-right text-md-center text-xl-right py-md-2 py-xl-0">
                                            <h6 class="font-weight-bold mb-0">$236</h6>
                                        </div>
                                    </div>
                                    <div class="bg-gray-dark d-flex d-md-block d-xl-flex flex-row py-3 px-4 px-md-3 px-xl-4 rounded mt-3">
                                        <div class="text-md-center text-xl-left">
                                            <h6 class="mb-1">Tranfer to Stripe</h6>
                                            <p class="text-muted mb-0">07 Jan 2019, 09:12AM</p>
                                        </div>
                                        <div class="align-self-center flex-grow text-right text-md-center text-xl-right py-md-2 py-xl-0">
                                            <h6 class="font-weight-bold mb-0">$593</h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> -->
                        <div class="col-12 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">

                                    <h4 class="card-title">Edit Standard</h4>
                                    <!-- <p class="card-description"> Basic form elements </p> -->
                                    <form id="editSub" class="forms-sample" action="/admin/standards/edit_standard/<?php echo e($standard); ?>" method="POST">
                                        <div class="form-group">
                                            <label for="exampleInputName1">Standard Name</label>
                                            <input type="text" value="<?php echo e($subject['subject_name'] ?? "");  ?>" class="form-control" id="exampleInputName1" name="sub_name" placeholder="Enter Subject Name...">
                                        </div>
                                        <?php if (array_key_exists('sub_name', $errors)) : ?>
                                            <div class="bg-gray-100 mt-2 p-2 text-red-500" style="color:red">
                                                <?php echo e($errors['sub_name'][0]); ?>
                                            </div>
                                        <?php endif; ?>


                                        <!-- <div class="form-group">
                                            <label for="exampleSelectGender">Gender</label>
                                            <select class="form-control" id="exampleSelectGender">
                                                <option>Male</option>
                                                <option>Female</option>
                                            </select>
                                        </div> -->
                                        <!-- <div class="form-group">
                                            <label>File upload</label>
                                            <input type="file" name="img[]" class="file-upload-default">
                                            <div class="input-group col-xs-12">
                                                <input type="text" class="form-control file-upload-info" disabled placeholder="Upload Image">
                                                <span class="input-group-append">
                                                    <button class="file-upload-browse btn btn-primary" type="button">Upload</button>
                                                </span>
                                            </div>
                                        </div> -->

                                        <!-- <div class="form-group">
                                            <label for="exampleTextarea1">Notes Or Remarks</label>
                                            <textarea class="form-control" id="exampleTextarea1" rows="4"></textarea>
                                        </div> -->
                                        <a><button type="submit" class="btn btn-primary mr-2">Submit</button></a>
                                        <button type="button" class="btn btn-dark" onclick="reset_form()">Cancel</button>
                                        <script>
                                            function reset_form() {
                                                document.getElementById("editSub").reset();
                                            }
                                        </script>
                                    </form>

                                </div>

                            </div>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">Visitors by Countries</h4>
                                    <table class="table">
                                        <thead align="center">
                                            <tr>
                                                <th>
                                                    <input type="checkbox" id="selectAll" onclick="toggleCheckboxes(this)">
                                                </th>
                                                <th>ID</th>
                                                <th>Student Name</th>
                                                <th>Student Roll Number</th>
                                                <!-- <th>Total Teachers</th> -->
                                                <th>Edit</th>
                                            </tr>
                                        </thead>
                                        <tbody align="center">
                                            <?php $i = 0;
                                            dd($standard[0]);
                                            $students = explode(",", $standard[0]['student_names']);
                                            $student_ids = explode(",", $standard[0]['student_ids']);
                                            $student_rolls = explode(",", $standard[0]['student_rolls']);



                                            ?>

                                            <tr>
                                                <td>
                                                    <input type="checkbox" name="selected_ids[]" value="<?php echo e($student_id); ?>" class="record-checkbox">
                                                </td>
                                                <td><?php echo e($students['id'][$i]); ?></td>
                                                <td><?php echo e($students['name'][$i]); ?></td>
                                                <td><?php echo e($students['rolls'][$i]); ?></td>

                                            </tr>

                                            <?php $i++;
                                            ?>
                                        </tbody>
                                    </table>
                                </div>

                            </div>

                            <!-- content-wrapper ends -->
                            <!-- partial:partials/_footer.html -->
                            <?php $this->resolve("admin/partials/_footer.php") ?>
                            <!-- partial -->
                        </div>
                        <!-- main-panel ends -->
                    </div>
                    <!-- page-body-wrapper ends -->
                </div>
                <!-- container-scroller -->
                <!-- plugins:js -->
                <script src="/assets/admin/assets/vendors/js/vendor.bundle.base.js"></script>
                <!-- endinject -->
                <!-- Plugin js for this page -->
                <script src="/assets/admin/assets/vendors/chart.js/Chart.min.js"></script>
                <script src="/assets/admin/assets/vendors/progressbar.js/progressbar.min.js"></script>
                <script src="/assets/admin/assets/vendors/jvectormap/jquery-jvectormap.min.js"></script>
                <script src="/assets/admin/assets/vendors/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
                <script src="/assets/admin/assets/vendors/owl-carousel-2/owl.carousel.min.js"></script>
                <!-- End plugin js for this page -->
                <!-- inject:js -->
                <script src="/assets/admin/assets/js/off-canvas.js"></script>
                <script src="/assets/admin/assets/js/hoverable-collapse.js"></script>
                <script src="/assets/admin/assets/js/misc.js"></script>
                <script src="/assets/admin/assets/js/settings.js"></script>
                <script src="/assets/admin/assets/js/todolist.js"></script>
                <!-- endinject -->
                <!-- Custom j/s for this page -->
                <script src="/assets/admin/assets/js/dashboard.js"></script>
                <!-- End custom js for this page -->
</body>

</html>

<?php dd([$students]); ?>