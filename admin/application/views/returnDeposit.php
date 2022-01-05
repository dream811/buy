<?php $ss= 0;
if($pf==null) $ss = $uc;
if($pf!=null) $ss = $uc-$pf; ?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        예치금환급요청
      </h1>
    </section>
    <section class="content">
        <div class="row">
          <div class="col-xs-12">
            <form  method="get" action="/admin/returnDeposit">
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
                <select class="form-control input-sm" style="width: 150px;" name="state">
                  <option value="">전체</option>
                  <option value="0" <?=$this->input->get("state") =="0" ? "selected":"" ?>>신청</option>
                  <option value="1" <?=empty($_GET['state']) == 0 && $_GET['state'] =="1" ? "selected":"" ?>>완료</option>
                  <option value="2" <?=empty($_GET['state']) == 0 && $_GET['state'] =="2" ? "selected":"" ?>>취소</option>
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
            </form>
          </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
              <div class="box">
                <form name="frmSearch" id="frmSearch" method="post" action=""> 
                  <input type="hidden" name="sKind" id="sKind">
                  <div class="box-body table-responsive no-padding">
                    <table class="table table-hover">
                      <tr>
                        <th><input type="checkbox" name="chkReqSeqAll" class="chkReqSeqAll" value="Y" onclick="fnCkBoxAllSel( 'frmSearch', 'chkReqSeqAll', 'chkReqSeq' );">Id</th>
                        <th>회원명(아이디)</th>
                        <th>신청일</th>
                        <th>예금주</th>
                        <th>은행명 및 계좌번호 </th>
                        <th>금액</th>
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
                          <?php if($record->updated !=1): ?> 
                             <input type="checkbox" name="chkReqSeq[]"  value="<?=$record->id?>" class="chkReqSeq">
                          <?php endif; ?>
                          <?=$ss?>
                        </td>
                        <td><?=$record->Uname?>(<?=$record->userId?>)</td>
                        <td><?=$record->updated_date?></td>
                        <td><?=$record->owner?></td>
                        <td><?=$record->bank_name?> <?=$record->bank_number?></td>
                        <td><?=$record->amount?></td>
                        <td><?php 
                              if($record->accept==0) echo '미정';
                              if($record->accept==1) echo '승인';
                              if($record->accept==2) echo '거절';?>
                        </td>
                      </tr>
                      <?php
                        $ss = $ss-1;
                        }
                      }
                      ?>
                    </table>
                  </div><!-- /.box-body -->
                  <div class="row">
                    <div class="col-xs-2">
                      <div class="form-group">
                        <select class="form-control" name="sStat" id="sStat" style="margin-left: 20px ">
                          <option value="1">승인</option>
                          <option value="2">거절</option>
                        </select>
                      </div>
                    </div>
                    <div class="col-xs-2">
                      <div class="form-group">
                        <button type="button" class="txt btn btn-primary" onclick="fnDpstReqChk();">변경</button>
                      </div>
                    </div>
                  </div>
                </form>
                <div class="box-footer clearfix">
                  <?php echo $this->pagination->create_links(); ?>
                </div>
              </div><!-- /.box -->
            </div>
        </div>
    </section>
</div>

<script>
  function fnDpstReqChk() {
  var frmObj = "#frmSearch";

  if ($("#sStat").val()==""){
    alert('변경할 상태를 선택하십시오.');
    return;
  }
  if (fnSelBoxCnt($(frmObj + " .chkReqSeq")) <= 0) {
    alert('변경할 예치금 내역을 선택하십시오.');
    return;
  }
 
  
  if (confirm('선택된 예치금 내역을 변경하시겠습니까?')) {
    $("#sKind").val("M");
    $("#frmSearch").attr("method", "post").attr("action", "./updateReturnDeposit");
    $("#frmSearch").submit();
  }
}



</script>