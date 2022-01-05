<div class="mt-20">
    <?php if(!empty($caan)): ?>
    <?php foreach($caan as $value): ?>
       <a href="<?=$value->link?>" target="_blink"><img src="<?=base_url_home()?>upload/homepage/banner_r/<?=$value->image?>" class="w-100"></a>
    <?php endforeach; ?>
    <?php endif; ?>
  </div>
  <div class="mt-20">
    <?php if(!empty($inan)): ?>
    <?php foreach($inan as $value): ?>
       <a href="<?=$value->link?>" target="_blink"><img src="<?=base_url_home()?>upload/homepage/banner_r/<?=$value->image?>" class="w-100"></a>
    <?php endforeach; ?>
    <?php endif; ?> 
  </div>
<?php 
$content = "";
$ff = getFooterContent();
if(!empty($ff))
    $content= $ff[0]->description;
?>
<?php 
if(!empty($accrate_default))
  $rate =  $accrate_default[0]->title." ". "<span class='font-weight-bold' style='font-size:16px;'>".$accrate_default[0]->rate."</span> 원";
else
  $rate = "";
?>
  <div class="footer-parts border border-primary border-top mt-20">
    <div class="bg-green p-10 text-center">
      <?=$rate
      ?>
    </div>
    <div class="row p-10">
      <?php if(!empty($footer)): ?>
      <?php $footer = array_chunk($footer, 4); ?>
      <?php foreach($footer as $v): ?>
     	<div class="row">
        <div class="col-md-5th-1 p-3 ellipsis text-center" style="position: relative;">
          <a href="/">Home</a>
          <div class="border-half"></div>
        </div>
        <div class="col-md-5th-1 p-3 ellipsis text-center" style="position: relative;">
          <a href="/usetext">이용약관</a>
          <div class="border-half"></div>
        </div>
        <div class="col-md-5th-1 p-3 ellipsis text-center" style="position: relative;">
          <a href="/policy">개인정보취급방침</a>
          <div class="border-half"></div>
        </div>
        <div class="col-md-5th-1 p-3 ellipsis text-center" style="position: relative;">
          <a href="<?=base_url_home()?>?webview=1">PC버전</a>
          <div class="border-half"></div>
        </div>
     		<div class="col-md-5th-1 p-3 ellipsis text-center" style="position: relative;">
     			<a href="/panel?id=idWQn">고객센터</a>
     		</div>
     	</div>
      <?php endforeach; ?>
      <?php endif; ?>
      <div class="row mt-10">
        <div class="copyright col-md-12"> 
          <p>
              <?=$content?>
          </p>
        </div>
      </div>
    </div>
  </div>
</body>
</html>