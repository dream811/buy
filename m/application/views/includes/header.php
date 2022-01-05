<!DOCTYPE html>
<!--[if lt IE 7]><html lang="es" class="no-js lt-ie9 lt-ie8
lt-ie7"><![endif]-->
<!--[if IE 7]><html class="no-js lt-ie9
lt-ie8"><![endif]-->
<!--[if IE 8]><html class="no-js
lt-ie9"><![endif]-->
<!--[if gt IE 8]><!-->
<html>
<!--<![endif]-->

<head>
  <meta charset="utf-8">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <meta http-equiv="content-language" content="es-ES" />
  <meta name="viewport" content="width=device-width,initial-scale=1.0, maximum-scale=1">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <meta name="naver-site-verification" content="22028ac933e9477336eadc18bb34c66d7942332b" />
  <meta name="description" content="중국구매대행 타오바오쇼핑 해외구매대행 중국물류대행 물류대행 해외물류대행 배대지 타오바오구매대행 타오바오물류대행 중국쇼핑몰" />
  <meta name="keywords" content="중국구매대행,타오바오쇼핑,해외구매대행,중국물류대행,물류대행,해외물류대행,배대지,타오바오구매대행,타오바오물류대행,중국쇼핑몰" />
  <meta property="og:type" content="website">
  <meta property="og:title" content="<?=!empty($fb_shared) ? $og_title : $pageTitle?>">
  <meta property="og:description" content="중국구매대행 타오바오쇼핑 해외구매대행 등을 가장 쓉고 편리하게 이용할 수 있는 해외구매대행 사이트 입니다.">
  <meta property="og:image" content="<?=!empty($fb_shared) ? $og_image : base_url()."template/images/top_logo.png"?>">
  <meta property="og:url" content="<?=!empty($fb_shared) ? $og_url : base_url()?>">
  <title>
    <?php echo $pageTitle; ?>
  </title>
  <link href="<?php echo site_url('/template/css/bootstrap-v3.3.6.min.css'); ?>" rel="stylesheet">
  <link href="<?php echo site_url('/template/css/slick.min.css'); ?>" rel="stylesheet">
  <link href="<?php echo site_url('/template/css/slick-theme.css'); ?>" rel="stylesheet">
  <link href="<?php echo site_url('/template/css/reset.css'); ?>?<?=time()?>" rel="stylesheet">
  <link href="<?php echo site_url('/template/css/bootstrap-datetimepicker.min.css'); ?>" rel="stylesheet">
  <link rel="stylesheet" href="/assets/plugins/third/font-awesome.min.css">
  <script>window.jQuery || document.write('<script src="<?php echo site_url('/template/js/jquery-v1.11.3.min.js') ?>"><\/script>')</script>
  <script src="<?php echo site_url('/template/js/bootstrap-v3.3.6.min.js') ?>"></script>
  <script src="<?php echo site_url('/template/js/slick.min.js')?>"></script>
  <script src="<?php echo site_url('/template/js/common.js')?>?<?=time()?>" type="text/javascript"></script>
  <script src="<?php echo site_url('/template/js/pop_cookies.js')?>"></script>
  <script src="<?php echo site_url('/template/js/bootstrap-datetimepicker.min.js') ?>"></script>
  <script src="<?php echo site_url('/template/js/bootstrap-datetimepicker.kr.js')?>"></script>
  <script src="<?=base_url_home()?>assets/js/handlebars.js"></script>
  <script src="http://dmaps.daum.net/map_js_init/postcode.v2.js"></script>
  <script > var baseURL = "<?php echo base_url(); ?>";</script>
  <script > var baseURL_HOME = "<?php echo base_url_home(); ?>";</script>
  <script src="/assets/plugins/third/socket.io.js"></script>
  <script src="<?php echo site_url('/template/js/rolldate.min.js') ?>"></script>
  <script src="<?php echo site_url('/template/js/init.js')?>?=<?=time()?>"></script>
  <script src="<?php echo site_url('/template/js/amazeui.lazyload.min.js')?>"></script>
  <script src="/assets/plugins/third/kakao.min.js"></script>
  <link rel="icon" href="<?=base_url_home()?>t.ico" type="image/gif">
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
  <!-- Standard sample menu -->
  <div id='loader' class="d-none loading_products">
    <img src='<?=base_url_home()?>template/images/reload.gif' width='60' height='60'>
  </div>
  <div class="header-nav navbar-collapse visible-xs-block collapse" aria-expanded="false" id="shop-nav">
    <button type="button" class="btn-closed" data-toggle="collapse" data-target="#shop-nav">
      <img src="/template/images/navbar_close_btn.png" alt="">
    </button>
    <div class="header-nav-inner">
      <div class="menu" id="" aria-multiselectable="true">
        <?php  if(!empty($cateogory_1)): ?>
        <?php  foreach($cateogory_1 as $v): ?>
        <div class="panel">
          <div class="panel-heading">
            <a href="/shopping?txt-category=<?=$v->category_code?>"><?=$v->name?></a>
          </div>
        </div>
        <?php  endforeach; ?>
        <?php  endif;?>
      </div>
    </div>
  </div>
  <div class="header-nav navbar-collapse visible-xs-block collapse" aria-expanded="false" id="header-nav">
    <button type="button" class="btn-closed" data-toggle="collapse" data-target="#header-nav">
      <img src="/template/images/navbar_close_btn.png" alt="">
    </button>
    <div class="header-nav-inner">
      <div class="top">
        <a href="/" class="home"><img src="/template/images/navbar_home.png" alt=""></a>
        <?php  if(empty($this->session->userdata('fisLoggedIn'))): ?>
        <a href="/login" class="action">로그인</a>
        <a href="/register" class="action">회원가입</a>
       <?php endif; ?>
       <?php  if(!empty($this->session->userdata('fisLoggedIn')) &&  $this->session->userdata('fisLoggedIn')): ?>
        <a href="/logout" class="action">로그아웃</a>
        <a href="/mybasket" class="action">장바구니</a>
       <?php endif; ?>
      </div>
      <div class="write">
        <a href="/delivery?option=buy" class="buying btn btn-green btn-lg btn-block"><img src="/template/images/topbuy.png" alt="">구매대행 신청하기</a>
        <a href="/delivery" class="delivery  btn btn-warning btn-lg btn-block"><img src="/template/images/topdelivery.png" alt="">배송대행 신청하기</a>
         <a href="/taoshopping" class="delivery  btn btn-danger btn-lg btn-block"><img src="/template/images/topshopping.png" alt="">쇼핑몰</a>
      </div>
      <div class="menu" id="" aria-multiselectable="true">
        <div class="panel">
          <div class="panel-heading">
            <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#menu-guide">이용안내</a>
          </div>
          <div id="menu-guide" class="collapse">
            <ul>
              <?php  if(!empty($headerr)): ?>
              <?php  foreach($headerr as $v): ?>
                 <li><a href="/ipage?id=<?=$v->id?>"><?=$v->title?></a></li>
              <?php  endforeach; ?>
              <?php  endif;?>
            </ul>
          </div>
        </div>
        <div class="panel">
          <div class="panel-heading">
            <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#menu-buying">고객센터</a>
          </div>
          <div id="menu-buying" class="collapse">
            <ul>
              <?php $n= ""; ?>
              <?php if(!empty($bmenu)): ?>
              <?php foreach($bmenu as $value): ?>
              <li><a  href="/panel?id=<?=$value->iden?>"><?=$value->title?></a></li>
              <?php endforeach; ?>
              <?php endif; ?>
              <li><a href="/event">이벤트</a></li>
            </ul>
          </div>
        </div>
      </div>
      <div class="anchor">
        <div class="small-area">
          <ul>
            <li><a href="/multi?type=2"><img src="/template/images/top_buy.png" alt="">구매대행 대량등록</a></li></li>
            <li><a href="/multi?type=1"><img src="/template/images/top_del.png" alt="">배송대행 대량등록</a></li></li>
            <li><a href="javascript:fnDlvrMnyPop()"><img src="/template/images/top_cal.png" alt="">배송요금계산기</a></li></li>
            <li><a href="https://www.kuaidi100.com/" target="_blink"><img src="/template/images/top_china.png" alt="">중국내택배조회</a></li></li>
            <li><a href="https://www.doortodoor.co.kr/parcel/pa_004.jsp" target="_blink"><img src="/template/images/top_tack.png" alt="">국내배송조회</a></li></li>
            <li><a href="/private?option=my"><img src="/template/images/top_1_1.png" alt="">1:1맞춤문의</a></li></li>
          </ul>
        </div>
      </div>
      <div class="pc">
        <a href="<?=base_url_home()?>?webview=1">PC화면</a>
      </div>
    </div>
  </div>
  <?php 
    if(base_url()!=current_url())
      $class="style='background-color:#000 !important'";
    else
      $class="";
   ?>

<div id="header_m">
  <div class="row gnb-area">
    <div class="col-xs-12">
      <ul>
      <?php if(empty($this->session->userdata('fisLoggedIn'))): ?>
        <li><a href="/login">로그인</a></li>
        <li><a href="/register">회원가입</a></li>
      <?php endif; ?>
      <?php  if(!empty($this->session->userdata('fisLoggedIn')) &&  $this->session->userdata('fisLoggedIn')): ?>
        <li><a href="/logout">로그아웃</a></li>
        <li><a href="/mybasket">장바구니</a></li>
      <?php endif; ?>
      </ul>
    </div>
  </div>
  <div class="row">
    <div class="col-xs-3">
      <div type="button" id="moby-button" data-toggle="collapse" data-target="#header-nav">
        <div  <?=$class?>></div>
        <div  <?=$class?>></div>
        <div  <?=$class?>></div>
      </div>
    </div>
    <div class="col-xs-6 text-center fixed-logo">
      <h1><a href="/" class="font-weight-bold rdoFtBig"><img src="/template/images/top_logo.png" width="117"></a></h1>
    </div>
    <div class="col-xs-3">
      <a href="/mypage" class="mypage"><img src="/template/images/topmy.png"></a>
    </div>
  </div>
</div>
