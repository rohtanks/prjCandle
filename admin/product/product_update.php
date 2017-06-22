<?php
include '../common.php';
include '../dbConfig.php';

$no= $_GET['no'];
$code= $_POST['code'];
$name= $_POST['name'];
$price= $_POST['price'];
$image1= $_POST['image1'];
$image2= $_POST['image2'];
$image3= $_POST['image3'];
$checkno1= $_POST['checkno1'];
$checkno2= $_POST['checkno2'];
$checkno3= $_POST['checkno3'];

echo "$no";
echo "$image1";


//$query = "UPDATE product SET productname='$name', productprice=$price, productno=$code, productimage1='$image1', productimage2='$image2', productimage3='$image3' where productno=$no";
$result= mysqli_query ( $conn, $query );
mysqli_close($conn);
 ?>
<body>
  <script type="text/javascript">
  //location.replace("http://localhost/prjCandle/admin/product/product.php");
  </script>
</body>
</html>
