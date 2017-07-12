<?php
class Admin {
	
	var $common;
	
	function get_object(/* &$dbcon=null,  */&$common=null/* , &$mall=null */){//db_connection 함수 불러오기
// 		$this->dbcon	= &$dbcon;
		$this->common	= &$common;
// 		$this->mall		= &$mall;
	}
	
	// 검색 필드 셀렉트 박스
	function selectMemType($sel = null) {
		$array = array (
				"" => "- 선택 -",
				"mem_name" => "이름",
				"mem_nickname" => "아이디",
				"mem_email" => "이메일",
				"mem_phoneNum" => "휴대폰번호",
				"mem_addr" => "주소" 
		);
		$arg [0] = "";
		$this->common->mkSelectMenu ( 'search_type', $array, $sel, $arg );
	} // end sel_mem_stitle()
} // end class
?>