<div class="container">
  <div class="row">
    <div id="subLeft" class="col-md-3">
      <div class="LeftTitle">
        이용안내
      </div>
      <ul class="leftMenu">
        <?php  foreach($header as $value): ?>
          <?php $link = "/ipage?id=".$value->id; ?>
          <li class="<?php if($_SERVER['REQUEST_URI'] == $link) echo  "on"; ?>"><a href="/ipage?id=<?=$value->id?>">
            <?=$value->title?></a></li>
        <?php  endforeach; ?>
        <li class="<?=strpos($_SERVER['REQUEST_URI'],"delivery_price") !==false ? "on":"" ?>"><a href="/delivery_price">배송비안내</a></li>


      </ul>
    </div>
    <div id="subRight" class="col-md-9">
      <div class="row">
        <div class="col-md-12">
          <div class="padgeName">
            <h2>배송비안내</h2>
          </div>
        </div>
      </div>
      <div class="con">
        <div class="row">
            <div class="col-xs-12">
                <?php foreach($deliveryAddress as $value): ?>
                    <a href="<?=base_url()?>delivery_price?option=<?=$value->id?>" class="btn btn-rok text-white"><?=$value->area_name?></a>
                <?php endforeach; ?>
            </div>
        </div>
        <div class="row my-4">
            <div class="col-xs-12">
              <div class="box">
                <div class="box-body table-responsive no-padding">
                  <table class="table table-hover">
                    <thead class="thead-jin">
                      <tr >
                        <th>무게</th>
                          <?php foreach($man as $childMans): ?>
                              <th><?=$childMans->role?></th>
                          <?php endforeach; ?>
                      </tr>
                    </thead>
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
                                        <td><?=$start1?></td>
                                        <?php foreach($man as $childMans): ?>
                                            <td><?=number_format(intval($childMans->sending_inul*$startPrice))?></td>
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