<!DOCTYPE html>
<html>

<head>
    <title></title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <link href="<?php echo site_url('/template/css/bootstrap-v3.3.6.min.css'); ?>" rel="stylesheet">
    <link href="<?php echo site_url('/template/css/reset.css'); ?>" rel="stylesheet">
    <link href="<?php echo site_url('/template/css/user.css'); ?>" rel="stylesheet">
    <link href="<?php echo site_url('/template/css/vpho.css'); ?>" rel="stylesheet">
    <script>     window.jQuery || document.write('<script src="<?php echo site_url('/template/js/jquery-v1.11.3.min.js') ?>"><\/script>')  </script>
    <script src="<?php echo site_url('/template/js/bootstrap-v3.3.6.min.js') ?>"></script>
    <script src="<?php echo site_url('/template/js/common.js')?>" type="text/javascript"></script>
    <script src="<?php echo site_url('/template/js/imagepreview.js')?>" type="text/javascript"></script>
</head>

<body style="">
    <div class="da-wrap3">
        <div class="orderStepTit">
            <h4>상품 실사촬영 목록&nbsp;&nbsp; <span>[주문번호 : <?=$delivery->ordernum?> 수취인 : <?=$delivery->billing_krname?>]</span></h4>
        </div>
        <div class="box-body table-responsive no-padding">
            <table class="table table-hover">
                <tbody>
                    <tr>
                        <th class="text-center">고객메모</th>
                    </tr>
                    <tr>
                        <td>
                           <p><?=$delivery->comment?></p>
                        </td>
                    </tr>
                    <tr>
                        <th class="text-center">실사사진</th>
                    </tr>
                    <tr>
                        <td>
                            <ul>
                                <?php if(!empty($map)): ?>
                                <?php foreach($map as $value): ?>
                                    <li class="show">
                                        <a href="../upload/silsa/<?=$delivery->delivery_id?>/<?=$value?>"  class="preview" target="_blank"><img src="../upload/silsa/<?=$delivery->delivery_id?>/<?=$value?>" class="ProImg" width="80" height="80" style="cursor:pointer;object-fit: cover;"></a>
                                    </li>
                                <?php endforeach; ?>
                            <?php endif; ?>
                            </ul>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</html>
<script type="text/javascript">
  	$('.preview').anarchytip();
</script>
<style>
    .da-wrap3 table th {
        background: #2083a5;
        color: #fbfbfb;
        padding: 5px 0;
    }
    .da-wrap3 table ul li {
	    margin-bottom: 15px;
	    float: left;
	    margin-right: 10px;
	}
	.da-wrap3 table {
	    border: 1px solid #dbdbdb;
	    border-top: none;
	    background: #fbfbfb;
	}
	.show {
	  width: 100px;
	  height: 100px;
	}
</style>