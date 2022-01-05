<?php

$name = '';
$cid ='';
$brand = '';
$eg_name = '';
$wonsanji = '';
$singo = '';
$orgprice = 0;
$addprice = 0;
$point = 0;
$weight = 0;
$count = '';
$use = 1;
$hot = 1;
$new = 1;
$sold= 1;
$i1=$i2=$i3=$i4=$i5=$i6="/upload/noimage.jpeg";
$details1=$details2=$details3=$details4=$details5="";
$description  = '';
$id = '';
$color = '';
$size = '';
$end_date = '';
$ch = isset($ch) ? $ch:"";
$shop_id ="";
$pcode = "";
$c_items = "";
$p_wowview="";
$p_newview="";
$p_saleview="";
$p_bestview="";
$p_icon = array();
$p_commission_type ="";
$p_sPersent = "";
$p_sPrice = 0;
$p_naver_switch = "";
$p_daum_switch = "";
$p_salecnt = 0;
$p_delivery_info = "";
$p_idx = 1;
$p_shoppingPay_use = 0;
$p_shoppingPay = 0;
$p_hashtag = "";
$deliverybysea = 0;
$deliverybysky = 0;
$best_big = "";
$best_small = "";
if(!empty($product))
{
    foreach ($product as $uf)
    {
        $cid = $uf->category;
        $name = $uf->name;
        $brand = $uf->brand;
        $eg_name = $uf->eg_name;
        $wonsanji = $uf->wonsanji;
        $singo = $uf->singo;
        $orgprice = $uf->orgprice;
        $addprice = $uf->addprice;
        $point = $uf->point;
        $weight = $uf->weight;
        $count  = $uf->count;
        $i1 = $uf->i1!="" ? "/upload/shoppingmal/".$uf->id."/".$uf->i1:"/upload/noimage.jpeg";
        $i2 = $uf->i2!="" ? "/upload/shoppingmal/".$uf->id."/".$uf->i2:"/upload/noimage.jpeg";
        $i3 = $uf->i3!="" ? "/upload/shoppingmal/".$uf->id."/".$uf->i3:"/upload/noimage.jpeg";
        $i4 = $uf->i4!="" ? "/upload/shoppingmal/".$uf->id."/".$uf->i4:"/upload/noimage.jpeg";
        $i5 = $uf->i5!="" ? "/upload/shoppingmal/".$uf->id."/".$uf->i5:"/upload/noimage.jpeg";
        $i6 = $uf->image!="" ? "/upload/shoppingmal/".$uf->id."/".$uf->image:"/upload/noimage.jpeg";
        $details1 = $uf->details1!="" ? "/upload/shoppingmal/".$uf->id."/".$uf->details1:"/upload/noimage.jpeg";
        $details2 = $uf->details2!="" ? "/upload/shoppingmal/".$uf->id."/".$uf->details2:"/upload/noimage.jpeg";
        $details3 = $uf->details3!="" ? "/upload/shoppingmal/".$uf->id."/".$uf->details3:"/upload/noimage.jpeg";
        $details4 = $uf->details4!="" ? "/upload/shoppingmal/".$uf->id."/".$uf->details4:"/upload/noimage.jpeg";
        $details5 = $uf->details5!="" ? "/upload/shoppingmal/".$uf->id."/".$uf->details5:"/upload/noimage.jpeg";
        $use = $uf->use;
        $sold = $uf->sold;
        $hot = $uf->hot;
        $new = $uf->new;
        $description = $uf->description;
        $id = $uf->id;
        $color = $uf->color;
        $size = $uf->size;
        $end_date = $uf->end_date;
        $shop_id = $uf->shop_category;
        $pcode = empty($uf->rid) ? generateRandomString(10)  : $uf->rid;
        $c_items = $uf->c_items;
        $p_wowview= $uf->p_wowview;
        $p_newview= $uf->p_newview;
        $p_saleview= $uf->p_saleview;
        $p_bestview= $uf->p_bestview;
        $p_commission_type = $uf->p_commission_type;
        $p_sPersent = $uf->p_sPersent;
        $p_sPrice = $uf->p_sPrice;
        $p_naver_switch = $uf->p_naver_switch;
        $p_daum_switch = $uf->p_daum_switch;
        $p_salecnt = $uf->p_salecnt;
        $p_delivery_info = $uf->p_delivery_info;
        $p_idx = $uf->p_idx;
        $p_shoppingPay_use = $uf->p_shoppingpay_use;
        $p_shoppingPay=  $uf->p_shoppingPay;
        $p_hashtag = $uf->p_hashtag;
        $deliverybysea = $uf->deliverybysea;
        $deliverybysky = $uf->deliverybysky;
        $best_big = $uf->best_big;
        $best_small = $uf->best_small;
        if(!empty($uf->p_icon))
        {
            $p_icon = explode(",", $uf->p_icon);
        }
    }
}

$pcode = empty($pcode) ? generateRandomString(10)  : $pcode;

?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        상품 정보 (상품 코드 : <?=$pcode?>)
      </h1>
    </section>
    <section class="content">
        <div class="row">
            <!-- left column -->
            <div class="col-md-10">
              <!-- general form elements -->
                <div class="box box-primary">
                    <?php echo form_open_multipart('registerShop');?>
                    <table class="table table-bordered">
                        <colgroup>
                            <col width="200px">
                        </colgroup>
                        <tbody class="adding_td adding_th">
                            <tr>
                                <th>노출여부</th>
                                <td>
                                    <input type="radio" name="use" id="use" value="1"  <?php if($use ==1) echo "checked"; ?>>
                                    <label>노츨</label>
                                    <input type="radio" name="use" id="use" value="0"  <?php if($use ==0) echo "checked"; ?>>
                                    <label>숨김</label>
                                </td>
                            </tr>
                            <tr>
                                <th>베스트상품</th>
                                <td>
                                    <input type="radio" name="p_bestview" id="p_bestview" value="1"  
                                    <?php if($p_bestview==1) echo "checked"; ?>>
                                    <label>노츨</label>
                                    <input type="radio" name="p_bestview" id="p_bestview" value="0"  
                                    <?php if($p_bestview==0) echo "checked"; ?>>
                                    <label>숨김</label>
                                </td>
                            </tr>
                            <tr>
                                <th>신규상품</th>
                                <td>
                                    <input type="radio" name="p_newview" id="p_newview" value="1"  <?php if($p_newview ==1) echo "checked"; ?>>
                                    <label>노츨</label>
                                    <input type="radio" name="p_newview" id="p_newview" value="0"  <?php if($p_newview ==0) echo "checked"; ?>>
                                    <label>숨김</label>
                                </td>
                            </tr>
                            <tr>
                                <th>멋진 상품</th>
                                <td>
                                    <input type="radio" name="p_wowview" id="p_wowview" value="1"  <?php if($p_wowview ==1) echo "checked"; ?>>
                                    <label>노츨</label>
                                    <input type="radio" name="p_wowview" id="p_wowview" value="0"  <?php if($p_wowview ==0) echo "checked"; ?>>
                                    <label>숨김</label>
                                </td>
                            </tr>
                            <tr>
                                <th>추천상품</th>
                                <td>
                                    <input type="radio" name="p_saleview" id="p_saleview" value="1"  <?php if($p_saleview ==1) echo "checked"; ?>>
                                    <label>노츨</label>
                                    <input type="radio" name="p_saleview" id="p_saleview" value="0"  <?php if($p_saleview ==0) echo "checked"; ?>>
                                    <label>숨김</label>
                                </td>
                            </tr>
                            <tr>
                                <th>상품아이콘</th>
                                <td>
                                    <div>
                                        <?php if(!empty($p_icons)): ?>
                                        <?php foreach($p_icons as $value): ?>
                                        <input type="checkbox" name="p_icon[]" value="<?=$value->id?>" <?=in_array($value->id,$p_icon) ? "checked":""?>>
                                        <img src="/upload/Products/icon/<?=$value->icon?>">
                                        <?php endforeach; ?>
                                        <?php endif;?>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th>베스트제목</th>
                                <td>
                                   <input type="text" class="form-control" id="best_big" name="best_big"  
                                    value="<?=$best_big?>"  maxlength="200" style="width: 300px">
                                </td>
                            </tr>
                            <tr>
                                <th>베스트부제목</th>
                                <td>
                                    <input type="text" class="form-control" id="best_small" name="best_small"  
                                    value="<?=$best_small?>"  maxlength="200" style="width: 300px">
                                </td>
                            </tr>
                            <tr>
                                <th>업체정산형태</th>
                                <td>
                                    <div>
                                        <span class="multi">
                                            <input type="radio" id="_commission_type1" name="p_commission_type" value="1" 
                                            <?=$p_commission_type ==1 ? "checked":""?>>
                                            <label for="_commission_type1"> 공급가</label>
                                        </span>
                                        <span class="multi">
                                            <input type="radio" id="_commission_type2" name="p_commission_type" value="2" 
                                            <?=$p_commission_type ==2 ? "checked":""?>>
                                            <label for="_commission_type2"> 수수료</label>
                                        </span>
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        <!-- 공급가 선택 시 노출 -->
                                        <span id="comSaleTypeTr1" style="<?=$p_commission_type ==1 ? "display: initial;":"display:none"?>">
                                            매입가격 (공급가격) : <input type="txt" name="p_sPrice" class="input_txt" size="10" 
                                            style="text-align:right;" value="<?=$p_sPrice?>"> 원
                                        </span>

                                        <!-- 수수료 선택 시 노출 -->
                                        <span id="comSaleTypeTr2" style="<?=$p_commission_type ==2 ? "display: initial;":"display:none"?>">
                                            수수료 : <input type="text" name="p_sPersent" class="input_txt" size="3" style="text-align:right;" 
                                            value="<?=$p_sPersent?>"> %
                                        </span>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th>배송시 상품카테고리</th>
                                <td>
                                    <div class="form-group">
                                        <div class="pull-left" style="width: 300px">
                                            <select id="head_cat" class="form-control">
                                                <?php foreach($category as $value): ?>
                                                    <option value="<?=$value->id?>" <?=$ch==$value->id ? "selected":""?> eng="<?=$value->en_subject?>">
                                                        <?=$value->name?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                        <div class="pull-left" style="width: 300px">
                                            <select id="category" name="category" required class="form-control">
                                                <option>Select Category</option>
                                                <?php if(!empty($categorys)): ?>
                                                    <?php foreach($categorys as $value): ?>
                                                        <option value="<?=$value->name?>" eng="<?=$value->en_subject?>" 
                                                            <?php if($cid==$value->name) echo 'selected'; ?>>
                                                            <?=$value->name?></option>
                                                    <?php endforeach; ?>
                                                <?php endif; ?>
                                            </select>
                                        </div>
                                        <div class="pull-left">
                                            <input type="text" class="required form-control" id="eg_name" name="eg_name" 
                                             value="<?=$eg_name?>" required>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th class="mid">상품분류<br>
                                    <font style="background-color: blue;font-size: 12px;color: #fff">상품등록후 "선택카테고리추가"를 선택해주세요</font>
                                </th>
                                <td class="mid">
                                    <div class="row">
                                        <div class="col-xs-6">
                                            <div class="row">
                                                <div class="col-xs-4 p-right-2">
                                                    <select id="p_category1" class="form-control category_select" name="p_category1" data-step="1">
                                                        <option value="">=== 선택 ===</option>
                                                        <?php if(!empty($left_category)): ?>
                                                        <?php foreach($left_category as $value): ?>
                                                        <option value="<?=$value->id?>"><?=$value->name?></option>
                                                        <?php endforeach;?>
                                                        <?php endif; ?>
                                                    </select>
                                                </div>
                                                <div class="col-xs-4  p-left-2 p-right-2">
                                                    <select id="p_category2" class="form-control category_select" name="p_category2" data-step="2">
                                                        <option value="">2차 카테고리</option>
                                                    </select>
                                                </div>
                                                <div class="col-xs-4  p-left-2 p-right-2">
                                                    <select id="p_category3" class="form-control category_select" name="p_category3" data-step="3">
                                                        <option value="">3차 카테고리</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-3 p-left-2 p-right-2">
                                            <a href="javascript:c_items()"  class="btn-default btn btn-block" >선택 카테고리 추가</a>
                                        </div>
                                    </div>
                                    <div class="row my-4">
                                        <div class="col-xs-6 category_items">
                                            <?php $multi = getShopAllagories($pcode,"","pcode"); ?>
                                            <?php if(!empty($multi)): ?>
                                            <?php foreach($multi  as $key_multi => $multi_item): ?>
                                            <?php $multi_item = array_reverse($multi_item); ?>
                                            <nav aria-label="breadcrumb" id="bread_<?=$key_multi?>">                            
                                                <ol class="breadcrumb" style="position:relative">
                                                    <?php foreach($multi_item as $multi_value): ?>
                                                        <li class="breadcrumb-item "><?=$multi_value?></li>  
                                                    <?php endforeach; ?>                                               
                                                    <li class="breadcrumb-item  last-item">
                                                        <a href="javascript:c_del(<?=$key_multi?>)" class="btn btn-danger">삭제</a>
                                                    </li>
                                                </ol>
                                            </nav>
                                            <?php endforeach; ?>
                                            <?php endif; ?>
                                        </div>   
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th>타오달인 카테고리</th>
                                <td>
                                    <select id="shop_category" name="shop_category">
                                        <option value="">카테고리 없음</option>
                                        <?php foreach($shop_category as $shop_value): ?>
                                            <option value="<?=$shop_value->id?>" <?=$shop_id==$shop_value->id ? "selected":""?>>
                                                <?=$shop_value->name?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <th>연관상품분류</th>
                                <td>
                                    <div class="form-group">
                                        <a href='javascript:fnPopWinCT("<?=base_url()?>/multi_categories?pcode=<?=$pcode?>", "옵션 관리", 1064, 800, "Y")' class="btn btn-warning btn-sm">등록하기</a>
                                         선택된 카테고리 : 
                                        <button class="btn btn-default selectedCategory" disabled=""><?=$selected_name?></button> 
                                        <a href="javascript:deletesecCate()" style="color: red">삭제</a>
                                        <input type="hidden" name="selected_cateogry"  value="<?=$selected_id?>" id="selected_cateogry">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th>네이버EP</th>
                                <td>
                                    <div class="form-group">
                                        <span class="multi">
                                            <input type="radio" id="p_naver_switchY" name="p_naver_switch" value="1" 
                                            <?=$p_naver_switch ==1 ? "checked":""?>>
                                            <label for="p_naver_switchY"> 적용</label>
                                        </span>
                                        <span class="multi">
                                            <input type="radio" id="p_naver_switchN" name="p_naver_switch" value="0" c
                                            <?=$p_naver_switch ==0 ? "checked":""?>>
                                            <label for="p_naver_switchN"> 미적용</label>
                                        </span>                     
                                        <div class="guide_text"><span class="ic_blue"></span><span class="blue">상품에 대한 지식 쇼핑 노출여부를 설정할 수 있습니다.</span></div>
                                        <div class="guide_text">
                                            <span class="ic_blue"></span>
                                            <span class="blue">네이버 지식 쇼핑 노출은 전체설정(환경설정 &gt; 기본설정 &gt; 네이버 EP), 상품개별설정에서 모두 적용되어야 노출됩니다.</span>
                                        </div>
                                        <div class="guide_text">
                                            <span class="ic_blue"></span>
                                            <span class="blue">전체상품업데이트는 매일 21시 ~ 24시 사이 갱신됩니다. - 전체상품 EP URL : <b>http://simbongsa.co.kr/include/addons/ep/naver/all.txt</b></span>
                                        </div>
                                        <div class="guide_text">
                                            <span class="ic_blue"></span>
                                            <span class="blue">요약상품업데이트는 매일 08:30 ~ 20:30 사이, 한시간마다 갱신됩니다. - 요약상품 EP URL : <b>http://simbongsa.co.kr/include/addons/ep/naver/brief.txt</b></span>
                                        </div>
                                        <div class="guide_text">
                                            <span class="ic_orange"></span>
                                            <span class="orange">전체EP는 요약EP 가 끝나는 시점에서 생성 되도록  지식쇼핑 관리자 내에서 시간설정을 맞춰 주어야만  정상적으로 상품 노출이 가능합니다.</span>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th>다음 EP</th>
                                <td>
                                    <div class="form-group">
                                        <span class="multi"><input type="radio" id="p_daum_switchY" name="p_daum_switch" value="1" 
                                            <?=$p_daum_switch ==1 ? "checked":""?> />
                                            <label for="p_daum_switchY"> 적용</label></span>
                                        <span class="multi"><input type="radio" id="p_daum_switchN" name="p_daum_switch" value="0"  
                                            <?=$p_daum_switch ==0 ? "checked":""?> />
                                            <label for="p_daum_switchN"> 미적용</label></span>
                                        <div class="guide_text"><span class="ic_blue"></span><span class="blue">상품에 대한 다음 EP 노출여부를 설정할 수 있습니다.</span></div>
                                        <div class="guide_text"><span class="ic_blue"></span><span class="blue">다음 하우 쇼핑 노출은 전체설정(환경설정 &gt; 기본설정 &gt; 다음 EP), 상품개별설정에서 모두 적용되어야 노출됩니다.</span></div>
                                        <div class="guide_text">
                                            <span class="ic_blue"></span>
                                            <span class="blue">전체상품업데이트는 매일 21시 ~ 24시 사이 갱신됩니다. - 전체상품 EP URL : <b>http://simbongsa.co.kr/include/addons/ep/daum/all.txt</b></span>
                                        </div>
                                        <div class="guide_text">
                                            <span class="ic_blue"></span>
                                            <span class="blue">요약상품업데이트는 매일 08:30 ~ 20:30 사이, 한시간마다 갱신됩니다. - 요약상품 EP URL : <b>http://simbongsa.co.kr/include/addons/ep/daum/brief.txt</b></span>
                                        </div>
                                        <div class="guide_text">
                                            <span class="ic_orange"></span>
                                            <span class="orange">전체EP는 요약EP 가 끝나는 시점에서 생성 되도록 하우쇼핑 관리자 내에서 시간설정을 맞춰 주어야만 정상적으로 상품 노출이 가능합니다.</span>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th>상품명</th>
                                <td>
                                    <input type="text" class="required form-control" id="name" name="name"  
                                    value="<?=$name?>" required maxlength="200" >
                                    <input type="hidden" name="id" value="<?=$id?>" id="id">
                                </td>
                            </tr>

                            <tr>
                                <th>상품가격</th>
                                <td>
                                    <div class="my-3 ">*기존가격 <input type="text" class="required" id="orgprice"  
                                    name="orgprice" maxlength="10"  value="<?=$orgprice?>" required style="width:70px">원</div>
                                    <div>
                                        *할인판매가 <input type="text" class="required" id="singo"  name="singo" maxlength="128" 
                                        value="<?=$singo?>" required style="width:70px">원 (싱글)
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th class="mid">상품설정</th>
                                <td class="mid">
                                    <div class="line">* 재고량 
                                        <input type="text" id="count"  name="count" value="<?=$count?>" style="width:70px">
                                        <div class="guide_text">
                                            <span class="ic_blue"></span>
                                            <span class="blue">옵션 상품의 경우 각 옵션의 재고량 합산값을 입력하세요.</span>
                                        </div>
                                    </div>
                                    <div class="line">
                                        *상품순위 <input type="text" id="p_idx"  name="p_idx"  value="<?=$p_idx?>" style="width:70px">
                                    </div>
                                    <div class="line">
                                        *판매량 <input type="text" id="p_salecnt"  name="p_salecnt"  value="<?=$p_salecnt?>" style="width:70px">
                                    </div>
                                    <div class="line">
                                        * 원산지 <input type="text"  id="wonsanji"  name="wonsanji" maxlength="128" value="<?=$wonsanji?>" required>
                                    </div>
                                    <div class="line">
                                        * 제조사 <input type="text"  id="brand"  name="brand" maxlength="128" value="<?=$brand?>" required>
                                    </div>
                                    <div class="line">
                                        *적립포인트 <input type="text" class="required" id="point"  name="point" maxlength="128" value="<?=$point?>" required style="width:70px">
                                        <div class="guide_text">
                                            <span class="ic_blue"></span>
                                            <span class="blue">상품구매시 상품가격당 해당 포인트값으로 적용됩니다.</span>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th>배송정보</th>
                                <td>
                                    <input type="text" class="required" id="p_delivery_info"  
                                    name="p_delivery_info"  value="<?=$p_delivery_info?>">
                                    <div class="guide_text">
                                            <span class="ic_blue"></span>
                                            <span class="blue">예:로젠택배 (2~3일 소요)</span>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th class="mid">배송비 설정</th>
                                <td class="mid">
                                    <div class="line">
                                        <label><input type="radio" name="p_shoppingPay_use" class="p_shoppingPay_use" value="0" 
                                           <?=$p_shoppingPay_use ==0 ? "checked":""?> /> 쇼핑몰 배송비 정책을 따릅니다.</label>
                                        <div id="p_shoppingPay_use_N" style="<?=$p_shoppingPay_use !=0 ? "display: none":"";?>">
                                            <div style="clear: both;">
                                                <div class="guide_text">
                                                    <span class="ic_blue"></span><span class="blue"><b style="cursor: pointer;" onclick="entershop_view()">[쇼핑몰 배송비 확인하기]</b></span>
                                                </div>
                                                <div class="guide_text"><span class="ic_blue"></span><span class="blue">장바구니에 담긴 총금액을 기준으로 무료배송비가 적용됩니다.</span></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="line">
                                        <label><input type="radio" name="p_shoppingPay_use" class="p_shoppingPay_use" value="1" 
                                            <?=$p_shoppingPay_use ==1 ? "checked":""?>/> 상품 개별 배송비를 적용합니다.</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        <span id="p_shoppingPay_use_Y" style="<?=$p_shoppingPay_use !=1 ? "display: none":"";?>">
                                            배송비 : 
                                            해운특송(5~7일) <input type="checkbox" name="deliverybysea" value="1" 
                                            <?=$deliverybysea ==1 ? "checked":""?>/> 
                                            &nbsp;&nbsp;&nbsp;&nbsp;
                                            항공특송(3~5일) <input type="checkbox" name="deliverybysky" value="1" 
                                            <?=$deliverybysky ==1 ? "checked":""?>/>
                                            &nbsp;&nbsp;&nbsp;&nbsp;  
                                            상품무게 &nbsp;&nbsp;<input type="text" class="required" id="weight"  
                                                        name="weight" maxlength="128" value="<?=$weight?>">
                                        </span>     
                                    </div>

                                    <div class="line">
                                        <label><input type="radio" name="p_shoppingPay_use" class="p_shoppingPay_use" value="2" 
                                            <?=$p_shoppingPay_use ==2 ? "checked":""?>/> 무료배송으로 설정합니다.</label>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th class="mid">상품옵션</th>
                                <td class="mid">
                                    <div class="form-group">
                                        <span class="shop_btn_pack" style="margin-right: 10px;">
                                            <a href='javascript:fnPopWinCT("<?=base_url()?>product_option?pcode=<?=$pcode?>", "옵션 관리", 1064, 500, "Y")' 
                                                class="btn btn-sm btn-primary">옵션창 열기</a></span>
                                        <div class="guide_text">
                                            <span class="ic_orange"></span><span class="orange">주문 내역이 있는 상품의 옵션은 변경하지 마시기 바랍니다.</span></div>
                                        <span class="shop_btn_pack" style="margin-right: 10px;">
                                            <a href='javascript:fnPopWinCT("<?=base_url()?>product_option?pcode=<?=$pcode?>&pass_mode=second", "옵션 관리", 1064, 500, "Y")'  class="btn btn-sm btn-primary">추가옵션창 열기</a></span>
                                        <div class="guide_text"><span class="ic_orange"></span><span class="orange">주문 내역이 있는 상품의 옵션은 변경하지 마시기 바랍니다.</span></div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th>정보제공공시</th>
                                <td></td>
                            </tr>
                            <tr>
                                <th>해시태그 지정</th>
                                <td>
                                    <div class="form-group">
                                       <textarea name="p_hashtag" class="form-control"><?=$p_hashtag?></textarea>
                                       <div class="guide_text">
                                        <span class="ic_blue"></span>
                                        <span class="blue">입력 예: 해시태그1,해시태그2,해시태그3 (해시태그의 구분을 콤마(,) 로 하시기 바랍니다.)</span></div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th>상품설명</th>
                                <td>
                                    <textarea class="form-control" id="editor3" geditor name="description"><?=!empty($description) ? stripslashes($description):""?></textarea>
                                </td>
                            </tr>
                            <tr>
                                <th class="mid">상품이미지(284*284)</th>
                                <td>
                                    <div class="form-group">
                                        <?php if (strpos($i6, 'upload/shoppingmal') != true): ?>
                                        <input type="file" class="form-control" id="image"  name="image" onchange="previewFile(this,6)">
                                        <?php endif; ?>
                                        <?php if (strpos($i6, 'upload/shoppingmal') != false): ?>
                                        <a class="text-danger btn-block" href="javascript:void(0)" 
                                           onclick="deleteFile('<?=$product[0]->image?>',<?=$id?>,'image',this)"><?=$i6?> 삭제</a>
                                        <?php endif; ?>
                                    </div>
                                    <div class="my-4">
                                        <img src="<?=$i6?>" width="200" height="200" id="img6">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th>상품이미지(확대이미지) 1</th>
                                <td>
                                    <?php if (strpos($i1, 'upload/shoppingmal') != true): ?>
                                    <input type="file" class="form-control" id="i1"  name="i1" onchange="previewFile(this,1)">
                                    <?php endif; ?>
                                    <?php if (strpos($i1, 'upload/shoppingmal') != false): ?>
                                    <a class="text-danger btn-block" href="javascript:void(0)" 
                                       onclick="deleteFile('<?=$product[0]->i1?>',<?=$id?>,'i1',this)"><?=$product[0]->i1?> 삭제</a>
                                    <?php endif; ?>
                                    <img src="<?=$i1?>" id="img1" width="300">
                                </td>
                            </tr>
                            <tr>
                                <th>상품이미지(확대이미지) 2</th>
                                <td>
                                    <?php if (strpos($i2, 'upload/shoppingmal') != true): ?>
                                    <input type="file" class="form-control" id="i2"  name="i2" onchange="previewFile(this,2)">
                                    <?php endif; ?>
                                    <?php if (strpos($i2, 'upload/shoppingmal') != false): ?>
                                    <a class="text-danger btn-block" href="javascript:void(0)" 
                                       onclick="deleteFile('<?=$product[0]->i2?>',<?=$id?>,'i2',this)"><?=$product[0]->i1?> 삭제</a>
                                    <?php endif; ?>
                                    <img src="<?=$i2?>" id="img2" width="300">
                                </td>
                            </tr>
                            <tr>
                                <th>상품이미지(확대이미지) 3</th>
                                <td>
                                    <?php if (strpos($i3, 'upload/shoppingmal') != true): ?>
                                    <input type="file" class="form-control" id="i3"  name="i3" onchange="previewFile(this,3)">
                                    <?php endif; ?>
                                    <?php if (strpos($i3, 'upload/shoppingmal') != false): ?>
                                    <a class="text-danger btn-block" href="javascript:void(0)" 
                                       onclick="deleteFile('<?=$product[0]->i3?>',<?=$id?>,'i3',this)"><?=$product[0]->i3?> 삭제</a>
                                    <?php endif; ?>
                                    <img src="<?=$i3?>" id="img3" width="300">
                            </tr>
                            <tr>
                                <th>상품이미지(확대이미지) 4</th>
                                <td>
                                    <?php if (strpos($i4, 'upload/shoppingmal') != true): ?>
                                    <input type="file" class="form-control" id="i4"  name="i4" onchange="previewFile(this,4)">
                                    <?php endif; ?>
                                    <?php if (strpos($i4, 'upload/shoppingmal') != false): ?>
                                    <a class="text-danger btn-block" href="javascript:void(0)" 
                                       onclick="deleteFile('<?=$product[0]->i4?>',<?=$id?>,'i4',this)"><?=$product[0]->i4?> 삭제</a>
                                    <?php endif; ?>
                                    <img src="<?=$i4?>" id="img4" width="300">
                                </td>
                            </tr>
                            <tr>
                                <th>상품이미지(확대이미지) 5</th>
                                <td>
                                    <?php if (strpos($i5, 'upload/shoppingmal') != true): ?>
                                    <input type="file" class="form-control" id="i5"  name="i5" onchange="previewFile(this,5)">
                                    <?php endif; ?>
                                    <?php if (strpos($i5, 'upload/shoppingmal') != false): ?>
                                    <a class="text-danger btn-block" href="javascript:void(0)" 
                                       onclick="deleteFile('<?=$product[0]->i5?>',<?=$id?>,'i5',this)"><?=$product[0]->i5?> 삭제</a>
                                    <?php endif; ?>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <img src="<?=$i5?>" id="img5" width="300">
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <input type="hidden" class="form-control" id="rid"  name="rid" value="<?=$pcode?>" >
                    <input type="hidden" name="c_items" id="category_items">
                    <div class="box-footer">
                        <input type="submit" class="btn btn-primary" value="저장" />
                        <input type="reset" class="btn btn-default" value="취소" />
                    </div>
                    </form>
                </div>
            </div>
        </div>    
    </section>
</div>
<link href="<?php echo base_url(); ?>assets/dist/css/editor.css" rel="stylesheet" type="text/css" />
<script src="<?php echo base_url(); ?>assets/dist/tinymce/tinymce.min.js"></script>
<script>
var items = <?php if(empty($c_items)): ?>new Array();<?php endif; ?><?php if(!empty($c_items)): ?>JSON.parse('<?=$c_items?>');<?php endif; ?>
var ro;
// initSample();
var comm_type_check = function() {
    if($("input[name=p_commission_type]:checked").val() == "1") {
        $("#comSaleTypeTr1").show();
        $("#comSaleTypeTr2").hide();
    } else {
        $("#comSaleTypeTr1").hide();
        $("#comSaleTypeTr2").show();
    }
}
$("input[name=p_commission_type]").click(comm_type_check);
var delivery_setting = function() {
    
    if($(".p_shoppingPay_use:checked").val() == "1") {
        $("#p_shoppingPay_use_Y").show();
        $("#p_shoppingPay_use_N").hide();
    } else if($(".p_shoppingPay_use:checked").val() == "0") {
        $("#weight").val(0);
        $("#p_shoppingPay_use_Y").hide();
        $("#p_shoppingPay_use_N").show();
    } else {
        $("#weight").val(0);
        $("#p_shoppingPay_use_Y").hide();
        $("#p_shoppingPay_use_N").hide();
    }

}

$(".p_shoppingPay_use").click(delivery_setting);
function previewFile(iss,id,type=1) {

    var img = "img";
    if(type != 1 )
        img="details";
    var file  = iss.files[0];
    var reader  = new FileReader();
    reader.onloadend = function () {
        $("#"+img+id).attr("src",reader.result);
    }

    if (file) {
        reader.readAsDataURL(file);
    } else {
        $("#"+img+id).attr("src","");
    }
}

function fnSaleRateCal(){
    var p = parseInt($('#orgprice').val())+parseInt($("#addprice").val());
    $("#oprice").val(p);
}

$('#head_cat').on('change', function() {
    var hitURL = baseURL + "getCateogory";
    var id = $(this).val();
  jQuery.ajax({
    type : "POST",
    dataType : "json",
    url : hitURL,
    data : { id : id } 
    }).done(function(data){
        $('#category').html("");

        $('#category').append("<option value='' eng=''>카테고리를 선택해주세요</option>");   
         $.each(data, function(key,val) {             
           $('#category').append("<option value='"+val.name+"' eng='"+val.en_subject+"'>"+val.name+"</option>");
   
        });  
    })
});




$('#category').change(function(){
    if($('#category option:selected').attr('eng') != undefined && $('#category option:selected').attr('eng').trim() != "" )
        $("#eg_name").val($('#category option:selected').attr('eng'));
})

function deleteFile(url,id,type,obj){
    var $this=$(obj);
    var message = confirm("이 첨부파일을 삭제하시겠습니까?");
    var hitURL = baseURL + "deleteProductImage";
    if(message){
        jQuery.ajax({
        type : "POST",
        dataType : "json",
        url : hitURL,
        data : { id : id,url:url,type:type } ,
        }).done(function(data){
            if(data.status ==0)
            {
                
                alert("이미지가 존재하지 않거나 삭제권한이 없습니다.");
                return;
            }
            if(data.status ==null)
            {
                alert("서버오류");
                return;
            }
            else{
                location.reload();
            }  
        }).fail(function (jqXHR, textStatus, errorThrown) { 
            location.reload();
        }); 
    }
}

$(".category_select").change(function() {
      if($(this).data("step") !=3)
      {
        var temp = $(this).data("step")+1;
        if(temp ==2)
        {
          $("#p_category3").html("");
          $("#p_category3").append( new Option("선택",""));
        }
        if($(this).val().trim() ==""){
          $("#p_category"+temp).html("");
          $("#p_category"+temp).append( new Option("선택","") );
          return;
        }
        jQuery.ajax({
          type : "POST",
          dataType : "json",
          url : baseURL+"getshopcategory",
          data : { id : $(this).val(),type:"list"  } 
          }).done(function(data){

            $("#p_category"+temp).html("");
            $("#p_category"+temp).append( new Option("선택","") );
            if(data.result.length > 0)
              $.each(data.result,function(index,value){
                $("#p_category"+temp).append( new Option(value.name,value.id) );
              })
          });
        }
  });

    function c_items(){
        var c1="",c2="",c3="",class1="",class2="",class3="";
        c3 = $("#p_category3 option:selected").text();
        c2 = $("#p_category2 option:selected").text();
        c1 = $("#p_category1 option:selected").text();

        c1 = c1=="선택" ? "":c1;
        c2 = c2=="선택" ? "":c2;
        c3 = c3=="선택" ? "":c3;
        

        if(c3.trim() !=""){
            class1 = class2="";
            class3 = "active";
        }
        if(c3.trim() =="" && c2.trim()!=""){
            class1 = class3="";
            class2 = "active";
        }

        if(c1.trim() !="" && c2.trim() ==""){
            class2 = class3="";
            class1 = "active";
        }

        var number = 0;
        if($("#p_category3").val().trim() != "")
            number = $("#p_category3").val();
        else if($("#p_category2").val().trim() != "")
            number = $("#p_category2").val();
        else
            number = $("#p_category1").val();
        if(!items.includes(number) && number > 0)
        {
            items.push(number);
            var bread = '   <nav aria-label="breadcrumb" id="bread_'+number+'">\
                            <ol class="breadcrumb" style="position:relative">\
                            <li class="breadcrumb-item '+class1+'"><a class="white-text" href="#">'+c1+'</a></li>\
                            <li class="breadcrumb-item '+class2+'"><a class="white-text" href="#">'+c2+'</a></li>\
                            <li class="breadcrumb-item '+class3+'">'+c3+'</li>\
                            <li class="breadcrumb-item  last-item"><a  href="javascript:c_del('+number+')" class="btn btn-danger">삭제</a></li></ol></nav>';
            

            jQuery.ajax({
              type : "POST",
              dataType : "json",
              url : baseURL+"setCategoryShop",
              data : { pcode :"<?=$pcode?>" , category:number ,type : "add" } 
              }).done(function(data){
                $(".category_items").append(bread);
                $("#c_items").val(JSON.stringify(items));
            });
        }
    }

    function c_del(id){
        var index = items.indexOf(id);
        jQuery.ajax({
          type : "POST",
          dataType : "json",
          url : baseURL+"setCategoryShop",
          data : { pcode :"<?=$pcode?>" , category:id ,type : "delete" } 
          }).done(function(data){
            items.splice(index, 1);
            $("#bread_"+id).remove();
            $("#c_items").val(JSON.stringify(items));
        });
    }

    function disableF5() {  // IE
        document.onkeydown = function() {
            if (window.event && window.event.keyCode == 116) { // Capture and remap F5
                window.event.keyCode = 505;
            }
            if (window.event && window.event.keyCode == 505) { // New action for F5
            return false; // Must return false or the browser will refresh anyway
            }
        }
    }
    function disableF5v2() { // FIREFOX
        $(this).keypress(function(e) {
            if (e.keyCode == 116) {
                e.preventDefault();
        return false;
            }
        });
    }
    function entershop_view() {
        window.open('<?=base_url()?>config_delivery');
    }

    function updateRealtedCategory(id,name){
        $("#selected_cateogry").val(id);
        $(".selectedCategory").text(name);
    }

    function deletesecCate(){
        $("#selected_cateogry").val(-1);
        $(".selectedCategory").text("");
    }
    tinymce.init({
        selector: "textarea[geditor]",
        theme: "modern",
        language : 'ko_KR',
        height: 370,
        force_br_newlines : false,
        force_p_newlines : true,
        convert_newlines_to_brs : false,
        remove_linebreaks : true,
        forced_root_block : 'p', // Needed for 3.x
                relative_urls:true,
        allow_script_urls: true,
        remove_script_host: true,
            //convert_urls: false,
        formats: { bold : {inline : 'b' }},
        extended_valid_elements: "@[class|id|width|height|alt|href|style|rel|cellspacing|cellpadding|border|src|name|title|type|onclick|onfocus|onblur|target],b,i,em,strong,a,img,br,h1,h2,h3,h4,h5,h6,div,table,tr,td,s,del,u,p,span,article,section,header,footer,svg,blockquote,hr,ins,ul,dl,object,embed,pre",
        plugins: [
            "jbimages",
             "advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker",
             "searchreplace visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
             "save table contextmenu directionality emoticons template paste textcolor"
       ],
       content_css: "/admin/assets/dist/css/editor.css",
       body_class: "editor_content",
       menubar : false,
       toolbar1: "undo redo | fontsizeselect | advlist bold italic forecolor backcolor | charmap | hr | jbimages | autolink link media | preview | code",
       toolbar2: "bullist numlist outdent indent | alignleft aligncenter alignright alignjustify | table"
     }); 
</script>
