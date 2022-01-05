<?php 
if($cc==null) $cou=$ac;
else $cou = $ac-$cc;
?>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        가장구매가 많은상품
      </h1>
    </section>
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-body table-responsive no-padding">
              <table class="table table-hover">
                <colgroup>
                  <col wdith="*"></col>
                  <col wdith="62"></col>
                  <col width="300x"></col>
                </colgroup>
                <tr class="thead-dark">
                  <th class="text-center">No</th>
                  <th></th>
                  <th class="text-left">상품명</th>
                  <th>판매수</th>
                  <th class="text-center">브랜드/원산지</th>
                  <th class="text-center">수입원가/판매가/할인가</th>
                  <th class="text-center">적립포인트</th>
                </tr>
                <?php if(!empty($products)): ?>
                  <?php foreach($products as $value): ?>
                    <tr>
                      <td class="text-center"><?=$cou?></td>
                      <td>
                        <img src="/upload/shoppingmal/<?=$value->id?>/<?=$value->image?>" width="60" height="60">
                      </td>
                      <td class="text-left">
                        <span><?=$value->name?></span>
                      </td>
                      <td class="text-center"><?=$value->p_salecnt?></td>
                      <td class="text-center"><?=$value->brand?>/<?=$value->wonsanji?></td>
                      <td class="text-center"><?=$value->orgprice?> / <?=$value->singo?>(원)</td>
                      <td class="text-center"><?=$value->point?></td>
                      
                    </tr>
                    <?php $cou--; ?>
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
