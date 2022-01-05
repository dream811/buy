<?php 
if($this->input->get("type") =="qna"){
	$type = "qna";
	$label = "문의";
}
else{
	$type = "eval";
	$label = "평가";
}
$type =  $this->input->get("type") =="qna" ? "qna" : "eval";?>
<script>
	var pcode = "";
	var loaded =0;
	var review_count = Array();
	review_count["eval"] =  <?=$review["review_count"]?>;
	review_count["qna"] = <?=$qna?>;
	var type ="<?=$type?>";
</script>
<div class="container">
	<div class="row">
		<!-- <div id="subLeft" class="col-md-3">
			<div class="LeftTitle">
				구매후기
			</div>
			<ul class="leftMenu">
				<li class="<?=$type=="eval" ? "on":""?>"><a href="/service_eval_list?type=eval">상품평가</a></li>
				<li class="<?=$type=="qna" ? "on":""?>"><a href="/service_eval_list?type=qna">상품문의</a></li>
			</ul> 
		</div> -->
		<div id="subRight" class="col-md-12">
			<div class="padgeName">
	            <h2>상품<?=$label?></h2>
	         </div>
			<div id="ID_<?=$type?>_list" class="cm_board_item_post">
				<div class="list_area">
					<ul>
						
					</ul>
				</div>
			</div>
			<div class="text-center my-4">
	   			<a id="more_<?=$type?>" class="btn btn-default " onclick="getReivews('#ID_<?=$type?>_list','<?=$type?>')">더보기</a>
	   		</div>
		</div>
	</div>
</div>
<link href="<?php echo site_url('/template/css/shop.css'); ?>?<?=time()?>" rel="stylesheet">
<link href="<?php echo site_url('/assets/plugins/ratings/star-rating-svg.css')?>" rel="stylesheet">
<script src="<?php echo site_url('/assets/plugins/ratings/jquery.star-rating-svg.js')?>"></script>
<script src="<?php echo site_url('/template/js/product.js')?>?<?=time()?>"></script>
<script src="<?php echo site_url('/template/js/services.js')?>?<?=time()?>"></script>
<script src="<?php echo site_url('/template/js/shop.js')?>?<?=time()?>"></script>
<link rel="stylesheet" type="text/css" href="/template/css/services.css?<?=time()?>">
<script id="eval-lists" type="text/x-handlebars-template">
	<li class="toggleTarget eval_box_area" id="view_{{id}}">
		<a href="#none" onclick="return false;" class="upper_link toggleEval" data-target="eval42" title="test1">
			<img src="/assets/images/blank.gif" alt=""></a>
		<div class="posting">
		    <!-- 유동적 x 150 -->
		    <div class="thumb"><img src="/upload/shoppingmal/{{pid}}/{{image}}" alt="test1" /></div>
		    <div class="conts">
		        <!-- ◆열기전의 내용(글자수제한,사진안보임) -->
		        <dl class="before">
		            <!-- 제목한줄제한 -->
		            <dt>
		                <span class="title pointer" onclick="javascript:eval_show('view_{{id}}')">{{title}}</span>
		                <span class="title_icon">
		                    <!-- 새글아이콘 -->
		                    {{#if new}}
		                    <img src="/assets/images/board_ic_new.gif" alt="새글" />
		                    {{/if}}

		                    <!-- 사진첨부한 글이면 나타남 -->
		                </span>
		            </dt>
		            <!-- 내용두줄제한 -->
		            <dd>{{content}}</dd>
		        </dl>
		        <!-- ◆열기후의 내용(글자수제한없음, 사진보임) -->
		        <dl class="after">
		            <dt><span class="title">{{title}}</span></dt>
		            <dd>{{content}}</dd>
		            <dd>
		                {{#if image_uploaded}}
		                <img src="/upload/request/{{img}}" />
		                {{/if}}
		            </dd>
		        </dl>
		        <div class="info">
		        	{{#if_type_request type}}
					<div id="rating_{{id}}" class="fl" data-rating="{{eval_point}}"></div>
					{{/if_type_request}}
		            <!-- 작성날짜 -->
		            <span class="date">{{rdate}}</span>
		            <!-- 작성자 -->
		            <span class="writer">{{name}}</span>
		        </div>
		    </div>
		    <!-- 관리자답변상태 -->
		    {{#if reply_use}}
		    <span class="texticon_pack"><span class="red">답변완료</span></span>
		    {{else}}
		    <span class="texticon_pack"><span class="dark">답변대기</span></span>
		    {{/if}}
		    <!-- 상품관련버튼 상품찜하면 if_wish 추가 -->
		    <div class="post_bottom_btn">
		        {{#if wished}}
		        <a href="#none" onclick="return false;" class="btn btn_wish ajax_wish ajax_wish_{{pcode}} if_wish" title="찜하기" data-code="{{pcode}}"><span class="txt">이 상품찜</span></a>
		        {{else}}
		        <a href="#none" onclick="return false;" class="btn btn_wish ajax_wish ajax_wish_{{pcode}}" title="찜하기" data-code="{{pcode}}"><span class="txt">이 상품찜</span></a>
		        {{/if}}
		        <a href="/view/shop_products/{{pcode}}" class="btn btn_open" target="_blank"><span class="txt">이 상품보기</span></a>
		        {{#if permission}}
		        <a href="#none" class="btn btn_delete" onclick="eval_del({{id}});return false;"><span class="txt">내글 삭제</span></a>
		        {{/if}}
		    </div>
		</div>
	</li>
</script>