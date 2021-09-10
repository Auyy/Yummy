<?php @session_start(); ?>
<!DOCTYPE html>
<html>
<head>
      <?php require 'head.php'; ?>
      <style>
            div#main-container {
                max-width: 1000px;
            }
            div.card {
                  min-width: 130px;
                  max-width: 150px;
            }       
            div.card img {
                  max-width: 100px;
                  max-height: 100px;
            }           
            div.card * {
                  font-size: 0.9rem;
            }          
            hr {
                  width: 93%;
                  background: #eee;
                  margin-top: 30px;
            }
            .text-h{
                  text-align: center;
                  color: #D91E41;
                  font-weight: bold;
            }
            .text-n{
                  color: #D91E41;
                  font-weight: bold;
            }
            .box-buttonn{
                  border-radius: 15px;
                  border: #F18095;
                  background-color: #F18095;
            }
            .box-buttonn:hover{
                  background-color: #D91E41;
            }
            .box-img{
                  width: 100px;
                  height: 100px;
            }
      </style>
      <script>
      $(function() {

      });
      </script>
</head>
<body class="px-3 pt-5">
<?php require 'navbar.php'; ?> 
    
<br><br>
<!-- หัวข้อ -->
<div class="text-h"><a>รายการสินค้า</a></div> 

<div id="main-container" class="mx-auto">
<div class="card-deck mx-4 mt-5 justify-content-center">

<?php
require 'lib/pagination-v2.class.php';
$page = new PaginationV2();

$mysqli = new mysqli('localhost', 'root', '', 'mix yummy');
$sql = 'SELECT * FROM product';
$result = $page->query($mysqli, $sql, 10);

while ($p = $result->fetch_object()) {
      $n = $p->name;
      if (strlen($n) > 20) {
            $n = mb_substr($n, 0, 20) . '...';
      }
      $images = explode(',', $p->img_files);
      $src = "product-images/$p->id/{$images[0]}";
      $prc = number_format($p->price);
     
      echo 
      '<div class="card border border-info pt-2 shadow mb-3">';
      echo "<img class=\"card-img-top d-block mt-1 mx-auto box-img\" src=\"$src\">";
      echo '<div class="card-body d-flex flex-column justify-content-between">';
      echo    "<h6 class=\"card-title text-n\">" .$n. "</h6>";
      echo          '<div class="d-flex justify-content-between mt-2">';
      echo                "<span class=\"mt-2\">฿" .$prc. "</span>";
      echo                "<a class=\"btn btn-info btn-sm p-1 box-buttonn\" href=\"product-detail.php?id=$p->id\">";
      echo                      '<i class="fas fa-shopping-cart"></i></a>';
      echo          '</div>';
      echo      '</div>';
      echo '</div>';  
}

$mysqli->close();
?>
</div>  <!-- card -->
<br>

<?php 
 if ($page->total_pages() > 1) {
      $page->echo_pagenums_bootstrap(); 
 }

include 'recently-viewed.php';
?>

</div>  <!-- main-container -->
<br><br><br><br>
<?php require 'footer.php'; ?>     
</body>
</html>
