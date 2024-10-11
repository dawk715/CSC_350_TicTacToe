<?php
session_start();
include 'tic-tac-toe-functions.php'; // Correctly include the helper functions

// Initialize game state
if (!isset($_SESSION['turn'])) {
    $_SESSION['turn'] = 'X';
}
if (!isset($_SESSION['board'])) {
    $_SESSION['board'] = array_fill_keys(['1-1', '2-1', '3-1', '1-2', '2-2', '3-2', '1-3', '2-3', '3-3'], '');
}

// Process button clicks
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    foreach ($_POST as $key => $value) {
        if ($_SESSION['board'][$key] == '' && in_array($key, array_keys($_SESSION['board']))) {
            $_SESSION['board'][$key] = $_SESSION['turn'];
            $_SESSION['turn'] = $_SESSION['turn'] == 'X' ? 'O' : 'X';
            break;
        }
    }

    // Check for a winner or draw using helper function from tic-tac-toe-functions.php
    $winner = whoIsWinner();
    if ($winner) {
        $_SESSION['winner'] = $winner;
        $_SESSION['turn'] = null; // End the game
    } elseif (!in_array('', $_SESSION['board'])) {
        $_SESSION['draw'] = true; // No spaces left
    }
}

// Reset game 
if (isset($_GET['reset'])) {
    session_destroy();
    header("Location: tic-tac-toe.php");
    exit();
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tic Tac Toe</title>
    <link rel="stylesheet" href="tic-tac-toe-style.css">
</head>
<body>
    <h1>Tic Tac Toe</h1>
    <?php
    // Display turn, winner, or draw message
    if (isset($_SESSION['winner'])) {
        echo "<p>The winner is {$_SESSION['winner']}!</p>";
    } elseif (isset($_SESSION['draw'])) {
        echo "<p>It's a draw!</p>";
    } else {
        echo "<p>Turn: {$_SESSION['turn']}</p>";
    }
    ?>

<form method="POST" action="tic-tac-toe.php">
    <table>
        <?php
        // Generate game board
        for ($row = 1; $row <= 3; $row++) {
            echo "<tr>";
            for ($col = 1; $col <= 3; $col++) {
                $position = "$col-$row";
                $value = $_SESSION['board'][$position];
                $currentTurn = $_SESSION['turn'];
                
                // Determine background color based on the player's selection
                $color = ($value == 'X') ? "background-color:green;" : (($value == 'O') ? "background-color:red;" : "");

                echo "<td style='$color'>";

                if (isset($_SESSION['winner'])) {
                    // If there is a winner, leave unselected cells empty
                    if ($value == '') {
                        echo ""; // Leave the cell empty
                    } else {
                        echo "<p>$value</p>"; // Display chosen cells with their values
                    }
                } else {
                    // No winner yet, so display buttons in unselected cells with current turn symbol
                    if ($value == '') {
                        echo "<button type='submit' name='$position' value='$currentTurn'>$currentTurn</button>";
                    } else {
                        echo "<p>$value</p>";
                    }
                }

                echo "</td>";
            }
            echo "</tr>";
        }
        ?>
    </table>
</form>




    <!-- Reset button to restart the game -->
    <form method="GET" action="tic-tac-toe.php">
        <button type="submit" name="reset" value="true" class='resetbutton'>Reset Game</button>
    </form>
</body>
</html>
