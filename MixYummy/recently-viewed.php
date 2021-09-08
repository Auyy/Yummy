<?php
@session_start();
if (isset($_SESSION['recently_viewed'])) {
      echo '
      <hr>
      <div class="mt-4 mb-4 text-center">
            <h6 class="text-secondary">สินค้าที่ดูล่าสุด</h6>
            <div class="d-flex mt-3 justify-content-center">
      ';

      $i = 1;
      foreach ($_SESSION['recently_viewed'] as $rv) {
            echo "
            <div class=\"d-flex flex-column justify-content-between border p-2 mr-2 text-center\" style=\"max-width:100px;\">" .$rv. "</div>"
            ; 

            if ($i == 20) {
                  break;
            }
            $i++;
      }

      echo '
            </div>
      </div>
      ';
}
?>