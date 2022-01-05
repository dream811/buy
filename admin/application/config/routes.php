<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$route['default_controller'] = "login";
$route['404_override'] = 'error';

/*********** USER DEFINED ROUTES *******************/
$route['index'] = 'home/index';
$route['loginMe'] = 'login/loginMe';
$route['dashboard'] = 'home/dashboard';
$route['dashboard/(:num)'] = "home/dashboard/$1";
$route['logout'] = 'user/logout';
$route['userListing'] = 'user/userListing';
$route['userListing/(:num)'] = "user/userListing/$1";
$route['addNew'] = "user/addNew";
$route['managerList'] = "user/managerList";
$route['managerList/(:num)'] = "user/managerList/$1";
$route['addManger'] = 'user/addManger';
$route['addProcessmanger'] = 'user/addProcessmanger';
$route['addNewUser'] = "user/addNewUser";
$route['editOld'] = "user/editOld";
$route['editOld/(:num)'] = "user/editOld/$1";
$route['editUser'] = "user/editUser";
$route['deleteUser'] = "user/deleteUser";
$route['loadChangePass'] = "user/loadChangePass";
$route['changePassword'] = "user/changePassword";
$route['pageNotFound'] = "user/pageNotFound";
$route['checkEmailExists'] = "user/checkEmailExists";
$route['forgotPassword'] = "login/forgotPassword";
$route['resetPasswordUser'] = "login/resetPasswordUser";
$route['resetPasswordConfirmUser'] = "login/resetPasswordConfirmUser";
$route['resetPasswordConfirmUser/(:any)'] = "login/resetPasswordConfirmUser/$1";
$route['resetPasswordConfirmUser/(:any)/(:any)'] = "login/resetPasswordConfirmUser/$1/$2";
$route['createPasswordUser'] = "login/createPasswordUser";
$route['productListing'] = "home/productListing";
$route['activeProduct'] = "home/activeProduct";
$route['changeProduct'] ="home/changeProduct";
$route['changeOrder'] = 'home/changeOrder';
$route['alert'] = 'home/alert';
$route['setSendingPay'] = 'home/setSendingPay';
$route['ActiveMoney'] = 'home/ActiveMoney';
$route['orderProduct'] = 'home/OrderProduct';
$route['orderProduct/(:num)'] = "home/OrderProduct/$1";
$route['payhistory'] = 'home/payhistory';
$route['payhistory/(:num)'] = "home/payhistory/$1";
$route['nodata']  = 'home/nodata';
$route['groupbuy'] = 'home/groupBuy';
$route['groupbuy/(:num)'] = 'home/groupBuy/$1';
$route['addProduct'] = 'home/addProduct';
$route['editProduct/(:num)'] = "home/editProduct/$1";
$route['registerProduct'] ='home/registerProduct';
$route['private'] ='home/privateMes';
$route['private/(:num)'] ='home/privateMes/$1';
$route['after_use'] ='home/after_use';
$route['after_use/(:num)'] ='home/after_use/$1';
$route['offque'] ='home/offque';
$route['offque/(:num)'] ='home/offque/$1';
$route['publicreq'] ='home/publicreq';
$route['publicreq/(:num)'] ='home/publicreq/$1';
$route['viewReq/(:num)'] ='Home/viewMessage/$1';
$route["changeOrderNUmber"] = "home/changeOrderNUmber";
$route["changeTracks"] = "home/changeTracks";
$route['deliveryTable'] = 'home/deliveryTable';
$route['writeComment'] = "home/writeComment";
$route['writePost/(:num)'] = 'home/writePost/$1';
$route['bbs'] = 'home/bbs';
$route['deliverAddress'] = 'home/deliverAddress';
$route['updateDelA'] = 'home/updateDelA';
$route['deleteDt'] = 'home/deleteDt';
$route['getDelA'] = 'home/getDelA';
$route['incomingBank'] = 'home/incomingBank';
$route['saveBank'] ='home/saveBank';
$route['company'] ='home/company';
$route['saveCompany'] = 'home/saveCompany';
$route['accuringRate'] = 'home/accuringRate';
$route['saveAccurRate'] = 'home/saveAccurRate';
$route['customexRate'] = 'home/customexRate';
$route['saveCustomRate'] = 'home/saveCustomRate';
$route['deliveryFee'] = 'home/deliveryFee';
$route['saveFee'] = 'home/saveFee';
$route['topcat'] = "home/topcat";
$route['topcat/(:num)'] = "home/topcat/$1";
$route['saveCategory'] = "home/saveCategory";
$route['childCat'] = "home/childCat";
$route['childCat/(:num)'] = "home/childCat/$1";
$route['getCat'] = "home/getCat";
$route['saveDeliveryTable'] = "home/saveDeliveryTable";
$route['memberLevel'] = 'home/memberLevel';
$route['saveMemberLevel'] = 'home/saveMemberLevel';
$route['shoppingmal']  = 'home/shoppingmal';
$route['saveShoppingMal'] = 'home/saveShoppingMal';
$route['coupon_register'] = 'home/coupon_register';
$route['saveCoupon'] = 'home/saveCoupon';
$route['eventCoupon'] = 'home/eventCoupon';
$route['couponList'] = "home/couponList";
$route['couponList/(:num)'] = "home/couponList/$1";
$route['deleteCoupon'] = 'home/deleteCoupon';
$route['mail'] = 'home/mail';
$route['mail/(:num)'] = 'home/mail/$1';
$route['viewMessage'] = 'home/viewMail';
$route['editMail/(:num)'] = 'home/editMail/$1';
$route['SaveMail'] = 'home/SaveMail';
$route['pay_order'] = 'home/OrderHistory';
$route['pay_order/(:num)'] = 'home/OrderHistory/$1';
$route['memberpay'] = 'home/memberpay';
$route['memberpay/(:num)'] = 'home/memberpay/$1';
$route['exitMember'] = 'user/exitMember';
$route['registerPoint'] = 'home/registerPoint';
$route['registerPoint/(:num)'] = 'home/registerPoint/$1';
$route['savePointUsers'] = 'home/savePointUsers';
$route['cancelPoint/(:num)'] = "home/cancelPoint/$1";
$route['deletePoint'] = 'home/deletePoint';
$route['registerDeposit'] = 'home/registerDepoit';
$route['registerDeposit/(:num)'] = 'home/registerDepoit/$1';
$route['updateDeposit'] = 'home/updateDeposit';
$route['ActDelivery'] = 'home/ActDelivery';
$route['getProduct'] = 'home/getProduct';
$route['UpdateDelivery'] = 'home/UpdateDelivery';
$route['ShowDelivery'] = 'home/ShowDelivery';
$route['setMemo'] = 'home/setMemo';
$route['setTrackDelivery'] = 'home/setTrackDelivery';
$route['updateTrackNumber'] = 'home/updateTrackNumber';
$route['homePage'] = 'home/homePage';
$route['saveBanner'] = 'home/saveBanner';
$route['banner_s'] = 'home/banner_s';
$route['saveBannerR'] = 'home/saveBanner_S';
$route['event'] = 'home/event';
$route['saveEvent'] = 'home/saveEvent';
$route['popup'] = 'home/popup';
$route['savePopup'] = 'home/savePopup';
$route['recomment_site'] = 'home/recomment_site';
$route['saveRecommend'] = 'home/saveRecommend';
$route['recomment_products'] = 'home/recomment_products';
$route['saveRecommentProduct'] = 'home/saveRecommentProduct';
$route['sms_history'] = 'home/sms_history';
$route['ActReturn'] = 'home/ActReturn';
$route['paying'] ='home/paying';
$route['paying/(:num)'] ='home/paying/$1';
$route['deletePd'] ='home/deletePd';
$route['deleteDtable'] ='home/deleteDtable';
$route['getShopping'] = 'home/getShopping';
$route['deleteShop'] = 'home/deleteShop';
$route['getCats'] = 'home/getCats';
$route['deleteCat'] = 'home/deleteCat';
$route['getHome'] = 'home/getHome';
$route['deleteHome'] = 'home/deleteHome';
$route['getBanner'] ='home/getBanner';
$route['deleteBanner'] = 'home/deleteBanner';
$route['getEvent'] = 'home/getEvent';
$route['deleteEvent'] = 'home/deleteEvent';
$route['editPopup'] = 'home/editPopup';
$route['deletePopup'] = 'home/deletePopup';
$route['editRecommend'] = 'home/editRecommend';
$route['deleteRecommend'] = 'home/deleteRecommend';
$route['editRecomP'] = 'home/editRecomP';
$route['deleteRecomP'] = 'home/deleteRecomP';
$route['shopProducts'] ='home/shopProducts';
$route['shopProducts/(:num)'] ='home/shopProducts/$1';
$route['addshop'] ='home/addshop';
$route['registerShop'] ='home/registerShop';
$route['shopcat'] = 'home/shopcat';
$route['editsproduct/(:num)'] = 'home/editsproduct/$1';
$route['deletesproduct'] = 'home/deletesproduct';
$route['getCateogrys'] = "home/getCateogrys";
$route['registerImage']= 'home/registerImage';
$route['updateDeliver'] ='home/updateDeliver';
$route['ActingPro_W'] = 'home/ActingPro_W';
$route['updateProduct'] = 'home/updateProduct';
$route['returnDeposit'] = 'home/returnDeposit';
$route['returnDeposit/(:num)'] = 'home/returnDeposit/$1';
$route['updateReturnDeposit'] = 'home/updateReturnDeposit';
$route['Comment_W'] = "home/Comment_W";
$route['deliveryComment'] = "home/deliveryComment";
$route['verifyDeposit'] ='home/verifyDeposit';
$route['cancelDeposit'] ='home/cancelDeposit';
$route['sendMail'] ='home/sendMail';
$route['PopNote_I'] = 'home/PopNote_I';
$route['deposithistory'] = 'home/deposithistory';
$route['deposithistory/(:num)'] = 'home/deposithistory/$1';
$route['saveDeposit'] = 'home/saveDeposit';
$route['DpstUseDet_M']= 'home/DpstUseDet_M';
$route['Box_Cnt_M'] = 'home/Box_Cnt_M';
$route['getDelivery'] = 'home/getDelivery';
$route['editBoard/(:num)'] = 'home/editBoard/$1';
$route['deleteBoard']="home/deleteBoard";
$route['updateBoard']="home/updateBoard";
$route['deleteF']="home/deleteF";
$route['view-photo']="home/view_photo";
$route['Acting_D'] = 'home/Acting_D';
$route['ActingAdrs_W'] = 'home/ActingAdrs_W';
$route['ActingAdrs_M'] ='home/ActingAdrs_M';
$route['User_MemAddr_S'] = 'home/User_MemAddr_S';
$route['Acting_Del'] = 'home/Acting_Del';
$route['getOT'] = 'home/getOT';
$route['trackPaper'] = 'home/trackPaper';
$route['ActingExcel_W'] = 'home/ActingExcel_W';
$route['Bbs_SetUp_W'] = 'home/Bbs_SetUp_W';
$route['addBoard'] = 'home/addBoard';
$route['board_settings']= 'home/board_settings';
$route['editboards/(:num)'] = 'home/editboards/$1';
$route['panel'] = 'home/panel';
$route['panel/(:num)'] = 'home/panel/$1';
$route['actionUsers'] = 'home/actionUsers';
$route['registered_mail']  ='home/registered_mail';
$route['addRegisteredMail']='home/addRegisteredMail';
$route['pages'] = 'home/pages';
$route['pages_edit/(:num)'] = 'home/pages_edit/$1';
$route['addPage'] = 'home/addPage';
$route['NtDet_W'] = 'home/NtDet_W';
$route['multisend'] = 'home/multisend';
$route['NtDet_D'] = 'home/NtDet_D';
$route['IdChk'] = 'home/IdChk';
$route['Mem_U'] = 'home/Mem_U';
$route['Mem_X'] = 'home/Mem_X';
$route['bbs_fl_D'] = 'home/bbs_fl_D';
$route['editmemberL/(:num)'] = 'home/editmemberL/$1';
$route["seporders"] = "home/seporders";
$route['Mem_Grade_S'] = 'home/Mem_Grade_S';
$route['getCommentMore'] = 'home/getCommentMore';
$route['deleteComment'] = 'home/deleteComment';
$route['ActingExcel_I'] ='home/ActingExcel_I';
$route["downloadI"] = "home/downloadI";
$route["changeLevel"] = "home/changeLevel";
$route["addOption"] = "home/addOption";
$route["addItem"] = "home/addItem";
$route["deleteOption"] = "home/deleteOption";
$route['editOption'] = "home/editOption";
$route["updateItem"]='home/updateItem';
$route["deleteAcc"]='home/deleteAcc';
$route["setting_point"]='home/setting_point';
$route["savepointRegister"]='home/savepointRegister';
$route["add_points"]='home/add_points';
$route["savePointByRegister"]='home/savePointByRegister';
$route["deletePointR"]='home/deletePointR';
$route["eventPoint"]='home/eventPoint';
$route["note"]='home/note';
$route["note/(:num)"]='home/note/$1';
$route["deleteNotes"]='home/deleteNotes';
$route['saveEventHomepage'] = 'home/saveEventHomepage';
$route['notsbyregister'] = 'home/notsbyregister';
$route['saveregisternots'] = 'home/saveregisternots';
$route['updateOrderBanner'] = 'home/updateOrderBanner';
$route['footer_management'] = 'home/footer_management';
$route['saveHeader'] = 'home/saveHeader';
$route['saveFooter'] = 'home/saveFooter';
$route['saveMobileHeader'] = 'home/saveMobileHeader';
$route['tackbae'] = 'home/tackbae';
$route['addTackBae'] = 'home/addTackBae';
$route['deleteTack'] = 'home/deleteTack';
$route['send_management'] = 'home/send_management';
$route['deleteSend'] = 'home/deleteSend';
$route['addSends'] = 'home/addSends';
$route['service_management'] = 'home/service_management';
$route['service_type'] = 'home/service_type';
$route['editServiceType'] = 'home/editServiceType';
$route['deleteServiceType'] = 'home/deleteServiceType';
$route['saveServiceType'] = 'home/saveServiceType';
$route['editService'] = 'home/editService';
$route['saveService'] = 'home/saveService';
$route['getCateogory'] = 'home/getCateogory';
$route['editAddress'] = 'home/editAddress';
$route['deletePost'] = 'Home/deletePost';
$route['deleteCustomX'] ="Home/deleteCustomX";
$route['categoryProducts'] = "Home/categoryProducts";
$route['categoryProducts/(:num)'] = "Home/categoryProducts/$1";
$route['editCategory'] = "Home/editCategory";
$route['editCategory/(:num)'] = "Home/edit_category/$1";
$route['registerCategory'] = "Home/registerCategory";
$route['del_cats'] = "Home/del_cats";
$route['deleteProductImage'] = "Home/deleteProductImage";
$route['changeGrade'] = "Home/changeGrade";
$route['viewNote'] = "Home/viewNote";

$route['deleteFooterImg'] = "Home/deleteFooterImg";

$route['edtCoupon'] = "Home/edtCoupon";
$route['delCoupon'] = "Home/delCoupon";

$route['shopcategory'] = "Home/shopcategory";

$route['category_pro'] = "Home/category_pro";

$route['addShopCategory'] = "Home/addShopCategory";

$route["getshopcategory"] = "Home/getshopcategory";

$route["deleteShopBanner"] = "Home/deleteShopBanner";

$route['ico'] = "Home/ico";

$route['addIcon'] = "Home/addIcon";

$route['CreateIcon'] = "Home/CreateIcon";

$route['deleteIconImage'] = "Home/deleteIconImage";

$route['product_wish'] = "Home/product_wish";

$route['shop_banner'] = "Home/shop_banner";

$route['setCategoryShop'] = "Home/setCategoryShop";

$route['config_delivery'] = "Home/config_delivery";

$route['product_option'] = "Home/product_option";

$route["product_option_save"] = "Home/product_option_save";

$route["saveOrderOptions"] = "Home/saveOrderOptions";

$route["multi_categories"] = "Home/multi_categories";

$route["config_delivery_pro"] = "Home/config_delivery_pro";

$route['delivery_addprice_list'] = "Home/delivery_addprice_list";

$route['delivery_addprice_list/(:num)'] = "Home/delivery_addprice_list/$1";

$route["addDeliveryPrice"] = "Home/addDeliveryPrice";

$route['updateAddDeliveryAddress'] = "Home/updateAddDeliveryAddress";

$route['deleteAddDelvieryAddress'] = "Home/deleteAddDelvieryAddress";

$route["product_talk"] = "Home/product_talk";
$route["product_talk/(:num)"] = "Home/product_talk/$1";
$route["deleteEval"] = "Home/deleteEval";

$route["product_talk_modify"] = "Home/product_talk_modify";

$route["deleteRequestImage"] = "Home/deleteRequestImage";

$route["updateProductTalk"] = "Home/updateProductTalk";

$route["getDeliveryBySecurity"] = "Home/getDeliveryBySecurity";

$route["updateOrderCategory"] = "Home/updateOrderCategory";

$route["deleteIconItem"] = "Home/deleteIconItem";

$route["deleteWishes"] = "Home/deleteWishes";

$route["loginlog"] = "Home/loginlog";

$route["monthloginlog"] = "Home/monthloginlog";

$route["yearloginlog"] = "Home/yearloginlog";

$route["timeloginlog"] = "Home/timeloginlog";


$route["visitlog"] = "Home/visitlog";

$route["monthvisitlog"] = "Home/monthvisitlog";

$route["yearvisitlog"] = "Home/yearvisitlog";

$route["timevisitlog"] = "Home/timevisitlog";

$route["gradeLogin"] = "Home/gradeLogin";
$route["gradeLogin/(:num)"] = "Home/gradeLogin/$1";

$route["depositLogin"] = "Home/depositLogin";

$route["depositLogin/(:num)"] = "Home/depositLogin/$1";

$route["dayRegister"] = "Home/dayRegister";

$route["weekRegister"] = "Home/weekRegister";

$route["MonthRegister"] = "Home/MonthRegister";

$route["RegionRegister"] = "Home/RegionRegister";

$route["purchasedProducts"] = "Home/purchasedProducts";

$route["purchasedProducts/(:num)"] = "Home/purchasedProducts/$1";

$route["viewedProducts"] = "Home/viewedProducts";

$route["viewedProducts/(:num)"] = "Home/viewedProducts/$1";

$route["viewedCategory"] = "Home/viewedCategory";

$route["searchProducts"] = "Home/searchProducts";

$route["searchProducts/(:num)"] = "Home/searchProducts/$1";

$route["purchasedCategory"] = "Home/purchasedCategory";


$route["membershopping"] = "Home/membershopping";

$route["membershopping/(:num)"] = "Home/membershopping/$1";


$route["memberBuy"] = "Home/memberBuy";

$route["memberBuy/(:num)"] = "Home/memberBuy/$1";

$route["daySite"] = "Home/daySite";

$route["monthSite"] = "Home/monthSite";

$route["weekSite"] = "Home/weekSite";

$route["regionvisitlog"] = "Home/regionvisitlog";

$route["regionvisitlog/(:num)"] = "Home/regionvisitlog/$1";


$route["getStrange"] = "Home/getStrange";

$route["getStrange/(:num)"] = "Home/getStrange/$1";

$route["backup"] = "Home/backup";