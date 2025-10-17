<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8"/>
	<title>내 신고/제보 관리</title>
	<style>
		* { margin: 0; padding: 0; box-sizing: border-box; }
		body { 
			font-family: Arial, sans-serif; 
			background: #f8f9fa; 
			min-height: 100vh;
		}
		.container { 
			max-width: 1200px; 
			margin: 0 auto; 
			padding: 20px;
		}
		.header { 
			background: white; 
			padding: 30px; 
			border-radius: 10px; 
			margin-bottom: 30px; 
			box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
			display: flex;
			justify-content: space-between;
			align-items: center;
		}
		.header h1 { 
			color: #333; 
			font-size: 28px;
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
			transition: all 0.3s;
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
		.btn-small { 
			padding: 6px 12px; 
			font-size: 12px;
		}
		.filter-section { 
			background: white; 
			padding: 20px; 
			border-radius: 10px; 
			margin-bottom: 20px; 
			box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
		}
		.filter-row { 
			display: grid; 
			grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); 
			gap: 15px; 
			align-items: end;
		}
		.filter-group { 
			display: flex; 
			flex-direction: column;
		}
		.filter-group label { 
			margin-bottom: 8px; 
			color: #333; 
			font-weight: bold; 
			font-size: 14px;
		}
		.filter-group input, .filter-group select { 
			padding: 10px; 
			border: 1px solid #ddd; 
			border-radius: 5px; 
			font-size: 14px;
		}
		.stats-grid { 
			display: grid; 
			grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); 
			gap: 15px; 
			margin-bottom: 20px;
		}
		.stat-card { 
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
			margin-top: 10px;
		}
		.reports-container { 
			display: grid; 
			grid-template-columns: repeat(auto-fill, minmax(350px, 1fr)); 
			gap: 20px;
		}
		.report-card { 
			background: white; 
			border-radius: 10px; 
			padding: 20px; 
			box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
			border-left: 5px solid #4ecdc4;
			display: flex;
			flex-direction: column;
		}
		.report-header { 
			display: flex; 
			justify-content: space-between; 
			align-items: flex-start; 
			margin-bottom: 15px;
		}
		.report-status { 
			display: inline-block; 
			padding: 6px 12px; 
			border-radius: 20px; 
			font-size: 12px; 
			font-weight: bold;
		}
		.status-pending { 
			background: #fff3cd; 
			color: #856404;
		}
		.status-processing { 
			background: #cfe2ff; 
			color: #084298;
		}
		.status-resolved { 
			background: #d1e7dd; 
			color: #0f5132;
		}
		.status-closed { 
			background: #f8d7da; 
			color: #842029;
		}
		.report-title { 
			color: #333; 
			font-size: 18px; 
			font-weight: bold; 
			margin-bottom: 10px;
		}
		.report-meta { 
			display: grid; 
			grid-template-columns: repeat(2, 1fr); 
			gap: 8px; 
			font-size: 13px; 
			color: #666; 
			margin-bottom: 12px;
		}
		.report-meta-item { 
			display: flex; 
			align-items: center; 
			gap: 5px;
		}
		.report-content { 
			color: #555; 
			font-size: 14px; 
			line-height: 1.6; 
			margin-bottom: 15px; 
			flex-grow: 1;
		}
		.report-footer { 
			display: flex; 
			gap: 8px; 
			padding-top: 15px; 
			border-top: 1px solid #e9ecef;
		}
		.report-footer button { 
			flex: 1; 
			padding: 8px; 
			font-size: 12px; 
			cursor: pointer; 
			border: none; 
			border-radius: 5px;
			transition: all 0.3s;
		}
		.btn-view { 
			background: #4ecdc4; 
			color: white;
		}
		.btn-view:hover { 
			background: #3bb8a8;
		}
		.btn-edit { 
			background: #f8f9fa; 
			color: #333; 
			border: 1px solid #ddd;
		}
		.btn-edit:hover { 
			background: #e9ecef;
		}
		.btn-delete { 
			background: #f8f9fa; 
			color: #dc3545; 
			border: 1px solid #ddd;
		}
		.btn-delete:hover { 
			background: #ffe5e5;
		}
		.list-view { 
			background: white; 
			border-radius: 10px; 
			box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
			overflow: hidden;
		}
		.list-item { 
			display: grid; 
			grid-template-columns: 1fr 150px 150px 150px; 
			gap: 20px; 
			padding: 20px; 
			border-bottom: 1px solid #e9ecef; 
			align-items: center;
		}
		.list-item:last-child { 
			border-bottom: none;
		}
		.list-item-info h3 { 
			color: #333; 
			margin-bottom: 5px; 
			font-size: 16px;
		}
		.list-item-info p { 
			color: #666; 
			font-size: 13px;
		}
		.list-item-date { 
			color: #666; 
			font-size: 13px;
		}
		.list-item-actions { 
			display: flex; 
			gap: 5px;
		}
		.view-toggle { 
			display: flex; 
			gap: 5px; 
			margin-left: 20px;
		}
		.view-btn { 
			padding: 8px 12px; 
			background: #f8f9fa; 
			border: 1px solid #ddd; 
			border-radius: 5px; 
			cursor: pointer;
		}
		.view-btn.active { 
			background: #4ecdc4; 
			color: white; 
			border-color: #4ecdc4;
		}
		.empty-state { 
			text-align: center; 
			padding: 60px 20px;
		}
		.empty-state-icon { 
			font-size: 48px; 
			margin-bottom: 15px;
		}
		.empty-state-text { 
			color: #999; 
			font-size: 16px;
		}
		.modal { 
			display: none; 
			position: fixed; 
			top: 0; 
			left: 0; 
			width: 100%; 
			height: 100%; 
			background: rgba(0, 0, 0, 0.5); 
			z-index: 1000; 
			justify-content: center; 
			align-items: center;
		}
		.modal.active { 
			display: flex;
		}
		.modal-content { 
			background: white; 
			padding: 30px; 
			border-radius: 10px; 
			max-width: 600px; 
			width: 90%; 
			max-height: 80vh; 
			overflow-y: auto;
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
		.form-group { 
			margin-bottom: 20px;
		}
		.form-group label { 
			display: block; 
			margin-bottom: 8px; 
			color: #333; 
			font-weight: bold;
		}
		.form-group input, .form-group textarea, .form-group select { 
			width: 100%; 
			padding: 12px; 
			border: 1px solid #ddd; 
			border-radius: 5px; 
			font-size: 14px; 
			font-family: Arial;
		}
		.form-group textarea { 
			min-height: 120px; 
			resize: vertical;
		}
		.form-group input:focus, .form-group textarea:focus, .form-group select:focus { 
			outline: none; 
			border-color: #4ecdc4; 
			box-shadow: 0 0 5px rgba(78, 205, 196, 0.3);
		}
		.modal-footer { 
			display: flex; 
			gap: 10px; 
			margin-top: 20px;
		}
		.modal-footer button { 
			flex: 1; 
			padding: 12px;
		}
		.tag { 
			display: inline-block; 
			background: #e9ecef; 
			color: #666; 
			padding: 4px 10px; 
			border-radius: 15px; 
			font-size: 12px; 
			margin-right: 5px;
		}
		@media (max-width: 768px) {
			.list-item { 
				grid-template-columns: 1fr;
			}
			.reports-container { 
				grid-template-columns: 1fr;
			}
		}
	</style>
</head>
<body>
	<div class="container">
		<!-- 헤더 -->
		<div class="header">
			<div>
				<h1>📋 내 신고/제보 관리</h1>
			</div>
			<div class="header-actions">
				<div class="view-toggle">
					<button class="view-btn active" onclick="switchView('grid')">🔲 격자형</button>
					<button class="view-btn" onclick="switchView('list')">☰ 목록형</button>
				</div>
				<button class="btn btn-primary" onclick="openModal('create-modal')">+ 새 신고/제보</button>
				<a href="profile.php" class="btn btn-secondary">프로필</a>
			</div>
		</div>

		<!-- 필터 섹션 -->
		<div class="filter-section">
			<div class="filter-row">
				<div class="filter-group">
					<label for="filter-status">상태</label>
					<select id="filter-status">
						<option value="">모든 상태</option>
						<option value="pending">대기 중</option>
						<option value="processing">진행 중</option>
						<option value="resolved">해결됨</option>
						<option value="closed">종료됨</option>
					</select>
				</div>
				<div class="filter-group">
					<label for="filter-date">기간</label>
					<select id="filter-date">
						<option value="">전체</option>
						<option value="week">지난 1주</option>
						<option value="month">지난 1개월</option>
						<option value="3months">지난 3개월</option>
					</select>
				</div>
				<div class="filter-group">
					<label for="filter-search">검색</label>
					<input type="text" id="filter-search" placeholder="제목이나 내용으로 검색">
				</div>
				<button class="btn btn-primary" onclick="applyFilters()">검색</button>
				<button class="btn btn-secondary" onclick="resetFilters()">초기화</button>
			</div>
		</div>

		<!-- 통계 -->
		<div class="stats-grid">
			<div class="stat-card">
				<div class="stat-number" id="stat-total">0</div>
				<div class="stat-label">총 신고/제보</div>
			</div>
			<div class="stat-card">
				<div class="stat-number" id="stat-pending">0</div>
				<div class="stat-label">대기 중</div>
			</div>
			<div class="stat-card">
				<div class="stat-number" id="stat-processing">0</div>
				<div class="stat-label">진행 중</div>
			</div>
			<div class="stat-card">
				<div class="stat-number" id="stat-resolved">0</div>
				<div class="stat-label">해결됨</div>
			</div>
		</div>

		<!-- 신고/제보 목록 (격자형) -->
		<div id="grid-view" class="reports-container"></div>

		<!-- 신고/제보 목록 (목록형) -->
		<div id="list-view" class="list-view" style="display: none;">
			<div id="list-items"></div>
		</div>

		<!-- 빈 상태 -->
		<div id="empty-state" class="empty-state" style="display: none;">
			<div class="empty-state-icon">📭</div>
			<div class="empty-state-text">작성한 신고/제보가 없습니다.</div>
		</div>
	</div>

	<!-- 신고/제보 생성/수정 모달 -->
	<div id="create-modal" class="modal">
		<div class="modal-content">
			<div class="modal-header">
				<h2 id="modal-title">새 신고/제보 작성</h2>
				<button class="close-btn" onclick="closeModal('create-modal')">✕</button>
			</div>
			<form id="report-form">
				<div class="form-group">
					<label for="report-title">제목</label>
					<input type="text" id="report-title" required placeholder="신고/제보 제목 입력">
				</div>
				<div class="form-group">
					<label for="report-type">유형</label>
					<select id="report-type" required>
						<option value="">선택해주세요</option>
						<option value="missing">실종</option>
						<option value="sighting">목격</option>
						<option value="found">발견</option>
						<option value="injury">부상</option>
						<option value="other">기타</option>
					</select>
				</div>
				<div class="form-group">
					<label for="report-location">위치</label>
					<input type="text" id="report-location" required placeholder="사건 발생 장소">
				</div>
				<div class="form-group">
					<label for="report-date">날짜</label>
					<input type="date" id="report-date" required>
				</div>
				<div class="form-group">
					<label for="report-content">상세 내용</label>
					<textarea id="report-content" required placeholder="가능한 자세한 내용을 입력해주세요"></textarea>
				</div>
				<div class="form-group">
					<label for="report-photo">사진</label>
					<input type="file" id="report-photo" accept="image/*">
				</div>
				<div class="form-group">
					<label for="report-contact">연락처</label>
					<input type="tel" id="report-contact" placeholder="010-1234-5678">
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-primary">저장</button>
					<button type="button" class="btn btn-secondary" onclick="closeModal('create-modal')">취소</button>
				</div>
			</form>
		</div>
	</div>

	<!-- 신고/제보 상세 보기 모달 -->
	<div id="detail-modal" class="modal">
		<div class="modal-content">
			<div class="modal-header">
				<h2>신고/제보 상세</h2>
				<button class="close-btn" onclick="closeModal('detail-modal')">✕</button>
			</div>
			<div id="detail-content"></div>
		</div>
	</div>

	<script>
		// 샘플 데이터
		let reports = [
			{
				id: 1,
				title: '진돗개 강아지 실종',
				type: 'missing',
				location: '서울시 강남구 테헤란로',
				date: '2024-01-15',
				content: '빨간색 목걸이를 한 진돗개가 2일전부터 실종되었습니다. 특이사항: 오른쪽 귀가 약간 접혀있습니다. 목격 정보 부탁드립니다.',
				contact: '010-1234-5678',
				status: 'pending',
				createdDate: '2024-01-16'
			},
			{
				id: 2,
				title: '고양이 목격 제보',
				type: 'sighting',
				location: '서울시 서초구 방배동',
				date: '2024-01-10',
				content: '길잃은 검은색 고양이를 봤습니다. 혹시 찾는 고양이일까요?',
				contact: '010-9876-5432',
				status: 'processing',
				createdDate: '2024-01-14'
			},
			{
				id: 3,
				title: '푸들 강아지 발견',
				type: 'found',
				location: '서울시 송파구 올림픽공원',
				date: '2024-01-12',
				content: '흰색 푸들 강아지를 발견했습니다. 주인이 있으신분 연락주세요.',
				contact: '010-5555-6666',
				status: 'resolved',
				createdDate: '2024-01-13'
			}
		];

		// 현재 보기 모드
		let currentView = 'grid';

		// 페이지 초기화
		function init() {
			const userEmail = sessionStorage.getItem('userEmail');
			if (!userEmail) {
				alert('로그인이 필요합니다.');
				window.location.href = 'auth.php';
				return;
			}
			
			loadReports();
			setDefaultDate();
		}

		// 기본 날짜 설정
		function setDefaultDate() {
			const today = new Date().toISOString().split('T')[0];
			document.getElementById('report-date').value = today;
		}

		// 신고/제보 로드
		function loadReports() {
			updateStats();
			renderReports();
		}

		// 통계 업데이트
		function updateStats() {
			document.getElementById('stat-total').textContent = reports.length;
			document.getElementById('stat-pending').textContent = reports.filter(r => r.status === 'pending').length;
			document.getElementById('stat-processing').textContent = reports.filter(r => r.status === 'processing').length;
			document.getElementById('stat-resolved').textContent = reports.filter(r => r.status === 'resolved').length;
		}

		// 신고/제보 렌더링
		function renderReports() {
			if (reports.length === 0) {
				document.getElementById('empty-state').style.display = 'block';
				document.getElementById('grid-view').style.display = 'none';
				document.getElementById('list-view').style.display = 'none';
				return;
			}

			document.getElementById('empty-state').style.display = 'none';

			// 격자형 렌더링
			const gridView = document.getElementById('grid-view');
			gridView.innerHTML = reports.map(report => `
				<div class="report-card">
					<div class="report-header">
						<span class="report-status status-${report.status}">
							${getStatusText(report.status)}
						</span>
						<span class="tag">${getTypeText(report.type)}</span>
					</div>
					<div class="report-title">${report.title}</div>
					<div class="report-meta">
						<div class="report-meta-item">📍 ${report.location}</div>
						<div class="report-meta-item">📅 ${report.date}</div>
					</div>
					<div class="report-content">${report.content.substring(0, 100)}...</div>
					<div class="report-footer">
						<button class="btn-view" onclick="viewDetail(${report.id})">상세보기</button>
						<button class="btn-edit" onclick="editReport(${report.id})">수정</button>
						<button class="btn-delete" onclick="deleteReport(${report.id})">삭제</button>
					</div>
				</div>
			`).join('');

			// 목록형 렌더링
			const listItems = document.getElementById('list-items');
			listItems.innerHTML = reports.map(report => `
				<div class="list-item">
					<div class="list-item-info">
						<h3>${report.title}</h3>
						<p>${report.content.substring(0, 50)}...</p>
					</div>
					<div class="list-item-date">${report.date}</div>
					<div class="report-status status-${report.status}">${getStatusText(report.status)}</div>
					<div class="list-item-actions">
						<button class="btn btn-small btn-view" onclick="viewDetail(${report.id})">상세</button>
						<button class="btn btn-small btn-edit" onclick="editReport(${report.id})">수정</button>
						<button class="btn btn-small btn-delete" onclick="deleteReport(${report.id})">삭제</button>
					</div>
				</div>
			`).join('');
		}

		// 상태 텍스트 변환
		function getStatusText(status) {
			const statusMap = {
				'pending': '대기 중',
				'processing': '진행 중',
				'resolved': '해결됨',
				'closed': '종료됨'
			};
			return statusMap[status] || status;
		}

		// 유형 텍스트 변환
		function getTypeText(type) {
			const typeMap = {
				'missing': '실종',
				'sighting': '목격',
				'found': '발견',
				'injury': '부상',
				'other': '기타'
			};
			return typeMap[type] || type;
		}

		// 보기 모드 전환
		function switchView(view) {
			currentView = view;
			const buttons = document.querySelectorAll('.view-btn');
			buttons.forEach(btn => btn.classList.remove('active'));
			event.target.classList.add('active');

			if (view === 'grid') {
				document.getElementById('grid-view').style.display = 'grid';
				document.getElementById('list-view').style.display = 'none';
			} else {
				document.getElementById('grid-view').style.display = 'none';
				document.getElementById('list-view').style.display = 'block';
			}
		}

		// 모달 열기
		function openModal(modalId) {
			document.getElementById(modalId).classList.add('active');
		}

		// 모달 닫기
		function closeModal(modalId) {
			document.getElementById(modalId).classList.remove('active');
			if (modalId === 'create-modal') {
				document.getElementById('report-form').reset();
				setDefaultDate();
			}
		}

		// 상세 보기
		function viewDetail(id) {
			const report = reports.find(r => r.id === id);
			if (!report) return;

			const detailContent = document.getElementById('detail-content');
			detailContent.innerHTML = `
				<div class="form-group">
					<label>제목</label>
					<p style="font-size: 16px; font-weight: bold;">${report.title}</p>
				</div>
				<div class="form-group">
					<label>유형</label>
					<p>${getTypeText(report.type)}</p>
				</div>
				<div class="form-group">
					<label>상태</label>
					<p>
						<span class="report-status status-${report.status}">
							${getStatusText(report.status)}
						</span>
					</p>
				</div>
				<div class="form-group">
					<label>위치</label>
					<p>${report.location}</p>
				</div>
				<div class="form-group">
					<label>날짜</label>
					<p>${report.date}</p>
				</div>
				<div class="form-group">
					<label>상세 내용</label>
					<p style="line-height: 1.6;">${report.content}</p>
				</div>
				<div class="form-group">
					<label>연락처</label>
					<p>${report.contact}</p>
				</div>
				<div class="form-group">
					<label>작성 날짜</label>
					<p>${report.createdDate}</p>
				</div>
			`;
			openModal('detail-modal');
		}

		// 수정
		function editReport(id) {
			const report = reports.find(r => r.id === id);
			if (!report) return;

			document.getElementById('modal-title').textContent = '신고/제보 수정';
			document.getElementById('report-title').value = report.title;
			document.getElementById('report-type').value = report.type;
			document.getElementById('report-location').value = report.location;
			document.getElementById('report-date').value = report.date;
			document.getElementById('report-content').value = report.content;
			document.getElementById('report-contact').value = report.contact;

			// 저장 버튼 동작 변경
			const form = document.getElementById('report-form');
			form.onsubmit = function(e) {
				e.preventDefault();
				report.title = document.getElementById('report-title').value;
				report.type = document.getElementById('report-type').value;
				report.location = document.getElementById('report-location').value;
				report.date = document.getElementById('report-date').value;
				report.content = document.getElementById('report-content').value;
				report.contact = document.getElementById('report-contact').value;
				
				alert('신고/제보가 수정되었습니다.');
				closeModal('create-modal');
				loadReports();
			};

			openModal('create-modal');
		}

		// 삭제
		function deleteReport(id) {
			if (confirm('정말로 삭제하시겠습니까?')) {
				reports = reports.filter(r => r.id !== id);
				alert('신고/제보가 삭제되었습니다.');
				loadReports();
			}
		}

		// 필터 적용
		function applyFilters() {
			const status = document.getElementById('filter-status').value;
			const search = document.getElementById('filter-search').value.toLowerCase();

			const filtered = reports.filter(report => {
				let match = true;
				if (status && report.status !== status) match = false;
				if (search && !report.title.toLowerCase().includes(search) && 
					!report.content.toLowerCase().includes(search)) match = false;
				return match;
			});

			renderFiltered(filtered);
		}

		// 필터 렌더링
		function renderFiltered(filtered) {
			if (filtered.length === 0) {
				document.getElementById('empty-state').style.display = 'block';
				document.getElementById('grid-view').style.display = 'none';
				document.getElementById('list-view').style.display = 'none';
				return;
			}

			document.getElementById('empty-state').style.display = 'none';
			const gridView = document.getElementById('grid-view');
			gridView.innerHTML = filtered.map(report => `
				<div class="report-card">
					<div class="report-header">
						<span class="report-status status-${report.status}">
							${getStatusText(report.status)}
						</span>
						<span class="tag">${getTypeText(report.type)}</span>
					</div>
					<div class="report-title">${report.title}</div>
					<div class="report-meta">
						<div class="report-meta-item">📍 ${report.location}</div>
						<div class="report-meta-item">📅 ${report.date}</div>
					</div>
					<div class="report-content">${report.content.substring(0, 100)}...</div>
					<div class="report-footer">
						<button class="btn-view" onclick="viewDetail(${report.id})">상세보기</button>
						<button class="btn-edit" onclick="editReport(${report.id})">수정</button>
						<button class="btn-delete" onclick="deleteReport(${report.id})">삭제</button>
					</div>
				</div>
			`).join('');
		}

		// 필터 초기화
		function resetFilters() {
			document.getElementById('filter-status').value = '';
			document.getElementById('filter-date').value = '';
			document.getElementById('filter-search').value = '';
			loadReports();
		}

		// 폼 제출
		document.getElementById('report-form').addEventListener('submit', function(e) {
			e.preventDefault();

			const newReport = {
				id: Math.max(...reports.map(r => r.id), 0) + 1,
				title: document.getElementById('report-title').value,
				type: document.getElementById('report-type').value,
				location: document.getElementById('report-location').value,
				date: document.getElementById('report-date').value,
				content: document.getElementById('report-content').value,
				contact: document.getElementById('report-contact').value,
				status: 'pending',
				createdDate: new Date().toISOString().split('T')[0]
			};

			reports.push(newReport);
			alert('신고/제보가 작성되었습니다.');
			closeModal('create-modal');
			loadReports();
		});

		// 초기화
		window.addEventListener('load', init);
	</script>
</body>
</html>
