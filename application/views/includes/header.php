<!DOCTYPE html>
<html>
<!--<![endif]-->
<head>
  <meta charset="utf-8">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <meta http-equiv="content-language" content="es-ES" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <meta name="viewport" content="width=1200">
  <meta name="google-site-verification" content="xEjibk8SdR8-3iqfobh-OzzaydxGxg6Tn1F-wYVaZbw" />
  <meta name="naver-site-verification" content="22028ac933e9477336eadc18bb34c66d7942332b" />
  <meta name="description" content="중국구매대행 타오바오쇼핑 해외 구매대행 중국 물류대행 물류대행 해외물류대행 배대지 타오바오구매대행 타오바오물류대행 중국쇼핑몰" />
  <meta name="keywords" content="중국 구매대행,타오바오쇼핑,해외 구매대행,중국 물류대행,물류대행,해외 물류대행,배대지,타오바오 구매대행,타오바오 물류대행,중국 쇼핑몰" />
  <meta property="og:type" content="website">
  <meta property="og:title" content="<?=!empty($fb_shared) ? $og_title : $pageTitle?>">
  <meta property="og:description" content="중국구매대행 타오바오쇼핑 해외구매대행 등을 가장 쓉고 편리하게 이용할 수 있는 해외구매대행 사이트 입니다.">
  <meta property="og:image" content="<?=!empty($fb_shared) ? $og_image : base_url()."template/images/top_logo.png"?>">
  <meta property="og:url" content="<?=!empty($fb_shared) ? $og_url : base_url()?>">
  <title>
    <?php echo $pageTitle; ?>
  </title>
  <link rel="icon" href="<?=base_url()?>t.ico" type="image/gif">
  <link href="<?php echo site_url('/template/css/bootstrap-v3.3.6.min.css'); ?>" rel="stylesheet">
  <link href="<?php echo site_url('/template/css/slick.min.css'); ?>" rel="stylesheet">
  <link href="<?php echo site_url('/template/css/reset.css'); ?>" rel="stylesheet">
  <link rel="stylesheet" href="/assets/plugins/third/font-awesome.min.css">
  <script>
    var footer_position=0;
    var layerTopOffset = <?=$controller_name =="taoshopping" ? 846:200?>;
    <?php if($controller_name == "wish_list" || $controller_name == "mybasket"):?>
      layerTopOffset = 309;
    <?php endif;?>
    var controller = "<?=$controller_name?>";
  </script>
  <script>window.jQuery || document.write('<script src="<?php echo site_url('/template/js/jquery-v1.11.3.min.js') ?>"><\/script>')</script>
  <script src="<?php echo site_url('/template/js/bootstrap-v3.3.6.min.js') ?>"></script>
  <script src="<?php echo site_url('/template/js/slick.min.js')?>"></script>
  <script src="<?php echo site_url('/template/js/common.js')?>" type="text/javascript"></script>
  <script src="<?php echo site_url('/template/js/jquery-scrolldown.js') ?>?<?=time()?>"></script>
  <script src="<?php echo site_url('/template/js/pop_cookies.js')?>"></script>
  <script src="http://dmaps.daum.net/map_js_init/postcode.v2.js"></script>
  <script src="<?php echo site_url('/template/js/menu.js')?>?<?=time()?>"></script>
  <script > var product_loaded = 0;var baseURL = "<?php echo base_url(); ?>";</script>
  <script src="<?php echo site_url('/assets/js/handlebars.js')?>"></script>
  <script src="/assets/plugins/third/socket.io.js"></script>
  <script src="<?php echo site_url('/template/js/amazeui.lazyload.min.js')?>"></script>
  <script src="<?php echo site_url('/template/js/init.js')?>"></script>
  <script src="/assets/plugins/third/kakao.min.js"></script>
  <script async src="https://www.googletagmanager.com/gtag/js?id=G-8J5QE0V51N"></script>
  <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'G-8J5QE0V51N');
  </script>
  <script>
  <?php if(!empty($accuringRate->rate)): ?>
    var accur = <?=$accuringRate->rate?>;
  <?php endif; ?>
  <?php if(empty($accuringRate->rate)):?>
    var accur = 150;
  <?php endif;?>
</script>
</head>
<body>
  <?php if(!empty($fb_shared)):?>
    <div id="fb-root"></div>
    <script>
      window.fbAsyncInit = function() {
        FB.init({
          appId            : '1103409070120184',
          autoLogAppEvents : true,
          xfbml            : true,
          version          : 'v9.0'
        });
      };
    </script>
  <script async defer crossorigin="anonymous" src="https://connect.facebook.net/ko_KR/sdk.js"></script>

  <?php endif;?>
  <?php $checked_shop = in_array($controller_name, SHOP_URLS); ?>
  <div class="topInfo">
    <?php if(!empty($this->session->userdata('fuser'))): ?>
      <div class="f-medium fl logoutbtn">
        <ul>
          <li>
            <span><strong><?=$this->session->userdata('fname')?></strong>님(<?=$user[0]->role?>)</span>
            
          </li>
          <li><a href="/mailbox">쪽지 : <strong><?=getMailCount()?></strong></a></li>
          <li>
            <span>예치금 : </span><a href="/deposit"><strong><?=number_format($user[0]->deposit)?>원</strong></a>
          </li>
          <li><span>쿠폰 : </span><a href="/coupon"><strong><?=!empty($coupon) ? sizeof($coupon) : 0?>장</strong></a></li>
          <li><span>포인트 : </span><a href="/point_history"><strong><?=number_format($user[0]->point)?>P</strong></a></li>
          <li><a href="/mybasket">장바구니</a></li>
          <li><a href="/logout">로그아웃</a></li>
        </ul>
      </div>  
    <?php endif; ?>
    <?php if(empty($this->session->userdata('fuser'))): ?>
        <div class="logbtn f-medium fl">
          <a href="/login" class="p-right-10">로그인<div class="border-half"></div></a>
          <a href="/register" class="p-right-10 p-left-10">회원가입<div class="border-half"></div></a>
          <a href="/mybasket" class="p-right-10 p-left-10">장바구니<div class="border-half"></div></a>
          <a href="/deposit"  class="p-left-10">예치금충전</a>
        </div>  
      <?php endif; ?>
  </div>
  <div class="logo-section clrBoth">
      <div class="logos text-center">
        <a href="/" title="<?=$pageTitle?>"><img src="/template/images/top_logo.png" alt="<?=$pageTitle?>"  title="<?=$pageTitle?>" height="50px"></a>
      </div>
      <a href="javascript:addBookmark()" id="favorite"><img src="/assets/images/favor.png" alt="<?php echo $pageTitle; ?>">즐겨찾기 추가</a>
    <div class="clrBoth"></div>
  </div>
  <header>
    <nav class="navbar navbar-inverse nav-he">
      <div class="navbar-header">
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar"> <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
      </div>
      <div id="navbar" class="navbar-collapse collapse">
        <ul class="nav navbar-nav ul-he">
          <li class="dropdown out_menu"><a href="<?=!empty($header) ? "/ipage?id=".$header[0]->id:""?>" class="dropdown-toggle"  role="button" aria-haspopup="true" aria-expanded="false">이용안내 
          </a>
            <ul class="dropdown-menu">
              <?php  if(!empty($header)): ?>
              <?php  foreach($header as $v): ?>
                 <li><a href="/ipage?id=<?=$v->id?>" title="<?=$v->title?>"><?=$v->title?></a></li>
              <?php  endforeach; ?>
              <?php  endif;?>
            </ul>
          </li>

          <li class="dropdown out_menu"> <a href="/delivery" class="dropdown-toggle"  role="button" aria-haspopup="true" aria-expanded="false">배송대행 </a>
            <ul class="dropdown-menu">
              <li><a href="/delivery">배송대행 신청</a></li>
              <li><a href="/multi?type=1">대량등록(엑셀)</a></li>
            </ul>
          </li>
          <li class="dropdown out_menu"> <a href="/delivery?options=buy" class="dropdown-toggle"  role="button" aria-haspopup="true" aria-expanded="false">구매대행</a>
            <ul class="dropdown-menu">
              <li><a href="/delivery?options=buy">구매대행 신청</a></li>
              <li><a href="/multi?type=2">대량등록(엑셀)</a></li>
            </ul>
          </li>
          <!-- <li><a href="/nodata">상품주인 찾아요</a> -->
          </li>
          <li class="out_menu"><a href="/taoshopping">쇼핑몰</a>
          </li>
          <li class="dropdown out_menu"> <a href="<?php if(!empty($bmenu)){ ?><?=base_url()?>panel?id=<?=$bmenu[0]->iden?> <?php } ?>" class="dropdown-toggle"  role="button" aria-haspopup="true" aria-expanded="false">고객센터</a>
            <ul class="dropdown-menu">
              <?php $n= ""; ?>
              <?php if(!empty($bmenu)): ?>
              <?php foreach($bmenu as $value): ?>
              <li><a  href="/panel?id=<?=$value->iden?>"><?=$value->title?></a></li>
              <?php endforeach; ?>
              <?php endif; ?>
              <li><a href="/event">이벤트</a></li>
            </ul>
          </li>
          <li class="dropdown out_menu"> 
            <a href="/mypage" class="dropdown-toggle"  role="button" aria-haspopup="true" aria-expanded="false">
              마이페이지</a>
            <ul class="dropdown-menu">
              <li><a href="/mypage">마이홈</a></li>
              <li><a href="/mypay">결제 페이지</a></li>
              <li><a href="/deposit">예치금/포인트</a></li>
              <li><a href="/private?option=my">Q&A</a></li>
              <li><a href="/coupon">나의 쿠폰함</a></li>
              <li><a href="/mailbox">받은 쪽지함</a></li>
              <li><a href="/member">회원정보수정</a></li>
            </ul>
          </li>
        </ul>
      </div>
      <!--/.nav-collapse -->
    </div>
  </nav>
  </header>
  <?php if($checked_shop): ?>
    <?php $all_shops = multi_categories(); ?>
    <?php $multi_categories =  $all_shops["categories1"]; ?>
    <?php $multi_categories1 = $all_shops["categories2"]; ?>
    <?php $multi_categories2 = $all_shops["categories3"];?>
    <link rel="stylesheet" type="text/css" href="<?php echo site_url('/assets/plugins/AutoComplete/easy-autocomplete.min.css')?>"></link>
    <link rel="stylesheet" type="text/css" href="<?php echo site_url('/assets/plugins/AutoComplete/easy-autocomplete.themes.min.css')?>"></link>
    <script src="<?php echo site_url('/assets/plugins/AutoComplete/jquery.easy-autocomplete.min.js')?>"></script>
    <div class="renewal-header">
      <section>
        <div class="clearfix">
          <form role="search" id="header_search" action="<?=base_url("shopping")?>">
            <div class="input-group">
                <div class="input-group-btn">
                    <button type="button" class="btn btn-default dropdown-toggle toggle-search" data-toggle="dropdown">
                        <span id="srch-category"><?=!empty($selected_name) ? $selected_name: "전체"?></span> <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu" id="mnu-category">
                      <li><a href="#" data-cate_id="">전체</a></li>
                      <?php if(!empty($multi_categories)): ?>
                      <?php foreach($multi_categories as $value):?>
                      <li><a href="#<?=$value->name?>" data-cate_id="<?=$value->category_code?>"><?=$value->name?></a></li>
                      <?php endforeach;?>
                      <?php endif;?>
                    </ul>
                </div>
                <input type="hidden" id="txt-category" name="txt-category" value="<?=$this->input->get("txt-category")?>">
                <input type="text" id="txt-search" class="form-control" placeholder="찾고 싶은 상품을 검색해주세요!..." name="txt-search" 
                value="<?=$this->input->get("txt-search")?>">
                <span class="input-group-btn">
                    <button id="btn-search" type="submit" class="btn btn-default">
                        <span class="glyphicon glyphicon-search"></span>
                    </button>
                </span>
            </div>
          </form>
          <ul class="icon-menus">
            <li class="my-coupang more">
                <a href="/mybasket">
                  <span class="my-coupang-icon">&nbsp;</span> 
                  <span class="my-coupang-title">장바구니</span>
                  <span id="headerCartCount"><?=$basket_count?></span>
                </a>
             </li>
             <li class="cart more">
                <a href="/wish_list" class="clearFix mycart-preview-module">
                  <span class="cart-icon">&nbsp;</span> <span class="cart-title">찜</span>
                </a>
             </li>
          </ul>
        </div>
        <ul class="nav navbar-nav filer_products_favor">
         <li class="rocket-delivery">
          <a href="/shopping?txt-category=best" class="rocket-delivery font-weight-bold" title="베스트상품">베스트상품</a> 
         </li>
         <li class="rocket-delivery">
          <a href="/shopping?txt-category=rec" class="rocket-delivery font-weight-bold" title="추천상품">추천상품</a> 
         </li>
         <li class="rocket-delivery">
          <a href="/shopping?txt-category=new" class="rocket-delivery font-weight-bold" title="신상품">신상품</a> 
          <span class="ico_span"><img src="/assets/images/ico_new.png" alt="<?=$pageTitle?> 신상품"></span>
         </li>
         <li class="rocket-delivery">
          <a href="/shopping?txt-category=low" class="rocket-delivery font-weight-bold" title="싸다">싸다</a> 
          <span class="ico_span"><img src="/assets/images/ico_sale.png" alt="<?=$pageTitle?> 눅은 상품"></span>
         </li>
         <li class="rocket-delivery">
          <a href="/shopping?txt-category=wow" class="rocket-delivery font-weight-bold" title="멋지다">멋지다</a> 
         </li>
      </ul>
      </section>
      <div class="category-btn">
        <a href="javascript:;">카테고리</a>
        <div class="category-layer">
          <ul class="Menu -vertical">
            <?php if(!empty($multi_categories)): ?>
            <?php foreach($multi_categories as $value): ?>

            <li class="firclass <?=!empty($multi_categories1[$value->id]) && sizeof($multi_categories1[$value->id]) > 0 ? "-hasSubmenu":""?>">
             <?php 
             if($value->banner_use == 1):
             ?>
              <img src="<?=base_url()?>upload/thumb/<?=$value->icon?>" class="icon" alt="<?=$value->name?>">
             <?php endif; ?>
              <a href="/shopping?txt-category=<?=$value->category_code?>&bread=<?=$value->category_code?>" title="<?=$value->name?>"><?=$value->name?></a>
              <ul>
                <?php if(!empty($multi_categories1[$value->id]) && sizeof($multi_categories1[$value->id]) > 0): ?>
                <?php foreach($multi_categories1[$value->id] as $value1): ?>
                <li class="<?php if(!empty($multi_categories2[$value1->id]) && sizeof($multi_categories2[$value1->id]) > 0): ?>-hasSubmenu<?php endif; ?>">
                  <?php 
                  if($value1->banner_use == 1):
                  ?>
                  <img src="<?=base_url()?>upload/thumb/<?=$value1->icon?>" class="icon" alt="<?=$value1->name?>">
                  <?php endif; ?>
                  <a href="/shopping?txt-category=<?=$value1->category_code?>&bread=<?=$value->category_code?>-<?=$value1->category_code?>" class="font-weight-bold" title="<?=$value1->name?>"><?=$value1->name?></a>
                  <ul>
                    <?php if(!empty($multi_categories2[$value1->id])): ?>
                    <?php foreach($multi_categories2[$value1->id] as $value2): ?>
                      <li>
                      <?php 
                        if($value2->banner_use == 1):
                        ?>
                        <img  alt="<?=$value2->name?>" src="<?=base_url()?>upload/thumb/<?=$value2->icon?>" class="icon">
                        <?php endif; ?>
                        <a href="/shopping?txt-category=<?=$value2->category_code?>&bread=<?=$value->category_code?>-<?=$value1->category_code?>-<?=$value2->category_code?>" class="font-weight-bold" title="<?=$value2->name?>"><?=$value2->name?></a>
                      </li>
                    <?php endforeach; ?>  
                  <?php endif; ?>
                  </ul>
                </li>
                <?php endforeach; ?>
                <?php endif;?>
              </ul>
              <span class="gnb-banner" style="background: #FFF">
                <?php if(!empty($value->banner) && $value->banner_use ==1): ?>
                <img alt="<?=$value->name?>"  class="category-banner-image" 
                src="<?=base_url()?>upload/thumb/<?=$value->banner?>" style="display: inline;" 
                onclick="goBannerPage('<?=$value->banner_link?>','<?=$value->banner_type?>')">
                <?php endif;?>
              </span>
            </li> 
            <?php endforeach; ?>
            <?php endif; ?>
          </ul>
        </div>
      </div>
    </div>
  <?php endif; ?>

<div class="container-fluid">
  <div id="floating" style="position: absolute; z-index: 10;" class="rightbanner<?=$checked_shop?>"> 
      <!--오늘본상품-->
 <div id="QiuckMenu">
  <ul>
    <?php 
    if($checked_shop){
      $shop_parameter = 24;
      $shop_image_folder = "banner";
    }
    else{
      $shop_parameter = 17;
      $shop_image_folder = "banner_r";
    }
    ?>
    <?php $rights = getBanners($shop_parameter); ?>
    <?php if(!empty($rights)): ?>
    <?php foreach($rights as $value): ?>
      <?php 
          $ss= explode("func-", $value->link);
          if(sizeof($ss) > 1) $link = "javascript:".$ss[1];
          else $link = $value->link;
        ?>
    <li style="<?=$value->mt > 0 ? "margin-top:".$value->mt."px;":""?> <?=$value->mb > 0 ? "margin-bottom:".$value->mb."px;":""?>">
      <a href="<?=$link?>" target="<?=$value->target==2 ? "_blank":"_self"?>" title="<?=$value->description?>">
        <img  src="/upload/homepage/<?=$shop_image_folder?>/<?=$value->image?>" 
        data-src="/upload/homepage/<?=$shop_image_folder?>/<?=$value->image?>" 
        data-src1="/upload/homepage/<?=$shop_image_folder?>/<?=$value->image1?>" class="hover_img" alt="<?=$value->description?>">
      </a>
    </li>
    <?php endforeach; ?>
    <?php endif; ?>
  </ul>
 </div>
</div>
<?php if(!$checked_shop): ?>
  
<div id="floating2" style="position: absolute; z-index: 10;">
   <div id="QiuckMenu2">
    <ul>
      <?php $lefts = getBanners(16); ?>
      <?php if(!empty($lefts)): ?>
      <?php foreach($lefts as $value): ?>
        <?php 
          $ss= explode("func-", $value->link);
          if(sizeof($ss) > 1) $link = "javascript:".$ss[1];
          else $link = $value->link;
        ?>
      <li style="<?=$value->mt > 0 ? "margin-top:".$value->mt."px;":""?> <?=$value->mb > 0 ? "margin-bottom:".$value->mb."px;":""?>">
      <a href="<?=$link?>" target="<?=$value->target==2 ? "_blank":"_self"?>" title="<?=$value->description?>">
        <img src="/upload/homepage/banner_r/<?=$value->image?>" alt="<?=$value->description?>"></a></li>
      <?php endforeach; ?>
      <?php endif; ?>
    </ul> 
   </div>
</div>

<?php endif; ?>
<aside class="side-button">
  <a  id="sideTop" class="top" title="맨 위로 가기" >top</a>
</aside>
<div class="loading_products d-none">
  <img src="/template/images/reload.gif" width="60" height="60" alt="<?php echo $pageTitle; ?>">
</div>
