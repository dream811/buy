<!DOCTYPE html>
<html>
  <head>

    <meta charset="UTF-8">
    <title><?php echo $pageTitle; ?></title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <link href="<?php echo base_url(); ?>assets/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />    
    <link href="<?php echo base_url(); ?>assets/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <link href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url(); ?>assets/dist/css/AdminLTE.min.css" rel="stylesheet" type="text/css" />
    <link href='<?php echo base_url(); ?>/assets/dist/css/bootstrap-datetimepicker.min.css' rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/dist/css/skins/_all-skins.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url(); ?>assets/dist/css/admin.css?<?=time()?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url(); ?>assets/dist/css/table.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url(); ?>assets/dist/css/neo.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url(); ?>assets/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url(); ?>assets/dist/css/sscss/bootstrap-notify.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url(); ?>assets/dist/css/sscss/styles/alert-bangtidy.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url(); ?>assets/dist/css/sscss/styles/alert-blackgloss.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript">
        var baseURL = "<?php echo base_url(); ?>";
    </script>
    <style>
      .error{
        color:red;
        font-weight: normal;
      }
      td,a,label,h1,h4,th,p,input{
        color: #000 
      }
    </style>
    <script src="<?php echo base_url(); ?>assets/js/jQuery-2.1.4.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/head.js?<?=time()?>"></script>
    <script src='<?php echo base_url(); ?>/assets/js/bootstrap-datetimepicker.min.js'></script>
    <script src='<?php echo base_url(); ?>/assets/js/bootstrap-datetimepicker.kr.js'></script>
    <script src="http://dmaps.daum.net/map_js_init/postcode.v2.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/ckeditor/ckeditor.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/ckeditor/sample.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/tooltipsy.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/bootstrap-notify.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/2.3.0/socket.io.js"></script>
    <script src="<?php echo base_url(); ?>assets/select2/js/select2.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/init.js?<?=time()?>"></script>
    <script>
      var del_count = 0;
      var pur_count = 0;
      var shop_count = 0;
      var return_count = 0;
      del_count = <?=getCountProcessing("delivery")?>;
      pur_count = <?=getCountProcessing("buy")?>;
      return_count = <?=getCountProcessing("return")?>;
      shop_count = <?=getCountProcessing("shop")?>;  
      var loading = null;
    </script>
    <script>
      $(document).ready(function(){
        loading = $(".loading_products");
      })
    </script>
  </head>

  <body class="skin-blue sidebar-mini">
    <div class="wrapper">
      <div class="loading_products d-none">
        <img src="/template/images/reload.gif" width="60" height="60">
      </div>
      <header class="main-header">
        <!-- Logo -->
        <a href="<?php echo base_url(); ?>index" class="logo">
          <!-- mini logo for sidebar mini 50x50 pixels -->
          <span class="logo-mini">????????? ??????</span>
          <!-- logo for regular state and mobile devices -->
          <span class="logo-lg"><b>?????????</b>??????</span>
        </a>
        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top" role="navigation">
          <!-- Sidebar toggle button-->
          <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
          </a>
          <a style="float: left;padding: 15px 16px;color: #fff" href="<?=base_url()?>panel?id=11&seach_input=&shCol=title&category=total&mode=?????????">1:1?????? : ?????????(<?=getPendingCount()?>)</a>
          <a  class="nav-link"  href="/admin/note" aria-expanded="true" style="padding: 15px 16px;float: left">
            <i class="fa fa-bell-o" style="color: #fff"></i>
            <span class="badge badge-warning navbar-badge <?=get_note() > 0 ? "blink blink-two":"" ?>" id="notice_count"><?=get_note()?></span>
          </a>
          <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
              <!-- User Account: style can be found in dropdown.less -->
              <li>
                <a href="<?=base_url()?>dashboard?order_part=1">???????????? ??????&nbsp;&nbsp;<span class="badge badge-danger badge-pill delivery"></span></a>
              </li>
              <li>
                <a href="<?=base_url()?>dashboard?order_part=2">???????????? ??????&nbsp;&nbsp;<span class="badge badge-danger badge-pill pur"></span></a>
              </li>
              <li>
                <a href="<?=base_url()?>dashboard?order_part=3">????????? ??????&nbsp;&nbsp;<span class="badge badge-danger badge-pill shopping"></span></a>
              </li>
              <li>
                <a href="<?=base_url()?>dashboard?order_part=4">???????????? ??????&nbsp;&nbsp;<span class="badge badge-danger badge-pill returning"></span></a>
              </li>
              <li>
                <a href="<?=base_url()?>dashboard">????????????&nbsp;&nbsp;<span class="badge badge-danger badge-pill total"></span></a>
              </li>
              <li class="dropdown user user-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  <img src="<?php echo base_url(); ?>assets/dist/img/avatar.png" class="user-image" alt="User Image"/>
                  <span class="hidden-xs"><?php echo $name; ?></span>
                </a>
                <ul class="dropdown-menu">
                  <!-- User image -->
                  <li class="user-header">
                    <img src="<?php echo base_url(); ?>assets/dist/img/avatar.png" class="img-circle" alt="User Image" />
                    <p>
                      <?php echo $name; ?>
                      <small><?php echo $role_text; ?></small>
                    </p>
                  </li>
                  <!-- Menu Footer-->
                  <li class="user-footer">
                    <div class="pull-left">
                      <a href="<?php echo base_url(); ?>loadChangePass" class="btn btn-default btn-flat"><i class="fa fa-key"></i> Change Password</a>
                    </div>
                    <div class="pull-right">
                      <a href="<?php echo base_url(); ?>logout" class="btn btn-default btn-flat"><i class="fa fa-sign-out"></i> Sign out</a>
                    </div>
                  </li>
                </ul>
              </li>
            </ul>
          </div>
        </nav>
      </header>
      <!-- Left side column. contains the logo and sidebar -->
      <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
          <!-- sidebar menu: : style can be found in sidebar.less -->
          <ul class="sidebar-menu">
            <?php if(in_array(1, $menu_list)): ?>
            <li   class="treeview <?php echo activate_menu("/orderProduct/dashboard/paying/payhistory/nodata/ShowDelivery/");?>">
              <a href="#">
                <i class="fa fa-dashboard"></i> <span>????????????</span></i>
              </a>
              <ul class="treeview-menu">
                <li class="<?php echo activate_menu("/dashboard/ShowDelivery/");?>"><a href="<?php echo base_url()."dashboard"?>"><i class="fa fa-circle-o"></i>??????????????????</a></li>
                <li class="<?php echo activate_menu("/orderProduct/");?>"><a href="<?php echo base_url()."orderProduct"  ?>"><i class="fa fa-circle-o"></i>??????????????????</a></li>
                <li class="<?php echo activate_menu("/paying/");?>"><a href="<?php echo base_url()."paying"?>"><i class="fa fa-circle-o"></i>????????????</a></li>
                <li class="<?php echo activate_menu("/payhistory/");?>"><a href="<?php echo base_url()."payhistory"  ?>"><i class="fa fa-circle-o"></i>??????????????????</a></li>
                <li><a href="<?php echo base_url()."nodata"?>"><i class="fa fa-circle-o"></i>????????????</a></li>
              </ul>
            </li>
            <?php endif; ?>
            <?php if(in_array(2, $menu_list)): ?>
            <?php $board = get_board(); ?>
            <?php 
            $m = "/board_settings/Bbs_SetUp_W/editboards/viewmessage/editboard/panel/bbs/viewreq/";
            if(!empty($board)){
              foreach($board as $v){
                $m .= "panel?id=".$v->id."/";
              }
            }
             ?>
            <li class="treeview <?php echo activate_menu($m);?>">
              <a href="<?php echo base_url(); ?>">
                <i class="fa fa-tasks"></i> <span>???????????????</span></i>
              </a>
              <ul class="treeview-menu">
                <li><a href="<?php echo base_url()."board_settings"  ?>"><i class="fa fa-circle-o"></i>????????? ??????</a></li>
                <li><a href="<?php echo base_url()."Bbs_SetUp_W"  ?>"><i class="fa fa-circle-o"></i>????????? ??????</a></li>
              <?
              if(!empty($board)): ?>
                  <?php foreach($board as $value): ?>
                  <li  <?php if($this->input->get("board_type") == $value->id) echo "class='active';";  ?>><a href="<?php echo base_url()."panel?id=".$value->id  ?>" >
                    <i class="fa fa-circle-o"></i><?=$value->title?></a></li>
                  <?php endforeach; ?>
              <?php endif; ?>
              </ul>
            </li>
            <?php endif; ?>
            <?php if(in_array(3, $menu_list)): ?>
            <?php $env = activate_menu("/addManger/managerList/deliveryTable/deliverAddress/shoppingmal/incomingBank/topcat/childCat/registered_mail/accuringRate/customexRate/deliveryFee/tackbae/send_management/"); ?>
            <li class="treeview <?php echo $env ;?>">
              <a href="#">
                <i class="fa fa-cog"></i> <span>????????????</span></i>
              </a>
              <ul class="treeview-menu">
                <?php if($this->session->userdata('userId') ==1): ?>
                <li class="<?=activate_menu("/managerList/addManger/");?>"><a href="<?php echo base_url()."managerList"  ?>"><i class="fa fa-circle-o"></i>????????? ??????</a></li>
                <?php endif; ?>
                <?php if(in_array(31, $menu_list)): ?>
                <li><a href="<?php echo base_url()."deliveryTable"  ?>"><i class="fa fa-circle-o"></i>??????????????????</a></li>
                <?php endif; ?>
                <?php if(in_array(32, $menu_list)): ?>
                <li><a href="<?php echo base_url()."deliverAddress"  ?>"><i class="fa fa-circle-o"></i>?????????????????????</a></li>
                <?php endif; ?>
                <?php if(in_array(33, $menu_list)): ?>
                <li><a href="<?php echo base_url()."shoppingmal"  ?>"><i class="fa fa-circle-o"></i>????????????????????????</a></li>
                <?php endif; ?>
                <?php if(in_array(34, $menu_list)): ?>
                <li><a href="<?php echo base_url()."incomingBank"  ?>"><i class="fa fa-circle-o"></i>??????????????????</a></li>
                <?php endif; ?>
                <?php if(in_array(35, $menu_list)): ?>
                <li><a href="<?php echo base_url()."topcat"  ?>"><i class="fa fa-circle-o"></i>??????????????????</a></li>
                <?php endif; ?>
                <?php if(in_array(36, $menu_list)): ?>
                <li><a href="<?php echo base_url()."childCat"  ?>"><i class="fa fa-circle-o"></i>????????????</a></li>
                <?php endif; ?>
                <?php if(in_array(37, $menu_list)): ?>
                <li><a href="<?php echo base_url()."registered_mail"  ?>"><i class="fa fa-circle-o"></i>???????????? ????????????</a></li>
                <?php endif; ?>
                <?php if(in_array(39, $menu_list)): ?>
                <li><a href="<?php echo base_url()."accuringRate"  ?>"><i class="fa fa-circle-o"></i>????????????</a></li>
                <?php endif; ?>
                <?php if(in_array(310, $menu_list)): ?>
                <li><a href="<?php echo base_url()."customexRate"  ?>"><i class="fa fa-circle-o"></i>?????????????????????</a></li>
                <?php endif; ?>
                <?php if(in_array(311, $menu_list)): ?>
                <li><a href="<?php echo base_url()."deliveryFee"  ?>"><i class="fa fa-circle-o"></i>?????????????????????</a></li>
                <?php endif; ?>
                <?php if(in_array(312, $menu_list)): ?>
                <li><a href="<?php echo base_url()."tackbae"  ?>"><i class="fa fa-circle-o"></i>????????? ??????</a></li>
                <?php endif; ?>
                <?php if(in_array(313, $menu_list)): ?>
                <li><a href="<?php echo base_url()."send_management"  ?>"><i class="fa fa-circle-o"></i>???????????? ??????</a></li>
                <?php endif; ?>
              </ul>
            </li>
            <?php endif; ?>
            <?php if(in_array(4, $menu_list)): ?>
            <li class="treeview <?php echo activate_menu("/homePage/banner_s/pages/event/popup/recomment_site/recomment_products/pages_edit/notsbyregister/footer_management/homePage?mobile=1/");?>">
              <a href="<?php echo base_url(); ?>">
                <i class="fa fa-home"></i> <span>??????????????????</span></i>
              </a>
              <ul class="treeview-menu">
                <li class="<?=activate_menu("/homePage/");?>"><a href="<?php echo base_url()."homePage"  ?>"><i class="fa fa-circle-o"></i>??????????????????</a></li>
                <li class="<?=activate_menu("/homePage?mobile=1/");?>"><a href="<?php echo base_url()."homePage?mobile=1"  ?>"><i class="fa fa-circle-o"></i>???????????????????????????</a></li>
                <li class="<?=activate_menu("/banner_s/");?>"><a href="<?php echo base_url()."banner_s?type=2"  ?>"><i class="fa fa-circle-o"></i>??????????????????</a></li>
                <li class=" <?php echo activate_menu("/pages/pages_edit/");?>">
                  <a href="<?php echo base_url()."pages"  ?>"><i class="fa fa-circle-o"></i>???????????????</a></li>
                <li><a href="<?php echo base_url()."event"  ?>"><i class="fa fa-circle-o"></i>?????????</a></li>
                <li><a href="<?php echo base_url()."popup"  ?>"><i class="fa fa-circle-o"></i>????????????</a></li>
                <li><a href="<?php echo base_url()."recomment_site"  ?>"><i class="fa fa-circle-o"></i>???????????????</a></li>
                <li><a href="<?php echo base_url()."recomment_products"  ?>"><i class="fa fa-circle-o"></i>????????????</a></li>
                <li><a href="<?php echo base_url()."notsbyregister"  ?>"><i class="fa fa-circle-o"></i>????????????,????????????</a></li>
                <li><a href="<?php echo base_url()."footer_management"  ?>"><i class="fa fa-circle-o"></i>Header,Footer ??????</a></li>
              </ul>
            </li>
            <?php endif; ?>
            <?php if(in_array(5, $menu_list)): ?>
            <li class="treeview <?php echo activate_menu("/coupon_register/couponList/eventCoupon/");?>">
              <a href="<?php echo base_url(); ?>">
                <i class="fa fa-quote-left"></i> <span>????????????</span></i>
              </a>
              <ul class="treeview-menu">
                <li><a href="<?php echo base_url()."coupon_register"  ?>"><i class="fa fa-circle-o"></i>??????????????????</a></li>
                <li><a href="<?php echo base_url()."couponList"  ?>"><i class="fa fa-circle-o"></i>??????????????????</a></li>
                <li><a href="<?php echo base_url()."eventCoupon"  ?>"><i class="fa fa-circle-o"></i>???????????????</a></li>
              </ul>
            </li>
            <?php endif; ?>
            <?php if(in_array(6, $menu_list)): ?>
            <li class="treeview <?php echo activate_menu("/add_points/registerPoint/");?>">
              <a href="<?php echo base_url(); ?>">
                <i class="fa fa-quote-left"></i> <span>???????????????</span></i>
              </a>
              <ul class="treeview-menu">
                 <li><a href="<?php echo base_url()."add_points"  ?>"><i class="fa fa-circle-o"></i>???????????????</a></li>
                 <li><a href="<?php echo base_url()."registerPoint"  ?>"><i class="fa fa-circle-o"></i>???????????????</a></li> 
              </ul>
            </li>
            <?php endif; ?>
            <?php if(in_array(7, $menu_list)): ?>
            <li class="treeview <?php echo activate_menu("/service_type/service_management/");?>">
              <a href="service_management">
                <i class="fa fa-envelope"></i> <span>???????????????</span></i>
              </a>
              <ul class="treeview-menu">
                <li><a href="<?php echo base_url()."service_type"  ?>"><i class="fa fa-circle-o"></i>??????????????? ??????</a></li>
                <li><a href="<?php echo base_url()."service_management"  ?>"><i class="fa fa-circle-o"></i>??????????????? ??????</a></li>
              </ul>
            </li>
            <?php endif; ?>
            <?php if(in_array(8, $menu_list)): ?>
            <li class="treeview">
              <a href="">
                <i class="fa fa-envelope"></i> <span>SMS??????</span></i>
              </a>
              <ul class="treeview-menu">
                <li><a href="javascript:alert('SMS ?????????????????????')"><i class="fa fa-circle-o"></i>SMS ??????</a></li>
                <li><a href="<?php echo base_url()."sms_history"  ?>"><i class="fa fa-circle-o"></i>SMS ????????????</a></li>
                <li><a href="#"><i class="fa fa-circle-o"></i>SMS ????????????</a></li>
              </ul>
            </li>
            <?php endif; ?>
            <?php if(in_array(9, $menu_list)): ?>
            <li class="treeview <?php echo activate_menu("/pay_order/memberpay/orderhistory/");?>">
              <a href="<?php echo base_url(); ?>">
                <i class="fa fa-bar-chart"></i> <span>????????????</span></i>
              </a>
              <ul class="treeview-menu">
                <li><a href="<?php echo base_url()."pay_order"  ?>"><i class="fa fa-circle-o"></i>???????????????</a></li>
                <li><a href="<?php echo base_url()."memberpay"  ?>"><i class="fa fa-circle-o"></i>???????????????</a></li>
              </ul>
            </li>
            <?php endif; ?>
            <?php if(in_array(10, $menu_list)): ?>
            <li class="treeview <?php echo activate_menu("/mail/editMail/");?>">
              <a href="<?php echo base_url(); ?>">
                <i class="fa fa-cog"></i> <span>????????????</span></i>
              </a>
              <ul class="treeview-menu">
                <li class="<?=activate_menu("/mail/editMail/");?>"><a href="<?php echo base_url()."mail"  ?>"><i class="fa fa-circle-o"></i>????????????</a></li>
              </ul>
            </li>
            <?php endif; ?>
            <?php if(in_array(11, $menu_list)): ?>
            <li class="treeview <?php echo activate_menu("/addNew/registerDepoit/userListing/exitMember/memberLevel/registerDeposit/returnDeposit/deposithistory/editOld/editmemberL/");?>">
              <a href="<?php echo base_url(); ?>">
                <i class="fa fa-users"></i>
                <span>????????????</span>
              </a>
              <ul class="treeview-menu">
                <?php if(in_array(111, $menu_list)): ?>
                <li class="<?=activate_menu("/addNew/userListing/editOld/");?>"><a href="<?php echo base_url()."userListing"  ?>">
                  <i class="fa fa-circle-o"></i>???????????????</a></li>
                <?php endif; ?>
                <?php if(in_array(112, $menu_list)): ?>
                <li><a href="<?php echo base_url()."exitMember"  ?>"><i class="fa fa-circle-o"></i>????????????</a></li>
                <?php endif; ?>
                <?php if(in_array(113, $menu_list)): ?>
                <li class="<?=activate_menu("/memberLevel/editmemberL/");?>"><a href="<?php echo base_url()."memberLevel"  ?>">
                  <i class="fa fa-circle-o"></i>??????????????????</a></li>
                <?php endif; ?>
                <?php if(in_array(114, $menu_list)): ?>
                <li><a href="<?php echo base_url()."registerDeposit"  ?>"><i class="fa fa-circle-o"></i>???????????????</a></li>
                <?php endif; ?>
                <?php if(in_array(115, $menu_list)): ?>
                <li><a href="<?php echo base_url()."returnDeposit"  ?>"><i class="fa fa-circle-o"></i>?????????????????????</a></li>
                <?php endif; ?>
                <?php if(in_array(116, $menu_list)): ?>
                <li><a href="<?php echo base_url()."deposithistory"  ?>"><i class="fa fa-circle-o"></i>?????????????????????</a></li> 
                <?php endif; ?>
              </ul>
            </li>
            <?php endif; ?>
            <?php if(in_array(12, $menu_list)): ?>
            <?php $ssh = activate_menu("/addshop/company/shopProducts/editsproduct/editCategory/categoryProducts/shopcategory/ico/addIcon/product_wish/shop_banner/config_delivery/delivery_addprice_list/addDeliveryPrice/product_talk/product_talk_modify/");?>
            <li class="treeview <?php echo $ssh;?>">
              <a href="<?php echo base_url(); ?>">
                <i class="fa fa-shopping-cart"></i>
                <span>???????????????</span>
              </a>
              <ul class="treeview-menu">
                <li class="<?=activate_menu("/product_talk?type=eval/product_talk_modify?status=reply&type=eval/");?>">
                  <a href="<?php echo base_url()."product_talk?type=eval"  ?>" class="<?php echo $ssh;?>"><i class="fa fa-circle-o"></i>???????????????</a>
                </li>
                <li class="<?=activate_menu("/product_talk?type=qna/product_talk_modify?status=reply&type=qna/");?>">
                  <a href="<?php echo base_url()."product_talk?type=qna"  ?>" class="<?php echo $ssh;?>"><i class="fa fa-circle-o"></i>??????????????????</a>
                </li>
                <?php if(in_array(38, $menu_list)): ?>
                <li><a href="<?php echo base_url()."company"  ?>"><i class="fa fa-circle-o"></i>???????????? ??????</a></li>
                <?php endif; ?>
                <li class="<?=activate_menu("/config_delivery/");?>">
                  <a href="<?php echo base_url()."config_delivery"  ?>" class="<?php echo $ssh;?>"><i class="fa fa-circle-o"></i>??????/??????????????????</a>
                </li>
                <li class="<?=activate_menu("/addshop/shopProducts/editsproduct/");?>">
                  <a href="<?php echo base_url()."shopProducts"  ?>" class="<?php echo $ssh;?>"><i class="fa fa-circle-o"></i>????????????</a>
                </li>
                <li class="<?=activate_menu("/editCategory/categoryProducts/");?>">
                  <a href="<?php echo base_url()."categoryProducts"  ?>" class="<?php echo $ssh;?>"><i class="fa fa-circle-o"></i>?????? ??????????????????</a>
                </li>
                <li class="<?=activate_menu("/shopcategory/");?>">
                  <a href="<?php echo base_url()."shopcategory"  ?>" class="<?php echo $ssh;?>"><i class="fa fa-circle-o"></i>????????? ??????????????????</a>
                </li>
                <li class="<?=activate_menu("/ico/addIcon/");?>">
                  <a href="<?php echo base_url()."ico"  ?>" class="<?php echo $ssh;?>"><i class="fa fa-circle-o"></i>?????? ???????????????</a>
                </li>
                <li class="<?=activate_menu("/product_wish/");?>">
                  <a href="<?php echo base_url()."product_wish"  ?>" class="<?php echo $ssh;?>"><i class="fa fa-circle-o"></i>???????????????</a>
                </li>
                <li class="<?=activate_menu("/shop_banner/");?>">
                  <a href="<?php echo base_url()."shop_banner"  ?>" class="<?php echo $ssh;?>"><i class="fa fa-circle-o"></i>????????? ????????????</a>
                </li>
                <li class="<?=activate_menu("/delivery_addprice_list/addDeliveryPrice/");?>">
                  <a href="<?php echo base_url()."delivery_addprice_list"  ?>" class="<?php echo $ssh;?>"><i class="fa fa-circle-o"></i>???????????? ??????????????? ??????</a>
                </li>
              </ul>
            </li>
            <?php endif; ?>
            <?php $ssh = activate_menu("/loginlog/monthloginlog/yearloginlog/timeloginlog/visitlog/monthvisitlog/yearvisitlog/timevisitlog/regionvisitlog/");?>

            <li class="<?=$ssh?>">
              <a href="#">
                <i class="fa fa-history"></i> <span>????????????</span></i>
              </a>
              <ul class="treeview-menu">
                <li class="<?=activate_menu("/loginlog/");?>"><a href="<?php echo base_url()."loginlog"?>"><i class="fa fa-circle-o"></i>?????? ????????????</a></li>
                <li class="<?=activate_menu("/monthloginlog/");?>"><a href="<?php echo base_url()."monthloginlog"?>"><i class="fa fa-circle-o"></i>?????? ????????????</a></li>
                <li class="<?=activate_menu("/yearloginlog/");?>"><a href="<?php echo base_url()."yearloginlog"?>"><i class="fa fa-circle-o"></i>?????? ????????????</a></li>
                <li class="<?=activate_menu("/timeloginlog/");?>"><a href="<?php echo base_url()."timeloginlog"?>"><i class="fa fa-circle-o"></i>???????????? ????????????</a></li>
                <li><a href="<?php echo base_url()."visitlog"?>"><i class="fa fa-circle-o"></i>?????? ????????????</a></li>
                <li href="<?php echo base_url()."yearvisitlog"?>"><a href="<?php echo base_url()."yearvisitlog"?>"><i class="fa fa-circle-o"></i>?????? ????????????</a></li>
                <li><a href="<?php echo base_url()."monthvisitlog"?>"><i class="fa fa-circle-o"></i>?????? ????????????</a></li>
                <li class="<?=activate_menu("/timevisitlog/");?>"><a href="<?php echo base_url()."timevisitlog"?>"><i class="fa fa-circle-o"></i>???????????? ????????????</a></li>

                <li class="<?=activate_menu("/regionvisitlog/");?>"><a href="<?php echo base_url()."regionvisitlog"?>">
                  <i class="fa fa-circle-o"></i>????????? ????????????</a>
                </li>
              </ul>
            </li>

            <?php $ssh = activate_menu("/gradeLogin/depositLogin/dayRegister/weekRegister/MonthRegister/RegionRegister/membershopping/memberBuy/");?>
            <li class="<?=$ssh?>">
              <a href="#">
                <i class="fa fa-history"></i> <span>????????? ????????????</span></i>
              </a>
              <ul class="treeview-menu">
                  <li class="<?=activate_menu("/gradeLogin/");?>"><a href="<?php echo base_url()."gradeLogin"?>"><i class="fa fa-circle-o"></i>?????? ????????????</a></li>
                  <li class="<?=activate_menu("/membershopping/");?>"><a href="<?php echo base_url()."membershopping"?>"><i class="fa fa-circle-o"></i>?????? ???????????? ??????</a></li>
                  <li class="<?=activate_menu("/memberBuy/");?>"><a href="<?php echo base_url()."memberBuy"?>"><i class="fa fa-circle-o"></i>?????? ???????????? ??????</a></li>
                  <li><a href="<?php echo base_url()."depositLogin"?>"><i class="fa fa-circle-o"></i>?????? ???????????????</a></li>
                  <li><a href="<?php echo base_url()."dayRegister"?>"><i class="fa fa-circle-o"></i>?????? ????????????</a></li>
                  <li><a href="<?php echo base_url()."weekRegister"?>"><i class="fa fa-circle-o"></i>?????? ????????????</a></li>
                  <li><a href="<?php echo base_url()."MonthRegister"?>"><i class="fa fa-circle-o"></i>?????? ????????????</a></li>
                  <li><a href="<?php echo base_url()."RegionRegister"?>"><i class="fa fa-circle-o"></i>?????? ?????????(?????????)?????????</a></li>
              </ul>
            </li>

            <?php $ssh = activate_menu("/purchasedProducts/viewedProducts/viewedCategory/purchasedCategory/searchProducts/");?>
            <li class="<?=$ssh?>">
              <a href="#">
                <i class="fa fa-history"></i> <span>?????? ????????????</span></i>
              </a>
              <ul class="treeview-menu">
                  <li><a href="<?php echo base_url()."purchasedProducts"?>"><i class="fa fa-circle-o"></i>??????????????? ????????????</a></li>
                  <li><a href="<?php echo base_url()."viewedProducts"?>"><i class="fa fa-circle-o"></i>?????? ?????? ????????????</a></li>
                  <li><a href="<?php echo base_url()."viewedCategory"?>"><i class="fa fa-circle-o"></i>?????? ????????? ?????? ????????????</a></li>
                  <li><a href="<?php echo base_url()."purchasedCategory"?>"><i class="fa fa-circle-o"></i>?????? ???????????? ?????? ????????????</a></li>
                  <li><a href="<?php echo base_url()."searchProducts"?>"><i class="fa fa-circle-o"></i>?????? ????????? ????????????</a></li>
              </ul>
            </li>

            <?php $ssh = activate_menu("/monthSite/daySite/weekSite/");?>
            <li class="<?=$ssh?>">
              <a href="#">
                <i class="fa fa-history"></i> <span>??????????????? ????????????</span></i>
              </a>
              <ul class="treeview-menu">
                  <li><a href="<?php echo base_url()."daySite"?>"><i class="fa fa-circle-o"></i>?????? ?????????????????????</a></li>
                  <li class="<?=activate_menu("/weekSite/");?>"><a href="<?php echo base_url()."weekSite"?>"><i class="fa fa-circle-o"></i>?????? ?????????????????????</a></li>
                  <li class="<?=activate_menu("/monthSite/");?>"><a href="<?php echo base_url()."monthSite"?>"><i class="fa fa-circle-o"></i>?????? ?????????????????????</a></li>
              </ul>
            </li>

            <?php $ssh = activate_menu("/getStrange/");?>
            <li class="<?=$ssh?>">
              <a href="<?=base_url()?>getStrange">
                <i class="fa fa-history"></i> <span>????????? ????????????</span></i>
              <a>
            </li>
            <li >
              <a href="<?=base_url()?>backup">
              <i class="fa fa-history"></i> <span>???????????? ??????</span></i>
              <a>
            </li>
          </ul>
        </section>
        <!-- /.sidebar -->
      </aside>
