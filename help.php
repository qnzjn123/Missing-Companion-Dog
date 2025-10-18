<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8"/>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>도움말 - 반려동물 실종</title>
	<style>
		* { margin: 0; padding: 0; box-sizing: border-box; }
		body { 
			font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
			background: #f5f7fa;
			color: #333;
		}
		.header {
			background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
			color: white;
			padding: 20px;
			text-align: center;
			position: sticky;
			top: 0;
			z-index: 100;
			box-shadow: 0 2px 10px rgba(0,0,0,0.1);
		}
		.header h1 {
			font-size: 28px;
			margin-bottom: 5px;
		}
		.header p {
			font-size: 14px;
			opacity: 0.9;
		}
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
		.back-btn:hover {
			background: #f0f0f0;
		}
		.container {
			max-width: 800px;
			margin: 0 auto;
			padding: 20px;
		}
		.help-section {
			background: white;
			border-radius: 10px;
			padding: 25px;
			margin-bottom: 20px;
			box-shadow: 0 2px 10px rgba(0,0,0,0.05);
		}
		.help-section h2 {
			color: #667eea;
			margin-bottom: 15px;
			padding-bottom: 10px;
			border-bottom: 2px solid #667eea;
			font-size: 22px;
		}
		.help-section h3 {
			color: #764ba2;
			margin-top: 20px;
			margin-bottom: 10px;
			font-size: 16px;
		}
		.help-section p {
			line-height: 1.8;
			margin-bottom: 10px;
			color: #666;
		}
		.help-section ul {
			margin-left: 20px;
			margin-bottom: 15px;
		}
		.help-section li {
			line-height: 1.8;
			margin-bottom: 8px;
			color: #666;
		}
		.step-container {
			background: #f8f9fa;
			padding: 15px;
			border-radius: 8px;
			margin: 15px 0;
			border-left: 4px solid #667eea;
		}
		.step-number {
			background: #667eea;
			color: white;
			width: 30px;
			height: 30px;
			border-radius: 50%;
			display: flex;
			align-items: center;
			justify-content: center;
			font-weight: bold;
			margin-right: 10px;
			float: left;
		}
		.step-content {
			overflow: hidden;
		}
		.faq-item {
			background: #f8f9fa;
			padding: 15px;
			border-radius: 8px;
			margin-bottom: 15px;
			cursor: pointer;
			border-left: 4px solid #764ba2;
			transition: all 0.3s;
		}
		.faq-item:hover {
			background: #f0f0f0;
		}
		.faq-question {
			font-weight: bold;
			color: #764ba2;
			margin-bottom: 10px;
		}
		.faq-answer {
			display: none;
			color: #666;
			margin-top: 10px;
		}
		.faq-item.open .faq-answer {
			display: block;
		}
		.faq-item.open .faq-question::after {
			content: ' ▼';
		}
		.faq-question::after {
			content: ' ▶';
			transition: all 0.3s;
		}
		.tip-box {
			background: #e8f4f8;
			border-left: 4px solid #4ecdc4;
			padding: 15px;
			border-radius: 8px;
			margin: 15px 0;
		}
		.tip-box strong {
			color: #4ecdc4;
		}
		.warning-box {
			background: #fff3cd;
			border-left: 4px solid #ffc107;
			padding: 15px;
			border-radius: 8px;
			margin: 15px 0;
		}
		.warning-box strong {
			color: #ff9800;
		}

		/* 모바일 반응형 */
		@media (max-width: 768px) {
			.header h1 { font-size: 20px; }
			.back-btn {
				top: 10px;
				left: 10px;
				padding: 8px 15px;
				font-size: 12px;
			}
			.container { padding: 15px; }
			.help-section { padding: 15px; margin-bottom: 15px; }
			.help-section h2 { font-size: 18px; }
			.help-section h3 { font-size: 14px; }
			.help-section p { font-size: 13px; }
		}
	</style>
</head>
<body>
	<button class="back-btn" onclick="history.back()">← 돌아가기</button>

	<div class="header">
		<h1>🐾 도움말</h1>
		<p>반려동물 실종 앱 사용 가이드</p>
	</div>

	<div class="container">
		<!-- 시작하기 -->
		<div class="help-section">
			<h2>🚀 시작하기</h2>
			<h3>로그인 / 회원가입</h3>
			<p>앱의 모든 기능을 사용하려면 먼저 로그인 또는 회원가입을 해야 합니다.</p>
			<div class="step-container">
				<div class="step-number">1</div>
				<div class="step-content">
					<strong>로그인 페이지 접속</strong>
					<p>메인 페이지에서 "로그인" 버튼을 클릭하세요.</p>
				</div>
			</div>
			<div class="step-container">
				<div class="step-number">2</div>
				<div class="step-content">
					<strong>계정 선택</strong>
					<p>기존 계정이 있으면 "로그인", 없으면 "회원가입" 탭을 선택하세요.</p>
				</div>
			</div>
			<div class="step-container">
				<div class="step-number">3</div>
				<div class="step-content">
					<strong>정보 입력 및 제출</strong>
					<p>필요한 정보를 입력하고 "로그인" 또는 "회원가입" 버튼을 클릭하세요.</p>
				</div>
			</div>

			<div class="tip-box">
				<strong>💡 팁:</strong> 로그인 상태 유지 옵션을 선택하면 다음에 더 편리하게 로그인할 수 있습니다.
			</div>
		</div>

		<!-- 실종 신고하기 -->
		<div class="help-section">
			<h2>📢 실종 신고하기</h2>
			<p>반려동물을 잃어버렸을 때 신고하는 방법입니다.</p>
			<div class="step-container">
				<div class="step-number">1</div>
				<div class="step-content">
					<strong>로그인 확인</strong>
					<p>반드시 로그인 상태여야 합니다.</p>
				</div>
			</div>
			<div class="step-container">
				<div class="step-number">2</div>
				<div class="step-content">
					<strong>"실종 신고" 탭 선택</strong>
					<p>사이드바의 "실종 신고" 탭을 클릭하세요.</p>
				</div>
			</div>
			<div class="step-container">
				<div class="step-number">3</div>
				<div class="step-content">
					<strong>정보 작성</strong>
					<ul>
						<li><strong>제목:</strong> 반려동물 이름 또는 간단한 설명</li>
						<li><strong>품종/색상:</strong> 반려동물의 특징 (예: 푸들/갈색)</li>
						<li><strong>설명:</strong> 마지막으로 본 장소, 시간, 기타 특징</li>
						<li><strong>연락처:</strong> 목격자들이 연락할 수 있도록 입력</li>
						<li><strong>사진:</strong> 반려동물의 사진을 첨부하면 더 효과적입니다</li>
					</ul>
				</div>
			</div>
			<div class="step-container">
				<div class="step-number">4</div>
				<div class="step-content">
					<strong>지도에 위치 표시</strong>
					<p>지도에서 실종된 장소를 클릭하여 표시하세요. 마커를 드래그하여 위치를 조정할 수 있습니다.</p>
				</div>
			</div>
			<div class="step-container">
				<div class="step-number">5</div>
				<div class="step-content">
					<strong>신고 제출</strong>
					<p>"신고 제출" 버튼을 클릭하면 모든 사용자에게 공개됩니다.</p>
				</div>
			</div>

			<div class="warning-box">
				<strong>⚠️ 주의:</strong> 정확한 정보를 입력할수록 반려동물을 찾을 확률이 높아집니다.
			</div>
		</div>

		<!-- 목격 제보하기 -->
		<div class="help-section">
			<h2>👁️ 목격 제보하기</h2>
			<p>실종된 반려동물을 목격했을 때 제보하는 방법입니다.</p>
			<div class="step-container">
				<div class="step-number">1</div>
				<div class="step-content">
					<strong>로그인 확인</strong>
					<p>반드시 로그인 상태여야 합니다.</p>
				</div>
			</div>
			<div class="step-container">
				<div class="step-number">2</div>
				<div class="step-content">
					<strong>"목격 제보" 탭 선택</strong>
					<p>사이드바의 "목격 제보" 탭을 클릭하세요.</p>
				</div>
			</div>
			<div class="step-container">
				<div class="step-number">3</div>
				<div class="step-content">
					<strong>정보 작성</strong>
					<ul>
						<li><strong>제목:</strong> 목격 위치 및 반려동물 특징</li>
						<li><strong>상세 설명:</strong> 어디서, 언제, 어떤 상황에서 목격했는지</li>
						<li><strong>반려동물 특징:</strong> 종류, 색상, 크기 등 가능한 상세하게</li>
						<li><strong>연락처:</strong> 당신의 연락처 (신고자가 확인할 수 있도록)</li>
						<li><strong>사진:</strong> 목격한 반려동물의 사진이 있으면 첨부</li>
					</ul>
				</div>
			</div>
			<div class="step-container">
				<div class="step-number">4</div>
				<div class="step-content">
					<strong>지도에 위치 표시</strong>
					<p>목격 장소를 지도에 표시하세요.</p>
				</div>
			</div>
			<div class="step-container">
				<div class="step-number">5</div>
				<div class="step-content">
					<strong>제보 제출</strong>
					<p>"제보 제출" 버튼을 클릭하면 신고자가 이 정보를 볼 수 있습니다.</p>
				</div>
			</div>

			<div class="tip-box">
				<strong>💡 팁:</strong> 가능한 빨리 제보할수록 좋습니다. 정보가 신선할수록 도움이 됩니다.
			</div>
		</div>

		<!-- 지도 사용하기 -->
		<div class="help-section">
			<h2>🗺️ 지도 사용하기</h2>
			<h3>기본 조작</h3>
			<ul>
				<li><strong>마우스 스크롤:</strong> 지도 확대/축소</li>
				<li><strong>마우스 드래그:</strong> 지도 이동</li>
				<li><strong>더블클릭:</strong> 해당 위치 확대</li>
			</ul>
			<h3>마커 사용</h3>
			<ul>
				<li><strong>마커 클릭:</strong> 신고/제보 상세 정보 확인</li>
				<li><strong>마커 드래그:</strong> 위치 조정</li>
				<li><strong>마커 색상:</strong> 빨강(실종), 파랑(목격)</li>
			</ul>
			<h3>필터링</h3>
			<ul>
				<li>화면 상단의 필터를 사용하여 특정 지역이나 기간의 신고만 볼 수 있습니다.</li>
				<li><strong>종류 필터:</strong> 강아지, 고양이 등 종류별로 필터링</li>
				<li><strong>기간 필터:</strong> 지난 일주일, 한 달 등으로 필터링</li>
			</ul>
		</div>

		<!-- FAQ -->
		<div class="help-section">
			<h2>❓ 자주 묻는 질문 (FAQ)</h2>

			<div class="faq-item">
				<div class="faq-question">Q: 회원가입 없이 신고를 볼 수 있나요?</div>
				<div class="faq-answer">A: 예, 신고를 보는 것만 가능합니다. 하지만 신고하거나 제보하려면 반드시 회원가입과 로그인이 필요합니다.</div>
			</div>

			<div class="faq-item">
				<div class="faq-question">Q: 신고한 내용을 수정할 수 있나요?</div>
				<div class="faq-answer">A: 현재는 신고 후 수정이 불가능합니다. 새로운 신고를 작성하거나 관리자에게 문의하세요.</div>
			</div>

			<div class="faq-item">
				<div class="faq-question">Q: 신고한 반려동물을 찾으면 어떻게 하나요?</div>
				<div class="faq-answer">A: 신고자의 연락처로 직접 연락하여 반려동물의 정보가 일치하는지 확인한 후 반려동물을 돌려주세요. 신고를 삭제하고 싶으면 관리자에게 문의하세요.</div>
			</div>

			<div class="faq-item">
				<div class="faq-question">Q: 잘못된 신고를 발견했어요.</div>
				<div class="faq-answer">A: 해당 신고자의 이메일로 직접 연락하시거나, 관리자에게 문의하세요. 부적절한 신고는 삭제될 수 있습니다.</div>
			</div>

			<div class="faq-item">
				<div class="faq-question">Q: 사진을 첨부하지 않아도 되나요?</div>
				<div class="faq-answer">A: 기술적으로 가능하지만, 사진이 있을 때 훨씬 더 빠르게 찾을 가능성이 높아집니다. 가능하면 선명한 사진을 첨부해주세요.</div>
			</div>

			<div class="faq-item">
				<div class="faq-question">Q: 특정 지역만 검색할 수 있나요?</div>
				<div class="faq-answer">A: 네! 지도에서 원하는 지역을 드래그하여 확인하거나, 필터 기능을 사용하여 특정 지역의 신고만 볼 수 있습니다.</div>
			</div>

			<div class="faq-item">
				<div class="faq-question">Q: 모바일에서도 사용 가능한가요?</div>
				<div class="faq-answer">A: 네, 이 앱은 모바일에 완벽하게 최적화되어 있습니다. 스마트폰의 웹 브라우저에서 바로 사용하실 수 있습니다.</div>
			</div>
		</div>

		<!-- 연락처 -->
		<div class="help-section">
			<h2>📞 문의 및 피드백</h2>
			<p>앱 사용 중 문제가 발생하거나 의견이 있으신가요?</p>
			<ul>
				<li><strong>이메일:</strong> qnzjn8@gmail.com</li>
				<li><strong>문제 신고:</strong> 각 신고 페이지에서 "신고하기" 버튼을 사용하세요.</li>
			</ul>
			<p style="margin-top: 15px; color: #999; font-size: 12px;">
				마지막 업데이트: 2024년 10월<br/>
				© 2024 반려동물 실종 찾기. 모든 권리 보유.
			</p>
		</div>
	</div>

	<script>
		// FAQ 아이템 토글
		document.querySelectorAll('.faq-item').forEach(item => {
			item.addEventListener('click', function() {
				this.classList.toggle('open');
			});
		});
	</script>
</body>
</html>
