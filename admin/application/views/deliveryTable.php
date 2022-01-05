
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
          배송비요율표
      </h1>
    </section>
    <section class="content">
        <form action="./saveDeliveryTable" method="post">
            <div class="row">
              <div class="col-md-2 text-center">
                <p>시작요율금액</p>
              </div>
              <div class="col-md-4">
                <div class="row">
                    <div class="col-xs-6">
                        <select class="form-control" name="address">
                            <?php if(!empty($deliveryAddress)):
                                    foreach($deliveryAddress as $key=>$value): ?>
                                <option value="<?=$value->id?>"><?=$value->area_name?></option>
                            <?php 
                                    endforeach;
                                endif;  ?>
                        </select>
                    </div>
                    <div class="col-xs-6">
                        <input type="text" name="startPrice" value="0" class="form-control">
                    </div>
                </div>
              </div>
              <div class="col-md-2 text-center">
                <p>금액 간격</p>
              </div>
              <div class="col-md-2">
                <input type="text" name="goldSpace" value="0" class="form-control">
              </div>원
            </div>
            <div class="row">
              <div class="col-md-2 text-center">
                <p>시작무게~종료무게  </p>
              </div>
              <div class="col-md-4">
                <div class="row">
                    <div class="col-xs-6">
                        <select class="form-control" name="startWeight">
                            <?php $startWeight=0; ?>
                            <?php for($i=1;$i<=400;$i++){
                                    $startWeight=$startWeight+0.5;?>
                                <option value="<?=$startWeight?>"><?php echo $startWeight;?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="col-xs-6">
                        <select class="form-control" name="endWeight">
                            <?php $startWeight=0; ?>
                            <?php for($i=1;$i<=400;$i++){
                                    $startWeight=$startWeight+0.5;?>
                                <option value="<?=$startWeight?>"><?php echo $startWeight;?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
              </div>
              <div class="col-md-2 text-center">
                <p>무게간격</p>
              </div>
              <div class="col-md-2">
                <input type="text" name="weight" value="0.5" class="form-control">
              </div>kg
            </div>
            <div class="row my-4 my-3">
                <div class="col-xs-12">
                    <input type="submit" name="" class="btn btn-sm btn-primary" value="저장">
                    <input type="reset" name="" class="btn btn-sm" value="취소">
                </div>
            </div>
        </form>
        <div class="row">
            <div class="col-xs-6">
                <?php foreach($deliveryAddress as $key=>$value): ?>
                    <a href="<?=base_url()?>deliveryTable?option=<?=$value->id?>&role_id=<?=$this->input->get("role_id")?>" 
                      class="btn btn-primary <?=$options==$value->id ? "active":""?>">
                      <?=$value->area_name?></a>
                <?php endforeach; ?>
            </div>
        </div>
        <div class="row">
          <div class="col-md-4">
            <div class="box">
                <div class="box-body table-responsive no-padding">
                  <table class="table table-hover">
                    <tr class="thead-dark">
                        <th>ID</th>
                        <th>가격</th>
                        <th>시작무게</th>  
                        <th>종료무게</th>
                        <th>금액간격</th>
                        <th>무게간격</th>
                        <th>주소</th>
                        <th></th>
                      </tr>
                      <?php if(!empty($dtable)): ?>
                        <?php foreach($dtable as $value): ?>
                          <tr> 
                            <td><?=$value->id?></td>
                            <td><?=$value->startPrice?></td>
                            <td><a href="#" class="gotoS" data-wid="<?=$value->startWeight?>"><?=$value->startWeight?></a></td>
                            <td><a href="#" class="gotoS" data-wid="<?=$value->endWeight?>"><?=$value->endWeight?></a></td>
                            <td><?=$value->goldSpace?></td>
                            <td><?=$value->weight?></td>
                            <td><?=$value->area_name?></td>
                            <td><a class="btn btn-sm btn-danger delD" href="#" data-dtid="<?php echo $value->id; ?>"><i class="fa fa-trash"></i></a></td>
                          </tr>  
                        <?php endforeach;?>
                      <?php endif;?>
                  </table>
                </div>
              </div>
          </div>
            <div class="col-md-8">
              <div class="box">
                <div class="box-body table-responsive no-padding">
                  <table class="table table-hover">
                    <tr class="thead-dark">
                      <th>무게</th>
                        <?php foreach($man as $childMans): ?>
                            <th><?=$childMans->role?></th>
                        <?php endforeach; ?>
                    </tr>
                    <?php 
                    if(!empty($deliveryContents)): 
                      $startWeight=0;
                      $start1= 0;
                      $start2=0;
                      $startPrice = 0;
                      ?>

                      <?php foreach($deliveryContents as $value): ?>
                          <?php   $start1 = $value->startWeight;
                                  $start2 = $value->endWeight;  
                                  $startPrice = $value->startPrice;

                                  while($start1<=$start2){ ?>
                                  <tr id="ids<?=$start1*100?>">
                                      <th><?=$start1?></th>
                                      <?php foreach($man as $childMans): ?>
                                      <?php 
                                        $halin = $rate[$childMans->roleId][$options];
                                      ?>
                                          <th><?=intval($halin*$startPrice)?></th>
                                      <?php endforeach; ?>
                                  </tr>
                      <?php $start1 = $start1 + $value->weight;$startPrice = $startPrice + $value->goldSpace; } 
                      endforeach;  ?>
                    <?php endif; ?>
                  </table>
                </div><!-- /.box-body -->
              </div><!-- /.box -->
            </div>
        </div>
    </section>
</div>
<script type="text/javascript">
  $(".gotoS").click(function(){
    var id = $(this).data("wid")*100;
      $([document.documentElement, document.body]).animate({
        scrollTop: $("#ids"+id).offset().top-50
    }, 1000);
      $("#ids"+id).css("background","#b3aeb5");
  });
  jQuery(document).on("click", ".delD", function(){
    var dtid = $(this).data("dtid"),
      hitURL = baseURL + "deleteDtable",
      currentRow = $(this);
    
    var confirmation = confirm("정말 삭제하시게습니까?");
    
    if(confirmation)
    {
      jQuery.ajax({
      type : "POST",
      dataType : "json",
      url : hitURL,
      data : { dtid : dtid,sure:1 } 
      }).done(function(data){
        currentRow.parents('tr').remove();
        if(data.status = true) { alert("성곡적으로 삭제되였습니다."); window.location.reload();}
        else if(data.status = false) { alert("삭제 오유!"); }
        else { alert("접근요청 거절!"); }
      });
    }
  });
</script>