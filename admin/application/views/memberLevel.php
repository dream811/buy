
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
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="role">회원등급명</label>
                                        <input type="text" class="form-control required" id="role" name="role"  required>
                                        <input type="hidden" name="roleId" value="0">
                                    </div>
                                    
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="sending_times">배송건수</label>
                                        <input type="number" class="form-control " id="sending_times"  name="sending_times" placeholder="0">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="sending_times">&nbsp;</label>
                                        <input type="number" class="form-control " id="sending_times1"  name="sending_times1" placeholder="100">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="sending_inul">배송할인율(%)</label>
                                        <input type="text" class="form-control" id="sending_inul"  name="sending_inul"  required placeholder="%" value="0">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="buy_fee">구매수수료율(%)</label>
                                        <input type="text" class="form-control" id="buy_fee" name="buy_fee"  required placeholder="%" value="0">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="coupon_gold">쿠폰 금액</label>
                                        <input type="text" class="form-control" id="coupon_gold"  name="coupon_gold" value="0">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="point_acceptRate">포인트 적립율(%)</label>
                                        <input type="text" class="form-control " id="point_acceptRate" name="point_acceptRate" placeholder="%" value="0">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="recomman">추천인 적립율(%)</label>
                                        <input type="text" class="form-control" id="recomman"  name="recomman" placeholder="%" value="0">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="use">사용유무</label>
                                        <select class="form-control" name="use">
                                            <option value="1">사용</option>
                                            <option value="0">사용안함</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="coupon_type">등업쿠폰 타입 </label>
                                        <select class="form-control" id="coupon_type" name="coupon_type">
                                            <option value="0">￦</option> 
                                            <option value="1">$</option>                                              
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="level">등급수준</label>
                                        <input type="number" class="form-control" name="level" placeholder="10">
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
                                    <input type="text" class="form-control required" name="address_rate[]" required value="1">
                                </div>
                                
                            </div>
                        </div>
                        <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </form>
        </div>
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-primary">
                    <div class="box-body">
                        <div class="box-body table-responsive no-padding">
                            <table class="table table-hover">
                                <tr class="thead-dark">
                                    <th>아이디</th>
                                    <th>회원등급명 </th>
                                    <th>배송건수</th>
                                    <th>등업쿠폰</th>
                                    <th>배송비할인</th>
                                    <th>구매수수료</th>
                                    <th>포인트적립</th>
                                    <th>추천인적립</th>
                                    <th>사용유무</th>
                                    <th>등급수준</th>
                                    <th>수정/삭제</th>
                                </tr>
                                <?php
                                if(!empty($man))
                                {
                                    foreach($man as $record)
                                    {
                                ?>
                                <tr>
                                    <td><?=$record->roleId?></td>
                                    <td><?php echo $record->role ?></td>
                                    <td><?php echo $record->sending_times ?> | <?php echo $record->sending_times1 ?></td>
                                    <td><?php echo $record->coupon_type ?></td>
                                    <td><?php echo $record->sending_inul ?></td>
                                    <td><?php echo $record->buy_fee ?></td>
                                    <td><?php echo $record->point_acceptRate ?></td>
                                    <td><?php echo $record->recomman ?></td>
                                    <td><?php echo $record->use ?></td>
                                    <td><?php echo $record->level ?></td>
                                    <td class="text-center">
                                        <a class="btn btn-sm btn-info <?=$record->level==1 ? "disabled":""?>" href="<?php echo base_url().'editmemberL/'.$record->roleId; ?>"><i class="fa fa-pencil"></i></a>  
                                        <a class="btn btn-sm btn-danger deleteUser <?=$record->level==1 || $record->roleId ==3 ? "disabled":""?>" href="#" data-userid="<?php echo $record->roleId; ?>"><i class="fa fa-trash"></i></a>
                                    </td>
                                </tr>
                                <?php
                                    }
                                }
                                ?>
                            </table>              
                        </div>
                </div> 
                </div> 
            </div>
        </div>  
    </section>
    
</div>