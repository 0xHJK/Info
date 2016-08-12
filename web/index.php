<!DOCTYPE html>
<html lang="zh-CN">
<head>
	<meta charset="UTF-8">
	<title>本机信息</title>
</head>
<body>
	<a id="geo" href="/geo.php"><button style="padding:10px;margin:10px 0;width:100%;">获取位置</button></a>
	<p>服务器端获取信息</p>
	<table border="1">
		<tr><td>HTTP_CLIENT_IP</td><td><?php echo $_SERVER['HTTP_CLIENT_IP'] ?></td></tr>
		<tr><td>HTTP_X_FORWARDED_FOR</td><td><?php echo $_SERVER['HTTP_X_FORWARDED_FOR'] ?></td></tr>
		<tr><td>REMOTE_ADDR</td><td><?php echo $_SERVER['REMOTE_ADDR'] ?></td></tr>
		<tr><td>REMOTE_PORT</td><td><?php echo $_SERVER['REMOTE_PORT'] ?></td></tr>
		<tr><td>HTTP_USER_AGENT</td><td><?php echo $_SERVER['HTTP_USER_AGENT'] ?></td></tr>
		<tr><td>HTTP_ACCEPT</td><td><?php echo $_SERVER['HTTP_ACCEPT'] ?></td></tr>
		<?php date_default_timezone_set('Asia/Shanghai'); ?>
		<tr><td>上海时间</td><td><?php echo date("Y-m-d  h:i:sa") ?></td></tr>
	</table>
	<p>IP数据</p>
	<table id="ip-info" border="1"></table>
	<p>屏幕信息</p>
	<table id="screen" border="1"></table>
	<p>客户端获取信息</p>
	<table id="client" border="1"></table>
	<script>
		function screenInfo(){
		   var  s = '';
		   s += '<tr><td>网页可见区域宽：</td><td>'+ document.body.clientWidth + '</td></tr>';
		   s += '<tr><td>网页可见区域高：</td><td>'+ document.body.clientHeight + '</td></tr>';
		   s += '<tr><td>网页可见区域宽：</td><td>'+ document.body.offsetWidth  +' (包括边线的宽)' + '</td></tr>';
		   s += '<tr><td>网页可见区域高：</td><td>'+ document.body.offsetHeight +' (包括边线的宽)' + '</td></tr>';
		   s += '<tr><td>网页正文全文宽：</td><td>'+ document.body.scrollWidth + '</td></tr>';
		   s += '<tr><td>网页正文全文高：</td><td>'+ document.body.scrollHeight + '</td></tr>';
		   s += '<tr><td>网页被卷去的高：</td><td>'+ document.body.scrollTop + '</td></tr>';
		   s += '<tr><td>网页被卷去的左：</td><td>'+ document.body.scrollLeft + '</td></tr>';
		   s += '<tr><td>网页正文部分上：</td><td>'+ window.screenTop + '</td></tr>';
		   s += '<tr><td>网页正文部分左：</td><td>'+ window.screenLeft + '</td></tr>';
		   s += '<tr><td>屏幕分辨率的高：</td><td>'+ window.screen.height + '</td></tr>';
		   s += '<tr><td>屏幕分辨率的宽：</td><td>'+ window.screen.width + '</td></tr>';
		   s += '<tr><td>屏幕可用工作区高度：</td><td>'+ window.screen.availHeight + '</td></tr>';
		   s += '<tr><td>屏幕可用工作区宽度：</td><td>'+ window.screen.availWidth + '</td></tr>';
		   var oScreen = document.getElementById('screen');
		   oScreen.innerHTML = s
		}

		function getNavi(){
			var s = ''
			for (nav in navigator) {
				s += '<tr><td>' + nav + '</td><td>' + navigator[nav] + '</td></tr>'
			}
			var oClient = document.getElementById('client')
			oClient.innerHTML = s
		}

		function setLink(x, y){
			oGeo = document.getElementById('geo');
			oGeo.href = '/geo.php?x=' + x + '&y=' + y;
		}

		function ajax(url, id, cb){
			var xhr = new XMLHttpRequest();
			xhr.open('GET', url);
			xhr.send(null);
			xhr.onreadystatechange = function(){
	      var obj = document.getElementById(id);
	      var s = obj.innerHTML
		    if(xhr.readyState === 4){
	        if(xhr.status === 200){
	        	var data = JSON.parse(xhr.responseText)
	        	for (i in data) { s += '<tr><td>' + i + '</td><td>' + data[i] + '</td></tr>' }
	        	obj.innerHTML = s
	        	cb(data.lng, data.lat)
	          console.log(data); // 这是返回的文本
	        } else{
	          obj.innerHTML = '获取失败'
	        }
		    }
			}
		}

		function getIpZishuo(){
			ajax('http://ip.zishuo.net/', 'ip-info', function(x, y){
				setLink(x, y);
			})
		}

		window.onload = function(){
			getNavi();
			screenInfo();
			getIpZishuo();
			window.onresize = function(e) {
				screenInfo();
			}
		}
	</script>
</body>
</html>