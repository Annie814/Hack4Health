<?php
session_start();
require 'connect.php';

function handleLoginRequest($conn) {

    $email = $_POST['email'];
    $password = $_POST['password'];
    $_SESSION['email'] = $email;
    if (($email == '') || ($password == '')) {
        header("refresh:1; url='index.html'");
        echo "<br>Email or password cannot be empty. Auto-refresh in 1 second.<br>";
        exit;
    }
    $sql = "SELECT Count(*) FROM Users WHERE (Users.email='$email' and Users.password='$password')";
    $result = mysqli_query($conn, $sql);
    $num = ($result->fetch_array())[0];

    if ($num == 1) {
        echo "<br>Logged In Successfully!<br>";
        header('refresh:0.5; url=foodintake.html');
    } else if ($num == 0) {
        header('refresh:2; url=index.html');
        echo "<br>Email or password wrong. Auto-refresh in 2 seconds.<br>";
    }
    # CloseCon($conn);
}

function handlePOSTRequest() {
    $conn = OpenCon();
    if (array_key_exists('login', $_POST)) {

        handleLoginRequest($conn);
    }
    CloseCon($conn);
}

if (isset($_POST['login'])) {

    handlePOSTRequest();
}

?>