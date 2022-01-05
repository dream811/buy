 <?php 
    if($cc==null) $cou=$ac;
    else $cou = $ac-$cc;
?>
<?php $data['title']="받은 쪽지함" ?>
<?php $this->load->view("my_header",$data); ?>
<div class="container">
	<div class="row">
		<div id="subRight">
      <div class="row pt-10">
        <form method="get" action="<?=base_url()?>mailbox">
          <div class="col-xs-5  p-right-5 p-left-5">
            <input type="hidden" name="option" value="<?=!empty($_GET['option']) && $_GET['option'] ? $_GET['option']:""?>">
            <input type="date" name="from" class="form-control w-100" value="<?=$this->input->get("from")?>">
          </div>
          <div class="col-xs-5  p-right-5 p-left-5">
            <input type="date" name="to" class="form-control w-100" value="<?=$this->input->get("to")?>">
          </div>
          <div class="col-xs-2  p-right-5 p-left-5">
            <input type="submit" class="btn btn-yonpu btn-block btn-round" value="검색">
          </div>
        </form> 
      </div>
			<div class="row mt-10">
         <div class="col-xs-12 p-left-5 p-right-5">
           <form name="frmSearch" id="frmSearch" method="get" action="">  
            <div class="con">
              <div class="border-b mb-10">
                <table class="table table-dark mb-0">
                  <colgroup>
                    <col width="20%"></col>
                    <col width="25%"></col>
                    <col width="37%"></col>
                    <col width="18%"></col>
                  </colgroup>
                  <thead class="thead-jin">
                      <tr>
                        <th scope="col"><input type="checkbox" name="NtSeqAll" id="NtSeqAll" class="vm" value="Y" onclick="fnChkBoxTotalByClass(this, 'basket');">&nbsp;순번</th>
                        <th scope="col">보낸일자</th>
                        <th scope="col">제목  </th>
                        <th scope="col">보낸사람</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php if(!empty($ques)):
                          foreach($ques as $value): ?>
                      <tr>
                        <td class="mid"><input type="checkbox" name="id[]" value="<?=$value->id?>" class="basket">&nbsp;<?=$cou?></td>
                        <td class="mid"><?=date_format(date_create($value->updated_date),"Y-m-d")?></td>
                        <td class="mid"><a class="<?=$value->view ==0 ? "text-danger":""?>" id="mail<?=$value->id?>" href="javascript:fnNtView('<?=$value->id?>');"><?=$value->title?></a></td>
                        <td class="mid">관리자</td>
                      </tr>
                      <?php $cou = $cou-1; ?>
                    <?php endforeach;
                      endif; ?>
                    </tbody>
                </table>
              </div>
              <div class="text-center">
                <?php echo $this->pagination->create_links(); ?>
              </div>
            </div>
          </form>
         </div>    
      </div>
      <div class="row pb-10">
        <div class="col-xs-12 p-left-5 text-right">
          <a href="javascript:deleteMails()" class="btn btn-warning  btn-round">삭제</a>
        </div>
      </div>
		</div>
	</div>
</div>
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
       <div class="order_table">
        <table class="order_write order_table_top border-r border-t">
          <tbody><tr>
            <th class="title"></th>
          </tr>
          <tr>
            <td><p class="content img-100"></p></td>
          </tr>
          </tbody>
        </table>
      </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger btn-round" data-dismiss="modal">닫기</button>
      </div>
    </div>
  </div>
</div>
<script>
function fnNtView(ids) {
  jQuery.ajax({
    type : "post",
    dataType : "json",
    url : baseURL + "getmailbyid",
    data : {  id : ids } 
    }).done(function(data){
      $("#exampleModal .title").text(data[0]['title']);
      $("#exampleModal .content").html(data[0]['content']);
      $("#mail"+ids).removeClass("text-danger");
    });
  $("#exampleModal").modal();
}
function fnChkBoxTotalByClass(sObj, sObjSel) {
  var ChkBox = $("."+sObjSel); 
  if (!ChkBox)
  {
    alert("선택할 항목이 없습니다.");
    return;
  }

  if (ChkBox.length == undefined) {
      ChkBox.checked = sObj.checked
  }
  else {
    for (var i = 0; i < (ChkBox.length); i++) {
      ChkBox[i].checked = sObj.checked;
    }
  }
}

function deleteMails(){
   var frmObj = "#frmSearch";
    if (fnSelBoxCnt($("input[class='basket']")) <= 0) {
      alert('삭제할 쪽지를 선택하십시오.');
      return;
    }
    if (confirm('선택된 쪽지를 삭제하시겠습니까?')) {
      $("#frmSearch").attr("method", "post").attr("action", "/deleteMails");
      $("#frmSearch").submit();
    }
}
</script>
<style type="text/css">
  #shCol {
    background: linear-gradient(#ffe594,#fcb949 30.71%);
    font-family: s-core-dream-medium;
    font-size: 12px;
}
.pagination{
  margin: 0
}
</style>