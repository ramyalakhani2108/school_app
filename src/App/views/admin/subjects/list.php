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
                                    <h6 class="text-muted font-weight-normal">Total Class</h6>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div>
                                            <h4 class="card-title mb-1">Subjects</h4>
                                            <p class="text-muted mb-1">Subjects for all class</p>
                                        </div>
                                        <?php include $this->resolve("admin/subjects/partials/_searchbar.php"); ?>

                                        <?php include $this->resolve("admin/subjects/partials/_filter.php"); ?>


                                    </div>

                                    <div class="row">
                                        <div class="col-12">
                                            <div class="preview-list">
                                                <?php
                                                $subjects = [];

                                                $subjects = array_merge($subjects, $filtered_subjects);

                                                foreach ($subjects as  $subject) {
                                                ?>

                                                    <div class="preview-item border-bottom">
                                                        <div class="preview-thumbnail">
                                                            <div class="preview-icon bg-primary">
                                                                <i class="mdi mdi-file-document"></i>
                                                            </div>
                                                        </div>
                                                        <div class="preview-item-content d-sm-flex flex-grow">
                                                            <div class="flex-grow">
                                                                <h6 class="preview-subject"><?php echo e($subject['subject_names']); ?></h6>
                                                                <p class="text-muted mb-0"><?php echo e($subject['subject_codes']); ?></p>
                                                            </div>
                                                            <div class="mr-auto text-sm-right pt-3 pt-sm-0">
                                                                Teachers : <?php echo e($subject['staff_name']); ?><br><br>
                                                                Standards : <?php echo e($subject['standards']); ?>
                                                            </div>


                                                            <div class="mr-auto text-sm-right pt-2 pt-sm-0">
                                                                <p class="text-muted">
                                                                    <a href="/admin/subjects/edit_subjects/<?php echo e($subject['subject_ids']); ?>"><button type="button" class="btn btn-success btn-fw mt-2 col-5 ml-5 pt-3 pb-3 pl-2 pr-2">Edit</button></a>
                                                                </p>
                                                                <p class="text-muted mb-0">
                                                                <form action="/admin/subjects/delete_subjects/<?php echo e($subject['subject_ids']); ?>" method="post">
                                                                    <input type="hidden" name="_METHOD" value="DELETE">
                                                                    <button type="submit" class="btn btn-danger btn-fw mt-2 col-5 ml-5 pt-3 pb-3 pl-2 pr-2">Delete</button>
                                                                </form>
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>

                                                <?php  }
                                                ?>
                                            </div>
                                        </div>

                                    </div>
                                    <button type="button" class="btn btn-success btn-fw mt-3 col-5 ml-5 p-4" style="padding:15px;font-size:20px;margin-right:20px;" onclick="add_subject()">Add Subject</button>
                                    <script>
                                        function add_subject() {
                                            window.location.href = "/admin/subjects/create_subject";
                                        }
                                    </script>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
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