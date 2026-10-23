@echo off
title Digitalizacao Profissional - Servidor Local
echo ============================================================
echo   DIGITALIZACAO PROFISSIONAL
echo   Iniciando o servidor local em PHP na porta 8000...
echo   Design: Noite Azul Escuro com Lua Amarela
echo ============================================================
echo.

where php >nul 2>nul
if %errorlevel% neq 0 (
    set "PATH=C:\Users\Aluno\AppData\Local\Microsoft\WinGet\Packages\PHP.PHP.8.3_Microsoft.Winget.Source_8wekyb3d8bbwe;%PATH%"
)

echo Abrindo navegador em http://localhost:8000 ...
start http://localhost:8000

echo Pressione Ctrl+C para encerrar o servidor quando desejar.
php -S localhost:8000
pause
