<!DOCTYPE html>
<html>
<head>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet" />
    <script>
    window.jQuery || document.write('<script src="<?php
    echo site_url('/template/js/jquery-v1.11.3.min.js') ?>"><\/script>')
  </script>
</head>
<body style="background: none;">
	<div class="container">
		<div class="row">
			<div class="table-responsive">
				<table class="table table-dark">
					<thead>
				      <tr >
				        <th scope="col"></th>
				        <th scope="col">수취인</th>
				        <th scope="col">주소</th>
				      </tr>
				    </thead>
				    <tbody>
				    	<?php if(!empty($contacts)):
				    			foreach($contacts as $value): ?>
				    	<tr style="border-bottom: 1px solid">
				    		<td><a href="javascript:fnRtnVal('<?=$value->name?>|<?=$value->eng_name?>|<?=$value->postcode?>|<?=$value->address?>|<?=$value->details_address?>|<?=$value->phone?>|<?=$value->type?>|<?=$value->unique_info?>');" class="btn btn-default">선택</a></td>
				    		<td class="text-left"><?=$value->name?><br><?=$value->eng_name?><br><?=$value->phone?></td>
				    		<td><?=$value->address?><br><?=$value->details_address?></td>
				    	</tr>
				    <?php endforeach;
				    	endif; ?>
				    </tbody>
				</table>
			</div>
			<div class="text-center">
				<a href="javascript:self.close();" class="btn btn-default btn-sm">닫기</a>
			</div>
		</div>
	</div>
</body>
</html>
<script type="text/javascript">
	function fnRtnVal(val){
		opener.fnMemAddrCfm(val);
		window.close(); 
	}
	$(".deleteContact").click(function(){
    	currentRow = $(this);
    	var id=$(this).data("delivery");
    	if(id > 0){
    		var message = confirm("정말 삭제하시겠습니까?");
	    	if(message){
	    		$.ajax({
				  method: "POST",
				  url: "deleteContact",
				  data: { id:id}
				})
				.done(function( msg ) {
				    currentRow.parents('tr').remove();
				});
	    	}
    	}
    });
</script>