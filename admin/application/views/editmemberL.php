<?php 
var_dump($role[0]->address_rate);
$address = (array)json_decode($role[0]->address_rate);
?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        회원등급관리
      </h1>
    </section>
    
    <section class="content">
    
        <div class="row">
            <form role="form" id="addUser" action="<?php echo base_url() ?>saveMemberLevel" method="post" role="form">
                <!-- left column -->
                <div class="col-md-8">
                  <!-- general form elements -->
                    <div class="box box-primary">                    
                        
                            <input type="hidden" name="roleId" value="<?=$role[0]->roleId?>">
                            <div class="box-body">
                                <div class="row">
                                    <div class="col-md-6">                                
                                        <div class="form-group">
                                            <label for="role">회원등급명</label>
                                            <input type="text" class="form-control" id="role" name="role" required 
                                            value="<?=$role[0]->role?>">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="sending_times">배송건수</label>
                                            <input type="text" class="form-control " id="sending_times"  name="sending_times" 
                                            value="<?=$role[0]->sending_times?>">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="sending_times">&nbsp;</label>
                                            <input type="text" class="form-control " id="sending_times"  name="sending_times1" 
                                            value="<?=$role[0]->sending_times1?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="sending_inul">배송할인율</label>
                                            <input type="text" class="form-control" id="sending_inul"  name="sending_inul"  
                                            required value="<?=$role[0]->sending_inul?>">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="buy_fee">구매수수료율</label>
                                            <input type="text" class="form-control" id="buy_fee" name="buy_fee"  
                                            value="<?=$role[0]->buy_fee?>" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="coupon_gold">쿠폰 금액 </label>
                                            <input type="text" class="form-control" id="coupon_gold"  name="coupon_gold" 
                                            value="<?=$role[0]->coupon_gold?>">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="point_acceptRate">포인트 적립율  </label>
                                            <input type="text" class="form-control " id="point_acceptRate" 
                                            name="point_acceptRate" value="<?=$role[0]->point_acceptRate?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="recomman">추천인 적립율</label>
                                            <input type="text" class="form-control" id="recomman"  name="recomman" 
                                            value="<?=$role[0]->recomman?>">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="use">사용유무</label>
                                            <select class="form-control" name="use">
                                                <option value="1"  <?php if($role[0]->use ==1) echo 'selected'; ?> >사용</option>
                                                <option value="0"  <?php if($role[0]->use ==0) echo 'selected'; ?>>사용안함</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="coupon_type">등업쿠폰 타입 </label>
                                            <select class="form-control" id="coupon_type" name="coupon_type">
                                                <option value="0" <?php if($role[0]->coupon_type ==0) echo 'selected'; ?>>￦</option> 
                                                <option value="1" <?php if($role[0]->coupon_type ==1) echo 'selected'; ?>>$</option>
                                            </select>
                                        </div>
                                    </div> 
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="point_acceptRate">등급수준 </label>
                                            <input type="number" class="form-control" name="level" value="<?=$role[0]->level?>">
                                        </div>
                                    </div>  
                                </div>
                            </div><!-- /.box-body -->
                            <div class="box-footer">
                                <input type="submit" class="btn btn-primary" value="저장" />
                                <input type="reset" class="btn btn-default" value="취소" />
                            </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="box-body">
                        <?php if(!empty($deliveryAddress)): ?>
                        <?php foreach($deliveryAddress as $d_index): ?>
                        <div class="row">
                            <div class="col-md-6">                                
                                <div class="form-group">
                                    <label for="role"><?=$d_index->area_name?>(배송할인율)</label>
                                    <input type="text" class="form-control required" name="address_rate[]" required 
                                    value="<?=isset($address[$d_index->id]) ? $address[$d_index->id]:1?>">
                                </div>
                                
                            </div>
                        </div>
                        <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </form>    
        </div>
    </section>
</div>        