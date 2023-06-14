<?php
;
$userData = $_SESSION['userData'];
if ($userData['role'] != 'admin') {
	switch ($userData['role']) {
		case "user":
			header("Location: user_homepage.php");
			die();
		case "teacher":
			header("Location: teacher_homepage.php");
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
	<title>Add user</title>
</head>

<body class="bg-blue-950">
	<div class="bg-indigo-950 p-5 max-w-md h-screen mx-auto rounded shadow-2xl shadow-cyan-500">
		<h1 class="text-white text-4xl mt-10 mb-6">Add user</h1>
		<?php
		if (isset($_SESSION['addUser_error'])) {
			echo '<h4 class="text-white text-xl mb-6">' . $_SESSION['addUser_error'] . '</h4>';
			unset($_SESSION['addUser_error']);
		} ?>
		<form action="add_user.php" method="POST">
			<div class="mb-4">
				<label class="block text-white text-sm font-bold mb-2" for="firstName"> First Name </label>
				<input class="bg-slate-400 w-full border rounded h-12 px-4 focus:outline-none" type="text"
					name="firstName" required />
			</div>
			<div class="mb-4">
				<label class="block text-white text-sm font-bold mb-2" for="lastName"> Last Name </label>
				<input class="bg-slate-400 w-full border rounded h-12 px-4 focus:outline-none" type="text"
					name="lastName" required />
			</div>
			<div class="mb-4">
				<label class="block text-white text-sm font-bold mb-2" for="email"> Email </label>
				<input class="bg-slate-400 w-full border rounded h-12 px-4 focus:outline-none" type="text" name="email"
					required />
			</div>
			<div class="mb-4">
				<label class="block text-white text-sm font-bold mb-2" for="password"> Password </label>
				<input class="bg-slate-400 w-full border rounded h-12 px-4 focus:outline-none" type="password"
					name="password" required />
			</div>
			<div class="mb-4">
				<label class="block text-white text-sm font-bold mb-2" for="confirmPassword"> Confirm Password </label>
				<input class="bg-slate-400 w-full border rounded h-12 px-4 focus:outline-none" type="password"
					name="confirmPassword" required />
			</div>
			<div class="mb-6">
				<label class="block text-white text-sm font-bold mb-2" for="role"> Role </label>
				<select class="bg-slate-400 w-full border rounded h-12 px-4 focus:outline-none" name="role">
					<option value="user">Student</option>
					<option value="teacher">Teacher</option>
					<option value="admin">Admin</option>
				</select>
			</div class="mb-6">
			<div class="flex flex-col md:flex-row md:items-center justify-between ">
				<a class="bg-cyan-300 text-sm active:bg-cyan-700 cursor-pointer font-regular text-black px-4 py-2 rounded uppercase shadow-lg"
					href="./admin_homepage.php">Back</a>
				<button type="submit"
					class="bg-cyan-300 text-sm active:bg-cyan-700 cursor-pointer font-regular text-black px-4 py-2 rounded uppercase shadow-lg">Add</a>
			</div>
		</form>
	</div>
</body>

</html>