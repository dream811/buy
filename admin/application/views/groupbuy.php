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
                <a class="btn btn-primary" href="<?php echo base_url(); ?>addProduct"><i class="fa fa-plus"></i>상품 등록</a>
            </div>
        </div>
      </div>
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
                  <label style="display:block; ">브랜드</label>
                  <input type="text" name="brands" class="form-control input-sm" style="width: 150px;" 
                   value="<?=empty($_GET['brands']) == 0 ? $_GET['brands']:"" ?>" >
               </div> 
               <div class="pull-right">
                 <label style="display:block; ">상품명</label>
                  <input type="text" name="search_pname"  class="form-control input-sm" style="width: 150px;" value="<?=empty($_GET['search_pname']) == 0 ? $_GET['search_pname']:"" ?>">
               </div> 
               <div class="pull-right">
                  <label style="display:block; ">진행여부</label>
                  <select name="shUseYn" id="shUseYn" class="form-control input-sm">
                    <option value="">=== 전체 ===</option>
                    <option value="1" <?=empty($_GET['shUseYn'])==0 && $_GET['shUseYn']==1 ? "selected":""?>>진행중</option>
                    <option value="0" <?=empty($_GET['shUseYn'])==0 && $_GET['shUseYn']==0 ? "selected":""?>>중지</option>
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
                <tr>
                  <th class="text-center">상품No</th>
                  <th class="text-center">상품명/브랜드</th>
                  <th class="text-center">이미지</th>
                  <th class="text-center">상품가격</th>
                  <th class="text-center">판매기간</th>
                  <th class="text-center">진행여부</th>
                  <th class="text-center">등록일</th>
                  <th>-</th>
                </tr>
                <?php if(!empty($groupBuy)): ?>
                  <?php foreach($groupBuy as $value): ?>
                    <tr>
                      <td class="text-center"><?=$value->id?></td>
                      <td class="text-center"><?=$value->name?><br><?=$value->brand?></td>
                      <td class="text-center"><img src="/upload/thumb/<?=$value->thumbnail?>" width="100" height="50" style="object-fit: cover"></td>
                      <td class="text-center"><?=$value->origin_price?><br><?=$value->product_price?></td>
                      <td class="text-center"><?=$value->sales_term?></td>
                      <td class="text-center"><?=$value->use==0 ? "중지":"사용" ?></td>
                      <td class="text-center"><?=$value->created_date?></td>
                      <td>
                          <a class="btn btn-sm btn-info" href="<?php echo base_url().'editProduct/'.$value->id; ?>">
                            <i class="fa fa-pencil"></i></a>
                          <a class="btn btn-sm btn-danger deleteProduct" href="#" data-pid="<?php echo $value->id; ?>">
                            <i class="fa fa-trash"></i></a></td>
                    </tr>
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
  jQuery(document).on("click", ".deleteProduct", function(){
    var pid = $(this).data("pid"),
      hitURL = baseURL + "deletePd",
      currentRow = $(this);
    
    var confirmation = confirm("정말 삭제하시게습니까?");
    
    if(confirmation)
    {
      jQuery.ajax({
      type : "POST",
      dataType : "json",
      url : hitURL,
      data : { pid : pid,sure:1 } 
      }).done(function(data){
        currentRow.parents('tr').remove();
        if(data.status = true) { alert("성곡적으로 삭제되였습니다."); }
        else if(data.status = false) { alert("삭제 오유! 상품이 존재하지 않습니다."); }
        else { alert("접근요청 거절!"); }
      });
    }
  });
  
</script>