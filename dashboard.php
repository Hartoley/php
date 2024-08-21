<?php
 session_start();
 include("./database/connectdb.php");
//  if ($_GET['message']) {
//     $mess = $_GET['message'];
//     echo $mess;
//  }
if (!isset($_SESSION['email']) || time() > $_SESSION["tokenExp"]) {
    session_destroy();
    header("location: loggin.php?message=Your token has expired. Kindly loggin again");
    
} else {
    $user_email = $_SESSION['email'];
    $sql = "SELECT * FROM user WHERE email ='$user_email'";
    $response= mysqli_query($conn, $sql);
    $result = mysqli_fetch_assoc($response);
    // print_r($result);
    if ($result) {
        $user_id = $result['id'];
        $firstName = $result['first_name'];
        $lastName = $result['last_name'];
        $prof_pix = $result['avatar'];
    }

}

$fecthingData = "SELECT * FROM user";
$data = mysqli_query($conn, $fecthingData);
if ($data) {
    while ($users = mysqli_fetch_assoc($data)) {
        echo "<h1>" . $users['first_name'] . ' '.$users['last_name']. "</h1>";
    }
} else {
    echo "Error: " . mysqli_error($conn);
}

if (isset($_POST['update'])) {
    $img_path = "images/";
    $file = $img_path. basename($_FILES['profile_picture']['name']);

    $sql = "UPDATE user SET avatar = '$file' WHERE email='$user_email'";
    if (mysqli_query($conn, $sql)) {
        move_uploaded_file($_FILES['profile_picture']['tmp_name'], $file);
        echo "Profile picture updated";
        header("location: dashboard.php?message=Profile picture updated successfully");
    }else {
        echo mysqli_error($conn). "cannot upload image";
    }
}



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <style>
    *{
            padding: 0;
            margin: 0;
        }
    body {
        font-family: Arial, sans-serif;
        background-image: linear-gradient(to bottom, #4a90e2 40%, white 25%);
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        height: 100vh;
        margin: 0;
    }

    .profile-card {
        background-color: #fff;
        border-radius: 15px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        text-align: center;
        width: 300px;
        padding: 20px;
        position: relative;
        
    }

    .close-btn {
        position: absolute;
        top: 10px;
        right: 10px;
        font-size: 20px;
        cursor: pointer;
    }

    .profile-img img {
        border-radius: 50%;
        width: 80px;
        height: 80px;
        margin-bottom: 15px;
    }

    .profile-info h2 {
        font-size: 18px;
        margin: 0;
        font-weight: bold;
    }

    .profile-info p {
        font-size: 14px;
        color: #555;
        margin: 5px 0;
    }

    .profile-links {
        margin: 15px 0;
    }

    .profile-links a {
        color: #007bff;
        text-decoration: none;
        font-size: 14px;
    }

    .profile-links a:hover {
        text-decoration: underline;
    }

    .profile-actions {
        margin-top: 20px;
    }

    .action-btn {
        background-color: #f8f9fa;
        border: 1px solid #ced4da;
        border-radius: 5px;
        padding: 10px 20px;
        margin: 5px;
        cursor: pointer;
        font-size: 14px;
    }

    .action-btn:hover {
        background-color: #e2e6ea;
    }

    </style>
</head>
<body>
<h1>Welcome to your Dashboard....</h1>
     <div class="profile-card">
     
        <div class="close-btn">&times;</div>
        <div class="profile-img">
            <img src="<?php echo $prof_pix?>" alt="">
        </div>
        <div class="profile-info">
        <h2><?= $firstName . ' ' . $lastName ?></h2>
            <p><?= $user_email?></p>
            <p>Zoho User ID : <?= $user_id?> </p>
            <p>Super admin : <?= $user_email?></p>
        </div>  
        <div class="profile-links">
            <a href="#">Control Panel</a> • <a href="#">Subscription</a>
        </div>
        <div class="profile-actions">
            <button class="action-btn">My account</button>
            <button class="action-btn">Sign out</button>
        </div>
    </div>
    <div>
           
           <h2>All Registered Users</h2>
             
     
</div>
    <form action="dashboard.php" method="POST" enctype="multipart/form-data">
        <input type="file" name="profile_picture">
        <button name="update">Update</button>
    </form>
    <form action="processForm.php" method="POST">
        <button name="logout">Log out</button>
    </form>
</body>
</html>