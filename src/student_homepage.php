<?php
;
require "vendor/autoload.php";
$service = new PHPSupabase\Service(
	"eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6ImhzZXBqZ3h4b3pleWt0amtiZXdjIiwicm9sZSI6ImFub24iLCJpYXQiOjE2NzYwMzgwODQsImV4cCI6MTk5MTYxNDA4NH0.zusO9r5QquROh2XfQ6CIM0sbL3Re2KPtSOsHK7lsPfc",
	"https://hsepjgxxozeyktjkbewc.supabase.co/rest/v1/"
);

$userData = $_SESSION['userData'];
if ($userData['role'] != 'user') {
	switch ($userData['role']) {
		case "teacher":
			header("Location: teacher_homepage.php");
			die();
		case "admin":
			header("Location: admin_homepage.php");
			die();
		default:
			echo ("An error occured: Error while redirecting user");
			die();
	}
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href="./output.css" rel="stylesheet" />
	<title>Grades</title>
</head>

<body class="bg-blue-950">
	<div class="bg-indigo-950 p-5 max-w-5xl h-screen mx-auto shadow-2xl shadow-cyan-500">

		<!-- Header -->
		<?php
		require_once "./student_header.php";
		?>
		<h1 class="text-white text-4xl mb-6">Grades</h1>
		<!-- Table -->
		<tbody>
			<!--Table expanded-->
			<table class="w-full text-sm text-left text-gray-500 dark:text-gray-400 shadow-md">
				<thead class="text-xs text-gray-700 uppercase bg-blue-50 dark:bg-blue-700 dark:text-gray-400">
					<tr>
						<th scope="col" class="px-6 py-3">Subject</th>
						<th scope="col" class="px-6 py-3">Grades</th>
					</tr>
				</thead>
				<tbody>
					<?php
					$fetchGradesQuery = $service->initializeQueryBuilder();
					$subjectDataQuery = $service->initializeQueryBuilder();

					try {
						$fetchSubjectData = $subjectDataQuery->select('*')
							->from('subjects')
							->execute()
							->getResult();
						$subjects = json_decode(json_encode($fetchSubjectData), true);

						$gradesQuery = $fetchGradesQuery->select('*')
							->from('users_grades')
							->join('subjects', 'id_subject')
							->execute()
							->getResult();

						$groupedGrades = [];
						foreach ($gradesQuery as $grade) {
							$subject = $grade->id_subject;
							if (!isset($groupedGrades[$subject])) {
								$groupedGrades[$subject] = [];
							}
							$groupedGrades[$subject][] = $grade->grade;
						}
						$gradeCounter = -1;
						foreach ($groupedGrades as $subject => $grades) {
							echo '<tr class="bg-white border-b dark:bg-blue-800 dark:border-gray-700">';
							echo '<td class="px-6 py-3">' . $subjects[$subject - 1]['name'] . '</td>';
							echo '<td class="px-6 py-3">' . implode(', ', $grades) . '</td>';
							echo '</tr>';
						}
					} catch (Exception $e) {
						echo $e->getMessage();
					}
					?>

				</tbody>
			</table>
		</tbody>
	</div>
</body>

</html>