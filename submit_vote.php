<?php
include 'includes/session.php';

// Your existing vote submission logic
if(isset($_POST['vote'])) {
    // Process vote and insert into database
    // Example:
    $voter_id = $voter['id'];
    $positions = $_POST;

    foreach($positions as $position => $candidate_id) {
        if (is_array($candidate_id)) {
            foreach ($candidate_id as $id) {
                $sql = "INSERT INTO votes (voters_id, candidate_id) VALUES ('$voter_id', '$id')";
                $conn->query($sql);
            }
        } else {
            $sql = "INSERT INTO votes (voters_id, candidate_id) VALUES ('$voter_id', '$candidate_id')";
            $conn->query($sql);
        }
    }

    $_SESSION['success'] = 'Your vote has been submitted successfully';
    header('location: index.php');
} else {
    $_SESSION['error'] = ['Invalid request'];
    header('location: index.php');
}
?>
