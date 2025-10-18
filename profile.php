<?php header('Content-Type: text/html; charset=utf-8'); ?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8"/>
	<title>개인 프로필</title>
	<style>
		* { margin: 0; padding: 0; box-sizing: border-box; }
		body { 
			font-family: Arial, sans-serif; 
			background: #f8f9fa; 
			min-height: 100vh;
		}
		.profile-container { 
			max-width: 1200px; 
			margin: 0 auto; 
			padding: 20px;
		}
		.header { 
			background: white; 
			padding: 20px; 
			border-radius: 10px; 
			margin-bottom: 20px; 
			box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
			display: flex;
			justify-content: space-between;
			align-items: center;
		}
		.header h1 { 
			color: #333; 
			font-size: 24px;
		}
		.header-actions { 
			display: flex; 
			gap: 10px;
		}
		.btn { 
			padding: 10px 20px; 
			border: none; 
			border-radius: 5px; 
			cursor: pointer; 
			font-weight: bold;
			transition: background 0.3s;
		}
		.btn-primary { 
			background: #4ecdc4; 
			color: white;
		}
		.btn-primary:hover { 
			background: #3bb8a8;
		}
		.btn-secondary { 
			background: #e9ecef; 
			color: #333;
		}
		.btn-secondary:hover { 
			background: #dee2e6;
		}
		.btn-danger { 
			background: #dc3545; 
			color: white;
		}
		.btn-danger:hover { 
			background: #c82333;
		}
		.nav-tabs { 
			display: flex; 
			gap: 10px; 
			margin-bottom: 20px; 
			border-bottom: 2px solid #e9ecef;
			background: white;
			padding: 0 20px;
			border-radius: 10px 10px 0 0;
		}
		.nav-tab { 
			padding: 15px 20px; 
			background: transparent; 
			border: none; 
			cursor: pointer; 
			font-weight: bold; 
			color: #666; 
			border-bottom: 3px solid transparent;
			transition: all 0.3s;
		}
		.nav-tab:hover { 
			color: #333;
		}
		.nav-tab.active { 
			color: #4ecdc4; 
			border-bottom-color: #4ecdc4;
		}
		.content-section { 
			display: none;
		}
		.content-section.active { 
			display: block;
		}
		.profile-card { 
			background: white; 
			padding: 30px; 
			border-radius: 10px; 
			box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
		}
		.profile-info { 
			display: grid; 
			grid-template-columns: 1fr 2fr; 
			gap: 30px;
			align-items: start;
		}
		.profile-avatar { 
			text-align: center;
		}
		.avatar-image { 
			width: 150px; 
			height: 150px; 
			background: linear-gradient(135deg, #4ecdc4 0%, #44a08d 100%); 
			border-radius: 50%; 
			display: flex; 
			align-items: center; 
			justify-content: center; 
			color: white; 
			font-size: 60px; 
			margin: 0 auto 15px;
		}
		.profile-details { 
			display: grid; 
			grid-template-columns: 1fr 1fr; 
			gap: 15px;
		}
		.detail-item { 
			background: #f8f9fa; 
			padding: 15px; 
			border-radius: 5px;
		}
		.detail-label { 
			color: #666; 
			font-size: 12px; 
			font-weight: bold; 
			margin-bottom: 5px; 
			text-transform: uppercase;
		}
		.detail-value { 
			color: #333; 
			font-size: 16px;
		}
		.edit-btn { 
			width: 100%; 
			margin-top: 15px; 
			padding: 10px; 
			background: #4ecdc4; 
			color: white; 
			border: none; 
			border-radius: 5px; 
			cursor: pointer; 
			font-weight: bold;
		}
		.form-group { 
			margin-bottom: 20px;
		}
		.form-group label { 
			display: block; 
			margin-bottom: 8px; 
			color: #333; 
			font-weight: bold;
		}
		.form-group input { 
			width: 100%; 
			padding: 12px; 
			border: 1px solid #ddd; 
			border-radius: 5px;
		}
		.form-group input:focus { 
			outline: none; 
			border-color: #4ecdc4; 
			box-shadow: 0 0 5px rgba(78, 205, 196, 0.3);
		}
		.edit-form { 
			display: none;
		}
		.edit-form.active { 
			display: block;
		}
		.report-grid { 
			display: grid; 
			grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); 
			gap: 20px;
		}
		.report-card { 
			background: white; 
			border-radius: 10px; 
			padding: 20px; 
			box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
			border-left: 5px solid #4ecdc4;
		}
		.report-status { 
			display: inline-block; 
			padding: 5px 10px; 
			background: #d4edda; 
			color: #155724; 
			border-radius: 20px; 
			font-size: 12px; 
			font-weight: bold; 
			margin-bottom: 10px;
		}
		.report-status.pending { 
			background: #fff3cd; 
			color: #856404;
		}
		.report-status.resolved { 
			background: #d4edda; 
			color: #155724;
		}
		.report-title { 
			color: #333; 
			font-size: 16px; 
			font-weight: bold; 
			margin-bottom: 10px;
		}
		.report-meta { 
			display: flex; 
			gap: 10px; 
			font-size: 12px; 
			color: #666; 
			margin-bottom: 10px;
		}
		.report-content { 
			color: #555; 
			font-size: 14px; 
			margin-bottom: 15px; 
			line-height: 1.6;
		}
		.report-actions { 
			display: flex; 
			gap: 10px;
		}
		.report-actions button { 
			flex: 1; 
			padding: 8px; 
			background: #f8f9fa; 
			border: 1px solid #ddd; 
			border-radius: 5px; 
			cursor: pointer;
		}
		.report-actions button:hover { 
			background: #e9ecef;
		}
		.empty-state { 
			text-align: center; 
			padding: 40px; 
			color: #999;
		}
		.empty-state-icon { 
			font-size: 48px; 
			margin-bottom: 15px;
		}
		.stats-grid { 
			display: grid; 
			grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); 
			gap: 15px; 
			margin-bottom: 30px;
		}
		.stat-box { 
			background: white; 
			padding: 20px; 
			border-radius: 10px; 
			text-align: center; 
			box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
		}
		.stat-number { 
			font-size: 32px; 
			font-weight: bold; 
			color: #4ecdc4;
		}
		.stat-label { 
			color: #666; 
			font-size: 14px; 
			margin-top: 5px;
		}
		.modal { 
			display: none; 
			position: fixed; 
			top: 0; 
			left: 0; 
			width: 100%; 
			height: 100%; 
			background: rgba(0, 0, 0, 0.5); 
			justify-content: center; 
			align-items: center; 
			z-index: 1000;
		}
		.modal.active { 
			display: flex;
		}
		.modal-content { 
			background: white; 
			padding: 30px; 
			border-radius: 10px; 
			max-width: 500px; 
			width: 90%;
		}
		.modal-header { 
			display: flex; 
			justify-content: space-between; 
			align-items: center; 
			margin-bottom: 20px;
		}
		.modal-header h2 { 
			color: #333;
		}
		.close-btn { 
			background: none; 
			border: none; 
			font-size: 24px; 
			cursor: pointer; 
			color: #999;
		}
	</style>
</head>
<body>
	<div class="profile-container">
		<!-- 헤더 -->
		<div class="header">
			<h1>🐾 개인 프로필</h1>
			<div class="header-actions">
				<a href="index.php" class="btn btn-secondary">지도로 돌아가기</a>
				<button class="btn btn-danger" onclick="logout()">로그아웃</button>
			</div>
		</div>

		<!-- 탭 네비게이션 -->
		<div class="nav-tabs">
			<button class="nav-tab active" onclick="switchContent('profile')">프로필</button>
			<button class="nav-tab" onclick="switchContent('reports')">내 신고/제보</button>
			<button class="nav-tab" onclick="switchContent('settings')">설정</button>
		</div>

		<!-- 프로필 섹션 -->
		<div id="profile" class="content-section active">
			<div class="profile-card">
				<div class="profile-info">
					<div class="profile-avatar">
						<div class="avatar-image" id="avatar">👤</div>
						<button class="edit-btn" onclick="openModal('avatar-modal')">사진 변경</button>
					</div>
					<div>
						<div class="profile-details">
							<div class="detail-item">
								<div class="detail-label">이름</div>
								<div class="detail-value" id="profile-name">사용자 이름</div>
							</div>
							<div class="detail-item">
								<div class="detail-label">이메일</div>
								<div class="detail-value" id="profile-email">user@email.com</div>
							</div>
							<div class="detail-item">
								<div class="detail-label">전화번호</div>
								<div class="detail-value" id="profile-phone">010-0000-0000</div>
							</div>
							<div class="detail-item">
								<div class="detail-label">주소</div>
								<div class="detail-value" id="profile-address">서울시</div>
							</div>
							<div class="detail-item">
								<div class="detail-label">가입 날짜</div>
								<div class="detail-value" id="profile-joined">2024-01-01</div>
							</div>
							<div class="detail-item">
								<div class="detail-label">계정 상태</div>
								<div class="detail-value" style="color: #28a745;">✓ 활성</div>
							</div>
						</div>
						<button class="edit-btn" onclick="toggleEditForm()">프로필 수정</button>
					</div>
				</div>

				<!-- 프로필 수정 폼 -->
				<div class="edit-form" id="edit-form" style="margin-top: 30px; padding-top: 30px; border-top: 1px solid #e9ecef;">
					<h2 style="margin-bottom: 20px;">프로필 정보 수정</h2>
					<form id="profile-edit-form">
						<div class="form-group">
							<label for="edit-name">이름</label>
							<input type="text" id="edit-name" placeholder="이름 입력">
						</div>
						<div class="form-group">
							<label for="edit-phone">전화번호</label>
							<input type="tel" id="edit-phone" placeholder="010-1234-5678">
						</div>
						<div class="form-group">
							<label for="edit-address">주소</label>
							<input type="text" id="edit-address" placeholder="거주 지역">
						</div>
						<div style="display: flex; gap: 10px;">
							<button type="submit" class="btn btn-primary" style="flex: 1; padding: 10px;">저장</button>
							<button type="button" class="btn btn-secondary" onclick="toggleEditForm()" style="flex: 1; padding: 10px;">취소</button>
						</div>
					</form>
				</div>
			</div>
		</div>

		<!-- 신고/제보 섹션 -->
		<div id="reports" class="content-section">
			<div class="profile-card">
				<h2 style="margin-bottom: 20px;">내 신고/제보</h2>
				
				<!-- 통계 -->
				<div class="stats-grid">
					<div class="stat-box">
						<div class="stat-number" id="total-reports">0</div>
						<div class="stat-label">총 신고/제보</div>
					</div>
					<div class="stat-box">
						<div class="stat-number" id="pending-reports">0</div>
						<div class="stat-label">진행 중</div>
					</div>
					<div class="stat-box">
						<div class="stat-number" id="resolved-reports">0</div>
						<div class="stat-label">해결됨</div>
					</div>
				</div>

				<!-- 신고/제보 목록 -->
				<div id="reports-list" class="report-grid">
					<div class="empty-state">
						<div class="empty-state-icon">📋</div>
						<p>아직 작성한 신고/제보가 없습니다.</p>
					</div>
				</div>
			</div>
		</div>

		<!-- 설정 섹션 -->
		<div id="settings" class="content-section">
			<div class="profile-card">
				<h2 style="margin-bottom: 30px;">계정 설정</h2>
				
				<h3 style="margin-bottom: 20px; color: #333;">보안 설정</h3>
				<div class="form-group">
					<label for="current-password">현재 비밀번호</label>
					<input type="password" id="current-password" placeholder="현재 비밀번호 입력">
				</div>
				<div class="form-group">
					<label for="new-password">새로운 비밀번호</label>
					<input type="password" id="new-password" placeholder="새로운 비밀번호 입력">
				</div>
				<div class="form-group">
					<label for="confirm-password">비밀번호 확인</label>
					<input type="password" id="confirm-password" placeholder="비밀번호 확인">
				</div>
				<button class="btn btn-primary" onclick="changePassword()" style="max-width: 200px;">비밀번호 변경</button>

				<div style="margin-top: 40px; padding-top: 30px; border-top: 1px solid #e9ecef;">
					<h3 style="margin-bottom: 20px; color: #333;">알림 설정</h3>
					<div class="form-group">
						<input type="checkbox" id="email-notifications" checked>
						<label for="email-notifications" style="display: inline; margin-left: 10px;">이메일 알림 수신</label>
					</div>
					<div class="form-group">
						<input type="checkbox" id="sms-notifications" checked>
						<label for="sms-notifications" style="display: inline; margin-left: 10px;">SMS 알림 수신</label>
					</div>
					<button class="btn btn-primary" onclick="saveNotificationSettings()" style="max-width: 200px;">저장</button>
				</div>

				<div style="margin-top: 40px; padding-top: 30px; border-top: 1px solid #e9ecef;">
					<h3 style="margin-bottom: 20px; color: #dc3545;">계정 삭제</h3>
					<p style="color: #666; margin-bottom: 15px;">주의: 계정을 삭제하면 모든 데이터가 영구적으로 삭제됩니다.</p>
					<button class="btn btn-danger" onclick="deleteAccount()" style="max-width: 200px;">계정 삭제</button>
				</div>
			</div>
		</div>
	</div>

	<!-- 모달 -->
	<div id="avatar-modal" class="modal">
		<div class="modal-content">
			<div class="modal-header">
				<h2>프로필 사진 변경</h2>
				<button class="close-btn" onclick="closeModal('avatar-modal')">✕</button>
			</div>
			<div class="form-group">
				<label for="avatar-input">이미지 선택</label>
				<input type="file" id="avatar-input" accept="image/*">
			</div>
			<div style="display: flex; gap: 10px;">
				<button class="btn btn-primary" onclick="updateAvatar()" style="flex: 1;">확인</button>
				<button class="btn btn-secondary" onclick="closeModal('avatar-modal')" style="flex: 1;">취소</button>
			</div>
		</div>
	</div>

	<script>
		// 프로필 초기화
		function initProfile() {
			const userEmail = sessionStorage.getItem('userEmail');
			const userName = sessionStorage.getItem('userName');
			
			if (!userEmail) {
				alert('로그인이 필요합니다.');
				window.location.href = 'auth.php';
				return;
			}

			document.getElementById('profile-name').textContent = userName || '사용자';
			document.getElementById('profile-email').textContent = userEmail;
			document.getElementById('profile-phone').textContent = '010-1234-5678';
			document.getElementById('profile-address').textContent = '서울시';
			document.getElementById('profile-joined').textContent = new Date().toISOString().split('T')[0];
			
			// 수정 폼에 초기값 설정
			document.getElementById('edit-name').value = userName || '';
			document.getElementById('edit-phone').value = '010-1234-5678';
			document.getElementById('edit-address').value = '서울시';

			// 샘플 신고/제보 로드
			loadReports();
		}

		// 콘텐츠 섹션 전환
		function switchContent(contentId) {
			const sections = document.querySelectorAll('.content-section');
			sections.forEach(s => s.classList.remove('active'));
			document.getElementById(contentId).classList.add('active');

			const tabs = document.querySelectorAll('.nav-tab');
			tabs.forEach(t => t.classList.remove('active'));
			event.target.classList.add('active');
		}

		// 프로필 수정 폼 토글
		function toggleEditForm() {
			const form = document.getElementById('edit-form');
			form.classList.toggle('active');
		}

		// 모달 열기
		function openModal(modalId) {
			document.getElementById(modalId).classList.add('active');
		}

		// 모달 닫기
		function closeModal(modalId) {
			document.getElementById(modalId).classList.remove('active');
		}

		// 프로필 사진 업데이트
		function updateAvatar() {
			const input = document.getElementById('avatar-input');
			if (input.files && input.files[0]) {
				const reader = new FileReader();
				reader.onload = function(e) {
					const avatar = document.getElementById('avatar');
					avatar.style.backgroundImage = `url('${e.target.result}')`;
					avatar.style.backgroundSize = 'cover';
					avatar.style.backgroundPosition = 'center';
					avatar.textContent = '';
					closeModal('avatar-modal');
					alert('프로필 사진이 업데이트되었습니다.');
				};
				reader.readAsDataURL(input.files[0]);
			}
		}

		// 프로필 수정 폼 제출
		document.getElementById('profile-edit-form').addEventListener('submit', function(e) {
			e.preventDefault();
			const name = document.getElementById('edit-name').value;
			const phone = document.getElementById('edit-phone').value;
			const address = document.getElementById('edit-address').value;

			document.getElementById('profile-name').textContent = name;
			document.getElementById('profile-phone').textContent = phone;
			document.getElementById('profile-address').textContent = address;

			toggleEditForm();
			alert('프로필이 업데이트되었습니다.');
		});

		// 신고/제보 로드
		function loadReports() {
			const sampleReports = [];

			const reportsList = document.getElementById('reports-list');
			const totalReports = document.getElementById('total-reports');
			const pendingReports = document.getElementById('pending-reports');
			const resolvedReports = document.getElementById('resolved-reports');

			totalReports.textContent = sampleReports.length;
			pendingReports.textContent = sampleReports.filter(r => r.status === 'pending').length;
			resolvedReports.textContent = sampleReports.filter(r => r.status === 'resolved').length;

			if (sampleReports.length > 0) {
				reportsList.innerHTML = sampleReports.map(report => `
					<div class="report-card">
						<span class="report-status ${report.status}">
							${report.status === 'pending' ? '진행 중' : '해결됨'}
						</span>
						<div class="report-title">${report.title}</div>
						<div class="report-meta">
							<span>📍 ${report.location}</span>
							<span>📅 ${report.date}</span>
						</div>
						<div class="report-content">${report.content}</div>
						<div class="report-actions">
							<button onclick="viewReportDetail(${report.id})">상세보기</button>
							<button onclick="editReport(${report.id})">수정</button>
							<button onclick="deleteReport(${report.id})">삭제</button>
						</div>
					</div>
				`).join('');
			} else {
				reportsList.innerHTML = '<div class="empty-state"><div class="empty-state-icon">📋</div><p>아직 작성한 신고/제보가 없습니다.</p></div>';
			}
		}

		// 신고/제보 상세 보기
		function viewReportDetail(id) {
			alert(`신고/제보 #${id}의 상세 정보입니다.`);
		}

		// 신고/제보 수정
		function editReport(id) {
			alert(`신고/제보 #${id}를 수정합니다.`);
		}

		// 신고/제보 삭제
		function deleteReport(id) {
			if (confirm('정말로 삭제하시겠습니까?')) {
				alert(`신고/제보 #${id}가 삭제되었습니다.`);
				loadReports();
			}
		}

		// 비밀번호 변경
		function changePassword() {
			const current = document.getElementById('current-password').value;
			const newPass = document.getElementById('new-password').value;
			const confirm = document.getElementById('confirm-password').value;

			if (!current || !newPass || !confirm) {
				alert('모든 필드를 입력해주세요.');
				return;
			}

			if (newPass !== confirm) {
				alert('새로운 비밀번호가 일치하지 않습니다.');
				return;
			}

			alert('비밀번호가 변경되었습니다.');
			document.getElementById('current-password').value = '';
			document.getElementById('new-password').value = '';
			document.getElementById('confirm-password').value = '';
		}

		// 알림 설정 저장
		function saveNotificationSettings() {
			alert('알림 설정이 저장되었습니다.');
		}

		// 계정 삭제
		function deleteAccount() {
			if (confirm('정말로 계정을 삭제하시겠습니까? 이 작업은 취소할 수 없습니다.')) {
				sessionStorage.clear();
				alert('계정이 삭제되었습니다.');
				window.location.href = 'auth.php';
			}
		}

		// 로그아웃
		function logout() {
			if (confirm('로그아웃하시겠습니까?')) {
				sessionStorage.clear();
				window.location.href = 'auth.php';
			}
		}

		// 페이지 로드 시 초기화
		window.addEventListener('load', initProfile);
	</script>
</body>
</html>
