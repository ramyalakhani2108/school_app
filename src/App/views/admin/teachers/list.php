<?php include $this->resolve("partials/admin/_header.php");



?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />

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
                                            </div>
                                        </div>
                                        <div class="col-3">
                                            <div class="icon icon-box-success">
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

                    <!-- Search Bar Section -->
                    <div class="row">
                        <div class="col-md-12 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div>
                                            <h4 class="card-title mb-1">Teachers</h4>
                                            <p class="text-muted mb-1">Teachers for all class</p>
                                        </div>

                                        <?php include $this->resolve("admin/teachers/partials/_searchbar.php"); ?>
                                        <?php include $this->resolve("admin/teachers/partials/_filter.php"); ?>
                                    </div>
                                    <form id="list_teachers" method="POST">
                                        <input type="hidden" name="_METHOD" value="DELETE">
                                        <div class="table-responsive">
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th>
                                                            <input type="checkbox" id="selectAll" onclick="toggleCheckboxes(this)">
                                                        </th>
                                                        <th> Name
                                                            <a href="#" onclick="sort('id','asc')"><i class="fas fa-arrow-up"></i></a>
                                                            <a href="#" onclick="sort('id','desc')"><i class="fas fa-arrow-down"></i></a>
                                                        </th>
                                                        <th> Email
                                                            <a href="#" onclick="sort('email','asc')"><i class="fas fa-arrow-up"></i></a>
                                                            <a href="#" onclick="sort('email','desc')"><i class="fas fa-arrow-down"></i></a>
                                                        </th>
                                                        <th> Phone
                                                            <a href="#" onclick="sort('phone','asc')"><i class="fas fa-arrow-up"></i></a>
                                                            <a href="#" onclick="sort('phone','desc')"><i class="fas fa-arrow-down"></i></a>
                                                        </th>
                                                        <th> Date Of Birth
                                                            <a href="#" onclick="sort('dob','asc')"><i class="fas fa-arrow-up"></i></a>
                                                            <a href="#" onclick="sort('dob','desc')"><i class="fas fa-arrow-down"></i></a>
                                                        </th>
                                                        <th> Gender
                                                            <a href="#" onclick="sort('gender','asc')"><i class="fas fa-arrow-up"></i></a>
                                                            <a href="#" onclick="sort('gender','desc')"><i class="fas fa-arrow-down"></i></a>
                                                        </th>
                                                        <th> Standads
                                                            <a href="#" onclick="sort('stds','asc')"><i class="fas fa-arrow-up"></i></a>
                                                            <a href="#" onclick="sort('stds','desc')"><i class="fas fa-arrow-down"></i></a>
                                                        </th>
                                                        <th> Subjects
                                                            <a href="#" onclick="sort('subs','asc')"><i class="fas fa-arrow-up"></i></a>
                                                            <a href="#" onclick="sort('subs','desc')"><i class="fas fa-arrow-down"></i></a>
                                                        </th>
                                                        <th> Status
                                                            <a href="#" onclick="sort('status','asc')"><i class="fas fa-arrow-up"></i></a>
                                                            <a href="#" onclick="sort('status','desc')"><i class="fas fa-arrow-down"></i></a>
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach ($filtered_teachers as $teacher) : ?>
                                                        <tr>
                                                            <td>
                                                                <input type="checkbox" name="selected_ids[]" value="<?php echo e($teacher['staff_ids']); ?>" class="record-checkbox">
                                                            </td>
                                                            <td>
                                                                <?php
                                                                $path = '/storage/';

                                                                if (array_key_exists('staff_profile', $teacher) && ($teacher['staff_profile'] != null || $teacher['staff_profile'] != '')) {
                                                                    $path .= $teacher['staff_profile'];
                                                                } else {
                                                                    $path .= 'default.png';
                                                                }
                                                                ?>
                                                                <img src="<?php echo e($path); ?>" alt="image" />
                                                                <span class="pl-2"><?php echo e($teacher['staff_names']); ?></span>
                                                            </td>
                                                            <td> <?php echo e($teacher['staff_emails']); ?> </td>
                                                            <td> <?php echo e($teacher['staff_phones']); ?> </td>
                                                            <td> <?php echo e($teacher['staff_dobs']); ?> </td>
                                                            <td> <?php echo e($teacher['staff_gender'] == 'F' ? 'Female' : 'Male' ?? 'Other'); ?> </td>
                                                            <td> <?php echo e($teacher['total_standards']); ?> </td>
                                                            <td> <?php echo e($teacher['total_subjects']); ?> </td>
                                                            <?php if ($teacher['staff_status'] === '1') : ?>
                                                                <td>
                                                                    <div class="badge badge-outline-success">Active</div>
                                                                </td>
                                                            <?php else : ?>
                                                                <td>
                                                                    <div class="badge badge-outline-danger">Not Active</div>
                                                                </td>
                                                            <?php endif; ?>
                                                            <td>
                                                                <a href="/admin/teachers/<?php echo e(urlencode($teacher['staff_ids'])); ?>" class="btn btn-inverse-success btn-fw" style="width: 10px;padding-top:15px;padding-bottom:15px">Edit</a>
                                                            </td>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                </tbody>
                                            </table>
                            <?php include $this->resolve("/admin/teachers/partials/_pagination.php"); ?>

                                            <button type="button" ondblclick="delete_selected()" class="btn btn-inverse-danger btn-fw" style="width: 10px;padding-top:15px;padding-bottom:15px">Delete Selected</button>
                                    </form>
                                </div>
                                <button type="button" class="btn btn-success btn-fw mt-3 col-5 ml-5 p-4" style="padding:15px;font-size:20px;margin-right:20px;" onclick="add_subject()">Add Subject</button>
                                <script>
                                    function add_subject() {
                                        window.location.href = "/admin/subjects/create_subject";
                                    }

                                    function toggleCheckboxes(selectAllCheckbox) {
                                        const checkboxes = document.querySelectorAll('.record-checkbox');
                                        checkboxes.forEach(checkbox => {
                                            checkbox.checked = selectAllCheckbox.checked;
                                        });
                                    }

                                    function delete_selected() {
                                        const form = document.getElementById("list_teachers");
                                        form.submit();
                                    }
                                </script>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- jQuery -->
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
        <!-- Custom js for this page -->
        <script src="/assets/admin/assets/js/dashboard.js"></script>
        <!-- End custom js for this page -->
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const searchInput = document.getElementById('searchInput');
                const searchButton = document.getElementById('searchButton');
                const searchHistoryDropdown = document.getElementById('searchHistoryDropdown');
                let searchHistory = JSON.parse(localStorage.getItem('searchHistory')) || [];

                // Function to update the dropdown with search history
                function updateDropdown() {
                    searchHistoryDropdown.innerHTML = '';
                    if (searchHistory.length > 0) {
                        searchHistoryDropdown.style.display = 'block';
                        searchHistory.slice(-5).reverse().forEach((term) => {
                            const item = document.createElement('div');
                            item.classList.add('dropdown-item');
                            item.textContent = term;
                            item.addEventListener('click', () => {
                                searchInput.value = term;
                                searchHistoryDropdown.style.display = 'none';
                            });
                            searchHistoryDropdown.appendChild(item);
                        });
                    } else {
                        searchHistoryDropdown.style.display = 'none';
                    }
                }

                // Add event listener to the search button
                searchButton.addEventListener('click', () => {
                    const searchTerm = searchInput.value.trim();
                    if (searchTerm) {
                        if (!searchHistory.includes(searchTerm)) {
                            searchHistory.push(searchTerm);
                            localStorage.setItem('searchHistory', JSON.stringify(searchHistory));
                        }
                        updateDropdown();
                    }
                });

                // Show the dropdown when the search input is focused
                searchInput.addEventListener('focus', () => {
                    updateDropdown();
                });

                // Hide the dropdown when clicking outside
                document.addEventListener('click', (event) => {
                    if (!event.target.closest('.search-container')) {
                        searchHistoryDropdown.style.display = 'none';
                    }
                });

                // Initialize the dropdown with search history
                updateDropdown();
            });
        </script>

</body>


</html>