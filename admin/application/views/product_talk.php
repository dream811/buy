<?php $ss= 0;
if($pf==null) $ss = $uc;
if($pf!=null) $ss = $uc-$pf; ?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <?=$this->input->get("type") =="eval" ? "상품평관리":"상품문의관리"?>
      </h1>
    </section>
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
           <form name="frmList" id="frmList" method="get" action="<?=base_url("product_talk")?>"> 
            <input type="hidden" name="type" value="<?=$this->input->get("type")?>" >
            <div class="box-tools">   
              <div class="input-group" style="margin-bottom: 10px">
                <div class="pull-right">
                  <label style="display:block; ">&nbsp;</label>
                  <input class="btn btn-primary btn-sm" value="검색" type="submit">
               </div> 
               <div class="pull-right">
                  <label style="display:block; ">댓글내용</label>
                  <input type="text" name="comment" class="form-control input-sm" style="width: 150px;" 
                   value="<?=empty($_GET['comment']) == 0 ? $_GET['comment']:"" ?>" >
               </div> 
               <div class="pull-right">
                 <label style="display:block; ">작성자명</label>
                  <input type="text" name="writter"  class="form-control input-sm" style="width: 150px;" value="<?=empty($_GET['writter']) == 0 ? $_GET['writter']:"" ?>">
               </div>
               <div class="pull-right">
                 <label style="display:block; ">상품코드</label>
                  <input type="text" name="pcode"  class="form-control input-sm" style="width: 150px;" value="<?=empty($_GET['pcode']) == 0 ? $_GET['pcode']:"" ?>">
               </div>
               <div class="pull-right">
                 <label style="display:block; ">상품명</label>
                  <input type="text" name="name"  class="form-control input-sm" style="width: 150px;" value="<?=empty($_GET['name']) == 0 ? $_GET['name']:"" ?>">
               </div> 
              </div>
            </div>
          </form>
          <div class="box">
            <div class="box-body table-responsive no-padding">
              <table class="table table-hover table-bordered ft-12">
                <colgroup>
                  <col width="50px">
                  <col width="200px">
                  <col width="130px">
                  <col width="80px">
                  <col width="50px;">
                  <col width="*">
                  <col width="80px;">
                  <col width="80px;">
                  <col width="140px;">
                </colgroup>
                <tr class="thead-dark">
                  <th class="text-center">No</th>
                  <th>상품정보</th>
                  <th class="text-left"></th>
                  <th class="text-center">작성자 </th>
                  <th class="text-center">평점</th>
                  <th class="text-center">댓글내용</th>
                  <th class="text-center">작성일</th>
                  <th class="text-center">답변</th>
                  <th class="text-center">비고</th>
                </tr>
                <?php if(!empty($list)): ?>
                  <?php foreach($list as $value): ?>
                    <tr>
                      <td class="text-center mid"><?=$ss?></td>
                      <td class="text-left mid"><img src="/upload/shoppingmal/<?=$value->pid?>/<?=$value->image?>" class='w-100' ></td>
                      <td class="text-left mid"><?=$value->pname?><br><?=$value->pcode?></span></td>
                      <td class="text-center mid"><?=$value->uname?><br>
                        <a href="/admin/editOld/<?=$value->userId?>" class="text-primary">(<?=$value->nickname?>)</a></td>
                      <td class="text-center mid"><?=$value->eval_point?></td>
                      <td class="text-left mid" id="item_<?=$value->id?>">
                        <span class="font-weight-bold"><?=$value->title?></span><br><?=$value->content?>
                        <br>
                        <?php if(!empty($value->reply)): ?>
                        <div class="new_admin_reply">
                          <span class="shape"></span>
                          <ul>
                          <!-- li 반복 -->
                            <li>
                              <!-- 글쓴정보 -->
                              <div class="name">
                                <span class="txt"> <?=$value->reply[0]->intype="admin" ? "운영자" : "회사"?> 
                                  (<u><a href="/admin/editOld/<?=$value->reply[0]->userId?>" target="_blank"><?=$value->reply[0]->name?></a></u>)
                                </span>
                                <span class="txt">작성일 : <?=date("Y-m-d",strtotime($value->reply[0]->rdate))?> 
                                (<?=date("H:i:s",strtotime($value->reply[0]->rdate))?>)</span>
                              </div>
                              <!-- 글내용 -->
                              <div class="conts"><?=$value->reply[0]->content?></div>
                              <!-- 관리버튼 -->
                              <span class="btn_box">
                                <span class="shop_btn_pack"><a 
                                  href="/admin/product_talk_modify?status=reply&type=<?=$this->input->get("type")?>&id=<?=$value->id?>"
                                  class="small white" title="수정">수정</a></span>
                                <span class="shop_btn_pack"><a href="javascript:void(0)" class="small gray deletesproduct" title="삭제" 
                                  data-spid="<?php echo $value->reply[0]->id; ?>" data-type="span" data-removed="<?php echo $value->id; ?>">삭제</a></span>
                              </span>
                            </li>
                            <!-- li 반복 -->
                          </ul>
                        </div>  
                        <?php endif; ?>
                      </td>
                      <td class="text-center mid"><?=date("Y-m-d",strtotime($value->rdate))?> </td>
                      <td class="text-center mid">
                        <?php if(!empty($value->reply)): ?>
                          <span class="p-5 bg-red text-white">답변완료</span>
                        <?php endif; ?>
                        <?php if(empty($value->reply)): ?>
                          <span class="p-5 bg-secondary text-white">답변대기</span>
                        <?php endif; ?>
                      </td>
                      <td class="mid">
                          <?php if(empty($value->reply)): ?>
                          <a class="btn btn-sm btn-primary" href="/admin/product_talk_modify?status=reply&type=<?=$this->input->get("type")?>&id=<?=$value->id?>">댓글</a>
                          <?php endif; ?>
                          <a class="btn btn-sm btn-default" 
                          href="/admin/product_talk_modify?type=<?=$this->input->get("type")?>&mode=modify&id=<?=$value->id?>">
                            <i class="fa fa-pencil"></i></a>
                          <a class="btn btn-sm btn-danger deletesproduct" href="javascript:void(0)" data-spid="<?php echo $value->id; ?>" data-type="td">
                            <i class="fa fa-trash"></i></a></td>
                    </tr>
                    <?php $ss = $ss-1; ?>
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
<script type="text/javascript">
  jQuery(document).on("click", ".deletesproduct", function(){
    var spid = $(this).data("spid"),
        hitURL = baseURL + "deleteEval",
        currentRow = $(this),
        type = $(this).data("type"),
        removed = $(this).data("removed"),
        item = $("#item_"+removed).find(".new_admin_reply");

    var confirmation = confirm("정말 삭제하시겠습니까?");
    
    if(confirmation)
    {
      jQuery.ajax({
      type : "POST",
      dataType : "json",
      url : hitURL,
      data : { spid : spid} 
      }).done(function(data){
        if(type =="td") currentRow.parents('tr').remove();
        else
          item.remove();
        if(data.status = true) { alert("성곡적으로 삭제되였습니다."); }
        else if(data.status = false) { alert("삭제 오유! 상품이 존재하지 않습니다."); }
        else { alert("접근요청 거절!"); }
      });
    }
  });
  
</script>