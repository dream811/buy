<?php  if($seg ==null) echo $ss = $csc; ?>
<?php  if($seg !=null) echo $ss = $csc-$seg; ?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        예치금사용내역
      </h1>
    </section>
    
    <section class="content">
    
        <div class="row">
            <!-- left column -->
            <div class="col-md-6">
              <!-- general form elements -->
                <div class="box box-primary">                    
                    <div class="box-body">
                        <div class="row my-3">
                            <form action="/admin/deposithistory" method="get">
                                <div class="col-md-2">
                                    <select class="form-control memberType" name="type">
                                        <option value="name">이름</option>
                                        <option value="nickname">닉네임</option>
                                        <option value="loginId">아이디</option>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <input type="text" name="content" class="memberVisible form-control" placeholder="회원검색">
                                </div>
                                <div class="col-md-2">
                                    <input type="submit" class="btn btn-primary" value="검색">
                                </div>
                            </form>
                        </div>
                        <form role="form" id="frmCpnInf1" action="<?php echo base_url() ?>saveDeposit" method="post" role="form">
                            <input type="hidden" name="chkMemCode">
                            <input type="hidden" name="event" value="0">
                            <div class="col-xs-12" style="border: 1px solid #a4a8ad;">
                                <div class="box-title">
                                    <h4>예치금 등록</h4>
                                </div>
                                <label>금액 구분</label>
                                <div class="row">
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <select class="form-control" name="gold_type">
                                                <option value="+">+</option>
                                                <option value="-">-</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <input type="text" name="gold" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="row my-4 my-3">
                                    <div class="col-xs-12">
                                        <a href="javascript:void(0);" class="btn btn-primary"  onclick="fnCpnReg('frmCpnInf1');">저장</a>
                                        <input type="reset" class="btn btn-secondary"  value="취소">
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>  
                </div>
            </div>
            <div class="col-md-6" id="frmMemList">
                <div class="box">
                    <div class="box-body table-responsive no-padding" style="max-height: 300px;overflow-y: scroll;">
                        <table class="table table-hover">
                            <tr class="thead-dark">
                              <th>
                                <input type="checkbox" class="input_chk" title="선택" name="MemCode_All" id="MemCode_All" value="total" onclick="fnChkBoxTotal(this, 'chkMemCode');">
                              No</th>
                              <th>회원명</th>
                              <th>닉네임(회원레벨)</th>
                              <th>이메일</th>
                              <th>핸드폰</th>
                              <th>예치금 금액</th>
                            </tr>
                            <?php
                            if(!empty($member))
                            {
                                foreach($member as $record)
                                {
                            ?>
                            <tr>
                                <td>
                                    <input type="checkbox" name="chkMemCode" class="chkMemCode" value="<?=$record->userId ?>">
                                    <?=$record->userId ?></td>
                                <td><?php echo $record->name ?></td>
                                <td><?php echo $record->nickname ?>(<?=$record->role?>)</td>
                                <td><?php echo $record->email ?></td>
                                <td><?php echo $record->mobile ?></td>
                                <td><?php echo $record->deposit ?>원</td>
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
        <div class="row">
            <div class="col-md-12">
                <!-- <div class="box"> -->
                    <div class="box-title">
                        <h5>예치금 사용내역 ( 회원전체 보유예치금 : 15,979,660 원 )</h5>
                    </div>
                    <div class="box-tools">
                        <div class="row">
                            <div class="col-md-12">
                                <form method="get" action="<?php echo base_url() ?>deposithistory">
                                    <div class="input-group" style="margin-bottom: 10px">
                                        <div class="pull-right">
                                            <label style="display: block;">&nbsp;</label>
                                            <input class="btn btn-primary btn-sm" value="검색" type="submit">
                                        </div> 
                                        <div class="pull-right">
                                            <label>&nbsp;</label>
                                            <input type="text" name="seach_input"  class="form-control input-sm"
                                              value="<?=empty($_GET['seach_input']) == 0 ? $_GET['seach_input']:"" ?>">
                                        </div> 
                                        <div class="pull-right">
                                            <label>검색항목</label>
                                            <select name="mem" class="form-control input-sm">
                                                <option value="name" 
                                                    <?=empty($_GET['mem']) == 0 && $_GET['mem']=="name" ? "selected":"" ?>>회원명</option>
                                                <option value="loginId" 
                                                    <?=empty($_GET['mem']) == 0 && $_GET['mem']=="loginId" ? "selected":"" ?>>아이디</option>
                                                <option value="nickname" 
                                                    <?=empty($_GET['mem']) == 0 && $_GET['mem']=="nickname" ? "selected":"" ?>>닉네임</option>
                                            </select>
                                        </div>
                                        <div class="pull-right">
                                            <label>상태</label>
                                            <select name="state" class="form-control input-sm">
                                                <option value="">전체</option>
                                                <option value="1" 
                                                    <?=empty($_GET['state']) == 0 && $_GET['mem']=="1" ? "selected":"" ?>>완료</option>
                                                <option value="2"
                                                    <?=empty($_GET['state']) == 0 && $_GET['mem']=="2" ? "selected":"" ?>>취소</option>
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
                                            <label>Page</label>
                                            <select name="shPageSize" id="shPageSize" class="form-control input-sm">
                                            <?php for($ii = 10 ;$ii<=100;$ii+=5){ ?>
                                              <option value="<?=$ii?>" <?=empty($_GET['shPageSize'])==0 && $_GET['shPageSize']==$ii ? "selected":"" ?>><?=$ii?></option>
                                            <?php }  ?>
                                          </select>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <form name="frmSearch" id="frmSearch" method="post" action="">
                        <input type="hidden" name="DPST_USE_SEQ" id="DPST_USE_SEQ">
                        <input type="hidden" name="sKind" id="sKind">
                        <div class="box-body table-responsive no-padding">
                            <table class="table table-hover">
                                <tr class="thead-dark">
                                  <th>No</th>
                                  <th>회원명(아이디)</th>
                                  <th>내용</th>
                                  <th>금액</th>
                                  <th>사용일자</th>
                                  <th>상태</th>
                                </tr>
                                <?php
                                if(!empty($deposites))
                                {
                                    foreach($deposites as $record)
                                    {
                                        $mul = 1;
                                ?>
                                <tr>
                                    <td>
                                        <?=$ss ?></td>
                                    <td><?php echo $record->name ?>(<?php echo $record->loginId ?>)</td>
                                    <td>
                                        <?php if($record->typess ==16 && $record->by ==1): ?>
                                            <?php $mul=1; ?>
                                            관리자 예치금 결제 
                                        <?php endif; ?>
                                        <?php if($record->typess ==17 && $record->by ==1): ?>
                                            <?php $mul=-1; ?>
                                            관리자 예치금 삭감
                                        <?php endif; ?>
                                        <?php if($record->typess ==4): ?>
                                            <?php $mul=-1; ?>
                                            무통장 입금 <?php if($record->tt==2) {echo '취소';$mul=1;} ?>
                                        <?php endif; ?>
                                        <?php if($record->typess ==5  && $record->by !=1): ?>
                                            <?php $mul=-1; ?>
                                            예치금 전액 결제 <?php if($record->tt==2) {echo '취소';$mul=1;} ?>
                                        <?php endif; ?>
                                        <?php if($record->typess ==5 && $record->by ==1): ?>
                                            <?php $mul=-1; ?>
                                            관리자 예치금 전액 결제 <?php if($record->tt==2) {echo '취소';$mul=1;} ?>
                                        <?php endif; ?>
                                        <?php if($record->typess ==101):?>
                                            <?php $mul=-1; ?>
                                            예치금 환급 <?php if($record->pending==0) {$mul=-1;}?>
                                                        <?php if($record->pending==2) {echo '(관리자 결제취소)'; $mul=1;}?>
                                            
                                        <?php endif; ?>
                                        <?php if($record->typess ==102): ?>
                                            <?php $mul=1; ?>
                                            예치금 적립 <?php if($record->tt==2) {echo '취소'; $mul=-1;}?>
                                        <?php endif; ?>
                                        <?php if($record->typess == 120 ){ echo '결제취소(예치금 결제)';$mul=1;} ?>
                                    </td>
                                    <td><?=$mul*$record->plus?>원</td>
                                    <td><?=$record->updated_date?></td>
                                    <td>
                                        <select name="sStat" id="sStat" onchange="fnDpstUseChk('<?=$record->id?>',this.value)">
                                            <option value="1" <?php if($record->tt==1) echo 'selected'; ?>>완료</option> 
                                            <option value="2" <?php if($record->tt==2) echo 'selected'; ?>>취소</option> 
                                            <option value="D">삭제</option> 
                                        </select>
                                    </td>
                                </tr>
                                <?php
                                    $ss = $ss-1;
                                    }
                                }
                                ?>
                            </table>  
                        </div>
                    </form>
                    <?php echo $this->pagination->create_links(); ?>
            </div>
        </div>
    </section>
</div>
<script>
    $('.form_date').datetimepicker({
        language:  'kr',
        weekStart: 1,
        autoclose: 1,
        startView: 2,
        forceParse: 0
    });
    function fnCpnReg(frmNm) { 
        var frmObj = "#" + frmNm;
        if (fnSelBoxCnt($("#frmMemList input[class='chkMemCode'")) <= 0) {
            alert('쿠폰을 발급할 회원을 선택하십시오.');
            return;
        }
        if ( Number($(frmObj + " input[name='gold']").val()) <= 0 ) {
            fnMsgFcs($("#CPN_MNY"), '쿠폰 금액을 입력하세요.');
            return;
        }
        debugger;
        $(frmObj + " input[name='chkMemCode']").val( fnGetChkboxValue($("#frmMemList input[class='chkMemCode'")));
        debugger;
        $(frmObj).submit(); 
}
function fnDpstUseChk(val1,val2) {
    var frmObj = "#frmSearch";
 
    
    if (confirm('선택된 예치금 내역을 변경하시겠습니까?')) {
        jQuery.ajax({
          type : "POST",
          url : "<?=base_url()?>DpstUseDet_M",
          data : { DPST_USE_SEQ : val1 ,sKind:val2} 
          }).done(function(data){
            if(data==101) alert("금액이 없습니다.");
            if(data==100) alert("변경되였습니다.");
            if(data==102) alert("삭제되였습니다.");
        });
    }
}
</script>