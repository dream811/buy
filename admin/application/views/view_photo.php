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
    <script src='<?php echo base_url(); ?>assets/bootstrap/js/bootstrap.min.js'></script>
    <script src="<?php echo base_url(); ?>assets/js/imagepreview.js"></script>
</head>

<body>
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
                            <?php if(!empty($map) && $map!=null): ?>
                                <?php foreach($map as $value): ?>
                                <li class="show">
                                    <a href="../upload/silsa/<?=$delivery->delivery_id?>/<?=$value?>"  class="preview" target="_blink"><img src="../upload/silsa/<?=$delivery->delivery_id?>/<?=$value?>" class="ProImg" width="80" height="80" style="cursor:pointer;object-fit: cover;"></a>
                                </li>
                                <?php endforeach; ?>
                            <?php endif; ?>
                            </ul>
                        </td>
                    </tr>
                </tbody>
            </table>
            <p class="my-4 text-center"><a href="javascript:self.close();" class="btn-default btn"><span>닫기</span></a></p>
            <p>
            </p>
        </div>
    </div>
</body>
</html>
<script type="text/javascript">
  	$('.preview').anarchytip();
</script>
<style>
    .da-wrap3 table th {
        background: #06C;
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