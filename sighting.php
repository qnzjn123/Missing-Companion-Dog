<?php header('Content-Type: text/html; charset=utf-8'); ?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8"/>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>목격 제보하기</title>
	<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
	<style>
		* { margin: 0; padding: 0; box-sizing: border-box; }
		body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: #f5f7fa; }
		.header {
			background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
			color: white;
			padding: 20px;
			text-align: center;
			box-shadow: 0 2px 10px rgba(0,0,0,0.1);
		}
		.header h1 { font-size: 28px; margin-bottom: 5px; }
		.back-btn {
			position: fixed;
			top: 20px;
			left: 20px;
			background: white;
			color: #667eea;
			border: none;
			padding: 10px 20px;
			border-radius: 8px;
			cursor: pointer;
			font-weight: bold;
			box-shadow: 0 2px 10px rgba(0,0,0,0.1);
			z-index: 101;
		}
		.back-btn:hover { background: #f0f0f0; }
		.container {
			max-width: 900px;
			margin: 20px auto;
			padding: 0 20px;
		}
		.content {
			display: grid;
			grid-template-columns: 1fr 1fr;
			gap: 20px;
		}
		.form-section {
			background: white;
			border-radius: 10px;
			padding: 25px;
			box-shadow: 0 2px 10px rgba(0,0,0,0.05);
		}
		.map-section {
			background: white;
			border-radius: 10px;
			overflow: hidden;
			box-shadow: 0 2px 10px rgba(0,0,0,0.05);
		}
		#map { height: 500px; width: 100%; }
		.form-section h2 {
			color: #667eea;
			margin-bottom: 20px;
			border-bottom: 2px solid #667eea;
			padding-bottom: 10px;
		}
		.form-group {
			margin-bottom: 15px;
		}
		.form-group label {
			display: block;
			margin-bottom: 6px;
			font-weight: bold;
			color: #333;
			font-size: 13px;
		}
		.form-group input,
		.form-group textarea,
		.form-group select {
			width: 100%;
			padding: 10px;
			border: 1px solid #ddd;
			border-radius: 6px;
			font-size: 13px;
			font-family: Arial, sans-serif;
		}
		.form-group input:focus,
		.form-group textarea:focus,
		.form-group select:focus {
			outline: none;
			border-color: #667eea;
			box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
		}
		.form-group textarea { min-height: 100px; resize: vertical; }
		.form-row {
			display: grid;
			grid-template-columns: 1fr 1fr;
			gap: 10px;
		}
		.photo-preview {
			margin-top: 10px;
			max-width: 100%;
		}
		.photo-preview img {
			max-width: 100%;
			max-height: 150px;
			border-radius: 6px;
		}
		.btn {
			width: 100%;
			padding: 12px;
			border: none;
			border-radius: 8px;
			font-weight: bold;
			cursor: pointer;
			transition: all 0.3s;
			font-size: 14px;
		}
		.btn-primary {
			background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
			color: white;
			margin-top: 20px;
		}
		.btn-primary:hover {
			transform: translateY(-2px);
			box-shadow: 0 10px 25px rgba(102, 126, 234, 0.3);
		}
		.info-box {
			background: #e8f4f8;
			border-left: 4px solid #4ecdc4;
			padding: 12px;
			border-radius: 6px;
			margin-bottom: 15px;
			font-size: 12px;
			color: #333;
		}
		.map-info {
			padding: 15px;
			background: #f8f9fa;
			font-size: 12px;
			color: #666;
		}
		.error-message {
			background: #f8d7da;
			color: #721c24;
			padding: 12px;
			border-radius: 6px;
			margin-bottom: 15px;
			display: none;
		}
		.success-message {
			background: #d4edda;
			color: #155724;
			padding: 12px;
			border-radius: 6px;
			margin-bottom: 15px;
			display: none;
		}
		.loading {
			display: none;
			text-align: center;
			padding: 10px;
		}
		.spinner {
			border: 3px solid #f3f3f3;
			border-top: 3px solid #667eea;
			border-radius: 50%;
			width: 20px;
			height: 20px;
			animation: spin 1s linear infinite;
			margin: 0 auto;
		}
		@keyframes spin {
			0% { transform: rotate(0deg); }
			100% { transform: rotate(360deg); }
		}

		/* 모바일 반응형 */
		@media (max-width: 768px) {
			.header h1 { font-size: 20px; }
			.back-btn { top: 10px; left: 10px; padding: 8px 15px; font-size: 12px; }
			.container { margin: 10px auto; padding: 0 10px; }
			.content {
				grid-template-columns: 1fr;
				gap: 15px;
			}
			#map { height: 300px; }
			.form-section { padding: 15px; }
			.form-row {
				grid-template-columns: 1fr;
			}
		}
	</style>
</head>
<body>
	<script>
		// 로그인 확인
		if (!localStorage.getItem('user_id')) {
			window.location.href = 'auth.php';
		}
	</script>
	<button class="back-btn" onclick="history.back()">← 돌아가기</button>

	<div class="header">
		<h1>👁️ 목격 제보하기</h1>
	</div>

	<div class="container">
		<div class="content">
			<div class="form-section">
				<h2>제보 정보</h2>

				<div class="error-message" id="error-message"></div>
				<div class="success-message" id="success-message"></div>

				<div class="info-box">
					💡 신속한 제보는 반려동물을 찾는 데 매우 중요합니다!
				</div>

				<form id="sighting-form">
					<div class="form-group">
						<label for="title">제목 *</label>
						<input type="text" id="title" name="title" required 
							placeholder="예: 인천 남동구 센트럴 공원 근처에서 갈색 푸들 목격">
					</div>

					<div class="form-row">
						<div class="form-group">
							<label for="breed">품종 *</label>
							<input type="text" id="breed" name="breed" required
								placeholder="예: 푸들, 진도개, 고양이 등">
						</div>
						<div class="form-group">
							<label for="color">색상 *</label>
							<input type="text" id="color" name="color" required
								placeholder="예: 갈색, 흰색 등">
						</div>
					</div>

					<div class="form-group">
						<label for="description">상세 설명 *</label>
						<textarea id="description" name="description" required
							placeholder="어디서 언제 목격했는지, 그때의 상황(혼자인지 함께 있는 다른 동물이 있는지 등)을 최대한 자세히 작성해주세요."></textarea>
					</div>

					<div class="form-group">
						<label for="location">위치명 (지도에서 선택)</label>
						<input type="text" id="location" name="location" readonly
							placeholder="지도에서 위치를 클릭하세요">
					</div>

					<div class="form-row">
						<div class="form-group">
							<label for="phone">연락처 *</label>
							<input type="tel" id="phone" name="phone" required
								placeholder="010-1234-5678">
						</div>
						<div class="form-group">
							<label for="date">목격 날짜 *</label>
							<input type="date" id="date" name="date" required>
						</div>
					</div>

					<div class="form-group">
						<label for="time">목격 시간</label>
						<input type="time" id="time" name="time">
					</div>

					<div class="form-group">
						<label for="photo">사진 (선택)</label>
						<input type="file" id="photo" name="photo" accept="image/*">
						<div class="photo-preview" id="photo-preview"></div>
					</div>

					<button type="submit" class="btn btn-primary">
						<span id="submit-text">제보 제출</span>
						<span class="loading" id="submit-loading"><div class="spinner"></div></span>
					</button>
				</form>
			</div>

			<div class="map-section">
				<div id="map"></div>
				<div class="map-info">
					지도에서 목격 위치를 클릭하세요. 마커를 드래그하여 위치를 조정할 수 있습니다.
					<div style="margin-top: 10px;">
						<strong>선택된 위치:</strong> <span id="coordinates">선택 안 됨</span>
					</div>
				</div>
			</div>
		</div>
	</div>

	<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
	<script>
		document.addEventListener('DOMContentLoaded', function() {
			// 지도 초기화 (한국 전체 보기)
			const map = L.map('map', {
				touchZoom: true,
				tap: true,
				bounceAtZoomLimits: false
			}).setView([36.5, 127.5], 7);
			
			L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
				attribution: '© OpenStreetMap contributors',
				maxZoom: 19,
				minZoom: 6
			}).addTo(map);

			let marker = null;
			let selectedLat = null;
			let selectedLng = null;

			// 터치 장치에 대한 마커 영역 확대
			const markerOptions = {
				draggable: true,
				icon: L.icon({
					iconUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/images/marker-icon.png',
					iconRetinaUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/images/marker-icon-2x.png',
					shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/images/marker-shadow.png',
					iconSize: [25, 41],
					iconAnchor: [12, 41],
					popupAnchor: [1, -34],
					shadowSize: [41, 41]
				})
			};

			// 지도 클릭 시 마커 추가 (데스크톱)
			map.on('click', function(e) {
				addMarkerAtLocation(e.latlng);
			});

			// 터치 이벤트 처리
			const mapContainer = document.getElementById('map');
			mapContainer.addEventListener('touchend', function(e) {
				if (e.touches.length === 0) {
					const touch = e.changedTouches[0];
					const rect = mapContainer.getBoundingClientRect();
					const x = touch.clientX - rect.left;
					const y = touch.clientY - rect.top;
					
					// 마우스 이벤트로 변환
					const latlng = map.containerPointToLatLng([x, y]);
					addMarkerAtLocation(latlng);
				}
			}, false);

			function addMarkerAtLocation(latlng) {
				selectedLat = latlng.lat;
				selectedLng = latlng.lng;

				if (marker) {
					map.removeLayer(marker);
				}

				marker = L.marker([selectedLat, selectedLng], markerOptions)
					.addTo(map)
					.bindPopup('목격 위치<br>' + selectedLat.toFixed(4) + ', ' + selectedLng.toFixed(4))
					.openPopup();

				marker.on('dragend', function() {
					const latlng = marker.getLatLng();
					selectedLat = latlng.lat;
					selectedLng = latlng.lng;
					updateCoordinates();
				});

				updateCoordinates();
				map.setView([selectedLat, selectedLng], map.getZoom());
			}

			function updateCoordinates() {
				document.getElementById('coordinates').textContent = 
					`위도: ${selectedLat.toFixed(4)}, 경도: ${selectedLng.toFixed(4)}`;
			}

			// 사진 미리보기
			document.getElementById('photo').addEventListener('change', function(e) {
				const file = e.target.files[0];
			if (file) {
				const reader = new FileReader();
				reader.onload = function(event) {
					const preview = document.getElementById('photo-preview');
					preview.innerHTML = '<img src="' + event.target.result + '" alt="사진 미리보기">';
				};
				reader.readAsDataURL(file);
			}
		});

		// 오늘 날짜 설정
		document.getElementById('date').valueAsDate = new Date();

		// 폼 제출
		document.getElementById('sighting-form').addEventListener('submit', async function(e) {
			e.preventDefault();

			// 로그인 확인
			const userId = localStorage.getItem('user_id');
			if (!userId) {
				showError('로그인이 필요합니다. 로그인 페이지로 이동하시겠습니까?');
				setTimeout(() => {
					window.location.href = 'auth.php';
				}, 2000);
				return;
			}

			if (!selectedLat || !selectedLng) {
				showError('지도에서 위치를 선택해주세요.');
				return;
			}

			const title = document.getElementById('title').value;
			const breed = document.getElementById('breed').value;
			const color = document.getElementById('color').value;
			const description = document.getElementById('description').value;
			const phone = document.getElementById('phone').value;
			const location = document.getElementById('location').value;
			const time = document.getElementById('time').value;

			let imageData = '';
			const photoFile = document.getElementById('photo').files[0];
			if (photoFile) {
				imageData = await fileToBase64(photoFile);
			}

			document.getElementById('submit-loading').style.display = 'inline';
			document.getElementById('submit-text').style.display = 'none';

			try {
				const response = await fetch('api.php?action=saveReport', {
					method: 'POST',
					headers: {
						'Content-Type': 'application/json'
					},
					body: JSON.stringify({
						type: 'sighting',
						title: title,
						breed: breed,
						color: color,
						description: description + (time ? '\n목격 시간: ' + time : ''),
						phone: phone,
						location: location,
						latitude: selectedLat,
						longitude: selectedLng,
						image: imageData
					})
				});

				const data = await response.json();

				if (response.ok && data.success) {
					showSuccess('목격 제보가 등록되었습니다! 메인 페이지로 이동합니다.');
					setTimeout(() => {
						window.location.href = 'index.php';
					}, 2000);
				} else {
					showError(data.error || '제보 등록 실패');
				}
			} catch (error) {
				showError('네트워크 오류: ' + error.message);
			} finally {
				document.getElementById('submit-loading').style.display = 'none';
				document.getElementById('submit-text').style.display = 'inline';
			}
		});

		function showError(message) {
			const errorEl = document.getElementById('error-message');
			errorEl.textContent = message;
			errorEl.style.display = 'block';
			setTimeout(() => {
				errorEl.style.display = 'none';
			}, 5000);
		}

		function showSuccess(message) {
			const successEl = document.getElementById('success-message');
			successEl.textContent = message;
			successEl.style.display = 'block';
		}

		function fileToBase64(file) {
			return new Promise((resolve, reject) => {
				const reader = new FileReader();
				reader.onload = () => resolve(reader.result);
				reader.onerror = reject;
				reader.readAsDataURL(file);
			});
		}
		});
	</script>
</body>
</html>
