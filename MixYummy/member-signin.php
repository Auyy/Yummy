<?php @session_start(); ?>
<!DOCTYPE html>
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
                  min-width: 270px;
                  max-width: 350px;
            }
            .login{
                  color: #D91E41;
                  font-family: roboto;
                  font-weight: bold;
            }
            .box-log{
                  border: none;
                  border-bottom: solid 1px;
                  border-radius: 0;
            }
            .box-button{
                  border-radius: 20px;
                  background-color: #592121;
            }
            .box-button:hover{
                  background-color: #D91E41;
            }
            .box-big{
                  width: 320px;
                  height: 300px;
                  background-color: #fff;
                  border-radius: 15px;
                  border: solid 3px #D91E41;
            }
            .box-small{
                  width: 250px;
                  height: 200px;
                  background-color: #fff;
                  margin: auto;
                  margin-top: 8%;
            }
      </style>
</head>
<body class="d-flex pt-5">
<?php require 'navbar.php'; ?> 
    
<form id="main-form" method="post" class="m-auto pt-4">
<?php      
if (isset($_SESSION['member_id'])) {
      
      // echo '
      // <h6 class="mb-4 text-center text-info">สำหรับสมาชิก</h6>
      // <a href="cart.php" class="btn bt-sm btn-info d-block w-75 mb-2 mx-auto">ตรวจสอบรถเข็นและสั่งซื้อ</a>
      // <a href="member-order-list.php" class="btn bt-sm btn-secondary d-block w-75 mb-2 mx-auto">ประวัติการสั่งซื้อและแจ้งชำระเงิน</a>
      // <a href="#" class="btn bt-sm btn-success d-block w-75 mb-2 mx-auto">รายการที่ชอบ</a><br>
      // <a href="#" class="btn bt-sm btn-secondary d-block w-75 mb-2 mx-auto">แก้ไขข้อมูลสมาชิก</a>
      // <a href="member-signout.php" class="btn bt-sm btn-danger d-block w-75 mb-2 mx-auto">ออกจากระบบ</a>
      // ';

      echo '<h6 class="mb-4 text-center text-info">เข้าสู่ระบบสำเสร็จ</h6>';
      echo '<a href="member-signout.php" class="btn bt-sm btn-danger d-block w-75 mb-2 mx-auto">ออกจากระบบ</a>';

      // include 'recently-viewed.php';
      echo '<br><br><br><br>';
      include 'footer.php';
      exit ('</form></body></html>');
}
//ถ้าเป็นการโพสต์ข้อมูลกลับขึ้นมา
if ($_SERVER['REQUEST_METHOD'] == 'POST') {           
      $email = $_POST['email'];
      $password = $_POST['password'];

      $mysqli = new mysqli('localhost', 'root', '', 'mix yummy');
      $sql = 'SELECT * FROM member 
                   WHERE email = ? AND password = ?';

      $stmt = $mysqli->stmt_init();
      $stmt->prepare($sql);
      $stmt->bind_param('ss', $email, $password);
      $stmt->execute();
      $result = $stmt->get_result();      
      $num_rows = $result->num_rows;
      if ($num_rows == 1) {
            $data = $result->fetch_object();
            $_SESSION['member_id'] = $data->id;
            $_SESSION['member_name'] = $data->firstname;
            $mysqli->close();
            echo "<script>location='index.php'</script>";
            exit();
      } else if ($num_rows == 0) {
             echo '
            <div class="alert alert-danger mb-4" role="alert">
                  อีเมลหรือรหัสผ่านไม่ถูกต้อง
                  <button class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            </div>     
            '; 
      }           
}
?>
<div class="box-big">
<div class="box-small">
<h6 class="mb-3 login">เข้าสู่ระบบ</h6>
<input type="email" name="email" placeholder="Email" class="form-control form-control-sm mb-3 box-log" required>
<input type="password" name="password" placeholder="Password"  class="form-control form-control-sm mb-4 box-log" required>   
<button type="submit" class="btn btn-sm btn-primary d-block mx-auto mb-4 w-50 box-button">เข้าสู่ระบบ</button>
<a href="member-signup.php" class="btn btn-sm d-block mx-auto w-50">สมัครสมาชิก</a>
</div>
</div>
</form>
    
<?php require 'footer.php'; ?> 
</body>
</html>