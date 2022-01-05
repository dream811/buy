<link href="<?php echo base_url(); ?>assets/plugins/morrisjs/morris.css" rel="stylesheet" type="text/css" />
<script>
var vars = [0,0,0,0,0,0,0,0,0,0,0,0];
var vars1 = [0,0,0,0,0,0,0,0,0,0,0,0];
var vars2 = [0,0,0,0,0,0,0,0,0,0,0,0];
var vars3 = [0,0,0,0,0,0,0,0,0,0,0,0];
<?php if(!empty($register_members)): ?>
<?php foreach($register_members as $value):
    $d = $value->cdate;
 ?>
    <?php 
        switch ($d) {
            case date("Y")."-01":
                    echo "vars[0]=".$value->c.";";
                break;
            case date("Y")."-02":
                echo "vars[1]=".$value->c.";";
                break;
            case date("Y")."-03":
                echo "vars[2]=".$value->c.";";
                break;
            case date("Y")."-04":
                echo "vars[3]=".$value->c.";";
                break;
            case date("Y")."-05":
                echo "vars[4]=".$value->c.";";
                break;
            case date("Y")."-06":
                echo "vars[5]=".$value->c.";";
                break;
            case date("Y")."-07":
                echo "vars[6]=".$value->c.";";
                break;
            case date("Y")."-08":
                echo "vars[7]=".$value->c.";";
                break;
            case date("Y")."-09":
                echo "vars[8]=".$value->c.";";
                break;
            case date("Y")."-10":
                echo "vars[9]=".$value->c.";";
                break;
            case date("Y")."-11":
                echo "vars[10]=".$value->c.";";
                break;
            case date("Y")."-12":
                echo "vars[11]=".$value->c.";";
                break;    
            
            default:
                # code...
                break;
        }
    ?>
<?php endforeach; ?>
<?php endif; ?>
<?php if(!empty($del)): ?>
<?php foreach($del as $value):
    $d = $value->cdate;
 ?>
    <?php 
        switch ($d) {
            case date("Y")."-01":
                    echo "vars1[0]=".$value->c.";";
                break;
            case date("Y")."-02":
                echo "vars1[1]=".$value->c.";";
                break;
            case date("Y")."-03":
                echo "vars1[2]=".$value->c.";";
                break;
            case date("Y")."-04":
                echo "vars1[3]=".$value->c.";";
                break;
            case date("Y")."-05":
                echo "vars1[4]=".$value->c.";";
                break;
            case date("Y")."-06":
                echo "vars1[5]=".$value->c.";";
                break;
            case date("Y")."-07":
                echo "vars1[6]=".$value->c.";";
                break;
            case date("Y")."-08":
                echo "vars1[7]=".$value->c.";";
                break;
            case date("Y")."-09":
                echo "vars1[8]=".$value->c.";";
                break;
            case date("Y")."-10":
                echo "vars1[9]=".$value->c.";";
                break;
            case date("Y")."-11":
                echo "vars1[10]=".$value->c.";";
                break;
            case date("Y")."-12":
                echo "vars1[11]=".$value->c.";";
                break;    
            
            default:
                # code...
                break;
        }
    ?>
<?php endforeach; ?>
<?php endif; ?>
<?php if(!empty($pur)): ?>
<?php foreach($pur as $value):
    $d = $value->cdate;
 ?>
    <?php 
        switch ($d) {
            case date("Y")."-01":
                    echo "vars2[0]=".$value->c.";";
                break;
            case date("Y")."-02":
                echo "vars2[1]=".$value->c.";";
                break;
            case date("Y")."-03":
                echo "vars2[2]=".$value->c.";";
                break;
            case date("Y")."-04":
                echo "vars2[3]=".$value->c.";";
                break;
            case date("Y")."-05":
                echo "vars2[4]=".$value->c.";";
                break;
            case date("Y")."-06":
                echo "vars2[5]=".$value->c.";";
                break;
            case date("Y")."-07":
                echo "vars2[6]=".$value->c.";";
                break;
            case date("Y")."-08":
                echo "vars2[7]=".$value->c.";";
                break;
            case date("Y")."-09":
                echo "vars2[8]=".$value->c.";";
                break;
            case date("Y")."-10":
                echo "vars2[9]=".$value->c.";";
                break;
            case date("Y")."-11":
                echo "vars2[10]=".$value->c.";";
                break;
            case date("Y")."-12":
                echo "vars2[11]=".$value->c.";";
                break;    
            
            default:
                # code...
                break;
        }
    ?>
<?php endforeach; ?>
<?php endif; ?>
<?php if(!empty($ret)): ?>
<?php foreach($ret as $value):
    $d = $value->cdate;
 ?>
    <?php 
        switch ($d) {
            case date("Y")."-01":
                    echo "vars3[0]=".$value->c.";";
                break;
            case date("Y")."-02":
                echo "vars3[1]=".$value->c.";";
                break;
            case date("Y")."-03":
                echo "vars3[2]=".$value->c.";";
                break;
            case date("Y")."-04":
                echo "vars3[3]=".$value->c.";";
                break;
            case date("Y")."-05":
                echo "vars3[4]=".$value->c.";";
                break;
            case date("Y")."-06":
                echo "vars3[5]=".$value->c.";";
                break;
            case date("Y")."-07":
                echo "vars3[6]=".$value->c.";";
                break;
            case date("Y")."-08":
                echo "vars3[7]=".$value->c.";";
                break;
            case date("Y")."-09":
                echo "vars3[8]=".$value->c.";";
                break;
            case date("Y")."-10":
                echo "vars3[9]=".$value->c.";";
                break;
            case date("Y")."-11":
                echo "vars3[10]=".$value->c.";";
                break;
            case date("Y")."-12":
                echo "vars3[11]=".$value->c.";";
                break;    
            
            default:
                # code...
                break;
        }
    ?>
<?php endforeach; ?>
<?php endif; ?>
</script>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
    </section>
    <section class="content">
        <div class="row">
           <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <div style="float: left;"><h4>1:1문의(미답변: <span class="text-danger text-bold"><?=$private_count?>건</span>)</h4></div>
                        <div style="float: right;"><a href="<?=base_url()?>panel?id=<?=$private_id?>">더보기</a></div>
                    </div>
                    <div class="body table-responsive no-padding" style="clear: both;">
                        <table class="table table-hover">
                            <tr class="thead-dark">
                                <th>작성자</th>
                                <th>제목</th>
                                <th>일자</th>
                            </tr>
                            <?php if(!empty($private)): ?>
                            <?php foreach($private as $va): ?>
                                <tr>
                                    <td><?=$va->UserName?></td>
                                    <td><a href="viewReq/<?=$va->id?>"><?=$va->title?></a></td>
                                    <td><?=$va->updated_date?></td>
                                </tr>
                            <?php endforeach;  ?>
                            <?php endif; ?>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <div><h4>금일 현황</h4></div>
                    </div>
                    <div class="body table-responsive no-padding">
                        <ul class="list-group">
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                배송대행 신청
                                <span class="badge badge-danger badge-pill">
                                    <a href="<?=base_url()?>dashboard?order_part=1" class="text-danger delivery">14건</a></span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                구매대행 신청
                                <span class="badge badge-danger badge-pill">
                                    <a href="<?=base_url()?>dashboard?order_part=2" class="text-danger pur">14건</a></span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                쇼핑몰 신청
                                <span class="badge badge-danger badge-pill">
                                    <a href="<?=base_url()?>dashboard?order_part=3" class="text-danger shopping">14건</a></span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                리턴대행 신청
                                <span class="badge badge-danger badge-pill">
                                    <a href="<?=base_url()?>dashboard?order_part=4" class="text-danger returning">14건</a></span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                주문 전체
                                <span class="badge badge-danger badge-pill">
                                    <a href="<?=base_url()?>dashboard" class="text-danger total">14건</a></span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div> 
        </div>
        <div class="row clearfix">
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h3>회원가입 통계(월별)</h3>
                    </div>
                    <div class="body">
                        <div id="line_register" class="graph"></div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h3>배송대행 신청 통계(월별)</h3>
                    </div>
                    <div class="body">
                        <canvas id="line_chart" height="150"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="row clearfix">
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h3>구매대행 신청 통계(월별)</h3>
                    </div>
                    <div class="body">
                        <canvas id="bar_chart" height="150"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h3>리턴 신청 통계(월별)</h3>
                    </div>
                    <div class="body">
                        <canvas id="bar_return" height="150"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<script src="<?php echo base_url(); ?>assets/plugins/chartjs/Chart.bundle.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/morrisjs/morris.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/raphael/raphael.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/chartjs.js"></script>
<script src="<?php echo base_url(); ?>assets/js/morris.js"></script>
<style>
    .badge{
        background-color: transparent;
    }
</style>