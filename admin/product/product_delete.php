<?php
error_reporting(0);
$no= $_GET['no'];

include '../common.php';
include '../dbConfig.php';

$query = "DELETE FROM product WHERE productno=$no";
$result= mysqli_query ( $conn, $query );
mysqli_close($conn);
 ?>
<body>
  <script type="text/javascript">
  location.replace("http://localhost/prjCandle/admin/product/product.php");
  </script>
</body>
</html>
