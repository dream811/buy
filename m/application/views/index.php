<link href="<?=base_url_home()?>assets/plugins/ratings/star-rating-svg.css" rel="stylesheet">
<link href="<?php echo site_url('/template/css/style.css?'.time());?>" rel="stylesheet">
<script src="<?=base_url_home()?>assets/plugins/ratings/jquery.star-rating-svg.js"></script>
<script src="<?=base_url()?>template/js/index.js?<?=time()?>"></script>
<div class="theme-showcase" role="main">
  <div class="logo-section clrBoth text-center">
    <div class="row">
      <div class="logos carousel slide" data-ride="carousel" id="logos">
        <ol class="carousel-indicators">
          <?php if(!empty($banner)): ?>
          <?php foreach($banner as $keys=>$value): ?>
          <li data-target="#logos" data-slide-to="<?=$keys?>" class="<?=$keys ==0 ? "active":""?>"></li>
          <?php endforeach; ?>
          <?php endif; ?>
        </ol>
        <div class="carousel-inner" role="listbox">
            <?php if(!empty($banner)): ?>
              <?php foreach($banner as $keys=>$value): ?>
                <div class="item <?=$keys==0 ? "active":""?>">
                  <a href="<?=$value->link == ""? "#":$value->link?>" target="<?=$value->target==2 ? "_blink":""?>">
                    <img  data-src="/upload/homepage/banner/<?=$value->image?>" src="/upload/homepage/banner/<?=$value->image?>" data-holder-rendered="true" class="w-100">
                  </a>
                </div>
              <?php endforeach; ?>
            <?php endif; ?>
        </div>
         <a class="left carousel-control" href="#logos" data-slide="prev">
            <img src="<?=base_url_home()?>assets/images/banner_l.png" class="im-left">
          </a>
          <a class="right carousel-control" href="#logos" data-slide="next">
            <img src="<?=base_url_home()?>assets/images/banner_r.png" class="im-right">
          </a>
      </div>
    </div>
  </div>
</div>
<div class="second-parts">
  <div class="go-part bg-green carousel slide" data-ride="carousel" id="go-part">
    <div class="fl ml-15">
      <p class="text-white" style="font-size: 14px;">[공지]</p>
    </div>
    <div class="carousel-inner fl ml-15" role="listbox">
    <?php if(!empty($ques)): ?>
      <?php foreach($ques as $keys=>$value): ?>
        <div class="item <?=$keys==0 ? "active":""?> ellipsis">
         <a href="/post/view/<?=$value->id?>?id=<?=$value->iden?>" class="text-white" style="font-size: 14px"><?=$value->title?></a>
        </div>
      <?php endforeach; ?>
    <?php endif; ?>
    </div>
    <a class="right carousel-control" href="#go-part" data-slide="next">
      >
    </a>
</div>
  <div class="main-top">
    <ul class="row">
        <li class="col-xs-3 col-md-2"><a href="/ipage?id=134">
          <img src="/template/images/1.using.png" class="img-responsive" alt=""><span>이용안내</span></a></li>
        <li class="col-xs-3 col-md-2"><a href="/delivery">
          <img src="/template/images/2.delusing.png" class="img-responsive" alt=""><span>배송대행 신청</span></a></li>
        <li class="col-xs-3 col-md-2"><a href="/delivery?option=buy">
          <img src="/template/images/3.buyusing.png" class="img-responsive" alt=""><span>구매대행 신청</span></a></li>
        <li class="col-xs-3 col-md-2"><a href="/taoshopping">
          <img src="template/images/4.shop.png" class="img-responsive" alt=""><span>쇼핑몰</span></a></li>
        <li class="col-xs-3 col-md-2"><a href="/panel?id=RCNIr">
          <img src="/template/images/5.notice.png" class="img-responsive" alt=""><span>공지사항</span></a></li>
        <li class="col-xs-3 col-md-2"><a href="/private?option=my">
          <img src="/template/images/6.11.png" class="img-responsive" alt=""><span>1:1문의</span></a></li>
        <li class="col-xs-3 col-md-2"><a href="/panel?id=idWQn">
          <img src="/template/images/7.usingafter.png" class="img-responsive" alt=""><span>이용후기</span></a></li>
        <li class="col-xs-3 col-md-2"><a href="/panel?id=RCNIr">
          <img src="/template/images/8.customer.png" class="img-responsive" alt=""><span>고객센터</span></a></li>
    </ul>
  </div>
  <div class="mConBox7 row mt-20">
    <div class="col-md-12 p-0">
      <?php if(!empty($event_home)): ?>
      <a href="<?=$event_home[0]->link?>"><img src="<?=base_url_home()?>upload/event/<?=$event_home[0]->image?>" class="w-100"> </a>  
      <?php endif; ?>
    </div>
  </div>
  <div class="shopping mt-20">
    <a href="/taoshopping" >
      <div class="mb-10" style="position: relative;">
      <p class="fav-header">&nbsp;&nbsp;&nbsp;쇼핑몰&nbsp;&nbsp;&nbsp;</p>
      <img src="/assets/images/shops.png" class="w-100">
    </div>
    </a>
    <div class="product_list_content">
      <?php if(!empty($shops)): ?>
      <?php foreach($shops as $shop_list): ?>
      <?php $data['value']  = $shop_list; ?>
      <?php $data['accuringRate'] = $accuringRate; ?>
      <?php $this->load->view("product_list",$data); ?>
      <?php endforeach; ?>
    <?php endif; ?>
    </div>
    <div class="more_btn">
      <a href="javascript:void(0)" class="btn -1 w-100 clickmore" onclick="clickMore($(this))">+ 더보기</a>
    </div>
  </div>
<!--   <div class="event-part mt-20">
    <?php if(!empty($event)): ?>
    <?php $event =  array_chunk($event, 2, true); ?>
    <?php foreach($event as $cc): ?>
    <div class="row">
      <?php foreach($cc as $event_chd): ?>
      <div class="col-xs-6">
        <a href="<?=$event_chd->link?>" target="_blink">
          <p class="event-title"><?=$event_chd->title?></p>
          <p class="event-content"><?=$event_chd->description?></p>
        </a>
        <div class="text-center">
          <img src="<?=base_url_home()?>upload/homepage/event/<?=$event_chd->image?>" alt="<?=$event_chd->title?>" class="w-80 mt-5" style="max-width: 200px">
        </div>
      </div>
      <?php endforeach; ?>
    </div>
    <?php endforeach; ?>
    <?php endif; ?>
  </div> -->
<!--   <div class="banner-part mt-10 pb-10">
     <?php if(!empty($s_banner)): ?>
      <?php
        $a = array_chunk($s_banner, 4, true);
       ?>
      <?php foreach($a as $value): ?>
        <div class="row text-center">
          <?php foreach($value as $chd): ?>
          <div class="col-xs-3">
            <a href="<?=$chd->link?>" target="<?=$chd->target==2 ? "_blink":"_self"?>">
              <img src="<?=base_url_home()?>/upload/homepage/banner_r/<?=$chd->image?>" alt="<?=$chd->description?>" class="w-100" style="max-width: 120px">
              <p class="chd-text"><?=$chd->description?></p>
            </a>
          </div>
          <?php endforeach; ?>
        </div>
      <?php endforeach; ?>
    <?php endif; ?>
</div> -->

<script>
$('.logos').carousel(
  {
    interval: 8000
  }
);
$('.go-part').carousel(
  {
    interval: 5000
  }
);
var lp = <?=$sizes?>;
var hitURL = baseURL+"getShopProducts";
var rate = <?=$accuringRate->rate?>;
var home = "<?=base_url_home()?>";
var o_type = 6;
var category  = "";
var site = "";


$(".my-rating").starRating({
    readOnly:true,
    starShape: 'rounded',
    starSize: 20,
    emptyColor: 'lightgray',
    hoverColor: 'salmon',
    activeColor: 'crimson',
    minRating: 0
});
</script>