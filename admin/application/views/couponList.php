<?php $ss= 0;
if($pf==null) $ss = $uc;
if($pf!=null) $ss = $uc-$pf; ?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        쿠폰발급내용
      </h1>
    </section>
    <section class="content">
      <form name="frmSearch" id="frmSearch" method="get" action=""> 
        <input type="hidden" name="chkMemCode">
        <div class="row">
            <div class="col-xs-12">
              <div class="box">
                <div class="box-tools">
                    <div class="input-group" style="margin-bottom: 10px">
                      <div class="pull-right">
                        <label style="display: block;">&nbsp;</label>
                        <input class="btn btn-primary btn-sm" value="검색" type="submit">
                     </div> 
                     <div class="pull-right">
                        <label>검색어</label>
                        <input type="text" name="seach_input"  class="form-control input-sm" 
                        value="<?=empty($_GET['seach_input']) == 0 ? $_GET['seach_input']:"" ?>">
                     </div> 
                     <div class="pull-right">
                        <label>검색항목</label>
                        <select name="shType" id="shType" class="form-control input-sm">
                          <option value="">=== 전체 ===</option>
                          <option value="code"   <?=empty($_GET['shType']) == 0 && $_GET['shType']=="code" ? "selected":"" ?>>쿠폰코드</option>
                          <option value="name"   <?=empty($_GET['shType']) == 0 && $_GET['shType']=="name" ? "selected":"" ?>>회원명</option>
                        </select>
                     </div>
                     <div class="pull-right">
                        <label>사용여부</label>
                        <select name="shUsedYn" id="shUsedYn" class="form-control input-sm">
                          <option value="">=== 전체 ===</option>
                          <option value="Y"   <?=empty($_GET['shUsedYn']) == 0 && $_GET['shUsedYn']=="Y" ? "selected":"" ?>>사용</option>
                          <option value="N"   <?=empty($_GET['shUsedYn']) == 0 && $_GET['shUsedYn']=="N" ? "selected":"" ?>>미사용</option>
                        </select>
                     </div> 
                     <div class="pull-right">
                        <label>종료일</label>
                        <input type="date" name="ends_date"  class="form-control input-sm"
                        value="<?=empty($_GET['ends_date']) == 0 ? $_GET['ends_date']:"" ?>">
                     </div> 
                     <div class="pull-right">
                        <label>시작일</label>
                        <input type="date" name="starts_date"  class="form-control input-sm"
                        value="<?=empty($_GET['starts_date']) == 0 ? $_GET['starts_date']:"" ?>">
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
                </div>
                <div class="box-body table-responsive no-padding">
                  <table class="table table-hover">
                    <tr class="thead-dark">
                      <th><input type="checkbox" class="input_chk" title="선택" name="CpnCode_All" id="CpnCode_All" value="total" onclick="fnChkBoxTotal(this, 'dddfdf');">No</th>
                      <th>쿠폰종류</th>
                      <th>쿠폰코드</th>
                      <th>할인</th>
                      <th>유효기간</th>
                      <th>사용회원</th>
                      <th>발급일</th>
                      <th>발급여부</th>
                      <th>사용여부</th>
                    </tr>
                    <?php
                    if(!empty($couponList))
                    {
                        foreach($couponList as $record)
                        {
                    ?>
                    <tr>
                      <td><input type="checkbox" name="dddfdf" class="chkCpnCode" value="<?=$record->id ?>"><?=$ss ?></td>
                      <td><?=$record->content?><br><?=$record->event==0 ? "관리자 발행 쿠폰":"이벤트 쿠폰"?></td>
                      <td><?=$record->code?></td>
                      <td><?=$record->gold?><?=$record->gold_type==1 ?"원":"%"?></td>
                      <td><?=$record->event==0 ? $record->terms : date("Y-m-d")."|".date("Y-m-d", strtotime($record->byd))?></td>
                      <td><?=$record->loginId?>(<?=$record->nickname?>)</td>
                      <td><?=$record->created_date?></td>
                      <td>발급받음</td>
                      <td>
                        <?php if($record->event==0):?>
                          <?php $dd = explode("|",$record->terms); ?>
                          <?php $dd1 = $dd[0]; ?>
                          <?php $dd2 = $dd[1]; ?>
                        <?php endif; ?>
                        <?php if($record->event==1):?>
                          <?php $dd1 = date("Y-m-d"); ?>
                          <?php $dd2 = date("Y-m-d", strtotime($record->byd)); ?>
                        <?php endif; ?>
                          <?php if(date("Y-m-d") >=$dd1 && date("Y-m-d")<=$dd2 && $record->used==0): ?>
                          사용가능<br>미사용
                          <?php endif;?>
                          <?php if(date("Y-m-d") >=$dd1 && date("Y-m-d")<=$dd2 && $record->used==1): ?>
                          사용불가<br>사용
                          <?php endif;?>
                          <?php if(date("Y-m-d") > $dd2 && $record->used==0): ?>
                            사용불가(기간만료)<br>미사용
                          <?php endif;?>
                      </td>
                    </tr>
                    <?php
                      $ss = $ss-1;
                        }
                    }
                    ?>
                  </table>
                </div><!-- /.box-body -->
                <?php echo $this->pagination->create_links(); ?>
              </div><!-- /.box -->
            </div>
            <div class="col-xs-12">
              <a href="javascript:void(0);" onclick="fnCpnInfChk();" class="btn btn-danger">삭제</a>
            </div>
        </div>        
      </form> 
    </section>
</div>

<script>
  function fnCpnInfChk(){
    var frmObj = "#frmSearch";
    if (fnSelBoxCnt($(frmObj + " input[class='chkCpnCode']")) <= 0) {
      alert('삭제할 쿠폰을 선택하십시오.');
      return;
    }
    if ( confirm("선택 쿠폰을 삭제하시겠습니까?") ) {
      $("#frmSearch" + " input[name='chkMemCode']").val( fnGetChkboxValue($("#frmSearch").find(".chkCpnCode")) );
      $("#frmSearch").attr("method", "post").attr("action", "/admin/deleteCoupon");
      $("#frmSearch").submit();
    }
  } 
</script>