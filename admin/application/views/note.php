<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        알림목록
      </h1>
    </section>
    <section class="content">   
      <div class="row">
        <div class="col-xs-12">

            <div class="box-body table-responsive no-padding">
              <form name="frmSearch" id="frmSearch" method="get">
                <table class="table table-hover">
                  <tr class="thead-dark">
                    <th><input type="checkbox" name="chkMemCodeAll" id="chkMemCodeAll" value="Y" onclick="fnCkBoxAllSel( 'frmSearch', 'chkMemCodeAll', 'notes[]' );">No</th>
                    <th> 회원네임</th>
                    <th >분류</th>
                    <th >내용</th>
                    <th >변경일수</th>
                    <th ></th>
                  </tr>
                  <?php if(!empty($note)): ?>
                    <?php foreach($note as $value): ?>
                      <tr <?php if($value->view ==0){ ?> class="bg-danger" <?php } ?> id="note_<?=$value->id?>"> 
                        <td>
                        <input type="checkbox" name="notes[]" class="notes" value="<?=$value->id ?>">
                        <?=$value->id?>
                        </td>
                        <td><?=$value->name?></td>
                        <td><?php 
                        if($value->tt=="shop") echo "쇼핑몰";
                        if($value->tt=="delivery") echo "접수신청";
                        if($value->tt=="buy") echo "구매신청";
                        if($value->tt=="1") echo "무통장 입금 신청";
                        if($value->tt=="0") echo "예치금 전액 결제"; 
                        if($value->tt=="reqdelivery") echo "배송요청"; 
                        if($value->tt=="reqdelivery_plus") echo "묶음배송요청"; 
                        if($value->tt=="reqdelivery_minus") echo "나눔배송요청"; 
                        if($value->tt=="deposit") echo "예치금신청"; 
                         if($value->tt=="waiting-out") echo "쇼핑몰 출고대기"; 
                        if($value->type ==7) echo $value->tt;
                         ?></td>
                        <td><?php  if(  $value->tt=="delivery" ||
                                        $value->tt=="waiting-out" || 
                                        $value->tt=="buy" || 
                                        $value->tt=="shop" || 
                                        $value->tt=="0" || 
                                        $value->tt=="1" || 
                                        $value->tt=="reqdelivery" ||  $value->tt=="reqdelivery_plus" ||  $value->tt=="reqdelivery_minus") { echo "주문번호: "; ?>
                                        <a href="<?=base_url()?>dashboard?search_id=<?=$value->content?>"><?=$value->content?></a>
                                      <?php } ?>
                             <?php if($value->type ==7){ ?>
                             <?php $split = explode("$!$", $value->content); ?>
                               <a href="<?=base_url()?>viewReq/<?=$split[2]?>?board_type=<?=$split[1]?>"><?=$split[0]?></a>
                             <?php } ?>         
                              <?php if($value->tt =="deposit"){ ?>
                               <a href="<?=base_url()?>registerDeposit?content=<?=$value->content?>&type=name">
                                 <?=$value->content?>님이 예치금을 신청하였습니다.
                               </a>
                              <?php } ?>  
                          </td>
                        <td><?=$value->created_date?></td>
                        <td> <?php if($value->view ==0){ ?> <a href="javascript:viewNote(<?=$value->id?>)" class="noteBtn btn btn-sm btn-danger  btn-block"><span class="blink blink-one">확인</span></a><?php } ?></td>
                      </tr>
                    <?php endforeach; ?>
                  <?php endif; ?>
                </table>
              </form>
            </div><!-- /.box-body -->
            <div class="box-footer clearfix">
              <?php echo $this->pagination->create_links(); ?>
            </div>

          <button type="button" class="btn btn-sm btn-primary" onclick="delteNotes();">전체 삭제</button>
        </div>
      </div>
    </section>
</div>
<script type="text/javascript">
  function  delteNotes() {
    var frmObj = "#frmSearch";
      if (fnSelBoxCnt($(frmObj + " input[class='notes']")) <= 0) {
        alert('삭제 할 목록을 선택하십시오.');
        return;
      }

      if (confirm('선택하신 목록을 영구 삭제하시겠습니까?')) {
        $("#frmSearch").attr("method", "post").attr("action", "/admin/deleteNotes");
        $("#frmSearch").submit();
      }
  }

  function viewNote(id){
     hitURL = baseURL + "viewNote";
     var obj = $("#note_"+id);
     var btn_note = $("#note_"+id+" .noteBtn");
    jQuery.ajax({
      type : "POST",
      url : hitURL,
      data : { id : id } 
    }).done(function(data){
      obj.removeClass("bg-danger");
      $("#notice_count").text(parseInt($("#notice_count").text())-1);
      btn_note.remove();
    });
  }

</script>
