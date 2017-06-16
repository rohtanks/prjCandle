<?php
if(!isset($_SESSION)){
     session_start();
}
include '../config.php';
include '../common.php';
include '../dbConfig.php';
$pageNum = ($_GET['page']) ? $_GET['page'] : 1;     //page : default - 1
$list = ($_GET['list']) ? $_GET['list'] : 15; //page : default - 15
$limit = ($pageNum - 1) * $list;

$query="SELECT * from product limit $limit, $list";
$sort= $_POST['sort'];
if ($sort == "up"){
  $query="SELECT * from product order by productprice desc limit $limit, $list";
} else if ($sort == "name"){
  $query = "SELECT * from product order by productname limit $limit, $list";
} else if ($sort == "down"){
  $query = "SELECT * from product order by productprice limit $limit, $list";
} else if ($sort == "new"){
  $query = "SELECT * from product order by productno desc limit $limit, $list";
}
$result= mysqli_query ( $conn, $query );
$total_rows = mysqli_num_rows($result);
?>
  		<div class="box" style="padding-left: 600px;">
			<form name="form2" method="post" action="product.php">
			<table border="0" cellpadding="0" cellspacing="5" width="767" class="cmfont" bgcolor="#efefef">
				<tr>
					<td bgcolor="white" align="center">
						<table border="0" cellpadding="0" cellspacing="0" width="751" class="cmfont">
							<tr>
								<td align="center" valign="middle">
									<table border="0" cellpadding="0" cellspacing="0" width="730" height="40" class="cmfont">
										<tr>
											<td width="500" class="cmfont">
												<font color="#C83762" class="cmfont"><b>상품소개 &nbsp</b></font>&nbsp
											</td>
											<td align="right" width="274">
												<table width="100%" border="0" cellpadding="0" cellspacing="0" class="cmfont">
													<tr>
														<td align="right"><font color="EF3F25"><b><?= $total_rows?></b></font> 개의 상품.&nbsp;&nbsp;&nbsp</td>
														<td width="100">
															<select name="sort" size="1" class="cmfont" onChange="form2.submit()">
                                <option value="" selected><a href="product.php?sort=1&page=1">정렬방법선택</a></option>
																<option value="new"><a href="product.php?sort=1&page=1">신상품순 정렬</a></option>
																<option value="up"><a href="product.php?sort=1&page=1">높은가격순 정렬</a></option>
																<option value="down"><a href="product.php?sort=1&page=1">낮은가격순 정렬</a></option>
																<option value="name"><a href="product.php?sort=1&page=1">상품명 정렬</a></option>
                              </select>
                              <script>document.form2.sort.value='<?=$sort?>';</script>
														</td>
													</tr>
												</table>
											</td>
										</tr>
									</table>
								</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
			</form>
      <br>
      <?php
      $num_col=5;
      $num_row=3;
      $icount=0;
      ?>
      	<tr><td height="10"></td></tr>
        		<table border="0" cellpadding="0" cellspacing="0">
              <?php
              for($ir=0;$ir<$num_row;$ir++){
                ?>
				<tr>
          <?php
            for($ic=0; $ic<$num_col; $ic++){
              if($icount < $total_rows){
                $row = mysqli_fetch_array($result);
                ?>
					<td width="150" height="205" align="center" valign="top">
						<table border="0" cellpadding="0" cellspacing="0" width="100" class="cmfont">
							<tr>
								<td align="center">
									<a href="../product/product_detail.php?no=<?=$row['productno']?>"><img src="<?= $row['productimage1']?>" width="120" height="140" border="0"></a>
								</td>
							</tr>
							<tr><td height="5"></td></tr>
							<tr>
								<td height="20" align="center">
									<a href="../product/product_detail.php?no=<?=$row['productno']?>"><font color="444444"><?= $row['productname']?></font></a>&nbsp;
								</td>
							</tr>
							<tr><td height="20" align="center"><b><?= $row['productprice']?>원</b></td></tr>
              	</td>
						</table>
              <?php
            }
          else
          ?>
          <td></td>
          <?php
            $icount++;
          }
          ?>
        </tr>
        <?php
      }
        ?>
      </table>
      <?php
      mysqli_close($conn);
      ?>
    <table border="0" cellpadding="0" cellspacing="0" align="center" width="690">
      <tr>
      <?php
include '../product/product_paging.php';
?>
</tr>
</table>
    </div>
<?php
include '../footer.php';
?>
</body>
</html>
