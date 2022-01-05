
<!DOCTYPE html>
<html>
<head>
	<title>카테고리 선택</title>
	<meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
	<link href="<?php echo base_url(); ?>assets/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
	<link href="<?php echo base_url(); ?>assets/dist/css/admin.css" rel="stylesheet" type="text/css" />
</head>
<body>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h3 class="text-center">
        관련	카테고리 선택 
      </h3>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-12">
            	<div class="row">
            		<div class="col-md-4 my-4">
            			<label>1차 카테고리</label>
	            		<?php if(!empty($categories1)): ?>
	            		<?php foreach($categories1 as $value): ?>
	            		<a href="javascript:SelectCategory(<?=$value->id?>,'<?=$value->name?>')" class="btn btn-block  
	            			<?=$sels == $value->id ? "disabled btn-danger":"btn-default"?>"><?=$value->name?></a>
	            		<?php endforeach; ?>
	            		<?php endif; ?>
            		</div>
            		<div class="col-md-4 my-4">
            			<label>2차 카테고리</label>
	            		<?php if(!empty($categories2)): ?>
	            		<?php foreach($categories2 as $value): ?>
	            		<a href="javascript:SelectCategory(<?=$value->id?>,'<?=$value->name?>')" class="btn btn-block 
	            			<?=$sels == $value->id ? "disabled btn-danger":"btn-default"?>"><?=$value->name?></a>
	            		<?php endforeach; ?>
	            		<?php endif; ?>
            		</div>
            		<div class="col-md-4 my-4">
            			<label>3차 카테고리</label>
            			<?php if(!empty($categories3)): ?>
	            		<?php foreach($categories3 as $value): ?>
	            		<a href="javascript:SelectCategory(<?=$value->id?>,'<?=$value->name?>')" class="btn btn-block 
	            			<?=$sels == $value->id ? "disabled btn-danger":"btn-default"?>"><?=$value->name?></a>
	            		<?php endforeach; ?>
	            		<?php endif; ?>
            		</div>
            	</div>
            </div>
        </div>
    </section>
</div>
</body>
</html>
<style type="text/css">
	.row{
		margin: 0
	}
</style>

<script>
	function SelectCategory(id,name){
		self.close();
		opener.updateRealtedCategory(id,name);
	}
</script>