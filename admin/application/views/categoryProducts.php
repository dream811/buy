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
                <a class="btn btn-primary" href="<?php echo base_url(); ?>editCategory"><i class="fa fa-plus"></i>카테고리 등록</a>
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
                  <label style="display:block; ">카테고리명</label>
                  <input type="text" name="name" class="form-control input-sm" style="width: 150px;" 
                   value="<?=empty($_GET['name']) == 0 ? $_GET['name']:"" ?>" >
               </div> 
               <div class="pull-right">
                  <label style="display:block; ">진행여부</label>
                  <select name="shUseYn" id="shUseYn" class="form-control input-sm">
                    <option value="">=== 전체 ===</option>
                    <option value="1" <?=$this->input->get("shUseYn") !=null && $this->input->get("shUseYn")==1 ? "selected":""?>>진행중</option>
                    <option value="0" <?=$this->input->get("shUseYn") !=null && $this->input->get("shUseYn")==0 ? "selected":""?>>중지</option>
                  </select>
               </div>
              </div>
            </div>
          </form>
          <div class="box">
            <div class="box-body table-responsive no-padding">
              <table class="table table-hover">
                <tr class="thead-dark">
                  <th class="text-center">No</th>
                  <th class="text-center">카테고리명</th>
                  <th>이미지</th>
                  <th class="text-center">노출여부</th>
                  <th class="text-center"></th>
                  <th></th>
                </tr>
                <?php if(!empty($categories)): ?>
                  <?php foreach($categories as $value): ?>
                    <tr>
                      <td class="text-center mid"><?=$value->id?></td>
                      <td class="text-center mid">
                        <?=$value->name?>
                      </td>
                      <td>
                        <?php if(!empty($value->image)): ?>
                         <img src="<?=base_url_source()?>upload/image/<?=$value->image?>" width=50> 
                        <?php endif;  ?>
                      </td>
                      <td class="text-center mid"><?=$value->use==0 ? "중지":"사용" ?></td>
                      <td class="mid">
                        <a class="btn btn-sm btn-info" href="<?php echo base_url().'editCategory/'.$value->id; ?>">
                          <i class="fa fa-pencil"></i></a>
                        <a class="btn btn-sm btn-danger del_cats" href="#" data-spid="<?php echo $value->id; ?>">
                          <i class="fa fa-trash"></i></a>
                      </td>
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
  jQuery(document).on("click", ".del_cats", function(){
    var spid = $(this).data("spid"),
      hitURL = baseURL + "del_cats",
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