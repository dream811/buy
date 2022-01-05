<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        노데이타  
      </h1>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
              <div class="box">
                <div class="box-body table-responsive no-padding">
                  <table class="table table-hover">
                    <tr class="thead-dark">
                      <th>No</th>
                      <th>트래킹번호</th>
                      <th>사서함번호</th>
                      <th>주문번호</th>
                      <th>이미지</th>
                      <th>입고일시</th>
                      <th></th>
                    </tr>
                    <?php if(isset($nodata) && sizeof($nodata) >0):  ?>
                      <?php foreach($nodata as $value): ?>
                        <tr>
                          <td><?=$value->id?></td>
                          <td><?=$value->trackingNumber?></td>
                          <td></td>
                          <td><?=$value->order_number?></td>
                          <td><img src="<?=$value->image?>" style="width:115px; height:80px;"></td>
                          <td><?=$value->created_date?></td>
                          <td>
                            <a href="#" class="btn btn-primary btn-sm">처리완료</a>
                            <a href="#" class="btn btn-danger btn-sm">삭제</a>
                          </td>
                        </tr>
                    <?php endforeach; ?>
                    <?php endif; ?>
                  </table>
                </div><!-- /.box-body -->
              </div><!-- /.box -->
            </div>
        </div>
    </section>
</div>

<script>
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