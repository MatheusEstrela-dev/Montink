@echo off
REM 1) Build das imagens sem cache
echo 🔨 Construindo imagens (sem cache...)
docker compose build --no-cache

REM 2) Sobe os containers em background
echo 🚀 Subindo containers...
docker compose up -d

REM 3) Aguarda o Postgres ficar disponível
echo ⏳ Aguardando Postgres...
:waitloop
@docker compose exec postgres_db pg_isready -U postgres >nul 2>&1
if errorlevel 1 (
    timeout /t 1 >nul
    goto waitloop
)

REM 4) Instala dependências PHP e roda migrations e seeders
echo 📦 Instalando pacotes PHP e rodando migrations e seeders...
docker compose exec laravel_app sh -c "composer install --no-interaction --optimize-autoloader && php artisan migrate --force && php artisan db:seed --force"

REM 5) Inicia o Laravel Octane via Docker Compose exec
echo ⚙️ Iniciando Laravel Octane (via compose exec)...
docker compose exec laravel_app sh -c "pkill -f 'artisan octane:start' || true && php artisan octane:start --server=swoole --host=0.0.0.0 --port=8000"

REM 6) Orientações para abrir container e iniciar Octane manualmente
echo 🚪 Para abrir o container e iniciar o Octane manualmente, use:
echo   docker exec -it laravel_app sh
echo   php artisan octane:start --host=0.0.0.0 --port=8000

pause
