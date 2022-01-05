<?php ini_set('user_agent', 'Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/85.0.4183.121 Safari/537.36'); ?> 
<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
<iframe src="https://cart.taobao.com/cart.htm" title="W3Schools Free Online Web Tutorials" style="width: 100%;height: 100vh"></iframe>

</body>
</html>
<script type="text/javascript">
	function setUserAgent(window, userAgent) {
    if (navigator.userAgent != userAgent) {
        var userAgentProp = { get: function () { return userAgent; } };
        try {
            Object.defineProperty(navigator, 'userAgent', userAgentProp);
        } catch (e) {
            navigator = Object.create(navigator, {
                userAgent: userAgentProp
            });
        }
    }
}
// setUserAgent(document.querySelector('iframe').contentWindow, 'Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/85.0.4183.121 Safari/537.36');
</script>