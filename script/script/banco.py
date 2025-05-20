# scripts/banco.py
import json
from sqlalchemy.orm import sessionmaker
from sqlalchemy import create_engine
from models import Base, Usuario, Produto, Estoque, Cupom, Pedido
from datetime import datetime

# ✅ Conexão com PostgreSQL (ajuste se necessário)
DATABASE_URL = 'postgresql://postgres:admin@localhost:5432/laravel'
engine = create_engine(DATABASE_URL)
Session = sessionmaker(bind=engine)
session = Session()

# 🔄 Criar tabelas (se não existirem)
Base.metadata.create_all(engine)

# 📂 Carregar dados JSON diretamente do diretório atual
with open('dados_usuarios.json', encoding='utf-8') as f:
    usuarios_data = json.load(f)

with open('dados_produtos.json', encoding='utf-8') as f:
    produtos_data = json.load(f)

with open('dados_estoques.json', encoding='utf-8') as f:
    estoques_data = json.load(f)

with open('dados_cupons.json', encoding='utf-8') as f:
    cupons_data = json.load(f)

with open('dados_pedidos.json', encoding='utf-8') as f:
    pedidos_data = json.load(f)

# 💾 Inserir dados no banco
for u in usuarios_data:
    session.add(Usuario(**u))

for p in produtos_data:
    session.add(Produto(**p))

for e in estoques_data:
    session.add(Estoque(**e))

for c in cupons_data:
    session.add(Cupom(**c))

for p in pedidos_data:
    session.add(Pedido(**p))

# ✅ Commit e fechar
session.commit()
session.close()
print("✅ Banco populado com sucesso!")