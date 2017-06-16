<?php
session_start();
include '../config.php';
include '../dbConfig.php';
include '../common.php';

$login_user = (isset($_SESSION['login_user']) && $_SESSION['login_user']) ? $_SESSION['login_user'] : NULL; // 세션변수가 없을 땐 null로 명시

$id = $_GET ['id'];
if (!isset($_GET['page'])) {
	$page = 1;
} else {
    $page = $_GET ['page'];
}

$sql_select_one = "SELECT * FROM board WHERE brd_id = '" . $id . "'";
$result_one = mysqli_query ( $conn, $sql_select_one );
$row = mysqli_fetch_assoc ( $result_one );
// 글 작성자와 세션 사용자를 비교하기 위한 변수
$writer = $row['brd_writer'];

// 조회수 증가
$sql_update_check = "UPDATE board SET brd_check = brd_check + 1 WHERE brd_id = '". $id ."'"; // TODO 새로고침이나 같은 사용자로 인해 조회수가 중복 증가되는것 방지 필요
mysqli_query($conn, $sql_update_check);
?>

<body>
	<div class="box">
	<table>
		<tr>
			<td colspan="5"><strong><?= $row['brd_title']?></strong></td>
		</tr>
		<tr>
			<td>이름: <?= $row['brd_writer']?></td>
		</tr>
		<tr>
			<td>등록일: <?= $row['brd_created_datetime']?></td>
		</tr>
		<tr>
			<td>조회수: <?= $row['brd_check']?> / 추천수: <?= $row['brd_like']?></td>
		</tr>
		<tr>
			<td align="right">
				<?php
// 				수정하기와 삭제하기 버튼은 세션 사용자와 글 작성자를 비교하여 노출
				if ($login_user == $writer) { // TODO 로그인 하지 않고 글을 볼 땐 어떻게 해야하지? -> 해결(3번째 줄)
				?>
				<a href="<?=$domainName?>prjcandle/view/write.php?id=<?= $id ?>&mode=modify">수정하기</a>
				<a href="<?=$domainName?>prjcandle/board/delete.php?id=<?= $id ?>">삭제하기</a>
				<?php
				}
				?>
			</td>
		</tr>
		<tr>
			<td colspan="5"><?= $row['brd_content']?></td>
		</tr>
	</table>
	<div>
		<?php
		if (! isset ( $_SESSION ['login_user'] )) {
		?>
		<!-- 로그인 전 -->
			<a href='<?=$domainName?>prjCandle/view/login.php'>로그인</a>
		<?php
		}
		?>
		<a href="<?=$domainName?>prjcandle/view/list.php?page=<?= $page ?>">목록보기</a>
		<a href="<?=$domainName?>prjcandle/view/write.php?mode=write">글쓰기</a>
	</div>
	<hr>
<!-- 	댓글 쓰기 시작(로그인 해서만 가능) -->
	<?php 
	if ($login_user) {
		include_once './comment.php';
	}
	?>
<!-- 	댓글 쓰기 끝 -->
	
<!-- 	이전글 다음글 보기 -->
	<?php
	// 이전글 보기 버튼
	// 이전글은 현재 글 이전에 작성된 글
	// 현재 글의 id보다 작은 값들 중 가장 큰 값을 가져오기 위한 query
	$sql_select_prev = "SELECT brd_id FROM board WHERE brd_id < $id ORDER BY brd_id DESC LIMIT 1";
	# order by desc를 하지 않으면 오름차순으로 되기 때문에 현재 id보다 작은 값 중 가장 작은 값을 가져온다
	$result_prev = mysqli_query($conn, $sql_select_prev);
	$prev_id = mysqli_fetch_row($result_prev);
	if ($prev_id[0]) //이전 글이 있을 경우
	{
		echo "<a href='$domainName"."prjcandle/board/read.php?page=$page&id=$prev_id[0]'>▽이전글</a>&nbsp;&nbsp;";
	}

	// 다음글 보기 버튼
	$sql_select_next = "SELECT brd_id FROM board WHERE brd_id > $id LIMIT 1";
	$result_next = mysqli_query($conn, $sql_select_next);
	$next_id = mysqli_fetch_row($result_next);
	if ($next_id[0]) //다음 글이 있을 경우
	{
		echo "<a href='$domainName"."prjcandle/board/read.php?page=$page&id=$next_id[0]'>△다음글</a>";
	}
	?>
</div>
<script>
var _user = '0';

function trimSpace (str) {
    return str ? str.replace(/^[\s\ufeff\u200b\xa0\u3000]+|[\s\ufeff\u200b\xa0\u3000]+$/g, '') : '';
}

//WEB-2044 코멘트 입력
var commentInit = 1;
function CommentInitform(memoForm){
	if(!checkLogin())
		return;

	if(commentInit == 1){
		commentInit = -1;
		memoForm.value = "";
	}
}

var checkLoginCount = 0;
function checkLogin()
{
	if(checkLoginCount > 0)
		return true;

	if(_user == '0') {
		checkLoginCount++;
		alert('로그인 이후에 이용 가능 합니다.');
		var s_url = 'zboard%2Fview.php%3Fid%3Dfreeboard%26page%3D2%26divpage%3D997%26no%3D5343473';
		location.href=G_HOME_SSL_URL +"/zboard/login.php?s_url=" + s_url;
		return false;
	}

	return true;
}

$(document).ready(function() {
    var imageResizeWidth = 550;

    if(typeof FileReader == "undefined") {
       $("label[id='upload-button']").hide();
       $("tr[id='comment-upload-preview']").hide();
    }

    $("label[id='upload-button']").live('click', function(e) {

    	if(!checkLogin())
        	return false;

	    if(typeof FileReader == "undefined") {
            alert('IE9 이하버전은 지원하지 않습니다.');
            return false;
	    } else {
            $("input[id='image-upload']").trigger('click');
            e.preventDefault();
	    }
    });

    $('#image-upload').live('change', function(e) {
        if(typeof FileReader == "undefined") return true;

        var elem = $(this);
	    var files = e.target.files;

	    if (files.length > 0) $('.upload-path').html(files[0].name);

	    for (var i = 0, f; f = files[i]; i++) {
	        if (f.type.match('image.*')) {
                if (f.size > 10 * 1024 * 1024) {
                    alert('원본 이미지 용량은 10MB를 넘을 수 없습니다.');
                    return false;
                }

	            var reader = new FileReader();

	            reader.onload = function(readerEvent) {
	                var origImage = new Image();

	                origImage.onload = function(imageEvent) {
        	            var canvas = document.createElement("canvas");
        	            var width = origImage.width;
        	            var height = origImage.height;

        	            var xhr = new XMLHttpRequest();
        	            xhr.open('POST', '/zboard/comment_file_upload.php', true);

        	            var data = new FormData();
                        data.append('origname', readerEvent.target.filename);

        	            if (origImage.width > imageResizeWidth) {
        	                width = imageResizeWidth;
        	                height = (imageResizeWidth / origImage.width) * origImage.height;

        	                canvas.width = width;
        	                canvas.height = height;
        	                canvas.getContext("2d").drawImage(origImage, 0, 0, width, height);

        	                var bitmapData = canvas.toDataURL(readerEvent.target.filetype);
        	                data.append('filehtml5', bitmapData.replace(/^(.*)base64,/, ''));
        	            } else {
        	                data.append('file', readerEvent.target.file);
        	            }

        	            xhr.onreadystatechange = function(xhrEvent) {
        	                if (this.readyState === 4 && this.status === 200) {
        	                    var jsonText = decodeURI(trimSpace(this.responseText));
        	                    jsonText = jsonText.replace(/\+/g, ' ').replace(/\\/g, '\\\\');
        	                    var jsonData = JSON.parse(jsonText);

        	                    $('.upload-path').css('display', 'inline-block');

                                $("input[id='comment_uploaded_file']").val(jsonData.fileName);

        	                    previewDiv = $('.file-preview');
        	                    bg_width = previewDiv.width() * 2;
        	                    previewDiv.show();
        	                    previewDiv.css({
        	                        "background-size":bg_width + "px, auto",
        	                        "background-position":"50%, 50%",
        	                        "background-image":"url("+jsonData.fileUrl+")"
        	                    });
        	                }
        	            };

        	            xhr.send(data);
	                };

	                origImage.src = readerEvent.target.result;
	            };

	            reader.file = f;
                reader.filename = f.name;
                reader.filetype = f.type;
                reader.readAsDataURL(f);
	        } else {
                alert('gif, png, jpg 사진 파일만 올릴 수 있습니다.');
	        }
	    }
    });

    $('.file-preview .btn-remove').live('click', function() {
	    $("input[id='image-upload']").val('');
	    $("input[id='comment_uploaded_file']").val('');
        $('.file-preview').css('background-image', 'none').hide();
        $('.upload-path').hide();
    });
});
</script>
<?php
include '../footer.php';
?>
</body>
</html>
