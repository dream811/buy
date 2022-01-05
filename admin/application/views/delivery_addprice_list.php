<?php $ss= 0;
if($pf==null) $ss = $uc;
if($pf!=null) $ss = $uc-$pf; ?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        도서산간 추가배송비 설정
      </h1>
    </section>
    <section class="content">
      <div class="row">
        <div class="col-xs-12 text-right">
            <div class="form-group">
                <a class="btn btn-primary" href="<?php echo base_url(); ?>addDeliveryPrice"><i class="fa fa-plus"></i>지역추가</a>
            </div>
        </div>
      </div>
      <div class="row">
        <div class="col-xs-12">
           <form name="frmList" id="frmList" method="get" action="<?=base_url("delivery_addprice_list")?>"> 
            <div class="box-tools">   
              <div class="input-group" style="margin-bottom: 10px">
                <div class="pull-right">
                  <label style="display:block; ">&nbsp;.</label>
                  <input class="btn btn-primary btn-sm" value="검색" type="submit">
               </div> 
               <div class="pull-right">
                 <label style="display:block; ">검색어</label>
                  <input type="text" name="content"  class="form-control input-sm" style="width: 150px;" value="<?=empty($_GET['content']) == 0 ? $_GET['content']:"" ?>">
               </div> 
               <div class="pull-right">
                  <label style="display:block; ">검색조건</label>
                  <select name="type" id="type" class="form-control input-sm">
                    <option value="">=== 전체 ===</option>
                    <option value="post" <?=$this->input->get("type")=="post" ? "selected":""?>>우편번호</option>
                    <option value="address" <?=$this->input->get("type")=="address" ? "selected":""?>>주소</option>
                  </select>
               </div>
              </div>
            </div>
          </form>
          <div class="box">
            <div class="box-body table-responsive no-padding">
              <table class="table table-hover">
                <colgroup>
                  <col wdith="*"></col>
                  <col wdith="62"></col>
                  <col width="300x"></col>
                </colgroup>
                  <tr class="thead-dark">
                    <th class="text-left">No</th>
                    <th class="text-left">우편번호</th>
                    <th class="text-left">주소 </th>
                    <th class="text-left">추가금액</th>
                    <th></th>
                </tr>
                <?php if(!empty($list)): ?>
                  <?php foreach($list as $value): ?>
                    <tr>
                      <td class="text-left"><?=$ss?></td>
                      <td class="text-left">
                        <span><?=$value->post?></span>
                      </td>
                      <td class="text-left"><?=$value->address?></td>
                      <td class="text-left"><?=$value->price?>(원)</td>
                      <td>
                          <a class="btn btn-sm btn-info" href="<?php echo base_url().'addDeliveryPrice?id='.$value->id; ?>">
                            <i class="fa fa-pencil"></i></a>
                          <a class="btn btn-sm btn-danger deletesproduct" href="#" data-spid="<?php echo $value->id; ?>">
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
      hitURL = baseURL + "deleteAddDelvieryAddress",
      currentRow = $(this);
    
    var confirmation = confirm("정말 삭제하시게습니까?");
    
    if(confirmation)
    {
      jQuery.ajax({
      type : "POST",
      dataType : "json",
      url : hitURL,
      data : { spid : spid} 
      }).done(function(data){
        currentRow.parents('tr').remove();
        if(data.status = true) { alert("성곡적으로 삭제되였습니다."); }
        else if(data.status = false) { alert("삭제 오유! 상품이 존재하지 않습니다."); }
        else { alert("접근요청 거절!"); }
      });
    }
  });
  
</script>