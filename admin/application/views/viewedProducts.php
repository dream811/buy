<?php 
if($cc==null) $cou=$ac;
else $cou = $ac-$cc;
?>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        가장 뷰가 많은상품
      </h1>
    </section>
    <section class="content">
      <div class="row">
        <div class="col-md-6">
            <div class="box-body table-responsive no-padding">
              <table class="table table-hover">
                <colgroup>
                  <col>
                  <col>
                  <col width="300px">
                </colgroup>
                <tr class="thead-dark">
                  <th class="text-left mid">No</th>
                  <th class="mid"></th>
                  <th class="text-left mid">상품명</th>
                  <th class="mid">뷰수</th>
                  <th class="text-left mid">브랜드/원산지</th>
                  <th class="text-left mid">적립포인트</th>
                </tr>
                <?php if(!empty($products)): ?>
                  <?php foreach($products as $value): ?>
                    <tr>
                      <td class="text-left mid"><?=$cou?></td>
                      <td>
                        <a href="<?=base_url_source()?>view/shop_products/<?=$value->rid?>" target="_blank">
                          <img src="/upload/shoppingmal/<?=$value->id?>/<?=$value->image?>" width="60" height="60">
                        </a>
                      </td>
                      <td class="text-left mid">
                        <a href="<?=base_url_source()?>view/shop_products/<?=$value->rid?>" target="_blank"><span><?=$value->name?></span></a>
                      </td>
                      <td class="text-left mid font-weight-bold"><strong><?=$value->view?></strong></td>
                      <td class="text-left mid"><?=$value->brand?>/<?=$value->wonsanji?></td>
                      <td class="text-left mid"><?=$value->point?></td>
                      
                    </tr>
                    <?php $cou--; ?>
                  <?php endforeach; ?>
                <?php endif; ?>
              </table>
            </div><!-- /.box-body -->
            <div class="box-footer clearfix">
              <?php echo $this->pagination->create_links(); ?>
            </div>
        </div>
      </div>
    </section>
</div>
