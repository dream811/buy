<?php 
if($cc==null) $cou=$ac;
else $cou = $ac-$cc;
?>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        상품관리
      </h1>
    </section>
    <section class="content">
      <div class="row">
        <div class="col-xs-12 text-right">
            <div class="form-group">
                <a class="btn btn-primary" href="<?php echo base_url(); ?>addshop"><i class="fa fa-plus"></i>상품 등록</a>
            </div>
        </div>
      </div>
      <div class="row">
        <div class="col-xs-12">
           <form name="frmList" id="frmList" method="get" action="<?=base_url("shopProducts")?>"> 
            <div class="box-tools">   
              <div class="input-group" style="margin-bottom: 10px">
                <div class="pull-right">
                  <label style="display:block; ">&nbsp;</label>
                  <input class="btn btn-primary btn-sm" value="검색" type="submit">
               </div> 
               <div class="pull-right">
                 <label style="display:block; ">3차 카테고리</label>
                  <select class="form-control input-sm left-combo" name="left3" data-id="3" id="left3">
                    <option value="">선택하세요</option>
                    <?php if(!empty($left2_cates)): ?>
                    <?php foreach($left2_cates as $value):?>  
                    <option value="<?=$value->id?>" <?=$value->id == $this->input->get("left3") ? "selected" : ""?>><?=$value->name?></option>
                    <?php endforeach;?>
                    <?php endif; ?>
                  </select>
               </div>
               <div class="pull-right">
                 <label style="display:block; ">2차 카테고리</label>
                  <select class="form-control input-sm left-combo" name="left2" data-id="2" id="left2">
                    <option value="">선택하세요</option>
                    <?php if(!empty($left1_cates)): ?>
                    <?php foreach($left1_cates as $value):?>  
                    <option value="<?=$value->id?>" <?=$value->id == $this->input->get("left2") ? "selected" : ""?>><?=$value->name?></option>
                    <?php endforeach;?>
                    <?php endif; ?>
                  </select>
               </div>
               <div class="pull-right">
                 <label style="display:block; ">1차 카테고리</label>
                  <select class="form-control input-sm left-combo" name="left1" data-id="1" id="left1">
                    <option value="">선택하세요</option>
                    <?php if(!empty($left_category)): ?>
                    <?php foreach($left_category as $value):?>  
                    <option value="<?=$value->id?>" <?=$value->id == $this->input->get("left1") ? "selected" : ""?>><?=$value->name?></option>
                    <?php endforeach;?>
                    <?php endif; ?>
                  </select>
               </div>
               <div class="pull-right">
                  <label style="display:block; ">브랜드</label>
                  <input type="text" name="brands" class="form-control input-sm" style="width: 150px;" 
                   value="<?=empty($_GET['brands']) == 0 ? $_GET['brands']:"" ?>" >
               </div> 
               <div class="pull-right">
                 <label style="display:block; ">상품명</label>
                  <input type="text" name="search_pname"  class="form-control input-sm" style="width: 150px;" value="<?=empty($_GET['search_pname']) == 0 ? $_GET['search_pname']:"" ?>">
               </div>
               <div class="pull-right">
                 <label style="display:block; ">신상품</label>
                  <select class="form-control input-sm" name="search_new">
                    <option value="">=== 전체 ===</option>
                    <option value="1" <?=!empty($_GET['search_new'])  ? "selected" : ""?>>노출</option>
                  </select>
               </div>
               <div class="pull-right">
                 <label style="display:block; ">세일상품</label>
                  <select class="form-control input-sm" name="search_wow">
                    <option value="">=== 전체 ===</option>
                    <option value="1" <?=!empty($_GET['search_wow'])  ? "selected" : ""?>>노출</option>
                  </select>
               </div>
               <div class="pull-right">
                 <label style="display:block; ">베스트상품</label>
                  <select class="form-control input-sm" name="search_best">
                    <option value="">=== 전체 ===</option>
                    <option value="1" <?=!empty($_GET['search_best'])  ? "selected" : ""?>>노출</option>
                  </select>
               </div>
               <div class="pull-right">
                  <label style="display:block; ">진행여부</label>
                  <select name="shUseYn" id="shUseYn" class="form-control input-sm">
                    <option value="">=== 전체 ===</option>
                    <option value="1" <?=$this->input->get("shUseYn") !=null && $this->input->get("shUseYn")==1 ? "selected":""?>>진행중</option>
                    <option value="0" <?=$this->input->get("shUseYn") !=null && $this->input->get("shUseYn")==0 ? "selected":""?>>중지</option>
                  </select>
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
              <table class="table table-hover">
                <colgroup>
                  <col wdith="*"></col>
                  <col wdith="62"></col>
                  <col width="300x"></col>
                </colgroup>
                <tr class="thead-dark">
                  <th class="text-center">No</th>
                  <th></th>
                  <th class="text-left">상품명</th>
                  <th class="text-center">브랜드/원산지</th>
                  <th class="text-center">수입원가/판매가/할인가</th>
                  <th class="text-center">적립포인트</th>
                  <th class="text-center">판매수</th>
                  <th class="text-center">무게</th>
                  <th class="text-center">노출여부</th>
                  <th class="text-center">등록일</th>
                  <th></th>
                </tr>
                <?php if(!empty($products)): ?>
                  <?php foreach($products as $value): ?>
                    <tr>
                      <td class="text-center"><?=$cou?></td>
                      <td>
                        <img src="/upload/shoppingmal/<?=$value->id?>/<?=$value->image?>" width="60" height="60">
                      </td>
                      <td class="text-left">
                        <span><?=$value->name?></span>
                      </td>
                      <td class="text-center"><?=$value->brand?>/<?=$value->wonsanji?></td>
                      <td class="text-center"><?=$value->orgprice?> / <?=$value->singo?>(원)</td>
                      <td class="text-center"><?=$value->point?></td>
                      <td class="text-center"><?=$value->p_salecnt?></td>
                      <td class="text-center"><?=$value->weight?></td>
                      <td class="text-center"><?=$value->use==0 ? "숨김":"노출" ?></td>
                      <td class="text-center"><?=$value->updated_date ?></td>
                      <td>
                          <a class="btn btn-sm btn-info" href="<?php echo base_url().'editsproduct/'.$value->id; ?>">
                            <i class="fa fa-pencil"></i></a>
                          <a class="btn btn-sm btn-danger deletesproduct" href="#" data-spid="<?php echo $value->id; ?>">
                            <i class="fa fa-trash"></i></a></td>
                    </tr>
                    <?php $cou--; ?>
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
      hitURL = baseURL + "deletesproduct",
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
  

  $(".left-combo").change(function(){
    var p = 0;
    p = parseInt($(this).data("id")) + 1;
    var current = $(this).val();
    var next = $("#left"+p);
    if(p < 4 ){
      jQuery.ajax({
        type : "POST",
        dataType : "json",
        url :  "<?=base_url()?>getshopcategory",
        data : { id:current,type:"list"},
        beforeSend: function(xhr) {
          ajax_returned =0; 
        }
        }).done(function(data){
          var result = data.result;
          next.html("");
          next.append( new Option("선택하세요","") );
          if(result.length > 0){
            
            jQuery.each(result,function(index,value){ 
              next.append( new Option(value.name,value.id) );
            });
          }
      });
    }
  })
</script>