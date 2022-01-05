<?php 
	if($afterview[0]->security==1){
		if(($this->session->userdata('fuser') !=$afterview[0]->fromId && $this->session->userdata('fuser') !=$afterview[0]->toId) 
			|| empty($this->session->userdata('fuser')))
		{
			if(!empty($_GET['id'])) echo "<script>alert('비밀글은 본인만 확인할 수 있습니다');location.href='/panel?id=".$_GET['id']."'</script>";
			else {echo "<script>alert('비밀글은 본인만 확인할 수 있습니다');location.href='/'</script>";}
			return;
		}
	}
?>
<script>
	var c=1;
	function fnFlDn(sFL_SEQ) {
		var frmObj = "#frmMove";
		$(frmObj + " input[name='sFL_SEQ']").val( sFL_SEQ );
		$(frmObj).attr("method", "post").attr("action", "/fnBbs_Dn").attr("target", "prcFrm");
		$(frmObj).submit();
	}
</script>
<div class="container">
	<div class="row">
		<?php if(!empty($_GET['option'])) $data['left'] = $_GET['option']; ?>
		<?php if(empty($_GET['option'])) $data['left'] = "customer"; ?>
		<?php $this->load->view("left_menu",$data); ?>
		<div id="subRight" class="col-md-9">
			<div class="padgeName">
				<h2><?= $this->input->get("option") == "my" ? "Q&A" :  $afterview[0]->btitle?></h2>
			</div>
			<div class="con">
				<div class="board_view_head row">
					<div class="col-xs-6">
						<h4 class="bold">No.<?=$afterview[0]->id?>&nbsp;&nbsp;<?=$afterview[0]->title?></h4>
					</div>
					<div class="col-xs-6 text-right">
						<ul>
							<li>작성일 : <?=$afterview[0]->updated_date?></li>
							<li>조회수 : <?=$afterview[0]->view?></li>
						</ul>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-12">
						<?php 
							if (strpos($afterview[0]->content, base_url()."upload") == false) {
							   	$afterview[0]->content = str_replace("../../upload/tinymce/", base_url()."upload/tinymce/", $afterview[0]->content);
								$afterview[0]->content = str_replace("../upload/tinymce/", base_url()."upload/tinymce/", $afterview[0]->content);
								$afterview[0]->content = str_replace("\"upload/tinymce/", "\"".base_url()."upload/tinymce/", $afterview[0]->content);
							}
						?>
						<?=$afterview[0]->content?>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12">
						<?php if((!empty($this->session->userdata("frole")) &&  $this->session->userdata("frole") <= $afterview[0]->download_use) 
						|| $afterview[0]->download_use==100000): ?>
							<?php if(!empty($afterview[0]->file1)): ?>
								<?php $ext = pathinfo($afterview[0]->file1, PATHINFO_EXTENSION); ?>
								<?php if(	strtolower($ext)=="jpg" || 
											strtolower($ext)=="jpeg" || 
											strtolower($ext)=="png" || 
											strtolower($ext)=="gif"): ?>
								<img src="/upload/mail/<?=$afterview[0]->id?>/<?=$afterview[0]->file1?>" class="w-100">
								<?php endif; ?>			
							<a href="javascript:fnFlDn('1');" class="btn-block text-danger text-bold"><?=$afterview[0]->file1?></a>
							<?php endif; ?>
							<?php if(!empty($afterview[0]->file2)): ?>
								<?php $ext = pathinfo($afterview[0]->file2, PATHINFO_EXTENSION); ?>
								<?php if(	strtolower($ext)=="jpg" || 
											strtolower($ext)=="jpeg" || 
											strtolower($ext)=="png" || 
											strtolower($ext)=="gif"): ?>
								<img src="/upload/mail/<?=$afterview[0]->id?>/<?=$afterview[0]->file2?>" class="w-100">
								<?php endif; ?>	
							<a href="javascript:fnFlDn('2');" class="btn-block text-danger text-bold"><?=$afterview[0]->file2?></a>
							<?php endif; ?>
							<?php if(!empty($afterview[0]->file3)): ?>
								<?php $ext = pathinfo($afterview[0]->file3, PATHINFO_EXTENSION); ?>
								<?php if(	strtolower($ext)=="jpg" || 
											strtolower($ext)=="jpeg" || 
											strtolower($ext)=="png" || 
											strtolower($ext)=="gif"): ?>
								<img src="/upload/mail/<?=$afterview[0]->id?>/<?=$afterview[0]->file3?>" class="w-100">
								<?php endif; ?>	
							<a href="javascript:fnFlDn('3');" class="btn-block text-danger text-bold"><?=$afterview[0]->file3?></a>
							<?php endif; ?>
						<?php endif; ?>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-12 my-4 my-3">
						<?php if(	!empty($this->session->userdata('frole')) && $this->session->userdata('frole') <=$afterview[0]->writing_use || 
									!empty($this->session->userdata('frole')) && $afterview[0]->writing_use==0 ): ?>	
							<a href="/board_write?bbc_code=<?=$afterview[0]->type?>&id=<?=$_GET['id']?>&option=<?=!empty($_GET['option']) ? $_GET['option']:"customer" ?>" class="btn btn-warning btn-round btn-sm">글쓰기</a>
							<?php if($this->session->userdata('fuser') ==$afterview[0]->fromId): ?>
							<a href="/board_edit?bbc_code=<?=$afterview[0]->type?>&board_id=<?=$afterview[0]->id?>&id=<?=$_GET['id']?>&option=<?=!empty($_GET['option']) ? $_GET['option']:"customer" ?>" class="btn btn-danger btn-round">수정</a>
							<a class="btn btn-danger btn-round" href="javascript:deletepost(<?=$afterview[0]->id?>,'<?=$this->input->get("id")?>')">삭제</a>
							<?php endif; ?>
						<?php endif; ?>
						<a href="/panel?id=<?=$afterview[0]->iden?><?=!empty($_GET['option']) ? "&option=".$_GET['option']:"" ?>" 
							class="btn btn-default btn-round btn-sm">목록</a>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-12">
						<div class="comment-wrapper">
				            <div class="panel panel-info">
				                <div class="panel-heading">
				                    댓글(<?=sizeof($comment)?>)
				                </div>
				                <div class="panel-body">
				                	<?php if(!empty($this->session->userdata('frole')) 
				                	&& $this->session->userdata('frole') <= $afterview[0]->comment_use): ?>	
				                    	<textarea class="form-control" rows="3" name="content" id="content"></textarea>
				                    	<input type="hidden" name="id" id="id">
				                    <br>
				                    <a href="javascript:void(0);" class="btn btn-info pull-right btn-round btn-sm"
				                    onclick="insertComment('<?=$afterview[0]->id?>',$('#id').val())">댓글달기</a>
				                    <?php endif; ?>
				                    <div class="clearfix"></div>
				                    <hr>
				                    <ul class="media-list">
				                        <?php if(!empty($comment)): ?>
				                        	<?php foreach($comment as $value): ?>
				                        		<li class="media">
						                            <div class="media-body">
						                                <span class="text-muted pull-right">
						                                    <small class="text-muted">
						                                    	<?=$value->created_date?>
						                                    </small>
						                                </span>
						                                <strong class="text-success"><?=$value->name?></strong>
						                                <?php if (	!empty($this->session->userdata('fuser')) && 
						                                			$value->userId==$this->session->userdata('fuser')): ?>
						                                <a href="javascript:void(0)" style="font-weight: 600" class="text-danger text-bold" onclick="javascript:deleteComment(<?=$value->id?>,$(this))">X</a>
						                                <a href="javascript:fnCmtMod(<?=$value->id?>,'<?=$value->content?>')">[수정]</a>		
						                                <?php endif; ?>			
						                                <p>
						                                    <?=$value->content?>
						                                </p>
						                            </div>
						                        </li>
				                        	<?php endforeach; ?>
				                        <?php endif; ?>
				                    </ul>
				                    <a class="loadmore text-primary" href="javascript:loadmore(c,<?=$afterview[0]->id?>)">Load More</a>
				                </div>
				            </div>
				        </div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<form id="frmMove">
	<input type="hidden" name="sFL_SEQ">
	<input type="hidden" name="id" value="<?=$afterview[0]->id?>">
</form>
<link href="<?php echo site_url('/template/css/user.css'); ?>" rel="stylesheet">
<link href="<?php echo site_url('/template/css/event.css'); ?>" rel="stylesheet">
<script>
	var comment_count = 0;
    comment_count = <?=$size?>; 
    function loadmore(comment_id,id){
    	var userId = <?=$this->session->userdata('fuser');?>;
      if(comment_id*5 >=comment_count) return;
        jQuery.ajax({
          method: "POST",
          url: baseURL+"getCommentMore",   
          data: {id:id,comment_id:comment_id},
          dataType:"json",
          beforeSend:function(){
            $(".loadmore").text("Loading...");
            $(".loadmore").addClass("disabled");
          },
        })
          .done(function( msg ) {
            c++;
            $(".loadmore").text("Load More");
            $(".loadmore").removeClass("disabled");
            if(msg.length > 0){
              for(var i=0;i<msg.length;i++){
              	var del = "";
              	if(userId == msg[0].userId){
              		del = '<a href="#" style="font-weight: 600" class="text-danger text-bold" onclick="javascript:deleteComment('+msg[i].id+',$(this))">X</a>'+'<a href="javascript:fnCmtMod(<?=$value->id?>,\''+msg[i].content+'\')">[수정]</a>	';
              	} 
                $(".media-list").append("<li class='media'>\
                  <div class='media-body'>\
                    <span class='text-muted pull-right'><small class='text-muted'>\
                    "+msg[i].created_date+"\
                    </small>\
                    </span>\
                    <strong class='text-success'>"+msg[i].name+"</strong>\
                    "+del+"\
                    <p>\
                    "+msg[i].content+"\
                    </p>\
                    </div>\
                    </li>");
              }
            }
          });
        
    }
    function deleteComment(id,tho){
      var fIptId = "";
      if (!confirm('해당 댓글을 삭제하시겠습니까?')) {
        return;
      }
      jQuery.ajax({
      method: "POST",
      url: baseURL+"deleteComment",   
      data: {id:id}
    })
      .done(function( msg ) {
        tho.parent().parent().remove();
      });
    }

    function fnCmtMod(id,content){
    	$("#content").val(content);
    	$("#id").val(id);
    }
</script>