<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8"/>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>회원 가입 / 로그인</title>
	<style>
		* { margin: 0; padding: 0; box-sizing: border-box; }
		body { 
			font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; 
			background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); 
			min-height: 100vh; 
			display: flex; 
			justify-content: center; 
			align-items: center; 
			padding: 20px;
		}
		.auth-container { 
			background: white; 
			border-radius: 15px; 
			box-shadow: 0 15px 50px rgba(0, 0, 0, 0.2); 
			width: 100%; 
			max-width: 450px; 
			overflow: hidden;
			animation: slideUp 0.5s ease;
		}
		@keyframes slideUp {
			from { opacity: 0; transform: translateY(30px); }
			to { opacity: 1; transform: translateY(0); }
		}
		.auth-header { 
			background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); 
			padding: 40px 30px; 
			text-align: center; 
			color: white;
		}
		.auth-header h1 { 
			font-size: 32px; 
			margin-bottom: 10px;
		}
		.auth-header p { 
			font-size: 14px;
			opacity: 0.9;
		}
		.auth-tabs { 
			display: flex; 
			border-bottom: 2px solid #e9ecef;
		}
		.auth-tab { 
			flex: 1; 
			padding: 15px; 
			text-align: center; 
			background: #f8f9fa; 
			cursor: pointer; 
			font-weight: bold; 
			color: #666; 
			border: none; 
			font-size: 14px;
			transition: all 0.3s;
		}
		.auth-tab:hover { 
			background: #f0f0f0;
		}
		.auth-tab.active { 
			background: white; 
			color: #667eea; 
			border-bottom: 3px solid #667eea;
		}
		.auth-form { 
			display: none; 
			padding: 30px;
		}
		.auth-form.active { 
			display: block;
		}
		.form-group { 
			margin-bottom: 20px;
		}
		.form-group label { 
			display: block; 
			margin-bottom: 8px; 
			color: #333; 
			font-weight: bold; 
			font-size: 14px;
		}
		.form-group input { 
			width: 100%; 
			padding: 12px; 
			border: 1px solid #ddd; 
			border-radius: 8px; 
			font-size: 14px; 
			transition: all 0.3s;
			font-family: Arial, sans-serif;
		}
		.form-group input:focus { 
			outline: none; 
			border-color: #667eea; 
			box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
		}
		.password-group { 
			position: relative;
		}
		.password-toggle { 
			position: absolute; 
			right: 12px; 
			top: 42px; 
			cursor: pointer; 
			color: #999;
			user-select: none;
		}
		.btn-primary { 
			width: 100%; 
			padding: 12px; 
			background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); 
			color: white; 
			border: none; 
			border-radius: 8px; 
			font-weight: bold; 
			font-size: 16px; 
			cursor: pointer; 
			transition: all 0.3s;
			margin-top: 10px;
		}
		.btn-primary:hover { 
			transform: translateY(-2px);
			box-shadow: 0 10px 25px rgba(102, 126, 234, 0.3);
		}
		.form-footer { 
			text-align: center; 
			margin-top: 15px;
		}
		.form-footer p { 
			color: #666; 
			font-size: 14px;
		}
		.form-footer a { 
			color: #667eea; 
			text-decoration: none; 
			font-weight: bold;
			cursor: pointer;
		}
		.form-footer a:hover { 
			text-decoration: underline;
		}
		.error-message { 
			background: #f8d7da; 
			color: #721c24; 
			padding: 12px; 
			border-radius: 8px; 
			margin-bottom: 20px; 
			border: 1px solid #f5c6cb;
			display: none;
		}
		.error-message.show { 
			display: block;
		}
		.checkbox-group { 
			display: flex; 
			align-items: center; 
			margin-bottom: 20px;
		}
		.checkbox-group input { 
			width: auto; 
			margin-right: 10px; 
			cursor: pointer;
		}
		.checkbox-group label { 
			margin: 0; 
			font-weight: normal; 
			font-size: 13px; 
			color: #666;
		}
		.loading { 
			display: none; 
			text-align: center; 
			margin: 20px 0;
		}
		.spinner { 
			border: 4px solid #f3f3f3; 
			border-top: 4px solid #667eea; 
			border-radius: 50%; 
			width: 40px; 
			height: 40px; 
			animation: spin 1s linear infinite; 
			margin: 0 auto;
		}
		@keyframes spin { 
			0% { transform: rotate(0deg); } 
			100% { transform: rotate(360deg); } 
		}

		/* 모바일 반응형 */
		@media (max-width: 480px) {
			body { padding: 10px; }
			.auth-container { max-width: 100%; }
			.auth-header { padding: 30px 20px; }
			.auth-header h1 { font-size: 24px; }
			.auth-form { padding: 20px; }
			.form-group { margin-bottom: 15px; }
			.form-group input { padding: 10px; font-size: 12px; }
			.btn-primary { padding: 10px; font-size: 14px; }
		}
	</style>
</head>
<body>
	<div class="auth-container">
		<div class="auth-header">
			<h1>🐾 반려동물 실종</h1>
			<p>회원 계정 관리</p>
		</div>

		<div class="auth-tabs">
			<button class="auth-tab active" onclick="switchTab('login')">로그인</button>
			<button class="auth-tab" onclick="switchTab('signup')">회원 가입</button>
		</div>

		<!-- 로그인 폼 -->
		<form class="auth-form active" id="login-form">
			<div class="error-message" id="login-error"></div>
			<div class="loading" id="login-loading"><div class="spinner"></div></div>

			<div class="form-group">
				<label for="login-email">이메일</label>
				<input type="email" id="login-email" name="email" required placeholder="example@email.com">
			</div>

			<div class="form-group">
				<label for="login-password">비밀번호</label>
				<div class="password-group">
					<input type="password" id="login-password" name="password" required placeholder="비밀번호 입력">
					<span class="password-toggle" onclick="togglePassword('login-password')">👁️</span>
				</div>
			</div>

			<div class="checkbox-group">
				<input type="checkbox" id="remember-me">
				<label for="remember-me">로그인 상태 유지</label>
			</div>

			<button type="submit" class="btn-primary">로그인</button>

			<div class="form-footer">
				<p>계정이 없으신가요? <a onclick="switchTab('signup')">회원 가입</a></p>
			</div>
		</form>

		<!-- 회원 가입 폼 -->
		<form class="auth-form" id="signup-form">
			<div class="error-message" id="signup-error"></div>
			<div class="loading" id="signup-loading"><div class="spinner"></div></div>

			<div class="form-group">
				<label for="signup-name">이름</label>
				<input type="text" id="signup-name" name="name" required placeholder="실명 입력">
			</div>

			<div class="form-group">
				<label for="signup-email">이메일</label>
				<input type="email" id="signup-email" name="email" required placeholder="example@email.com">
			</div>

			<div class="form-group">
				<label for="signup-phone">전화번호</label>
				<input type="tel" id="signup-phone" name="phone" required placeholder="010-1234-5678">
			</div>

			<div class="form-group">
				<label for="signup-password">비밀번호</label>
				<div class="password-group">
					<input type="password" id="signup-password" name="password" required placeholder="8자 이상 (영문, 숫자, 특수문자)">
					<span class="password-toggle" onclick="togglePassword('signup-password')">👁️</span>
				</div>
			</div>

			<div class="form-group">
				<label for="signup-password-confirm">비밀번호 확인</label>
				<div class="password-group">
					<input type="password" id="signup-password-confirm" name="password-confirm" required placeholder="비밀번호 다시 입력">
					<span class="password-toggle" onclick="togglePassword('signup-password-confirm')">👁️</span>
				</div>
			</div>

			<div class="form-group">
				<label for="signup-address">주소 (선택)</label>
				<input type="text" id="signup-address" name="address" placeholder="거주 지역">
			</div>

			<div class="checkbox-group">
				<input type="checkbox" id="terms-agree" required>
				<label for="terms-agree">이용약관 및 개인정보 처리방침에 동의합니다.</label>
			</div>

			<button type="submit" class="btn-primary">회원 가입</button>

			<div class="form-footer">
				<p>이미 계정이 있으신가요? <a onclick="switchTab('login')">로그인</a></p>
			</div>
		</form>
	</div>

	<script>
		function switchTab(tab) {
			// 탭 버튼 활성화
			const tabs = document.querySelectorAll('.auth-tab');
			tabs.forEach(t => t.classList.remove('active'));
			
			if (tab === 'login') {
				tabs[0].classList.add('active');
				document.getElementById('login-form').classList.add('active');
				document.getElementById('signup-form').classList.remove('active');
			} else {
				tabs[1].classList.add('active');
				document.getElementById('signup-form').classList.add('active');
				document.getElementById('login-form').classList.remove('active');
			}
		}

		function togglePassword(fieldId) {
			const field = document.getElementById(fieldId);
			if (field.type === 'password') {
				field.type = 'text';
			} else {
				field.type = 'password';
			}
		}

		function showError(formType, message) {
			const errorEl = document.getElementById(formType + '-error');
			errorEl.textContent = message;
			errorEl.classList.add('show');
			setTimeout(() => {
				errorEl.classList.remove('show');
			}, 5000);
		}

		function showLoading(formType, show) {
			const loadingEl = document.getElementById(formType + '-loading');
			loadingEl.style.display = show ? 'block' : 'none';
		}

		// 로그인 폼 제출
		document.getElementById('login-form').addEventListener('submit', async function(e) {
			e.preventDefault();
			
			const email = document.getElementById('login-email').value;
			const password = document.getElementById('login-password').value;
			
			showLoading('login', true);
			
			try {
				const response = await fetch('api.php?action=login', {
					method: 'POST',
					headers: {
						'Content-Type': 'application/json'
					},
					body: JSON.stringify({ email, password })
				});

				const data = await response.json();

				if (response.ok && data.success) {
					localStorage.setItem('user_id', data.user.id);
					localStorage.setItem('user_name', data.user.name);
					localStorage.setItem('user_email', data.user.email);
					window.location.href = 'index.php';
				} else {
					showError('login', data.error || '로그인 실패');
				}
			} catch (error) {
				showError('login', '네트워크 오류: ' + error.message);
			} finally {
				showLoading('login', false);
			}
		});

		// 회원 가입 폼 제출
		document.getElementById('signup-form').addEventListener('submit', async function(e) {
			e.preventDefault();
			
			const name = document.getElementById('signup-name').value;
			const email = document.getElementById('signup-email').value;
			const phone = document.getElementById('signup-phone').value;
			const address = document.getElementById('signup-address').value;
			const password = document.getElementById('signup-password').value;
			const passwordConfirm = document.getElementById('signup-password-confirm').value;
			
			// 클라이언트 유효성 검사
			if (password !== passwordConfirm) {
				showError('signup', '비밀번호가 일치하지 않습니다.');
				return;
			}

			if (password.length < 8) {
				showError('signup', '비밀번호는 8자 이상이어야 합니다.');
				return;
			}

			showLoading('signup', true);
			
			try {
				const response = await fetch('api.php?action=signup', {
					method: 'POST',
					headers: {
						'Content-Type': 'application/json'
					},
					body: JSON.stringify({ name, email, phone, address, password })
				});

				const data = await response.json();

				if (response.ok && data.success) {
					localStorage.setItem('user_id', data.user.id);
					localStorage.setItem('user_name', data.user.name);
					localStorage.setItem('user_email', data.user.email);
					window.location.href = 'index.php';
				} else {
					showError('signup', data.error || '회원 가입 실패');
				}
			} catch (error) {
				showError('signup', '네트워크 오류: ' + error.message);
			} finally {
				showLoading('signup', false);
			}
		});
	</script>
</body>
</html>
