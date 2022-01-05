<?php $s=""; ?>
<?php $controller = $this->router->fetch_method(); ?>
<?php $controller = !empty($controller) ? $controller : ""; ?>
<link rel="stylesheet" type="text/css" href="<?=base_url_home()?>assets/plugins/AutoComplete/easy-autocomplete.min.css"></link>
<link rel="stylesheet" type="text/css" href="<?=base_url_home()?>assets/plugins/AutoComplete/easy-autocomplete.themes.min.css"></link>
<script src="<?=base_url_home()?>assets/plugins/AutoComplete/jquery.easy-autocomplete.min.js"></script>

<div class="bg-white" id="shopping_top">
	<div class="shop_header p-5 p-b-0">
		<div class="row">
			<div class="col-xs-12 text-center p-1">
				<div type="button" id="moby-shop" data-toggle="collapse" data-target="#shop-nav" class="font-weight-bold p-5">
			        <div></div>
			        <div></div>
			        <div></div>
			        카테고리
			    </div>
			    <a href="/taoshopping"><h2 id="shop_tit" class="fl">쇼핑몰</h2></a>
				<ul class="icon-menus">
					<li class="more-search">
						<a href="javascript:void(0)">
							<span class="my-search-icon">&nbsp;</span> 
		                  	<span class="my-search-title">검색</span>
						</a>
					</li>
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
		</div>
		
	</div>
	<?php if(	($controller == "shopping" && !empty($this->input->get("txt-category")) && in_array($this->input->get("txt-category"), FAVOR_URL)) || 
				$controller == "taoshopping" || 
				($controller == "shopping" && empty($this->input->get("txt-category")))):?>
	<div class="row p-0">
		<div class="col-xs-12 p-0">
			<nav class="navbar navbar-default  fav-nav border-none border-b">
			  <div class="container">
			  	<div class="collapse navbar-collapse">
			  		<ul class="nav navbar-nav">
				        <li class="<?=!empty($this->input->get("txt-category")) &&  $this->input->get("txt-category") == "best"? "active":""?>">
				        	<a href="/shopping?txt-category=best">베스트상품</a>
				        </li>
				        <li class="<?=!empty($this->input->get("txt-category")) &&  $this->input->get("txt-category") == "rec"? "active":""?>">
				        	<a href="/shopping?txt-category=rec">추천상품</a>
				        </li>
				        <li class="<?=!empty($this->input->get("txt-category")) &&  $this->input->get("txt-category") == "new"? "active":""?>"><a href="/shopping?txt-category=new">신상품</a></li>
				        <li class="<?=!empty($this->input->get("txt-category")) &&  $this->input->get("txt-category") == "low"? "active":""?>"><a href="/shopping?txt-category=low">싸다</a></li>
				       	<li class="<?=!empty($this->input->get("txt-category")) &&  $this->input->get("txt-category") == "wow"? "active":""?>"><a href="/shopping?txt-category=wow">멋지다</a></li>
				    </ul>
			  	</div>
			    
			  </div>
			</nav>
		</div>
	</div>
	<?php endif; ?>
</div>

<div class="search-section row bg-white pt-10 d-none">
	<div class="col-xs-12">
		<form action="/shopping" id="shop_form">
			<div class="input-group mb-3">
			  	<input type="text" class="form-control" placeholder="검색어를 입력하세요" id="txt-search" name="txt-search" value="">
			  	<div class="input-group-append">
			    	<button class="btn btn-default" type="button" onclick="$('.search-section').addClass('d-none');">
			    		닫기
			    	</button>
			  	</div>
			</div>
		</form>
	</div>
</div>
<?php if($controller == "shopping" && !empty($cates)): ?>
	<?php  $self = $cates["self_category"];	?>
	<?php  if(!empty($self) && ($self[0]->step ==1 || $self[0]->step ==2) ):?>
	<ol class="breadcrumb breadcrumb-arrow">
		<li class="">
			<a href="/taoshopping"><img src="/template/images/navbar_home.png" width="30"></a>
		</li>						
		<li class="">
			<a href="/shopping">쇼핑몰</a>
		</li>
		<?php if(!empty($cates["parent_category"])): ?>
		<li class="">
			<a href="/shopping?txt-category=<?=$cates["parent_category"][0]->category_code?>"><?=$cates["parent_category"][0]->name?></a>
		</li>	
		<?php endif;?>						
		<li class="active">
			<span class="font-weight-bold"><?=$self[0]->name?></span>
		</li>																							
	</ol>
	<?php 	endif;?>

	<?php  	if(!empty($cates["child_category"]) || !empty($cates["self3_category"])):?>
	<?php $self3_category = NULL; ?>
	<?php if(!empty($cates["child_category"])): ?>
		<?php $self3_category = $cates["child_category"]; ?>
	<?php endif;?>
	<?php if(!empty($cates["self3_category"])): ?>
	<div class="row bg-green p-5">
		<div class="col-xs-12 text-center p-1">
			<a href="/shopping?txt-category=<?=$cates["parent_category"][0]->category_code?>">
				<img src="/template/images/back.png" class="back_btn" width="18px">
			</a>
	    	<span class="parts1 text-white"><?=$cates["parent_category"][0]->name?></span>
		</div>
	</div>
	<?php $self3_category = $cates["self3_category"]; ?>
	<?php endif;?>		
	<div class="ctg_wrap">
	    <div class="ctg_inner">
	      	<div class="inner_box">
	        	<ul class="ctg_list">
	        		<?php foreach($self3_category as $value):?>
	        		<li>
		              <a href="/shopping?txt-category=<?=$value->category_code?>">
		                <span class="<?=$this->input->get("txt-category") == $value->category_code ? "text-green font-weight-bold" : "" ?>">
		                    <?=$value->name?>
		                </span>
		              </a>
		            </li>
	        		<?php endforeach;?>
	        	</ul>
	    	</div>
	    </div>	
	</div>
	<?php 	endif;?>
<?php endif;?>
<?php if($controller == "mybasket"): ?>
	<div class="row bg-green p-5">
		<div class=" col-xs-12 text-center p-1">
			<img src="/template/images/back.png" class="back_btn" width="18px" onclick="history.back();">
	    	<span class="parts1 text-white">장바구니</span>
		</div>
	</div>
<?php endif;?>
<!-- <script src="<?php echo site_url('/template/js/select2.min.js') ?>"></script> -->
<!-- <link rel="stylesheet" type="text/css" href="<?php echo site_url('/template/css/select2.min.css') ?>"> -->
<script>
	$('.shop_cate_list').on("change", function (e) {
		location.href="/shopping?category="+this.value;
	});

</script>


