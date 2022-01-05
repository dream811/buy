<?php

$name = '';
$icon ='';
$id= 0;
$order = '';

if(!empty($icons))
    foreach ($icons as $uf)
    {
        $id = $uf->id;
        $name = $uf->name;
        $order = $uf->order;
        $icon = !empty($uf->icon) ? "/upload/Products/icon/".$uf->icon : "";
    }    
?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        상품아이콘 관리
      </h1>
    </section>
    <section class="content">
        <div class="row">
            <!-- left column -->
            <div class="col-md-6">
              <!-- general form elements -->
                <div class="box box-primary">
                    <?php echo form_open_multipart('CreateIcon');?>
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="name">아이콘 타이틀</label>
                                        <input type="text" class="form-control required" id="name" name="name"  value="<?=$name?>" required maxlength="200">
                                        <input type="hidden" name="id" value="<?=$id?>" id="id">
                                    </div>
                                </div>
                            </div>
                            <div class="row">    
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="brand">아이콘이미지(60 X 18)</label>
                                        <?php if(!empty($icon)): ?>
                                    	<div>
                                    		<img src="<?=$icon?>" width="32">
                                    		<a href="javascript:void(0)" onclick="deleteIcon('<?=$icon?>',<?=$id?>)" class="text-danger font-weight-bold">삭제</a>
                                    	</div>
                                        <?php endif; ?>
                                    	<?php if(empty($icon)): ?>
                                    		<input type="file" class="form-control"  name="icon">
                                    	<?php endif; ?>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                            	<div class="col-md-6">
                            		<div class="form-group">
                                        <label for="name">노출순위</label>
                                        <input type="number" class="" id="order" name="order"  value="<?=$order?>">
                                    </div>
                            	</div>
                            </div>
                            
                        </div><!-- /.box-body -->
                        <div class="box-footer">
                            <input type="submit" class="btn btn-primary" value="저장" />
                            <input type="button" class="btn btn-default" value="취소" onclick="location.href='<?=base_url()?>ico'" />
                        </div>
                    </form>
                </div>
            </div>
        </div>    
    </section>
</div>


<script>

function deleteIcon(url,id){
    var message = confirm("이 첨부파일을 삭제하시겠습니까?");
    var hitURL = baseURL + "deleteIconImage";
    if(message){
        jQuery.ajax({
        type : "POST",
        dataType : "json",
        url : hitURL,
        data : { id : id,url:url} ,
        }).done(function(data){
            if(data.status ==null)
            {
                alert("서버오류");
                return;
            }
            if(data.status ==0)
            {
                alert("이미지가 존재하지 않습니다.");
                location.reload();
                return;
            }
            else{
                location.reload();
            }  
        }).fail(function (jqXHR, textStatus, errorThrown) { 
            location.reload();
        }); 
    }
}

</script>
