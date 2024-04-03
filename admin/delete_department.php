<?php
include('includes/config.php');

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    $memberId = $_GET['id'];

  

    $deleteMemberQuery = "DELETE FROM department WHERE id = $memberId";

    if ($conn->query($deleteMemberQuery) === TRUE) {
        header("Location: department.php");
        exit();
    } else {
        echo "Error deleting record: " . $conn->error;
    }
} else {
    header("Location: department.php");
    exit();
}

$conn->close();
?>