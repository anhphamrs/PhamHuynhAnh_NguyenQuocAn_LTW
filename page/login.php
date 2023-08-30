<?php   

include 'connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
};

if(isset($_POST['submitSignUp'])){

   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);
   $email = $_POST['email'];
   $email = filter_var($email, FILTER_SANITIZE_STRING);
   $pass = sha1($_POST['pass']);
   $pass = filter_var($pass, FILTER_SANITIZE_STRING);
   $cpass = sha1($_POST['cpass']);
   $cpass = filter_var($cpass, FILTER_SANITIZE_STRING);

   $select_user = $conn->prepare("SELECT * FROM `acc` WHERE email = ?");
   $select_user->execute([$email,]);
   $row = $select_user->fetch(PDO::FETCH_ASSOC);

   if($select_user->rowCount() > 0){
      $message[] = 'Email Đã Tồn Tại!';
   }else{
      if($pass != $cpass){
         $message[] = 'Mật Khẩu Không Đúng!';
      }else{
         $insert_user = $conn->prepare("INSERT INTO `acc`(name, email, password) VALUES(?,?,?)");
         $insert_user->execute([$name, $email, $cpass]);
         $message[] = 'Đăng Kí Thành Công, Đăng Nhập Ngay!';
      }
   }

}

if(isset($_POST['submitSignIn'])){

    $email = $_POST['email'];
    $email = filter_var($email, FILTER_SANITIZE_STRING);
    $pass = sha1($_POST['pass']);
    $pass = filter_var($pass, FILTER_SANITIZE_STRING);
 
    $select_user = $conn->prepare("SELECT * FROM `acc` WHERE email = ? AND password = ?");
    $select_user->execute([$email, $pass]);
    $row = $select_user->fetch(PDO::FETCH_ASSOC);
 
    if($select_user->rowCount() > 0){
       $_SESSION['user_id'] = $row['id'];
       header('location:../index.php');
    }else{
       $message[] = 'Tên đăng nhập hoặc mật khẩu không chính xác!';
    }
 
 }
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- import font roboto -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
    <!-- import font-awesome -->
    <link rel="stylesheet" href="../imgs\font-awesome-4.7.0\css\font-awesome.min.css">
    <!-- import css -->
    <link rel="stylesheet" href="../css/login.css">
    <link rel="stylesheet" href="../css/index.css">
    <link rel="stylesheet" href="../css/navigation.css">
    <!-- import js -->
    <script src="../js/login.js" defer></script>
    <script src="../js/cart.js" defer></script>

    <title>Login</title>
</head>
<?php
   if(isset($message)){
      foreach($message as $message){
         echo '
         <div class="message">
            <span>'.$message.'</span>
            <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
         </div>
         ';
      }
   }
?>

<body>
    <section class="head-info">
        <ul id="container">
            <li><i class="fa fa-ticket" aria-hidden="true"></i>
                <p>Khuyến mại</p>
            </li>
            <li><i class="fa fa-building" aria-hidden="true"></i>
                <p>Hệ thống Showroom</p>
            </li>
            <li><i class="fa fa-headphones" aria-hidden="true"></i>
                <p>Tư vấn mua hàng: 1800 6867</p>
            </li>
            <li><i class="fa fa-headphones" aria-hidden="true"></i>
                <p>CSKH: 1800 6865</p>
            </li>
            <li><i class="fa fa-newspaper-o" aria-hidden="true"></i>
                <p>Tin công nghệ</p>
            </li>
            <li><i class="fa fa-cog" aria-hidden="true"></i>
                <p>Xây dựng cấu hình</p>
            </li>
        </ul>
    </section>
    <section class="navbar">
        <div id="container">
            <div class="flex">
                <a href=" ../index.php"><img class="logo" src="../imgs/logo.svg" /></a>
                <div class="flex dropdown-navbar">
                    <i class="fa fa-bars fa-lg"></i>
                    <p>Danh mục sản phẩm</p>
                </div>
            </div>
            <div class="flex navbar-search">
                <input type="text" placeholder="Nhập từ khoá cần tìm" />
                <div class="search-button">
                    <i class="fa fa-search"></i>
                </div>
            </div>
            <?php          
            $select_profile = $conn->prepare("SELECT * FROM `acc` WHERE id = ?");
            $select_profile->execute([$user_id]);
            if($select_profile->rowCount() > 0){
            $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
            ?>
            <p><?= $fetch_profile["name"]; ?></p>
            <?php
                }else{
            ?>
            <div class="flex navbar-user">
                <i class="fa fa-user-circle-o"></i>
                <div class="navbar-user-text">
                    <p>Đăng nhập</p>
                    <p>Đăng ký</p>
                </div>
            </div>
            <?php
                }
            ?> 
            <div class="flex navbar-alert">
                <i class="fa fa-bell-o"></i>
            </div>
            <div class="flex navbar-cart">
                <i class="fa fa-shopping-cart" aria-hidden="true"></i>
                <a href="../page/cart.html" class="navbar-user-text">
                    <p>Giỏ hàng của bạn</p>
                    <p id="cart"></p>
                </a>
            </div>
        </div>
    </section>
    <section class="login">
        <div class="login-form-wrap">
            <div class="login-container" id="login-container">
                <div class="form-container sign-up-container">
                    <form action="" method="post">
                        <h1>Create Account</h1>
                        <div class="social-container">
                            <i class="fa fa-facebook"></i>
                            <i class="fa fa-google"></i>
                        </div>
                        <span>or use your email for registration</span>
                        <input type="text" name="name" required placeholder="Name" maxlength="20"  class="box">
                        <input type="email" name="email" required placeholder="Email" maxlength="50"  class="box" oninput="this.value = this.value.replace(/\s/g, '')">
                        <input type="password" name="pass" required placeholder="Password" maxlength="20"  class="box" oninput="this.value = this.value.replace(/\s/g, '')">
                        <input type="password" name="cpass" required placeholder="Confirm password" maxlength="20"  class="box" oninput="this.value = this.value.replace(/\s/g, '')">
                        <button type="submit" class="btn" name="submitSignUp">Sign Up</button>
                    </form>
                </div>
                <div class="form-container sign-in-container">
                    <form form action="" method="post">
                        <h1>Sign in</h1>
                        <div class="social-container">
                            <i class="fa fa-facebook-f"></i>
                            <i class="fa fa-google"></i>
                        </div>
                        <span>or use your account</span>
                        <input type="email" name="email" required placeholder="Nhập Email..." maxlength="50"  class="box" oninput="this.value = this.value.replace(/\s/g, '')">
                        <input type="password" name="pass" required placeholder="Nhập Password..." maxlength="20"  class="box" oninput="this.value = this.value.replace(/\s/g, '')">  
                        <a href="#">Forgot your password?</a>
                        <input type="submit" value="Sign In" class="btn" name="submitSignIn">
                        <button type="submit" class="btn" name="submitSignIn">Sign In</button>
                    </form>
                </div>
                <div class="overlay-container">
                    <div class="overlay">
                        <div class="overlay-panel overlay-left">
                            <h1>Welcome Back!</h1>
                            <p>Đăng nhập ngay</p>
                            <button class="ghost" id="signIn">Sign In</button>
                        </div>
                        <div class="overlay-panel overlay-right">
                            <h1>Chưa có tài khoản ?</h1>
                            <p>Đăng kí ngay</p>
                            <button class="ghost" id="signUp">Sign Up</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</body>
<footer>
    <div class="flex footer-wrap">
        <div id="container" class="flex">
            <div>
                <strong>CÔNG TY CỔ PHẦN THƯƠNG MẠI - DỊCH VỤ PHONG VŨ</strong>
                <p>© 1997 - 2020 Công Ty Cổ Phần Thương Mại - Dịch Vụ Phong Vũ</p>
                <p>Giấy chứng nhận đăng ký doanh nghiệp: 0304998358 do Sở KH-ĐT TP.HCM cấp lần đầu ngày 30 tháng 05
                    năm 2007</p>
            </div>
            <div>
                <strong>Địa chỉ trụ sở chính:</strong>
                <p>Tầng 5, Số 117-119-121 Nguyễn Du, Phường Bến Thành, Quận 1, Thành Phố Hồ Chí Minh</p>
                <strong>Văn phòng điều hành miền Bắc:</strong>
                <p>Tầng 6, Số 1 Phố Thái Hà, Phường Trung Liệt, Quận Đống Đa, Hà Nội</p>
                <strong>Văn phòng điều hành miền Nam:</strong>
                <p>Tầng 11 Minh Long Tower, số 17 Bà Huyện Thanh Quan, Phường Võ Thị Sáu, Quận 3, TP. Hồ Chí Minh</p>
            </div>
        </div>
    </div>
</footer>

</html>