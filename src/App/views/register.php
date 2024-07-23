<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Registration</title>
    <link rel="stylesheet" href="assets/register.css">
    <style>
        input[type="password"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
            font-size: 16px;
        }
    </style>
    <script src="\assets\public\js\indexeddb.js"></script>
</head>


<body>
    <div class="container">
        <header class="header">
            <h1 class="logo">School App</h1>
        </header>

        <main class="main-content">
            <div class="form-container">
                <h2 class="form-heading">Student Registration</h2>
                <form action="/register" method="POST" class="registration-form">
                    <div class="form-group">
                        <?php if (array_key_exists('registered_user', $errors)) : ?>
                            <div class="bg-gray-100 mt-2 p-2 text-red-500">
                                <?php echo e($errors['registered_user']); ?>
                            </div>
                        <?php endif; ?>

                        <label for="first_name">First Name</label>
                        <input type="text" value="<?php echo e($oldFormData['first_name'] ?? "");  ?>" id="first_name" name="first_name">
                        <?php if (array_key_exists('first_name', $errors)) : ?>
                            <div class="bg-gray-100 mt-2 p-2 text-red-500">
                                <?php echo e($errors['first_name'][0]); ?>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="form-group">
                        <label for="last_name">Last Name</label>
                        <input type="text" value="<?php echo e($oldFormData['last_name'] ?? "");  ?>" id="last_name" name="last_name">
                        <?php if (array_key_exists('last_name', $errors)) : ?>
                            <div class="bg-gray-100 mt-2 p-2 text-red-500">
                                <?php echo e($errors['last_name'][0]); ?>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="form-group">
                        <label for="dob">Date of Birth</label>
                        <input type="date" id="dob" value="<?php echo e($oldFormData['dob'] ?? "");  ?>" name="dob">
                        <?php if (array_key_exists('dob', $errors)) : ?>
                            <div class="bg-gray-100 mt-2 p-2 text-red-500">
                                <?php echo e($errors['dob'][0]); ?>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="form-group">
                        <label for="gender">Gender</label>
                        <select id="gender" name="gender">
                            <option value="S" <?php echo $oldFormData['gender'] ?? '' == "S" ? "selected" : '' ?>>Select Gender</option>
                            <option value="M" <?php echo $oldFormData['gender'] ?? ''  == "M" ? 'selected' : '' ?>>Male</option>
                            <option value="F" <?php echo $oldFormData['gender'] ?? '' == "F" ? 'selected' : '' ?>>Female</option>
                            <option value="O" <?php echo $oldFormData['gender'] ?? '' == "O" ? 'selected' : '' ?>>Others</option>
                        </select>

                        <?php if (array_key_exists('gender', $errors)) : ?>
                            <div class="bg-gray-100 mt-2 p-2 text-red-500">
                                <?php echo e($errors['gender'][0]); ?>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="form-group">
                        <label for="address">Address</label>
                        <textarea id="address" name="address" value="<?php echo e($oldFormData['address'] ?? "");  ?>" rows="3"></textarea>
                        <?php if (array_key_exists('address', $errors)) : ?>
                            <div class="bg-gray-100 mt-2 p-2 text-red-500">
                                <?php echo e($errors['address'][0]); ?>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div>
                        <div class="form-group">
                            <label for="phone">Phone</label>
                            <input type="text" id="phone" name="phone" value="<?php echo e($oldFormData['phone'] ?? "");  ?>" maxlength="10">
                            <?php if (array_key_exists('phone', $errors)) : ?>
                                <div class="bg-gray-100 mt-2 p-2 text-red-500">
                                    <?php echo e($errors['phone'][0]); ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" value="<?php echo e($oldFormData['email'] ?? "");  ?>" name="email">
                        <?php if (array_key_exists('email', $errors)) : ?>
                            <div class="bg-gray-100 mt-2 p-2 text-red-500">
                                <?php echo e($errors['email'][0]); ?>

                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" id="password" value="<?php echo e($oldFormData['password'] ?? "");  ?>" name="password">
                        <?php if (array_key_exists('password', $errors)) : ?>
                            <div class="bg-gray-100 mt-2 p-2 text-red-500">
                                <?php echo e($errors['password'][0]); ?>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="form-group">
                        <button type="submit" onclick="login()" class="btn btn-register">Register</button>
                    </div>
                </form>
                <div class="login-link">
                    <p>Already have an account? <a href="/login">Login here</a></p>
                </div>


            </div>
        </main>
    </div>
</body>

</html>