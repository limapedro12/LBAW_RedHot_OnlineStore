DROP SCHEMA IF EXISTS lbaw2352;
CREATE SCHEMA lbaw2352;
SET search_path TO lbaw2352;

DROP TABLE IF EXISTS Utilizador CASCADE;
DROP TABLE IF EXISTS Compra CASCADE;
DROP TABLE IF EXISTS Transporte CASCADE;
DROP TABLE IF EXISTS Devolucao CASCADE;
DROP TABLE IF EXISTS Reembolso CASCADE;
DROP TABLE IF EXISTS Notificacao CASCADE;
DROP TABLE IF EXISTS Comentario CASCADE;
DROP TABLE IF EXISTS Produto CASCADE;
DROP TABLE IF EXISTS Administrador CASCADE;
DROP TABLE IF EXISTS Grupo_Encomendas CASCADE;
DROP TABLE IF EXISTS Notificacao_Compra CASCADE;
DROP TABLE IF EXISTS Notificacao_Devolucao CASCADE;
DROP TABLE IF EXISTS Notificacao_Reembolso CASCADE;
DROP TABLE IF EXISTS Notificacao_Stock CASCADE;
DROP TABLE IF EXISTS Portes CASCADE;
DROP TABLE IF EXISTS ProdutoCompra CASCADE;

CREATE TABLE Utilizador (
	id SERIAL PRIMARY KEY,
  	nome VARCHAR(256) NOT NULL,
  	email VARCHAR(256) UNIQUE NOT NULL,
	password VARCHAR(256) NOT NULL
);

CREATE TABLE Compra (
	id SERIAL PRIMARY KEY,
  	timestamp TIMESTAMP NOT NULL CHECK (timestamp <= now()),
  	total FLOAT NOT NULL CHECK (total >= 0),
        descricao TEXT,
  	id_utilizador INTEGER NOT NULL REFERENCES Utilizador (id) ON UPDATE CASCADE
);

CREATE TABLE Transporte (
	id SERIAL PRIMARY KEY,
  	tipo VARCHAR(256) NOT NULL,
  	precoAtual FLOAT NOT NULL CHECK (precoAtual >= 0)
);

CREATE TABLE Devolucao (
	id SERIAL PRIMARY KEY,
  	timestamp TIMESTAMP NOT NULL CHECK (timestamp <= now()),
  	estado VARCHAR(256),
    id_compra INTEGER NOT NULL REFERENCES Compra (ID) ON UPDATE CASCADE
);

CREATE TABLE Reembolso (
	id SERIAL PRIMARY KEY,
  	timestamp TIMESTAMP NOT NULL CHECK (timestamp <= now()),
  	estado VARCHAR(256),
        id_compra INTEGER NOT NULL REFERENCES Compra (ID) ON UPDATE CASCADE
);

CREATE TABLE Notificacao (
	id SERIAL PRIMARY KEY,
  	timestamp TIMESTAMP NOT NULL CHECK (timestamp <= now()),
  	texto VARCHAR(256) NOT NULL,
        id_utilizador INTEGER REFERENCES Utilizador (id) ON UPDATE CASCADE
);

Create TABLE Administrador (
	id SERIAL PRIMARY KEY,
  	nome VARCHAR(256) NOT NULL
);

CREATE TABLE Produto (
	id SERIAL PRIMARY KEY,
  	nome VARCHAR(256) NOT NULL,
	descricao TEXT NOT NULL,
  	precoAtual FLOAT NOT NULL CHECK (precoAtual >= 0),
	desconto FLOAT CHECK (desconto >= 0 AND desconto <= 100),
  	stock INTEGER NOT NULL CHECK (stock >= 0),
  	id_administrador INTEGER REFERENCES Administrador (id) ON UPDATE CASCADE
);

CREATE TABLE Comentario (
	id SERIAL PRIMARY KEY,
  	timestamp TIMESTAMP NOT NULL CHECK (timestamp <= now()),
  	texto TEXT NOT NULL,
    avaliacao INTEGER NOT NULL CHECK (avaliacao >= 1 AND avaliacao <= 5),
  	id_utilizador INTEGER NOT NULL REFERENCES Utilizador (id) ON UPDATE CASCADE,
  	id_produto INTEGER NOT NULL REFERENCES Produto (id) ON UPDATE CASCADE
);

CREATE TABLE Notificacao_Compra (
	id INTEGER PRIMARY KEY REFERENCES Notificacao (id) ON UPDATE CASCADE,
  	id_compra INTEGER REFERENCES Compra (id) ON UPDATE CASCADE
);

CREATE TABLE Notificacao_Devolucao (
	id INTEGER PRIMARY KEY REFERENCES Notificacao (id) ON UPDATE CASCADE,
  	id_devolucao INTEGER REFERENCES Devolucao (id) ON UPDATE CASCADE
);

CREATE TABLE Notificacao_Reembolso (
	id INTEGER PRIMARY KEY REFERENCES Notificacao (id) ON UPDATE CASCADE,
  	id_reembolso INTEGER REFERENCES Reembolso (id) ON UPDATE CASCADE
);

CREATE TABLE Notificacao_Stock (
	id INTEGER PRIMARY KEY REFERENCES Notificacao (id) ON UPDATE CASCADE,
  	id_stock INTEGER REFERENCES Produto (id) ON UPDATE CASCADE,
	id_administrador INTEGER REFERENCES Administrador (ID) ON UPDATE CASCADE
);

CREATE TABLE Notificacao_Encomenda (
	id INTEGER PRIMARY KEY REFERENCES Notificacao (id) ON UPDATE CASCADE,
  	id_grupo_de_encomenda INTEGER REFERENCES Grupo_Encomendas (id) ON UPDATE CASCADE
);

CREATE TABLE Portes (
	id_compra INTEGER NOT NULL UNIQUE REFERENCES Compra (ID) ON UPDATE CASCADE,
  	id_transporte INTEGER REFERENCES Transporte (id) ON UPDATE CASCADE,
 	preco FLOAT NOT NULL CHECK (preco >= 0)
);

CREATE TABLE Preco (
  	preco FLOAT NOT NULL CHECK (preco >= 0),
	id_compra INTEGER REFERENCES Compra (id) ON UPDATE CASCADE,
  	id_produto INTEGER REFERENCES Produto (id) ON UPDATE CASCADE
);

CREATE TABLE ProdutoWishlist (
	id INTEGER PRIMARY KEY,
  	id_utilizador INTEGER REFERENCES Utilizador (id) ON UPDATE CASCADE,
  	id_produto INTEGER REFERENCES Produto (id) ON UPDATE CASCADE
);

CREATE TABLE UtilizadorNaoAutenticadoComProdutosNoCarrinho (
	id INTEGER PRIMARY KEY
);

CREATE TABLE ProdutoCarrinho (
	id INTEGER PRIMARY KEY,
  	id_produto INTEGER REFERENCES Produto (id) ON UPDATE CASCADE,
	id_utilizador INTEGER REFERENCES Utilizador (id) ON UPDATE CASCADE,
	id_utilizador_nao_autenticado INTEGER REFERENCES UtilizadorNaoAutenticadoComProdutosNoCarrinho (id) ON UPDATE CASCADE
);

CREATE TABLE Notificacao_Carrinho (
	id INTEGER PRIMARY KEY REFERENCES Notificacao (id) ON UPDATE CASCADE,
  	id_produto_carrinho INTEGER REFERENCES ProdutoCarrinho (id) ON UPDATE CASCADE
);

CREATE TABLE Notificacao_Wishlist (
	id INTEGER PRIMARY KEY REFERENCES Notificacao (id) ON UPDATE CASCADE,
  	id_produto_wishlist INTEGER REFERENCES ProdutoWishlist (id) ON UPDATE CASCADE
);
