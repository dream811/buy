<?php 
$tt = is_null($gy) ? $sc:$sc-$gy;
?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        주문상품관리
      </h1>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
               <form name="frmList" id="frmList" method="get" action="<?=base_url()?>orderProduct">
                 <div class="box-tools">
                    <div class="input-group">
                      <div class="pull-right">
                         <label style="display: block;">주문구분</label>
                         <select class="form-control" style="width: 150px;" name="order_part">
                           <option value="">== 구분</option>                
                            <option value="delivery" <?=empty($_GET['order_part']) == 0 && $_GET['order_part'] =="delivery" ? "selected":"" ?>>배송대행</option>                      
                            <option value="buy" <?=empty($_GET['order_part']) == 0 && $_GET['order_part'] =="buy" ? "selected":"" ?>>구매대행</option>                                           
                            <option value="return" <?=empty($_GET['order_part']) == 0 && $_GET['order_part'] =="return" ? "selected":"" ?>>리턴대행</option>                                          
                         </select>
                       </div>
                       <div class="pull-right">
                         <label style="display: block;">트래킹 유무</label>
                         <select name="shFrgEmptyCd" id="shFrgEmptyCd" class="form-control">
                            <option value=""> == 전체</option>
                            <option value="1" <?=empty($_GET['shFrgEmptyCd'])== 0 && $_GET['shFrgEmptyCd'] == 1 ? "selected":""?>> 트래킹 없음 </option>
                            <option value="2" <?=empty($_GET['shFrgEmptyCd'])== 0 && $_GET['shFrgEmptyCd'] == 2 ? "selected":""?>> 트래킹 있음</option>
                          </select>
                       </div>
                       <div class="pull-right">
                         <label style="display: block;">종료일</label>
                         <input type="date" name="ends_date" class="form-control" 
                         value="<?=empty($_GET['ends_date']) == 0 ? $_GET['ends_date']:"" ?>"  >
                       </div>
                       <div class="pull-right">
                         <label style="display: block;">시작일</label>
                         <input type="date" name="starts_date" class="form-control" 
                         value="<?=empty($_GET['starts_date']) == 0 ? $_GET['starts_date']:"" ?>">
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
                  <div class="input-group" style="margin-top: 15px;margin-bottom: 10px">
                    <div class="pull-right">
                      <label style="display:block; ">..........</label>
                      <input class="btn btn-primary btn-sm" value="검색" type="submit">
                   </div> 
                   <div class="pull-right">
                      <label style="display:block; ">트래킹번호</label>
                      <input type="text" name="search_ptracking" class="form-control input-sm" style="width: 150px;" 
                       value="<?=empty($_GET['search_ptracking']) == 0 ? $_GET['search_ptracking']:"" ?>" >
                   </div> 
                   <div class="pull-right">
                     <label style="display:block; ">주문번호</label>
                      <input type="text" name="search_porder" class="form-control input-sm" style="width: 150px;" 
                      value="<?=empty($_GET['search_porder']) == 0 ? $_GET['search_porder']:"" ?>">
                   </div>   
                   <div class="pull-right">
                     <label style="display:block; ">오더넘버</label>
                      <input type="text" name="search_id"  class="form-control input-sm" style="width: 150px;" 
                      value="<?=empty($_GET['search_id']) == 0 ? $_GET['search_id']:""?>">
                   </div> 
                   
                   <div class="pull-right">
                     <label style="display:block; ">상품명</label>
                      <input type="text" name="search_peng"  class="form-control input-sm" style="width: 150px;" 
                      value="<?=empty($_GET['search_productname']) == 0 ? $_GET['search_productname']:"" ?>">
                   </div> 
                   <div class="pull-right">
                     <label style="display:block; ">아이디</label>
                      <input type="text" name="search_puserId"  class="form-control input-sm" style="width: 150px;" 
                      value="<?=empty($_GET['search_puserId']) ==0 ? $_GET['search_puserId']:""?>" >
                   </div> 
                   <div class="pull-right">
                     <label style="display:block; ">이름</label>
                      <input type="text" name="search_pusername"  class="form-control input-sm" style="width: 150px;" 
                      value="<?=empty($_GET['search_pusername']) == 0 ? $_GET['search_pusername']:"" ?>" >
                   </div> 
                   <div class="pull-right">
                     <label style="display:block; ">수취인명</label>
                      <input type="text" name="search_billing_name"  class="form-control input-sm" style="width: 150px;" value="<?=empty($_GET['search_billing_name']) == 0 ? $_GET['search_billing_name']:"" ?>">
                   </div> 
                   <div class="pull-right">
                     <label style="display:block; ">사서함번호</label>
                      <input type="text" name="search_nickname"  class="form-control input-sm" style="width: 150px;" value="<?=empty($_GET['search_nickname']) == 0 ? $_GET['search_nickname']:"" ?>">
                   </div> 
                  </div>
                </div>
               </form>
              <div class="box">
                <div class="box-body table-responsive no-padding">
                  <table class="table table-hover">
                    <tr class="thead-dark">
                      <th>No.</th>
                      <th>이미지</th>
                      <th>주문번호</th>
                      <th>회원명</th>
                      <th>상품명</th>
                      <th>오더번호<br>트래킹번호</th>
                      <th>색상, 사이즈 </th>
                      <th>단가 * 수량<br>총액</th>
                      <th>주문<br>입고상태</th>
                      <th>등록일<br>수정일</th>
                    </tr>
                    <?php if(isset($products) && sizeof($products) >0):  ?>
                      <?php foreach($products as $key=>$value): ?>
                        <tr>
                          <td><?=$tt?></td>
                          <td><a target="_blink" href="<?=$value->url?>"><img src="<?=$value->image?>" width="50" height="50"></a></td>
                          <td><span style="font-weight:bold;"><span style="color:#ff6600;">
                            <?=$value->get=="delivery" ? "배송대행":"구매대행";  ?></span></span> | <?=$value->ordernum?></td>
                          <td>
                            <a data-toggle="tooltip" class="hastip"  data-uname="<?=$value->name?>" data-userid="<?=$value->userId?>" data-deposit="<?=$value->deposit?>"><?=$value->name?></a></td>
                          <td><a target="_blink" href="<?=$value->url?>"><?=$value->productName?></a></td>
                          <td>
                            <div class="my-3">
                              <input type="text" name="sSHOP_ORD_NO_<?=$value->id?>_1" id="sSHOP_ORD_NO_<?=$value->id?>_1" maxlength="40" size="30" value="<?=$value->order_number?>">
                              <button type="button" class="txt btn btn-sm" onclick="fnChgFrgOrd('<?=$value->id?>','1');">주문번호 변경</button>
                            </div>
                            <div>
                              <select id="sFRG_DLVR_COM_<?=$value->id?>_1" >
                                <?php if(!empty($trackheader)): ?>
                                  <?php foreach($trackheader as $vt): ?>
                                    <option value="<?=$vt->name?>" <?php if($value->trackingHeader == $vt->name) echo ' selected'; ?>><?=$vt->name?></option>
                                  <?php endforeach; ?>
                                <?php endif;?>
                              </select>
                              <input type="text" name="sFRG_IVC_NO_<?=$value->id?>_1" id="sFRG_IVC_NO_<?=$value->id?>_1" maxlength="40" size="30" value="<?=$value->trackingNumber?>">
                              <button type="button" class="txt btn btn-sm" onclick="fnChgFrgIvc('<?=$value->id?>','1');">트래킹번호 변경</button>
                            </div>
                          </td>
                          <td><?=$value->color?>,<?=$value->size?></td>
                          <td><?=$value->unitPrice?>*<?=$value->count?><br>￥<?=intval($value->unitPrice)*intval($value->count)?></td>
                          <td><?=$value->sName?><br><?=$value->InS?></td>
                          <td><?=$value->created_date?></td>
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

<script>
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
  function fnChgFrgOrd(val1,val2){
    if ($("#sSHOP_ORD_NO_"+val1+"_"+val2).val()==""){
      alert('샵 주문번호 정보를 넣으세요!');
    }else{
      var url = "changeOrderNUmber?"
        + "sKind=T&sOrdSeq="+ val1 + "&sProSeq="+val2 + "&sSHOP_ORD_NO="+$("#sSHOP_ORD_NO_"+val1+"_"+val2).val();
      //  alert(url);
      var returnvalue="";
    
      returnvalue = DoCallbackCommon(url);
   
      if (returnvalue > 0)
      {
        alert("정상적으로 등록되었습니다.");
      }else{
        alert("등록에 실패했습니다.\n관리자에게 문의하세요.");
      }
    }
  }

  function fnChgFrgIvc(val1,val2){
  if ($("#sFRG_DLVR_COM_"+val1+"_"+val2).val()=="" || $("#sFRG_IVC_NO_"+val1+"_"+val2).val()==""){
    alert('등록할 트래킹 정보를 넣으세요!');
  }else{
    var url = "changeTracks?"
      + "sKind=T&sOrdSeq="+ val1 + "&sProSeq="+val2 + "&sFRG_DLVR_COM="+$("#sFRG_DLVR_COM_"+val1+"_"+val2).val() + "&sFRG_IVC_NO="+$("#sFRG_IVC_NO_"+val1+"_"+val2).val();
    //  alert(url);
    var returnvalue="";
  
    returnvalue = DoCallbackCommon(url);
 
    if (returnvalue)
    {
      alert("정상적으로 등록되었습니다.");
    }else{
      alert("등록에 실패했습니다.\n관리자에게 문의하세요.");
    }
  }
}
</script>