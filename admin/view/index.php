<?php
//게시판의 기본화면. 검색기능을 포함한 목록 출력화면 index.php
//환경설정파일 (db 접속정보 외) 인클루드
include('./config.php');

//검색창에서 POST 입력받을 정보
$P_page = $_POST['P_page'];
$P_start_date = $_POST['start_date'];
$P_end_date = $_POST['end_date'];
$P_post_author = $_POST['post_author'];
$P_post_title = $_POST['post_title'];
$P_post_content = $_POST['post_content'];
$P_sort_column = $_POST['sort_column'];
$P_sort_type = $_POST['sort_type'];

//지정된 값이 없으면 일자 및 검색칼럼의 설정
if(!$P_start_date){$P_start_date = date('Y-m-d', strtotime('-1 year', time()));}
if(!$P_end_date){$P_end_date = date('Y-m-d');}
if(!$P_sort_column){$P_sort_column = 'no'; $P_sort_type = 'desc';}

//게시판 페이징을 위한 코드, row_num 구하기 위한 쿼리
$q1 = "select no from board where post_date between ? and ?
		and post_author like ? and post_title like ? and post_content like ?";


$stmt1=$mysqli->prepare($q1);
$p11 = '%'.$P_post_author.'%';$p12 = '%'.$P_post_title.'%';$p13 = '%'.$P_post_content.'%'; //like 구문에 % 붙이기 위함
$stmt1->bind_param('sssss',$P_start_date,$P_end_date,$p11,$p12,$p13);
$stmt1->execute();
$stmt1->store_result();
$total = $stmt1->num_rows;
$stmt1->close();

//$P_page에 값이 없으면 1페이지로 설정
if(!$P_page){ $P_page = 1; }
//한 페이지에 출력될 행 수, 현재 페이지, 전체페이지 수 구하기
$page_row = 10;
$current_page = intval($P_page);
$total_page = ceil($total/$page_row);
//쿼리 limit 절 시작하는 행 start_row 구하기
if($current_page == 1){ $start_row = 0; }else{ $start_row = ($current_page * $page_row) - $page_row; }
//쿼리 limit 절 끝나는 행 end_row 구하기
$limit = $start_row + $page_row;
if ($limit >= $total){ $limit = $total;	}
if($P_page == 1){ $end_row = $page_row;	}else{ $end_row = $limit - $start_row; }

//검색조건에 따라 게시글 쿼리
$q2 = "select * from board where post_date between ? and ?
and post_author like ? and post_title like ? and post_content like ?


order by `$P_sort_column` $P_sort_type limit ?, ?";


$stmt2 = $mysqli->prepare($q2);
$p21 = '%'.$P_post_author.'%';$p22 = '%'.$P_post_title.'%';$p23 = '%'.$P_post_content.'%'; //like 구문에 % 붙이기 위함
$stmt2->bind_param('sssssii',$P_start_date,$P_end_date,$p21,$p22,$p23,$start_row,$end_row);
$stmt2->execute();
$stmt2->bind_result($no,$post_date,$post_time,$post_author,$post_title,$post_content);
?>
 
<html>
<head>
	<?php include('./header.php'); ?>
</head>
 
<body class="admin-list">
<div class="container-fluid">
	<div class="row">
		<div class="col-xs-12 top">
			<!--게시판 최상단 반복되는 top.php 인클루드-->
			<?php include('./top.php'); ?>
		</div>
	</div>
 
	<div class="row search-setting">
    <div class="col-sm-12">
		<!-- 검색 폼 -->
  		<form name='sch_frm' class="form-horizontal center-blockyyy" method="post" action="./index.php" >
    	<div class="row">
			<div class="col-sm-12">
            <input class="form-control input-sm" type="date" name="start_date" value="<?=$P_start_date;?>">
            <input class="form-control input-sm" type="date" name="end_date" value="<?=$P_end_date;?>">
            <input class="form-control input-sm" type="text" name="post_author" placeholder="작성자" value="<?=$P_post_author;?>">
            <input class="form-control input-sm wide" type="text" name="post_title" placeholder="제목" value="<?=$P_post_title;?>">
            <input class="form-control input-sm wide" type="text" name="post_content" placeholder="내용" value="<?=$P_post_content;?>">
			<select class="form-control input-sm" name="sort_column">
				<option value="no" <?php if($P_sort_column == 'no'){ echo 'selected="selected"'; }?>>작성순</option>
				<option value="post_author" <?php if($P_sort_column == 'post_author'){ echo 'selected="selected"'; }?>>작성자</option>
				<option value="post_title" <?php if($P_sort_column == 'post_title'){ echo 'selected="selected"'; }?>>제목</option>
			</select>			
			<label><input type="radio" name="sort_type" value="asc" <?php if($P_sort_type == 'asc'){ echo 'checked'; }?>>오름</label>
			<label><input type="radio" name="sort_type" value="desc" <?php if($P_sort_type == 'desc'){ echo 'checked'; }?>>내림</label>
            <button type="submit" id="submit" class="btn btn-sm btn-info">검색</button>
			</div>
        </div>
  		</form>
 
	<div class="row">
		<div class="col-md-12 paging">
		<!-- 페이징 폼, 페이징에서는 검색폼의 칼럼을 숨은 값으로 정의하여 값을 유지 -->
        <form name='page' method="post" action="./index.php">
			<div class="comp">
				<span class="glyphicon glyphicon-step-backward" id="pagePrv" style="cursor:pointer;"></span>
				<span><input class="form-control input-sm input-number" type="number" min="1" name="P_page" value="<?=$P_page;?>"></span>
				<span class="glyphicon glyphicon-step-forward" id="pageNext" style="cursor:pointer;"></span>
				<span class="text"><?=$current_page;?> / <?=$total_page;?> 페이지</span>
			</div>
      			
			<input type="hidden" name="start_date" value="<?=$P_start_date;?>">
			<input type="hidden" name="end_date" value="<?=$P_end_date;?>">
			<input type="hidden" name="post_author" value="<?=$P_post_author;?>">
			<input type="hidden" name="post_title" value="<?=$P_post_title;?>">
			<input type="hidden" name="post_content" value="<?=$P_post_content;?>">
			<input type="hidden" name="sort_column" value="<?=$P_sort_column;?>">
			<input type="hidden" name="sort_type" value="<?=$P_sort_type;?>">
			<input type="submit" id="page_submit"  style="visibility: hidden;" />
		</form>
    	</div>
	</div>
 
    </div>
	</div>
 
	<div class="row">
		<div class="col-md-12">
			전체 : <b><?=$total;?></b><br>
			<form name='frm1' action='./modify.php?action=del' method='post'>
  			<table class="table x_table-striped x_table-hover">
    			<thead>
    			<tr>
    				<th width="4%"><input type="checkbox" onClick="chkBox(this.checked)"></th>
					<th>일자</th>
					<th>시간</th>
					<th>작성자</th>
					<th>제목</th>
    			</tr>
    			</thead>
    			<tbody>
    				<?php while($stmt2->fetch()){ ?>
    					<tr>
    					<td><input type='checkbox' name='chk[]' value='<?=$no;?>'></td>
    					<td><?=$post_date;?></td>
    					<td><?=$post_time;?></td>
    					<td><?=$post_author;?></td>
    					<td><a href="./form.php?no=<?=$no;?>"><?=$post_title;?></a></td>
    					</tr>
    				<?php } ?>
    			</tbody>
  			</table>
  			<input type='button' class="btn btn-sm btn-info" value='입력' onclick=(location.href='./form.php')>
			<a class="btn btn-sm btn-danger" href='javascript:document.frm1.submit()'>삭제</a><br>
			</form>
		</div>
	</div>
 
	<div class="row">
		<div class="col-xs-12 footer">
			<!--게시판 최하단 반복되는 bottom.php 인클루드-->
			<?php include('./bottom.php'); ?>
		</div>
	</div>
</div>
 
	<!-- 이 페이지에 필요한 자바스크립트-->
	<script language="javascript" type="text/javascript">
	//게시글 전체선택, 해제
	function chkBox(bool) {
		var obj = document.getElementsByName("chk[]");
		for (var i=0; i<obj.length; i++) obj[i].checked = bool;
	};
	$(document).ready(function(){
		$("#pageNext").click(function(){
			pageVal = parseInt($("input[name='P_page']").val());
			pageVal = pageVal+1;
			//전체 페이지 초과시 1페이지로 이동
			if( pageVal > <?=$total_page;?> ) {
				pageVal = 1;
			}
			$("input[name='P_page']").val(pageVal);
			$('#page_submit').trigger('click');
		});
		$("#pagePrv").click(function(){
			pageVal = parseInt($("input[name='P_page']").val());
			pageVal = pageVal-1;
			//전체 페이지 초과시 1페이지로 이동
			if( pageVal < 1 ) {
				pageVal = <?=$total_page;?>;
			}
			$("input[name='P_page']").val(pageVal);
			$('#page_submit').trigger('click');
		});
	});
	</script>
</body>
<?php $stmt2->close();$mysqli->close(); ?>
</html>
