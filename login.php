<?php
$usernameOrEmail = $password = "";
$usernameOrEmailErr = $passwordErr = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["usernameOrEmail"])) {
        $usernameOrEmailErr = "Username or Email is required";
    } else {
        $usernameOrEmail = $_POST["usernameOrEmail"];
    }
    if (empty($_POST["password"])) {
        $passwordErr = "Password is required";
    } else {
        $password = $_POST["password"];
    }
    
    if ($usernameOrEmail && $password) {
        include("conn/Connection.php");
        
        if (filter_var($usernameOrEmail, FILTER_VALIDATE_EMAIL)) {
            $condition = "Email = '$usernameOrEmail'";
        } else {
            $condition = "username = '$usernameOrEmail'";
        }
        
        $check_user = mysqli_query($Connections, "SELECT * FROM login_tbl WHERE $condition");
        $check_user_row = mysqli_num_rows($check_user);

        if ($check_user_row > 0) {
            session_start();
            $_SESSION['usernameOrEmail'] = $usernameOrEmail;
            $row = mysqli_fetch_assoc($check_user);
            $db_password = $row["password"];
            $db_account_type = $row["account_type"];
            if ($db_password == $password) {
                if ($db_account_type ==  "1") {
                    echo "<script>window.location.href = 'admin.php'; </script>";
                } else {
                    echo "<script>window.location.href = 'user.php'; </script>";
                }
            } else {
                $passwordErr = "Password is incorrect";
            }
        } else {
            $usernameOrEmailErr = "Username or Email is not registered";
        }
    } 
}
?>


<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="node_modules/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="LOGIN.css">
    <title>LOGIN</title>
</head>

<body style="background: #162d5e;">
        <form method="POST" action="<?php htmlspecialchars($_SERVER["PHP_SELF"]);?>">
    <div class="hh flex align-items-center justify-content-center flex-nowrap ">
        <div class="form w-25 text-center"style="top:20%;	background: linear-gradient(90deg, rgba(2,0,36,1) 0%, rgba(17,41,92,1) 40%, rgba(0,132,255,1) 100%);">
            <form action="login.php" method="post">
                <div class=" text-center text-light fs-6"><img src="2206.png" style=" height: 30px; width: 30px;">  LEGAL MANAGEMENT</div>

                <input type="text" name="usernameOrEmail" placeholder="Enter Email or Username" value="<?php echo $usernameOrEmail ?>"><br>
                    <span class="error" style="color:red; font-family:arial;"><?php echo $usernameOrEmailErr; ?></span>

                <input type="password" name="password" placeholder="Enter Password"><br>
                    <span class="error" style="color:red;font-family:arial;"><?php echo $passwordErr; ?></span>
            <button class="btn btn-light w-75 mt-4 m-3" name="login">Login</button><br>

            </form>
        </div>
    </div>
</body>
</html>
