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
                                        <div class="custom-dropdown">
                                            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" aria-haspopup="true" aria-expanded="false">
                                                <i class="mdi mdi-filter-outline"></i> Filter
                                            </button>
                                            <div class="custom-dropdown-menu p-3" id="customDropdownMenu">
                                                <form id="filterForm" action="/admin/subjects/filtered_by/" method="POST">
                                                    <div class="dropdown-item">
                                                        <span class="dropdown-label" style="color:black">Teachers</span>
                                                        <div class="dropdown-submenu">
                                                            <?php foreach ($teachers as $teacher) : ?>
                                                                <label>
                                                                    <input type="checkbox" name="teacher_names[]" value="<?php echo htmlspecialchars($teacher); ?>"> <?php echo htmlspecialchars($teacher); ?>
                                                                </label>
                                                            <?php endforeach; ?>
                                                        </div>
                                                    </div>
                                                    <button type="submit" class="btn btn-primary mt-2">Apply Filter</button>
                                                </form>
                                            </div>
                                        </div>

                                        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                                        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
                                        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
                                        <script>
                                            $(document).ready(function() {
                                                $('.dropdown-submenu .dropdown-toggle').on("click", function(e) {
                                                    $(this).next('.dropdown-menu').toggle();
                                                    e.stopPropagation();
                                                    e.preventDefault();
                                                });
                                            });
                                        </script>
                                    </div>

                                    <div class="row">
                                        <div class="col-12">
                                            <div class="preview-list">
                                                <?php foreach ($filtered_subjects as $subject) {
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
                                                                Total Teachers : <?php echo e($subject['staff_name']); ?><br><br>
                                                                Total standards : <?php echo e($subject['standards']); ?>
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

                                                <?php } ?>
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
                    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                    <!-- Bootstrap JS -->
                    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
                    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            const dropdownButton = document.getElementById('dropdownMenuButton');
                            const customDropdownMenu = document.getElementById('customDropdownMenu');

                            dropdownButton.addEventListener('click', function(e) {
                                e.stopPropagation();
                                customDropdownMenu.style.display = customDropdownMenu.style.display === 'block' ? 'none' : 'block';
                            });

                            document.addEventListener('click', function(e) {
                                if (!dropdownButton.contains(e.target) && !customDropdownMenu.contains(e.target)) {
                                    customDropdownMenu.style.display = 'none';
                                }
                            });
                        });
                    </script>
                    <style>
                        .custom-dropdown {
                            position: relative;
                            display: inline-block;
                        }

                        .custom-dropdown-menu {
                            display: none;
                            position: absolute;
                            background-color: white;
                            min-width: 250px;
                            box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
                            z-index: 1;
                            padding: 10px;
                            border-radius: 4px;
                        }

                        .dropdown-item {
                            position: relative;

                        }

                        .dropdown-item:hover {
                            position: relative;
                            background-color: aquamarine;
                            color: black;

                        }

                        .dropdown-label {
                            display: block;
                            padding: 8px 10px;
                            cursor: pointer;
                            font-weight: bold;
                        }


                        .dropdown-submenu {
                            display: none;
                            position: absolute;
                            left: 0;
                            top: 100%;
                            background-color: white;
                            min-width: 200px;
                            box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
                            padding: 10px;
                            border-radius: 4px;
                        }

                        .custom-dropdown:hover .custom-dropdown-menu {
                            display: block;
                        }

                        .dropdown-item:hover .dropdown-submenu {
                            display: block;
                        }

                        .dropdown-submenu label {
                            display: block;
                            padding: 8px 10px;
                            cursor: pointer;
                        }

                        .dropdown-submenu label:hover {
                            background-color: #f1f1f1;
                        }
                    </style>

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