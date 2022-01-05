<?php
$pid = array(); 
if(empty($delivery)) return;
$fee = "";
$services_ss=array();
$services_ss = json_decode($delivery[0]->content,true);
if(!empty($ss))
   foreach ($ss as $key => $value) {
      $fee .=$key.",";
   }
?>
<script type="text/javascript">
   var aRrnCdNm = new Array(3);
   aRrnCdNm[1] = "媛쒖씤�듦�怨좎쑀踰덊샇瑜� �낅젰�� 二쇱꽭��.";
   aRrnCdNm[2] = "'-'개인통괍부호 글수는 13글자이여야 합니다.";
   aRrnCdNm[3] = "사용자등록번호는 10글자이여야 합니다..";
</script>
<div class="content-wrapper">
   <section class="content">
      <div class="row">
         <div class="col-md-12">
            <input type="hidden" id="product_val" value="">
            <form method="post" name="frmPageInfo" id="frmPageInfo" action="/admin/updateDeliver" enctype="multipart/form-data">
               <input type="hidden" name="ORD_SEQ" id="ORD_SEQ" value="<?=$delivery[0]->id?>">
               <input type="hidden" name="ORD_TY_CD" id="ORD_TY_CD" >
               <input type="hidden" name="PRO_AMT" id="PRO_AMT" >
               <input type="hidden" name="PRO_QTY" id="PRO_QTY">
               <input type="hidden" name="TempProNum" id="TempProNum" value="<?=sizeof($products)?>">
               <input type="hidden" name="theader" id="theader">
               <input type="hidden" name="CHECK" id="CHECK">
               <input type="hidden" name="pid" id="pid">
               <input type="hidden" name="deliver" value="<?=$delivery[0]->get?>">
               <input type="hidden" name="id" value="<?=$delivery[0]->id?>">
               <input type="hidden" name="fees" id="fees" value="<?=$fee?>">
               <div class="step_box">
                  <div class="orderTit">
                     <h4>배송대행 신청서</h4>
                  </div>
               </div>
               <div class="step_box">
                  <p class="orderAgreeTit">* 서비스 신청 유의사항</p>
                  <div class="order_table order_table_top">
                     <div class="orderStepTit">
                        <p>
                           <span class="stepTxt">STEP</span>
                           <span class="stepNo">01</span>
                        </p>
                        <h4>배송을 받을 물류센터를 선택해주세요.</h4>
                     </div>
                     <div class="order_table">
                        <table class="order_write" summary="센터, 배송방식 셀로 구성">
                           <colgroup>
                              <col width="15%">
                              <col width="*">
                           </colgroup>
                           <tbody>
                              <tr>
                                 <th>주문번호</th>
                                 <td><span class="bold"><?=$delivery[0]->ordernum ?></span></td>
                              </tr>
                              <tr>
                                 <td colspan="2">
                                    <div style="line-height:150%;padding-top:7px;">
                                       <ul class="rdoBox">
                                          <?php if(!empty($address)): ?>
                                          <?php foreach($address as $value): ?>
                                          <li>
                                             <label class="rdoFtBig">
                                             <input type="radio" name="CTR_SEQ" id="CTR_SEQ" rel="0" class="input_chk" value="<?=$value->id?>"
                                                <?php if($delivery[0]->Did == $value->id) echo 'checked'; ?>
                                                ><?=$value->area_name?></label>
                                          </li>
                                          <?php endforeach; ?>
                                          <?php endif; ?>
                                       </ul>
                                       <div style="padding-top:20px;">
                                          <ul class="areaMyAddrBox" style="height:40px;">
                                             <li class="areaMyAddr">
                                             </li>
                                          </ul>
                                          * 이지솔루션에서는 합 배송, 단독배송 관련 없이 하나의 신청서로 배송신청이 모두 완료됩니다.
                                       </div>
                                    </div>
                                    <p class="clrBoth"></p>
                                 </td>
                              </tr>
                           </tbody>
                        </table>
                     </div>
                     <input type="hidden" name="DLVR_TY_CD" id="DLVR_TY_CD" value="1">
                     <!-- B: 배송방식 -->
                     <div id="stepOrd-DlvrTy" style="">
                        <p class="clrBoth pHt30"></p>
                        <div class="orderStepTit">
                           <p>
                              <span class="stepTxt">STEP</span>
                              <span class="stepNo">02</span>
                           </p>
                           <h4>수입방식을 선택해주세요.</h4>
                        </div>
                        <div class="order_table">
                           <table class="order_write" summary="배송방식">
                              <colgroup>
                                 <col width="15%">
                                 <col width="*">
                              </colgroup>
                              <tbody>
                                 <tr>
                                    <td colspan="2">
                                       <div style="line-height:150%;padding:6px 0 0 0;">
                                          <ul class="rdoBox">
                                             <?php if(!empty($inMe)): ?>
                                             <?php foreach($inMe as $value): ?>
                                             <li>
                                                <label class="rdoFtBig">
                                                <input type="radio" name="REG_TY_CD" id="REG_TY_CD" rel="0" class="input_chk" value="<?=$value->id?>" <?php if($delivery[0]->Sid == $value->id) echo 'checked'; ?>> <?=$value->name?>
                                                <br>
                                                <span class="rdoFtSub"></span>
                                                </label>
                                             </li>
                                             <?php endforeach; ?>
                                             <?php endif; ?>
                                          </ul>
                                       </div>
                                    </td>
                                 </tr>
                              </tbody>
                           </table>
                        </div>
                     </div>
                     <!-- E: 금액정보 -->
                     <!--<input type="hidden" name="DLVR_TY_CD" id="DLVR_TY_CD" value="1" />
                        <input type="hidden" name="CTR_SEQ" id="CTR_SEQ" value="1" /-->
                     <p class="clrBoth pHt30"></p>
                  </div>
                  <div id="stepOrd-EtcTt" style="">
                     <div class="step_box">
                        <p class="clrBoth" id="TextBlankTab1"></p>
                        <div class="orderStepTit">
                           <p>
                              <span class="stepTxt">STEP</span>
                              <span class="stepNo">03</span>
                              <!-- 기존값은 02,03 -->
                           </p>
                           <h4>
                              받는 사람 정보를 입력해주세요.  <!--a href="javascript:fnPopMemAddr('33');" class="btn_m">[ 주소 불러오기 클릭 - 자세히 ]</a-->
                           </h4>
                        </div>
                        <div class="order_table">
                           <table class="order_write" summary="주소검색, 우편번호, 주소, 상세주소, 수취인 이름(한글), 수취인 이름(영문), 전화번호, 핸드폰번호, 용도, 주민번호, 통관번호 셀로 구성">
                              <colgroup>
                                 <col width="15%">
                                 <col width="35%">
                                 <col width="15%">
                                 <col width="35%">
                              </colgroup>
                              <tbody>
                                 <tr>
                                    <th>받는 사람</th>
                                    <td colspan="3">
                                       <div class="addrRcvKr">
                                          <ul class="RcvKrBox">
                                             <li>한글
                                                <input type="text" name="ADRS_KR" id="ADRS_KR" maxlength="60" class="input_txt2 ipt_type1" onkeyup="fnHanEng(this.value, frmPageInfo.ADRS_EN);" onblur="fnHanEng(this.value, frmPageInfo.ADRS_EN);" value="<?=$delivery[0]->billing_krname?>">
                                             </li>
                                          </ul>
                                       </div>
                                       <p class="clrBoth pHt10"></p>
                                       <div class="addrRcvEn">
                                          영문
                                          <input type="text" name="ADRS_EN" id="ADRS_EN" maxlength="60" class="input_txt2 ipt_type1" onblur="fnBuyNmAdd();" value="<?=$delivery[0]->billing_name?>">
                                       </div>
                                    </td>
                                 </tr>
                                 <tr>
                                    <th>받는 사람 정보</th>
                                    <td colspan="3">
                                       <div class="addrRcvKr">
                                          <ul class="RcvKrBox">
                                             <li class="ckBox">
                                                <label>
                                                <input type="radio" class="input_chk vm" name="RRN_CD" id="RRN_CD" value="1" <?php if($delivery[0]->person_num==1) echo 'checked'; ?>> 개인통관고유부호 (추천)</label>
                                             </li>
                                             <li class="ckBox">
                                                <label>
                                                <input type="radio" class="input_chk vm" name="RRN_CD" id="RRN_CD" value="3" <?php if($delivery[0]->person_num==3) echo 'checked'; ?>> 사업자등록번호</label>
                                             </li>
                                          </ul>
                                       </div>
                                       <div class="addrRcvEn">
                                          <ul>
                                             <li>
                                                <input type="text" name="RRN_NO" id="RRN_NO" maxlength="20" class="input_txt2 m_num" value="<?=$delivery[0]->person_unique_content?>" onfocus="fnFocusInExp( 'RRN_NO', aRrnCdNm[$('input[name=RRN_CD]:radio:checked').val()] );" onblur="fnFocusOutReg( 'RRN_NO', aRrnCdNm[$('input[name=RRN_CD]:radio:checked').val()], /[^a-zA-Z0-9]/g );">
                                             </li>
                                          </ul>
                                       </div>
                                    </td>
                                 </tr>
                                 <tr>
                                    <th>주소 및 연락처</th>
                                    <td colspan="3">
                                       <ul class="addrTel2">
                                          <li class="vm_box">
                                             <label>연락처</label>
                                             <input type="text" name="MOB_NO1" id="MOB_NO1" maxlength="4" class="input_txt2 hp" onkeypress="fnChkNumeric();" value="<?=explode("-", $delivery[0]->phone_number)[0]?>" title="전화번호 첫자리"> -
                                             <input type="text" name="MOB_NO2" id="MOB_NO2" maxlength="4" class="input_txt2 hp" onkeypress="fnChkNumeric();" value="<?=explode("-", $delivery[0]->phone_number)[1]?>" title="전화번호 중간자리"> -
                                             <input type="text" name="MOB_NO3" id="MOB_NO3" maxlength="4" class="input_txt2 hp" onkeypress="fnChkNumeric();" value="<?=explode("-", $delivery[0]->phone_number)[2]?>" title="전화번호 마지막자리">
                                          </li>
                                          <li class="vm_box">
                                             <label>우편번호</label>
                                             <input type="text" name="ZIP" id="ZIP" maxlength="8" class="input_txt2" value="<?=$delivery[0]->post_number?>" readonly="">
                                             <a href="javascript:openDaumPostcode();" style="position:relative; top:5px;" class="btn_small"><span>우편번호 검색</span></a>
                                             <!--  <a href="javascript:goPopup();" class="btn_small3 vm"><span>우편번호 검색</span></a> -->
                                          </li>
                                          <li class="vm_box">
                                             <label>주소</label>
                                             <input type="text" name="ADDR_1" id="ADDR_1" maxlength="100" class="input_txt2 adr" value="<?=$delivery[0]->address?>" readonly="" style="width:70%">
                                          </li>
                                          <li class="vm_box">
                                             <label>상세주소</label>
                                             <input type="text" name="ADDR_2" id="ADDR_2" maxlength="100" class="input_txt2 adr" value="<?=$delivery[0]->detail_address?>" onkeyup="fnHanEng(this.value, frmPageInfo.ADDR_2_EN);" onblur="fnHanEng(this.value, frmPageInfo.ADDR_2_EN);" style="width:70%">
                                             <br>
                                             <div style="padding-top:5px">
                                                <label></label>* 도로명 주소를 써주세요. 지번 주소 기재 시 통관/세관에서 오류로 분류시켜 통관지연이 될 수 있습니다
                                             </div>
                                          </li>
                                          <input type="hidden" name="ADDR_1_EN" id="ADDR_1_EN" value="18, Samseong-ro 115-gil, Gangnam-gu, Seoul">
                                          <input type="hidden" name="ADDR_2_EN" id="ADDR_2_EN" value="SEOUL">
                                       </ul>
                                    </td>
                                 </tr>
                                 <tr>
                                    <th>배송 요청사항</th>
                                    <td colspan="3">
                                       <select  class="vm form-control" id="sSelReq" onchange="fnReqValGet(this.value);">
                                          <option value="">직접기재</option>
                                          <option value="배송 전 연락 바랍니다">배송 전 연락 바랍니다</option>
                                          <option value="부재시 경비실에 맡겨주세요">부재시 경비실에 맡겨주세요</option>
                                          <option value="부재시 집앞에 놔주세요">부재시 집앞에 놔주세요</option>
                                          <option value="택배함에  맡겨주세요">택배함에 맡겨주세요</option>
                                       </select>
                                       <div style="line-height:150%;padding-top:5px;">
                                          <input type="text" name="REQ_1" id="REQ_1" maxlength="100" class="input_txt2 full form-control" value="<?=$delivery[0]->request_detail?>">
                                          <br>
                                          <div style="padding-top:8px;">
                                             * 국내 배송기사 분께 전달하고자 하는 요청사항을 남겨주세요(예: 부재 시 휴대폰으로 연락주세요.)
                                          </div>
                                       </div>
                                    </td>
                                 </tr>
                              </tbody>
                           </table>
                        </div>
                     </div>
                     <div class="step_box">
                        <input type="hidden" name="sProNum" id="sProNum" value="<?=sizeof($products)?>" readonly="">
                        <p class="clrBoth pHt30"></p>
                        <div class="orderStepTit">
                           <p>
                              <span class="stepTxt">STEP</span>
                              <span class="stepNo">04</span>
                           </p>
                           <h4>
                              상품 정보를 입력해 주세요
                           </h4>
                        </div>
                        <!-- B: 상품 상세 -->
                        <?php if(!empty($products)): ?>
                            <?php foreach($products as $key=>$value):  ?>
                              <?php array_push($pid,$value->id); ?>
                                <div id="TextProduct<?=$key+1?>">
                                   <div class="order_table order_table_top">
                                      <table class="proBtn_write">
                                         <tbody>
                                            <tr>
                                               <td width="30%">
                                                  <h4 class="s_tit vm_box" style="color:#ed7d31;">
                                                     <input type="hidden" name="PRO_SEQ" id="PRO_SEQ" value="1">
                                                     <input type="hidden" name="BUY_REQ" id="BUY_REQ" value="">
                                                     <input type="hidden" name="ARV_STAT_CD" id="ARV_STAT_CD" value="2">
                                                     <input type="hidden" name="PRO_STOCK_SEQ" id="PRO_STOCK_SEQ" value="0">
                                                     <label style="font-size:14px;">
                                                        상품#<?=$key+1?>
                                                     </label>
                                                     <input type="text" name="StockTxt" id="StockTxt" value="" class="stock-font" readonly="">
                                                  </h4>
                                               </td>
                                               <td style="text-align:right;">
                                                <div class="col-md-4 my-4">
                                                   <a href="javascript:fnPageCopy2('<?=$key+1?>');" class="btn btn-warning btn-sm w-100"><span>상품복사</span></a>
                                                </div>
                                                <div class="col-md-4 my-4">
                                                    <a href="javascript:fnProPlus('<?=$key+1?>');" class="btn btn-success btn-sm w-100"><span>╋ 상품추가</span></a>
                                                </div>
                                                <div class="col-md-4 my-4">
                                                   <a href="javascript:fnStockTempDel('<?=$key+1?>')" class="btn btn-danger btn-sm w-100"><span>━ 상품삭제</span></a>
                                                </div>
                                               </td>
                                            </tr>
                                         </tbody>
                                      </table>
                                   </div>
                                   <div class="order_table">
                                      <table class="order_write" summary="상품정보 사항">
                                         <caption>상품정보</caption>
                                         <colgroup>
                                            <col width="15%">
                                            <col width="35%">
                                            <col width="15%">
                                            <col width="35%">
                                         </colgroup>
                                         <tbody>
                                            <input type="hidden" name="ORD_SITE" id="ORD_SITE" value="">
                                            <input type="hidden" name="SHIP_NM" id="SHIP_NM" value="KIMSUIN">
                                            <tr id="DLVR_1">
                                               <th>트래킹번호
                                                  <br>Tracking No.
                                               </th>
                                               <td colspan="3" class="vm_box">
                                                  <select title="Tracking Number" name="FRG_DLVR_COM" id="FRG_DLVR_COM" style="width:69px;" class="vm">
                                                     <?php if(!empty($trackings)): ?>
                                                        <?php foreach($trackings as $values): ?>
                                                            <option value="<?=$values->id?>" 
                                                                <?php if($values->name==$value->trackingHeader) echo 'selected'; ?>
                                                                ><?=$values->name?></option>
                                                        <?php endforeach; ?>
                                                     <?php endif; ?>
                                                  </select>
                                                  <input type="text" class="input_txt2 " name="FRG_IVC_NO" id="FRG_IVC_NO" maxlength="40"  onblur="fnTrkNoChk();fnTotalProPrice();" title="Tracking Number"  value="<?=$value->trackingNumber?>">&nbsp;&nbsp;
                                                  <label>
                                                  <input type="checkbox" name="TRACKING_NO_YN" id="TRACKING_NO_YN" onchange="fnTrkNoAfChk('<?=$key+1?>');" value="Y">트래킹 번호 나중에 입력</label>&nbsp;&nbsp;
                                               </td>
                                            </tr>
                                            <tr id="ORD_1">
                                               <th>오더번호</th>
                                               <td colspan="3" class="vm_box">
                                                  <input type="text" class="input_txt2 per40" name="SHOP_ORD_NO" 
                                                  id="SHOP_ORD_NO" maxlength="40" value="<?=$value->order_number?>">
                                               </td>
                                            </tr>
                                            <tr>
                                               <th>
                                                  <p class="goods_img"><img src="<?=$value->image?>" width="109" height="128" id="sImgNo<?=$key+1?>"></p>
                                                  <br><a href="javascript:openPopupImg(<?=$key+1?>);" class="btn_small5 vm"><span>이미지등록</span></a>
                                               </th>
                                               <td class="depth_table" colspan="3">
                                                  <!-- 상품 상세 -->
                                                  <table class="order_noBd">
                                                     <colgroup>
                                                        <col width="15%">
                                                        <col width="*">
                                                     </colgroup>
                                                     <tbody>
                                                        <tr>
                                                           <th>* 통관품목</th>
                                                           <td>
                                                              <select name="PARENT_CATE" id="PARENT_CATE" class="vm"  onchange="fnArcAjax(this.value,'<?=$key+1?>');">
                                                                  <?php $pidss = "pid".$value->id; ?>
                                                                  <?php if(!empty($categorys)): ?>
                                                                     <?php foreach($categorys as $valuep): ?>
                                                                        <option value="<?=$valuep->id?>" 
                                                                        <?php if($$pidss == $valuep->id) echo 'selected'; ?> ><?=$valuep->name?></option>
                                                                     <?php endforeach; ?>
                                                                  <?php endif; ?>
                                                              </select>
                                                              <!--품목명-->
                                                              <span>
                                                                 <select name="ARC_SEQ" id="TextArc_<?=$key+1?>" title="통관품목" onchange="fnArcChkYN('<?=$key+1?>',this.value);">
                                                                    <?php $ss = "category_ch".$value->id; ?>
                                                                     <?php if(!empty($$ss)): ?>
                                                                        <?php foreach($$ss as $valuep): ?>
                                                                           <option value="<?=$valuep->id?>" 
                                                                              enchar="<?=$valuep->en_subject?>" cnchar="<?=$valuep->chn_subject?>"
                                                                     <?php if($value->category == $valuep->id) echo 'selected'; ?>
                                                                              ><?=$valuep->name?></option>
                                                                        <?php endforeach; ?>
                                                                     <?php endif; ?>
                                                                 </select>
                                                              </span>
                                                              <br>카테고리에 없는 품목은 직접 영문명 상세기재 바랍니다.
                                                           </td>
                                                        </tr>
                                                        <tr>
                                                           <th>* 상품명(영문)</th>
                                                           <td style="line-height:150%;">
                                                              <input type="text" class="input_txt2 per40" name="PRO_NM" id="PRO_NM" maxlength="200" value="<?=$value->productName?>" onblur="fnValKeyRep( /[^a-zA-z0-9 \,\.\-]/g, this );" title="영문상품명">
                                                              <input type="hidden" class="input_txt2 per60" name="PRO_NM_CH" id="PRO_NM_CH" maxlength="200"  title="중문상품명" readonly="">
                                                              * 정확한 작성을 해주셔야 통관지연을 막을 수 있습니다. (대표품목, 특수문자, 한글 입력 금지)
                                                           </td>
                                                        </tr>
                                                        <input type="hidden" class="input_txt2" name="BRD" id="BRD" maxlength="200" value="" title="브랜드">
                                                        <tr>
                                                           <th>* 단가</th>
                                                           <td>
                                                              단가
                                                              <input type="text" class="input_txt2 per20" name="COST" id="COST" maxlength="10" onblur="fnNumChiper(this, '2');fnTotalProPrice();" onmouseup="$(this).select();" value="<?=$value->unitPrice?>" title="단가"> &nbsp;X&nbsp; 수량
                                                              <input type="text" class="input_txt2 per20" name="QTY" id="QTY" maxlength="5" onblur="fnNumChiper(this, '0');fnTotalProPrice();" onmouseup="$(this).select();" value="<?=$value->count?>" title="수량">&nbsp;&nbsp;
                                                           </td>
                                                        </tr>
                                                        <tr>
                                                           <th>*옵션</th>
                                                           <td>
                                                              색상
                                                              <input type="text" class="input_txt2 per20" name="CLR" id="CLR" maxlength="100" value="<?=$value->color?>" title="색상(영문)"> &nbsp; 사이즈
                                                              <input type="text" class="input_txt2 per20" name="SZ" id="SZ" maxlength="80" value="<?=$value->size?>" title="사이즈"> &nbsp;
                                                           </td>
                                                        </tr>
                                                        <input type="hidden" class="input_txt2 full" name="AMT" id="AMT" maxlength="10" value="15000.00" readonly="">
                                                        <tr>
                                                           <th>* 상품URL</th>
                                                           <td>
                                                              <input type="text" class="input_txt2 full form-control" name="PRO_URL" id="PRO_URL" maxlength="500" value="<?=$value->url?>" title="상품URL">
                                                              <input type="hidden" name="pro_step" value="<?=$value->step?>">
                                                              <input type="hidden" name="pro_id" value="<?=$value->id?>">
                                                              <br> *검수가 필요하신 분들은 정확한 URL주소를 넣어주세요
                                                           </td>
                                                        </tr>
                                                        <tr>
                                                           <th>* 이미지URL</th>
                                                           <td>
                                                              <input type="text" class="input_txt2 full form-control" name="IMG_URL" id="IMG_URL" maxlength="500" value="<?=$value->image?>" onblur="fnImgChg('1');" title="쇼핑몰 상품페이지에서 상품이미지를 우클릭하여, URL을 복사하세요">
                                                           </td>
                                                        </tr>
                                                     </tbody>
                                                  </table>
                                                  <!-- //table -->
                                               </td>
                                            </tr>
                                         </tbody>
                                      </table>
                                   </div>
                                   <?php if($key == sizeof($products)-1): ?>
                                       <div id="TextProduct<?=$key+2?>"></div>
                                    <?php endif; ?>
                                 <?php endforeach; ?>
                              <?php endif; ?>
                        <?php for($u=0;$u<sizeof($products);$u++){ ?>
                              </div>
                        <?php  }?>
                        <!-- E: 상품 상세 -->
                        <p class="clrBoth pHt30"></p>
                        <div class="orderStepTit">
                           <h4>금액 정보</h4>
                        </div>
                        <div class="order_table">
                           <table class="order_write">
                              <colgroup>
                                 <col width="15%">
                                 <col width="30%">
                                 <col width="*">
                              </colgroup>
                              <tbody>
                                 <tr>
                                    <input type="hidden" name="SALE_AMT" id="SALE_AMT" value="0">
                                    <input type="hidden" name="TAX_AMT" id="TAX_AMT" value="0">
                                    <input type="hidden" name="SHIP_AMT" id="SHIP_AMT" value="0">
                                    <td rowspan="3">
                                       <ul class="proTtAmt">
                                          <li><span class="fl">총 수량</span> <span class="fr"><span id="TextTotalProCNT" 
                                             class="proTtQtyTxt"><?=$delivery[0]->ProCount?></span></span>
                                          </li>
                                          <li><span class="fl">총 금액</span> <span class="fr">￥<span id="TextTotalAmt" 
                                             class="proTtAmtTxt"><?=number_format($delivery[0]->ProSum)?></span></span>
                                          </li>
                                          <li style="height:auto;">
                                             <h3><span class="proTtBtmTxt">* 세관에 신고되는 금액 입니다 (쇼핑몰 결제 금액과 동일)<br>
                                                * 총 금액이 150달러를 넘을 경우 일반통관으로 진행되며 수수료 3000원이 추가 부과됩니다.</span>
                                             </h3>
                                          </li>
                                       </ul>
                                    </td>
                                 </tr>
                              </tbody>
                           </table>
                        </div>
                        <p class="clrBoth pHt30"></p>
                        <div class="orderStepTit">
                           <p>
                              <span class="stepTxt">STEP</span>
                              <span class="stepNo">05</span>
                           </p>
                           <h4>
                              요청사항을 입력해 주세요
                           </h4>
                        </div>
                        <div class="order_table">
                           <table class="order_write" summary="기타 사항">
                              <colgroup>
                                 <col width="15%">
                                 <col width="*">
                              </colgroup>
                              <tbody>
                                 <?php if(!empty($service_header)): ?>
                                 <?php foreach($service_header as $vas): ?>
                                 <tr>
                                    <th><?=$vas->name?></th>
                                    <td class="vm_box">

                                    <?php if(!empty($aa[$vas->id])): ?>
                                       <?php foreach($aa[$vas->id] as $chd): ?>
                                          <label style="padding-right:2px;">
                                             <input type="checkbox" class="input_chk" name="EtcDlvr"  mny="<?=$chd['price']?>" value="<?=$chd['id']?>" onclick="fnEtcSvcChk($(this));"  
                                             <?php if(isset($services_ss[$chd['id']]) && $services_ss[$chd['id']]>=0) echo "checked"; ?> ><?=$chd['name']?>
                                             <span style="color:#d30009;font-weight:bold;">
                                                (<?= $chd['price'] == 0 ? '무료':$chd['price'].'원' ?>)
                                             </span>
                                          </label>
                                       <?php endforeach; ?>
                                    <?php endif; ?>
                                    </td>
                                 </tr>
                                 <?php endforeach; ?>
                                 <?php endif; ?>
                                 <input type="hidden" name="CPN_ETC" id="CPN_ETC" value="">
                                 <tr>
                                    <th>물류 요청사항</th>
                                    <td>
                                       <input type="text" name="REQ_2" id="REQ_2" maxlength="100" class="input_txt2 full form-control" value="<?=$delivery[0]->logistics_request?>">
                                    </td>
                                 </tr>
                              </tbody>
                           </table>
                        </div>
                     </div>
                  </div>
                  <div class="btn-area">
                     <div class="btn-area" style="text-align:center">
                        <span class="whGraBtn_bg ty2">
                        <button type="button" class="btn btn-danger" onclick="fnPageStep();">수정</button>
                        </span>
                        <span class="whGraBtn ty2">
                        <a href="/admin" class="btn btn-primary">목록</a>
                        </span>
                     </div>
                  </div>
               </div>
            </form>
         </div>
      </div>
   </section>
</div>
<div class="modal" tabindex="-1" role="dialog" id="exampleModalCenter">
  <div class="modal-dialog" role="document">
      <?php echo form_open_multipart('registerImage',array('id' => 'popFrmImg'));?>
       <div class="modal-content">
         <div class="modal-header">
           <h5 class="modal-title">이미지 등록</h5>
           <button type="button" class="close" data-dismiss="modal" aria-label="Close">
             <span aria-hidden="true">&times;</span>
           </button>
         </div>
         <div class="modal-body">
          <table class="board_list" summary="">
              <colgroup>
              <col width="15%">
              <col width="*">
              </colgroup>
            <thead>
            <tr> 
               <th>이미지</th>
               <th></th>
            </tr>
            </thead> 
            <tbody>
            <tr>
               <td><input type="file" name="FILE_NM" id="FILE_NM"></td>
            </tr>
            </tbody>
          </table> 
         </div>
         <div class="modal-footer">
           <button type="submit" class="btn btn-primary">이미지 등록</button>
           <button type="button" class="btn btn-secondary" data-dismiss="modal">취소</button>
         </div>
       </div>
   </form>
  </div>
</div>
<script>
   var gFrmNm = "#frmPageInfo";
   var fGrpCdInit = "";
   function openDaumPostcode() {
       new daum.Postcode({
           oncomplete: function(data) {
               if ( data.userSelectedType == "R" ) {
                   document.getElementById('ZIP').value = data.zonecode;
                   document.getElementById('ADDR_1').value = data.roadAddress;
                   document.getElementById('ADDR_2').focus();
                   document.getElementById('ADDR_1_EN').value = data.addressEnglish;
               } else {
                   alert("지번주소가 아닌 도로명주소를 선택하십시오.");
               }
           }
       }).open();
   }
   function fnReqValGet(sVal) {
      $("#frmPageInfo input[name='REQ_1']").val( sVal );
   }

   function fnEtcSvcChk(pObj) {
      var fGrpCd1 = "";
       $(gFrmNm + " input[name='EtcDlvr']").each( function() {
           if ( $(this).is(":checked") ) {
              fGrpCd1 += "," + $(this).val();
           }
       });
      $("#fees").val(fGrpCd1);
      fnTotalProPrice();
   }

   function remove_character(str, char_pos) 
   {
     part1 = str.substring(0, char_pos);
     part2 = str.substring(char_pos + 1, str.length);
     return (part1 + part2);
   }
   function fnArcAjax(sSeq, ShopNum){
      var url = "?CATE_SEQ="+sSeq; 
      fnGetChgHtmlAjax("TextArc_"+ShopNum, "/getCateogrys", url);
   }
   function fnArcChkYN(val1,val2){
      $("#TempShopNum").val(val1);
      var val = "sArcSeq=" + val2;  
      // DoCallbackCommonPost("/getCategoryById", val);
      fnCtmArcProNmGet(val1);
   }
   function fnCtmArcProNmGet(ShopNum) {
      var fProNmEn = "", fProNmCn = "";

      fProNmEn = $(gFrmNm + " select[name='ARC_SEQ'] option:selected").eq(ShopNum-1).attr("EnChar");
      fProNmCn = $(gFrmNm + " select[name='ARC_SEQ'] option:selected").eq(ShopNum-1).attr("CnChar");
      //alert(fProNmCn);
      
      $(gFrmNm + " input[name='PRO_NM']").eq(ShopNum-1).val( fProNmEn );
      $(gFrmNm + " input[name='PRO_NM_CH']").eq(ShopNum-1).val( fProNmCn );
   }
   function openPopupImg(pid){

   $("#product_val").val(pid);
   $('#exampleModalCenter').modal('show');
}
$('#popFrmImg').on('submit',(function(e) {
  e.preventDefault();
  var formData = new FormData(this);

  $.ajax({
      type:'POST',
      url: $(this).attr('action'),
      data:formData,
      dataType: "json",
      async: false,
   processData: false,
   contentType: false,
   
      success:function(data){             
          $('#exampleModalCenter').modal('toggle');
          if(data.errorId==0){
            var pval = $("#product_val").val();
            $("#TextProduct"+pval).find("#IMG_URL").first().val("/upload/delivery/"+data.img);
            $("#sImgNo"+$("#product_val").val()).attr("src","/upload/delivery/"+data.img);
          }

      },
      error: function(data){
          console.log("error");
          console.log(data);
      }
  });
}));

function fnPageStep(){
      var FRG_DLVR_COM =new Array();
      var FRG_IVC_NO = new Array();
      var SHOP_ORD_NO = new Array();
      var PARENT_CATE = new Array();
      var ARC_SEQ = new Array();
      var PRO_NM = new Array();
      var COST =new Array();
      var QTY = new Array();
      var CLR = new Array();
      var SZ = new Array();
      var PRO_URL = new Array();
      var IMG_URL = new Array();
      var temp_array = new Array();
      var main_array  =new Array();
      if( $("#ADRS_KR").val().trim() == "" || 
         $("#ADRS_EN").val().trim() == "" || 
         $("#RRN_NO").val().trim()  == "" ||
         $("#MOB_NO1").val().trim() == "" ||
         $("#MOB_NO2").val().trim() == "" ||
         $("#MOB_NO3").val().trim() == "" ||
         $("#ZIP").val().trim() == "" ||
         $("#ADDR_1").val().trim() == ""){
         $([document.documentElement, document.body]).animate({
              scrollTop: $("#stepOrd-EtcTt").offset().top
          }, 2000);
         alert("받는 사람 정보를 입력해주세요.");
         return;
      }

      for( var i=1; i<=$("#sProNum").val(); i++ ) {

         temp_array = new Array();
         if($("input[name='TRACKING_NO_YN']").eq(i-1).prop('checked')){
            temp_array.push("");
            temp_array.push("");
         }
         else{
            temp_array.push($("select[name='FRG_DLVR_COM']").eq(i-1).val()==null?"":$("select[name='FRG_DLVR_COM']").eq(i-1).val());
            temp_array.push($("input[name='FRG_IVC_NO']").eq(i-1).val()==null?"":$("input[name='FRG_IVC_NO']").eq(i-1).val());
         }

         if ( !fnIptChk($("select[name='ARC_SEQ']").eq(i-1)) ) {
            fnMsgFcs($("select[name='ARC_SEQ']").eq(i-1), '통관품목을 선택해 주세요.');
            return;
         }

         if ( !fnIptChk($("input[name='PRO_NM']").eq(i-1)) ) {
            fnMsgFcs($("input[name='PRO_NM']").eq(i-1), '상품명을 입력해 주세요.');
            return;
         }
         
         if ( !fnIptChk($("input[name='COST']").eq(i-1)) ) {
            fnMsgFcs($("input[name='COST']").eq(i-1), '단가를 입력해 주세요.');
            return;
         }

         if ( Number($("input[name='COST']").eq(i-1).val()) <= 0 ) {
            fnMsgFcs($("input[name='COST']").eq(i-1), '단가는 0보다 커야합니다.');
            return;
         }
         if ( !fnIptChk($("input[name='QTY']").eq(i-1)) ) {
            fnMsgFcs($("input[name='QTY']").eq(i-1), '수량을 입력해 주세요.');
            return;
         }
         temp_array.push($("input[name='SHOP_ORD_NO']").eq(i-1).val());
         temp_array.push($("select[name='PARENT_CATE']").eq(i-1).val());
         temp_array.push($("select[name='ARC_SEQ']").eq(i-1).val());
         temp_array.push($("input[name='PRO_NM']").eq(i-1).val()); 
         temp_array.push($("input[name='COST']").eq(i-1).val()); 
         temp_array.push($("input[name='QTY']").eq(i-1).val()); 
         temp_array.push($("input[name='CLR']").eq(i-1).val()); 
         temp_array.push($("input[name='SZ']").eq(i-1).val()); 
         temp_array.push($("input[name='PRO_URL']").eq(i-1).val()); 
         temp_array.push($("input[name='IMG_URL']").eq(i-1).val());

         if($("input[name='pro_step']").eq(i-1).val()!=undefined && $("input[name='pro_step']").eq(i-1).val()!=""){
            temp_array.push($("input[name='pro_step']").eq(i-1).val());
         }
         else{temp_array.push("");}
         if($("input[name='pro_id']").eq(i-1).val()!=undefined && $("input[name='pro_id']").eq(i-1).val()!=""){
            temp_array.push($("input[name='pro_id']").eq(i-1).val());
         }
         else{temp_array.push("");}
         main_array.push(temp_array);
      }

      $("#theader").val(JSON.stringify(main_array));
      $("#CHECK").val(remove_character(fGrpCdInit,0));
      $("#frmPageInfo").submit();
    }

    $(document).ready(function(){
      $("#pid").val("<?=implode(",",$pid)?>")
    });
</script>