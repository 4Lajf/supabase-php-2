<?php
;
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
	<title>History</title>
</head>

<body class="bg-blue-950">
	<div class="bg-indigo-950 p-5 max-w-5xl h-screen mx-auto shadow-2xl shadow-cyan-500">

		<!-- Header -->
		<?php
		require_once "./student_header.php";
		?>
		<h1 class="text-white text-4xl mb-6">History</h1>
		<!-- Table -->
		<table class="w-full text-sm text-left text-gray-500 dark:text-gray-400 shadow-md">
			<tbody>
				<!--Table expanded-->
				<table class="w-full text-sm text-left text-gray-500 dark:text-gray-400 shadow-md">
					<thead class="text-xs text-gray-700 uppercase bg-blue-50 dark:bg-blue-700 dark:text-gray-400">
						<tr>
							<th scope="col" class="px-6 py-3">ID</th>
							<th scope="col" class="px-6 py-3">Original Grade</th>
							<th scope="col" class="px-6 py-3">Modifed Grade</th>
							<th scope="col" class="px-6 py-3">Modification Date</th>
							<th scope="col" class="px-6 py-3">Subject</th>
							<th scope="col" class="px-6 py-3">State</th>
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
								->where('id_user', "eq.$gradeWhereClause")
								->execute()
								->getResult();
							$gradeCounter = -1;
							foreach ($gradesQuery as $grade) {
								$gradeCounter++;
								$grade = json_decode(json_encode($gradesQuery[$gradeCounter]), true);
								$state = (empty($grade['modificated_grades'])) ? 'Added' : 'Modified';
								if ($state == 'Added') {
									echo '<tr class="bg-white border-b dark:bg-blue-800 dark:border-gray-700">';
									echo '<td class="px-6 py-3">' . $grade['id'] . '</td>';
									echo '<td class="px-6 py-3">' . $grade['grade'] . '</td>';
									echo '<td class="px-6 py-3">' . "None" . '</td>';
									echo '<td class="px-6 py-3">' . "Never" . '</td>';
									echo '<td class="px-6 py-3">' . $subjects[$grade['id_subject'] - 1]['name'] . '</td>';
									echo '<td class="px-6 py-3">' . "Added" . '</td>';
									echo '</tr>';
								} else {
									echo '<tr class="bg-white border-b dark:bg-blue-800 dark:border-gray-700">';
									echo '<td class="px-6 py-3">' . $grade['id'] . '</td>';
									echo '<td class="px-6 py-3">' . $grade['grade'] . '</td>';
									echo '<td class="px-6 py-3">' . "None" . '</td>';
									echo '<td class="px-6 py-3">' . "Never" . '</td>';
									echo '<td class="px-6 py-3">' . $subjects[$grade['id_subject'] - 1]['name'] . '</td>';
									echo '<td class="px-6 py-3">' . "Added" . '</td>';
									echo '</tr>';

									foreach ($grade['modificated_grades'] as $modificated_grade) {
										echo '<tr class="bg-white border-b dark:bg-blue-800 dark:border-gray-700">';
										echo '<td class="px-6 py-3">' . $grade['id'] . '</td>';
										echo '<td class="px-6 py-3">' . $modificated_grade['original_grade'] . '</td>';
										echo '<td class="px-6 py-3">' . $modificated_grade['changed_grade'] . '</td>';
										echo '<td class="px-6 py-3">' . $modificated_grade['date_modification'] . '</td>';
										echo '<td class="px-6 py-3">' . $subjects[$grade['id_subject'] - 1]['name'] . '</td>';
										echo '<td class="px-6 py-3">' . "Modified" . '</td>';
										echo '</tr>';
									}
								}
							}

							echo '</table>';
						} catch (Exception $e) {
							echo $e->getMessage();
						}

						?>

					</tbody>
				</table>
			</tbody>
		</table>
	</div>
</body>

</html>