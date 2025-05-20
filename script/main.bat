@echo off
chcp 65001 > nul
title 🎯 Mini ERP Laravel - Utilitário

:MENU
cls
echo ===================================================
echo  🟢 MINI ERP - GERENCIADOR DE DADOS (🐘 PostgreSQL)
echo ===================================================
echo.
echo 📦 [1] Popular banco com dados fake
echo 💣 [2] Limpar banco de dados (TRUNCATE)
echo ❌ [0] Sair
echo.
set /p opcao=👉 Escolha uma opção e pressione ENTER: 

if "%opcao%"=="1" goto POPULAR
if "%opcao%"=="2" goto TRUNCATE
if "%opcao%"=="0" exit
goto MENU

:POPULAR
echo 🚀 Iniciando: Popular banco com dados fake...
call .venv\Scripts\activate.bat
python gerar_fake.py
echo ✅ Banco populado com sucesso!
pause
goto MENU

:TRUNCATE
echo ⚠️ Iniciando: Limpando todas as tabelas...
call .venv\Scripts\activate.bat
python truncate_db.py
echo ✅ Banco limpo com sucesso!
pause
goto MENU
