<html>
<head></head>
<body style="background: none;">

	<div id="pop_wrap">
		<h1>이미지 등록</h1>
		<!-- 게시판 -->
		<div class="t_board">

	<form method="post" name="popFrmImg" id="popFrmImg" enctype="multipart/form-data">
	    <table class="board_list" summary="">
	        <colgroup>
	        <col width="15%">
	        <col width="*">
	        </colgroup>
			<thead>
			<tr> 
				<th>이미지</th>
				<th></th>
			</tr>
			</thead> 
			<tbody>
			<tr>
				<td><input type="file" name="FILE_NM" id="FILE_NM"></td>
				<td><a href="javascript:" onclick="fnImgReg();" class="btn_reg"><span>이미지 등록</span></a></td>
			</tr>
			</tbody>
	    </table> 
	</form>
		<div class="btn_wrap style_top_3">
			<a href="javascript:self.close();" class="btn_cancel"><span>닫기</span></a>
		</div> 
	</div>

</div> 


<script language="JavaScript" type="text/JavaScript">
<!-- 
 
// 등록
function fnImgReg() {
	var frmObj = "#popFrmImg";
	var fFileNm =  $(frmObj + " input[name='FILE_NM']").val();
	var fExt = "";

	if ( $(frmObj + " input[name='FILE_NM']").val() == "" ) {
		alert("이미지를 선택해주십시오.");
		return;
	}

	fExt = fFileNm.replace(/^.*\./, '');
	fExt = fExt.toLowerCase();

	if ( fExt == "gif" || fExt == "jpg" || fExt == "png" ) {
		$(popFrmImg).attr("action", "./PopProImg_I.asp").attr("target", "").submit();
	} else {
		alert("이미지 파일만 가능합니다.");
	}
} 

//-->
</script>  </body></html>