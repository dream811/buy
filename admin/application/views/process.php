<script type="text/javascript">
    var baseURL = "<?php echo base_url(); ?>";
</script>
<html>
    <head>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/2.3.0/socket.io.js"></script>
        <script>
            var socket = io.connect('http://121.254.254.216:8081');
            <?php if(sizeof(explode(",",$this->input->get("alert"))) > 0):  ?>
                alert("입고완료되지 않은 상품이 신청되였습니다.\n 주문번호는 <?=$this->input->get("alert")?>입니다");
            <?php endif; ?>
            <?php if(sizeof(explode(",",$this->input->get("completed"))) > 0):  ?>
                socket.emit("chat message",1,"<?=$this->input->get("completed")?>","0","output","");
                location.href=baseURL+"dashboard?step=16";
            <?php endif; ?>
            <?php if(sizeof(explode(",",$this->input->get("completed"))) == 0):  ?>
                alert("신청한 모든 주문의 상품들이 입고완료되지 않았습니다.");
                location.href=baseURL+"dashboard?step=7";
            <?php endif; ?>
        </script>
    </head>
</html>