<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        추가수수료관리
      </h1>
    </section>
    <section class="content">
      <form action="saveFee" method="post">
        <div class="row my-3">
          <div class="col-md-2 text-center">
            <p>관/부가세</p>
          </div>
          <div class="col-md-2">
            <input type="text" name="tax_fee" id="tax_fee" class="form-control" value="<?=$deliveryFee[0]->tax_fee?>">    
          </div>
          원
        </div>
        <div class="row my-3">
          <div class="col-md-2 text-center">
            <p>폐기수수료</p>
          </div>
          <div class="col-md-2">
            <input type="text" name="throw_price" id="throw_price" class="form-control" value="<?=$deliveryFee[0]->throw_price?>">    
          </div>
          원
        </div>
        <div class="row my-3">
          <div class="col-md-2 text-center">
            <p>검역수수료</p>
          </div>
          <div class="col-md-2">
            <input type="text" name="quarantine" class="form-control" value="<?=$deliveryFee[0]->quarantine?>">    
          </div>
          원
        </div>
        <div class="row my-3">
          <div class="col-md-2 text-center">
            <p>카툰분할 수 신고/BL 분할</p>
          </div>
          <div class="col-md-2">
            <input type="text" name="carton_price" class="form-control" value="<?=$deliveryFee[0]->carton_price?>">    
          </div>
          원
        </div>
        <div class="row my-3">
          <div class="col-md-2 text-center">
            <p>과태료</p>
          </div>
          <div class="col-md-2">
            <input type="text" name="gate_fee" class="form-control" value="<?=$deliveryFee[0]->gate_fee?>">    
          </div>
          원
        </div>
        <div class="row my-3">
          <div class="col-md-2 text-center">
            <p>리턴 수수료</p>
          </div>
          <div class="col-md-2">
            <input type="text" name="return_fee" class="form-control" value="<?=$deliveryFee[0]->return_fee?>">    
          </div>
          원
        </div>
        <div class="row my-3">
          <div class="col-md-2 text-center">
            <p>추가수수료</p>
          </div>
          <div class="col-md-2">
            <input type="text" name="add_fee" class="form-control" value="<?=$deliveryFee[0]->add_fee?>">
          </div>
        </div>
        <div class="row my-3">
          <div class="col-md-2 text-center">
            <p>부피무게 기본 값</p>
          </div>
          <div class="col-md-2">
            <input type="text" name="volunmn_rate" class="form-control" value="<?=$deliveryFee[0]->volunmn_rate?>">    
          </div>
          %
        </div>
        <div class="row my-3">
          <div class="col-md-2 text-center">
            <p>카드수수료</p>
          </div>
          <div class="col-md-2">
            <input type="text" name="credit_fee" class="form-control" value="<?=$deliveryFee[0]->credit_fee?>">    
          </div>
          %
        </div>
        <div class="row my-3">
          <div class="col-md-2 text-center">
            <p>합배송</p>
          </div>
          <div class="col-md-2">
            <input type="text" name="sum_delivery" class="form-control" value="<?=$deliveryFee[0]->sum_delivery?>">    
          </div>
        </div>
        <div class="row my-3">
          <div class="col-md-2 text-center">
            <p>보관수수료</p>
          </div>
          <div class="col-md-2">
            <input type="text" name="save_fee" class="form-control" value="<?=$deliveryFee[0]->save_fee?>">    
          </div>
        </div>
        <div class="row my-3">
          <div class="col-md-2 text-center">
            <p>부피무게</p>
          </div>
          <div class="col-md-2">
            <input type="text" name="volumn_price" class="form-control" value="<?=$deliveryFee[0]->volumn_price ?>">    
          </div>
        </div>
        <div class="row my-3">
            <div class="col-md-2 text-center">
                <input type="submit" class="btn btn-primary" value="저장">
                <input type="reset"  class="btn" value="취소">
            </div>
        </div>
      </form>
    </section>
</div>
