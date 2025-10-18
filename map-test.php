<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8"/>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>지도 테스트</title>
	<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
	<style>
		* { margin: 0; padding: 0; box-sizing: border-box; }
		body { width: 100%; height: 100vh; font-family: Arial; }
		#map { width: 100%; height: 100%; }
	</style>
</head>
<body>
	<div id="map"></div>

	<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
	<script>
		console.log('페이지 로드됨');
		console.log('Leaflet:', typeof L);
		console.log('Map 요소:', document.getElementById('map'));

		// 지도 초기화
		const map = L.map('map', {
			touchZoom: true,
			tap: true,
			bounceAtZoomLimits: false
		}).setView([36.5, 127.5], 7);

		console.log('지도 초기화됨:', map);

		L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
			attribution: '© OpenStreetMap contributors',
			maxZoom: 19,
			minZoom: 6
		}).addTo(map);

		console.log('타일 레이어 추가됨');
	</script>
</body>
</html>
