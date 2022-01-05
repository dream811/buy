<?php $this->load->view("ipage_header",NULL); ?>
<div class="container">
  <div class="row">
    <div id="subRight" class="col-xs-12">
      <div class="padgeName">
        <h2>배송비안내</h2>
      </div>
      <div class="con">
        <div class="row">
            <div class="col-xs-12">
                <?php foreach($deliveryAddress as $value): ?>
                    <a href="<?=base_url()?>delivery_price?option=<?=$value->id?>" class="btn 
                      <?php  if($value->id == $this->input->get("option")) echo "btn-warning"; else echo "btn-primary";  ?>  btn-block mb-5 "><?=$value->area_name?></a>
                <?php endforeach; ?>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
              <div class="box">
                <div class="box-body table-responsive no-padding">
                  <table class="table table-hover">
                    <tr>
                      <th>무게</th>
                        <?php foreach($man as $childMans): ?>
                            <th><?=$childMans->role?></th>
                        <?php endforeach; ?>
                    </tr>
                    <?php if(!empty($deliveryContents)): 
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
                                    <tr>
                                        <th><?=$start1?></th>
                                        <?php foreach($man as $childMans): ?>
                                            <th><?=number_format(intval($childMans->sending_inul*$startPrice))?></th>
                                        <?php endforeach; ?>
                                    </tr>
                        <?php $start1 = $start1 + $value->weight;$startPrice = $startPrice + $value->goldSpace; } endforeach;  ?>
                    <?php endif; ?>
                  </table>
                </div>
              </div>
            </div>
        </div>
      </div>
    </div>
  </div>
</div>