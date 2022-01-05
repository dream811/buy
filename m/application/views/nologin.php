<?php $page_title = isset($title) ?$title:""; ?>
<div class="shop_header p-5 bg-green">
	<div class="row">
		<div class="col-xs-12 text-center p-1"><span class="parts1 text-white"><?=$page_title?></span></div>
	</div>
</div>
<!-- <div class="category_part">
	<ul class="nav-shop">
		<?php $bmenu = get_board(); ?>
          <?php $n= ""; ?>
          <?php if(!empty($bmenu)): ?>
          <?php foreach($bmenu as $value): ?>
            <?php if($value->title=="1:1맞춤문의"): ?>
            <?php $n= "/panel?id=".$value->iden ?>
            <?php endif; ?>
          <li class="shop-item"><a href="/panel?id=<?=$value->iden?>"><span class="border-l"><?=$value->title?></span></a></li>
          <?php endforeach; ?>
        <?php endif; ?>
        <li class="shop-item"><a href="/event"><span class="border-l">이벤트</span></a></li>
	</ul>
</div>
<div class="row pt-10 ">
	<div class="col-md-12 p-left-5">
	    <div class="padgeName" style="border-bottom:none">
	        <h2 style="font-size: 15px" class="text-green"><?=!empty($f) ? $f:""?></h2>
	   </div>
	</div>
</div> -->
<!-- <div class="row mt-5 GrpBuyTit pt-5">
  	<div class="col-xs-4 mb-5 p-right-5 p-left-5">
    	<a href="/register" class="btn btn-d7-gradient w-100 btn-round text-pa btn-lg" style="font-size: 14px;display: table;height: 58px">
    		<span style="display: table-cell;vertical-align: middle;">회원가입</span></a>
  	</div>
  	<div class="col-xs-4 mb-5 p-right-5 p-left-5">
    	<a href="/login" class="btn btn-d7-gradient w-100 btn-round text-pa btn-lg" style="font-size: 14px;display: table;height: 58px">
    		<span style="display: table-cell;vertical-align: middle;">로그인</span></a>
  	</div>
  	<div class="col-xs-4 mb-5 p-right-5 p-left-5">
    	<a href="" class="btn btn-d7-gradient w-100 btn-round text-pa btn-lg" style="font-size: 14px" 
      data-toggle="modal" data-target="#findpass">아이디<br>비번찾기</a>
  	</div>
  	<div class="col-xs-4 mb-5 p-right-5 p-left-5">
    	<a href="/usetext" class="btn btn-d7-gradient w-100 btn-round text-pa btn-lg" style="font-size: 14px;display: table;height: 58px">
    		<span style="display: table-cell;vertical-align: middle;">이용약관</span></a>
  	</div>
  	<div class="col-xs-4 mb-5 p-right-5 p-left-5">
    	<a href="/policy" class="btn btn-d7-gradient w-100 btn-round text-pa btn-lg" style="font-size: 14px">개인정보<br>취급방침</a>
  	</div>
</div>
 -->
<div class="modal fade" id="findpass" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog  modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header bg-dark text-white">
        <h5 class="modal-title font-weight-bold" id="exampleModalLabel">아이디/비밀번호 찾기</h5>
        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          <p class="font-weight-bold">아이디 찾기</p>
          <hr>
            <div class="form-group row">
              <div class="col-md-2">
                <label for="recipient-name" class="col-form-label">이름:</label>
              </div>
              <div class="col-md-10">
                <input type="text" class="form-control" id="recipient-name" name="recipient-name">
              </div>
            </div>
            <div class="form-group row">
              <div class="col-md-2">
                <label for="recipient-email" class="col-form-label">메일:</label>
              </div>
              <div class="col-md-10">
                <input type="email" class="form-control" id="recipient-email" name="recipient-email">
              </div>
            </div>
          <div class="row form-group">
              <div class="col-md-12 text-right">
                <a href="javascript:void(0)" class=" btn btn-danger btn-sm btn-round" onclick="find(1,this)" 
                data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> 처리중">찾기</a>
              </div>
          </div>
          <p class="font-weight-bold">비밀번호 찾기</p>
          <hr>
          <div class="form-group row">
              <div class="col-md-2">
                <label for="name" class="col-form-label">이름:</label>
              </div>
              <div class="col-md-10">
                <input type="text" class="form-control" id="name" name="name">
              </div>
            </div>
            <div class="form-group row">
              <div class="col-md-2">
                <label for="loginId" class="col-form-label">아이디:</label>
              </div>
              <div class="col-md-10">
                <input type="text" class="form-control" id="loginId" name="loginId">
              </div>
            </div>
            <div class="form-group row">
              <div class="col-md-2">
                <label for="email" class="col-form-label">메일:</label>
              </div>
              <div class="col-md-10">
                <input type="email" class="form-control" id="email" name="email">
              </div>
            </div>
            <div class="row form-group">
              <div class="col-md-12 text-right">
                <a href="javascript:void(0)" class=" btn btn-danger btn-sm btn-round" onclick="find(2,this)" 
                data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> 처리중">찾기</a>
              </div>
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default btn-round btn-sm" data-dismiss="modal">닫기</button>
      </div>
    </div>
  </div>
</div>
<script>
  var message = "입력하신 정보가 정확한 정보가 아닙니다.";
  function find(id,obj){
    var ids = [];
    var $this = $(obj);
    var data = {};
    if(id ==1)
    {
      ids["recipient-name"] = "이름을 입력하세요.";
      ids["recipient-email"] = "메일을 입력하세요.";
    }
    else{
      ids["name"] = "이름을 입력하세요.";
      ids["loginId"] = "아이디를 입력하세요.";
      ids["email"] = "메일을 입력하세요.";
    }

    for (var key in ids) {
        if (document.getElementById(key).value == '') {
        alert(ids[key]);
        document.getElementById(key).focus();
        return false;
      }
      if((key =="email" || key=="recipient-email") && !validateEmail(document.getElementById(key).value)){
        alert("이메일 형식이 정확치 않습니다.");
        return false;
      }
      data[key] = document.getElementById(key).value;
    }
    data["type"] = id;
    $.ajax({
      url: baseURL + "checkForget",
        data: data,
        dataType:"json",
        type:'POST',
        beforeSend: function() {
            $this.button('loading');
        },
        success: function (data) {
          $this.button('reset');
          if(data.status ==1){
            alert(data.message);
          }
          else
            alert(message);
          
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) { 
          alert("서버오류");
          $this.button('reset');
        }
    });
    
  }

  function validateEmail(email) {
      const re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
      return re.test(String(email).toLowerCase());
  }
</script>