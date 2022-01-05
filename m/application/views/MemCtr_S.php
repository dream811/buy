<!DOCTYPE html>
<html>
<head>
	<title></title>
	<meta charset="utf-8">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta http-equiv="content-language" content="es-ES" />
	<meta name="viewport" content="width=device-width,initial-scale=1.0, maximum-scale=1">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<link href="<?php echo site_url('/template/css/bootstrap-v3.3.6.min.css'); ?>" rel="stylesheet">
	<link href="<?php echo site_url('/template/css/style.css');?>" rel="stylesheet">
	<link href="<?php echo site_url('/template/css/slick.min.css'); ?>" rel="stylesheet">
	<link href="<?php echo site_url('/template/css/reset.css'); ?>" rel="stylesheet">
	<link href="<?php echo site_url('/template/css/user.css'); ?>" rel="stylesheet">
</head>
<body style="background: none;margin-top: 0px">
	<div id="pop_wrap">
		<!-- <h1>나의 중국 주소</h1> -->
		<?php if(!empty($contents)): ?>
			<?php foreach($contents as $value): ?>
		<div class="t_board">
			<table class="board_list" summary="배송지">
				<colgroup>
					<col width="63px"></col>
					<col></col>
				</colgroup>
				<thead>
				<tr>
					<th colspan="2">
						<span class="bold">"<?=$value->area_name?>"</span> 물류센터 주소지 적는 방법
					</th> 
				</tr> 
				</thead>
				<tbody>
					<tr>
						<th class="tit text-center">주소 </td>
						<td><span class="bold"><?=$value->address?></span></td>
					</tr>
					<tr>
						<th class="tit text-center">사서함 </td>
						<td><span class="bold"><?=$value->mailbox?><?=!empty($user) ? $user[0]->sase:""?></span></td>
					</tr>
					<tr>
						<th class="tit text-center">우편번호 </td>
						<td><span class="bold"><?=$value->postNum?></span></td>
					</tr>
					<tr>
						<th class="tit text-center">전화번호 </td>
						<td><span class="bold"><?=$value->phoneNum?></span></td>
					</tr>
				</tbody>
			</table>
		</div>
			<?php endforeach; ?>
		<?php endif; ?>
</div> 

 </body>
</html>
<style type="text/css">
	html, body {
    background-color: #fff !important;
}

#pop_wrap h1 {
    margin-bottom: 9px;
    margin-top: 10px;
}
</style>