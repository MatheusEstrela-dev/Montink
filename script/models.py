from sqlalchemy import Column, Integer, BigInteger, String, Text, Numeric, Date, Boolean, ForeignKey, DateTime
from sqlalchemy.ext.declarative import declarative_base
from sqlalchemy import create_engine

Base = declarative_base()

# Atualize conforme sua string de conexão real
engine = create_engine("postgresql+psycopg2://postgres:admin@localhost:5432/laravel", echo=False)

class Usuario(Base):
    __tablename__ = 'usuarios'

    id = Column(BigInteger, primary_key=True)
    nome = Column(String(255), nullable=False)
    email = Column(String(255), nullable=False, unique=True)
    senha = Column(String(255), nullable=False)
    created_at = Column(DateTime)
    updated_at = Column(DateTime)

class Produto(Base):
    __tablename__ = 'produtos'

    id = Column(BigInteger, primary_key=True)
    nome = Column(String(255), nullable=False)
    descricao = Column(Text)
    preco = Column(Numeric(10, 2), nullable=False)
    categoria = Column(String(255))
    created_at = Column(DateTime)
    updated_at = Column(DateTime)

class Estoque(Base):
    __tablename__ = 'estoques'

    id = Column(Integer, primary_key=True)
    produto_id = Column(Integer, ForeignKey('produtos.id'))
    variacao = Column(String)  # ✅ Adicionado campo variacao
    quantidade = Column(Integer)
    localizacao = Column(String)
    created_at = Column(DateTime)
    updated_at = Column(DateTime)


class Pedido(Base):
    __tablename__ = 'pedidos'

    id = Column(BigInteger, primary_key=True)
    usuario_id = Column(BigInteger, ForeignKey('usuarios.id', ondelete="CASCADE"), nullable=False)
    data_pedido = Column(Date, nullable=False)
    valor_total = Column(Numeric(10, 2), nullable=False)
    status = Column(String(255), nullable=False)
    created_at = Column(DateTime)
    updated_at = Column(DateTime)

class Cupom(Base):
    __tablename__ = 'cupoms'

    id = Column(BigInteger, primary_key=True)
    codigo = Column(String(255), nullable=False, unique=True)
    tipo = Column(String(50), nullable=False)  # 'percentual' ou 'fixo'
    valor = Column(Numeric(10, 2), nullable=False)
    data_validade = Column(Date)
    ativo = Column(Boolean, nullable=False)
    created_at = Column(DateTime)
    updated_at = Column(DateTime)
