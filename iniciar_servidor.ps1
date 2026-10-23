# ============================================================
# DIGITALIZAÇÃO PROFISSIONAL - INICIALIZADOR POWERSHELL
# ============================================================

$phpPath = "C:\Users\Aluno\AppData\Local\Microsoft\WinGet\Packages\PHP.PHP.8.3_Microsoft.Winget.Source_8wekyb3d8bbwe\php.exe"
if (-not (Test-Path $phpPath)) {
    $phpPath = (Get-Command php -ErrorAction SilentlyContinue).Source
}

Write-Host "============================================================" -ForegroundColor Cyan
Write-Host "  DIGITALIZAÇÃO PROFISSIONAL" -ForegroundColor Yellow
Write-Host "  Design: Noite Azul Escuro com Lua Amarela" -ForegroundColor White
Write-Host "  Iniciando servidor em http://localhost:8000" -ForegroundColor Green
Write-Host "============================================================" -ForegroundColor Cyan

Start-Process "http://localhost:8000"
& $phpPath -S localhost:8000
