<?php 
$tt = is_null($gy) ? $sc:$sc-$gy;
?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        상품찜관리
      </h1>
    </section>
    <section class="content">

      <div class="row">
        <div class="col-xs-12">
           <form name="frmList" id="frmList" method="get" action="<?=base_url()?>product_wish"> 
            <input type="hidden" name="p_category" id="p_category" value="<?=empty($_GET['p_category']) == 0 ? $_GET['p_category']:"" ?>">
            <input type="hidden" name="step2" id="step2" value="<?=empty($_GET['step2']) == 0 ? $_GET['step2']:"" ?>">
            <input type="hidden" name="step3" id="step3" value="<?=empty($_GET['step3']) == 0 ? $_GET['step3']:"" ?>">
            <div class="box-tools">   
              <div class="input-group" style="margin-bottom: 10px">
                <div class="pull-right" style="margin-left: 10px">
                  <label style="display:block; ">&nbsp;</label>
                  <input class="btn btn-primary btn-sm" value="검색" type="submit">
               </div> 
               <div class="pull-right">
                  <label style="display:block; ">3차분류</label>
                  <select name="p_category3" id="p_category3" class="form-control input-sm category_select" data-step="3">
                    <option value="">=== 선택 ===</option>
                    <?php if(!empty($category3)): ?>
                    <?php foreach($category3 as $value): ?>
                    <option value="<?=$value->id?>" <?=$this->input->get("p_category3")==$value->id ? "selected":""?>><?=$value->name?></option>
                    <?php endforeach;?>
                    <?php endif; ?>
                  </select> 
               </div> 
               <div class="pull-right">
                  <label style="display:block; ">2차분류</label>
                  <select name="p_category2" id="p_category2" class="form-control input-sm category_select" data-step="2">
                    <option value="">=== 선택 ===</option>
                    <?php if(!empty($category2)): ?>
                    <?php foreach($category2 as $value): ?>
                    <option value="<?=$value->id?>" <?=$this->input->get("p_category2")==$value->id ? "selected":""?>><?=$value->name?></option>
                    <?php endforeach;?>
                    <?php endif; ?>
                  </select>               
                </div> 
               <div class="pull-right">
                  <label style="display:block; ">1차분류</label>
                   <select name="p_category1" id="p_category1" class="form-control input-sm category_select" data-step="1">
                    <option value="">=== 선택 ===</option>
                    <?php if(!empty($category)): ?>
                    <?php foreach($category as $value): ?>
                    <option value="<?=$value->id?>" <?=$this->input->get("p_category1")==$value->id ? "selected":""?>><?=$value->name?></option>
                    <?php endforeach;?>
                    <?php endif; ?>
                  </select>
               </div> 
               
               <div class="pull-right">
                 <label style="display:block; ">상품코드</label>
                  <input type="text" name="p_code"  class="form-control input-sm" style="width: 150px;" value="<?=empty($_GET['p_code']) == 0 ? $_GET['p_code']:"" ?>">
               </div>  
               <div class="pull-right">
                 <label style="display:block; ">상품명</label>
                  <input type="text" name="p_name"  class="form-control input-sm" style="width: 150px;" value="<?=empty($_GET['p_name']) == 0 ? $_GET['p_name']:"" ?>">
               </div>
               <div class="pull-right"> 
                  <label style="display:block; ">신상품</label>
                  <select name="p_newview" id="p_newview" class="form-control input-sm">
                    <option value="">=== 전체 ===</option>
                    <option value="1" <?=$this->input->get("p_newview") !=null && $this->input->get("p_newview")==1 ? "selected":""?>>노출</option>
                    <option value="0" <?=$this->input->get("p_newview") !=null && $this->input->get("p_newview")==0 ? "selected":""?>>숨김</option>
                  </select>
               </div>
               <div class="pull-right"> 
                  <label style="display:block; ">세일상품</label>
                  <select name="p_saleview" id="p_saleview" class="form-control input-sm">
                    <option value="">=== 전체 ===</option>
                    <option value="1" <?=$this->input->get("p_saleview") !=null && $this->input->get("p_saleview")==1 ? "selected":""?>>노출</option>
                    <option value="0" <?=$this->input->get("p_saleview") !=null && $this->input->get("p_saleview")==0 ? "selected":""?>>숨김</option>
                  </select>
               </div>
               <div class="pull-right"> 
                  <label style="display:block; ">베스트상품</label>
                  <select name="p_bestview" id="p_bestview" class="form-control input-sm">
                    <option value="">=== 전체 ===</option>
                    <option value="1" <?=$this->input->get("p_bestview") !=null && $this->input->get("p_bestview")==1 ? "selected":""?>>노출</option>
                    <option value="0" <?=$this->input->get("p_bestview") !=null && $this->input->get("p_bestview")==0 ? "selected":""?>>숨김</option>
                  </select>
               </div>
              </div>
            </div>
          </form>
          <div class="box">
            <form id="frmSearch">
            <div class="box-body table-responsive no-padding">
                <table class="table table-hover">
                  <tr class="thead-dark">
                    <th class="text-center">
                      선택 <input type="checkbox" class="NtSeqAll" name="NtSeqAll" value="Y" onclick="fnCkBoxAllSel( 'frmSearch', 'NtSeqAll', 'checkedp[]' );">
                    </th>
                    <th class="text-center">상품이미지</th>
                    <th class="text-center">상품명</th>
                    <th class="text-center">상품코드</th>
                    <th class="text-center">가격</th>
                    <th class="text-center">회원명</th>
                    <th class="text-center">등록일</th>
                  </tr>
                  <?php if(!empty($wishes)): ?>
                    <?php foreach($wishes as $value): ?>
                      <tr>
                        <td class="text-center mid">
                          <?=$tt?>
                          <input type="checkbox" name="checkedp[]" value="<?=$value->wid?>" class="checkedp">
                        </td>
                        <td class="text-center mid">
                          <img src="/upload/shoppingmal/<?=$value->id?>/<?=$value->i1?>" width="60">
                        </td>
                        <td class="text-center mid"><?=$value->name?></td>
                        <td class="text-center mid"><?=$value->rid?></td>
                        <td class="text-center mid"><?=number_format($value->singo)?>원</td>
                        <td class="text-center mid"><?=$value->uname?></td>
                        <td class="text-center mid"><?=$value->updated_date ?></td>
                      </tr>
                      <?php $tt = $tt -1 ; ?>
                    <?php endforeach; ?>
                  <?php endif; ?>
                </table>
              </div><!-- /.box-body -->
            </form>
            <div class="box-footer clearfix">
              <?php echo $this->pagination->create_links(); ?>
            </div>
          </div><!-- /.box -->
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
          <button type="button" class="btn btn-danger btn-lg" onclick="fnNtDel();">삭제</button>
        </div>
      </div>
    </section>
  </div>


<script>
  $(".category_select").change(function() {
      $("#p_category").val($(this).val());
      if($(this).data("step") !=3)
      {
        var temp = $(this).data("step")+1;
        $("#step"+temp).val($(this).val());
        if(temp ==2)
        {
          $("#step3").val("");
          $("#p_category3").html("");
          $("#p_category3").append( new Option("선택",""));
        }
        if($(this).val().trim() ==""){
          $("#p_category"+temp).html("");
          $("#p_category"+temp).append( new Option("선택","") );
          return;
        }
        jQuery.ajax({
          type : "POST",
          dataType : "json",
          url : baseURL+"getshopcategory",
          data : { id : $(this).val(),type:"list"  } 
          }).done(function(data){

            $("#p_category"+temp).html("");
            $("#p_category"+temp).append( new Option("선택","") );
            if(data.result.length > 0)
              $.each(data.result,function(index,value){
                $("#p_category"+temp).append( new Option(value.name,value.id) );
              })
          });
      }
  });

  function fnNtDel(){
    var frmObj = "#frmSearch";
    if (fnSelBoxCnt($("input[class='checkedp']")) <= 0) {
      alert('삭제할 쪽지를 선택하십시오.');
      return;
    }
    if (confirm('선택된 항목을 삭제하시겠습니까?')) {

      $("#frmSearch").attr("method", "post").attr("action", "./deleteWishes");
      $("#frmSearch").submit();
    }
  }   
</script>