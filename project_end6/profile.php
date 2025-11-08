<?php
require_once('db_connect.php');
session_start();
$id = $_SESSION['id'];
$sql = "SELECT * FROM users WHERE id = :id";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':id', $id, PDO::PARAM_STR);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fa">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>پروفایل کاربری</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Baloo+Bhaijaan+2:wght@400..800&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: "Baloo Bhaijaan 2", sans-serif !important;
            background: linear-gradient(rgba(2, 2, 2, 0.369), rgba(2, 2, 2, 0.3)), url("https://img.lovepik.com/background/20211021/large/lovepik-blue-science-and-technology-background-image_500425113.jpg");
            background-size: cover;
            background-position: center;
            direction: rtl;
            text-align: right;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .profile-container {
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            animation: fadeInUp 1s;
        }
        .profile-image {
            border-radius: 50%;
            margin-bottom: 20px;
            animation: pulse 1s infinite alternate;
        }
        .profile-button {
            margin-top: 20px;
        }
        .btn-primary {
            background-color: #6a1b9a;
            border-color: #6a1b9a;
        }
        .btn-primary:hover {
            background-color: #4a148c;
            border-color: #4a148c;
        }
        .btn-danger {
            background-color: #d32f2f;
            border-color: #d32f2f;
        }
        .btn-danger:hover {
            background-color: #b71c1c;
            border-color: #b71c1c;
        }
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translate3d(0, 0px, 0);
            }
            to {
                opacity: 1;
                transform: none;
            }
        }
        @keyframes pulse {
            from {
                transform: scale(1);
            }
            to {
                transform: scale(1.1);
            }
        }
    </style>
</head>
<body>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="profile-container border border-light px-4 py-3 rounded text-light">
                <div class="text-center">
                    <img class="profile-image rounded-circle" width="150px" src="profile.jpg" alt="تصویر پروفایل">
                    <h2 class="font-weight-bold"><?php echo $user["username"]; ?></h2>
                    <p class=""><?php echo $user["email"]; ?></p>
                </div>
                <hr>
                <?php if (isset($_POST['delete'])): ?>
                <div class="alert alert-success fade show text-center" role="alert">
                    Your account has been successfully deleted
                    
                </div>
                <script>
                    setTimeout(function() {
                        window.location.href = 'register.html';
                    }, 2000);
                </script>
                <?php endif; ?>
                <div >
                    <form method="post">
                        <div class="form-group">
                            <label for="firstname">نام</label>
                            <input type="text" class="form-control" value="<?php echo $user['first_name']; ?>" disabled>
                        </div>
                        <div class="form-group">
                            <label for="lastname">نام خانوادگی</label>
                            <input type="text" class="form-control" value="<?php echo $user['last_name']; ?>" disabled>
                        </div>
                        <div class="form-group">
                            <label for="password">رمز عبور</label>
                            <input type="text" class="form-control" value="<?php echo $user['password']; ?>" disabled>
                        </div>
                        <div class="text-center">
                            <a class="btn btn-primary profile-button" href="login.html">خروج</a>
                            <button class="btn btn-danger profile-button" type="submit" name="delete">حذف حساب کاربری</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>

</body>
</html>

<?php
if (isset($_POST['delete'])) {
    try {
        $sql = "DELETE FROM users WHERE id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_STR);
        $stmt->execute();
        
        // پایان دادن به نشست کاربر
        session_destroy();
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>
