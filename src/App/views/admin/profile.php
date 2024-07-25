<?php include $this->resolve("partials/admin/_header.php"); ?>
<?php
$path = '/storage/';
if ($profile['storage_filename'] != null) {
    $path .= $profile['storage_filename'];
} else {
    $path .= 'default.png';
}

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
                        <div class="col-12 grid-margin stretch-card">
                            <div class="card corona-gradient-card">
                                <div class="card-body col-md-12 grid-margin stretch-card">
                                    <form method="POST" enctype="multipart/form-data">
                                        <div class="container">
                                            <div class="row gutters">
                                                <div class="col-xl-3 col-lg-3 col-md-12 col-sm-12 col-12">
                                                    <div class="card h-100">
                                                        <div class="card-body">
                                                            <div class="account-settings">
                                                                <div class="user-profile">
                                                                    <div class="user-avatar">




                                                                        <img src="<?php echo e($path); ?>" alt="Maxwell Admin">
                                                                    </div>
                                                                    <h5 class="user-name"><?php echo e($profile['name']); ?></h5>
                                                                    <h6 class="user-email"><a href="mailto:<?php echo e($profile['name']); ?>" class="__cf_email__" data-cfemail="cab3bfa1a38a87abb2bdafa6a6e4a9a5a7"><?php echo e($profile['email']); ?></a></h6>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-xl-9 col-lg-9 col-md-12 col-sm-12 col-12">
                                                    <div class="card h-100">
                                                        <div class="card-body">
                                                            <div class="row gutters">
                                                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                                                    <h6 class="mb-3 text-primary">Details</h6>
                                                                </div>
                                                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                                                    <div class="form-group">
                                                                        <label for="fullName">Full Name</label>
                                                                        <input type="text" name="name" class="form-control" value="<?php echo e($profile['name']); ?>" id="fullName" placeholder="Enter full name">
                                                                    </div>
                                                                    <?php if (array_key_exists('name', $errors)) : ?>
                                                                        <div class="bg-gray-100 mt-2 p-2 text-red-500" style="color:red">
                                                                            <?php echo e($errors['name'][0]); ?>
                                                                        </div>
                                                                    <?php endif; ?>

                                                                </div>
                                                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                                                    <div class="form-group">
                                                                        <label for="eMail">Email</label>
                                                                        <input type="email" name="email" class="form-control" id="email" value="<?php echo e($profile['email']); ?>" placeholder="Enter email ID">
                                                                    </div>
                                                                    <?php if (array_key_exists('email', $errors)) : ?>
                                                                        <div class="bg-gray-100 mt-2 p-2 text-red-500" style="color:red">
                                                                            <?php echo e($errors['email']); ?>
                                                                        </div>
                                                                    <?php endif; ?>

                                                                </div>

                                                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                                                    <div class="form-group">
                                                                        <label for="phone">Phone</label>
                                                                        <input type="text" name="phone" class="form-control" id="phone" value="<?php echo e($profile['phone']); ?>" placeholder="Enter phone number">
                                                                    </div>
                                                                    <?php if (array_key_exists('phone', $errors)) : ?>
                                                                        <div class="bg-gray-100 mt-2 p-2 text-red-500" style="color:red">
                                                                            <?php echo e($errors['phone'][0]); ?>
                                                                        </div>
                                                                    <?php endif; ?>

                                                                </div>
                                                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                                                    <div class="form-group">
                                                                        <label for="website">Department</label>
                                                                        <input type="text" name="department" class="form-control" value="<?php echo e($profile['department']); ?>" id="website" placeholder="Enter your department">
                                                                    </div>
                                                                    <?php if (array_key_exists('department', $errors)) : ?>
                                                                        <div class="bg-gray-100 mt-2 p-2 text-red-500" style="color:red">
                                                                            <?php echo e($errors['department'][0]); ?>
                                                                        </div>
                                                                    <?php endif; ?>

                                                                </div>
                                                            </div>
                                                            <div class="row gutters">
                                                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                                                    <h6 class="mb-3 text-primary">More Info</h6>
                                                                </div>
                                                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                                                    <div class="form-group">
                                                                        <label for="Street">Password</label>
                                                                        <input type="password" name="password" class="form-control" id="Street" placeholder="Enter Password">
                                                                        <div class="bg-gray-100 mt-2 p-2 text-red-500" style="color:red">
                                                                            *only enter password if you wnat to change
                                                                        </div>
                                                                    </div>

                                                                    <?php if (array_key_exists('password', $errors)) : ?>
                                                                        <div class="bg-gray-100 mt-2 p-2 text-red-500" style="color:red">
                                                                            <?php echo e($errors['password'][0]); ?>
                                                                        </div>
                                                                    <?php endif; ?>
                                                                </div>
                                                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                                                    <div class="form-group">
                                                                        <label for="ciTy">Confirm Password</label>
                                                                        <input type="password" name="confirm_password" class="form-control" id="ciTy" placeholder="Enter Confirm Password">
                                                                    </div>
                                                                    <?php if (array_key_exists('confirm_password', $errors)) : ?>
                                                                        <div class="bg-gray-100 mt-2 p-2 text-red-500" style="color:red">
                                                                            <?php echo e($errors['confirm_password']); ?>
                                                                        </div>
                                                                    <?php endif; ?>
                                                                </div>
                                                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                                                    <div class="form-group">
                                                                        <label for="sTate">profile</label>

                                                                        <input type="file" class="form-control" name="profile" style="font-size:10px;padding-bottom:29px" id="sTate" placeholder="Enter State">
                                                                    </div>
                                                                    <?php if (array_key_exists('profile', $errors)) : ?>
                                                                        <div class="bg-gray-100 mt-2 p-2 text-red-500" style="color:red">
                                                                            <?php echo e($errors['profile'][0]); ?>
                                                                        </div>
                                                                    <?php endif; ?>

                                                                </div>
                                                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                                                    <div class="form-group">
                                                                        <label for="sTate">Date Of Birth</label>

                                                                        <input type="date" value="<?php echo e($profile['fomatted_date']); ?>" class="form-control" name="profile" id="sTate">
                                                                    </div>
                                                                    <?php if (array_key_exists('profile', $errors)) : ?>
                                                                        <div class="bg-gray-100 mt-2 p-2 text-red-500" style="color:red">
                                                                            <?php echo e($errors['profile'][0]); ?>
                                                                        </div>
                                                                    <?php endif; ?>

                                                                </div>
                                                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                                                    <div class="form-group">
                                                                        <label for="sTate">Gender</label>
                                                                        <select name="" id="" class="form-control">
                                                                            <option value="Male" <?php echo $profile['gender']  === 'M' ? 'selected' :  ''; ?>>Male </option>
                                                                            <option value="Female" <?php echo $profile['gender']  === 'F' ? 'selected' :  ''; ?>>Female</option>
                                                                            <option value="Others" <?php echo $profile['gender']  === 'O' ? 'selected' :  ''; ?>>Others</option>
                                                                        </select>
                                                                    </div>
                                                                    <?php if (array_key_exists('profile', $errors)) : ?>
                                                                        <div class="bg-gray-100 mt-2 p-2 text-red-500" style="color:red">
                                                                            <?php echo e($errors['profile'][0]); ?>
                                                                        </div>
                                                                    <?php endif; ?>

                                                                </div>

                                                            </div>
                                                            <div class="row gutters">
                                                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                                                    <div class="text-right">
                                                                        <button type="submit" id="submit" name="submit" class="btn btn-secondary">Cancel</button>
                                                                        <button type="submit" id="submit" name="submit" class="btn btn-primary">Update</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>


                                        </div>

                                    </form>
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
    <!-- End plug/in js for this page -->
    <!-- inject:j/s -->
    <script src="/assets/admin/assets/js/off-canvas.js"></script>
    <script src="/assets/admin/assets/js/hoverable-collapse.js"></script>
    <script src="/assets/admin/assets/js/misc.js"></script>
    <script src="/assets/admin/assets/js/settings.js"></script>
    <script src="/assets/admin/assets/js/todolist.js"></script>
    <!-- endinjec/t -->
    <!-- Custom j/s for this page -->
    <script src="/assets/admin/assets/js/dashboard.js"></script>
    <!-- End custom js for this page -->
</body>

</html>

</html>