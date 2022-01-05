<div class="container">
	<div class="row">
		<div id="subLeft" class="col-md-3">
			<div class="LeftTitle">
				<?php if($_GET['type']==1) {echo '배송대행'; $ss="배송";}?>
				<?php if($_GET['type']==2) {echo '구매대행'; $ss="구매";} ?>
			</div>
			<ul class="leftMenu">
				<li >
					<?php if($_GET['type']==1): ?>
						<a href="/delivery">배송대행신청</a></li>
					<?php endif; ?>
					<?php if($_GET['type']==2): ?>
						<a href="/delivery?options=buy">구매대행신청</a></li>
					<?php endif; ?>
				<li class="on"><a href="/multi?type=1">대량등록(엑셀)</a></li>
			</ul> 
		</div>
		<div id="subRight" class="col-md-9 multi">
			<div class="padgeName">
				<h2>대량등록(엑셀)</h2>
			</div>
			<div class="panel panel-primary">
		      <div class="panel-heading text-center" ><?=$ss?>대행 대량등록(엑셀)</div>
		      <div class="panel-body border">
		      	<div class="row">
		      		<div class="col-md-2 col-sm-12">
		      			<h2>대량등록</h2>
		      		</div>
		      		<?php echo form_open_multipart('multiupload',array('id' => 'multiForm'));?>
			      		<div class="col-md-4 col-sm-12">
			      			<input type="file" name="Multi_FL" id="Multi_FL" maxlength="100" value="">
			      			<input type="hidden" name="type" value="<?=$_GET['type']?>">     			
			      		</div>
		      		</form>	
		      		<div class="col-md-4 col-sm-12">
		      			<a href="#" class="btn btn-danger btn-sm btn-round" onclick="fnMultiSampleDown('<?=$_GET['type']?>');">대량등록 엑셀샘플 다운로드</a>
		      		</div>
		      	</div>		      	
		      </div>
		    </div>
		    <div class="row my-15">
	      		<div class="col-md-12 text-center">
	      			<button  class="btn btn-danger multi-btn btn-round" 
	      				data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> 처리중">등록</button>
	      		</div>
	      	</div>
	      	<div class="row">
	      		<div class="col-md-12">
	      			<div class="progress my-15">
					  <div class="progress-bar progress-bar-striped progress-bar-animated"></div>
					</div>
	      		</div>
	      	</div>
		</div>
	</div>
</div>
<link href="<?php echo site_url('/template/css/multi.css'); ?>?<?=time()?>" rel="stylesheet">
<script type="text/javascript">
	var frmObj  = "#multiForm";
	var fIptId  = "";
	fIptId     = $(frmObj + " input[name='Multi_FL']");
	var timer ="";
	function fnMultiSampleDown(TyCd) {
		if ( TyCd == "2" )
			location.href = "/upload/multi/BuySample.xls";
		else
			location.href = "/upload/multi/DlvrSample.xls";
	}
	function makeRequest(toPHP, callback) {
        var xmlhttp;
        var params = 'out=1';
        if (window.XMLHttpRequest)
          {// code for IE7+, Firefox, Chrome, Opera, Safari
          xmlhttp=new XMLHttpRequest();
          }
        else
          {// code for IE6, IE5
          xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
          }
        xmlhttp.open("POST",toPHP,true);  
        xmlhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded'); 
        xmlhttp.onreadystatechange=function()
          {
              if (xmlhttp.readyState==4 && xmlhttp.status==200)
                {
                    callback(xmlhttp.response);
                }
          }
        xmlhttp.send(params);
     }

	 function loop() {
         timer=setInterval(makeRequest("getTimes", function(response) {
            $(".progress-bar").css('width',parseFloat(response)*100+"%");
            if(response ==1) {alert("등록 성공");clearInterval(timer);return;}
          }),1000);
     }

	// 제목 체크
	$('.multi-btn').click(function(e) {
		var $this = $(this);
		if ( !fnIptChk( fIptId ) ) {
			fnMsgFcs( fIptId, "파일을 선택하세요" );
			return;
		}
        else{
        	$(".progress-bar").css('width',"1%");
        	$this.button("loading");
        	loop();
	        var formData = new FormData(document.getElementById("multiForm"));
	        $.ajax({
	            type:'POST',
	            url: baseURL + "multiupload",
	            data:formData,
	            dataType: "json",
	            contentType: false,
		        cache: false,
		   		processData:false,
				beoforeSend:function(){
					$this.button("loading");
				},
	            success:function(data){
	            	clearInterval(timer);
	            	$this.button("reset");
	            	if(data.errorId==1) location.reload();
	            	else{
	            		socket.emit("chat message",
	            										1,
	            										data.post_id,
	            										<?=$this->session->userdata('fuser')?>,
	            										"<?=$_GET['type']==1 ? "delivery":"buy"?>",
	            										"<?=$this->session->userdata('fname')?>")
	            		location.href="/mypage";
	            	}
	            },
	            error: function(data){
	            	$this.button("reset");
	            	clearInterval(timer);
	            }
	        });
        }
    });
</script>