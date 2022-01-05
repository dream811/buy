<div class="container">
	<div class="row">
		<div id="subLeft" class="col-md-3">
			<div class="LeftTitle">
				상품주인찾아요
			</div>
			<ul class="leftMenu">
				<li class="on"><a href="/nodata">상품주인찾아요</a></li>
			</ul> 
		</div>
		<div id="subRight" class="col-md-9">
			<div class="padgeName">
				<h2>상품주인찾아요</h2>
			</div>
			<div class="table-responsive">
				  <table class="table table-dark">
				    <thead>
				      <tr>
				        <th scope="col">입고일자</th>
				        <th scope="col">트래킹번호</th>
				        <th scope="col">사서함번호</th>
				        <th scope="col">촬영사진</th>
				      </tr>
				    </thead>
				    <tbody>
				    	<?php if(!empty($nodata)): ?>
				    	<?php foreach($nodata as $value):?>
			    		<tr>
					        <td><?=$value->created_date?></td>
					        <td><?=$value->trackingNumber?></td>
					        <td>[나의 노데이타]</td>
					        <td>
					        	<a href="http://iza.izsolution.co.kr//UpFile/OrdFrgImg/FRG_17774_1_20190619204352.jpg" target="_Blank">
									<img src="<?=base_url().$value->image?>" style="width:100px; height:80px;">
								</a>
							</td>
			      		</tr>
				    	<?php endforeach;?>
				    	<?php endif;?>
				    </tbody>
				</table>
			</div>
		</div>
	</div>
</div>