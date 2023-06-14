<?php
;
require "vendor/autoload.php";
$service = new PHPSupabase\Service(
    "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6ImhzZXBqZ3h4b3pleWt0amtiZXdjIiwicm9sZSI6ImFub24iLCJpYXQiOjE2NzYwMzgwODQsImV4cCI6MTk5MTYxNDA4NH0.zusO9r5QquROh2XfQ6CIM0sbL3Re2KPtSOsHK7lsPfc",
    "https://hsepjgxxozeyktjkbewc.supabase.co/rest/v1/"
);
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $db = $service->initializeDatabase('profiles', 'uuid');
    $userId = $_SESSION['userId'];
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    $fieldsToUpdate = array();

    if (!empty($firstName)) {
        $fieldsToUpdate['firstName'] = $firstName;
    }

    if (!empty($lastName)) {
        $fieldsToUpdate['lastName'] = $lastName;
    }

    if (!empty($password)) {
        $fieldsToUpdate['password'] = $password;
    }

    if (!empty($email)) {
        $fieldsToUpdate['email'] = $email;
    }

    if (!empty($role)) {
        $fieldsToUpdate['role'] = $role;
    }

    try {
        header("Location: teacher_homepage.php");
        $_SESSION['grade_edit'] = 'Grade edited successfuly!';
        $data = $db->update($userId, $fieldsToUpdate);
    } catch (Exception $e) {
        $_SESSION["editUser_error"] = $e->getMessage();
        echo "<script> history.back(); </script>";
        die();
    }
}
?>