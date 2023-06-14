<?php
;
$userData = $_SESSION['userData'];
?>
<header>
    <ul class="bg-cyan-500 flex mb-6 shadow-md">
        <li class="mr-3">
            <a class="bg-cyan-300 hover:bg-cyan-400 text-sm active:bg-cyan-700 cursor-pointer font-regular text-black px-4 py-2 uppercase shadow-md"
                href="./student_homepage.php">
                Grades</a>
        </li>
        <li class="mr-3">
            <a class="bg-cyan-300 hover:bg-cyan-400 text-sm active:bg-cyan-700 cursor-pointer font-regular text-black px-4 py-2 uppercase shadow-md"
                href="./student_history.php">
                History</a>
        </li>
        <li class="mr-3">
            <form action="logout.php" method="POST"
                class="bg-cyan-300 hover:bg-cyan-400 text-sm active:bg-cyan-700 cursor-pointer font-regular text-black px-4 py-2 uppercase shadow-md">
                <button type="submit">Logout</button>
            </form>
        </li>
        <li class="mr-3">
            <p class="bg-cyan-300 text-sm font-regular text-black px-4 py-2 uppercase">
                <?php echo "Hello " . $userData['firstName'] ?>
            </p>
        </li>
    </ul>
</header>
<hr class="mb-6">