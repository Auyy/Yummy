<?php 
@session_start();
if (!isset($_SESSION['member_id'])) {
      header('location: member-signin.php');
      exit;
} else if ($_SERVER['REQUEST_METHOD'] != 'POST') {
      header('location: cart.php');
      exit;
}
?>
<!doctype html>
<html>
<head>
      <?php require 'head.php'; ?>
      <style>
            html, body { 
                  width: 100%;
                  height: 100%;
                  background: #FCFCFC;
            }

            #main-form {
                  min-width: 400px;

            }
            .text-h{
                  color: #D91E41;
                  font-family: roboto;
                  font-weight: bold;
            }
            .text-d{
                  color: #F18095;
                  font-family: roboto;
                  font-weight: bold;
            }
            .box-buttonr{
                  border-radius: 20px;
                  border:  #000;
                  background-color: #D91E41;
            }
            .box-buttonr:hover{
                  background-color: #F18095;
            }
            .box-buttonl{
                  border-radius: 20px;
                  border:  #000;
                  background-color: #592121;
            }
            .box-buttonl:hover{
                  background-color: #966B6B;
            }
      </style>
      <script>
      $(function() {
             $('button.placeorder').click(function() {
                   if (confirm('ยินยันการสั่งซื้อสินค้า?')) {
                         $('#main-form').submit();
                   }
             })
      });     
      </script>
</head>
<body class="d-flex pt-5 px-3">  
    
<form method="post" id="main-form" action="place-order.php" class="m-auto">
<h6 class="text-center text-h" style="font-size: 1.5rem">Mix Yummy</h6>
<hr>
<h6 class="mb-5 text-center text-d">วิธีชำระเงินและที่อยู่ในการจัดส่งสินค้า</h6>

<span class="mt-4 mb-2 d-block text-h">วิธีการชำระเงิน</span>
<div class="custom-control custom-radio">
      <input type="radio" class="custom-control-input" 
            id="radio1" name="payment" value="cod" checked>
      <label class="custom-control-label" for="radio1">ชำระเงินปลายทาง</label>
</div>
<div class="custom-control custom-radio">
      <input type="radio" class="custom-control-input" 
            id="radio2" name="payment" value="bank_transfer">
      <label class="custom-control-label" for="radio2">โอนผ่านธนาคาร/ATM</label>
</div>
<?php
//อ่านข้อมูลส่วนตัวของลูกค้า ซึ่งกำหนดไว้ตอนสมัครสมาชิก  
//มาแสดงบนฟอร์ม เผื่อกรณีที่ต้องการเปลี่ยนแปลงที่อยู่ในการจัดส่ง
$mid = $_SESSION['member_id'];
$mysqli = new mysqli('localhost', 'root', '', 'mix yummy');
$sql = "SELECT * FROM member WHERE id = $mid";
$result = $mysqli->query($sql);
$m = $result->fetch_object();
?>
<span class="mt-4 mb-3 d-block text-h">ที่อยู่ในการจัดส่งสินค้า (อาจใช้ข้อมูลเดิม หรือแก้ไขใหม่)</span>
<div class="input-group input-group-sm mb-2">
    <input type="text" name="firstname" placeholder="ชื่อ" class="form-control w-auto" value="<?= $m->firstname ?>" required>
      <input type="text" name="lastname" placeholder="นามสกุล" class="form-control w-auto" value="<?= $m->lastname ?>" required>
</div>
<textarea name="address" rows="3" class="form-control form-control-sm mb-2" placeholder="ที่อยู่" required><?= $m->address ?></textarea>
<input type="text" name="phone" placeholder="โทร"  class="form-control form-control-sm" value="<?= $m->phone ?>" required>

<div class="text-center mt-4">
      <a href="index.php" class="btn btn-danger btn-sm px-4 mr-5 box-buttonl">ยกเลิก</a>
      <button type="button" class="placeorder btn btn-primary btn-sm px-4 box-buttonr">สั่งซื้อสินค้า</button>
</div>
<br><br><br><br>
</form>
    
</body>
</html>
