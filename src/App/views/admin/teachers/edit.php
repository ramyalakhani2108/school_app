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
                                    <form class="forms-sample" id="edit_teacher" method="POST">

                                        <?php foreach ($teachers as $teacher) : ?>
                                            <?php
                                            // $i = 0;
                                            foreach ($teacher as $k => $v) :

                                                $ignore = ['id', 'created_at', 'updated_at', 'storage_filename', 'profile', 'user_id', 'password', 'role_id', 'status', 'role', 'dob'];

                                                if (in_array($k, $ignore)) {
                                                    continue;
                                                }
                                                if ($k == 'gender') {
                                                    if ($v == 'F') {
                                                        $v = 'Female';
                                                    } else if ($v == 'M') {
                                                        $v = 'Male';
                                                    } else {
                                                        $v = 'Other';
                                                    }
                                                }
                                            ?>
                                                <div class="form-group">
                                                    <label for="exampleInputName1"><?php echo e($k); ?></label>
                                                    <input type="text" value="<?php echo e($v ?? "");  ?>" name="<?php echo e($k); ?>" class="form-control" id="exampleInputName1" name="sub_name" placeholder="Enter Subject Name...">
                                                </div>
                                                <?php if (array_key_exists($k, $errors)) : ?>
                                                    <div class="bg-gray-100 mt-2 p-2 text-red-500" style="color:red">
                                                        <?php echo e($errors[$k][0]); ?>
                                                    </div>
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                            <div class="form-group">
                                                <label for="exampleInputName1">Date of Birth</label>
                                                <input type="date" value="<?php echo e($teacher['dob'] ?? ""); ?>" name="dob" class="form-control" id="exampleInputName1" name="sub_name" placeholder="Enter Subject Name...">
                                            </div>
                                            <?php if (array_key_exists('dob', $errors)) : ?>
                                                <div class="bg-gray-100 mt-2 p-2 text-red-500" style="color:red">
                                                    <?php echo e($errors['dob'][0]); ?>
                                                </div>
                                            <?php endif; ?>
                                        <?php
                                        endforeach; ?>




                                        <?php $i = 1;
                                        $teacher_ids = [];
                                        // dd($teachers_sub);
                                        // function is_teacher_added(int $teacher_id, array $teachers_sub)
                                        // {
                                        //     return in_array($teacher_id, $teachers_sub);
                                        // }
                                        // foreach ($teachers as $teacher) :
                                        //     $teacher_ids[] = $teacher['id'];
                                        //     $isAdded = is_teacher_added($teacher['id'], $teachers_sub);

                                        // endforeach; 
                                        ?>

                                        <label for="exampleInputName1">Select subjects</label>

                                        <?php $i = 1;
                                        $std_id = [];
                                        // dd($teachers_sub);

                                        foreach ($teacher_stds as $stds) :
                                            $std_id[] = $stds['id'];

                                        endforeach;

                                        ?>

                                        <table class="table">
                                            <thead align="center">
                                                <tr>
                                                    <th>
                                                        <input type="checkbox" id="selectAll" onclick="toggleCheckboxes(this)">
                                                    </th>
                                                    <th>Standard Name</th>
                                                    <!-- Empty header for the second column -->
                                                    <th></th>
                                                    <th>Standard Name</th>
                                                    <th></th> <!-- Empty header for the third column -->

                                                    <th>Standard Name</th>
                                                </tr>
                                            </thead>
                                            <tbody align="center">
                                                <?php
                                                $total_stds = count($teacher_stds);
                                                // dd($total_stds);

                                                $part = ceil($total_stds / 3); // Divide subs into 3 columns

                                                $first_part = array_slice($teacher_stds, 0, $part);
                                                $second_part = array_slice($teacher_stds, $part, $part);
                                                $third_part = array_slice($teacher_stds, 2 * $part);

                                                for ($i = 0; $i < $part; $i++) :
                                                    $std1 = isset($first_part[$i]) ? $first_part[$i] : null;
                                                    $std2 = isset($second_part[$i]) ? $second_part[$i] : null;
                                                    $std3 = isset($third_part[$i]) ? $third_part[$i] : null;
                                                ?>
                                                    <tr>
                                                        <?php if ($std1) : ?>
                                                            <td>
                                                                <input type="checkbox" name="selected_standards[]" value="<?php echo e($std1['id']); ?>" class="record-checkbox">
                                                            </td>
                                                            <td><?php echo e($std1['name']); ?></td>
                                                        <?php else : ?>
                                                            <td colspan="2"></td>
                                                        <?php endif; ?>

                                                        <?php if ($std2) : ?>
                                                            <td>
                                                                <input type="checkbox" name="selected_standards[]" value="<?php echo e($std2['id']); ?>" class="record-checkbox">
                                                            </td>
                                                            <td><?php echo e($std2['name']); ?></td>
                                                        <?php else : ?>
                                                            <td colspan="2"></td>
                                                        <?php endif; ?>

                                                        <?php if ($std3) : ?>
                                                            <td>
                                                                <input type="checkbox" name="selected_standards[]" value="<?php echo e($std3['id']); ?>" class="record-checkbox">
                                                            </td>
                                                            <td><?php echo e($std3['name']); ?></td>
                                                        <?php else : ?>
                                                            <td colspan="2"></td>
                                                        <?php endif; ?>
                                                    </tr>
                                                <?php endfor; ?>
                                            </tbody>
                                        </table>



                                        <label for="exampleInputName1">Select subjects</label>

                                        <?php $i = 1;
                                        $std_id = [];
                                        // dd($teachers_sub);
                                        // function is_std_added(int $std_id, array $sub_ids)
                                        // {

                                        //     return !in_array($std_id, $sub_ids);
                                        // }
                                        // foreach ($subs as $stds) :
                                        //     $std_id[] = $stds['id'];
                                        //     $isAdded = is_std_added($stds['id'], $sub_ids);

                                        // endforeach;
                                        ?>

                                        <table class="table">
                                            <thead align="center">
                                                <tr>
                                                    <th>
                                                        <input type="checkbox" id="selectAll" onclick="toggleCheckboxes2(this)">
                                                    </th>
                                                    <th>Subject Name</th>
                                                    <!-- Empty header for the second column -->
                                                    <th></th>
                                                    <th>Subject Name</th>
                                                    <th></th> <!-- Empty header for the third column -->

                                                    <th>Subject Name</th>
                                                </tr>
                                            </thead>
                                            <tbody align="center">
                                                <?php
                                                $total_subs = count($subs);
                                                $part = ceil($total_subs / 3); // Divide subs into 3 columns
                                                $first_part = array_slice($subs, 0, $part);
                                                $second_part = array_slice($subs, $part, $part);
                                                $third_part = array_slice($subs, 2 * $part);

                                                for ($i = 0; $i < $part; $i++) :
                                                    $std1 = isset($first_part[$i]) ? $first_part[$i] : null;
                                                    $std2 = isset($second_part[$i]) ? $second_part[$i] : null;
                                                    $std3 = isset($third_part[$i]) ? $third_part[$i] : null;
                                                ?>
                                                    <tr>
                                                        <?php if ($std1) : ?>
                                                            <td>
                                                                <input type="checkbox" name="selected_subjects[]" value="<?php echo e($std1['id']); ?>" class="record-checkbox2">
                                                            </td>
                                                            <td><?php echo e($std1['name']); ?></td>
                                                        <?php else : ?>
                                                            <td colspan="2"></td>
                                                        <?php endif; ?>

                                                        <?php if ($std2) : ?>
                                                            <td>
                                                                <input type="checkbox" name="selected_subjects[]" value="<?php echo e($std2['id']); ?>" class="record-checkbox2">
                                                            </td>
                                                            <td><?php echo e($std2['name']); ?></td>
                                                        <?php else : ?>
                                                            <td colspan="2"></td>
                                                        <?php endif; ?>

                                                        <?php if ($std3) : ?>
                                                            <td>
                                                                <input type="checkbox" name="selected_subjects[]" value="<?php echo e($std3['id']); ?>" class="record-checkbox2">
                                                            </td>
                                                            <td><?php echo e($std3['name']); ?></td>
                                                        <?php else : ?>
                                                            <td colspan="2"></td>
                                                        <?php endif; ?>
                                                    </tr>
                                                <?php endfor; ?>
                                            </tbody>
                                        </table>


                                        <input type="hidden" name="tid" value=<?php echo e($teachers[0]['id']); ?>>

                                        <button type="button" onclick="form_submit()" class="btn btn-primary mr-2">Submit</button>
                                        <button type="button" class="btn btn-dark" onclick="reset_form()">Cancel</button>
                                        <script>
                                            function reset_form() {
                                                document.getElementById("addSub").reset();
                                            }

                                            function form_submit() {
                                                const form = document.getElementById("edit_teacher");
                                                form.submit();
                                            }
                                        </script>
                                    </form>

                                    <br>
                                    <!-- <button type="submit" class="btn btn-inverse-danger btn-fw" style="width: 10px;padding-top:15px;padding-bottom:15px">Delete Selected</button> -->




                                    <script>
                                        function toggleCheckboxes(selectAllCheckbox) {
                                            // Get all checkboxes with the class "record-checkbox"
                                            const checkboxes = document.querySelectorAll('.record-checkbox');
                                            checkboxes.forEach(checkbox => {
                                                checkbox.checked = selectAllCheckbox.checked;
                                            });
                                        }

                                        function toggleCheckboxes2(selectAllCheckbox) {
                                            // Get all checkboxes with the class "record-checkbox"
                                            const checkboxes = document.querySelectorAll('.record-checkbox2');
                                            checkboxes.forEach(checkbox => {
                                                checkbox.checked = selectAllCheckbox.checked;
                                            });
                                        }
                                    </script>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="row">

                        <div class="col-12 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">Add subjects</h4>
                                    <!-- <p class="card-description"> Basic form elements </p> -->
                                    <form method="POST" action="/admin/subjects/add_teachers">
                                        <table class="table">
                                            <thead align="center">
                                                <tr>
                                                    <th>
                                                        <input type="checkbox" id="selectAll" onclick="toggleCheckboxes2(this)">
                                                    </th>
                                                    <th>ID</th>
                                                    <th>subjects Names</th>
                                                    <th>Teacher Email</th>
                                                    <th>Action</th>
                                                    <th>ID</th>
                                                    <th>Teacher Names</th>
                                                    <th>Teacher Email</th>


                                                </tr>
                                            </thead>
                                            <tbody align="center">
                                                <tr>
                                                    <?php

                                                    $total_subjects = count($subjects);
                                                    $part = ceil($total_subjects / 2);
                                                    $first_part = array_slice($subjects, 0, $part);
                                                    $second_part = array_slice($subjects, $part, $part);

                                                    for ($i = 0; $i < $part; $i++) :
                                                        $std1 = isset($first_part[$i]) ? $first_part[$i] : null;

                                                        $std2 = isset($second_part[$i]) ? $second_part[$i] : null;
                                                    ?>

                                                        <?php if ($std1) : ?>
                                                            <td>
                                                                <input type="checkbox" name="selected_ids[]" value="<?php echo e($std1['id']); ?>" class="record-checkbox2">
                                                            </td>
                                                            <td><?php echo e($std1['id']); ?></td>
                                                            <td><?php echo e($std1['name']); ?></td>


                                                            <td>

                                                                <a href="/admin/teachers/remove_subs/<?php echo e($std1['id']) ?>/<?php echo e($teacher['id']); ?>" class="btn btn-inverse-danger btn-fw" style="width: 10px;padding-top:15px;padding-bottom:15px">Remove</a>

                                                            </td>
                                                        <?php else : ?>
                                                            <td colspan="5"></td>
                                                        <?php endif; ?>

                                                        <?php if ($std2) :  ?>
                                                            <td>
                                                                <input type="checkbox" name="selected_ids[]" value="<?php echo e($std2['id']); ?>" class="record-checkbox2">
                                                            </td>
                                                            <td><?php echo e($std2['id']); ?></td>
                                                            <td><?php echo e($std2['name']); ?></td>


                                                            <td>

                                                                <a href="/admin/teachers/remove_subs/<?php echo e($std2['id']) ?>/<?php echo e($teacher['id']); ?>" class="btn btn-inverse-danger btn-fw" style="width: 10px;padding-top:15px;padding-bottom:15px">Remove</a>


                                                            </td>
                                                        <?php else : ?>
                                                            <td colspan="5"></td>
                                                        <?php endif; ?>

                                                </tr>
                                            <?php endfor; ?>
                                            </tbody>
                                        </table>

                                        <br>
                                    </form>

                                    <script>
                                        function toggleCheckboxes(selectAllCheckbox) {
                                            // Get all checkboxes with the class "record-checkbox"
                                            const checkboxes = document.querySelectorAll('.record-checkbox');
                                            checkboxes.forEach(checkbox => {
                                                checkbox.checked = selectAllCheckbox.checked;
                                            });
                                        }

                                        function toggleCheckboxes2(selectAllCheckbox) {
                                            // Get all checkboxes with the class "record-checkbox"
                                            const checkboxes = document.querySelectorAll('.record-checkbox2');
                                            checkboxes.forEach(checkbox => {
                                                checkbox.checked = selectAllCheckbox.checked;
                                            });
                                        }
                                    </script>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">

                        <div class="col-12 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">Add Standards</h4>
                                    <!-- <p class="card-description"> Basic form elements </p> -->
                                    <form method="POST" action="/admin/subjects/add_teachers">
                                        <table class="table">
                                            <thead align="center">
                                                <tr>
                                                    <th>
                                                        <input type="checkbox" id="selectAll" onclick="toggleCheckboxes2(this)">
                                                    </th>
                                                    <th>ID</th>
                                                    <th>Standards Names</th>
                                                    <th>Action</th>
                                                    <th></th>
                                                    <th>ID</th>
                                                    <th>Standards Names</th>
                                                    <th>Action</th>


                                                </tr>
                                            </thead>
                                            <tbody align="center">
                                                <?php
                                                $total_standards = count($standards);
                                                $part = ceil($total_standards / 2);
                                                $first_part = array_slice($standards, 0, $part);
                                                $second_part = array_slice($standards, $part, $part);

                                                for ($i = 0; $i < $part; $i++) :
                                                    $std1 = isset($first_part[$i]) ? $first_part[$i] : null;

                                                    $std2 = isset($second_part[$i]) ? $second_part[$i] : null;
                                                ?>
                                                    <tr>
                                                        <?php if ($std1) : ?>
                                                            <td>
                                                                <input type="checkbox" name="selected_ids[]" value="<?php echo e($std1['id']); ?>" class="record-checkbox2">
                                                            </td>
                                                            <td><?php echo e($std1['id']); ?></td>
                                                            <td><?php echo e($std1['name']); ?></td>


                                                            <td>

                                                                <a href="/admin/teachers/remove_stds/<?php echo e($std1['id']) ?>/<?php echo e($teacher['id']); ?>" class="btn btn-inverse-danger btn-fw" style="width: 10px;padding-top:15px;padding-bottom:15px">Remove</a>

                                                            </td>
                                                        <?php else : ?>
                                                            <td colspan="5"></td>
                                                        <?php endif; ?>

                                                        <?php if ($std2) :  ?>
                                                            <td>
                                                                <input type="checkbox" name="selected_ids[]" value="<?php echo e($std2['id']); ?>" class="record-checkbox2">
                                                            </td>
                                                            <td><?php echo e($std2['id']); ?></td>
                                                            <td><?php echo e($std2['name']); ?></td>


                                                            <td>

                                                                <a href="/admin/teachers/remove_stds/<?php echo e($std2['id']) ?>/<?php echo e($teacher['id']); ?>" class="btn btn-inverse-danger btn-fw" style="width: 10px;padding-top:15px;padding-bottom:15px">Remove</a>


                                                            </td>
                                                        <?php else : ?>
                                                            <td colspan="5"></td>
                                                        <?php endif; ?>

                                                    </tr>
                                                <?php endfor; ?>
                                            </tbody>
                                        </table>

                                        <br>
                                    </form>

                                    <script>
                                        function toggleCheckboxes(selectAllCheckbox) {
                                            // Get all checkboxes with the class "record-checkbox"
                                            const checkboxes = document.querySelectorAll('.record-checkbox');
                                            checkboxes.forEach(checkbox => {
                                                checkbox.checked = selectAllCheckbox.checked;
                                            });
                                        }

                                        function toggleCheckboxes2(selectAllCheckbox) {
                                            // Get all checkboxes with the class "record-checkbox"
                                            const checkboxes = document.querySelectorAll('.record-checkbox2');
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