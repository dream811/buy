<!DOCTYPE html>
<html>
<head>
	<title></title>

    <link href="<?php echo base_url(); ?>assets/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url(); ?>assets/dist/css/admin.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url(); ?>assets/dist/css/table.min.css" rel="stylesheet" type="text/css" />  
	<script src="<?php echo base_url(); ?>assets/js/jQuery-2.1.4.min.js"></script>
	<script src='<?php echo base_url(); ?>assets/bootstrap/js/bootstrap.min.js'></script>	
</head>
<body>
	<div class="container">
		<table class="table table-bordered">
			<?php if(!empty($delivery_id)): ?>
			<?php foreach($delivery_id as $key=>$value): ?>
			<?php 
			$use = 1;
			$id = $comment = $memo = "";
			if(!empty($comments[$key]))
			{
				$id = $comments[$key][0];
				$use = empty($comments[$key][1]) ? 1: $comments[$key][1] ;
				$comment = $comments[$key][2];
				$memo = $comments[$key][3];
			}
			?>
			<tr>
				<td>
					<?php echo form_open_multipart('deliveryComment');?>
					  	<div class="form-group">
					    	<label for="comment">고객메모(<?=$key==0 ? "현재":""?> 주문번호 : <?=$ordernum[$key]?>)</label>
					    		<textarea id="comment" name="comment" class="form-control" 
					    		style="height: 100px;" required><?=$comment?></textarea>
					    	<input type="hidden" name="delivery_id" value="<?=$value?>">
					    	<input type="hidden" name="id" value="<?=$id?>">
					  	</div>
					  	<div class="form-group">
					  		<label for="MngMemo<?=$value?>">관리자메모 
					  			<button type="button" class="btn btn-danger btn-sm" onclick="fnMngMemo('<?=$value?>');">등록</button>
					  		</label>
					  		<textarea id="MngMemo<?=$value?>" class="form-control" 
					    		style="height: 100px;"><?=$memo?></textarea>
							
					  	</div>
					  	<div class="form-group">
					    	<label for="exampleInputPassword1">첨부파일 보기</label>
						    <div class="box-body table-responsive no-padding">
				                  <table class="table table-hover">
				                    <tr>
				                      <th>파일명</th>
				                      <th>상품 이미지</th>
				                      <th> </th>
				                    </tr>
				                    <?php if(!empty($map[$key])): ?>
				                    	<?php foreach($map[$key] as $mapv): ?>
				                    		<tr>
						                      <td class="mid"><p data-toggle="tooltip" data-placement="top" title="<?=$mapv?>"><?=substr($mapv, 0, 30)?>...</p></td>
						                      <td class="mid"><img src="../upload/silsa/<?=$value?>/<?=$mapv?>" width="70"></td>
						                      <td class="mid"><a href="javascript:deleteImageSilsa(<?=$value?>,'<?=$mapv?>')" 
						                      	class="btn btn-sm btn-danger">삭제</a></td>
						                    </tr>
				                    	<?php endforeach; ?>
				                    <?php endif; ?>
				                </table>
				            </div>
					  	</div>
					  	<div class="form-group">
					  		<label  for="image">첨부파일</label>
					    	<input type="file" class="form-control" name="image[]" multiple="">
					  	</div>
					  	<div class="form-group">
					  	<label  for="use">사용유무</label>
					    <select class="form-control" name="use">
					    	<option value="1" <?=$use ==1 ? "selected":""?>>보임</option>
					    	<option value="0" <?=$use ==0 ? "selected":""?>>숨김</option>
					    </select>
					  </div>
					  <button type="submit" class="btn btn-primary">저장</button>
					  <a href="javascript:self.close();" class="btn btn-default">닫기</a>
					</form>
				</td>
			</tr>
			<?php endforeach; ?>
			<?php endif; ?>
		</table>
	</div>
</body>
</html>
<script>
	$(document).ready(function(){
	  $('[data-toggle="tooltip"]').tooltip()
	})

	function deleteImageSilsa(id,name){
		var confirmation = confirm("삭제하시겠습니까 ?");
		if(confirmation) {
			var hitURL = "<?php echo base_url(); ?>deleteF";
			jQuery.ajax({
			type : "POST",
			url : hitURL,
			data : { url : "../upload/silsa/"+id+"/"+name } 
			}).done(function(data){
				if(data ==1 )  {alert("변경되였습니다.");window.location.reload();}
				else alert("서버오류");
			});
		}
	}

	function fnMngMemo(id){
		var memo_content = $("#MngMemo"+id).val();
		if(memo_content.trim() == ""){
			alert("메모를 입려하세요");
			$("MngMemo"+id).focus();
			return;
		}
		opener.fnMngMemo(id,memo_content);
	}
</script>

<style type="text/css">
	table {
		border-collapse: separate;
		border-spacing: 5px;
		border-spacing: 1vw;
		border-spacing: 2em;
	}
</style>