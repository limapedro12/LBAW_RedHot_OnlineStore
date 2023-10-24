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
DROP TABLE IF EXISTS Notificacao_Compra CASCADE;
DROP TABLE IF EXISTS Notificacao_Devolucao CASCADE;
DROP TABLE IF EXISTS Notificacao_Reembolso CASCADE;
DROP TABLE IF EXISTS Notificacao_Stock CASCADE;
DROP TABLE IF EXISTS Portes CASCADE;
DROP TABLE IF EXISTS Preco CASCADE;
DROP TABLE IF EXISTS ProdutoCarrinho CASCADE;
DROP TABLE IF EXISTS ProdutoCompra CASCADE;
DROP TABLE IF EXISTS ProdutoWishlist CASCADE;
DROP TABLE IF EXISTS UtilizadorNaoAutenticadoComProdutosNoCarrinho CASCADE;
DROP TABLE IF EXISTS Notificacao_Carrinho CASCADE;
DROP TABLE IF EXISTS Notificacao_Wishlist CASCADE;

CREATE TABLE Utilizador (
	id SERIAL PRIMARY KEY,
  	nome VARCHAR(256) NOT NULL,
  	email VARCHAR(256) UNIQUE NOT NULL,
	password VARCHAR(256) NOT NULL
);

CREATE TABLE Administrador (
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
  	id_utilizador INTEGER NOT NULL REFERENCES Utilizador (id) ON UPDATE CASCADE,
    estado VARCHAR(256) NOT NULL,
	id_administrador INTEGER REFERENCES Administrador (id)
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

-- IDX01
CREATE INDEX notificacao_tempo ON Notificacao USING btree (timestamp);
CLUSTER Notificacao USING notificacao_tempo;

-- IDX02
CREATE INDEX compra_tempo ON Compra USING btree (timestamp);

-- IDX03
CREATE INDEX utilizador_email ON Utilizador USING hash (email);

-- IDX04
-- Adiciona uma coluna a Produto para guardar o ts_vector já calculado
ALTER TABLE Produto
ADD COLUMN tsvectors TSVECTOR;
DROP FUNCTION IF EXISTS produto_search_update();
-- Cria uma função que atualiza automaticamente o ts_vector de Produto
CREATE FUNCTION produto_search_update() RETURNS TRIGGER AS $$
BEGIN
 IF TG_OP = 'INSERT' THEN
        NEW.tsvectors = (
         setweight(to_tsvector('portuguese', NEW.nome), 'A') ||
         setweight(to_tsvector('portuguese', NEW.descricao), 'B')
        );
 END IF;
 IF TG_OP = 'UPDATE' THEN
         IF (NEW.title <> OLD.title OR NEW.obs <> OLD.obs) THEN
           NEW.tsvectors = (
             setweight(to_tsvector('portuguese', NEW.nome), 'A') ||
             setweight(to_tsvector('portuguese', NEW.descricao), 'B')
           );
         END IF;
 END IF;
 RETURN NEW;
END $$
LANGUAGE plpgsql;
-- Cria um trigger que é ativado antes de inserir ou atualizar Produto
CREATE TRIGGER produto_search_update
 BEFORE INSERT OR UPDATE ON Produto
 FOR EACH ROW
 EXECUTE PROCEDURE produto_search_update();
-- Finalmente, cria um índice to tipo GIST para os ts_vectors de Produto
CREATE INDEX produto_search_idx ON Produto USING GIST (tsvectors);

--IDX05
-- Adiciona uma coluna a Utilizador para guardar o ts_vector já calculado
ALTER TABLE Utilizador
ADD COLUMN tsvectors TSVECTOR;
DROP FUNCTION IF EXISTS utilizador_search_update();
-- Cria uma função que atualiza automaticamente o ts_vector de Utilizador
CREATE FUNCTION utilizador_search_update() RETURNS TRIGGER AS $$
BEGIN
 IF TG_OP = 'INSERT' THEN
        NEW.tsvectors = to_tsvector('portuguese', NEW.nome);
 END IF;
 IF TG_OP = 'UPDATE' THEN
         IF (NEW.nome <> OLD.nome) THEN
           NEW.tsvectors = to_tsvector('portuguese', NEW.nome);
         END IF;
 END IF;
 RETURN NEW;
END $$
LANGUAGE plpgsql;
-- Cria um trigger que é ativado antes de inserir ou atualizar Utilizador
CREATE TRIGGER utilizador_search_update
 BEFORE INSERT OR UPDATE ON Utilizador
 FOR EACH ROW
 EXECUTE PROCEDURE utilizador_search_update();
-- Finalmente, cria um índice to tipo GIST para os ts_vectors de Utilizador
CREATE INDEX utilizador_search_idx ON Utilizador USING GIST (tsvectors);

CREATE OR REPLACE FUNCTION check_stock()
RETURNS TRIGGER AS $$
BEGIN
    IF NEW.quantidade > (SELECT stock FROM Produto WHERE id = NEW.id_produto) THEN
        RAISE EXCEPTION 'Insufficient stock for product';
    END IF;
    RETURN NEW;
END;
$$ LANGUAGE plpgsql;

CREATE TRIGGER check_stock_trigger
AFTER INSERT ON ProdutoCarrinho
FOR EACH ROW
EXECUTE FUNCTION check_stock();

CREATE OR REPLACE FUNCTION decrement_stock()
RETURNS TRIGGER AS $$
BEGIN
    UPDATE Produto
    SET stock = stock - NEW.quantidade
    WHERE id = NEW.id_produto;
    RETURN NEW;
END;
$$ LANGUAGE plpgsql;

CREATE TRIGGER decrement_stock_trigger
AFTER INSERT ON ProdutoCompra
FOR EACH ROW
EXECUTE FUNCTION decrement_stock();

CREATE OR REPLACE FUNCTION calculate_total_price()
RETURNS TRIGGER AS $$
BEGIN
    UPDATE Compra
    SET total = (SELECT SUM(preco) FROM Portes WHERE id_compra = NEW.id_compra)
    WHERE id = NEW.id_compra;
    RETURN NEW;
END;
$$ LANGUAGE plpgsql;

CREATE TRIGGER calculate_total_price_trigger
AFTER INSERT ON Portes
FOR EACH ROW
EXECUTE FUNCTION calculate_total_price();

CREATE OR REPLACE FUNCTION update_order_status_trigger()
RETURNS TRIGGER AS $$
BEGIN
    IF NEW.estado = 'Enviada' AND (
        SELECT COUNT(*) FROM ProdutoCompra WHERE id_compra = NEW.id_compra
    ) = (
        SELECT COUNT(*) FROM Devolucao WHERE id_compra = NEW.id_compra
    ) THEN
        UPDATE Grupo_Encomendas
        SET estado = 'Entregue'
        WHERE id = NEW.id;
    END IF;
    RETURN NEW;
END;
$$ LANGUAGE plpgsql;

CREATE TRIGGER update_order_status
AFTER UPDATE ON Devolucao
FOR EACH ROW
EXECUTE FUNCTION update_order_status_trigger();

CREATE OR REPLACE FUNCTION update_product_rating_trigger()
RETURNS TRIGGER AS $$
BEGIN
    UPDATE Produto
    SET avaliacao_media = (
        SELECT AVG(avaliacao)
        FROM Comentario
        WHERE id_produto = NEW.id_produto
    )
    WHERE id = NEW.id_produto;
    RETURN NEW;
END;
$$ LANGUAGE plpgsql;

CREATE TRIGGER update_product_rating
AFTER INSERT OR UPDATE ON Comentario
FOR EACH ROW
EXECUTE FUNCTION update_product_rating_trigger();
