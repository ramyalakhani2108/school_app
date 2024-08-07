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
                                            <h4 class="card-title mb-1">Subjects</h4>
                                            <p class="text-muted mb-1">Subjects for all class</p>
                                        </div>

                                        <?php include $this->resolve("admin/subjects/partials/_searchbar.php"); ?>
                                        <?php include $this->resolve("admin/subjects/partials/_filter.php"); ?>
                                    </div>

                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>
                                                        <div class="form-check form-check-muted m-0">
                                                            <label class="form-check-label">
                                                                <input type="checkbox" class="form-check-input">
                                                            </label>
                                                        </div>
                                                    </th>
                                                    <th> Client Name </th>
                                                    <th> Order No </th>
                                                    <th> Product Cost </th>
                                                    <th> Project </th>
                                                    <th> Payment Mode </th>
                                                    <th> Start Date </th>
                                                    <th> Payment Status </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        <div class="form-check form-check-muted m-0">
                                                            <label class="form-check-label">
                                                                <input type="checkbox" class="form-check-input">
                                                            </label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <img src="assets/images/faces/face1.jpg" alt="image" />
                                                        <span class="pl-2">Henry Klein</span>
                                                    </td>
                                                    <td> 02312 </td>
                                                    <td> $14,500 </td>
                                                    <td> Dashboard </td>
                                                    <td> Credit card </td>
                                                    <td> 04 Dec 2019 </td>
                                                    <td>
                                                        <div class="badge badge-outline-success">Approved</div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <div class="form-check form-check-muted m-0">
                                                            <label class="form-check-label">
                                                                <input type="checkbox" class="form-check-input">
                                                            </label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <img src="assets/images/faces/face2.jpg" alt="image" />
                                                        <span class="pl-2">Estella Bryan</span>
                                                    </td>
                                                    <td> 02312 </td>
                                                    <td> $14,500 </td>
                                                    <td> Website </td>
                                                    <td> Cash on delivered </td>
                                                    <td> 04 Dec 2019 </td>
                                                    <td>
                                                        <div class="badge badge-outline-warning">Pending</div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <div class="form-check form-check-muted m-0">
                                                            <label class="form-check-label">
                                                                <input type="checkbox" class="form-check-input">
                                                            </label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <img src="assets/images/faces/face5.jpg" alt="image" />
                                                        <span class="pl-2">Lucy Abbott</span>
                                                    </td>
                                                    <td> 02312 </td>
                                                    <td> $14,500 </td>
                                                    <td> App design </td>
                                                    <td> Credit card </td>
                                                    <td> 04 Dec 2019 </td>
                                                    <td>
                                                        <div class="badge badge-outline-danger">Rejected</div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <div class="form-check form-check-muted m-0">
                                                            <label class="form-check-label">
                                                                <input type="checkbox" class="form-check-input">
                                                            </label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <img src="assets/images/faces/face3.jpg" alt="image" />
                                                        <span class="pl-2">Peter Gill</span>
                                                    </td>
                                                    <td> 02312 </td>
                                                    <td> $14,500 </td>
                                                    <td> Development </td>
                                                    <td> Online Payment </td>
                                                    <td> 04 Dec 2019 </td>
                                                    <td>
                                                        <div class="badge badge-outline-success">Approved</div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <div class="form-check form-check-muted m-0">
                                                            <label class="form-check-label">
                                                                <input type="checkbox" class="form-check-input">
                                                            </label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <img src="assets/images/faces/face4.jpg" alt="image" />
                                                        <span class="pl-2">Sallie Reyes</span>
                                                    </td>
                                                    <td> 02312 </td>
                                                    <td> $14,500 </td>
                                                    <td> Website </td>
                                                    <td> Credit card </td>
                                                    <td> 04 Dec 2019 </td>
                                                    <td>
                                                        <div class="badge badge-outline-success">Approved</div>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
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