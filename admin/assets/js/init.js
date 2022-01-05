var socket = io("http://taodalin.com:8081");
    socket.on('chat message', function(msg1,msg2,msg3,msg4,msg5){
      var url = "";
      var message ="";
      if(msg4=="delivery")
      {
        var message = msg5+"님이 배송신청을 하였습니다. 주문번호는 "+msg2+"입니다";
        url = "/admin/dashboard?search_id="+msg2;
      }
      if(msg4=="buy")
      {
        var message = msg5+"님이 구매신청을 하였습니다.주문번호는 "+msg2+"입니다"; 
        url = "/admin/dashboard?search_id="+msg2;
      }
      if(msg4=="shop")
      {
        var message = msg5+"님이 쇼핑몰구매신청을 하였습니다.주문번호는 "+msg2+"입니다"; 
        url = "/admin/dashboard?search_id="+msg2;
      }
      if(msg4=="0")
      {
        var message = msg5+"님이 예치금 전액 결제를  하였습니다.주문번호는 "+msg2+"입니다"; 
        url = "/admin/dashboard?search_id="+msg2;
      }
      if(msg4=="1")
      {
        var message = msg5+"님이 무통장 입금을 하였습니다.주문번호는 "+msg2+"입니다"; 
       url = "/admin/dashboard?search_id="+msg2;
      }

      if(msg4=="deposit")
      {
        var message = msg5+"님이 예치금을 신청하였습니다."; 
        url = "/admin/registerDeposit?content="+msg5+"&type=name";  
      }

      if(msg4=="reqdelivery")
      {
        var message = msg5+"님이 배송요청을 하였습니다.주문번호는 "+msg2+"입니다"; 
        
         url = "/admin/dashboard?search_id="+msg2;
      }

      if(msg4=="reqdelivery_plus")
      {
        var message = msg5+"님이 묶음배송요청을 하였습니다.주문번호는 "+msg2+"입니다"; 
        
         url = "/admin/dashboard?search_id="+msg2;
      }


      if(msg4=="reqdelivery_minus")
      {
        var message = msg5+"님이 나눔배송요청을 하였습니다.주문번호는 "+msg2+"입니다"; 
        
         url = "/admin/dashboard?search_id="+msg2;
      }


      if(msg1 =="7")
      {
        var message = msg5+"님이 댓글을 남겻습니다.";
        var msg2= msg2.split("$!$");
        url = "/admin/viewReq/"+msg2[2]+"?board_type="+msg2[1];
      }

      if(msg1 =="30")
      {
        var message = "쇼핑몰 상품 출고대기 입니다.";
        url = "/admin/dashboard?search_id="+msg2;
      }

      $("#notice_count").text(parseInt($("#notice_count").text())+1);
      $("#notice_count").addClass("text-danger blink blink-two");
      $.notify({
        message: message,
        url: url
      });
  });