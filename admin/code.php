<?php 
require_once '../config/function.php';
require_once '../connection.php'; // Ensure correct connection

function executeQuery($conn, $query, $params, $types) {
    $stmt = $conn->prepare($query);
    if ($stmt === false) {
        die('Prepare failed: ' . htmlspecialchars($conn->error));
    }
    $stmt->bind_param($types, ...$params);
    if ($stmt->execute() === false) {
        die('Execute failed: ' . htmlspecialchars($stmt->error));
    }
    return $stmt->affected_rows > 0;
}

if(isset($_POST['saveUser'])) {
    $name = validate($_POST['username']);
    $email = validate($_POST['email']);
    $password = validate($_POST['password']);
    $role = validate($_POST['role']);

    if($name && $email && $password) {
        $query = "INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, ?)";
        $result = executeQuery($conn, $query, [$name, $email, $password, $role], 'ssss');

        if($result) {
            redirect('users.php', 'User/Admin Added Successfully');
        } else {
            redirect('users-create.php', 'Something Went Wrong');
        }
    } else {
        redirect('users-create.php', 'Please fill all the input fields');
    }
}

if(isset($_POST['updateUser'])) {
    $name = validate($_POST['username']);
    $email = validate($_POST['email']);
    $password = validate($_POST['password']);
    $role = validate($_POST['role']);

    $userId = validate($_POST['userId']);

    $user = getById('users',$userId);
    if($user['status'] != 200){
        redirect('users-edit.php?id='.$userId,'No such id found');
    }

    if($name && $email && $password) {
        $query = "UPDATE users SET username = ?, email = ?, password = ?, role = ? WHERE id = ?";
        $result = executeQuery($conn, $query, [$name, $email, $password, $role, $userId], 'ssssi');

        if($result) {
            redirect('users-edit.php?id='.$userId,'User/Admin Updated Successfully');
        } else {
            redirect('users-create.php','Something Went Wrong');
        }
    } else {
        redirect('users-create.php','Please fill all the input fields');
    }
}

if(isset($_POST['saveSetting'])) {
    $email1 = validate($_POST['email1']);
    $phone1 = validate($_POST['phone1']);
    $address = validate($_POST['address']);

    $settingId = validate($_POST['settingId']);

    if($settingId == 'insert') {
        $query = "INSERT INTO settings (email1, phone1, address) VALUES (?, ?, ?)";
        $result = executeQuery($conn, $query, [$email1, $phone1, $address], 'sss');
    }

    if(is_numeric($settingId)) {
        $query = "UPDATE settings SET email1 = ?, phone1 = ?, address = ? WHERE id = ?";
        $result = executeQuery($conn, $query, [$email1, $phone1, $address, $settingId], 'sssi');
    }

    if($result) {
        redirect('settings.php','Settings Saved');
    } else {
        redirect('settings.php','Something Went Wrong');
    }
}

// ADD CATEGORY
if(isset($_POST['saveCategory'])) {
    $category_name = validate($_POST['category_name']);

    if(!empty($category_name)) {
        $query = "INSERT INTO categories (name) VALUES (?)";
        $result = executeQuery($conn, $query, [$category_name], 's');

        if($result) {
            redirect('categories.php', 'Category Added Successfully');
        } else {
            redirect('categories-create.php', 'Something Went Wrong');
        }
    } else {
        redirect('categories-create.php', 'Please enter a category name');
    }
}

// ADD PRODUCT
if(isset($_POST['saveProduct'])) {
    $category_id = validate($_POST['category_id']);
    $name = validate($_POST['product_name']);
    $description = validate($_POST['product_description']);
    $price = validate($_POST['product_price']);

    // Handle File Upload
    $image = $_FILES['product_image']['name'];
    $image_tmp = $_FILES['product_image']['tmp_name'];
    $image_path = "uploads/" . basename($image);

    if (move_uploaded_file($image_tmp, "../" . $image_path)) {
        $query = "INSERT INTO products (category_id, name, description, price, image) VALUES (?, ?, ?, ?, ?)";
        $result = executeQuery($conn, $query, [$category_id, $name, $description, $price, $image_path], 'issss');

        if ($result) {
            $_SESSION['message'] = "Product Added Successfully!";
        } else {
            $_SESSION['message'] = "Something went wrong!";
        }
    } else {
        $_SESSION['message'] = "Image upload failed!";
    }

    header("Location: products-create.php"); // Stay on the same page after adding
    exit();
}
?>