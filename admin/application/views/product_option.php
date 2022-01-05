<?php 

$pass_mode = $this->input->get("pass_mode"); 
$class="";
$table_class = "table-striped";
$dep = 1;
if($pass_mode =="second")
{  
  $class = "table-primary";
  $table_class = "";
  $dep = 2;
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>상품 옵션 설정</title>
  <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
  <link href="<?php echo base_url(); ?>assets/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />   
  <link href="<?php echo base_url(); ?>assets/dist/css/admin.css?<?=time()?>" rel="stylesheet" type="text/css" />
  <link href="<?php echo base_url(); ?>assets/dist/css/table.min.css" rel="stylesheet" type="text/css" />
  <script src="<?php echo base_url(); ?>assets/js/jQuery-2.1.4.min.js"></script>
  <!-- <script src="https://code.jquery.com/ui/1.12.0/jquery-ui.min.js"></script>  -->
</head>
<body>
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content">
      <div class="row" style="margin: 0">
            <!-- left column -->
        <div class="col-md-12">
              <!-- general form elements -->
          <div class="box box-primary">
            <?php echo form_open_multipart('product_option_save');?>
              <table class="table table-bordered <?=$table_class?>" summary="검색항목">
                <colgroup>
                  <col width="100px"/>  <col width="*"/><col width="150px"/>
                </colgroup>
                <tbody class="depth1">
                  <?php if(!empty($add_options)): ?>
                  <?php foreach($add_options as $value):?>
                   <tr id="options_<?=$value->id?>" class="tr_depth1 <?=$class?>" data-id="<?=$value->id?>">
                      <th class="mid text-center">1차 옵션<span class="ic_ess" title="필수"></span></th>
                      <td class="mid">
                        <div class="value">
                          <!-- 이름입력 -->
                          <span class="wrapping_name">
                              <span class="txt_box">1차 옵션명</span>
                              <input type="text"  class="input_design name" placeholder="1차 옵션명입력" value="<?=$value->name?>" />
                          </span>
                          <!-- 값 입력 -->
                          <span class="wrapping_num">
                              <span class="txt_box">공급가</span>
                              <input type="text"  class="input_design input_price optionprice" placeholder="0" value="<?=$value->optionprice?>" />
                          </span>
                          <span class="wrapping_num">
                              <span class="txt_box">판매가</span>
                              <input type="text"  class="input_design input_price supply" placeholder="0" value="<?=$value->supply?>" />
                          </span>
                          <span class="wrapping_num">
                              <span class="txt_box">수량(재고)</span>
                              <input type="text"  class="input_design input_number count" placeholder="0" value="<?=$value->count?>" />
                          </span>
                          <span class="wrapping_num">
                              <span class="txt_box">판매</span>
                              <input type="text" class="input_design input_number" placeholder="0" value="<?=$value->salecount?>" readonly="readonly" disabled="" />
                          </span>
                      </div>
                      </td>
                      <td class="mid text-center">
                        <!-- 끼워넣기버튼 -->
                        <div class="btn_add">
                            <span class="shop_btn_pack">
                              <a href="javascript:f_insert('update',0, <?=$value->id?>);" class="btn btn-default btn-sm" >변경</a>
                              <a href="javascript:f_insert('delete',0, '<?=$value->id?>');" class="btn btn-sm btn-default" title="해당 옵션을 삭제합니다.">삭제</a>
                            </span>
                        </div>
                        <!-- 숨기기체크 -> 숨김시 li. 추가 -->
                        <label class="btn_hide" title="옵션 노출">옵션 노출
                          <input type="checkbox" class="btn_hide_input pviews"  value="1" <?=$value->view=="Y" ? "checked":""?>/>
                        </label>
                      </td>
                    </tr>
                    <?php if($pass_mode =="second"): ?>
                     <tr> 
                       <td colspan="3">
                          <table class="table table-bordered">
                            <colgroup>
                              <col width="100px"/>  <col width="*"/><col width="150px"/>
                            </colgroup>
                             <tbody class="depth2">
                              <?php if(!empty($second[$value->id])): ?>
                              <?php foreach($second[$value->id] as $second_chd): ?>
                              <tr id="options_<?=$second_chd->id?>" data-id="<?=$second_chd->id?>">
                                <th class="mid text-center">2차 옵션<span class="ic_ess" title="필수"></span></th>
                                  <td class="mid">
                                    <div class="value">
                                      <!-- 이름입력 -->
                                      <span class="wrapping_name">
                                          <span class="txt_box">2차 옵션명</span>
                                          <input type="text"  class="input_design name" placeholder="2차 옵션명입력" value="<?=$second_chd->name?>" />
                                      </span>
                                      <!-- 값 입력 -->
                                      <span class="wrapping_num">
                                          <span class="txt_box">공급가</span>
                                          <input type="text"  class="input_design input_price optionprice" placeholder="0" value="<?=$second_chd->optionprice?>" />
                                      </span>
                                      <span class="wrapping_num">
                                          <span class="txt_box">판매가</span>
                                          <input type="text"  class="input_design input_price supply" placeholder="0" value="<?=$second_chd->supply?>" />
                                      </span>
                                      <span class="wrapping_num">
                                          <span class="txt_box">수량(재고)</span>
                                          <input type="text"  class="input_design input_number count" placeholder="0" value="<?=$second_chd->count?>" />
                                      </span>
                                      <span class="wrapping_num">
                                          <span class="txt_box">판매</span>
                                          <input type="text" class="input_design input_number" placeholder="0" value="<?=$second_chd->salecount?>" readonly="readonly" disabled="" />
                                      </span>
                                  </div>
                                  </td>
                                  <td class="mid text-center">
                                    <!-- 끼워넣기버튼 -->
                                    <div class="btn_add">
                                        <span class="shop_btn_pack">
                                          <a href="javascript:f_insert('update',<?=$value->id?>, <?=$second_chd->id?>);" class="btn btn-default btn-sm" >변경</a>
                                          <a href="javascript:f_insert('delete',0, '<?=$second_chd->id?>');" class="btn btn-sm btn-default" title="해당 옵션을 삭제합니다.">삭제</a>
                                        </span>
                                    </div>
                                    <!-- 숨기기체크 -> 숨김시 li. 추가 -->
                                    <label class="btn_hide" title="옵션 노출">옵션 노출
                                      <input type="checkbox" class="btn_hide_input pviews"  value="1" <?=$second_chd->view=="Y" ? "checked":""?>/>
                                    </label>
                                  </td>
                              </tr>  
                              <?php endforeach; ?>
                              <?php endif; ?>

                             </tbody>
                           </table>
                           <table class="table table-bordered">
                            <colgroup>
                              <col width="100px"/>  <col width="*"/><col width="150px"/>
                            </colgroup>
                             <tbody>
                               <tr class="add_options add_options2<?=$value->id?>">
                                <th class="mid text-center">2차 옵션<span class="ic_ess" title="필수"></span></th>
                                <td class="mid">
                                  <div class="value">
                                    <!-- 이름입력 -->
                                    <span class="wrapping_name">
                                        <span class="txt_box">2차 옵션명</span>
                                        <input type="text"  class="input_design name"  placeholder="2차 옵션명입력" value=""  />
                                    </span>
                                    <!-- 값 입력 -->
                                    <span class="wrapping_num">
                                        <span class="txt_box">공급가</span>
                                        <input type="text"  class="input_design input_price optionprice" placeholder="0" value="0" />
                                    </span>
                                    <span class="wrapping_num">
                                        <span class="txt_box">판매가</span>
                                        <input type="text" class="input_design input_price supply" placeholder="0" value="0" />
                                    </span>
                                    <span class="wrapping_num">
                                        <span class="txt_box">수량(재고)</span>
                                        <input type="text"  class="input_design input_number count" placeholder="0" value="0" />
                                    </span>
                                    <span class="wrapping_num">
                                        <span class="txt_box">판매</span>
                                        <input type="text" class="input_design input_number salecount"  placeholder="0" value="0" readonly="readonly" disabled="" />
                                    </span>
                                </div>
                                </td>
                                <td class="mid text-center">
                                  <!-- 끼워넣기버튼 -->
                                  <div class="btn_add">
                                      <span class="shop_btn_pack">
                                        <a href="javascript:f_insert('add',<?=$value->id?>,0,2,<?=$value->id?>);" class="btn btn-default btn-sm btn-block" >추가</a>
                                      </span>
                                  </div>
                                  <!-- 숨기기체크 -> 숨김시 li. 추가 -->
                                  <label class="btn_hide" title="옵션 노출">옵션 노출
                                    <input type="checkbox" class="btn_hide_input pviews" value="1" checked />
                                  </label>
                                </td>
                              </tr> 
                             </tbody>
                           </table>
                       </td>
                     </tr>
                    <?php endif;?>   
                  <?php endforeach; ?>
                  <?php endif; ?>
                </tbody>
              </table>
              <?php if($pass_mode !="second"): ?>
                <table class="table table-bordered table-striped">
                  <colgroup>
                    <col width="100px"/>  <col width="*"/><col width="150px"/>
                  </colgroup>
                  <tr class="add_options add_options1">
                    <th class="mid text-center">기본배송비<span class="ic_ess" title="필수"></span></th>
                    <td class="mid">
                      <div class="value">
                        <!-- 이름입력 -->
                        <span class="wrapping_name">
                            <span class="txt_box">1차 옵션명</span>
                            <input type="text"  class="input_design name"  placeholder="1차 옵션명입력" value=""  />
                        </span>
                        <!-- 값 입력 -->
                        <span class="wrapping_num">
                            <span class="txt_box">공급가</span>
                            <input type="text"  class="input_design input_price optionprice" placeholder="0" value="0" />
                        </span>
                        <span class="wrapping_num">
                            <span class="txt_box">판매가</span>
                            <input type="text" class="input_design input_price supply" placeholder="0" value="0" />
                        </span>
                        <span class="wrapping_num">
                            <span class="txt_box">수량(재고)</span>
                            <input type="text"  class="input_design input_number count" placeholder="0" value="0" />
                        </span>
                        <span class="wrapping_num">
                            <span class="txt_box">판매</span>
                            <input type="text" class="input_design input_number salecount"  placeholder="0" value="0" readonly="readonly" disabled="" />
                        </span>
                    </div>
                    </td>
                    <td class="mid text-center">
                      <!-- 끼워넣기버튼 -->
                      <div class="btn_add">
                          <span class="shop_btn_pack">
                            <a href="javascript:f_insert('add',0,0,1);" class="btn btn-default btn-sm btn-block" >추가</a>
                          </span>
                      </div>
                      <!-- 숨기기체크 -> 숨김시 li. 추가 -->
                      <label class="btn_hide" title="옵션 노출">옵션 노출
                        <input type="checkbox" class="btn_hide_input pviews" value="1" checked />
                      </label>
                    </td>
                  </tr> 
                </table>
              <?php endif; ?>
            </form>
          </div>
        </div>
      </div>
    </section>
  </div>
</body>
</html>

<style type="text/css">
  .btn_updown .shapeup {
    display: inline-block;
    width: 0;
    height: 0;
    border-left: 6px solid transparent;
    border-right: 6px solid transparent;
    border-bottom: 6px solid #c52121;
    margin-top: 7px;
  }
  .btn_updown .shapedw {
    display: inline-block;
    width: 0;
    height: 0;
    border-left: 6px solid transparent;
    border-right: 6px solid transparent;
    border-top: 6px solid #415685;
    margin-top: 7px;
  }
  .shop_btn_pack .small {
    padding: 0 7px;
    height: 23px;
    line-height: 25px;
    font-size: 11px;
    font-family: dotum;
    letter-spacing: -1px;
}
.shop_btn_pack .white {
    color: #5e5a5a!important;
    border: 1px solid #ababab!important;
    background: #ffffff!important;
}


.value .input_design {
    line-height: 25px;
    padding: 0 5px;
    border: 1px solid #ccc;
    width: 200px;
    float: left;
    height: 25px !important;
}
.value .txt_box {
    display: block;
    margin: 0 0 4px 0;
    font-size: 11px;
}
.value .input_price {
    width: 60px;
    text-align: right;
    font-weight: 600;
}

.value .input_number {
    width: 40px;
    text-align: right;
    font-weight: 600;
}
.value .wrapping_num {
    float: left;
    margin-right: 5px;
}
.value .wrapping_name {
    float: left;
    margin-right: 5px;
}
</style>

<script type="text/javascript">
  var pcode = "<?=$this->input->get("pcode")?>";
  var data = {};
  var view = "Y";
  function f_insert(mode="add",parent=0,id=0,t="",t1="") {
    var obj =$(".add_options"+t+""+t1); 
    if(mode =="update")
      obj = $("#options_"+id);
    var name = obj.find(".name").val();
    var optionprice = obj.find(".optionprice").val();
    var supply = obj.find(".supply").val();
    var count = obj.find(".count").val();  
    if(!obj.find(".pviews").is(':checked')){
      view = "N";
    }
    if(mode !="delete"){
      if(pcode.trim() =="")
      {
        alert("상품코드가 비였습니다.");
        return;
      }
       
      if(name.trim() == "")
      {
        alert("옵션명을 입력해주세요");
        return;
      }
    }

    else
    {
      if(!confirm("정말 삭제하시겠습니까?")){
        return;
      }
    }
    
    data =  { parent : parent,name:name,optionprice:optionprice,supply:supply,count:count,pcode:pcode,mode:mode,id:id,view:view }
    jQuery.ajax({
    type : "POST",
    dataType : "json",
    url : "<?=base_url("product_option_save")?>",
    data : data
    }).done(function(data){
      location.reload();
    }).fail(function (jqXHR, textStatus, errorThrown) { 
   }); 
  }

$(".depth<?=$dep?>").sortable({
  update: function(event, ui) {
    var ids = new Array();
    $(".depth<?=$dep?>").children().each(function(index,value){
      ids.push($(value).data("id"));
    }).promise().done(function(){
      jQuery.ajax({
      type : "POST",
      url : "<?=base_url("saveOrderOptions")?>",
      data : { ids : ids } 
      }).done(function(data){
      })
    });
  }
});

</script>