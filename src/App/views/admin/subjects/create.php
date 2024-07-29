<?php include $this->resolve("partials/admin/_header.php");


?>


<body>

    <link rel="stylesheet" href="/assets/admin/assets/vendors/select2/select2.min.css">
    <link rel="stylesheet" href="/assets/admin/assets/vendors/select2-bootstrap-theme/select2-bootstrap.min.css">
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
                                                <h3 class="mb-0"><?php echo e($total_class ?? '0'); ?></h3>
                                                <!-- <p class="text-danger ml-2 mb-0 font-weight-medium">-2.4%</p> -->
                                            </div>
                                        </div>
                                        <div class="col-3">
                                            <div class="icon icon-box-danger">
                                                <span class="mdi mdi-arrow-bottom-left icon-item"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <h6 class="text-muted font-weight-normal">Total Class</h6>
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
                                    <h4 class="card-title">Add Subject</h4>
                                    <!-- <p class="card-description"> Basic form elements </p> -->
                                    <form class="forms-sample" id="addSub" method="POST">
                                        <div class="form-group">
                                            <label for="exampleInputName1">Subject Name</label>
                                            <input type="text" value="<?php echo e($oldFormData['sub_name'] ?? "");  ?>" class="form-control" id="exampleInputName1" name="sub_name" placeholder="Enter Subject Name...">
                                        </div>
                                        <?php if (array_key_exists('sub_name', $errors)) : ?>
                                            <div class="bg-gray-100 mt-2 p-2 text-red-500" style="color:red">
                                                <?php echo e($errors['sub_name'][0]); ?>
                                            </div>
                                        <?php endif; ?>
                                        <div class="form-group">
                                            <label for="exampleInputEmail3">Subject Code</label>
                                            <input type="text" value="<?php echo e($oldFormData['sub_code'] ?? "");  ?>" class="form-control" id="exampleInputEmail3" name="sub_code" placeholder="Enter Subject Code">
                                        </div>
                                        <?php if (array_key_exists('sub_code', $errors)) : ?>
                                            <div class="bg-gray-100 mt-2 p-2 text-red-500" style="color:red">
                                                <?php echo e($errors['sub_code'][0]); ?>
                                            </div>
                                        <?php endif; ?>
                                        <div class="form-group">
                                            <label for="exampleInputPassword4">Standard Names</label>
                                            <input type="text" value="<?php echo e($oldFormData['standard_names'] ?? "");  ?>" class="form-control" id="exampleInputPassword4" name="standard_names" placeholder="Enter Classnames in Comma saperated values.....">
                                        </div>
                                        <?php if (array_key_exists('standard_names', $errors)) : ?>
                                            <div class="bg-gray-100 mt-2 p-2 text-red-500" style="color:red">
                                                <?php echo e($errors['standard_names'][0]); ?>
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
                                        <div class="form-group">
                                            <label for="exampleInputCity1">Teachers</label>
                                            <input type="text" value="<?php echo e($oldFormData['teacher_names'] ?? "");  ?>" class="form-control" id="exampleInputCity1" name="teacher_names" placeholder="Enter teachers teaching subjects in comma saperated value with respect to class names.......">
                                        </div>
                                        <?php if (array_key_exists('teacher_names', $errors)) : ?>
                                            <div class="bg-gray-100 mt-2 p-2 text-red-500" style="color:red">
                                                <?php echo e($errors['teacher_names'][0]); ?>
                                            </div>
                                        <?php endif; ?>
                                        <!-- <div class="form-group">
                                            <label for="exampleTextarea1">Notes Or Remarks</label>
                                            <textarea class="form-control" id="exampleTextarea1" rows="4"></textarea>
                                        </div> -->
                                        <button type="submit" class="btn btn-primary mr-2">Submit</button>
                                        <button type="button" class="btn btn-dark" onclick="reset_form()">Cancel</button>
                                        <script>
                                            function reset_form() {
                                                document.getElementById("addSub").reset();
                                            }
                                        </script>


                                        <div class="form-group">
                                            <label>Single select box using select 2</label>

                                        </div>
                                        <div class="form-group">
                                            <label>Multiple select using select 2</label>
                                            <select class="js-example-basic-multiple" multiple="multiple" style="width:100%">
                                                <option value="AL">Alabama</option>
                                                <option value="WY">Wyoming</option>
                                                <option value="AM">America</option>
                                                <option value="CA">Canada</option>
                                                <option value="RU">Russia</option>
                                            </select>
                                        </div>
                                </div>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
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

    <!-- endinject -->
    <!-- Plugin js for this page -->

    <!-- End plugin js for this page -->
    <!-- inject:js -->

    <!-- endinject -->
    <!-- Custom js for this page -->
    <script src="/assets/admin/assets/vendors/js/vendor.bundle.base.js"></script>
    <!-- endinject -->
    <!-- Plugin js for this page -->
    <script src="/assets/admin/assets/vendors/select2/select2.min.js"></script>
    <script src="/assets/admin/assets/vendors/typeahead.js/typeahead.bundle.min.js"></script>
    <script src="/assets/admin/assets/js/file-upload.js"></script>
    <script src="/assets/admin/assets/js/typeahead.js"></script>
    <script src="/assets/admin/assets/js/select2.js"></script>
</body>

</html>