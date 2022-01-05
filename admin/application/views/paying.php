<?php $ss= 0;
if($pf==null) $ss = $uc;
if($pf!=null) $ss = $uc-$pf; ?>
<div class="content-wrapper">
    <section class="content-header">
      <h1>
        결제내역
      </h1>
    </section>
    <section class="content">
      <form method="get" accept="">
        <div class="row">
          <div class="col-xs-12">
            <div class="box-tools">
              <div class="input-group">
                <div class="pull-right">
                  <label style="display:block; ">&nbsp;</label>
                  <input class="btn btn-primary" value="검색" type="submit">
               </div> 
                <div class="pull-right">
                   <label style="display: block;">검색항목</label>
                   <input type="text" name="search_txt" class="form-control" 
                   value="<?=empty($_GET['search_txt']) == 0 ? $_GET['search_txt']:"" ?>" >
                 </div>
                <div class="pull-right">
                   <label style="display: block;">회원등급</label>
                   <select class="form-control" style="width: 150px;" name="member_part">             
                      <option value="name" <?=empty($_GET['member_part']) == 0 && $_GET['member_part'] =="name" ? "selected":"" ?>>회원명</option>
                      <option value="loginId" <?=empty($_GET['member_part']) == 0 && $_GET['member_part'] =="loginId" ? "selected":"" ?>>아이디</option>
                      <option value="nickname" <?=empty($_GET['member_part']) == 0 && $_GET['member_part'] =="nickname" ? "selected":"" ?>>닉네임</option>
                      <option value="userId" <?=empty($_GET['member_part']) == 0 && $_GET['member_part'] =="userId" ? "selected":"" ?>>회원코드</option>
                   </select>
                 </div>
                 <div class="pull-right">
                   <label style="display: block;">결제여부</label>
                   <select class="form-control" style="width: 150px;" name="pay_parts">
                      <option value="">선택</option>
                      <option value="0" <?=empty($_GET['pay_parts']) == 0 && $_GET['pay_parts']==0 ? "selected":"" ?>>결제완료</option>
                      <option value="1" <?=empty($_GET['pay_parts']) == 0 && $_GET['pay_parts']==1 ? "selected":"" ?>>입금대기중</option>
                   </select>
                 </div>
                 <div class="pull-right">
                   <label style="display: block;">종료일</label>
                   <input type="date" name="ends_date" class="form-control" 
                   value="<?=empty($_GET['ends_date']) == 0 ? $_GET['ends_date']:"" ?>">
                 </div>
                 <div class="pull-right">
                   <label style="display: block;">시작일</label>
                   <input type="date" name="starts_date" class="form-control" 
                   value="<?=empty($_GET['starts_date']) == 0 ? $_GET['starts_date']:"" ?>" >
                 </div>
                 <?php //echo $allRecords; ?>
                 <input type="hidden" name="coming_order">
                 <div class="pull-right">
                   <label style="display: block;">타입</label>
                   <select class="form-control" style="width: 150px;" name="type_parts">
                      <option value="">전체</option>               
                      <option value="buy" <?=!empty($_GET['type_parts'])  && $_GET['type_parts']=="buy" ? "selected":"" ?>>구매비용</option>
                      <option value="delivery" <?=!empty($_GET['type_parts'])  && $_GET['type_parts']=="delivery" ? "selected":"" ?>>베송비용</option>
                      <option value="return" <?=!empty($_GET['type_parts'])  && $_GET['type_parts']=="return" ? "selected":"" ?>>리턴비용</option>
                   </select>
                 </div>
                 <div class="pull-right">
                   <label style="display: block;">구분</label>
                   <select class="form-control" style="width: 150px;" name="deposit_part">
                      <option value="">전체</option>                
                      <option value="4" <?=empty($_GET['deposit_part']) == 0 && $_GET['deposit_part']==4 ? "selected":"" ?>>무통장 입금</option>
                      <option value="5" <?=empty($_GET['deposit_part']) == 0 && $_GET['deposit_part']==5 ? "selected":"" ?>>예치금 전액 결제</option>
                   </select>
                 </div>
                 <div class="pull-right">
                   <label style="display: block;">Page</label>
                   <select name="shPageSize" id="shPageSize" class="form-control">
                      <?php for($ii = 10 ;$ii<=100;$ii+=5){ ?>
                        <option value="<?=$ii?>" <?=empty($_GET['shPageSize'])==0 && $_GET['shPageSize']==$ii ? "selected":"" ?>><?=$ii?></option>
                      <?php }  ?>
                    </select>
                 </div>
              </div>
            </div>
          </div>
        </div>
      </form>
        <div class="row">
            <div class="col-xs-12">
                <div class="box-body table-responsive no-padding">
                  <table class="table table-hover">
                    <tr class="thead-dark">
                      <th>No.</th>
                      <th>회원명</th>
                      <th>결제총금액</th>
                      <th>예치금</th>
                      <th>포인트</th>
                      <th>쿠폰</th>
                      <th>결제구분</th>
                      <th>미결제금액</th>
                      <th>처리일자</th>
                      <th>결제내역</th>
                      <th></th>
                    </tr>
                    <?php if(!empty($data)): ?>
                      <?php foreach($data as $value): ?>
                        <tr>
                          <td><?=$ss?></td>
                          <td><?=$value['login']?><br><?=$value['name']?></td>
                          <td><?=$value['all_amount']?></td>
                          <td><?=$value['amount']?></td>
                          <td><?=$value['point']?></td>
                          <td>
                            <?php if(!empty($value['coupon_type'])): ?>
                            <?php $coupons = json_decode($value['coupon_type']); ?>
                            <?php if(!empty($coupons)):?>
                            <?php foreach($coupons as $key=>$cou): ?>
                             <?=!empty(COUPON[$key-1]) ? COUPON[$key-1]." ".explode("|", $cou)[0]."원" : ""?> 
                            <?php endforeach; ?>
                            <?php endif; ?>  
                            <?php endif; ?>  
                            </td>
                          <td><?php 
                              if($value['type']==4) echo '무통장 입금';
                              if($value['type']==1) echo '신용카드/체크카드';
                              if($value['type']==5 && $value['by']!=1) echo '예치금 전액 결제';
                              if($value['type']==5 && $value['by']==1) echo '관리자 예치금 전액 결제';?>
                          </td>
                          <td>
                            <span style="color: red"><?=$value['pending'] ==1 ? $value['pamount']:0?></span>원
                            <?php if($value['pending'] ==2): ?>(관리자 결제 취소)<?php endif; ?>
                          </td>
                          <td><?=$value['update']?></td>
                          <td><?php if(!empty($orderr[$value['security']])): ?>
                              <?php foreach($orderr[$value['security']] as $valuep): ?>
                                주문번호:
                                <a href="javascript:fnOrdPopV(<?=$valuep['delivery_id']?>);"><span class="bold"><?=$valuep['order']?></span> <?=$valuep['label']?>: <?=$valuep['amount']?>원</a><br>
                              <?php endforeach; ?>
                            <?php endif; ?></td>
                          <td>
                            <?php if($value['pending'] == 1 || $value['pending'] == 2): ?>
                              <button onclick="verifyDeposit('<?=$value["security"]?>',<?=$value["userId"]?>,this)" 
                                class="btn btn-sm btn-primary <?php if($value['pending'] ==2): ?>disabled<?php endif; ?>" 
                                data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> 처리중">입금확인</button>
                            <?php endif; ?>
                            <?php if($value['pending'] == 0 && $value['state']!=23 || $value['type']==4 && $value['pending']==1): ?>
                              <button onclick="cancelDeposit('<?=$value["security"]?>',<?=$value['type']?>,this)" class="btn btn-sm btn-danger" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> 처리중">결제취소</button>
                            <?php endif; ?>
                            
                          </td>
                        </tr>
                        <?php $ss = $ss-1; ?>
                      <?php endforeach; ?>
                    <?php endif; ?>
                  </table>
                </div><!-- /.box-body -->
                <div class="box-footer">
                  <?php echo $this->pagination->create_links(); ?>
                </div>
            </div>
        </div>
    </section>
</div>
<script>
  function verifyDeposit(id,userId,obj){
    var checked = 0;
    var btn = $(obj);
    hitURL = baseURL + "verifyDeposit";
    jQuery.ajax({
      type : "POST",
      url : baseURL + "getDeliveryBySecurity",
      data : { security : id}       
      }).done(function(data){
        var con = confirm("변경할 주문은 "+ data.trim() + "입니다");
        if(!con) return false;
        jQuery.ajax({
        type : "POST",
        url : hitURL,
        data : { security : id,userId:userId},
        beforeSend: function() {
          btn.button("loading")
        }         
        }).done(function(data){
          window.location.reload();
        });
    }).fail(function(xhr){
      console.log(xhr)
    });
  }
  function cancelDeposit(id,type,obj){
    var checked = 0;
    var btn = $(obj);
    hitURL = baseURL + "cancelDeposit";
    jQuery.ajax({
      type : "POST",
      url : baseURL + "getDeliveryBySecurity",
      data : { security : id}      
      }).done(function(data){
        var con = confirm("변경할 주문은 "+ data.trim() + "입니다");
        if(!con) return false;
        jQuery.ajax({
        type : "POST",
        url : hitURL,
        data : { security : id,type:type},
        beforeSend: function() {
          btn.button("loading")
        }
        }).done(function(data){
          window.location.reload();
      }).fali(function(xhr){
        console.log(xhr)
      });
    });
  }
</script>
