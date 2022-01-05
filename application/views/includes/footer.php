<?php 
$content = "";
$ff = getFooterContent();
if(!empty($ff))
    $content= $ff[0]->description;
 $footer = getPages("footer");
?>
<?php 
if(!empty($accrate_default))
  $rate =  $accrate_default[0]->title." ". "<span class='font-weight-bold' style='font-size:16px;'>".$accrate_default[0]->rate."</span> 원";
else
  $rate = "";
?>

<div id="footer">
    <nav class="nav navbar-nav navbar-inverse">
        <div class="container">
            <ul class="nav navbar-nav ul-he">
            <?php if(!empty($footer)): ?>
            <?php foreach($footer as $value): ?>
            <li><a href="/ipage?id=<?=$value->id?>"><?=$value->title?></a></li>
            <?php endforeach; ?>
            <?php endif; ?>    
            <li><a href="/policy">개인정보취급방침</a></li>
            <li><a href="/usetext">이용약관</a></li>
            <li><a href="javascript:void()"><?=$rate?></a></li>
            </ul>
        </div>
    </nav>
    <div class="f_con container">
        <?php $content_class = 12; ?>
        <?php if(!empty($ff[0]->image)): ?>
        <?php     $content_class = $content_class-4; ?>
            <div class="bottom-logo col-md-4 text-center">
                <img src="/template/images/footer_logo.png" alt="이지몰">
            </div>
        <?php endif;?>
        <?php if(!empty($ff[0]->image1)): ?>
        <?php  $content_class = $content_class-4;?>
        <?php endif;?>
        <div class="copyright col-md-<?=$content_class?>"> 
            <p>
                <?=$content?>
            </p>
        </div>
        <form name="CERTMARK_FORM" method="POST">
          <input type="hidden" name="certMarkURLKey">
        </form>
         <?php if(!empty($ff[0]->image1)): ?>
        <div class="esc col-md-4 text-center"><a href=""><img src="/template/images/footer_logo_left.png" alt="에스크로"></a></div>
        <?php endif;?>
    </div>
    <?php 
        
        if (($detect->isMobile() || $detect->isTablet() || $detect->isAndroidOS())) { ?>
            <a href="http://m.taodalin.com" class="pc_to_mobile_btn btn-block" style="">모바일화면</a>
<?php  }
    ?>
</div>

</body>
</html>