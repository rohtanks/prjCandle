<?php
class Common {

// 	hidden 값 생성
	public function addHiddenField($str, $arr) {
		$hidden = explode(',', $str); // explode() 문자를 나누는 함수
		if (is_array($hidden)) {
			foreach ($hidden as $key => $val) {
				echo "<input type='hidden' name='".$val."' value='".$arr[$val]."' />\n";
			}
		}
			
	} // end addHiddenField()
	
// 	셀렉트 메뉴 생성
	function mkSelectMenu($name, $array, $select="", $arg=null){
		##$list : Array
		##$arg: array : 0: 각종 argument "style='width: 140px' onChange=this.form.submit()
		echo "<select name='".$name."' ".$arg[0].">\n";
		if (is_array($array)){
			foreach($array as $key => $val){
				$key = (string)$key;
				$selected = ($key == $select) ? " selected":"";
				echo "<option value='".$key."'".$selected.">".$val."</option>\n";
			}
		}
		echo "</select>\n";
	}
	
// 	paging
	function paging($params){//일단 관리자 처리후 common에 페이징 관련 넣어 상속 받는 것으로 처리 예정
		
		$pageSize = $params['pageSize'] ? $params['pageSize'] : 10; // 한 화면에 몇 개의 글을 출력할지 결정하는 변수
		$pageListSize = $params['pageListSize'] ? $params['pageListSize'] : 10; // 블록 당 페이지 수  default < 1 2 3 4 5 6 7 8 9 10 >
		$page = $params['page']; // 몇 번째 페이지인지 나타내는 변수
		$totalRow = $params['totalRow']; // 총 자료의 수
		$pageType = $params['pageType'];
		
// 		echo "pageSize :".$pageSize." page :".$page." totalRow :".$totalRow." pageListSize :".$pageListSize." pageType :".$pageType;
		
		$return = "";
		
		//--페이지 나타내기--
		$totalPage = ceil($totalRow / $pageSize) ; // 총 페이지 수($totalPage)
		$currentBlock = ceil($page / $pageListSize); // 현재 블록($currentBlock)
		$firstPage = ($currentBlock - 1) * $pageListSize + 1; // 현재 블록의 처음 페이지($firstPage)
		$lastPage = ($currentBlock * $pageListSize); // 현재 블록의 마지막 페이지($lastPage)
		$totalBlock = ceil($totalPage / $pageListSize); // 총 블록 수($totalBlock)
		
// 		echo $totalPage." ".$currentBlock." ".$firstPage." ".$lastPage." ".$totalBlock;
		switch($pageType){
			/*
			 case "gameinfo"://처음페이지와 맨나중 페이지로 이동 하는 것 추가
			 
			 # 1페이지로 이동
			 $return .= "<a href='$url&cp=1' class='goToFirst'>".$img_pre0."</a>";
			 
			 if ( $currentBlock > 1 ) {
			 $PREV_PAGE = $firstPage - 1;
			 $page = $firstPage - 1;
			 $return .= "<a href='$url&cp=$page'  class='goToPrev'>".$img_pre."</a>";
			 } else $return .= $img_pre;
			 
			 ###   LISTING NUMBER PART
			 for ($i = $firstPage; $i <= $lastPage && $i <= $totalPage ; $i++) {
			 $class = $cp == $i ? "class='menuActive'" : "";
			 $return .= " <span><a href='$url&cp=$i' $class >$i</a></span> ";
			 }
			 ###   NEXT or END PART
			 if ($currentBlock < $totalBlock) {
			 $page = $lastPage + 1;
			 $return .= "&nbsp;<a href='$url&cp=$page' class='goToNext'>".$img_next."</a>";
			 } else {
			 $return .= "&nbsp;".$img_next;
			 }
			 ## 마지막 페이지로 이동
			 $return .= "<a href='$url&cp=$totalPage' class='goToFirst'>".$img_next0."</a>";
			 break;
			 */
			case "script"://본문에 gotoPage javascrpt 처리
				if ( $page != 1 ) {
					$page = 1;
					$return .= "<a href='javascript:gotoPage(".$page.")'> 처음 </a>";
				}
				if ( $currentBlock > 1 ) {
					$page = $firstPage - 1;
					$return .= "<a href='javascript:gotoPage(".$page.")'> 이전 </a>";
				} else $return .= "이전";
				
				###   LISTING NUMBER PART
				for ($i = $firstPage; $i <= $lastPage && $i <= $totalPage; $i++) {
					if($page == $i) $NUMBER_SHAPE= "<font color = 'gray'><B>".$i."</B></font>";
					else $NUMBER_SHAPE="<font color = 'gray'>".${i}."</font>";
					$return .= "&nbsp;<a href='javascript:gotoPage(".$i.")'>".$NUMBER_SHAPE."</a>";
				}
				###   NEXT or END PART
				if ($currentBlock < $totalBlock) {
					$page = $lastPage + 1;
					$return .= "&nbsp;<a href='javascript:gotoPage(".$page.")'> 다음 </a>";
				} else {
					$return .= "&nbsp;다음";
				}
				if ($currentBlock != $totalPage) {
					$page = $totalPage;
					$return .= "<a href='javascript:gotoPage(".$page.")'> 끝 </a>";
				}
				break;
			case "mall":
				###   PREVIOUS or First 부분
				if ( $currentBlock > 1 ) {
					$PREV_PAGE = $firstPage - 1;
					$page = $firstPage - 1;
					$return .= "<a href='".$url."&page=".$page."'>".$img_pre."</a>";
				} else $return .= $img_pre0;
				
				###   LISTING NUMBER PART
				for ($i = $firstPage; $i <= $lastPage && $i <= $totalPage; $i++) {
					if($page == $i){$NUMBER_SHAPE= "<strong>[".$i."]</strong>";}
					else $NUMBER_SHAPE="[".$i."]";
					$return .= "&nbsp;<a href='".$url."&page=".$i."'>".$NUMBER_SHAPE."</a>";
				}
				###   NEXT or END PART
				if ($currentBlock < $totalBlock) {
					$page = $lastPage + 1;
					$return .= "&nbsp;<a href='".$url."&page=".$page."'>".$img_next."</a>";
				} else {
					$return .= "&nbsp;".$img_next0;
				}
				$return .= "/ <font color='#FF0000'>Total</font> <font color='#000000'>[".$total."]</font> ";
				
				break;
			case "bootstrapPost": // 처음과 끝 버튼을 넣을 시 처음 버튼에 $page=1을 주기 때문에 실제 번호 버튼이 무조건 받은 $page가 1로 고정되버린다
				$return = "<ul class='pagination'>";
				if ( $currentBlock > 1) {
					$page = $firstPage - 1;
					$return .= "<li><a href='javascript:gotoPage(".$page.")'> 이전 </a></li>";
				} else {
					$return .= "<li class='disabled'><a href='javascript:;'> 이전 </a></li>";
				}
				
				///   LISTING NUMBER PART
				for ($i = $firstPage; $i <= $lastPage && $i <= $totalPage; $i++) {
					$activeClass = $page == $i ?" class='active'":"";
					$return .= "<li".$activeClass."><a href='javascript:gotoPage(".$i.")'>" .$i. "</a></li>";
				}
				///   NEXT or END PART
				if ($lastPage < $totalPage) {
					$page = $lastPage + 1;
					$return .= "<li><a href='javascript:gotoPage(".$page.")'> 다음 </a></li>";
				} else {
					$return .= "<li class='disabled'><a href='javascript:;'> 다음 </a></li>";
				}
				$return .= "</ul>";
				break;
				
			default:
				if ( $currentBlock > 1 ) {
					$page = $firstPage - 1;
					$return .= "<a href='".$url."&page=".$page."'>".$img_pre."</a>";
				} else $return .= $img_pre0;
				
				###   LISTING NUMBER PART
				for ($i = $firstPage; $i <= $lastPage && $i <= $totalPage; $i++) {
					if($page == $i) $NUMBER_SHAPE= "<font color = 'gray'><B>".$i."</B></font>";
					else $NUMBER_SHAPE="<font color = 'gray'>".${i}."</font>";
					$return .= "&nbsp;<a href='".$url."&page=".$i."'>".$NUMBER_SHAPE."</a>";
				}
				###   NEXT or END PART
				if ($currentBlock < $totalBlock) {
					$page = $lastPage + 1;
					$return .= "&nbsp;<a href='".$url."&page=".$page."'>".$img_next."</a>";
				} else {
					$return .= "&nbsp;".$img_next0;
				}
				break;
		}
		return $return;
	} // end paging()
} // end class
?>