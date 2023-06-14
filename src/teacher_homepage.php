<?php
;
$userData = $_SESSION['userData'];
if ($userData['role'] != 'teacher') {
	switch ($userData['role']) {
		case "user":
			header("Location: user_homepage.php");
			die();
		case "admin":
			header("Location: admin_homepage.php");
			die();
		default:
			echo ("An error occured: Error while redirecting user");
			die();
	}
}
require "vendor/autoload.php";
$service = new PHPSupabase\Service(
	"eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6ImhzZXBqZ3h4b3pleWt0amtiZXdjIiwicm9sZSI6ImFub24iLCJpYXQiOjE2NzYwMzgwODQsImV4cCI6MTk5MTYxNDA4NH0.zusO9r5QquROh2XfQ6CIM0sbL3Re2KPtSOsHK7lsPfc",
	"https://hsepjgxxozeyktjkbewc.supabase.co/rest/v1/"
);

?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href="./output.css" rel="stylesheet" />
	<title>Students</title>
</head>

<body class="bg-blue-950">
	<div class="bg-indigo-950 p-5 max-w-5xl h-screen mx-auto shadow-2xl shadow-cyan-500">

		<!-- Header -->
		<?php
		require_once "./teacher_header.php";

		if (isset($_SESSION['grade_add'])) {
			echo '<h4 class="text-white text-xl mb-6">' . $_SESSION['grade_add'] . '</h4>';
			unset($_SESSION['grade_add']);
		}

		if (isset($_SESSION['grade_delete'])) {
			echo '<h4 class="text-white text-xl mb-6">' . $_SESSION['grade_delete'] . '</h4>';
			unset($_SESSION['grade_delete']);
		}

		if (isset($_SESSION['grade_edit'])) {
			echo '<h4 class="text-white text-xl mb-6">' . $_SESSION['grade_edit'] . '</h4>';
			unset($_SESSION['grade_edit']);
		}
		?>
		<h1 class="text-white text-4xl mb-6">Students</h1>
		<!-- Table -->
		<table class="w-full text-sm text-left text-gray-500 dark:text-gray-400 shadow-md">
			<tbody>
				<!--Table expanded-->
				<table class="w-full text-sm text-left text-gray-500 dark:text-gray-400 shadow-md">
					<thead class="text-xs text-gray-700 uppercase bg-blue-50 dark:bg-blue-700 dark:text-gray-400">
						<tr>
							<th scope="col" class="px-6 py-3">Name</th>
							<th scope="col" class="px-6 py-3">Grade</th>
							<th scope="col" class="px-6 py-3">Subject</th>
							<th scope="col" class="px-6 py-3">Edit</th>
							<th scope="col" class="px-6 py-3">Add grade</th>
							<th scope="col" class="px-6 py-3">Delete</th>
						</tr>
					</thead>
					<tbody>
						<?php
						$subjectDataQuery = $service->initializeQueryBuilder();
						$fetchGradesQuery = $service->initializeQueryBuilder();

						try {
							$fetchSubjectData = $subjectDataQuery->select('*')
								->from('subjects')
								->execute()
								->getResult();
							$subjects = json_decode(json_encode($fetchSubjectData), true);
							$gradeWhereClause = $userData['uuid'];
							$gradesQuery = $fetchGradesQuery->select('*')
								->from('users_grades')
								->join('modificated_grades', 'id_grades')
								->join('profiles', 'uuid')
								->execute()
								->getResult();
							$gradeCounter = -1;
							foreach ($gradesQuery as $grade) {
								$gradeCounter++;
								$grade = json_decode(json_encode($gradesQuery[$gradeCounter]), true);
								echo '<tr class="bg-white border-b dark:bg-blue-800 dark:border-gray-700">';
								echo '<td class="px-6 py-3">' . $grade['profiles']['firstName'] . " " . $grade['profiles']['lastName'] . '</td>';
								echo '<td class="px-6 py-3">' . $grade['grade'] . '</td>';
								echo '<td class="px-6 py-3">' . $subjects[$grade['id_subject'] - 1]['name'] . '</td>';
								echo '<td class="px-6 py-3">';
								echo '<a class="bg-cyan-300 text-sm active:bg-cyan-700 cursor-pointer font-regular text-black px-4 py-2 rounded uppercase shadow-lg" href="edit_grades.php?gradeId=' . $grade['id'] . '">Edit</a>';
								echo '</td>';
								echo '<form action="add_grade.php" method="POST">';
								echo '<input class="hidden" type="text" name="uuid" value="' . $grade['id_user'] . '"/>';
								echo '<input class="hidden" type="text" name="subjectId" value="' . $grade['id_subject'] . '"/>';
								echo '<td class="px-6 py-3">';
								echo '	<select class="text-sm border rounded focus:outline-none shadow-lg" name="addGrade">';
								echo '		<option value="1">1</option>';
								echo '		<option value="2">2</option>';
								echo '		<option value="3">3</option>';
								echo '		<option value="4">4</option>';
								echo '		<option value="5">5</option>';
								echo '		<option value="6">6</option>';
								echo '	</select>';
								echo '	<button type="submit" class="bg-cyan-300 text-sm active:bg-cyan-700 cursor-pointer font-regular text-black px-4 py-2 rounded uppercase shadow-lg"';
								echo '		href="script_add_grade.php">Add</button>';
								echo '</td>';
								echo '</form>';
								echo '<form action="delete_grade.php" method="POST">';
								echo '<input class="hidden" type="text" name="gradeId" value="' . $grade['id'] . '"/>';
								echo '<td class="px-6 py-3">';
								echo '<button type="submit" class="bg-cyan-300 text-sm active:bg-cyan-700 cursor-pointer font-regular text-black px-4 py-2 rounded uppercase shadow-lg" href="script_delete_grade.php">Delete</button>';
								echo '</td>';
								echo '</form>';
								echo '</tr>';
							}

							echo '</table>';
						} catch (Exception $e) {
							echo $e->getMessage();
						}

						?>
						</tr>
					</tbody>
				</table>
			</tbody>
		</table>
	</div>
</body>

</html>