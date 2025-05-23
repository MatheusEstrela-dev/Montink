#!/usr/bin/env bash
set -e

# 1) Build das imagens sem cache
echo "🔨 Construindo imagens (sem cache...)"
docker compose build --no-cache

# 2) Sobe os containers em background
echo "🚀 Subindo containers..."
docker compose up -d

# 3) Aguarda o Postgres ficar disponível
echo "⏳ Aguardando Postgres..."
docker compose exec postgres_db sh -c 'until pg_isready -U postgres >/dev/null 2>&1; do sleep 1; done'

# 4) Instala dependências PHP e roda migrations e seeders
echo "📦 Instalando pacotes PHP e rodando migrations e seeders..."
docker compose exec laravel_app sh -c '
  composer install --no-interaction --optimize-autoloader && \
  php artisan migrate --force && \
  php artisan db:seed --force
'

# 5) Inicia o Laravel Octane via Docker Compose exec
echo "⚙️ Iniciando Laravel Octane (via compose exec)..."
docker compose exec laravel_app sh -c '
  pkill -f "artisan octane:start" || true && \
  php artisan octane:start --server=swoole --host=0.0.0.0 --port=8000 &
'

# 6) Abre um shell interativo no container e inicia o Octane manualmente
echo "🚪 Abrindo container para inspeção e start manual do Octane..."
echo "Use os seguintes comandos dentro do container:"
echo "  docker exec -it laravel_app sh"
echo "  php artisan octane:start --host=0.0.0.0 --port=8000"

echo "✅ Tudo configurado!"
