<?php include $this->resolve("partials/admin/_header.php"); ?>


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
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">Visitors by Countries</h4>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="table-responsive">
                                                <form method="POST" action="/admin/standards/deletestandards">
                                                    <input type="hidden" name="_METHOD" value="DELETE">
                                                    <table class="table">
                                                        <thead align="center">
                                                            <tr>
                                                                <th>
                                                                    <input type="checkbox" id="selectAll" onclick="toggleCheckboxes(this)">
                                                                </th>
                                                                <th>ID</th>
                                                                <th>Standard Names</th>
                                                                <th>Total Students</th>
                                                                <th>Total Teachers</th>
                                                                <th>Edit</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody align="center">
                                                            <?php $i = 1;
                                                            foreach ($standards as $standard) : ?>

                                                                <tr>
                                                                    <td>
                                                                        <input type="checkbox" name="selected_ids[]" value="<?php echo e($standard['standards_name']); ?>" class="record-checkbox">
                                                                    </td>
                                                                    <td><?php echo e($i++); ?></td>
                                                                    <td><?php echo e($standard['standards_name']); ?></td>
                                                                    <td><?php echo e($standard['student_count']); ?></td>
                                                                    <td class="text-end"><?php echo e($standard['teacher_count']); ?></td>
                                                                    <td>
                                                                        <a href="/admin/standards/editstandard/<?php echo e(urlencode($standard['standards_name'])); ?>" class="btn btn-inverse-success btn-fw" style="width: 10px;padding-top:15px;padding-bottom:15px">Edit</a>
                                                                    </td>
                                                                </tr>
                                                            <?php endforeach; ?>
                                                        </tbody>
                                                    </table>
                                                    <br>
                                                    <button type="submit" class="btn btn-inverse-danger btn-fw" style="width: 10px;padding-top:15px;padding-bottom:15px">Delete Selected</button>
                                                </form>

                                                <script>
                                                    function toggleCheckboxes(selectAllCheckbox) {
                                                        // Get all checkboxes with the class "record-checkbox"
                                                        const checkboxes = document.querySelectorAll('.record-checkbox');
                                                        checkboxes.forEach(checkbox => {
                                                            checkbox.checked = selectAllCheckbox.checked;
                                                        });
                                                    }
                                                </script>


                                            </div>

                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <!-- content-wrapper ends -->
        <!-- partial:partials/_footer.html -->
        <?php

        // dd($standards);
        $this->resolve("admin/partials/_footer.php") ?>
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