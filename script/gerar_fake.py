from datetime import datetime
from faker import Faker
import random
from sqlalchemy import create_engine
from sqlalchemy.orm import sessionmaker
from models import Base, Usuario, Produto, Estoque, Pedido, Cupom

# Configuração da conexão com o banco
engine = create_engine('postgresql://postgres:admin@localhost:5432/laravel')
Session = sessionmaker(bind=engine)
session = Session()

faker = Faker('pt_BR')

# Limpa e recria as tabelas (opcional: use só em ambiente de dev)
Base.metadata.drop_all(engine)
Base.metadata.create_all(engine)

# Usuários
for _ in range(10):
    session.add(Usuario(
        nome=faker.name(),
        email=faker.unique.email(),
        senha=faker.password(length=12),
        created_at=faker.date_time_this_year(),
        updated_at=faker.date_time_this_year()
    ))

# Produtos
categorias = ['Hardware', 'Periféricos', 'Acessórios', 'Softwares']
for _ in range(15):
    session.add(Produto(
        nome=faker.word().capitalize(),
        preco=round(random.uniform(10, 1000), 2),
        descricao=faker.sentence(),  # Evita null
        categoria=random.choice(categorias),
        created_at=faker.date_time_this_year(),
        updated_at=faker.date_time_this_year()
    ))

# Cupoms
tipos = ['percentual', 'fixo']
for _ in range(5):
    session.add(Cupom(
        codigo=faker.unique.lexify(text='??????').upper(),
        tipo=random.choice(tipos),
        valor=round(random.uniform(5, 50), 2),
        data_validade=faker.date_this_year(),
        ativo=True,
        created_at=faker.date_time_this_year(),
        updated_at=faker.date_time_this_year()
    ))

session.commit()

# Estoques
produtos = session.query(Produto).all()
for produto in produtos:
    session.add(Estoque(
        produto_id=produto.id,
        quantidade=random.randint(0, 100),
        localizacao=faker.city(),
        created_at=datetime.now(),
        updated_at=datetime.now()
    ))

# Pedidos
usuarios = session.query(Usuario).all()
for _ in range(20):
    session.add(Pedido(
        usuario_id=random.choice(usuarios).id,
        data_pedido=faker.date_this_year(),
        valor_total=round(random.uniform(100, 2000), 2),
        status=random.choice(['pendente', 'pago', 'cancelado']),
        created_at=datetime.now(),
        updated_at=datetime.now()
    ))

session.commit()
print("✅ Dados populados com sucesso!")
