<?php
;
require "vendor/autoload.php";
$service = new PHPSupabase\Service(
    "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6ImhzZXBqZ3h4b3pleWt0amtiZXdjIiwicm9sZSI6ImFub24iLCJpYXQiOjE2NzYwMzgwODQsImV4cCI6MTk5MTYxNDA4NH0.zusO9r5QquROh2XfQ6CIM0sbL3Re2KPtSOsHK7lsPfc",
    "https://hsepjgxxozeyktjkbewc.supabase.co/rest/v1/"
);
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $db = $service->initializeDatabase('users_grades', 'id');
    $gradeId = $_POST['gradeId'];
    try {
        $data = $db->delete($gradeId);
        header("Location: teacher_homepage.php");
        $_SESSION['grade_delete'] = 'Grade deleted successfuly!';
    } catch (Exception $e) {
        echo $e->getMessage();
    }
}
?>