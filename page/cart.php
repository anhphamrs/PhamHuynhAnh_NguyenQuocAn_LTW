<?php

include 'connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
};
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
    <link rel="stylesheet" href="../css/cart.css">
    <link rel="stylesheet" href="../css/index.css">
    <link rel="stylesheet" href="../css/navigation.css">
    <!-- import js -->
    <!-- <script src="../js/product-detail.js" defer></script> -->
    <script src="../js/cart.js" defer></script>
    <script src="../js/cart-total.js" defer></script>
    <title>Cart</title>
</head>

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
                <a href="../index.php"><img class="logo" src="../imgs/logo.svg" /></a>
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
            <div class="flex navbar-user">
                <i class="fa fa-user-circle-o"></i>
                <div class="navbar-user-text">
                    <p><?= $fetch_profile["name"]; ?></p>
                    <a href="../page/user_logout.php" class="delete-btn" onclick="return confirm('Bạn Muốn Đăng Xuất?');">Đăng Xuất</a> 
                </div>
            </div>
            <?php
                }else{
            ?>
            <div class="flex navbar-user">
                <i class="fa fa-user-circle-o"></i>
                <div class="navbar-user-text">
                    <a href="../page/login.php">Đăng nhập</a>
                    <a href="../page/login.php">Đăng ký</a>
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
                <a href="../page/cart.php" class="navbar-user-text">
                    <p>Giỏ hàng của bạn</p>
                    <p id="cart"></p>
                </a>
            </div>
        </div>
    </section>
    <section class="flex content">
        <div id="container" class="flex content-wraper">
            <div id="cart">
            <div class="cart-head"><a href="../index.php">Trang chủ</a><i class="fa fa-angle-right" aria-hidden="true"></i><a href="../">Giỏ Hàng</a></div>
                <h1 class="cart-head-title">Giỏ hàng</h1>
            </div>
        </div>
      
    </section>
    <section class="flex content">
        <div  id="container" class="flex content-wraper">
            <div class="cart-table">
                <div class="table-head">
                    <p><strong>Sản phẩm</strong></p>
                    <p>Đơn giá</p>
                    <p>Số lượng</p>
                    <p>Thành tiền</p>
                </div>
                <div id="table-body">

                </div>
            </div>
            <div class="cart-total">
                <p><strong>Thanh toán</strong></p>
                <div class="flex cart-total-wraper">
                    <p>Thành tiền</p>
                    <p id="total"></p>
                </div>
                <button class="cart-total-btn">THANH TOÁN</button>
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