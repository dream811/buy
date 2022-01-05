<!DOCTYPE html>
<html>
<head>
	<title></title>
	<meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <link href="<?php echo base_url(); ?>assets/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url(); ?>assets/dist/css/admin.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url(); ?>assets/dist/css/user.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url(); ?>assets/dist/css/table.min.css" rel="stylesheet" type="text/css" />
    <script src="<?php echo base_url(); ?>assets/js/jQuery-2.1.4.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/head.js"></script>
</head>
<body>
	<div class="container-f">
		<div class="row">
			<div class="col-md-12">
				<div class="pop-title"><h3 style="padding-top:0px">엑셀 업로드</h3></div>
				<div class="addpop-wrap" style="text-align: center;">
				    <div class=""> 
						<form method="post" name="frmPageInfo" id="frmPageInfo" action="./ActingExcel_I" enctype="multipart/form-data">   
							<table cellpadding="0" cellspacing="0" border="0">
								<colgroup>
								<col width="30%"><col width="*%"><col width="20%">
								</colgroup>   
								<tbody><tr> 
									<th>업로드 엑셀</th> 		
									<td>	
										<input type="file" name="Multi_FL" id="Multi_FL" maxlength="70" value=""> </td><td>
										<a href="javascript:" onclick="fnMultiSampleDown();" target="_Blank" class="btn btn-sm btn-warning my-4"><span>샘플 다운로드</span></a>
									</td> 
								</tr>  
							</tbody></table> 
						</form>
						<div class="btn-area"> 
							<span class="whGraBtn_bg ty2">
								<button type="button" class="btn btn-sm btn-primary" onclick="fnExcelAdd();">등록</button>
							</span>&nbsp;   
							<span class="whGraBtn ty2">
								<button type="button" class="btn btn-sm btn-primary" onclick="self.close();">닫기</button>
							</span>
						</div>
				 
					</div> 
				</div>
			</div>
		</div>
	</div>
</body>
</html>
<script>
	function fnMultiSampleDown() {
		top.location.href = "/upload/BulkIvcSample.xls";
	}
	function fnExcelAdd() {
		var frmObj  = "#frmPageInfo";
		var fIptId  = "";
		// 제목 체크
		fIptId     = $(frmObj + " input[name='Multi_FL']");
		if ( !fnIptChk( fIptId ) ) {
			fnMsgFcs( fIptId, "파일을 선택하세요." );
			return;
		}
		$(frmObj).attr("action", "./ActingExcel_I");
		$(frmObj).submit();

	}
</script>