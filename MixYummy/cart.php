<?php
@session_start();
if (!isset($_SESSION['member_id'])) {
      header('location: member-signin.php');
      exit;
}
?>
<!DOCTYPE html>
<html>
<head>
      <?php require 'head.php'; ?>
      <style>
            div.main-container {
                  max-width: 600px;
                  min-width: 450px;
            }
            
            img.product {
                  max-width: 64px;
                  max-height: 64px;
            } 
            
            div.row {
                  border-bottom: solid 1px lightgray;
            }
            
            input[type="number"] {
                  max-width: 50px;
            }
            .text-h{
                  text-align: center;
                  color: #D91E41;
                  font-weight: bold;
            }
            .box-buttona{
                  border-radius: 15px;
                  border: #F18095;
                  background-color: #F18095;
            }
            .box-buttona:hover{
                  background-color: #D91E41;
            }
            .box-buttonl{
                  border-radius: 15px;
                  border: #F18095;
                  background-color: #966B6B;
            }
            .box-buttonl:hover{
                  background-color: #592121;
            }
      </style>
      <script>
      $(function() {
            $('a.delete').click(function() {
                  if (confirm('ยืนยันการลบสินค้ารายการนี้ออกจากรถเข็น')) {
                        var del_id = $(this).attr('data-id');
                        $('#delete-id').val(del_id);
                        $('#form-delete').submit();
                  }
            });
            
            //เมื่อคลิกที่ปุ่ม "สั่งซื้อสินค้า"
            $('a.checkout').click(function() {
                  $('#form-checkout').submit();
           });
      });
     </script>
</head>
<body class="px-3 pt-5">
<?php require 'navbar.php'; ?> 
    
<div class="main-container mx-auto pt-4">
<form method="post" id="form-cart">   
<?php      
$mid = $_SESSION['member_id'];
$mysqli = new mysqli('localhost', 'root', '', 'mix yummy');
//ถ้าส่งค่า id สำหรับการลบขึ้นมา ก็นำไปกำหนดเงื่อนไขเพื่อลบข้อมูลออกจากตาราง cart
if (isset($_POST['delete_id'])) {
      $pid = $_POST['delete_id'];
      $sql = "DELETE FROM cart WHERE member_id = $mid AND product_id = $pid";
      $mysqli->query($sql);
}
//ถ้าส่งจำนวนขึ้นมา เราต้องนำค่าทั้งหมดจากฟอร์ม ไปอัปเดตทุกรายการ
if (isset($_POST['qty'])) {
      $count = count($_POST['qty']);
      for ($i = 0; $i < $count; $i++) {
            $qty = $_POST['qty'][$i];
            $pid = $_POST['pid'][$i];
            $sql = "UPDATE cart SET quantity = $qty
                        WHERE member_id = $mid AND product_id = $pid";

            $mysqli->query($sql);
      }
}

//อ่านข้อมูลจากตาราง cart + product มาแสดง
$sql =<<<SQL
      SELECT p.*,  c.quantity 
      FROM product p 
      LEFT JOIN  cart c
      ON p.id = c.product_id
      WHERE c.member_id = $mid
SQL;

$result = $mysqli->query($sql);
if ($mysqli->error || $result->num_rows == 0) {
      echo '<h6 class="text-center text-danger text-h">ไม่มีสินค้าในรถเข็น</h6>';
      $mysqli->close();
      include 'footer.php';
      exit ('</form></div></body></html>');
}

echo '<h6 class="mb-4 text-center text-h">รายการสินค้าในรถเข็น</h6>';
echo '<div class="container">';

$grand_total = 0;
$dvr_cost = 0;
while ($p = $result->fetch_object()) {
      $n = mb_substr($p->name, 0, 20);    //เอา 20 ตัวแรกของชื่อสินค้า
      
      $img_files = explode(',', $p->img_files);       //แยกชื่อภาพออกจากกัน
      $src = "product-images/$p->id/{$img_files[0]}";
      
      $price = number_format($p->price);
      $subtotal = $p->price * $p->quantity;     //ผลรวมย่อยของแต่ละรายการ
      $st = number_format($subtotal);
      $grand_total += $subtotal;                      //ผลรวมสะสมของทุกรายการ
      $dvr_cost += $p->delivery_cost * $p->quantity;  //ค่าจัดส่งสะสมทุกรายการ
      
      echo '<div class="row py-2">';
      echo     "<div class=\"col-2 text-right \"><img src=\"$src\" class=\"product\"></div>";
      echo      '<div class="col-10">';
      echo           "<h6><a class=\"text-h\" href=\"product-detail.php?id=$p->id\" target=\"_blank\">".$n."</a></h6>";
      echo          '<div class="d-flex justify-content-between align-items-center ">';
      echo                '<div class="small">';
      echo                      'ราคา:' .$price.'<br>';
      echo                       "จำนวน: <input type=\"number\" name=\"qty[]\" class=\"\" size=\"3\" maxlength=\"3\" min=\"1\" max=\"$p->remain\" value=\"$p->quantity\">";
      echo                      "<input type=\"hidden\" name=\"pid[]\" value=\"$p->id\">";
      echo                        '<div>';
      echo                           "<a href=# class=\"delete\" data-id=\"$p->id\">";
      echo                                  '<i class="fas fa-trash text-h"></i>';
      echo                             '</a>';
      echo                      '</div>';
      echo                '</div>';
      echo               "<div class=\"\">".$st."</div>";
      echo          '</div>';     // <!-- d-flex --> 
      echo     '</div>  ';        //<!-- col-10 -->
      echo '</div>';                // <!-- row -->
}

$f_dvr_cost = number_format($dvr_cost);

$grand_total += $dvr_cost;
$gt = number_format($grand_total);

echo '<div class="row py-3">';
echo     '<div class="col-7 col-md-9 text-center">ค่าจัดส่งรวม</div>';
echo      "<div class=\"col-5 col-md-3 text-right\">".$f_dvr_cost."</div>";
echo"</div>";
echo'<div class="row py-3">';
echo     '<div class="col-7 col-md-9 text-center">รวมทั้งสิ้น</div>';
echo     "<div class=\"col-5 col-md-3 text-right\">".$gt."</div>";
echo'</div>';
echo'<div class="row py-3">';
echo     '<div class="col-7 col-md-9 text-center">ถ้าเปลี่ยนแปลงจำนวนสินค้า ให้คลิกปุ่ม <b>คำนวณใหม่</b> เพื่อบันทึกการเปลี่ยนแปลง</div>';
echo      '<div class="col-5 col-md-3 text-right">';
echo          '<button type="submit" class="btn btn-primary btn-sm box-buttonl">คำนวณใหม่</button>';
echo      '</div>';
echo'</div>';

echo '</div>';          //end grid container

$mysqli->close();
?>
    
<div class="text-center mt-4">
      <a href="index.php" class="btn btn-sm btn-info mr-2 mr-md-5 px-md-5 box-buttonl">&laquo; เลือกสินค้าเพิ่มเติม</a>
      <a href="#" class="checkout btn btn-sm btn-success px-md-5 box-buttona">สั่งซื้อสินค้า &raquo;</a>
</div>

<br><br><br><br>
</form>        
</div> <!-- main container -->

<form id="form-delete" method="post">
      <input type="hidden" name="delete_id" id="delete-id" value="">
</form>

<form id="form-checkout" action="checkout.php" method="post"></form>

<?php include 'footer.php';  ?>
</body>
</html>
