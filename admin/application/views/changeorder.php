<!DOCTYPE html>
<html>
<head>
	<title></title>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/2.3.0/socket.io.js"></script>
</head>
<body>

</body>
</html>
<script>
	var	socket = io.connect('http://taodalin.com:8081');
	var arr_passed = "123";
	var arr_id = "";

		debugger;
		// debugger;
		if(arr_passed.trim() != ""){
			socket.on('connect', function(){
			    socket.emit("chat message",30,arr_passed,0,"waiting-out","쇼핑몰");
			    location.href="/admin/dashboard?step=16";
			});
			
		}

		if(arr_id.trim() != ""){
			alert("입고완료상태가 아닌 주문이 포함되여 있습니다.주문번호는 "+arr_id+"입니다.");
			location.href="/admin/dashboard?step=16";
		}

		if(arr_passed.trim() =="" && arr_id.trim() ==""){
			location.href="/admin/dashboard?step=16";
		}


</script>