<?php
;
require "vendor/autoload.php";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $_SESSION["login_error"] = "";
    $email = $_POST["email"];
    $password = $_POST["password"];
    if (empty($email) || empty($password)) {
        $_SESSION["login_error"] = "Please fill in all fields.";
        echo "<script> history.back(); </script>";
        die();
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION["login_error"] = "Invalid email format.";
        echo "<script> history.back(); </script>";
        die();
    } else {
        $authService = new PHPSupabase\Service(
            "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6ImhzZXBqZ3h4b3pleWt0amtiZXdjIiwicm9sZSI6ImFub24iLCJpYXQiOjE2NzYwMzgwODQsImV4cCI6MTk5MTYxNDA4NH0.zusO9r5QquROh2XfQ6CIM0sbL3Re2KPtSOsHK7lsPfc",
            "https://hsepjgxxozeyktjkbewc.supabase.co/auth/v1/"
        );

        $service = new PHPSupabase\Service(
            "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6ImhzZXBqZ3h4b3pleWt0amtiZXdjIiwicm9sZSI6ImFub24iLCJpYXQiOjE2NzYwMzgwODQsImV4cCI6MTk5MTYxNDA4NH0.zusO9r5QquROh2XfQ6CIM0sbL3Re2KPtSOsHK7lsPfc",
            "https://hsepjgxxozeyktjkbewc.supabase.co/rest/v1/"
        );

        $auth = $authService->createAuth();

        try {
            $auth->signInWithEmailAndPassword($email, $password);
            $authData = $auth->data();
            $data = json_decode(json_encode($authData), true);
            $userDataQuery = $service->initializeQueryBuilder();
            $profileQuery = $data['user']['id'];
            if (isset($data['access_token'])) {
                try {
                    $fetchUserData = $userDataQuery->select('*')
                        ->from('profiles')
                        ->where('uuid', "eq.$profileQuery") //eq -> equal
                        ->execute()
                        ->getResult();
                    $userData = json_decode(json_encode($fetchUserData[0]), true);
                    $_SESSION["userData"] = $userData;
                } catch (Exception $e) {
                    echo $e->getMessage();
                }
                $_SESSION["session"] = $data;

                switch ($userData['role']) {
                    case "user":
                        header("Location: student_homepage.php");
                        break;
                    case "teacher":
                        header("Location: teacher_homepage.php");
                        break;
                    case "admin":
                        header("Location: admin_homepage.php");
                        break;
                    default:
                        echo ("An error occured: Error while redirecting user");
                }
                die();
            } else {
                throw new Exception("Error: no access token set");
            }
        } catch (Exception $e) {
            $_SESSION["login_error"] = $auth->getError();
            echo "<script> history.back(); </script>";
            die();
        }
    }
}
?>