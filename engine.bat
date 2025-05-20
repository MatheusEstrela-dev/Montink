@echo off
chcp 65001 > nul
title 🚀 ERP Laravel - Octane + Vite + Docker

echo [✔] Subindo containers Docker...
docker-compose up -d

echo [✔] Aguardando container laravel_app subir...
timeout /t 3 > nul

echo [✔] Instalando dependências PHP...
docker exec laravel_app composer install

echo [✔] Executando migrations...
docker exec laravel_app php artisan migrate --force

echo [✔] Limpando cache Laravel...
docker exec laravel_app php artisan config:clear
docker exec laravel_app php artisan route:clear
docker exec laravel_app php artisan view:clear

echo [✔] Instalando dependências NPM...
docker exec laravel_app npm install

echo [🚀] Iniciando Vite no container...
start "Vite" docker exec -it laravel_app npm run dev

echo [🚀] Iniciando Laravel Octane...
docker exec -it laravel_app php artisan octane:start --host=0.0.0.0 --port=8000
