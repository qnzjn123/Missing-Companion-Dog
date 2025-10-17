<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8"/>
	<title>회원 가입 / 로그인</title>
	<style>
		* { margin: 0; padding: 0; box-sizing: border-box; }
		body { 
			font-family: Arial, sans-serif; 
			background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%); 
			min-height: 100vh; 
			display: flex; 
			justify-content: center; 
			align-items: center; 
			padding: 20px;
		}
		.auth-container { 
			background: white; 
			border-radius: 10px; 
			box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1); 
			width: 100%; 
			max-width: 450px; 
			overflow: hidden;
		}
		.auth-header { 
			background: #f8f9fa; 
			padding: 30px; 
			text-align: center; 
			border-bottom: 1px solid #e9ecef;
		}
		.auth-header h1 { 
			color: #333; 
			font-size: 28px; 
			margin-bottom: 10px;
		}
		.auth-header p { 
			color: #666; 
			font-size: 14px;
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
		}
		.auth-tab.active { 
			background: white; 
			color: #333; 
			border-bottom: 3px solid #4ecdc4;
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
			border-radius: 5px; 
			font-size: 14px; 
			transition: border-color 0.3s;
		}
		.form-group input:focus { 
			outline: none; 
			border-color: #4ecdc4; 
			box-shadow: 0 0 5px rgba(78, 205, 196, 0.3);
		}
		.form-group textarea { 
			width: 100%; 
			padding: 12px; 
			border: 1px solid #ddd; 
			border-radius: 5px; 
			font-size: 14px; 
			font-family: Arial; 
			min-height: 80px; 
			resize: vertical;
		}
		.form-group textarea:focus { 
			outline: none; 
			border-color: #4ecdc4; 
			box-shadow: 0 0 5px rgba(78, 205, 196, 0.3);
		}
		.form-group select { 
			width: 100%; 
			padding: 12px; 
			border: 1px solid #ddd; 
			border-radius: 5px; 
			font-size: 14px;
		}
		.password-group { 
			position: relative;
		}
		.password-toggle { 
			position: absolute; 
			right: 12px; 
			top: 38px; 
			cursor: pointer; 
			color: #999;
		}
		.btn-primary { 
			width: 100%; 
			padding: 12px; 
			background: #4ecdc4; 
			color: white; 
			border: none; 
			border-radius: 5px; 
			font-weight: bold; 
			font-size: 16px; 
			cursor: pointer; 
			transition: background 0.3s;
		}
		.btn-primary:hover { 
			background: #3bb8a8;
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
			color: #4ecdc4; 
			text-decoration: none; 
			font-weight: bold;
		}
		.form-footer a:hover { 
			text-decoration: underline;
		}
		.error-message { 
			background: #f8d7da; 
			color: #721c24; 
			padding: 12px; 
			border-radius: 5px; 
			margin-bottom: 20px; 
			border: 1px solid #f5c6cb;
		}
		.success-message { 
			background: #d4edda; 
			color: #155724; 
			padding: 12px; 
			border-radius: 5px; 
			margin-bottom: 20px; 
			border: 1px solid #c3e6cb;
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
		.home-link { 
			display: inline-block; 
			margin-top: 15px; 
			color: #4ecdc4; 
			text-decoration: none;
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
				<p><a href="#forgot-password">비밀번호를 잊으셨나요?</a></p>
			</div>
		</form>

		<!-- 회원 가입 폼 -->
		<form class="auth-form" id="signup-form">
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
					<input type="password" id="signup-password" name="password" required placeholder="8자 이상 (영문, 숫자, 특수문자 포함)">
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
				<label for="signup-address">주소</label>
				<input type="text" id="signup-address" name="address" placeholder="거주 지역">
			</div>

			<div class="checkbox-group">
				<input type="checkbox" id="terms-agree" required>
				<label for="terms-agree">이용약관 및 개인정보 처리방침에 동의합니다.</label>
			</div>

			<button type="submit" class="btn-primary">회원 가입</button>

			<div class="form-footer">
				<p>이미 계정이 있으신가요? <a href="#login">로그인하기</a></p>
			</div>
		</form>
	</div>

	<script>
		function switchTab(tab) {
			// 탭 버튼 활성화
			const tabs = document.querySelectorAll('.auth-tab');
			tabs.forEach(t => t.classList.remove('active'));
			event.target.classList.add('active');

			// 폼 전환
			const forms = document.querySelectorAll('.auth-form');
			forms.forEach(f => f.classList.remove('active'));
			
			if (tab === 'login') {
				document.getElementById('login-form').classList.add('active');
			} else {
				document.getElementById('signup-form').classList.add('active');
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

		// 로그인 폼 제출
		document.getElementById('login-form').addEventListener('submit', function(e) {
			e.preventDefault();
			const email = document.getElementById('login-email').value;
			const password = document.getElementById('login-password').value;
			
			// 세션 저장
			sessionStorage.setItem('userEmail', email);
			sessionStorage.setItem('userName', email.split('@')[0]);
			
			alert('로그인 되었습니다!');
			// 메인 페이지에서 온라인 사용자에 추가됨
			window.location.href = 'index.php';
		});

		// 회원 가입 폼 제출
		document.getElementById('signup-form').addEventListener('submit', function(e) {
			e.preventDefault();
			
			const password = document.getElementById('signup-password').value;
			const passwordConfirm = document.getElementById('signup-password-confirm').value;
			
			if (password !== passwordConfirm) {
				alert('비밀번호가 일치하지 않습니다.');
				return;
			}

			const name = document.getElementById('signup-name').value;
			const email = document.getElementById('signup-email').value;
			
			// 사용자 정보 저장
			sessionStorage.setItem('userEmail', email);
			sessionStorage.setItem('userName', name);
			
			alert('회원 가입이 완료되었습니다!');
			// 메인 페이지에서 온라인 사용자에 추가됨
			window.location.href = 'index.php';
		});
	</script>
</body>
</html>
