from sqlalchemy.orm import sessionmaker
from sqlalchemy import text  # ✅ necessário para comandos SQL puros
from models import engine

Session = sessionmaker(bind=engine)
session = Session()

# Ordem correta respeitando FK
tabelas = ['estoques', 'pedidos', 'cupoms', 'produtos', 'usuarios']

print("⚠️ Limpando todas as tabelas e resetando IDs...")

for tabela in tabelas:
    session.execute(text(f'TRUNCATE TABLE {tabela} RESTART IDENTITY CASCADE'))

session.commit()
print("✅ Todas as tabelas foram esvaziadas com sucesso!")
