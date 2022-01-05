<div class="container">
  <div class="row">
    <div id="subLeft" class="col-md-2">
      <div class="LeftTitle">
        이용안내
      </div>
      <ul class="leftMenu">
        <li ><a href="/deliveryShow">배송대행 안내</a></li>
        <li ><a href="/buyShow">구매대행 안내</a></li>
        <li class="on"><a href="/delivery_price">배송비 안내</a></li>
        <li ><a href="/totalfee">종합수수료 안내</a></li>
        <li ><a href="/incomingNot">수입금지 품목</a></li>
        <li ><a href="/gwanbu">관부가세 안내</a></li>
      </ul>
    </div>
    <div id="subRight" class="col-md-10">
      <div class="padgeName">
        <h2>배송비안내</h2>
      </div>
      <div class="con">
        <div class="row">
            <div class="col-xs-12">
                <?php foreach($deliveryAddress as $value): ?>
                    <a href="<?=base_url()?>delivery_price?option=<?=$value->id?>" class="btn btn-primary"><?=$value->area_name?></a>
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
                                            <th><?=intval($childMans->sending_inul*$startPrice)?></th>
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