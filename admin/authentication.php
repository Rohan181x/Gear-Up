<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include('../connection.php'); // Ensure DB connection is included

if(isset($_SESSION['auth']))
{
    if(isset($_SESSION['role']) && isset($_SESSION['email'])) { // Use correct session keys

        $role = validate($_SESSION['role']); 
        $email = validate($_SESSION['email']); 

        // Use prepared statements to prevent SQL injection
        $query = "SELECT * FROM users WHERE email = ? AND role = ? LIMIT 1";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ss", $email, $role);
        $stmt->execute();
        $result = $stmt->get_result();

        if($result && $result->num_rows > 0){
            $row = $result->fetch_assoc();
            if($row['role'] !== 'admin'){
                logoutSession();
                redirect('../login.php','Access Denied');
            }
        } else {
            logoutSession();
            redirect('../login.php','Access Denied');
        }
    } else {
        redirect('../login.php','Invalid Session Data');
    }
} else {
    redirect('../login.php','Login to continue');
}
?>
