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
        require_once "./admin_header.php";

        if (isset($_SESSION['userDeletedMsg'])) {
            echo '<h2>' . $_SESSION['userDeletedMsg'] . '</h2>';
            unset($_SESSION['userDeletedMsg']);
        }

        if (isset($_SESSION['editMessage'])) {
            echo '<h4>' . $_SESSION['editMessage'] . '</h4>';
            unset($_SESSION['editMessage']);
        }

        if (isset($_SESSION['addMessage'])) {
            echo '<h4>' . $_SESSION['addMessage'] . '</h4>';
            unset($_SESSION['addMessage']);
        }
        ?>

        <h1 class="text-white text-4xl mb-6">Students</h1>
        <!-- Table -->
        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400 shadow-md">
            <thead class="text-xs text-gray-700 uppercase bg-blue-50 dark:bg-blue-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">Name</th>
                    <th scope="col" class="px-6 py-3">Role</th>
                    <th scope="col" class="px-6 py-3">Edit</th>
                    <th scope="col" class="px-6 py-3">Delete</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $fetchUsersQuery = $service->initializeQueryBuilder();

                try {
                    $usersQuery = $fetchUsersQuery->select('*')
                        ->from('profiles')
                        ->execute()
                        ->getResult();
                    $userCounter = -1;
                    foreach ($usersQuery as $user) {
                        $userCounter++;
                        $user = json_decode(json_encode($usersQuery[$userCounter]), true);
                        echo '<tr class="bg-white border-b dark:bg-blue-800 dark:border-gray-700">';
                        echo '<td class="px-6 py-3">' . $user['firstName'] . " " . $user['lastName'] . '</td>';
                        echo '<td class="px-6 py-3">' . $user['role'] . '</td>';
                        echo '<td class="px-6 py-3">';
                        echo '<a class="bg-cyan-300 text-sm active:bg-cyan-700 cursor-pointer font-regular text-black px-4 py-2 rounded uppercase shadow-lg" href="edit_user.php?userId=' . $user['uuid'] . '">Edit</a>';
                        echo '</td>';
                        echo '<form action="delete_user.php" method="POST">';
                        echo '<input class="hidden" type="text" name="userId" value="' . $user['uuid'] . '"/>';
                        echo '<td class="px-6 py-3">';
                        echo '<button type="submit" class="bg-cyan-300 text-sm active:bg-cyan-700 cursor-pointer font-regular text-black px-4 py-2 rounded uppercase shadow-lg">Delete</button>';
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
        <br><a
            class="bg-cyan-300 text-sm active:bg-cyan-700 cursor-pointer font-regular text-black px-4 py-2 rounded uppercase shadow-lg"
            href="admin_add_user.php">Add User</a>
    </div>
</body>

</html>