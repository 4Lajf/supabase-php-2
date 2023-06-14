<?php
;
require "vendor/autoload.php";
$service = new PHPSupabase\Service(
	"eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6ImhzZXBqZ3h4b3pleWt0amtiZXdjIiwicm9sZSI6ImFub24iLCJpYXQiOjE2NzYwMzgwODQsImV4cCI6MTk5MTYxNDA4NH0.zusO9r5QquROh2XfQ6CIM0sbL3Re2KPtSOsHK7lsPfc",
	"https://hsepjgxxozeyktjkbewc.supabase.co/rest/v1/"
);
$userData = $_SESSION['userData'];
if ($userData['role'] == 'user') {
	header("Location: user_homepage.php");
}

if (isset($_GET['gradeId'])) {
	$_SESSION['gradeId'] = $_GET['gradeId'];
	$gradeId = $_SESSION['gradeId'];
} else {
	echo "Missing parameter \"gradeId\" ";
	die();
}


$fetchGradesQuery = $service->initializeQueryBuilder();
$gradesQuery = $fetchGradesQuery->select('*')
	->from('users_grades')
	->join('profiles', 'uuid')
	->where('id', "eq.$gradeId")
	->execute()
	->getResult();
$grade = json_decode(json_encode($gradesQuery[0]), true);
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href="./output.css" rel="stylesheet" />
	<title>Edit</title>
</head>

<body class="bg-blue-950">
	<div class="bg-indigo-950 p-5 max-w-md h-screen mx-auto rounded shadow-2xl shadow-cyan-500">
		<h1 class="text-white text-4xl mt-28 mb-6">Edit Grade</h1>
		<div class="mb-4">
			<p class="text-white text-2xl">Name:
				<?php echo $grade['profiles']['firstName'] . " " . $grade['profiles']['lastName']; ?>
			<p>
		</div>
		<div class="mb-6">
			<form action="script_edit_grade.php" method="POST">
				<table class="w-full text-sm text-left text-gray-500 dark:text-gray-400 shadow-md">
					<tbody>
						<!--Table expanded-->
						<table class="w-full text-sm text-left text-gray-500 dark:text-gray-400 shadow-md">
							<thead
								class="text-xs text-gray-700 uppercase bg-blue-50 dark:bg-blue-700 dark:text-gray-400">
								<tr>
									<th scope="col" class="px-6 py-3">Current Grade</th>
									<th scope="col" class="px-6 py-3">New Grade</th>
								</tr>
							</thead>
							<tbody>
								<tr class="bg-white border-b dark:bg-blue-800 dark:border-gray-700">
									<td class="px-6 py-3">
										<?php echo $grade['grade'] ?>
									</td>
									<td class="px-6 py-3">
										<select class="text-sm border rounded focus:outline-none shadow-lg"
											name="newGrade">
											<option value="1">1</option>
											<option value="2">2</option>
											<option value="3">3</option>
											<option value="4">4</option>
											<option value="5">5</option>
											<option value="6">6</option>
										</select>
									</td>
								</tr>
							</tbody>
						</table>
					</tbody>
				</table>
		</div>
		<div class="flex flex-col md:flex-row md:items-center justify-between ">
			<a class="bg-cyan-300 text-sm active:bg-cyan-700 cursor-pointer font-regular text-black px-4 py-2 rounded uppercase shadow-lg"
				href="teacher_homepage.php">Back</a>
			<button type="submit"
				class="bg-cyan-300 text-sm active:bg-cyan-700 cursor-pointer font-regular text-black px-4 py-2 rounded uppercase shadow-lg">Edit</button>
			</form>
		</div>
	</div>
</body>

</html>