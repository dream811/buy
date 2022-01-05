<?php $ss= 0;
if($pf==null) $ss = $uc;
if($pf!=null) $ss = $uc-$pf; ?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        쪽지관리
      </h1>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
              <form name="frmList" id="frmList" method="get" action=""> 
                <div class="box-tools">   
                  <div class="input-group" style="margin-bottom: 10px">
                    <div class="pull-right">
                      <label style="display:block; ">..........</label>
                      <input class="btn btn-primary btn-sm" value="검색" type="submit">
                   </div> 
                   <div class="pull-right">
                      <label style="display:block; ">내용</label>
                      <input type="text" name="content" class="form-control input-sm" style="width: 150px;" 
                       value="<?=empty($_GET['content']) == 0 ? $_GET['content']:"" ?>" >
                   </div> 
                   <div class="pull-right">
                      <label style="display:block; ">검색항목</label>
                      <select name="shType" id="shType" class="form-control input-sm">
                        <option value="B" <?=empty($_GET['shType'])==0 && $_GET['shType'] =="B" ? "selected":""?>>회원명</option>
                        <option value="E" <?=empty($_GET['shType'])==0 && $_GET['shType'] =="E" ? "selected":""?>>쪽지내용</option>
                        <option value="A" <?=empty($_GET['shType'])==0 && $_GET['shType'] =="A" ? "selected":""?>>아이디</option>
                        <option value="D" <?=empty($_GET['shType'])==0 && $_GET['shType'] =="D" ? "selected":""?>>닉네임</option>
                      </select>
                   </div>
                   <div class="pull-right">
                     <label style="display: block;">종료일</label>
                     <input type="date" name="ends_date" class="form-control input-sm" 
                     value="<?=empty($_GET['ends_date']) == 0 ? $_GET['ends_date']:"" ?>">
                   </div>
                   <div class="pull-right">
                     <label style="display: block;">시작일</label>
                     <input type="date" name="starts_date" class="form-control input-sm" 
                     value="<?=empty($_GET['starts_date']) == 0 ? $_GET['starts_date']:"" ?>" >
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
              </form>
              <div class="box">
                <div class="box-body table-responsive no-padding">
                  <form id="frmSearch">
                    <input type="hidden" name="sKind" id="sKind">
                    <table class="table table-hover">
                      <tr class="thead-dark">
                        <th><input type="checkbox" class="NtSeqAll"  value="Y" name="NtSeqAll" 
                          onclick="fnCkBoxAllSel( 'frmSearch', 'NtSeqAll', 'chkNtSeq[]' );">No</th>
                        <th>받는사람</th>
                        <th>아이디 </th>
                        <th>내용</th>
                        <th>보낸일자  </th>
                        <th>읽음</th>
                        <th>수정</th>
                      </tr>
                      <?php
                      if(!empty($mail))
                      {
                          foreach($mail as $record)
                          {
                      ?>
                      <tr>
                        <td>
                          <input type="checkbox" name="chkNtSeq[]" class="chkNtSeq" value="<?=$record->id?>">
                          <?php echo $ss ?></td>
                        <td><?php echo $record->name?></td>
                        <td><?php echo $record->loginId ?></td>
                        <td><a href="javascript:fnNtView('<?=$record->id?>');"><?php echo $record->title ?></a></td>
                        <td><?php echo $record->updated_date ?></td>
                        <td><?=$record->view == 0 ? "읽지 않음":"읽음" ?></td>
                        <td><a class="btn btn-sm btn-info" href="<?php echo base_url().'editMail/'.$record->id; ?>"><i class="fa fa-pencil"></i></a></td>
                      </tr>
                      <?php
                      $ss=$ss-1;
                          }
                      }
                      ?>
                    </table>
                  </form>
                </div><!-- /.box-body -->
                <div class="box-footer clearfix">
                  <?php echo $this->pagination->create_links(); ?>
                </div>
              </div><!-- /.box -->
            </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <button type="button" class="btn btn-danger btn-sm" onclick="fnNtDel();">삭제</button>
            <button type="button" class="btn btn-primary btn-sm" onclick="fnPopNtDet();">쪽지보내기</button>
          </div>
        </div>
    </section>
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
        <table class="order_write order_table_top">
          <tbody><tr>
            <th class="title"></th>
          </tr>
          <tr>
            <p class="content" style="overflow: overlay"></p>
          </tr>
          </tbody>
        </table>
      </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">닫기</button>
      </div>
    </div>
  </div>
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
    function fnNtView(ids) {
      jQuery.ajax({
        type : "post",
        dataType : "json",
        url : baseURL + "viewMessage",
        data : {  id : ids } 
        }).done(function(data){
          $("#exampleModal .title").text(data[0]['title']);
          $("#exampleModal .content").html(data[0]['content']);
        });
      $("#exampleModal").modal();
    }
    function fnPopNtDetEdit(sVal){  
      fnPopWinCT("NtDet_E.asp?sNtSeq="+sVal, "쪽지보내기", 640, 550, "N")
    }
    function fnPopWinCT(sUrl, sTitle, iWidth, iHeight, sScrollYN)
    {
      var lsWinOption;
      var sSYN;
      //var iLeft, iTop;
      iLeft = (screen.width - iWidth)/2;
      iTop = (screen.height - iHeight)/2;
      sSYN = sScrollYN;
      switch (sScrollYN) {
      case 'Y' : sSYN = 'yes'; break;
      case 'N' : sSYN = 'no'; break;
      default : sSYN = 'auto'; break;
      }

      sTitle = sTitle.replace(" ", "_");
      lsWinOption = "width=" + iWidth + ", height=" + iHeight;
      lsWinOption += 
      " toolbar=no, directories=no, status=no, menubar=no, location=no, resizable=yes, left=" + iLeft + ", top=" + iTop + ", scrollbars="+sSYN;
      var loNewWin = window.open(sUrl, sTitle, lsWinOption).focus();
  }

  function fnPopNtDet(){  
    fnPopWinCT("NtDet_W", "쪽지보내기", 640, 550, "N")
  }


  function fnNtDel() {
    var frmObj = "#frmSearch";
    if (fnSelBoxCnt($("input[class='chkNtSeq']")) <= 0) {
      alert('삭제할 쪽지를 선택하십시오.');
      return;
    }
    if (confirm('선택된 쪽지를 삭제하시겠습니까?')) {
      $("#sKind").val("D");
      $("#frmSearch").attr("method", "post").attr("action", "./NtDet_D");
      $("#frmSearch").submit();
    }
  }
</script>
<style type="text/css">
  .order_write tbody th {
    padding: 14px 8px;
    text-align: left;
    color: #707070;
    border-right: 1px solid #e5e5e5;
    background-color: #fbfbfb;
    letter-spacing: -0.05em;
}
.order_write tbody td {
    padding: 10px 8px;
}
.order_write tbody td {
    border-bottom: 1px solid #e5e5e5;
    border-left: 1px solid #e5e5e5;
    line-height: 130%;
}
.order_write {
    border-left: 1px solid #e5e5e5;
    border-right: 1px solid #e5e5e5;
    border-bottom: 1px solid #e5e5e5;
}
.order_write {
    width: 100%;
}
.order_write tbody th {
    border-bottom: 1px solid #e5e5e5;
    border-left: 1px solid #e5e5e5;
    line-height: 130%;
}
.btn-area {
    margin-top: 15px;
}
</style>