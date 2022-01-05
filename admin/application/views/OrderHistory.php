<?php 
  $tt = is_null($csc) ? $csc:$csc-$seg;
  $amount1 = 0; 

?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        주문별통계
      </h1>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
              <div class="box">
                <div class="box-body table-responsive no-padding">
                  <table class="table table-hover">
                    <tr class="thead-dark">
                      <th>배송구분</th>
                      <th>금액</th>
                      <th>주문건수</th>
                    </tr>
                    <tr>
                      <th>배송대행</th>
                      <th><?=number_format($OrderHistory1[0]->A)?>원</th>
                      <th><?=$OrderHistory1[0]->AA?>건</th>
                    </tr>
                    <tr>
                      <th>구매대행</th>
                      <th><?=number_format($OrderHistory1[0]->B)?>원</th>
                      <th><?=$OrderHistory1[0]->BB?>건</th>
                    </tr>
                    <tr>
                      <th>리턴대행</th>
                      <th><?=number_format($OrderHistory1[0]->C)?>원</th>
                      <th><?=$OrderHistory1[0]->CC?>건</th>
                    </tr>
                    <tr>
                      <th>쇼핑몰</th>
                      <th><?=number_format($OrderHistory1[0]->F)?>원</th>
                      <th><?=$OrderHistory1[0]->FF?>건</th>
                    </tr>
                  </table>
                  
                </div><!-- /.box-body -->
              </div><!-- /.box -->
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
              <div class="box-tools">   
                  <form method="get" action="<?=base_url()?>pay_order">
                    <div class="input-group" style="margin-bottom: 10px">
                      <div class="pull-right">
                        <label style="display: block;">......</label>
                        <input class="btn btn-primary btn-sm" value="검색" type="submit">
                     </div> 
                     <div class="pull-right">
                       <label style="display: block;">종료일</label>
                       <input type="date" name="ends_date" class="form-control input-sm" 
                       value="<?=empty($_GET['ends_date']) == 0 ? $_GET['ends_date']:"" ?>" 
                       >
                     </div>
                     <div class="pull-right">
                       <label style="display: block;">시작일</label>
                       <input type="date" name="starts_date" class="form-control input-sm" 
                       value="<?=empty($_GET['starts_date']) == 0 ? $_GET['starts_date']:"" ?>" 
                        >
                     </div>
                     <div class="pull-right">
                       <label style="display: block;">Page</label>
                       <select name="shPageSize" id="shPageSize" class="form-control input-sm">
                          <?php for($ii = 10 ;$ii<=100;$ii+=5){ ?>
                            <option value="<?=$ii?>" <?=empty($_GET['shPageSize'])==0 && $_GET['shPageSize']==$ii ? "selected":"" ?>><?=$ii?></option>
                          <?php }  ?>
                        </select>
                     </div>
                   </div>
                 </form>
              </div>
              <div class="box">
                <div class="box-body table-responsive no-padding">
                  <table class="table table-hover">
                    <tr class="thead-dark">
                      <th>No</th>
                      <th>주문번호<br>구분</th>
                      <th>회원명<br>수취인</th>
                      <th>통합/나눔 </th>
                      <th>배송<br>구분</th>
                      <th>수량<br>총액</th>
                      <th>결제금액</th>
                      <th>운송장번호</th>
                      <th>수정일</th>
                    </tr>
                    <?php if(!empty($payHistory)): ?>
                      <?php foreach($payHistory as $value): ?>
                        <tr>
                          <td><?=$tt?></td>
                          <td><?=$value->ordernum?><br>
                            <?php if($value->dtype==1) echo '배송대행';
                                  if($value->dtype==2) echo '구매대행';
                                  if($value->dtype==4) echo '리턴대행';
                                  if($value->dtype==3) echo '쇼핑몰';  ?></td>
                          <td><?=$value->name?><br><?=$value->billing_krname?></td>
                          <td>
                            <?php if($value->combine == 1): ?>통합<?php endif; ?>
                            <?php if($value->combine == 2): ?>나눔<?php endif; ?>
                          </td>
                          <td><?=$value->Pcount > 1 ? "합배송":"단독배송"?><br>구분</td>
                          <td><?=$value->Pcount?><br><?=number_format($value->PSum)?></td>
                          <td class="mid"><a href="javascript:fnChaView(<?=$value->did?>);">
                          <?php if($value->sending_price > 0 && $value->dtype ==1): ?>
                            <strong><?php if($value->payed_send==0) 
                            echo '배송비용(미입금)';else echo '배송비용(완료)'; ?></strong>
                            <?=number_format(str_replace(",", "", $value->sending_price))?>원</a>
                          <?php endif; ?>
                          <?php if($value->purchase_price > 0 && $value->dtype ==2): ?>
                            <br><strong><?php if($value->payed_checked==0) 
                            echo '구매비용(미입금)';else echo '구매비용(완료)'; ?></strong>
                            <?=number_format($value->purchase_price)?>원</a>
                          <?php endif; ?>
                           <?php if($value->purchase_price > 0 && $value->dtype ==3): ?>
                            <br><strong>
                              <?php if($value->payed_checked==0) echo '쇼핑몰(미입금)';else echo '쇼핑몰(완료)'; ?>
                              </strong><?=number_format($value->purchase_price)?>원</a>
                          <?php endif; ?>
                          <?php if($value->return_price > 0): ?>
                            <br><strong><?php if($value->return_check==0) 
                            echo '리턴비용(미입금)';else echo '리턴비용(완료)'; ?></strong>
                            <?=number_format($value->return_price)?>원</a>
                          <?php endif; ?>
                          <?php if($value->add_check == 1): ?>
                            <br>
                            추가결제비용(미입금)<?=number_format($value->add_price)?>원
                          <?php endif; ?>
                          <?php if($value->add_check == 0 && $value->add_check !=NULL ): ?>
                            <br>
                            추가결제비용(입금완료)<?=number_format($value->add_price)?>원
                          <?php endif; ?>
                          <?php if($value->add_check == 2): ?>
                            <br>
                            추가결제비용(무통장 입금대기)<?=number_format($value->add_price)?>원
                          <?php endif; ?>
                          <?php if($value->add_check == 3): ?>
                            <br>
                            추가결제비용(관리자 결제취소)<?=number_format($value->add_price)?>원
                          <?php endif; ?></a>

                        </td>
                          <td><?=$value->tracking_number?></td>
                          <td><?=$value->Udate?></td>
                        </tr>
                        <?php $tt = $tt-1; ?>
                      <?php endforeach; ?>
                    <?php endif; ?>
                  </table>
                </div><!-- /.box-body -->
                <div class="box-footer clearfix">
                  <?php echo $this->pagination->create_links(); ?>
                </div>
              </div><!-- /.box -->
            </div>
        </div>
    </section>
</div>
<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" id="details_modal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">결제내역상세</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
       <div class="modal-body">
      </div>
    </div>
  </div>
</div>
<script>
  function fnChaView(id){

    jQuery.ajax({
      type : "POST",
      url : baseURL+"getDelivery",
      data : { delivery_id : id } 
      }).done(function(data){
        $("#details_modal").modal("show");
        $("#details_modal .modal-body").html(data);
    });
  }
</script>