<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1></h1>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
              <form name="frmList" id="frmList" method="get" action=""> 
                <div class="box-tools">   
                  <div class="input-group" style="margin-bottom: 10px">
                    <div class="pull-right">
                      <label style="display:block; ">&nbsp;</label>
                      <input class="btn btn-primary btn-sm" value="검색" type="submit">
                   </div> 
                   <div class="pull-right">
                      <label style="display:block; ">회원등급</label>                                
                      <select name="shMemLvl" id="shMemLvl" class="form-control input-sm">
                        <option value="">=전체=</option>
                        <?php if(!empty($levels)): ?>
                          <?php foreach($levels as $value): ?>
                            <option value="<?=$value->roleId?>" <?=empty($_GET['shMemLvl'])==0 && $_GET['shMemLvl']==$value->roleId ?  "selected":""?>><?=$value->role?></option>
                          <?php endforeach; ?>  
                        <?php endif; ?>
                      </select>
                   </div>
                  </div>
                </div>
              </form>
              <form id="frmSearch">
                <input type="hidden" name="sKind" id="sKind">
                <div class="box">
                  <div class="box-body table-responsive no-padding">
                    <table class="table table-hover">
                      <tr class="thead-dark">
                        <th><input type="checkbox" name="chkMemCodeAll" id="chkMemCodeAll" value="Y" 
                          onclick="fnCkBoxAllSel( 'frmSearch', 'chkMemCodeAll', 'chkMemCode' );">Id</th>
                        <th>회원명(아이디)</th>
                        <th>닉네임[등급]</th>
                        <th>예치금(원)</th>
                        <th>적립포인트</th>
                        <th>핸드폰</th>
                        <th>Email</th>
                        <th>생년월일</th>
                        <th>주문완료(건)</th>
                        <th>가입일</th>
                        <th>이메일수신</th>
                        <th>이메일수신</th>
                        <th>로그인횟수</th>
                        <th>마지막 접속일</th>
                        <th class="text-center"></th>
                      </tr>
                      <?php
                      if(!empty($userRecords))
                      {
                          foreach($userRecords as $record)
                          {
                      ?>
                      <tr>
                        <td><input type="checkbox" name="chkMemCode[]" class="chkMemCode" value="<?=$record->userId ?>"><?=$record->userId ?></td>
                        <td><a data-toggle="tooltip" class="hastip"  data-uname="<?=$record->name?>" 
                          data-userid="<?=$record->userId?>" data-deposit="<?=$record->deposit?>"><?=$record->name?>(<?=$record->loginId?>)</a>
                        </td>
                        <td><?=$record->nickname ?>[<?=$record->role?>]</td>
                        <td><?=$record->deposit?></td>
                        <td><?=$record->point?></td>
                        <td><?=$record->mobile?></td>
                        <td><?=$record->email ?></td>
                        <td><?=$record->birthday?></td>                       
                        <td>0</td>
                        <td><?=$record->createdDtm?></td>
                        <td><?=$record->emailRecevice==1 ? "예":"아니"?></td>
                        <td><?=$record->smsRecevice==1 ? "예":"아니"?></td>
                        <td><?=$record->log_num?></td>
                        <td><?=$record->log_date?></td>
                        <td class="text-center">
                            <a class="btn btn-sm btn-info" href="<?php echo base_url().'editOld/'.$record->userId; ?>">
                              <i class="fa fa-pencil"></i></a>
                            <a class="btn btn-sm btn-danger deleteUser" href="#" data-userid="<?php echo $record->userId; ?>">
                              <i class="fa fa-trash"></i></a>
                        </td>
                      </tr>
                      <?php
                          }
                      }
                      ?>
                    </table>
                    
                  </div><!-- /.box-body -->
                  <div class="box-footer clearfix">
                    <?php //echo $this->pagination->create_links(); ?>
                  </div>
                </div><!-- /.box -->
                <button type="button" class="btn btn-sm btn-primary" onclick="fnMemLvlChk();">등업완료</button>
              </form>
            </div>
        </div>
    </section>
</div>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/common.js" charset="utf-8"></script>
<script type="text/javascript">
    jQuery(document).ready(function(){
        jQuery('ul.pagination li a').click(function (e) {
            e.preventDefault();            
            var link = jQuery(this).get(0).href;            
            var value = link.substring(link.lastIndexOf('/') + 1);
            jQuery("#searchList").attr("action", baseURL + "userListing/" + value);
            jQuery("#searchList").submit();
        });
    });
    $('.hastip').tooltipsy({
     content: function ($el, $tip) {
        return '<table width="130" cellspacing="5" style="margin-left:10px;"><tbody><tr><td><span class="bold">'+$el.data("uname")+'</span> ('+$el.data("deposit")+'원)</td></tr><tr>      <td>· <a href="/admin/editOld/'+$el.data("userid")+'" target="_blank" class="popMem">회원정보보기</a></td></tr><tr>      <td>· <a href="javascript:fnPopWinCT(\'/admin/sendMail?userid='+$el.data("userid")+'\', \'MemNote\', 700, 510, \'N\');" class="popMem">쪽지보내기</a></td> </tr> <tr>      <td>· <a href="#" class="popMem">SMS 발송</a></td>    </tr>    <tr>      <td>· <a href="javascript:fnPopWinCT(\'/admin/payhistory?member_part=userId&search_txt='+$el.data("userid")+'\', \'ActingMem\', 1200, 700, \'Y\');" class="popMem">주문내역</a></td>    </tr>    <tr>      <td>· <a href="/admin/deposithistory?mem=name&seach_input='+$el.data("uname")+'" target="_blank" class="popMem">예치금 사용내역</a></td>    </tr>    <tr>      <td>· <a href="/admin/paying/?member_part=userId&search_txt='+$el.data("userid")+'" target="_blank" class="popMem">결제내역</a></td>    </tr>    <tr>      <td>· <a href="/admin/couponList/?shType=name&seach_input='+$el.data("uname")+'" target="_blank" class="popMem">쿠폰발급내역</a></td>    </tr>    <tr>      <td>· <a href="/admin/coupon_register?type=name&content='+$el.data("uname")+'" target="_blank" class="popMem">쿠폰발급</a></td>    </tr>    </tbody></table>';
    },
    offset: [0, 1],
    css: {
        'padding': '10px',
        'max-width': '200px',
        'color': '#303030',
        'background-color': '#f5f5b5',
        'border': '1px solid #deca7e',
        '-moz-box-shadow': '0 0 10px rgba(0, 0, 0, .5)',
        '-webkit-box-shadow': '0 0 10px rgba(0, 0, 0, .5)',
        'box-shadow': '0 0 10px rgba(0, 0, 0, .5)',
        'text-shadow': 'none',
        'cursor':'pointer'
    }
});


function fnMemLvlChk(){
  var frmObj = "#frmSearch";
  if (fnSelBoxCnt($(frmObj + " input[class='chkMemCode']")) <= 0) {
    alert('등급을 변경 할 회원을 선택하십시오.');
    return;
  }
  $("#sKind").val("U");
  $("#frmSearch").attr("method", "post").attr("action", "./Mem_U").attr("target", "prcFrm");
  $("#frmSearch").submit();
  
}
 function fnPopNtDet(){
  var frmObj = "#frmSearch";
    if (fnSelBoxCnt($(frmObj + " input[class='chkMemCode']")) <= 0) {
      alert('쪽지를 보낼 회원을 선택하십시오');
      return;
    }
    debugger;
    var reVal = fnGetChkboxValue($(frmObj + " input[class='chkMemCode']"));
    fnPopWinCT("NtDet_W?chkMemCode="+reVal, "쪽지보내기", 640, 550, "N")
  }
function fnMemDelChk(){
  var frmObj = "#frmSearch";
  if (fnSelBoxCnt($("input[class='chkMemCode']")) <= 0) {
    alert('탈퇴 대기 할 회원을 선택하십시오.');
    return;
  }
  $("#sKind").val("D");
  $("#frmSearch").attr("method", "post").attr("action", "./Mem_U").attr("target", "prcFrm");
  $("#frmSearch").submit();
}

function fnMemExl() { 
  $("#sKind").val("");
  $("#frmSearch").attr("method", "post").attr("action", "./Mem_X").attr("target", "prcFrm");
  $("#frmSearch").submit();
}
</script>
