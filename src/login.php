<?php ; ?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href="./output.css" rel="stylesheet" />
	<title>Login</title>
</head>

<body class="bg-blue-950">
	<div class="bg-indigo-950 p-5 max-w-md h-screen mx-auto rounded shadow-2xl shadow-cyan-500">
		<form action="auth.php" method="POST">
			<h1 class="text-white text-4xl mt-28 mb-6">Login</h1>
			<p>
				<?php
				if (isset($_SESSION['login_error'])) {
					echo '<h5 class="block text-red-700 text-sm font-bold mb-2">' . $_SESSION['login_error'] . '</h5>';
					unset($_SESSION['login_error']);
				}
				?>
			</p>
			<div class="mb-4">
				<label class="block text-white text-sm font-bold mb-2" for="email"> Email </label>
				<input class="bg-slate-400 w-full border rounded h-12 px-4 focus:outline-none" type="email" name="email"
					required autofocus />
			</div>
			<div class="mb-6">
				<label class="block text-white text-sm font-bold mb-2" for="password"> Password </label>
				<input class="bg-slate-400 w-full border rounded h-12 px-4 focus:outline-none" type="password"
					name="password" required />
			</div>
			<div class="flex flex-col md:flex-row md:items-center justify-between ">
				<button
					class="bg-cyan-300 text-sm active:bg-cyan-700 cursor-pointer font-regular text-black px-4 py-2 rounded uppercase shadow-lg"
					type="submit">Login</button>
			</div>
		</form>
	</div>
</body>

</html>