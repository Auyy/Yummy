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
<!DOCTYPE html>
<html>
<head>
      <?php require 'head.php'; ?>
      <style>
            html, body {
                  width:100%;
                  height: 100%;
            }

            #main-container {
                  max-width: 450px;
            }
            img.product {
                max-width: 64px;
                max-height: 64px;
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

            .box-button{
                  border-radius: 20px;
                  border:  #000;
                  background-color: #F18095;
            }
            .box-button:hover{
                  background-color: #D91E41;
            }
            
            div.row {
                  border-bottom: solid 1px darkgray;
            }
            
            input[type="number"] {
                  max-width: 50px;
            }
      </style>
      <script>
      $(function() {

      });
      </script>
</head>
<body class="d-flex pt-5">
    
<div id = "main-container" class="mt-5 m-auto p-3">
<h6 class="text-center text-h" style="font-size: 1.5rem">Mix Yummy</h6>
<hr>
<?php      
$mid = $_SESSION['member_id'];
//นำข้อมูลจากฟอร์มที่ถูกส่งเข้ามา และข้อมูลอีกบางส่วนที่กำหนดค่าไว้ล่วงหน้า
//จัดเก็บลงในตาราง orders
$mysqli = new mysqli('localhost', 'root', '', 'mix yummy');
$sql = 'INSERT INTO orders VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
$stmt = $mysqli->stmt_init();
$stmt->prepare($sql);
$now = strtotime('now');
$d = date('Y-m-d', $now);     //วันที่สั่งซื้อ (ปัจจุบัน)
$p = [0, $mid, $_POST['firstname'], $_POST['lastname'], $_POST['address'], 
        $_POST['phone'], $_POST['payment'], 'pending', $d, '', '', '', 'no'];

$stmt->bind_param('iisssssssssss', ...$p);
$stmt->execute();
 //อ่านรหัสการสังซื้อ เพื่อนำไปเก็บลงในตาราง orders_item
$order_id = $stmt->insert_id;     
$stmt->close();

//อ่านข้อมูลจากตาราง cart ที่ลูกค้ารายนั้นหยิบใส่รถเข็น
$sql = "SELECT * FROM cart
            WHERE member_id = $mid";

$result = $mysqli->query($sql);
//เก็บข้อมูลสินค้าแต่ละรายการลงในตาราง orders_item
while ($cart = $result->fetch_object()) {
      $pid = $cart->product_id;
      $q = $cart->quantity;
      $sql = "INSERT INTO orders_item VALUES 
                  (0, $order_id, $pid, $q)";

      $mysqli->query($sql);
}
//ลบรายการสินค้าที่ลูกค้ารายนั้นหยิบใส่รถเข็นออกจากตาราง cart
$sql = "DELETE FROM cart WHERE member_id = $mid";
$mysqli->query($sql);
$mysqli->close();       
?>

<h6 class="text-center my-4 text-d">การสั่งซื้อเสร็จเรียบร้อย</h6>
<p class="">
     การสั่งซื้อสำเร็จ ได้ทำการส่งรายการสินค้าให้กับผู้ขายเรียบร้อย
</p>
<div class="mt-4 mb-3 text-center">ขอขอบพระคุณที่สั่งซื้อสินค้าจากเรา</div>
<div class="text-center mt-4">
      <a href="index.php" class="btn btn-primary btn-sm px-4 box-button">กลับไป Shopping ต่อ</a>
</div>

<br><br><br><br>
</div>  <!-- main-container -->
    
</body>
</html>
