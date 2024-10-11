<?php
function whoIsWinner()
{
    // 1 of 8: top row
    $winner = checkWhoHasTheSeries(['1-1', '2-1', '3-1']);
    if ($winner != null) return $winner;
    // 2 of 8: middle row
    $winner = checkWhoHasTheSeries(['1-2', '2-2', '3-2']);
    if ($winner != null) return $winner;
    // 3 of 8: bottom row
    $winner = checkWhoHasTheSeries(['1-3', '2-3', '3-3']);
    if ($winner != null) return $winner;
    // 4 of 8: left column
    $winner = checkWhoHasTheSeries(['1-1', '1-2', '1-3']);
    if ($winner != null) return $winner;
    // 5 of 8: middle column
    $winner = checkWhoHasTheSeries(['2-1', '2-2', '2-3']);
    if ($winner != null) return $winner;
    // 6 of 8: right column
    $winner = checkWhoHasTheSeries(['3-1', '3-2', '3-3']);
    if ($winner != null) return $winner;
    // 7 of 8: diagonal left to right
    $winner = checkWhoHasTheSeries(['1-1', '2-2', '3-3']);
    if ($winner != null) return $winner;
    // 8 of 8: diagonal right to left
    $winner = checkWhoHasTheSeries(['3-1', '2-2', '1-3']);
    if ($winner != null) return $winner;
    return null; // Its a draw
}

function checkWhoHasTheSeries($list)
{
    // Initialize counts for X and O
    $XCount = 0;
    $OCount = 0;

    // Count Xs and Os in the provided list of positions
    foreach ($list as $value) {
        if (isset($_SESSION['board'][$value])) {
            if ($_SESSION['board'][$value] == 'X') {
                $XCount++;
            } elseif ($_SESSION['board'][$value] == 'O') {
                $OCount++;
            }
        }
    }

    // Determine if either player has completed a winning series
    if ($XCount == 3) {
        return 'X';
    } elseif ($OCount == 3) {
        return 'O';
    } else {
        return null;
    }
}
?>
