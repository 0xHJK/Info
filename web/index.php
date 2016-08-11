<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>本机信息</title>
</head>
<body>
	<p>服务器端获取信息</p>
	<table border="1">
		<tr>
			<td>HTTP_CLIENT_IP</td>
			<td><?php echo $_SERVER['HTTP_CLIENT_IP'] ?></td>
		</tr>
		<tr>
			<td>HTTP_X_FORWARDED_FOR</td>
			<td><?php echo $_SERVER['HTTP_X_FORWARDED_FOR'] ?></td>
		</tr>
		<tr>
			<td>REMOTE_ADDR</td>
			<td><?php echo $_SERVER['REMOTE_ADDR'] ?></td>
		</tr>
		<tr>
			<td>REMOTE_PORT</td>
			<td><?php echo $_SERVER['REMOTE_PORT'] ?></td>
		</tr>
		<tr>
			<td>HTTP_USER_AGENT</td>
			<td><?php echo $_SERVER['HTTP_USER_AGENT'] ?></td>
		</tr>
		<tr>
			<td>HTTP_ACCEPT</td>
			<td><?php echo $_SERVER['HTTP_ACCEPT'] ?></td>
		</tr>
	</table>
	<p>客户端获取信息</p>
	<table id="client" border="1"></table>
	<div id="out"></div>
	<button onclick="geoFindMe()">GET</button>
	<script>
		// window.onload = function(){
			oClient = document.getElementById('client')
			sHtml = ''
			for (nav in navigator) {
				sHtml += '<tr><td>' + nav + '</td><td>' + navigator[nav] + '</td></tr>'
			}
			oClient.innerHTML = sHtml

			function geoFindMe() {
			  var output = document.getElementById("out");

			  if (!navigator.geolocation){
			    output.innerHTML = "<p>Geolocation is not supported by your browser</p>";
			    return;
			  }

			  function success(position) {
			    var latitude  = position.coords.latitude;
			    var longitude = position.coords.longitude;

			    output.innerHTML = '<p>Latitude is ' + latitude + '° <br>Longitude is ' + longitude + '°</p>';

			    var img = new Image();
			    img.src = "https://maps.googleapis.com/maps/api/staticmap?center=" + latitude + "," + longitude + "&zoom=13&size=300x300&sensor=false";

			    output.appendChild(img);
			  };

			  function error() {
			    output.innerHTML = "Unable to retrieve your location";
			  };

			  output.innerHTML = "<p>Locating…</p>";

			  navigator.geolocation.getCurrentPosition(success, error);
			}
			// geoFindMe();
		// }

	</script>
</body>
</html>