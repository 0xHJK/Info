<!DOCTYPE html>
<html lang="zh-CN">
<head>
	<meta charset="UTF-8">
	<title>本机信息</title>
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no, minimal-ui" />
	<style>
		table {width:100%; border-spacing: 0px; border-color: #ccc;}
		td {padding: 4px; font-size: 16px; word-break:break-all;}
	</style>
</head>
<body>
	<div class="container" style="position:relative;max-width:960px;margin:auto;">
		<a id="geo" href="/geo.php"><button style="padding:10px;margin:10px 0;width:100%;">地图展示</button></a>
		<button onclick="showMore()" style="padding:10px;margin:10px 0;width:100%;">更多信息</button>
		<button onclick="modeChange()" style="padding:10px;margin:10px 0;width:100%;">模式切换</button>
		<p>服务器端获取信息</p>
		<table border="1">
			<?php date_default_timezone_set('Asia/Shanghai'); ?>
			<tr><td>TIME</td><td><?php echo date("Y-m-d  h:i:sa") ?></td></tr>
			<tr><td>REMOTE_ADDR</td><td><?php echo $_SERVER['REMOTE_ADDR'] ?></td></tr>
			<tr><td>REMOTE_PORT</td><td><?php echo $_SERVER['REMOTE_PORT'] ?></td></tr>
			<tr><td>HTTP_USER_AGENT</td><td><?php echo $_SERVER['HTTP_USER_AGENT'] ?></td></tr>
			<tr><td>HTTP_ACCEPT</td><td><?php echo $_SERVER['HTTP_ACCEPT'] ?></td></tr>
			<?php 
			if ($_SERVER['HTTP_CLIENT_IP'] != '') {
				echo '<tr><td>HTTP_CLIENT_IP</td><td>' + $_SERVER['HTTP_CLIENT_IP'] + '</td></tr>';
			}
			if ($_SERVER['HTTP_X_FORWARDED_FOR'] != '') {
				echo '<tr><td>HTTP_X_FORWARDED_FOR</td><td>' + $_SERVER['HTTP_X_FORWARDED_FOR'] + '</td></tr>';
			}
			?>
		</table>
		<p>IP数据</p>
		<table id="ip-info" border="1"></table>
		<p>屏幕信息</p>
		<table id="screen" border="1"></table>
		<p>客户端获取信息</p>
		<table id="client" border="1"></table>
	</div>
	<script>
		function getScreenBase(){
			var oScreen = document.getElementById('screen');
			var s = '';
			s += '<tr><td>screen.height</td><td>'+ window.screen.height + '</td></tr>';
			s += '<tr><td>screen.width</td><td>'+ window.screen.width + '</td></tr>';
			s += '<tr><td>screen.availHeight</td><td>'+ window.screen.availHeight + '</td></tr>';
			s += '<tr><td>screen.availWidth</td><td>'+ window.screen.availWidth + '</td></tr>';
			s += '<tr><td>body.clientWidth</td><td>'+ document.body.clientWidth + '</td></tr>';
			s += '<tr><td>body.clientHeight</td><td>'+ document.body.clientHeight + '</td></tr>';
			oScreen.innerHTML = s
		}
		function getScreenMore(){
			getScreenBase()
			var oScreen = document.getElementById('screen');
			var s = oScreen.innerHTML;
			s += '<tr><td>offsetWidth</td><td>'+ document.body.offsetWidth  +' (包括边线的宽)' + '</td></tr>';
			s += '<tr><td>offsetHeight</td><td>'+ document.body.offsetHeight +' (包括边线的宽)' + '</td></tr>';
			s += '<tr><td>scrollWidth</td><td>'+ document.body.scrollWidth + '</td></tr>';
			s += '<tr><td>scrollHeight</td><td>'+ document.body.scrollHeight + '</td></tr>';
			s += '<tr><td>scrollTop</td><td>'+ document.body.scrollTop + '</td></tr>';
			s += '<tr><td>scrollLeft</td><td>'+ document.body.scrollLeft + '</td></tr>';
			s += '<tr><td>window.screenTop</td><td>'+ window.screenTop + '</td></tr>';
			s += '<tr><td>window.screenLeft</td><td>'+ window.screenLeft + '</td></tr>';
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

		function ajax(url, cb){
			var xhr = new XMLHttpRequest();
			xhr.open('GET', url);
			xhr.send(null);
			xhr.onreadystatechange = function(){
		    if(xhr.readyState === 4){
	        if(xhr.status === 200){
	        	cb(JSON.parse(xhr.responseText));
	        } else{
	          alert('IP数据获取失败');
	        }
		    }
			}
		}

		function getIpZishuo(){
			var obj = document.getElementById('ip-info');
			var s = obj.innerHTML;
			ajax('http://ip.zishuo.net/', function(data){
				s += '<tr><td>Message</td><td>' + data.message + '</td></tr>';
				s += '<tr><td>IP</td><td>' + data.ip + '</td></tr>';
				s += '<tr><td>lng</td><td>' + data.lng + '</td></tr>';
				s += '<tr><td>lat</td><td>' + data.lat + '</td></tr>';
				s += '<tr><td>City</td><td>' + data.country + ' ' + data.province + ' ' + data.city + ' ' + data.district + '</td></tr>'
				s += '<tr><td>Address</td><td>' + data.desc + '</td></tr>';
				s += '<tr><td>position</td><td>' + data.position + '</td></tr>';
				obj.innerHTML = s;
				setLink(data.lng, data.lat);
			})
		}

		function showMore(){
			getNavi();
			getScreenMore();
		}

		function modeChange(){
			var oMeta = document.getElementsByTagName('meta')[1];
			var sMeta = 'width=device-width, initial-scale=1, user-scalable=no, minimal-ui';
			if (oMeta.getAttribute('content') === ''){
				oMeta.setAttribute('content', sMeta);
			} else {
				oMeta.setAttribute('content', '');
			}
		}

		window.onload = function(){
			getScreenBase();
			getIpZishuo();
			window.onresize = function(e) {
				getScreenMore();
			}
		}
	</script>
</body>
</html>