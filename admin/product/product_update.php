<?php
$no= $_GET['no'];
$code= $_POST['code'];
$name= $_POST['name'];
$price= $_POST['price'];
include '../common.php';
include '../dbConfig.php';

$query = "UPDATE product SET productname='$name', productprice=$price, productno=$code where productno=$no";
$result= mysqli_query ( $conn, $query );
mysqli_close($conn);
 ?>
<body>
  <script type="text/javascript">
  location.replace("http://localhost/prjCandle/admin/product/product.php");
  </script>
</body>
</html>
