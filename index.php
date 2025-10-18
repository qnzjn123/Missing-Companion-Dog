<?php
// PHP 설정 로드
require_once 'config.php';
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8"/>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>반려동물 강아지 실종 지도</title>
	<link rel="icon" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><text y='75' font-size='75'>🐕</text></svg>">
	<style>
		* { margin: 0; padding: 0; box-sizing: border-box; }
		body { width: 100%; height: 100vh; font-family: Arial; }
		.container { display: flex; width: 100%; height: 100%; }
		#map { flex: 1; height: 100%; }
		.user-menu { position: absolute; top: 15px; right: 15px; display: flex; gap: 10px; z-index: 100; }
		.user-btn { padding: 10px 15px; background: white; border: 1px solid #ddd; border-radius: 5px; cursor: pointer; font-weight: bold; font-size: 13px; transition: all 0.3s; }
		.user-btn:hover { background: #f5f5f5; border-color: #999; }
		.user-btn.logout { background: #ff6b6b; color: white; border: none; }
		.user-btn.logout:hover { background: #ff5252; }
		.sidebar { width: 350px; background: #f5f5f5; border-right: 1px solid #ddd; overflow-y: auto; padding: 20px; }
		.tab-buttons { display: flex; gap: 10px; margin-bottom: 20px; }
		.tab-btn { flex: 1; padding: 10px; background: #e0e0e0; border: none; border-radius: 4px; cursor: pointer; font-weight: bold; }
		.tab-btn.active { background: #ff6b6b; color: white; }
		.tab-content { display: none; }
		.tab-content.active { display: block; }
		h2 { margin-bottom: 15px; font-size: 16px; }
		.info-text { background: #fff3cd; padding: 10px; border-radius: 4px; margin-bottom: 15px; font-size: 12px; }
		.form-group { margin-bottom: 12px; }
		.form-group label { display: block; margin-bottom: 4px; font-weight: bold; font-size: 12px; }
		.form-group input, .form-group textarea { width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px; font-size: 12px; font-family: Arial; }
		.form-group textarea { min-height: 60px; }
		.btn { width: 100%; padding: 10px; background: #ff6b6b; color: white; border: none; border-radius: 4px; cursor: pointer; font-weight: bold; }
		.btn:hover { background: #ff5252; }
		.marker-list { margin-top: 20px; }
		.marker-list h3 { font-size: 13px; margin-bottom: 10px; }
		.marker-item { background: white; border: 1px solid #ddd; padding: 8px; margin-bottom: 8px; cursor: pointer; border-radius: 4px; }
		.marker-item:hover { background: #ffe6e6; }
		.marker-item h4 { font-size: 11px; color: #ff6b6b; margin-bottom: 3px; }
		.marker-item p { font-size: 10px; color: #666; margin: 2px 0; }
		#photoPreview img { max-width: 100%; max-height: 100px; margin-top: 8px; }
		.filter-section { background: white; padding: 12px; border-radius: 4px; margin-bottom: 15px; border: 1px solid #ddd; }
		.filter-section h4 { font-size: 12px; font-weight: bold; margin-bottom: 8px; }
		.filter-row { margin-bottom: 8px; }
		.filter-row input { width: 100%; padding: 6px; border: 1px solid #ddd; border-radius: 3px; font-size: 11px; }
		.filter-buttons { display: flex; gap: 5px; margin-top: 8px; }
		.filter-btn { flex: 1; padding: 6px; background: #4ecdc4; color: white; border: none; border-radius: 3px; cursor: pointer; font-size: 11px; font-weight: bold; }
		.filter-btn:hover { background: #3bb8a8; }
		.filter-btn.reset { background: #999; }
		.filter-btn.reset:hover { background: #888; }
		.stats { background: #f0f8ff; padding: 10px; border-radius: 4px; margin-bottom: 12px; font-size: 11px; }
		.stats p { margin: 3px 0; }
		.time-filter { display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 5px; margin-top: 8px; }
		.time-filter input { padding: 6px; border: 1px solid #ddd; border-radius: 3px; font-size: 10px; }
		.alert-section { background: #fff3e0; padding: 12px; border-radius: 4px; margin-bottom: 15px; border: 1px solid #ffb74d; }
		.alert-section h4 { font-size: 12px; font-weight: bold; margin-bottom: 8px; color: #e65100; }
		.alert-item { background: white; padding: 8px; border-left: 4px solid #ff6b6b; margin-bottom: 8px; border-radius: 3px; font-size: 11px; }
		.alert-item p { margin: 3px 0; }
		.close-alert { float: right; cursor: pointer; color: #999; font-weight: bold; }
		.notification { position: fixed; top: 20px; right: 20px; background: #ff6b6b; color: white; padding: 15px 20px; border-radius: 4px; box-shadow: 0 2px 10px rgba(0,0,0,0.2); z-index: 9999; animation: slideIn 0.3s ease-in; }
		@keyframes slideIn { from { transform: translateX(400px); opacity: 0; } to { transform: translateX(0); opacity: 1; } }
		@keyframes pulse { 0%, 100% { box-shadow: 0 0 0 0 rgba(78, 205, 196, 0.7); } 50% { box-shadow: 0 0 0 6px rgba(78, 205, 196, 0); } }
		.notification.success { background: #4ecdc4; }
		.notification.info { background: #2196F3; }
		.online-users-section { background: white; padding: 12px; border-radius: 4px; margin-bottom: 15px; border: 1px solid #ddd; }
		.online-users-section h4 { font-size: 12px; font-weight: bold; margin-bottom: 8px; color: #333; }
		.online-user-item { display: flex; align-items: center; gap: 8px; padding: 8px; background: #f8f9fa; border-radius: 4px; margin-bottom: 6px; font-size: 11px; transition: all 0.3s ease; }
		.online-user-item:hover { background: #f0f0f0; }
		.online-user-item:last-child { margin-bottom: 0; }
		.user-status-dot { width: 8px; height: 8px; background: #4ecdc4; border-radius: 50%; }
		.user-status-dot.offline { background: #ddd; }
		.user-name { flex: 1; font-weight: bold; color: #333; }
		.user-time { color: #999; font-size: 10px; }

		/* 모바일 반응형 디자인 */
		@media (max-width: 768px) {
			body { width: 100%; height: 100vh; font-family: Arial; overflow: hidden; }
			.container { display: flex; flex-direction: column; width: 100%; height: 100%; }
			#map { flex: 1; height: 100%; width: 100%; }
			.sidebar { 
				position: fixed; 
				bottom: 0; 
				left: 0; 
				right: 0;
				width: 100%; 
				height: 0;
				max-height: 0;
				background: #f5f5f5; 
				border-right: none; 
				border-top: 1px solid #ddd; 
				overflow-y: auto; 
				padding: 12px; 
				order: 2; 
				transition: max-height 0.3s ease, height 0.3s ease;
				z-index: 50;
			}
			.sidebar.mobile-open { 
				height: 60vh;
				max-height: 60vh;
			}
			
			.mobile-toggle-btn {
				position: fixed;
				bottom: 20px;
				right: 20px;
				width: 60px;
				height: 60px;
				background: #ff6b6b;
				color: white;
				border: none;
				border-radius: 50%;
				font-size: 24px;
				cursor: pointer;
				z-index: 99;
				box-shadow: 0 2px 10px rgba(0,0,0,0.3);
				transition: all 0.3s ease;
			}
			.mobile-toggle-btn:active { transform: scale(0.95); }
			
			.user-menu { position: fixed; top: 10px; right: 10px; display: flex; gap: 5px; z-index: 100; flex-wrap: wrap; }
			.user-btn { padding: 8px 12px; background: white; border: 1px solid #ddd; border-radius: 5px; cursor: pointer; font-weight: bold; font-size: 11px; transition: all 0.3s; }
			.user-btn { display: none; }
			.user-btn.logout { display: inline-block; background: #ff6b6b; color: white; border: none; padding: 8px 12px; }
			
			.tab-buttons { display: flex; gap: 6px; margin-bottom: 10px; }
			.tab-btn { flex: 1; padding: 7px; background: #e0e0e0; border: none; border-radius: 4px; cursor: pointer; font-weight: bold; font-size: 11px; }
			.tab-btn.active { background: #ff6b6b; color: white; }
			
			h2 { margin-bottom: 8px; font-size: 13px; }
			.info-text { background: #fff3cd; padding: 6px 8px; border-radius: 4px; margin-bottom: 8px; font-size: 10px; }
			.form-group { margin-bottom: 8px; }
			.form-group label { display: block; margin-bottom: 2px; font-weight: bold; font-size: 10px; }
			.form-group input, .form-group textarea { width: 100%; padding: 5px; border: 1px solid #ddd; border-radius: 4px; font-size: 11px; font-family: Arial; }
			.form-group textarea { min-height: 40px; }
			.btn { width: 100%; padding: 7px; background: #ff6b6b; color: white; border: none; border-radius: 4px; cursor: pointer; font-weight: bold; font-size: 11px; }
			
			.filter-section { background: white; padding: 8px; border-radius: 4px; margin-bottom: 8px; border: 1px solid #ddd; }
			.filter-section h4 { font-size: 10px; font-weight: bold; margin-bottom: 5px; }
			.filter-row { margin-bottom: 5px; }
			.filter-row input { width: 100%; padding: 4px; border: 1px solid #ddd; border-radius: 3px; font-size: 10px; }
			.filter-buttons { display: flex; gap: 3px; margin-top: 5px; }
			.filter-btn { flex: 1; padding: 4px; background: #4ecdc4; color: white; border: none; border-radius: 3px; cursor: pointer; font-size: 9px; font-weight: bold; }
			
			.stats { background: #f0f8ff; padding: 6px; border-radius: 4px; margin-bottom: 8px; font-size: 9px; }
			.stats p { margin: 1px 0; }
			
			.marker-list { margin-top: 8px; max-height: 150px; overflow-y: auto; }
			.marker-list h3 { font-size: 11px; margin-bottom: 6px; }
			.marker-item { background: white; border: 1px solid #ddd; padding: 5px; margin-bottom: 4px; cursor: pointer; border-radius: 4px; font-size: 9px; }
			
			.alert-section { background: #fff3e0; padding: 8px; border-radius: 4px; margin-bottom: 8px; border: 1px solid #ffb74d; }
			.alert-section h4 { font-size: 10px; font-weight: bold; margin-bottom: 5px; }
			
			.notification { position: fixed; top: 60px; right: 10px; left: 10px; background: #ff6b6b; color: white; padding: 10px; border-radius: 4px; box-shadow: 0 2px 10px rgba(0,0,0,0.2); z-index: 9999; font-size: 11px; }
			
			#photoPreview img { max-width: 100%; max-height: 60px; margin-top: 5px; border-radius: 4px; }
			
			.time-filter { display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 3px; margin-top: 5px; }
			.time-filter input { padding: 4px; border: 1px solid #ddd; border-radius: 3px; font-size: 9px; }
			
			.online-users-section { background: white; padding: 8px; border-radius: 4px; margin-bottom: 8px; border: 1px solid #ddd; }
			.online-users-section h4 { font-size: 10px; font-weight: bold; margin-bottom: 5px; }
			.online-user-item { display: flex; align-items: center; gap: 5px; padding: 5px; background: #f8f9fa; border-radius: 4px; margin-bottom: 3px; font-size: 9px; }
		}

		/* 초소형 핸드폰 (480px 이하) */
		@media (max-width: 480px) {
			.user-menu { top: 8px; right: 8px; gap: 3px; }
			.user-btn { padding: 6px 10px; font-size: 9px; }
			
			#map { height: 100%; width: 100%; }
			.sidebar { 
				height: 0;
				max-height: 0;
				padding: 10px;
				transition: max-height 0.3s ease, height 0.3s ease;
			}
			.sidebar.mobile-open {
				height: 70vh;
				max-height: 70vh;
			}
			
			.mobile-toggle-btn {
				width: 55px;
				height: 55px;
				bottom: 15px;
				right: 15px;
				font-size: 22px;
			}
			
			.tab-buttons { gap: 5px; margin-bottom: 8px; }
			.tab-btn { padding: 6px; font-size: 10px; }
			
			h2 { font-size: 12px; margin-bottom: 6px; }
			.info-text { font-size: 9px; padding: 5px; margin-bottom: 6px; }
			.form-group { margin-bottom: 6px; }
			.form-group label { font-size: 9px; margin-bottom: 2px; }
			.form-group input, .form-group textarea { font-size: 10px; padding: 4px; }
			.form-group textarea { min-height: 35px; }
			.btn { font-size: 10px; padding: 6px; }
			
			.filter-section { padding: 6px; margin-bottom: 6px; }
			.filter-section h4 { font-size: 9px; margin-bottom: 4px; }
			.filter-row input { padding: 4px; font-size: 9px; }
			.filter-buttons { gap: 2px; margin-top: 4px; }
			.filter-btn { padding: 3px; font-size: 8px; }
			
			.marker-item { font-size: 8px; padding: 4px; margin-bottom: 3px; }
			.marker-list { max-height: 100px; margin-top: 6px; }
			.marker-list h3 { font-size: 10px; margin-bottom: 5px; }
			
			.stats { font-size: 8px; padding: 5px; margin-bottom: 6px; }
			.stats p { margin: 1px 0; font-size: 8px; }
			
			#photoPreview img { max-height: 50px; }
			
			.time-filter { gap: 2px; margin-top: 4px; }
			.time-filter input { padding: 3px; font-size: 8px; }
			
			.online-users-section { padding: 6px; margin-bottom: 6px; }
			.online-users-section h4 { font-size: 9px; margin-bottom: 4px; }
			.online-user-item { font-size: 8px; padding: 4px; margin-bottom: 2px; gap: 4px; }
			
			.notification { top: 50px; font-size: 10px; padding: 8px; }
		}
	</style>
</head>
<body>
	<!-- 사용자 메뉴 -->
	<div class="user-menu">
		<span id="user-info" style="padding: 10px 15px; background: white; border-radius: 5px; font-size: 13px; display: none;"></span>
		<button class="user-btn" onclick="goToHelp()" title="도움말">❓ 도움말</button>
		<button class="user-btn" onclick="goToAuth()" id="login-btn">🔐 로그인</button>
		<button class="user-btn logout" id="logout-btn" onclick="logout()" style="display: none;">로그아웃</button>
	</div>

	<div class="container">
		<!-- 모바일용 토글 버튼 -->
		<button class="mobile-toggle-btn" id="mobileToggleBtn" onclick="toggleMobileSidebar()" style="display: none;">📝</button>
		
		<div class="sidebar" id="sidebar">
			<div class="tab-buttons">
				<button class="tab-btn active" onclick="switchTab('report')">🐕 실종 신고</button>
				<button class="tab-btn" onclick="switchTab('sighting')">👁️ 목격 제보</button>
			</div>

			<div id="tabReportContent" class="tab-content active">
				<h2>🐕 강아지 실종 신고</h2>
				<div class="info-text">지도를 클릭하여 위치를 선택하세요</div>
				
				<div class="filter-section">
					<h4>�️ 지역 선택</h4>
					<div class="filter-row" style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 5px;">
												<button class="filter-btn" onclick="moveToRegion(37.5665, 126.9780, 5)">📍 서울</button>
						<button class="filter-btn" onclick="moveToRegion(37.2656, 127.0086, 5)">📍 수원</button>
						<button class="filter-btn" onclick="moveToRegion(37.2795, 126.6248, 5)">📍 인천</button>
						<button class="filter-btn" onclick="moveToRegion(37.4216, 127.1286, 5)">📍 성남</button>
						<button class="filter-btn" onclick="moveToRegion(37.5742, 127.0097, 5)">📍 동대문</button>
						<button class="filter-btn" onclick="moveToRegion(37.4979, 127.0276, 5)">📍 강남</button>
						<button class="filter-btn" onclick="moveToRegion(36.3504, 127.3845, 5)">📍 대전</button>
						<button class="filter-btn" onclick="moveToRegion(36.0163, 129.3439, 5)">📍 포항</button>
						<button class="filter-btn" onclick="moveToRegion(35.8748, 128.5945, 5)">📍 대구</button>
						<button class="filter-btn" onclick="moveToRegion(35.1595, 126.8526, 5)">📍 광주</button>
						<button class="filter-btn" onclick="moveToRegion(35.1796, 129.0756, 5)">📍 부산</button>
						<button class="filter-btn" onclick="moveToRegion(34.7604, 127.6622, 5)">📍 여수</button>
						<button class="filter-btn" onclick="moveToRegion(37.7510, 128.8888, 5)">📍 강릉</button>
						<button class="filter-btn" onclick="moveToRegion(36.6424, 127.4890, 5)">📍 청주</button>
						<button class="filter-btn" onclick="moveToRegion(35.5384, 129.3114, 5)">📍 울산</button>
						<button class="filter-btn" onclick="moveToRegion(35.8362, 129.2238, 5)">📍 경주</button>
						<button class="filter-btn" onclick="moveToRegion(33.4996, 126.5312, 5)">📍 제주</button>
						<button class="filter-btn reset" onclick="moveToRegion(36.5, 127.5, 10)">🔄 전국</button>
					</div>
				</div>
				
				<div class="filter-section">
					<h4>�🔍 신고 검색 필터</h4>
					<div class="stats" id="reportStats">
						<p>📊 총 신고: <strong>0</strong>건</p>
						<p>📍 표시 중: <strong>0</strong>건</p>
					</div>
					<div class="filter-row">
						<label style="font-size: 11px;">품종</label>
						<input type="text" id="filterBreed" placeholder="품종 검색 (예: 푸들)">
					</div>
					<div class="filter-row">
						<label style="font-size: 11px;">시간 범위</label>
						<div class="time-filter">
							<input type="date" id="filterStartDate" placeholder="시작일">
							<input type="date" id="filterEndDate" placeholder="종료일">
						</div>
					</div>
					<div class="filter-row">
						<label style="font-size: 11px;">거리 범위 (km)</label>
						<input type="number" id="filterRadius" placeholder="반경 (빈칸=제한없음)" min="0" max="50" step="0.5">
					</div>
					<div class="filter-buttons">
						<button class="filter-btn" onclick="applyDogFilter()">🔍 검색</button>
						<button class="filter-btn reset" onclick="resetDogFilter()">초기화</button>
					</div>
				</div>

				<div class="alert-section">
					<h4>🔔 알림 설정</h4>
					<div class="filter-row">
						<label style="font-size: 11px;">🗺️ 감시 반경 (km)</label>
						<input type="number" id="alertRadius" placeholder="예: 2" min="0.1" max="50" step="0.1" value="2">
					</div>
					<div class="filter-row">
						<label style="font-size: 11px;">📍 감시 위치</label>
						<input type="text" id="alertLocation" placeholder="지도 클릭하여 설정" readonly>
					</div>
					<button class="filter-btn" onclick="setAlertLocation()">📍 현재 지점 설정</button>
					<button class="filter-btn reset" onclick="disableAlerts()">알림 해제</button>
					<div id="alertsContainer" style="margin-top: 10px;"></div>
				</div>

				<!-- 접속자 현황 -->
				<div class="online-users-section">
					<h4>👥 현재 접속자 (<span id="online-count">0</span>명)</h4>
					<div id="online-users-list"></div>
				</div>

				<form id="dogForm">
					<div class="form-group">
						<label>🗺️ 위치</label>
						<input type="text" id="location" readonly>
					</div>
					<div class="form-group">
						<label>📅 실종일시</label>
						<input type="datetime-local" id="lostDate" required>
					</div>
					<div class="form-group">
						<label>🐕 품종</label>
						<input type="text" id="breed" required>
					</div>
					<div class="form-group">
						<label>특징</label>
						<textarea id="features" required></textarea>
					</div>
					<div class="form-group">
						<label>📱 연락처</label>
						<input type="tel" id="phone" required>
					</div>
					<button type="button" class="btn" onclick="registerDog()">신고 등록</button>
				</form>
				<div class="marker-list">
					<h3>📍 신고 목록</h3>
					<div id="markerListContainer"></div>
				</div>
			</div>

			<div id="tabSightingContent" class="tab-content">
				<h2>👁️ 목격 제보</h2>
				<div class="info-text">지도를 클릭하여 위치를 선택하세요</div>
				
				<div class="filter-section">
					<h4>�️ 지역 선택</h4>
					<div class="filter-row" style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 5px;">
												<button class="filter-btn" onclick="moveToRegion(37.5665, 126.9780, 5)">📍 서울</button>
						<button class="filter-btn" onclick="moveToRegion(37.2656, 127.0086, 5)">📍 수원</button>
						<button class="filter-btn" onclick="moveToRegion(37.2795, 126.6248, 5)">📍 인천</button>
						<button class="filter-btn" onclick="moveToRegion(37.4216, 127.1286, 5)">📍 성남</button>
						<button class="filter-btn" onclick="moveToRegion(37.5742, 127.0097, 5)">📍 동대문</button>
						<button class="filter-btn" onclick="moveToRegion(37.4979, 127.0276, 5)">📍 강남</button>
						<button class="filter-btn" onclick="moveToRegion(36.3504, 127.3845, 5)">📍 대전</button>
						<button class="filter-btn" onclick="moveToRegion(36.0163, 129.3439, 5)">📍 포항</button>
						<button class="filter-btn" onclick="moveToRegion(35.8748, 128.5945, 5)">📍 대구</button>
						<button class="filter-btn" onclick="moveToRegion(35.1595, 126.8526, 5)">📍 광주</button>
						<button class="filter-btn" onclick="moveToRegion(35.1796, 129.0756, 5)">📍 부산</button>
						<button class="filter-btn" onclick="moveToRegion(34.7604, 127.6622, 5)">📍 여수</button>
						<button class="filter-btn" onclick="moveToRegion(37.7510, 128.8888, 5)">📍 강릉</button>
						<button class="filter-btn" onclick="moveToRegion(36.6424, 127.4890, 5)">📍 청주</button>
						<button class="filter-btn" onclick="moveToRegion(35.5384, 129.3114, 5)">📍 울산</button>
						<button class="filter-btn" onclick="moveToRegion(35.8362, 129.2238, 5)">📍 경주</button>
						<button class="filter-btn" onclick="moveToRegion(33.4996, 126.5312, 5)">📍 제주</button>
						<button class="filter-btn reset" onclick="moveToRegion(36.5, 127.5, 10)">🔄 전국</button>
					</div>
				</div>
				
				<div class="filter-section">
					<h4>�🔍 제보 검색 필터</h4>
					<div class="stats" id="sightingStats">
						<p>📊 총 제보: <strong>0</strong>건</p>
						<p>📍 표시 중: <strong>0</strong>건</p>
					</div>
					<div class="filter-row">
						<label style="font-size: 11px;">최근 제보</label>
						<select id="timeRangeFilter" style="width: 100%; padding: 6px; border: 1px solid #ddd; border-radius: 3px; font-size: 11px;">
							<option value="">전체</option>
							<option value="24">최근 24시간</option>
							<option value="72">최근 3일</option>
							<option value="168">최근 1주일</option>
						</select>
					</div>
					<div class="filter-row">
						<label style="font-size: 11px;">상태 검색</label>
						<input type="text" id="filterStatus" placeholder="상태 검색 (예: 공원)">
					</div>
					<div class="filter-row">
						<label style="font-size: 11px;">거리 범위 (km)</label>
						<input type="number" id="sightingFilterRadius" placeholder="반경 (빈칸=제한없음)" min="0" max="50" step="0.5">
					</div>
					<div class="filter-buttons">
						<button class="filter-btn" onclick="applySightingFilter()">🔍 검색</button>
						<button class="filter-btn reset" onclick="resetSightingFilter()">초기화</button>
					</div>
				</div>

				<form id="sightingForm">
					<div class="form-group">
						<label>🗺️ 위치</label>
						<input type="text" id="sightingLocation" readonly>
					</div>
					<div class="form-group">
						<label>⏰ 목격 시간</label>
						<input type="datetime-local" id="sightingTime" required>
					</div>
					<div class="form-group">
						<label>📸 사진</label>
						<input type="file" id="sightingPhoto" accept="image/*">
						<div id="photoPreview"></div>
					</div>
					<div class="form-group">
						<label>상태 설명</label>
						<textarea id="sightingStatus" required></textarea>
					</div>
					<div class="form-group">
						<label>📱 제보자 연락처</label>
						<input type="tel" id="sightingPhone">
					</div>
					<button type="button" class="btn" onclick="registerSighting()" style="background: #4ecdc4;">제보 등록</button>
				</form>
				<div class="marker-list">
					<h3>👁️ 제보 목록</h3>
					<div id="sightingListContainer"></div>
				</div>
			</div>
		</div>
		<div id="map"></div>
	</div>

	<script src="https://dapi.kakao.com/v2/maps/sdk.js?appkey=481ddadbb86f2ac32bc6ca3574d3244e"></script>
	<script>
		let map, selectedLat, selectedLng, selectedSightingLat, selectedSightingLng;
		let markers = [], sightingMarkers = [], infowindows = [], sightingInfowindows = [];
		let dogsData = [], sightingsData = [];
		let currentTab = 'report', selectionMarker = null;
		let centerLat = 36.5, centerLng = 127.5; // 한국 전체 중심
		let filteredDogs = [], filteredSightings = [];
		let alertEnabled = false;
		let alertLat = null, alertLng = null, alertRadius = 2;
		let alertMarker = null;
		let notifiedSightings = new Set();

		// Kakao API 로드 확인
		function waitForKakao() {
			return new Promise((resolve) => {
				if (typeof kakao !== 'undefined') {
					resolve();
				} else {
					setTimeout(() => waitForKakao().then(resolve), 100);
				}
			});
		}

		function switchTab(tab) {
			currentTab = tab;
			document.querySelectorAll('.tab-content').forEach(el => el.classList.toggle('active'));
			document.querySelectorAll('.tab-btn').forEach(el => el.classList.toggle('active'));
		}

		// 모바일 사이드바 토글
		function toggleMobileSidebar() {
			const sidebar = document.getElementById('sidebar');
			sidebar.classList.toggle('mobile-open');
		}

		// 모바일 환경 감지
		function checkMobileEnvironment() {
			const toggleBtn = document.getElementById('mobileToggleBtn');
			if (window.innerWidth <= 768) {
				toggleBtn.style.display = 'block';
				const sidebar = document.getElementById('sidebar');
				sidebar.classList.remove('mobile-open');
			} else {
				toggleBtn.style.display = 'none';
				const sidebar = document.getElementById('sidebar');
				sidebar.classList.remove('mobile-open');
			}
		}

		// 윈도우 리사이즈 감지
		window.addEventListener('resize', checkMobileEnvironment);

		function initMap() {
			map = new kakao.maps.Map(document.getElementById('map'), {
				center: new kakao.maps.LatLng(centerLat, centerLng),
				level: 10 // 한국 전체를 보기 위해 줌 레벨 확대
			});

			kakao.maps.event.addListener(map, 'click', function(mouseEvent) {
				const latlng = mouseEvent.latLng;
				if (currentTab === 'report') {
					selectedLat = latlng.getLat();
					selectedLng = latlng.getLng();
					document.getElementById('location').value = selectedLat.toFixed(6) + ', ' + selectedLng.toFixed(6);
				} else {
					selectedSightingLat = latlng.getLat();
					selectedSightingLng = latlng.getLng();
					document.getElementById('sightingLocation').value = selectedSightingLat.toFixed(6) + ', ' + selectedSightingLng.toFixed(6);
				}
				if (selectionMarker) selectionMarker.setMap(null);
				selectionMarker = new kakao.maps.Marker({ position: latlng });
				selectionMarker.setMap(map);
			});

			loadSavedData();
		}

		// 지역으로 이동
		function moveToRegion(lat, lng, level) {
			if (!map) return;
			map.setCenter(new kakao.maps.LatLng(lat, lng));
			map.setLevel(level);
			centerLat = lat;
			centerLng = lng;
		}

		function getDistance(lat1, lng1, lat2, lng2) {
			const R = 6371;
			const dLat = (lat2 - lat1) * Math.PI / 180;
			const dLng = (lng2 - lng1) * Math.PI / 180;
			const a = Math.sin(dLat / 2) * Math.sin(dLat / 2) +
				Math.cos(lat1 * Math.PI / 180) * Math.cos(lat2 * Math.PI / 180) *
				Math.sin(dLng / 2) * Math.sin(dLng / 2);
			const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
			return R * c;
		}

		function applyDogFilter() {
			const breed = document.getElementById('filterBreed').value.toLowerCase();
			const startDate = document.getElementById('filterStartDate').value;
			const endDate = document.getElementById('filterEndDate').value;
			const radius = parseFloat(document.getElementById('filterRadius').value) || null;

			filteredDogs = dogsData.filter(dog => {
				if (breed && !dog.breed.toLowerCase().includes(breed)) return false;
				
				if (startDate || endDate) {
					const dogDate = new Date(dog.lostDate).getTime();
					if (startDate) {
						const start = new Date(startDate + 'T00:00:00').getTime();
						if (dogDate < start) return false;
					}
					if (endDate) {
						const end = new Date(endDate + 'T23:59:59').getTime();
						if (dogDate > end) return false;
					}
				}

				if (radius !== null) {
					const dist = getDistance(centerLat, centerLng, dog.lat, dog.lng);
					if (dist > radius) return false;
				}

				return true;
			});

			displayDogList();
			updateDogStats();
		}

		function resetDogFilter() {
			document.getElementById('filterBreed').value = '';
			document.getElementById('filterStartDate').value = '';
			document.getElementById('filterEndDate').value = '';
			document.getElementById('filterRadius').value = '';
			filteredDogs = [...dogsData];
			displayDogList();
			updateDogStats();
		}

		function applySightingFilter() {
			const timeRange = parseInt(document.getElementById('timeRangeFilter').value) || null;
			const status = document.getElementById('filterStatus').value.toLowerCase();
			const radius = parseFloat(document.getElementById('sightingFilterRadius').value) || null;

			filteredSightings = sightingsData.filter(sighting => {
				if (timeRange !== null) {
					const sightingTime = new Date(sighting.sightingTime).getTime();
					const now = Date.now();
					const hoursAgo = now - (timeRange * 60 * 60 * 1000);
					if (sightingTime < hoursAgo) return false;
				}

				if (status && !sighting.status.toLowerCase().includes(status)) return false;

				if (radius !== null) {
					const dist = getDistance(centerLat, centerLng, sighting.lat, sighting.lng);
					if (dist > radius) return false;
				}

				return true;
			});

			displaySightingList();
			updateSightingStats();
		}

		function resetSightingFilter() {
			document.getElementById('timeRangeFilter').value = '';
			document.getElementById('filterStatus').value = '';
			document.getElementById('sightingFilterRadius').value = '';
			filteredSightings = [...sightingsData];
			displaySightingList();
			updateSightingStats();
		}

		function updateDogStats() {
			const total = dogsData.length;
			const shown = filteredDogs.length;
			document.getElementById('reportStats').innerHTML = 
				'<p>📊 총 신고: <strong>' + total + '</strong>건</p>' +
				'<p>📍 표시 중: <strong>' + shown + '</strong>건</p>';
		}

		function updateSightingStats() {
			const total = sightingsData.length;
			const shown = filteredSightings.length;
			document.getElementById('sightingStats').innerHTML = 
				'<p>📊 총 제보: <strong>' + total + '</strong>건</p>' +
				'<p>📍 표시 중: <strong>' + shown + '</strong>건</p>';
		}

		function setAlertLocation() {
			if (currentTab !== 'report') {
				alert('실종 신고 탭에서 설정해주세요');
				return;
			}
			if (!selectedLat || !selectedLng) {
				alert('지도에서 위치를 먼저 선택하세요');
				return;
			}
			alertLat = selectedLat;
			alertLng = selectedLng;
			alertRadius = parseFloat(document.getElementById('alertRadius').value) || 2;
			alertEnabled = true;

			document.getElementById('alertLocation').value = alertLat.toFixed(6) + ', ' + alertLng.toFixed(6) + ' (' + alertRadius + 'km)';
			
			if (alertMarker) alertMarker.setMap(null);
			alertMarker = new kakao.maps.Marker({
				position: new kakao.maps.LatLng(alertLat, alertLng),
				title: '알림 반경'
			});
			alertMarker.setMap(map);

			showNotification('✅ 알림이 활성화되었습니다!', 'success');
			displayAlerts();
		}

		function disableAlerts() {
			alertEnabled = false;
			alertLat = null;
			alertLng = null;
			notifiedSightings.clear();
			document.getElementById('alertLocation').value = '';
			document.getElementById('alertsContainer').innerHTML = '<p style="color: #999; font-size: 11px;">알림이 비활성화되었습니다</p>';
			if (alertMarker) {
				alertMarker.setMap(null);
				alertMarker = null;
			}
			showNotification('🔔 알림이 해제되었습니다', 'info');
		}

		function checkAlerts() {
			if (!alertEnabled || !alertLat || !alertLng) return;

			sightingsData.forEach(sighting => {
				if (notifiedSightings.has(sighting.id)) return;

				const distance = getDistance(alertLat, alertLng, sighting.lat, sighting.lng);
				if (distance <= alertRadius) {
					notifiedSightings.add(sighting.id);
					const message = '🐕 반경 ' + alertRadius + 'km 내에서 강아지 목격 제보가 있습니다! ' + sighting.status.substring(0, 20) + '...';
					showNotification(message, 'info');
				}
			});

			displayAlerts();
		}

		function displayAlerts() {
			const container = document.getElementById('alertsContainer');
			if (!alertEnabled) {
				container.innerHTML = '<p style="color: #999; font-size: 11px;">알림 설정 후 목격 제보가 등록되면 알림이 표시됩니다</p>';
				return;
			}

			const nearSightings = sightingsData.filter(s => {
				const dist = getDistance(alertLat, alertLng, s.lat, s.lng);
				return dist <= alertRadius;
			});

			if (nearSightings.length === 0) {
				container.innerHTML = '<p style="color: #999; font-size: 11px;">반경 내 제보 없음</p>';
				return;
			}

			container.innerHTML = '';
			nearSightings.forEach(sighting => {
				const item = document.createElement('div');
				item.className = 'alert-item';
				const dist = getDistance(alertLat, alertLng, sighting.lat, sighting.lng).toFixed(2);
				item.innerHTML = '<span class="close-alert" onclick="this.parentElement.remove()">✕</span>' +
					'<p><strong>⏰ ' + sighting.sightingTime + '</strong></p>' +
					'<p>📍 ' + dist + 'km 거리</p>' +
					'<p>' + sighting.status.substring(0, 40) + '...</p>' +
					(sighting.phone ? '<p>📱 ' + sighting.phone + '</p>' : '');
				container.appendChild(item);
			});
		}

		function showNotification(message, type = 'info') {
			const notif = document.createElement('div');
			notif.className = 'notification ' + type;
			notif.textContent = message;
			document.body.appendChild(notif);

			setTimeout(() => {
				notif.style.opacity = '0';
				notif.style.transform = 'translateX(400px)';
				setTimeout(() => notif.remove(), 300);
			}, 4000);
		}

		function registerDog() {
			// 로그인 확인
			const userId = localStorage.getItem('user_id');
			if (!userId) {
				alert('로그인이 필요합니다.');
				window.location.href = 'auth.php';
				return;
			}

			if (!selectedLat) return alert('위치를 선택하세요');
			const form = document.getElementById('dogForm');
			if (!form.lostDate.value || !form.breed.value || !form.features.value || !form.phone.value) return alert('모든 정보를 입력하세요');

			// 서버에 신고 저장
			const reportData = {
				type: 'missing',
				title: form.breed.value,
				description: form.features.value,
				latitude: selectedLat,
				longitude: selectedLng,
				breed: form.breed.value,
				phone: form.phone.value,
				user_id: userId,
				user_name: localStorage.getItem('user_name'),
				user_email: localStorage.getItem('user_email')
			};

			fetch('api.php?action=saveReport', {
				method: 'POST',
				headers: {
					'Content-Type': 'application/json'
				},
				body: JSON.stringify(reportData)
			})
			.then(response => response.json())
			.then(data => {
				if (data.success || data.id) {
					// 로컬 데이터도 업데이트
					const dog = {
						id: Date.now(),
						lat: selectedLat, lng: selectedLng,
						lostDate: form.lostDate.value,
						breed: form.breed.value,
						features: form.features.value,
						phone: form.phone.value,
						registeredDate: new Date().toLocaleString('ko-KR')
					};
					dogsData.push(dog);
					filteredDogs = [...dogsData];
					saveData();
					addDogMarker(dog);
					displayDogList();
					updateDogStats();
					form.reset();
					selectedLat = null;
					if (selectionMarker) selectionMarker.setMap(null);
					alert('등록되었습니다!');
				} else {
					alert('등록 실패: ' + (data.error || '알 수 없는 오류'));
				}
			})
			.catch(err => {
				console.error('에러:', err);
				alert('네트워크 오류가 발생했습니다.');
			});
		}

		function registerSighting() {
			// 로그인 확인
			const userId = localStorage.getItem('user_id');
			if (!userId) {
				alert('로그인이 필요합니다.');
				window.location.href = 'auth.php';
				return;
			}

			if (!selectedSightingLat) return alert('위치를 선택하세요');
			const form = document.getElementById('sightingForm');
			if (!form.sightingTime.value || !form.sightingStatus.value) return alert('필수 정보를 입력하세요');

			const photoFile = document.getElementById('sightingPhoto').files[0];
			if (photoFile) {
				const reader = new FileReader();
				reader.onload = (e) => saveSighting(e.target.result);
				reader.readAsDataURL(photoFile);
			} else {
				saveSighting(null);
			}

			function saveSighting(photo) {
				// 서버에 신고 저장
				const reportData = {
					type: 'sighting',
					title: '목격 제보',
					description: form.sightingStatus.value,
					latitude: selectedSightingLat,
					longitude: selectedSightingLng,
					phone: form.sightingPhone.value,
					image: photo,
					user_id: userId,
					user_name: localStorage.getItem('user_name'),
					user_email: localStorage.getItem('user_email')
				};

				fetch('api.php?action=saveReport', {
					method: 'POST',
					headers: {
						'Content-Type': 'application/json'
					},
					body: JSON.stringify(reportData)
				})
				.then(response => response.json())
				.then(data => {
					if (data.success || data.id) {
						// 로컬 데이터도 업데이트
						const sighting = {
							id: Date.now(),
							lat: selectedSightingLat, lng: selectedSightingLng,
							sightingTime: form.sightingTime.value,
							status: form.sightingStatus.value,
							phone: form.sightingPhone.value,
							photo: photo,
							registeredDate: new Date().toLocaleString('ko-KR')
						};
						sightingsData.push(sighting);
						filteredSightings = [...sightingsData];
						saveData();
						addSightingMarker(sighting);
						displaySightingList();
						updateSightingStats();
						form.reset();
						document.getElementById('photoPreview').innerHTML = '';
						selectedSightingLat = null;
						if (selectionMarker) selectionMarker.setMap(null);
						checkAlerts();
						alert('등록되었습니다!');
					} else {
						alert('등록 실패: ' + (data.error || '알 수 없는 오류'));
					}
				})
				.catch(err => {
					console.error('에러:', err);
					alert('네트워크 오류가 발생했습니다.');
				});
			}
		}

		function addDogMarker(dog) {
			const marker = new kakao.maps.Marker({ position: new kakao.maps.LatLng(dog.lat, dog.lng) });
			marker.setMap(map);
			markers.push(marker);

			const infowindow = new kakao.maps.InfoWindow({
				content: '<div style="padding:8px;"><h4>🐕 ' + dog.breed + '</h4><p><strong>실종:</strong> ' + dog.lostDate + '</p><p><strong>특징:</strong> ' + dog.features + '</p><p><strong>연락:</strong> ' + dog.phone + '</p></div>'
			});

			marker.addListener('click', function() {
				infowindows.concat(sightingInfowindows).forEach(iw => iw.close());
				infowindow.open(map, marker);
			});
			infowindows.push(infowindow);
		}

		function addSightingMarker(sighting) {
			const marker = new kakao.maps.Marker({ position: new kakao.maps.LatLng(sighting.lat, sighting.lng) });
			marker.setMap(map);
			sightingMarkers.push(marker);

			const photo = sighting.photo ? '<img src="' + sighting.photo + '" style="max-width:140px;margin:5px 0;">' : '';
			const infowindow = new kakao.maps.InfoWindow({
				content: '<div style="padding:8px;"><h4>👁️ 목격 제보</h4><p><strong>시간:</strong> ' + sighting.sightingTime + '</p>' + photo + '<p><strong>상태:</strong> ' + sighting.status + '</p>' + (sighting.phone ? '<p><strong>연락:</strong> ' + sighting.phone + '</p>' : '') + '</div>'
			});

			marker.addListener('click', function() {
				infowindows.concat(sightingInfowindows).forEach(iw => iw.close());
				infowindow.open(map, marker);
			});
			sightingInfowindows.push(infowindow);
		}

		function displayDogList() {
			document.getElementById('markerListContainer').innerHTML = '';
			filteredDogs.forEach((dog, i) => {
				const item = document.createElement('div');
				item.className = 'marker-item';
				item.innerHTML = '<h4>' + dog.breed + '</h4><p><strong>실종:</strong> ' + dog.lostDate + '</p><p>' + dog.features.substring(0, 25) + '...</p>';
				item.onclick = () => {
					map.setCenter(new kakao.maps.LatLng(dog.lat, dog.lng));
					map.setLevel(3);
					infowindows.concat(sightingInfowindows).forEach(iw => iw.close());
					const idx = dogsData.indexOf(dog);
					infowindows[idx].open(map, markers[idx]);
				};
				document.getElementById('markerListContainer').appendChild(item);
			});
		}

		function displaySightingList() {
			document.getElementById('sightingListContainer').innerHTML = '';
			filteredSightings.forEach((s, i) => {
				const item = document.createElement('div');
				item.className = 'marker-item';
				const photo = s.photo ? '<img src="' + s.photo + '" style="max-width:40px;height:auto;margin:3px 0;">' : '';
				item.innerHTML = '<h4>👁️ 목격</h4><p><strong>시간:</strong> ' + s.sightingTime + '</p>' + photo + '<p>' + s.status.substring(0, 20) + '...</p>';
				item.onclick = () => {
					map.setCenter(new kakao.maps.LatLng(s.lat, s.lng));
					map.setLevel(3);
					infowindows.concat(sightingInfowindows).forEach(iw => iw.close());
					const idx = sightingsData.indexOf(s);
					sightingInfowindows[idx].open(map, sightingMarkers[idx]);
				};
				document.getElementById('sightingListContainer').appendChild(item);
			});
		}

		function saveData() {
			localStorage.setItem('dogsData', JSON.stringify(dogsData));
			localStorage.setItem('sightingsData', JSON.stringify(sightingsData));
		}

		function loadSavedData() {
			// API에서 데이터 로드
			fetch('api.php?action=getReports')
				.then(response => response.json())
				.then(data => {
					if (data.success && data.reports) {
						const reports = data.reports || [];
						
						// 타입별로 분류
						dogsData = reports.filter(r => r.type === 'missing').map(r => ({
							breed: r.breed,
							lat: r.latitude,
							lng: r.longitude,
							lostDate: r.created_at,
							photo: r.image,
							status: r.description,
							title: r.title,
							color: r.color,
							phone: r.phone,
							userEmail: r.user_email,
							userName: r.user_name
						}));
						
						sightingsData = reports.filter(r => r.type === 'sighting').map(r => ({
							breed: r.breed,
							lat: r.latitude,
							lng: r.longitude,
							sightingTime: r.created_at,
							photo: r.image,
							status: r.description,
							title: r.title,
							color: r.color,
							phone: r.phone,
							userEmail: r.user_email,
							userName: r.user_name
						}));
						
						filteredDogs = [...dogsData];
						filteredSightings = [...sightingsData];
						
						dogsData.forEach(dog => addDogMarker(dog));
						sightingsData.forEach(sighting => addSightingMarker(sighting));
						
						displayDogList();
						displaySightingList();
						updateDogStats();
						updateSightingStats();
					}
				})
				.catch(err => console.error('데이터 로드 오류:', err));
			
			document.getElementById('alertsContainer').innerHTML = '<p style="color: #999; font-size: 11px;">알림 설정 후 목격 제보가 등록되면 알림이 표시됩니다</p>';
		}

		document.getElementById('sightingPhoto').addEventListener('change', function(e) {
			const file = e.target.files[0];
			const preview = document.getElementById('photoPreview');
			preview.innerHTML = '';
			if (file) {
				const reader = new FileReader();
				reader.onload = (event) => {
					const img = document.createElement('img');
					img.src = event.target.result;
					preview.appendChild(img);
				};
				reader.readAsDataURL(file);
			}
		});

		// 사용자 계정 시스템 함수
		function initUserMenu() {
			const userId = localStorage.getItem('user_id');
			const userName = localStorage.getItem('user_name');
			const userEmail = localStorage.getItem('user_email');
			
			const loginBtn = document.getElementById('login-btn');
			const logoutBtn = document.getElementById('logout-btn');
			const userInfo = document.getElementById('user-info');

			if (userId && userEmail) {
				loginBtn.style.display = 'none';
				logoutBtn.style.display = 'block';
				userInfo.style.display = 'block';
				userInfo.textContent = `👋 ${userName || userEmail}님`;
			} else {
				loginBtn.style.display = 'block';
				logoutBtn.style.display = 'none';
				userInfo.style.display = 'none';
			}
		}

		function goToAuth() {
			window.location.href = 'auth.php';
		}

		function goToHelp() {
			window.location.href = 'help.php';
		}

		function goToReportPage() {
			const userId = localStorage.getItem('user_id');
			if (!userId) {
				alert('로그인이 필요합니다.');
				window.location.href = 'auth.php';
				return;
			}
			window.location.href = 'report.php';
		}

		function goToSightingPage() {
			const userId = localStorage.getItem('user_id');
			if (!userId) {
				alert('로그인이 필요합니다.');
				window.location.href = 'auth.php';
				return;
			}
			window.location.href = 'sighting.php';
		}

		function goToReports() {
			const userId = localStorage.getItem('user_id');
			if (!userId) {
				alert('로그인이 필요합니다.');
				window.location.href = 'auth.php';
				return;
			}
			window.location.href = 'manage-reports.php';
		}

		function logout() {
			if (confirm('로그아웃하시겠습니까?')) {
				fetch('api.php?action=logout', { method: 'POST' })
					.then(() => {
						localStorage.removeItem('user_id');
						localStorage.removeItem('user_name');
						localStorage.removeItem('user_email');
						alert('로그아웃되었습니다.');
						initUserMenu();
						location.reload();
					})
					.catch(err => {
						console.error('로그아웃 오류:', err);
						localStorage.removeItem('user_id');
						localStorage.removeItem('user_name');
						localStorage.removeItem('user_email');
						location.reload();
					});
			}
		}

		// 온라인 사용자 관리
		let onlineUsers = [];

		function getOnlineUsers() {
			const stored = localStorage.getItem('onlineUsers');
			return stored ? JSON.parse(stored) : [];
		}

		// 실시간 온라인 사용자 업데이트 (PHP 백엔드 연동)
		function updateOnlineUsers() {
			fetch('online_users.php?action=get')
				.then(response => response.json())
				.then(data => {
					if (data.status === 'success') {
						const usersList = document.getElementById('online-users-list');
						const onlineCount = document.getElementById('online-count');

						onlineCount.textContent = data.total_users;

						if (data.users.length === 0) {
							usersList.innerHTML = '<div style="color: #999; font-size: 11px; padding: 8px; text-align: center;">접속한 사용자가 없습니다.</div>';
							return;
						}

						usersList.innerHTML = data.users.map(user => {
							const isCurrentUser = user.is_current ? '⭐ ' : '';
							return `
								<div class="online-user-item" style="${user.is_current ? 'background: #ffe6e6;' : ''}">
									<div class="user-status-dot" style="${user.is_current ? 'background: #4ecdc4; animation: pulse 1s infinite;' : 'background: #4ecdc4;'}"></div>
									<div class="user-name">${isCurrentUser}${user.user_name}</div>
									<div class="user-time" style="font-size: 9px;">활동 중</div>
								</div>
							`;
						}).join('');
					}
				})
				.catch(error => console.error('온라인 사용자 조회 오류:', error));
		}

		// 페이지 활성 상태 업데이트 (5초마다) + 사용자 정보 전송
		function keepAlive() {
			const userName = sessionStorage.getItem('userName');
			const userEmail = sessionStorage.getItem('userEmail');
			
			const userData = {
				action: 'update',
				userName: userName || 'Anonymous',
				userEmail: userEmail || ''
			};
			
			fetch('online_users.php', {
				method: 'POST',
				headers: {
					'Content-Type': 'application/json'
				},
				body: JSON.stringify(userData)
			}).catch(error => console.error('세션 유지 오류:', error));
		}

		// 실시간 업데이트
		setInterval(updateOnlineUsers, 3000);
		setInterval(keepAlive, 5000);

		// 페이지 나갈 때 사용자 제거
		window.addEventListener('beforeunload', function() {
			fetch('online_users.php?action=remove');
		});

		window.addEventListener('load', function() {
			// 모바일 환경 초기화
			checkMobileEnvironment();
			
			// 로그인 상태 복원 (서버 세션 동기화)
			const userId = localStorage.getItem('user_id');
			const userName = localStorage.getItem('user_name');
			const userEmail = localStorage.getItem('user_email');
			if (userId && userEmail) {
				// 서버 세션 설정
				fetch('api.php?action=login', {
					method: 'POST',
					headers: {
						'Content-Type': 'application/json'
					},
					body: JSON.stringify({ 
						user_id: userId,
						user_name: userName,
						user_email: userEmail,
						skip_password: true 
					})
				}).catch(err => console.log('세션 복원 중 오류:', err));
			}
			
			// Kakao API 로드 대기
			waitForKakao().then(() => {
				initMap();
				initUserMenu();
				
				// 페이지 로드 시 사용자 추가
				const userEmail = sessionStorage.getItem('userEmail');
				const userName = sessionStorage.getItem('userName');
				if (userEmail) {
					addOnlineUser(userName, userEmail);
				}
			}).catch(err => {
				console.error('Kakao API 로드 실패:', err);
				alert('지도 기능을 사용할 수 없습니다. 페이지를 새로고침하세요.');
			});
			
			// 첫 로드 시 온라인 사용자 업데이트
			updateOnlineUsers();
			keepAlive();
		});
	</script>
</body>
</html>

