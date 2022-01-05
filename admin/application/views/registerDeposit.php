<?php $ss= 0;
if($pf==null) $ss = $uc;
if($pf!=null) $ss = $uc-$pf; ?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        예치금 신청관리
      </h1>
    </section>
    <section class="content">
        <input type="hidden" name="sKind" id="sKind">
        <div class="row">
            <div class="col-xs-12">

                <form  method="get" action="/admin/registerDeposit"> 
                  <div class="box-tools">
                    <div class="input-group">
                      <div class="pull-right">
                        <label style="display:block; ">&nbsp;</label>
                        <input class="btn btn-primary btn-sm" value="검색" type="submit">
                     </div> 
                     <div class="pull-right">
                       <label style="display:block; ">&nbsp;</label>
                        <input type="text" name="content"  class="form-control input-sm" style="width: 150px;" 
                        value="<?=empty($_GET['content']) == 0 ? $_GET['content']:""?>">
                     </div> 
                     <div class="pull-right">
                       <label style="display:block; ">검색항목</label>
                        <select class="form-control input-sm" style="width: 150px;" name="type">
                         <option value="">== 구분</option>                
                          <option value="loginId" <?=empty($_GET['type']) == 0 && $_GET['type'] =="loginId" ? "selected":"" ?>>아이디</option>
                          <option value="name" <?=empty($_GET['type']) == 0 && $_GET['type'] =="name" ? "selected":"" ?>>이름</option>                      
                          <option value="nickname" <?=empty($_GET['type']) == 0 && $_GET['type'] =="nickname" ? "selected":"" ?>>닉네임</option>
                       </select>
                     </div> 
                     <div class="pull-right">
                       <label style="display:block; ">상태</label>
                        <select class="form-control input-sm" style="width: 150px;" name="updated">
                         <option value="">전체</option>                
                          <option value="0" <?=$this->input->get("updated")==0 ? "selected":"" ?>>신청</option>
                          <option value="1" <?=empty($_GET['updated']) == 0 && $_GET['updated'] =="1" ? "selected":"" ?>>완료</option>                      
                          <option value="2" <?=empty($_GET['updated']) == 0 && $_GET['updated'] =="2" ? "selected":"" ?>>취소</option>
                       </select>
                     </div> 
                     <div class="pull-right">
                       <label style="display:block; ">종료일</label>
                        <input type="date" name="end_date"  class="form-control input-sm" style="width: 150px;" 
                        value="<?=empty($_GET['end_date']) ==0 ? $_GET['end_date']:""?>" >
                     </div> 
                     <div class="pull-right">
                       <label style="display:block; ">시작일</label>
                        <input type="date" name="start_date"  class="form-control input-sm" style="width: 150px;" 
                        value="<?=empty($_GET['start_date']) == 0 ? $_GET['start_date']:"" ?>" >
                     </div> 
                     <div class="pull-right">
                       <label style="display:block; ">Page</label>
                        <select name="shPageSize" class="form-control input-sm">
                          <?php for($ii = 10 ;$ii<=100;$ii+=5){ ?>
                            <option value="<?=$ii?>" <?=empty($_GET['shPageSize'])==0 && $_GET['shPageSize']==$ii ? "selected":"" ?>><?=$ii?></option>
                          <?php }  ?>
                        </select>
                     </div> 
                    </div>
                  </div>
                </form>
                <form name="frmSearch" id="frmSearch" method="post" action="<?=base_url()?>registerDeposit"> 
                  <input type="hidden" name="userids" id="userids">
                  <div class="box-body table-responsive no-padding">
                    <table class="table table-hover">
                      <tr>
                        <th><input type="checkbox" name="chkReqSeqAll" id="chkReqSeqAll" value="Y" onclick="fnCkBoxAllSel( 'frmSearch', 'chkReqSeqAll', 'chkReqSeq' );">Id</th>
                        <th>회원명(아이디)</th>
                        <th>입금일자</th>
                        <th>입금자명 </th>
                        <th>입금계좌 </th>
                        <th>금액</th>
                        <th>구분</th>
                        <th>상태</th>
                      </tr>
                      <?php
                      if(!empty($deposit))
                      {
                          foreach($deposit as $record)
                          {
                      ?>
                      <tr>
                        <td>
                          <?php if($record->updated==0): ?><input type="checkbox" class="chkReqSeq" 
                          name="chkReqSeq[]"  value="<?=$record->id?>" data-userid='<?=$record->userId?>'><?php endif; ?>
                          <?=$ss ?></td>
                        <td><?=$record->name?>(<?=$record->loginId?>)</td>
                        <td><?=$record->update_date ?></td>
                        <td><?=$record->name?></td>
                        <td><?=$record->Bname?> <?=$record->bank?> <?=$record->number?></td>
                        <td><?=$record->amount?></td>
                        <td><?=$record->type==1 ? "예치금 적립":"예치금 환금"?></td>
                        <td><?php if($record->updated==1) echo '완료';
                                  if($record->updated==0) echo '신청';
                                  if($record->updated==2) echo '취소';?></td>
                      </tr>
                      <?php
                        $ss = $ss-1;
                          }
                      }
                      ?>
                    </table>
                      <div class="col-xs-2">
                        <div class="form-group">
                          <select class="form-control" name="sStat" id="sStat">
                            <option value="1">완료</option>
                            <option value="2">취소</option>
                          </select>
                        </div>
                      </div>
                      <div class="col-xs-2">
                        <div class="form-group">
                          <button type="button" class="txt btn btn-primary" onclick="fnDpstReqChk();">변경</button>
                        </div>
                      </div>
                  </div><!-- /.box-body -->
                </form>
                <div class="box-footer clearfix">
                  <?php echo $this->pagination->create_links(); ?>
                </div>

            </div>
        </div>
        
    </section>
</div>

<script>
$(document).on("change", ".chkReqSeq", function () {
  var userids = "";
  $(".chkReqSeq").each(function(){
    if($(this).is(':checked'))
      userids =userids+$(this).data("userid")+",";
  })
  $("#userids").val(userids);
})
function fnDpstReqChk() {
  var frmObj = "#frmSearch";
  if ($("#sStat").val()==""){
    alert('변경할 상태를 선택하십시오.');
    return;
  }
  if (fnSelBoxCnt($(frmObj + " input[class='chkReqSeq']")) <= 0) {
    alert('변경할 예치금 내역을 선택하십시오.');
    return;
  }
 
  
  if (confirm('선택된 예치금 내역을 변경하시겠습니까?')) {
    $("#sKind").val("M");
    $("#frmSearch").attr("method", "post").attr("action", "/admin/updateDeposit");
    $("#frmSearch").submit();
  }
}


</script>