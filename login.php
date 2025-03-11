<?php
session_start();
if (isset($_SESSION['uid'])) {
    header("location: homepage.php");
    exit();
}

include("dbconnect.php");

if (isset($_POST["loginbtn"])) {
    $email = $_POST["email"];
    $password = $_POST["password"];

    // Admin Login
    if ($email === "admin" && $password === "admin") {
        header("location: adminpage.php");
        exit();
    }

    // Student Login
    $qry = "SELECT * FROM stud_info WHERE smail='$email' AND spassword='$password'";
    $result = mysqli_query($connect, $qry);
    $row = mysqli_num_rows($result);

    if ($row > 0) {
        $data = mysqli_fetch_assoc($result);
        $_SESSION["uid"] = $data["sid"];  // Fix: Use correct column name from `stud_info`

        header("location: homepage.php");
        exit();
    } else {
        echo "<script>alert('Invalid Credentials!'); window.location.href='login.php';</script>";
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light d-flex justify-content-center align-items-center vh-100">
    <div class="container bg-white p-4 rounded shadow" style="max-width: 400px;">
        <h3 class="text-center">Login</h3>
        <form method="post">
            <div class="mb-3">
                <label class="form-label">Email / Username</label>
                <input type="text" class="form-control" name="email" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Password</label>
                <input type="password" class="form-control" name="password" required>
            </div>
            <button type="submit" class="btn btn-primary w-100" name="loginbtn">Login</button>
        </form>
    </div>
</body>
</html>
