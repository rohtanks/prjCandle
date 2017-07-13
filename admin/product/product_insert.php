<?php
$code= $_POST['code'];
$name= $_POST['name'];
$price= $_POST['price'];
$image1= $_POST['image1'];
$image2= $_POST['image2'];
$image3= $_POST['image3'];
include '../common.php';
include '../dbConfig.php';

$query = "INSERT INTO product (productno, productname, productprice, productimage1, productimage2, productimage3) VALUES ($code, '$name', $price, '$image1', '$image2', '$image3')";

$result= mysqli_query ( $conn, $query );
mysqli_close($conn);
 ?>
<body>
  <script type="text/javascript">
  location.replace("http://".$domainName."prjCandle/admin/product/product.php");
  </script>
</body>
</html>
