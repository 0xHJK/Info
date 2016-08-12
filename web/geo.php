<!DOCTYPE html>
<html lang="zh-CN">
<head>
	<meta charset="UTF-8">
	<title>地理位置信息</title>
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no, minimal-ui" />
	<script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=IGTbHNdRcTUc9KtD92QD7rIBdqzNGl7z"></script>
</head>
<body>
	<button onclick="getGPS()" style="padding:10px;margin:10px 0;width:100%;">获取GPS位置</button>
	<div id="info"></div>
	<div id="map" style="width:100%;min-height:400px;height:100%;"></div>
	<script>
		function getmap(x, y, id){
			var map = new BMap.Map(id);   
			var point = new BMap.Point(x, y);
			map.centerAndZoom(point, 15);
			var marker = new BMap.Marker(point);
			map.addOverlay(marker);
			map.addControl(new BMap.NavigationControl());
			map.addControl(new BMap.ScaleControl());    
			map.addControl(new BMap.OverviewMapControl());    
			map.addControl(new BMap.MapTypeControl());
		}

		function getGPS() {
		  var info =  document.getElementById('info');
		  if (!navigator.geolocation){
		    info.innerHTML = '不支持获取位置';
		    return;
		  }
		  function success(position) {
		    var longitude = position.coords.longitude;
		    var latitude  = position.coords.latitude;
		    info.innerHTML = '<p>Latitude is ' + latitude + '° <br>Longitude is ' + longitude + '°</p>';
		    getmap(longitude, latitude, 'map')
		  };
		  function error() {
		    info.innerHTML = '获取不到位置';
		  }
		  info.innerHTML = '<p>定位中……</p>';
		  navigator.geolocation.getCurrentPosition(success, error);
		}

		window.onload = function(){
			var x = '<?php echo $_GET['x'] ?>';
			var y = '<?php echo $_GET['y'] ?>';
			getmap(x, y, 'map');
		}
	</script>
</body>
</html>