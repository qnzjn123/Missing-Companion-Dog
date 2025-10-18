# 🚀 클라우드 배포 가이드

## Cloudtype 배포 확인 사항

### 1. 포트 바인딩 확인
- 클라우드는 동적 PORT 환경변수 사용
- `cloudtype.yml`에서 `0.0.0.0:${PORT}` 설정 완료

### 2. 디렉토리 권한
- `data/` 디렉토리가 쓰기 권한 필요
- `data/sessions/` 디렉토리가 존재해야 함

### 3. 배포 후 확인

```bash
# 1. 배포 로그 확인
cloudtype logs -f

# 2. 헬스 체크 상태
curl https://port-9000-missing-companion-dog-xxxxx.cloudtype.app/index.php

# 3. 데이터 디렉토리 확인
curl https://port-9000-missing-companion-dog-xxxxx.cloudtype.app/api.php?action=getReports
```

### 4. 문제 해결

**문제: 503 Service Unavailable**
- → PHP 서버 시작 실패 (로그 확인)
- → 포트 바인딩 오류
- → 메모리 부족 (256M로 설정)

**문제: 파일을 찾을 수 없음**
- → 상대 경로 오류
- → __DIR__ 사용하여 절대 경로로 수정 (완료)

**문제: 세션 오류**
- → data/sessions 디렉토리 권한 (자동 생성됨)

## 최종 확인

모든 설정이 완료되었습니다:
- ✅ config.php - 세션 경로 자동 생성
- ✅ cloudtype.yml - 포트 및 헬스 체크 설정
- ✅ Procfile - PHP 서버 실행 명령어
- ✅ index.php - PHP 태그 및 config 로드

배포 후 logs를 확인하세요!
