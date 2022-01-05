<?php
$id = "";
$product_image = "";
$product_name= "";
$product_code = "";
$username = "";
$nickname = "";
$userId = "";
$title = "";
$content = "";
$eval_point = "";
$child_id ="";
$child_content="";
$image = "";
$intype = "";
if(!empty($parent)){
    foreach($parent as $value){
        if($value->depth ==1){
            $product_image = "<img src='/upload/shoppingmal/".$value->pid."/".$value->image."' width ='220'/>";
            $product_name = $value->pname;
            $product_code = $value->pcode;
            $username = $value->uname;
            $nickname = $value->nickname;
            $title = $value->title;
            $content = $value->content;
            $eval_point = $value->eval_point;
            $id =$value->id;
            $userId = $value->userId;
            $image =$value->img;
        }
        else{
            $child_id = $value->id;
            $child_content = $value->content;
            $intype = $value->intype;
        }
    }
}
?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <i class="fa fa-users"></i> <?=$this->input->get("type")=="eval" ? "상품평관리":"상품문의관리"?>
      </h1>
    </section>
    <section class="content">
        <div class="row">
            <!-- left column -->
            <div class="col-md-8">
              <!-- general form elements -->
                <div class="box box-primary">
                    <?php if($this->input->get("status") =='reply'): ?>
                    <div class="box-body">    
                        <div class="row">
                            <div class="col-md-12">
                                <table class="table table-bordered border-jin">
                                    <colgroup>
                                        <col width="150px"></col>
                                    </colgroup>
                                    <tr>
                                        <th class="mid">상품정보</th>
                                        <td><?=$product_image?><br><?=$product_name?><br><?=$product_code?></td>
                                    </tr>
                                    <tr>
                                        <th>글등록자</th>
                                        <td>
                                            <?=$username?><br><a href="/admin/editOld/<?=$userId?>" class="text-primary">(<?=$nickname?>)</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>부모글제목</th>
                                        <td><?=$title?></td>
                                    </tr>
                                    <tr>
                                        <th>부모글내용</th>
                                        <td><?=$content?></td>
                                    </tr>
                                    <?php if($this->input->get("type") == 'eval'): ?>
                                    <tr>
                                        <th>평점</th>
                                        <td><div class="my_eval"></div></td>
                                    </tr>
                                    <?php endif; ?>
                                </table>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>
                    <?php if($this->input->get("mode") == "modify" && $this->input->get("status") != "reply"): ?>
                    <?php echo form_open_multipart('updateProductTalk');?>
                        <input type="hidden" name="type" value="<?=$this->input->get("type")?>">
                        <input type="hidden" name="mode" value="<?=$this->input->get("mode")?>">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <table class="table table-bordered border-jin">
                                        <colgroup>
                                            <col width="150px"></col>
                                        </colgroup>
                                        <tbody>
                                            <tr>
                                                <th class="mid">작성자</th>
                                                <td class="mid">
                                                    <input type="hidden" name="id" value="<?=$id?>">
                                                    <input type="text"  required value="<?=$username?>" disabled>
                                                </td>
                                            </tr>
                                            <?php if($this->input->get("type") == 'eval'): ?>
                                            <tr>
                                                <th class="mid">이미지</th>
                                                <td class="mid text-center">
                                                    <?php if(!empty($image)): ?>
                                                    <img src="/upload/request/<?=$image?>" />
                                                    <br>
                                                    <a href="javascript:deleteReqeustImage(<?=$id?>,'<?=$image?>')" class="text-danger">이미지 삭제</a>    
                                                    <?php endif; ?>
                                                    <?php if(empty($image)): ?>
                                                    <input type="file" name="img">
                                                    <?php endif;?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th class="mid">평점</th>
                                                <td class="mid">
                                                    <div class="my_eval_edit" data-rating="<?=$eval_point?>"></div>
                                                    <input type="hidden" name="eval_point" id="eval_point" value="<?=$eval_point?>">
                                                </td>
                                            </tr>
                                            <?php endif; ?>
                                            <tr>
                                                <th class="mid">본문제목</th>
                                                <td class="mid"><input type="text" name="title" value="<?=$title?>" class="form-control" required></td>
                                            </tr>
                                            <tr>
                                                <th class="mid">본문내용</th>
                                                <td class="mid"><textarea class="form-control" name="content"><?=$content?></textarea></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>  
                        </div> 
                        <div class="box-footer text-center">
                            <input type="submit" value="확인" class="btn btn-danger">
                            <a href="/admin/product_talk?type=<?=$this->input->get("type")?>" class="btn btn-secondary">목록</a>
                        </div>
                    </form>
                    <?php endif; ?>
                    <?php if($this->input->get("status") =='reply'): ?>
                    <?php echo form_open_multipart('updateProductTalk');?>
                        <input type="hidden" name="type" value="<?=$this->input->get("type")?>">
                        <input type="hidden" name="relation" value="<?=$id?>">
                        <input type="hidden" name="id" value="<?=$child_id?>">
                        <input type="hidden" name="status" value="reply">
                        <input type="hidden" name="depth" value="2">
                        <input type="hidden" name="pcode" value="<?=$product_code?>">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <table class="table table-bordered border-jin">
                                        <colgroup>
                                            <col width="150px"></col>
                                        </colgroup>
                                        <tbody>
                                            <tr>
                                                <th class="mid">작성자</th>
                                                <td class="mid">
                                                    <input type="hidden"  required name="userId" value="<?=$this->session->userdata("userId")?>">
                                                    <select name="intype" class="form-control" style="width: 150px">
                                                        <option value="admin" <?=$intype =="admin" ? "selected":""?>>admin</option>
                                                        <option value="company" <?=$intype =="company" ? "selected":""?>>company</option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th class="mid">댓글내용</th>
                                                <td class="mid"><textarea class="form-control" name="content"><?=$child_content?></textarea></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>  
                        </div> 
                        <div class="box-footer text-center">
                            <input type="submit" value="확인" class="btn btn-danger">
                            <a href="/admin/product_talk?type=<?=$this->input->get("type")?>" class="btn btn-secondary">목록</a>
                        </div>
                    </form>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>
</div>
<link href="/assets/plugins/ratings/star-rating-svg.css" rel="stylesheet">
<script src="/assets/plugins/ratings/jquery.star-rating-svg.js"></script>
<?php if($this->input->get("status") =='reply'): ?>
<script>
    $(".my_eval").starRating({
        readOnly:true,
        initialRating: <?=$eval_point?>,
        disableAfterRate: true,
        starShape: 'rounded',
        starSize: 20,
        emptyColor: 'lightgray',
        hoverColor: 'salmon',
        minRating: 0,
        activeColor: 'crimson'
    });
</script>
<?php endif;?>
<?php if($this->input->get("mode") =='modify' && $this->input->get("type") =='eval'): ?>
<script>
    $(".my_eval_edit").starRating({
        initialRating: <?=$eval_point?>,
        disableAfterRate: true,
        starSize: 40,
        emptyColor: 'lightgray',
        hoverColor: 'salmon',
        activeColor: 'crimson',
        minRating: 0,
        callback: function(currentRating, $el){
            $("#eval_point").val(currentRating);
        }
    });
</script>
<?php endif;?>
<script>
    function deleteReqeustImage(id,img){
        var con =  confirm("정말 삭제하시겠습니까?");
        if (!con) return;
        jQuery.ajax({
            type : "POST",
            dataType : "json",
            url : baseURL + "deleteRequestImage",
            data : { id : id,img : img }
            }).done(function(data){
                location.reload();
        });
    }
</script>