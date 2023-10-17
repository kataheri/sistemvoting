<?php
include 'includes/session.php';
include 'includes/slugify.php';

if (isset($_POST['vote'])) {
    $selectedCandidates = $_POST;
    unset($selectedCandidates['vote']); // Hapus elemen 'vote' dari array $_POST

    $error = false;
    $sql_array = array();

    $sql = "SELECT * FROM positions";
    $query = $conn->query($sql);

    // Inisialisasi pesan kesalahan "Mohon isi setiap jabatan"
    $jabatan_error = false;

    while ($row = $query->fetch_assoc()) {
        $position = slugify($row['description']);
        $pos_id = $row['id'];

        if (!isset($selectedCandidates[$position])) {
            if (!$jabatan_error) {
                $_SESSION['error'][] = 'Mohon isi setiap jabatan';
                $jabatan_error = true;
            }
            $_SESSION['error'][] = 'Select candidates for ' . $row['description'];
            $error = true;
        } else {
            if ($row['max_vote'] > 1) {
                if (count($selectedCandidates[$position]) > $row['max_vote']) {
                    $_SESSION['error'][] = 'You can only choose ' . $row['max_vote'] . ' candidates for ' . $row['description'];
                    $error = true;
                } else {
                    foreach ($selectedCandidates[$position] as $key => $values) {
                        $sql_array[] = "INSERT INTO votes (voters_id, president_id, candidate_id, position_id) VALUES ('" . $voter['id'] . "', '$values', '$pos_id')";
                    }
                }
            } else {
                $candidate = $selectedCandidates[$position];

                // Dapatkan id position
                $position_id = $row['id'];

                // Cari position id di tabel candidate:
                $sql = "SELECT * FROM candidates WHERE position_id = '$position_id'";
                $cmquery = $conn->query($sql);
                $affected = $conn->affected_rows;

                if ($affected > 0) {
                    $candidate_id = $candidate;
                    $president_id = 0;
                } else {
                    $president_id = $candidate;
                    $candidate_id = 0;
                }

                $sql_array[] = "INSERT INTO votes (voters_id, president_id, candidate_id, position_id) VALUES ('" . $voter['id'] . "', '$president_id', '$candidate_id', '$pos_id')";
            }
        }
    }

    if (!$error) {
        foreach ($sql_array as $sql_row) {
            $conn->query($sql_row);
        }
        unset($_SESSION['post']);
        $_SESSION['success'] = 'Vote berhasil dikirim';
    }
} else {
    $_SESSION['error'][] = 'Select candidates to vote first';
}

header('location: home.php');
?>
