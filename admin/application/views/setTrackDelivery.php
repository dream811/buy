<!DOCTYPE html>
<html>
<head>
	<title></title>
    <link href="<?php echo base_url(); ?>assets/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />    
    <link href="<?php echo base_url(); ?>assets/dist/css/admin.css" rel="stylesheet" type="text/css" />	
    <script src="<?php echo base_url(); ?>assets/js/jQuery-2.1.4.min.js"></script>
</head>
<body style="background: none;">
   <div class="pop-title">
      <h3>운송장 등록</h3>
   </div>
   <div id="pop_wrap">
      <form method="post" class="boardSearchForm" name="frmIvcNo" id="frmIvcNo">
         <input type="hidden" name="ORD_SEQ" id="ORD_SEQ" value="<?=$sOrdSeq?>">
         <div>
            <table class="order_write order_table_top">
               <colgroup>
                  <col width="25%">
                  <col width="*">
               </colgroup>
               <tbody>
                  <tr>
                     <th>출고일자</th>
                     <td><input type="date" name="out_date" id="out_date" class="form-control" value="<?=date("Y-m-d")?>">	</td>
                  </tr>
                  <tr>
                     <th>운송장 번호</th>
                     <td><input type="text" name="tracking_number" id="tracking_number" maxlength="40" size="20" class="form-control" value="<?=$track[0]->tracking_number?>" required></td>
                  </tr>
               </tbody>
            </table>
            <div class="btn-area" style="text-align:center">
               <span class="whGraBtn_bg ty2">
               <button type="button" class="btn btn-sm btn-primary" onclick="fnIvcNoReg();">등록</button>
               </span>
               <span class="whGraBtn ty2">
               <button type="button" class="btn btn-sm btn-danger" onclick="window.close();">닫기</button>
               </span>
            </div>
         </div>
      </form>
   </div>
   <script type="text/javascript">
      function fnIvcNoReg() {
       
      	var frmObj  = "#frmIvcNo";
      	var fIptId  = "";
      	if($("#tracking_number").val()=="") {alert("항목이 비였습니다.");return;}
      	$(frmObj).attr("action", "./updateTrackNumber").attr("target", "");
      	$(frmObj).submit();
       
      }
      
   </script>
   <div class="panel combo-p" style="position: absolute; z-index: 10; display: none;">
      <div class="combo-panel panel-body panel-body-noheader" title="" id="" style="overflow: hidden;">
         <div class="datebox-calendar-inner">
            <div class="calendar" style="width: 176px; height: 176px;">
               <div class="calendar-header">
                  <div class="calendar-nav calendar-prevmonth"></div>
                  <div class="calendar-nav calendar-nextmonth"></div>
                  <div class="calendar-nav calendar-prevyear"></div>
                  <div class="calendar-nav calendar-nextyear"></div>
                  <div class="calendar-title"><span class="calendar-text">Sep 2019</span></div>
               </div>
               <div class="calendar-body" style="height: 154px;">
                  <table class="calendar-dtable" cellspacing="0" cellpadding="0" border="0">
                     <thead>
                        <tr>
                           <th>S</th>
                           <th>M</th>
                           <th>T</th>
                           <th>W</th>
                           <th>T</th>
                           <th>F</th>
                           <th>S</th>
                        </tr>
                     </thead>
                     <tbody>
                        <tr class="calendar-first">
                           <td class="calendar-day calendar-other-month calendar-sunday calendar-first " abbr="2019,8,25" style="">25</td>
                           <td class="calendar-day calendar-other-month " abbr="2019,8,26" style="">26</td>
                           <td class="calendar-day calendar-other-month " abbr="2019,8,27" style="">27</td>
                           <td class="calendar-day calendar-other-month " abbr="2019,8,28" style="">28</td>
                           <td class="calendar-day calendar-other-month " abbr="2019,8,29" style="">29</td>
                           <td class="calendar-day calendar-other-month " abbr="2019,8,30" style="">30</td>
                           <td class="calendar-day calendar-other-month calendar-saturday calendar-last " abbr="2019,8,31" style="">31</td>
                        </tr>
                        <tr class="">
                           <td class="calendar-day calendar-sunday calendar-first " abbr="2019,9,1" style="">1</td>
                           <td class="calendar-day " abbr="2019,9,2" style="">2</td>
                           <td class="calendar-day " abbr="2019,9,3" style="">3</td>
                           <td class="calendar-day " abbr="2019,9,4" style="">4</td>
                           <td class="calendar-day " abbr="2019,9,5" style="">5</td>
                           <td class="calendar-day " abbr="2019,9,6" style="">6</td>
                           <td class="calendar-day calendar-saturday calendar-last " abbr="2019,9,7" style="">7</td>
                        </tr>
                        <tr class="">
                           <td class="calendar-day calendar-sunday calendar-first " abbr="2019,9,8" style="">8</td>
                           <td class="calendar-day " abbr="2019,9,9" style="">9</td>
                           <td class="calendar-day " abbr="2019,9,10" style="">10</td>
                           <td class="calendar-day " abbr="2019,9,11" style="">11</td>
                           <td class="calendar-day " abbr="2019,9,12" style="">12</td>
                           <td class="calendar-day " abbr="2019,9,13" style="">13</td>
                           <td class="calendar-day calendar-saturday calendar-last " abbr="2019,9,14" style="">14</td>
                        </tr>
                        <tr class="">
                           <td class="calendar-day calendar-sunday calendar-first " abbr="2019,9,15" style="">15</td>
                           <td class="calendar-day calendar-today calendar-selected " abbr="2019,9,16" style="">16</td>
                           <td class="calendar-day " abbr="2019,9,17" style="">17</td>
                           <td class="calendar-day " abbr="2019,9,18" style="">18</td>
                           <td class="calendar-day " abbr="2019,9,19" style="">19</td>
                           <td class="calendar-day " abbr="2019,9,20" style="">20</td>
                           <td class="calendar-day calendar-saturday calendar-last " abbr="2019,9,21" style="">21</td>
                        </tr>
                        <tr class="">
                           <td class="calendar-day calendar-sunday calendar-first " abbr="2019,9,22" style="">22</td>
                           <td class="calendar-day " abbr="2019,9,23" style="">23</td>
                           <td class="calendar-day " abbr="2019,9,24" style="">24</td>
                           <td class="calendar-day " abbr="2019,9,25" style="">25</td>
                           <td class="calendar-day " abbr="2019,9,26" style="">26</td>
                           <td class="calendar-day " abbr="2019,9,27" style="">27</td>
                           <td class="calendar-day calendar-saturday calendar-last " abbr="2019,9,28" style="">28</td>
                        </tr>
                        <tr class="calendar-last">
                           <td class="calendar-day calendar-sunday calendar-first " abbr="2019,9,29" style="">29</td>
                           <td class="calendar-day " abbr="2019,9,30" style="">30</td>
                           <td class="calendar-day calendar-other-month " abbr="2019,10,1" style="">1</td>
                           <td class="calendar-day calendar-other-month " abbr="2019,10,2" style="">2</td>
                           <td class="calendar-day calendar-other-month " abbr="2019,10,3" style="">3</td>
                           <td class="calendar-day calendar-other-month " abbr="2019,10,4" style="">4</td>
                           <td class="calendar-day calendar-other-month calendar-saturday calendar-last " abbr="2019,10,5" style="">5</td>
                        </tr>
                     </tbody>
                  </table>
                  <div class="calendar-menu" style="display: none;">
                     <div class="calendar-menu-year-inner"><span class="calendar-nav calendar-menu-prev"></span><span><input class="calendar-menu-year" type="text"></span><span class="calendar-nav calendar-menu-next"></span></div>
                     <div class="calendar-menu-month-inner"></div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</body>
</html>