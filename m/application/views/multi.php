<?php $ss="배송";?>
<?php if($_GET['type']==1) {$ss="배송";}?>
<?php if($_GET['type']==2) {$ss="구매";} ?>
<?php $this->load->view("multi_header",NULL); ?>
<link href="<?php echo site_url('/template/css/multi.css'); ?>?<?=time()?>" rel="stylesheet">
<div class="container bg-white p-left-10 p-right-10">
	<div id="subRight" class="multi">
		<div class="orderTit border-none mt-10">
	        <h4><?=$ss?>대행 대량등록</h4>
	    </div>
		<div class="panel panel-primary border-none">
	      	<div class="panel-body">
	      		<?php echo form_open_multipart('multiupload',array('id' => 'multiForm'));?>
		      		<div class="row">
			      		<div class="col-md-12">
			      			<span class="mr-10">대량등록</span>
			      			<input type="file" name="Multi_FL" id="Multi_FL" maxlength="100" style="display: inline-block;">
			      			<input type="hidden" name="type" value="<?=$_GET['type']?>">     			
			      		</div>
			      	</div>
	      		</form>	
	      	</div>
	    </div>
	    <div class="row mb-10">
      		<div class="col-md-12 text-center">
      			<a href="#" class="btn btn-default btn-sm btn-round" onclick="fnMultiSampleDown('<?=$_GET['type']?>');">대량등록 엑셀샘플 다운로드</a>
      			<button  class="btn btn-danger multi-btn btn-round btn-sm" 
      				data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> 처리중">&nbsp;&nbsp;등록&nbsp;&nbsp;</button>
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

<script type="text/javascript">
	var frmObj  = "#multiForm";
	var fIptId  = "";
	fIptId     = $(frmObj + " input[name='Multi_FL']");
	var timer ="";
	function fnMultiSampleDown(TyCd) {
		if ( TyCd == "2" )
			location.href = "<?=base_url_home()?>upload/multi/BuySample.xls";
		else
			location.href = "<?=base_url_home()?>upload/multi/DlvrSample.xls";
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
	            		location.href="/viewdeliveryState";
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