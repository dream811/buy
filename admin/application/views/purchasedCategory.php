<?php 
$t = !empty($products) ?  sizeof($products) : 0;
?>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        가장 구매수가 많은 카테고리
      </h1>
    </section>
    <section class="content">
      <div class="row">
        <div class="col-md-4">
          <div class="box">
            <div class="box-body table-responsive no-padding">
              <table class="table table-hover">
                <tr class="thead-dark">
                  <th class="text-left mid">No</th>
                  <th class="text-left mid">카테고리명</th>
                  <th class="mid">구매수</th>
                </tr>
                <?php if(!empty($products)): ?>
                  <?php foreach($products as $value): ?>
                    <tr>
                      <td class="text-left mid"><?=$t?></td>
                      <td class="text-left mid"><a href="<?=base_url_source()?>shopping?txt-category=<?=$value->category_code?>&inc=none" target="_blank"><?=$value->name?></a></td>
                      <td class="text-left mid"><?=$value->purchase?></td>
                    </tr>
                    <?php $t--; ?>
                  <?php endforeach; ?>
                <?php endif; ?>
              </table>
            </div><!-- /.box-body -->
            <div class="box-footer clearfix">
            </div>
          </div><!-- /.box -->
        </div>
      </div>
    </section>
</div>
