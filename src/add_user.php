<?php

require "vendor/autoload.php";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $_SESSION["addUser_error"] = "";
    $email = $_POST["email"];
    $password = $_POST["password"];
    $confirmPassword = $_POST["confirmPassword"];
    $firstname = $_POST["firstName"];
    $lastname = $_POST["lastName"];
    $role = $_POST['role'];

    // if (!preg_match('/^(?=.[a-z])(?=.[A-Z])(?=.\d)(?=._[^\w\d\s])\S{8,}$/', $password)) {
    //     $_SESSION["addUser_error"] = "Password does not match requirements.";
    //     echo "<script> history.back(); </script>";
    //     die();
    // }

    if (empty($firstname) || empty($lastname) || empty($email) || empty($password) || empty($confirmPassword) || empty($role)) {
        $_SESSION["addUser_error"] = "Please fill in all fields.";
        echo "<script> history.back(); </script>";
        die();
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION["addUser_error"] = "Invalid email format.";
        echo "<script> history.back(); </script>";
        die();
    } elseif ($password !== $confirmPassword) {
        $_SESSION["addUser_error"] = "Passwords do not match.";
        echo "<script> history.back(); </script>";
        die();
    } else {
        $service = new PHPSupabase\Service(
            "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6ImhzZXBqZ3h4b3pleWt0amtiZXdjIiwicm9sZSI6ImFub24iLCJpYXQiOjE2NzYwMzgwODQsImV4cCI6MTk5MTYxNDA4NH0.zusO9r5QquROh2XfQ6CIM0sbL3Re2KPtSOsHK7lsPfc",
            "https://hsepjgxxozeyktjkbewc.supabase.co/auth/v1/"
        );

        $auth = $service->createAuth();

        try {
            $auth->createUserWithEmailAndPassword($email, $password);
            $data = $auth->data();
            if (isset($data->access_token)) {
                $userData = $data->user;
                header("Location: admin_homepage.php");
            } else {
                throw new Exception("Error: no access token set");
            }
        } catch (Exception $e) {
            $_SESSION["addUser_error"] = $auth->getError();
            echo "<script> history.back(); </script>";
            die();
        }

        $db = $service->initializeDatabase('profiles', 'uuid');

        $update = [
            'role' => $role,
            'firstname' => $firstname,
            'lastname' => $lastname
        ];

        try {
            $data = $db->update($userData['uuid'], $update);
            $_SESSION['addMessage'] = 'User added successfuly!';
            header("Location: admin_homepage.php");
        } catch (Exception $e) {
            $_SESSION["addUser_error"] = $e->getMessage();
            echo "<script> history.back(); </script>";
            die();
        }
    }
}
?>