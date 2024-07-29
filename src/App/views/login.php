<!DOCTYPE html>
<html lang="en">


<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f0f0f0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .login-container {
            background-color: #d2f2e4;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            width: 300px;
            max-width: 100%;
            text-align: center;
        }

        .login-container h2 {
            margin-bottom: 30px;
            color: #4CAF50;
        }

        .login-container input[type="email"],
        .login-container input[type="password"] {
            width: calc(100% - 20px);
            padding: 12px 10px;
            margin: 10px 0;
            border: 1px solid #4CAF50;
            border-radius: 5px;
            font-size: 16px;
            background-color: #ffffff;
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
        }

        .login-container input[type="email"]:focus,
        .login-container input[type="password"]:focus {
            border-color: #45a049;
            box-shadow: 0 0 8px rgba(69, 160, 73, 0.4);
        }

        .login-container input[type="submit"] {
            background-color: #4CAF50;
            color: #ffffff;
            border: none;
            padding: 12px 20px;
            cursor: pointer;
            border-radius: 5px;
            font-size: 16px;
            transition: background-color 0.3s ease;
        }

        .login-container input[type="submit"]:hover {
            background-color: #45a049;
        }

        .login-container p {
            color: #4CAF50;
            margin-top: 20px;
            font-size: 14px;
        }

        .login-container a {
            color: #4CAF50;
            text-decoration: none;
            border-bottom: 1px dashed #4CAF50;
            transition: color 0.3s ease, border-color 0.3s ease;
        }

        .login-container a:hover {
            color: #45a049;
            border-color: #45a049;
        }
    </style>
    <!-- <script src="\assets\public\js\indexeddb.js"></script> -->
</head>

<body>
    <!-- <script src="\assets\public\js\verify_token.js"></script> -->
    <div class="login-container">
        <!-- <input type="hidden" value> -->
        <h2>Login</h2>
        <form action="/login" onsubmit="login()" method="POST">
            <input type="email" name="email" placeholder="Email">
            <?php if (array_key_exists('email', $errors)) : ?>
                <div class="bg-gray-100 mt-2 p-2 text-red-500">
                    <?php echo e($errors['email']); ?>
                </div>
            <?php endif; ?>
            <input type="password" name="password" placeholder="Password">
            <?php if (array_key_exists('password', $errors)) : ?>
                <div class="bg-gray-100 mt-2 p-2 text-red-500">
                    <?php echo e($errors['password'][0]); ?>
                </div>
            <?php endif; ?>
            <input type="submit" onclick="login()" value="Login">

        </form>
        <p>Forgot your password? <a href="#">Reset here</a></p>
        <p><a href="/register">register here</a></p>

    </div>
</body>

</html>