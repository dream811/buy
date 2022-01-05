<?php 
$ss = sizeof($icons);
?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        상품아이콘관리
      </h1>
    </section>
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
           <form name="frmList" id="frmList" method="get" action="<?=base_url()?>ico"> 
            <div class="box-tools">   
              <div class="input-group" style="margin-bottom: 10px">
                <div class="pull-right" style="margin-left: 10px">
                  <label style="display:block; ">&nbsp;</label>
                  <a class="btn btn-primary btn-sm" href="<?php echo base_url(); ?>addIcon"><i class="fa fa-plus"></i>등록</a>
                </div>
                <div class="pull-right" style="margin-left: 10px">
                  <label style="display:block; ">&nbsp;</label>
                  <input class="btn btn-primary btn-sm" value="검색" type="submit">
               </div> 
               <div class="pull-right">
                  <label style="display:block; ">아이콘타이틀 </label>
                  <input type="text" name="brands" class="form-control input-sm" style="width: 150px;" 
                   value="<?=empty($_GET['name']) == 0 ? $_GET['name']:"" ?>" >
               </div> 
              </div>
            </div>
          </form>
          <div class="box">
            <div class="box-body table-responsive no-padding">
              <table class="table table-hover">
                <tr class="thead-dark">
                  <th class="text-center">No</th>
                  <th class="text-center">아이콘이름</th>
                  <th class="text-center">아이콘이미지</th>
                  <th class="text-center">관리</th>
                  <th></th>
                </tr>
                <?php if(!empty($icons)): ?>
                  <?php foreach($icons as $value): ?>
                    <tr>
                      <td class="text-center"><?=$ss?></td>
                      <td class="text-center"><?=$value->name?></td>
                      <td class="text-center">
                        <img src="/upload/Products/icon/<?=$value->icon?>" width="32">
                      </td>
                      <td class="text-center">
                          <a class="btn btn-sm btn-info" href="<?php echo base_url().'addIcon?id='.$value->id; ?>">
                            <i class="fa fa-pencil"></i></a>
                          <a class="btn btn-sm btn-danger deleteIconItem" href="#" data-iconid="<?php echo $value->id; ?>">
                            <i class="fa fa-trash"></i></a></td>
                    </tr>
                    <?php $ss = $ss -1 ?>
                  <?php endforeach; ?>
                <?php endif; ?>
              </table>
            </div><!-- /.box-body -->
          </div><!-- /.box -->
        </div>
      </div>
    </section>
</div>
<script>
  jQuery(document).on("click", ".deleteIconItem", function(){
    var id = $(this).data("iconid"),
      hitURL = baseURL + "deleteIconItem",
      currentRow = $(this);
    
    var confirmation = confirm("Are you sure to delete this item ?");
    
    if(confirmation)
    {
      jQuery.ajax({
      type : "POST",
      dataType : "json",
      url : hitURL,
      data : { id : id} 
      }).done(function(data){
        console.log(data);
        currentRow.parents('tr').remove();
        if(data.status = true) { alert("Successfully deleted"); }
        else if(data.status = false) { alert("Deletion failed"); }
        else { alert("Access denied..!"); }
      });
    }
  });
</script>