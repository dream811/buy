<?php if(empty($panel)) {return;} ?>
<?php 	$title = "";
		$cats = "";
		$content = "";
		$file1 = "";
		$file2 = "";
		$file3 = "";?>
<?php
if(!empty($afterview))
	foreach ($afterview as $key => $value) {
		$title = $value->title;
		$cats = $value->category;
		$content = $value->content;
		$file1 = $value->file1;
		$file2 = $value->file2;
		$file3 = $value->file3;
	}
?>
<div class="container">
	<div class="row">
	<?php if($this->input->get("option")=="my"):  ?>
      <?php 
      $data['title']="마이페이지";
      $data['mmy']=1;
      ?>
      <?php $this->load->view("my_header",$data); ?>
    <?php endif; ?>
    <?php if($this->input->get("option")!="my"):  ?>
    <?php $data["link"] = "location.href='"."/panel?id=".$panel[0]->iden; ?>	
      <?php $data['title']=$panel[0]->title ?>

      <?php $this->load->view("event_header",$data); ?>
    <?php endif; ?>
		<div id="subRight">
			<div class="con">
				<form method="post" name="frmBbs" id="frmBbs" enctype="multipart/form-data" action="/bbSend">
					<input type="hidden" name="len" value="<?=$panel[0]->file_size?>">
					<input type="hidden" name="bbc_code" value="<?=$bbc_code?>">
					<input type="hidden" name="id" value="<?=empty($this->input->get("board_id")) ? 0 : $this->input->get("board_id")?>">
					<div class="row pt-10">
						<div class="col-md-1"><p>제목</p></div>
						<div class="col-md-6">
							<input type="text" name="sTIT" id="sTIT" maxlength="100" class="txt form-control" value="<?=$title?>"  required>
						</div>
						<?php if($panel[0]->security ==1): ?>
						<div class="col-md-1-md-2">
							<input type="checkbox" name="security" class="form-check-input">
							<label for="security">비밀글</label>
						</div>
						<?php endif;?>
					</div>
					<div class="row my-4">
						<div class="col-md-1">
							<p>분류</p>
						</div>
						<div class="col-md-2">
						<?php if($panel[0]->category_use ==1): ?>
						<?php $category = explode("|",$panel[0]->category); ?>
						<?php if(!empty($category)): ?>
							<select name="sCT" id="sCT" class="form-control" required>
								<option value="">== 선택</option>
								<?php foreach($category as $value): ?>
								<option value="<?=$value?>"  <?php if($value ==$cats) echo "selected"; ?>><?=$value?></option>	
								<?php endforeach; ?>
							</select>
						<?php endif; ?>	
						<?php endif; ?>
						</div>
						<?php if($panel[0]->state_use ==1): ?>
						<?php $state = explode("|", $panel[0]->state); ?>
						<input type="hidden" name="state" value="<?=!empty($state) ? $state[0]:""?>">
						<?php endif; ?>
					</div>
					<div class="row my-4">
						<div class="col-md-10">
							<textarea class="form-control" name="content" style="height: 300px" required id="content" geditor>
								<?= empty($content) ? $panel[0]->content : $content ?></textarea>
						</div>
					</div>
					<div class="row mt-10">
                        <div class="col-md-6">
                            <?php if($panel[0]->file_size > 0 && $this->session->userdata("flevel") <= $panel[0]->download_use): ?>
                            <?php if(!empty($file1)): ?>
                            <a href="javascript:void(0)" onclick="deleteFile('<?=$file1?>',1,this)" class="text-danger mb-5"><?=$file1?> 삭제</a>
                            <div id="file1"></div>	
                            <?php endif; ?>
                            <?php if(empty($file1)): ?>
                            <input type='file' name='file1' class='mb-5'>
                            <?php endif; ?>
                            <?php if(!empty($file2)): ?>
                            <a href="javascript:void(0)" onclick="deleteFile('<?=$file2?>',2,this)" class="text-danger"><?=$file2?> 삭제</a>
                            <div id="file2"></div>
                            <?php endif; ?>
                             <?php if(empty($file2)): ?>
                            <input type='file' name='file2' class='mb-5'>
                            <?php endif; ?>
                            <?php if(!empty($file3)): ?>
                            <a href="javascript:void(0)" onclick="deleteFile('<?=$file3?>',3,this)" class="text-danger"><?=$file3?> 삭제</a>	
                            <div id="file3"></div>
                            <?php endif; ?>
                            <?php if(empty($file3)): ?>
                           	<input type='file' name='file3' class='mb-5'>
                            <?php endif; ?>
                            <?php endif; ?>
                        </div> 
                    </div>
					<div class="row mt-10 pb-10">
						<div class="col-xs-12 center">
							<input type="submit" class="btn btn-danger btn-round" 
							value="<?=empty($this->input->get("board_id")) ? "등록" : "수정"?>" id="res">
							<a href="panel?id=<?=$panel[0]->iden?><?=!empty($_GET['option']) ? "&option=".$_GET['option']:"" ?>" class="btn btn-default btn-round">취소</a>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

<link href="<?php echo site_url('/template/css/neo.css'); ?>" rel="stylesheet" type="text/css" />
<link href="<?php echo site_url('/template/css/poster.css'); ?>" rel="stylesheet">
<link href="<?php echo base_url(); ?>assets/editor.css" rel="stylesheet" type="text/css" />
<script src="<?php echo base_url(); ?>assets/tinymce/tinymce.min.js"></script>
<script>
    tinymce.init({
        selector: "textarea[geditor]",
        theme: "modern",
        language : 'ko_KR',
        height: 370,
        force_br_newlines : false,
        force_p_newlines : true,
        convert_newlines_to_brs : false,
        remove_linebreaks : true,
        forced_root_block : 'p', // Needed for 3.x
                relative_urls:true,
        allow_script_urls: true,
        remove_script_host: true,
            //convert_urls: false,
        formats: { bold : {inline : 'b' }},
        extended_valid_elements: "@[class|id|width|height|alt|href|style|rel|cellspacing|cellpadding|border|src|name|title|type|onclick|onfocus|onblur|target],b,i,em,strong,a,img,br,h1,h2,h3,h4,h5,h6,div,table,tr,td,s,del,u,p,span,article,section,header,footer,svg,blockquote,hr,ins,ul,dl,object,embed,pre",
        plugins: [
            "jbimages",
             "advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker",
             "searchreplace visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
             "save table contextmenu directionality emoticons template paste textcolor"
       ],
       content_css: "/assets/editor.css",
       body_class: "editor_content",
       menubar : false,
       toolbar1: "undo redo | fontsizeselect | advlist bold italic forecolor backcolor | charmap | hr | jbimages | autolink link media | preview | code",
       toolbar2: "bullist numlist outdent indent | alignleft aligncenter alignright alignjustify | table"
     }); 
</script>
<script>

	$('#frmBbs').on('submit',(function(e) {
        e.preventDefault();
        $("#content").val(CKEDITOR.instances['content'].getData());
        var formData = new FormData(document.getElementById("frmBbs"));
        $.ajax({
            type:'POST',
            url: $(this).attr('action'),
            data:formData,
            cache:false,
            contentType: false,
            processData: false,
            dataType:"json",
            beforeSend: function(){
			    // Show image container
			    $("#loader").show();
			    $("#res").addClass("disabled");
			},
            success:function(data){
                if(data.error==0) 
				{
					alert("등록되였습니다.");
					location.href=data.message;
				} 
                if(data.error==1) 
                	alert(data.message);
                $("#loader").hide();
                $("#res").removeClass("disabled");
            },
            error: function(data){
                alert('서버 오류');
                $("#loader").hide();
                $("#res").removeClass("disabled");
            }
        });
    }));

	function deleteFile(url,type,obj){
		var con = confirm("해당 첨부파일을 삭제하시겠습니까?");
		if(!con)
			return;
		var $this = $(obj);
		$.ajax({
	        type:'POST',
	        url: baseURL + "deleteFile",
	        data:{url:url,id:"<?=$this->input->get("board_id")?>",type:type},
	        success:function(data){            	
	            if(data ==0) alert("서버오류");
	            else
	            {
	            	$("#file"+type).html(" <input type='file' name='file"+type+"' class='mb-5'>");
	            	$this.remove();
	            }
	        },
	        error: function(data){
	            alert("서버오류");
	        }
	    });
	}

</script>