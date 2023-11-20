DROP SCHEMA IF EXISTS lbaw2352 CASCADE;
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
	password VARCHAR(256) NOT NULL,
  remember_token VARCHAR(256)
);

CREATE TABLE Administrador (
    id SERIAL PRIMARY KEY,
      nome VARCHAR(256) NOT NULL,
      email VARCHAR(256) UNIQUE NOT NULL,
    password VARCHAR(256) NOT NULL,
    remember_token VARCHAR(256)
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
  	id_administrador INTEGER REFERENCES Administrador (id) ON UPDATE CASCADE,
    url_imagem VARCHAR(256) DEFAULT 'https://upload.wikimedia.org/wikipedia/commons/thumb/d/d1/Image_not_available.png/640px-Image_not_available.png'
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
         IF (NEW.nome <> OLD.nome OR NEW.descricao <> OLD.descricao) THEN
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
AFTER INSERT ON Preco
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

SET timezone = 'Europe/Lisbon';

INSERT INTO Utilizador (nome, email, password) VALUES
  ('Dominic Walter','et.eros@yahoo.couk','XRC92KGT3PX'),
  ('Scott Mckenzie','nonummy.ultricies.ornare@icloud.org','HEE09TED7XV'),
  ('Janna Santiago','proin.vel.nisl@yahoo.net','JLY18UFO0RY'),
  ('Nathan Horne','dolor.nulla@icloud.couk','JFX71BSD7SC'),
  ('Tiger Boyle','dignissim@hotmail.net','SDU69QXM4TH'),
  ('James Gutierrez','dolor.quisque@hotmail.ca','GEV73ERP4BN'),
  ('Miranda Holmes','curae.phasellus@protonmail.org','CQX21FNX0MB'),
  ('Vincent Chambers','pede.nonummy@hotmail.edu','EVH63ZKS0DY'),
  ('Inez Barrera','nibh.aliquam@outlook.ca','EJY18RGV2MU'),
  ('Jordan Chandler','enim.nunc@icloud.edu','CKN22QHB2VH'),
  ('Octavia Hickman','enim.diam@protonmail.couk','FNQ14POC4VY'),
  ('Neil Petersen','metus.aliquam@hotmail.net','VCC55JKP7GF'),
  ('Kyla Tanner','tempor.lorem.eget@outlook.org','OME47XIN8YG'),
  ('Leilani Sargent','amet.ornare.lectus@aol.org','OUQ44TKA3PO'),
  ('Prescott Mayer','donec.dignissim@icloud.couk','DWF44MCK4DM'),
  ('Dean Lawson','ut@aol.com','XJC01OKK3IO'),
  ('John Holmes','nec.eleifend@protonmail.org','SPQ25VQX5BT'),
  ('Colorado Lamb','sed.nec@yahoo.edu','UQY34WSJ5XT'),
  ('Ralph Lambert','commodo.hendrerit@outlook.edu','JSA88KNH7BS'),
  ('Brenna Cline','a.felis.ullamcorper@yahoo.org','RTF10SNH7CL');

INSERT INTO Administrador (nome, email, password) VALUES
  ('Guilherme Couto', 'guicouto@aol.com', 'JAF73FJA9'),
  ('Filipa Antunes', 'fisantunes@google.pt', 'AD2155FWA'),
  ('Sofia Pereira', 'pereirasofia@iol.pt', '278WGFBFL1'),
  ('Gustavo Faria', 'gugafaria@hotmail.com', '28RTG2UFIW'),
  ('Pedro Martins', 'pedromart@yahoo.es', 'HUG317FBU'),
  ('admin', 'admin@admin.pt', '$2y$10$R6IeqCxQxMConGFO3OHuq.Um2vxTYB9NKikC6Hky8cmUCln6jl5k6'); -- password: 12345678

INSERT INTO Compra (timestamp, total, descricao, id_utilizador, estado, id_administrador) VALUES
  ('2023-01-15 09:23:54', 99.99, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit', 1, 'Enviada', 1),
  ('2023-01-30 10:47:06', 49.95, 'Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua', 2, 'Aguarda pagamento', 2),
  ('2023-02-05 03:56:15', 199.99, 'Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris', 3, 'Enviada', 3),
  ('2023-02-09 07:53:18', 79.99, 'Nisi ut aliquip ex ea commodo consequat', 4, 'Enviada', 4),
  ('2023-02-12 18:24:22', 129.99, 'Duis aute irure dolor in reprehenderit in voluptate velit esse cillum', 5, 'Aguarda pagamento', 5),
  ('2023-02-15 01:15:26', 59.99, 'Excepteur sint occaecat cupidatat non proident, sunt in culpa', 6, 'Aguarda pagamento', 5),
  ('2023-02-19 16:05:57', 89.99, 'Qui officia deserunt mollit anim id est laborum', 7, 'Aguarda pagamento', 4),
  ('2023-02-26 00:59:05', 39.99, 'Consectetur adipiscing elit, sed do eiusmod tempor incididunt', 8, 'Aguarda pagamento', 3),
  ('2023-03-02 11:32:11', 69.99, 'Ut labore et dolore magna aliqua. Ut enim ad', 9, 'Aguarda pagamento', 2),
  ('2023-03-06 03:39:05', 119.99, 'Minim veniam, quis nostrud exercitation ullamco laboris nisi', 10, 'Aguarda pagamento', 1),
  ('2023-03-11 18:03:47', 69.99, 'Ut aliquip ex ea commodo consequat. Duis aute', 11, 'Aguarda pagamento', 1),
  ('2023-03-14 01:18:38', 179.99, 'Excepteur sint occaecat cupidatat non proident, sunt in', 12, 'Aguarda pagamento', 2),
  ('2023-03-19 19:56:04', 49.99, 'Culpa qui officia deserunt mollit anim id est', 13, 'Aguarda pagamento', 3),
  ('2023-03-21 06:48:31', 99.99, 'Eiusmod tempor incididunt ut labore et dolore magna', 14, 'Aguarda pagamento', 4),
  ('2023-03-25 00:23:36', 69.99, 'Aliqua. Ut enim ad minim veniam, quis', 15, 'Aguarda pagamento', 5),
  ('2023-03-30 21:47:10', 149.99, 'Nostrud exercitation ullamco laboris nisi ut aliquip', 16, 'Aguarda pagamento', 5),
  ('2023-04-02 04:35:50', 79.99, 'Ex ea commodo consequat. Duis aute irure', 17, 'Enviada', 4),
  ('2023-04-05 02:46:03', 119.99, 'Dolor in reprehenderit in voluptate velit esse', 18, 'Entregue', 3),
  ('2023-04-09 16:23:37', 49.99, 'Cillum dolore eu fugiat nulla pariatur. Excepteur', 19, 'Entregue', 2),
  ('2023-04-12 22:38:22', 139.99, 'Sint occaecat cupidatat non proident, sunt in', 20, 'Enviada', 1),
  ('2023-04-17 07:50:19', 79.99, 'Culpa qui officia deserunt mollit anim id est', 1, 'Aguarda pagamento', 1),
  ('2023-04-22 18:02:54', 89.99, 'Eiusmod tempor incididunt ut labore et dolore magna', 2, 'Enviada', 2),
  ('2023-04-27 15:12:08', 69.99, 'Aliqua. Ut enim ad minim veniam, quis', 3, 'Enviada', 3),
  ('2023-05-01 11:37:33', 129.99, 'Nostrud exercitation ullamco laboris nisi ut aliquip', 4, 'Aguarda pagamento', 4),
  ('2023-05-04 10:10:43', 149.99, 'Ex ea commodo consequat. Duis aute irure', 5, 'Entregue', 5),
  ('2023-05-07 13:42:41', 79.99, 'Dolor in reprehenderit in voluptate velit esse', 6, 'Enviada', 5),
  ('2023-05-11 12:31:20', 109.99, 'Cillum dolore eu fugiat nulla pariatur. Excepteur', 7, 'Enviada', 4),
  ('2023-05-13 14:51:36', 159.99, 'Sint occaecat cupidatat non proident, sunt in', 8, 'Enviada', 3),
  ('2023-05-17 08:07:42', 59.99, 'Culpa qui officia deserunt mollit anim id est', 9, 'Enviada', 2),
  ('2023-05-22 23:40:01', 89.99, 'Eiusmod tempor incididunt ut labore et dolore', 10, 'Entregue', 1),
  ('2023-05-26 02:07:23', 119.99, 'Aliqua. Ut enim ad minim veniam, quis', 11, 'Enviada', 1),
  ('2023-05-30 04:33:45', 99.99, 'Nostrud exercitation ullamco laboris nisi ut aliquip', 12, 'Entregue', 2),
  ('2023-06-03 08:41:16', 129.99, 'Ex ea commodo consequat. Duis aute irure', 13, 'Entregue', 3),
  ('2023-06-06 13:21:39', 119.99, 'Dolor in reprehenderit in voluptate velit esse', 14, 'Entregue', 4),
  ('2023-06-08 01:19:59', 69.99, 'Cillum dolore eu fugiat nulla pariatur. Excepteur', 15, 'Enviada', 5),
  ('2023-06-12 16:54:29', 119.99, 'Sint occaecat cupidatat non proident, sunt in', 16, 'Entregue', 5),
  ('2023-06-18 12:20:29', 139.99, 'Culpa qui officia deserunt mollit anim id est', 17, 'Devolução solicitada', 4),
  ('2023-06-20 08:45:31', 129.99, 'Eiusmod tempor incididunt ut labore et dolore', 18, 'Devolução solicitada', 3),
  ('2023-06-22 21:01:00', 99.99, 'Aliqua. Ut enim ad minim veniam, quis', 19, 'Devolução solicitada', 2),
  ('2023-06-28 19:30:58', 99.99, 'Nostrud exercitation ullamco laboris nisi ut aliquip', 20, 'Entregue', 1),
  ('2023-07-03 00:01:29', 69.99, 'Ex ea commodo consequat. Duis aute irure', 1, 'Entregue', 1),
  ('2023-07-07 06:29:30', 139.99, 'Dolor in reprehenderit in voluptate velit esse', 2, 'Devolvida', 2),
  ('2023-07-10 21:34:42', 199.99, 'Cillum dolore eu fugiat nulla pariatur. Excepteur', 3, 'Entregue', 3),
  ('2023-07-12 22:28:47', 49.99, 'Sint occaecat cupidatat non proident, sunt in', 4, 'Entregue', 4),
  ('2023-07-16 14:58:19', 109.99, 'Culpa qui officia deserunt mollit anim id est', 5, 'Devolução solicitada', 5),
  ('2023-07-18 03:08:13', 69.99, 'Eiusmod tempor incididunt ut labore et dolore magna', 6, 'Enviada', 5),
  ('2023-07-23 03:45:12', 119.99, 'Aliqua. Ut enim ad minim veniam, quis', 7, 'Entregue', 4),
  ('2023-07-28 12:43:49', 59.99, 'Nostrud exercitation ullamco laboris nisi ut aliquip', 8, 'Entregue', 3),
  ('2023-07-29 10:14:57', 99.99, 'Ex ea commodo consequat. Duis aute irure', 9, 'Entregue', 2),
  ('2023-08-03 21:50:14', 89.99, 'Dolor in reprehenderit in voluptate velit esse', 10, 'Entregue', 1),
  ('2023-08-04 19:40:28', 69.99, 'Cillum dolore eu fugiat nulla pariatur. Excepteur', 11, 'Entregue', 1),
  ('2023-08-07 14:49:59', 49.99, 'Sint occaecat cupidatat non proident, sunt in', 12, 'Entregue', 2),
  ('2023-08-10 14:09:52', 69.99, 'Culpa qui officia deserunt mollit anim id est', 13, 'Entregue', 3),
  ('2023-08-14 14:49:17', 99.99, 'Eiusmod tempor incididunt ut labore et dolore', 14, 'Devolução solicitada', 4),
  ('2023-08-17 17:59:53', 149.99, 'Aliqua. Ut enim ad minim veniam, quis', 15, 'Aguarda pagamento', 5),
  ('2023-08-20 05:28:06', 139.99, 'Nostrud exercitation ullamco laboris nisi ut aliquip', 16, 'Devolvida', 5),
  ('2023-08-21 13:13:02', 89.99, 'Ex ea commodo consequat. Duis aute irure', 17, 'Aguarda pagamento', 4),
  ('2023-08-24 14:32:04', 79.99, 'Dolor in reprehenderit in voluptate velit esse', 18, 'Aguarda pagamento', 3),
  ('2023-08-28 20:45:15', 99.99, 'Cillum dolore eu fugiat nulla pariatur. Excepteur', 19, 'Aguarda pagamento', 2),
  ('2023-08-30 23:55:30', 119.99, 'Sint occaecat cupidatat non proident, sunt in', 20, 'Entregue', 1),
  ('2023-09-03 12:38:59', 49.99, 'Culpa qui officia deserunt mollit anim id', 1, 'Entregue', 1),
  ('2023-09-09 06:06:43', 79.99, 'Eiusmod tempor incididunt ut labore et dolore', 2, 'Entregue', 2),
  ('2023-09-15 22:46:11', 119.99, 'Aliqua. Ut enim ad minim veniam, quis', 3, 'Entregue', 3),
  ('2023-09-18 07:49:59', 129.99, 'Nostrud exercitation ullamco laboris nisi ut aliquip', 4, 'Enviada', 4),
  ('2023-09-25 05:33:56', 129.99, 'Culpa qui officia deserunt mollit anim id', 5, 'Enviada', 5),
  ('2023-09-28 13:20:42', 149.99, 'Eiusmod tempor incididunt ut labore et dolore', 6, 'Enviada', 5),
  ('2023-10-02 23:54:20', 99.99, 'Aliqua. Ut enim ad minim veniam, quis', 7, 'Devolução solicitada', 4),
  ('2023-10-08 07:03:17', 179.99, 'Nostrud exercitation ullamco laboris nisi ut aliquip', 8, 'Enviada', 3),
  ('2023-10-10 16:47:16', 79.99, 'Ex ea commodo consequat. Duis aute irure', 9, 'Entregue', 2),
  ('2023-10-14 15:03:32', 99.99, 'Dolor in reprehenderit in voluptate velit esse', 10, 'Entregue', 1),
  ('2023-10-15 23:07:55', 199.99, 'Cillum dolore eu fugiat nulla pariatur. Excepteur', 11, 'Entregue', 1),
  ('2023-10-18 10:24:37', 149.99, 'Sint occaecat cupidatat non proident, sunt in', 12, 'Entregue', 2),
  ('2023-10-22 16:16:52', 139.99, 'Culpa qui officia deserunt mollit anim id est', 13, 'Entregue', 3),
  ('2023-10-23 08:45:34', 119.99, 'Eiusmod tempor incididunt ut labore et dolore magna', 14, 'Enviada', 4),
  ('2023-10-16 11:58:07', 89.99, 'Aliqua. Ut enim ad minim veniam, quis', 15, 'Devolvida', 5),
  ('2023-10-17 01:34:20', 109.99, 'Nostrud exercitation ullamco laboris nisi ut aliquip', 16, 'Entregue', 5),
  ('2023-10-18 19:16:45', 129.99, 'Ex ea commodo consequat. Duis aute irure', 17, 'Entregue', 4),
  ('2023-10-19 06:59:55', 69.99, 'Dolor in reprehenderit in voluptate velit esse', 18, 'Entregue', 3),
  ('2023-10-20 08:24:33', 79.99, 'Cillum dolore eu fugiat nulla pariatur. Excepteur', 19, 'Entregue', 2),
  ('2023-10-21 10:43:51', 99.99, 'Sint occaecat cupidatat non proident, sunt in', 20, 'Entregue', 1),
  ('2023-10-22 05:05:33', 179.99, 'Culpa qui officia deserunt mollit anim id est', 1, 'Entregue', 1),
  ('2023-10-23 00:05:28', 69.99, 'Eiusmod tempor incididunt ut labore et dolore magna', 2, 'Entregue', 2),
  ('2023-10-23 00:39:35', 79.99, 'Aliqua. Ut enim ad minim veniam, quis', 3, 'Entregue', 3),
  ('2023-10-23 01:17:05', 59.99, 'Nostrud exercitation ullamco laboris nisi ut aliquip', 4, 'Enviada', 4),
  ('2023-10-23 02:01:32', 139.99, 'Ex ea commodo consequat. Duis aute irure', 5, 'Entregue', 5),
  ('2023-10-23 03:55:27', 49.99, 'Dolor in reprehenderit in voluptate velit esse', 6, 'Entregue', 5),
  ('2023-10-23 04:12:29', 89.99, 'Cillum dolore eu fugiat nulla pariatur. Excepteur', 7, 'Entregue', 4),
  ('2023-10-23 05:26:37', 79.99, 'Sint occaecat cupidatat non proident, sunt in', 8, 'Entregue', 3),
  ('2023-10-23 06:25:36', 119.99, 'Culpa qui officia deserunt mollit anim id est', 9, 'Entregue', 2),
  ('2023-10-23 07:20:39', 29.99, 'Eiusmod tempor incididunt ut labore et dolore magna', 10, 'Entregue', 1),
  ('2023-10-23 08:46:01', 179.99, 'Aliqua. Ut enim ad minim veniam, quis', 11, 'Entregue', 2),
  ('2023-10-23 09:40:25', 69.99, 'Nostrud exercitation ullamco laboris nisi ut aliquip', 12, 'Enviada', 3),
  ('2023-10-23 10:33:23', 109.99, 'Ex ea commodo consequat. Duis aute irure', 13, 'Enviada', 4),
  ('2023-10-23 11:47:45', 59.99, 'Dolor in reprehenderit in voluptate velit esse', 14, 'Enviada', 5),
  ('2023-10-23 12:54:04', 149.99, 'Cillum dolore eu fugiat nulla pariatur. Excepteur', 15, 'Enviada', 5),
  ('2023-10-23 13:58:29', 79.99, 'Sint occaecat cupidatat non proident, sunt in', 16, 'Enviada', 4),
  ('2023-10-23 14:10:09', 139.99, 'Culpa qui officia deserunt mollit anim id est', 17, 'Enviada', 3),
  ('2023-10-23 15:30:15', 99.99, 'Eiusmod tempor incididunt ut labore et dolore magna', 18, 'Enviada', 2),
  ('2023-10-23 16:15:02', 119.99, 'Aliqua. Ut enim ad minim veniam, quis', 19, 'Enviada', 1),
  ('2023-10-23 17:25:44', 69.99, 'Nostrud exercitation ullamco laboris nisi ut aliquip', 20, 'Enviada', 1);

INSERT INTO Transporte (tipo, precoAtual) VALUES
  ('Grátis', 0),
  ('Levantamento em Ponto Pick-up', 2.5),
  ('Entrega ao domicílio', 5);

INSERT INTO Devolucao (timestamp, estado, id_compra) VALUES
  ('2023-08-15 08:15:30', 'Pendente', 27),
  ('2023-08-20 15:42:12', 'Aprovado', 56),
  ('2023-08-25 14:30:59', 'Rejeitado', 89),
  ('2023-09-05 11:20:47', 'Pendente', 7),
  ('2023-09-10 20:05:34', 'Aprovado', 42),
  ('2023-09-15 05:38:29', 'Rejeitado', 13),
  ('2023-09-20 09:51:01', 'Pendente', 61),
  ('2023-09-25 14:17:55', 'Aprovado', 75),
  ('2023-09-30 23:42:03', 'Rejeitado', 93),
  ('2023-10-05 16:29:14', 'Pendente', 34);

INSERT INTO Reembolso (timestamp, estado, id_compra) VALUES
  ('2023-08-15 08:15:30', 'Pendente', 27),
  ('2023-08-20 15:42:12', 'Aprovado', 56),
  ('2023-08-25 14:30:59', 'Rejeitado', 89),
  ('2023-09-05 11:20:47', 'Pendente', 7),
  ('2023-09-10 20:05:34', 'Aprovado', 42),
  ('2023-09-15 05:38:29', 'Rejeitado', 13),
  ('2023-09-20 09:51:01', 'Pendente', 61),
  ('2023-09-25 14:17:55', 'Aprovado', 75),
  ('2023-09-30 23:42:03', 'Rejeitado', 93),
  ('2023-10-05 16:29:14', 'Pendente', 34);

INSERT INTO Notificacao (timestamp, texto, id_utilizador)
VALUES
  ('2023-09-01 08:15:30', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit', 1),
  ('2023-09-02 15:42:12', 'Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua', 2),
  ('2023-09-03 14:30:59', 'Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris', 3),
  ('2023-09-04 11:20:47', 'Nisi ut aliquip ex ea commodo consequat', 4),
  ('2023-09-05 20:05:34', 'Duis aute irure dolor in reprehenderit in voluptate velit esse cillum', 5),
  ('2023-09-06 05:38:29', 'Excepteur sint occaecat cupidatat non proident, sunt in culpa', 6),
  ('2023-09-07 09:51:01', 'Qui officia deserunt mollit anim id est laborum', 7),
  ('2023-09-08 14:17:55', 'Consectetur adipiscing elit, sed do eiusmod tempor incididunt', 8),
  ('2023-09-09 23:42:03', 'Ut labore et dolore magna aliqua. Ut enim ad', 9),
  ('2023-09-10 16:29:14', 'Minim veniam, quis nostrud exercitation ullamco laboris nisi', 10),
  ('2023-09-11 05:05:33', 'Ut aliquip ex ea commodo consequat. Duis aute', 11),
  ('2023-09-12 17:56:28', 'Excepteur sint occaecat cupidatat non proident, sunt in', 12),
  ('2023-09-13 00:39:35', 'Culpa qui officia deserunt mollit anim id est', 13),
  ('2023-09-14 08:17:05', 'Eiusmod tempor incididunt ut labore et dolore magna', 14),
  ('2023-09-15 19:01:32', 'Aliqua. Ut enim ad minim veniam, quis', 15),
  ('2023-09-16 06:54:04', 'Nostrud exercitation ullamco laboris nisi ut aliquip', 16),
  ('2023-09-17 17:58:29', 'Ex ea commodo consequat. Duis aute irure', 17),
  ('2023-09-18 21:10:09', 'Dolor in reprehenderit in voluptate velit esse', 18),
  ('2023-09-19 10:30:15', 'Cillum dolore eu fugiat nulla pariatur. Excepteur', 19),
  ('2023-09-20 19:15:02', 'Sint occaecat cupidatat non proident, sunt in', 20),
  ('2023-09-21 11:58:07', 'Aliqua. Ut enim ad minim veniam, quis', 1),
  ('2023-09-22 01:34:20', 'Nostrud exercitation ullamco laboris nisi ut aliquip', 2),
  ('2023-09-23 19:16:45', 'Ex ea commodo consequat. Duis aute irure', 3),
  ('2023-09-24 06:59:55', 'Dolor in reprehenderit in voluptate velit esse', 4),
  ('2023-09-25 08:24:33', 'Cillum dolore eu fugiat nulla pariatur. Excepteur', 5),
  ('2023-09-26 10:43:51', 'Sint occaecat cupidatat non proident, sunt in', 6),
  ('2023-09-27 05:05:33', 'Culpa qui officia deserunt mollit anim id est', 7),
  ('2023-09-28 17:56:28', 'Eiusmod tempor incididunt ut labore et dolore magna', 8),
  ('2023-09-29 00:39:35', 'Aliqua. Ut enim ad minim veniam, quis', 9),
  ('2023-09-30 08:17:05', 'Nostrud exercitation ullamco laboris nisi ut aliquip', 10),
  ('2023-10-01 19:01:32', 'Ex ea commodo consequat. Duis aute irure', 11),
  ('2023-10-02 06:54:04', 'Dolor in reprehenderit in voluptate velit esse', 12),
  ('2023-10-03 00:12:29', 'Cillum dolore eu fugiat nulla pariatur. Excepteur', 13),
  ('2023-10-04 06:26:37', 'Sint occaecat cupidatat non proident, sunt in', 14),
  ('2023-10-05 21:25:36', 'Culpa qui officia deserunt mollit anim id est', 15),
  ('2023-10-06 08:20:39', 'Eiusmod tempor incididunt ut labore et dolore magna', 16),
  ('2023-10-07 05:46:01', 'Aliqua. Ut enim ad minim veniam, quis', 17),
  ('2023-10-08 16:40:25', 'Nostrud exercitation ullamco laboris nisi ut', 18),
  ('2023-10-09 03:33:23', 'Ex ea commodo consequat. Duis aute irure', 19),
  ('2023-10-10 14:47:45', 'Dolor in reprehenderit in voluptate velit esse', 20),
  ('2023-10-11 06:54:04', 'Cillum dolore eu fugiat nulla pariatur. Excepteur', 1),
  ('2023-10-12 17:58:29', 'Sint occaecat cupidatat non proident, sunt in', 2),
  ('2023-10-13 21:10:09', 'Culpa qui officia deserunt mollit anim id est', 3),
  ('2023-10-14 10:30:15', 'Eiusmod tempor incididunt ut labore et dolore magna', 4),
  ('2023-10-15 19:15:02', 'Aliqua. Ut enim ad minim veniam, quis', 5),
  ('2023-10-16 08:20:39', 'Nostrud exercitation ullamco laboris nisi ut aliquip', 6),
  ('2023-10-17 05:46:01', 'Ex ea commodo consequat. Duis aute irure', 7),
  ('2023-10-18 16:40:25', 'Dolor in reprehenderit in voluptate velit esse', 8),
  ('2023-10-19 03:33:23', 'Cillum dolore eu fugiat nulla pariatur. Excepteur', 9),
  ('2023-10-20 14:47:45', 'Sint occaecat cupidatat non proident, sunt in', 10),
  ('2023-10-21 06:54:04', 'Culpa qui officia deserunt mollit anim id est', 11),
  ('2023-10-22 17:58:29', 'Eiusmod tempor incididunt ut labore et dolore magna', 12),
  ('2023-10-23 00:10:09', 'Aliqua. Ut enim ad minim veniam, quis', 13),
  ('2023-10-23 01:30:15', 'Nostrud exercitation ullamco laboris nisi ut', 14),
  ('2023-10-23 02:15:02', 'Ex ea commodo consequat. Duis aute irure', 15),
  ('2023-10-23 02:20:39', 'Dolor in reprehenderit in voluptate velit esse', 16),
  ('2023-10-23 02:46:01', 'Cillum dolore eu fugiat nulla pariatur. Excepteur', 17),
  ('2023-10-23 03:40:25', 'Sint occaecat cupidatat non proident, sunt in', 18),
  ('2023-10-23 04:33:23', 'Culpa qui officia deserunt mollit anim id est', 19),
  ('2023-10-23 04:47:45', 'Eiusmod tempor incididunt ut labore et dolore magna', 20),
  ('2023-10-23 04:54:04', 'Aliqua. Ut enim ad minim veniam, quis', 1),
  ('2023-10-23 04:58:29', 'Nostrud exercitation ullamco laboris nisi ut', 2),
  ('2023-10-23 05:33:23', 'Ex ea commodo consequat. Duis aute irure', 3),
  ('2023-10-23 05:47:45', 'Dolor in reprehenderit in voluptate velit esse', 4),
  ('2023-10-23 05:54:04', 'Cillum dolore eu fugiat nulla pariatur. Excepteur', 5),
  ('2023-10-23 06:40:25', 'Sint occaecat cupidatat non proident, sunt in', 6),
  ('2023-10-23 07:33:23', 'Culpa qui officia deserunt mollit anim id est', 7),
  ('2023-10-23 07:47:45', 'Eiusmod tempor incididunt ut labore et dolore magna', 8),
  ('2023-10-23 07:54:04', 'Aliqua. Ut enim ad minim veniam, quis', 9),
  ('2023-10-23 07:58:29', 'Nostrud exercitation ullamco laboris nisi ut', 10),
  ('2023-10-23 08:33:23', 'Ex ea commodo consequat. Duis aute irure', 11),
  ('2023-10-23 08:47:45', 'Dolor in reprehenderit in voluptate velit esse', 12),
  ('2023-10-23 08:54:04', 'Cillum dolore eu fugiat nulla pariatur. Excepteur', 13),
  ('2023-10-23 09:40:25', 'Sint occaecat cupidatat non proident, sunt in', 14),
  ('2023-10-23 10:33:23', 'Culpa qui officia deserunt mollit anim id est', 15),
  ('2023-10-23 10:47:45', 'Eiusmod tempor incididunt ut labore et dolore magna', 16),
  ('2023-10-23 11:54:04', 'Aliqua. Ut enim ad minim veniam, quis', 17),
  ('2023-10-23 11:58:29', 'Nostrud exercitation ullamco laboris nisi ut', 18),
  ('2023-10-23 12:33:23', 'Ex ea commodo consequat. Duis aute irure', 19),
  ('2023-10-23 12:47:45', 'Dolor in reprehenderit in voluptate velit esse', 20),
  ('2023-10-23 12:54:04', 'Cillum dolore eu fugiat nulla pariatur. Excepteur', 1),
  ('2023-10-23 13:40:25', 'Sint occaecat cupidatat non proident, sunt in', 2),
  ('2023-10-23 14:33:23', 'Culpa qui officia deserunt mollit anim id est', 3),
  ('2023-10-23 14:47:45', 'Eiusmod tempor incididunt ut labore et dolore magna', 4),
  ('2023-10-23 14:54:04', 'Aliqua. Ut enim ad minim veniam, quis', 5),
  ('2023-10-23 14:58:29', 'Nostrud exercitation ullamco laboris nisi ut', 6),
  ('2023-10-23 15:33:23', 'Ex ea commodo consequat. Duis aute irure', 7),
  ('2023-10-23 15:47:45', 'Dolor in reprehenderit in voluptate velit esse', 8),
  ('2023-10-23 15:54:04', 'Cillum dolore eu fugiat nulla pariatur. Excepteur', 9),
  ('2023-10-23 16:40:25', 'Sint occaecat cupidatat non proident, sunt in', 10),
  ('2023-10-23 17:33:23', 'Culpa qui officia deserunt mollit anim id est', 11),
  ('2023-10-23 17:47:45', 'Eiusmod tempor incididunt ut labore et dolore magna', 12),
  ('2023-10-23 17:54:04', 'Aliqua. Ut enim ad minim veniam, quis', 13),
  ('2023-10-23 17:58:29', 'Nostrud exercitation ullamco laboris nisi ut', 14),
  ('2023-10-23 18:33:23', 'Ex ea commodo consequat. Duis aute irure', 15),
  ('2023-10-23 19:47:45', 'Dolor in reprehenderit in voluptate velit esse', 16),
  ('2023-10-23 20:54:04', 'Cillum dolore eu fugiat nulla pariatur. Excepteur', 17),
  ('2023-10-23 21:58:29', 'Sint occaecat cupidatat non proident, sunt in', 18),
  ('2023-10-23 22:33:23', 'Culpa qui officia deserunt mollit anim id est', 19),
  ('2023-10-23 22:47:45', 'Eiusmod tempor incididunt ut labore et dolore magna', 20),
  ('2023-10-23 22:54:04', 'Aliqua. Ut enim ad minim veniam, quis', 1),
  ('2023-10-23 22:58:29', 'Nostrud exercitation ullamco laboris nisi ut', 2),
  ('2023-10-23 23:33:23', 'Ex ea commodo consequat. Duis aute irure', 3),
  ('2023-10-23 23:47:45', 'Dolor in reprehenderit in voluptate velit esse', 4),
  ('2023-10-23 23:54:04', 'Cillum dolore eu fugiat nulla pariatur. Excepteur', 5),
  ('2023-10-24 00:40:25', 'Sint occaecat cupidatat non proident, sunt in', 6),
  ('2023-10-24 01:33:23', 'Culpa qui officia deserunt mollit anim id est', 7),
  ('2023-10-24 01:47:45', 'Eiusmod tempor incididunt ut labore et dolore magna', 8),
  ('2023-10-24 01:54:04', 'Aliqua. Ut enim ad minim veniam, quis', 9),
  ('2023-10-24 01:58:29', 'Nostrud exercitation ullamco laboris nisi ut', 10),
  ('2023-10-24 02:33:23', 'Ex ea commodo consequat. Duis aute irure', 11),
  ('2023-10-24 02:47:45', 'Dolor in reprehenderit in voluptate velit esse', 12),
  ('2023-10-24 02:54:04', 'Cillum dolore eu fugiat nulla pariatur. Excepteur', 13),
  ('2023-10-24 03:40:25', 'Sint occaecat cupidatat non proident, sunt in', 14),
  ('2023-10-24 04:33:23', 'Culpa qui officia deserunt mollit anim id est', 15),
  ('2023-10-24 04:47:45', 'Eiusmod tempor incididunt ut labore et dolore magna', 16),
  ('2023-10-24 04:54:04', 'Aliqua. Ut enim ad minim veniam, quis', 17),
  ('2023-10-24 04:58:29', 'Nostrud exercitation ullamco laboris nisi ut', 18),
  ('2023-10-24 05:33:23', 'Ex ea commodo consequat. Duis aute irure', 19),
  ('2023-10-24 05:47:45', 'Dolor in reprehenderit in voluptate velit esse', 20);

INSERT INTO Produto (nome, descricao, precoAtual, desconto, stock, id_administrador) VALUES
  ('Pimenta Malagueta', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.', 3.99, 0.05, 100, 1),
  ('Molho de Piri-Piri', 'Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', 4.50, 0.03, 75, 2),
  ('Canela em Pau', 'Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris.', 6.25, 0, 250, 3),
  ('Paprica Doce', 'Duis aute irure dolor in reprehenderit in voluptate velit esse cillum.', 8.75, 0.20, 150, 4),
  ('Molho de Tomate Picante', 'Excepteur sint occaecat cupidatat non proident, sunt in culpa.', 3.25, 0.05, 200, 5),
  ('Noz-Moscada Moída', 'Qui officia deserunt mollit anim id est laborum.', 7.80, 0.10, 50, 1),
  ('Molho de Mostarda', 'Consectetur adipiscing elit, sed do eiusmod tempor incididunt.', 5.75, 0, 100, 2),
  ('Alho em Pó', 'Ut labore et dolore magna aliqua. Ut enim ad minim veniam.', 6.50, 0, 300, 3),
  ('Salsa Seca', 'Minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip.', 2.50, 0, 20, 4),
  ('Molho de Soja Picante', 'Ut aliquip ex ea commodo consequat. Duis aute.', 4.99, 0, 350, 5),
  ('Orégãos Secos', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.', 3.99, 0, 100, 1),
  ('Molho de Piri-Piri', 'Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', 4.50, 0.3, 75, 2),
  ('Canela em Pau', 'Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris.', 6.25, 0, 250, 3),
  ('Paprica Doce', 'Duis aute irure dolor in reprehenderit in voluptate velit esse cillum.', 8.75, 0, 150, 4),
  ('Molho de Tomate Picante', 'Excepteur sint occaecat cupidatat non proident, sunt in culpa.', 3.25, 0, 200, 5),
  ('Noz-Moscada Moída', 'Qui officia deserunt mollit anim id est laborum.', 7.80, 1, 0.50, 1),
  ('Molho de Mostarda', 'Consectetur adipiscing elit, sed do eiusmod tempor incididunt.', 5.75, 0.70, 100, 2),
  ('Alho em Pó', 'Ut labore et dolore magna aliqua. Ut enim ad minim veniam.', 6.50, 0, 300, 3),
  ('Salsa Seca', 'Minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip.', 2.50, 0, 20, 4),
  ('Molho de Soja Picante', 'Ut aliquip ex ea commodo consequat. Duis aute.', 4.99, 0, 350, 5),
  ('Orégãos Secos', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.', 3.99, 5, 100, 1),
  ('Molho de Piri-Piri', 'Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', 4.50, 0, 75, 2),
  ('Canela em Pau', 'Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris.', 6.25, 0, 250, 3),
  ('Paprica Doce', 'Duis aute irure dolor in reprehenderit in voluptate velit esse cillum.', 8.75, 0, 150, 4),
  ('Molho de Tomate Picante', 'Excepteur sint occaecat cupidatat non proident, sunt in culpa.', 3.25, 0, 200, 5),
  ('Noz-Moscada Moída', 'Qui officia deserunt mollit anim id est laborum.', 7.80, 0, 50, 1),
  ('Molho de Mostarda', 'Consectetur adipiscing elit, sed do eiusmod tempor incididunt.', 5.75, 0, 100, 2),
  ('Alho em Pó', 'Ut labore et dolore magna aliqua. Ut enim ad minim veniam.', 6.50, 0, 300, 3),
  ('Salsa Seca', 'Minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip.', 2.50, 0.35, 20, 4),
  ('Molho de Soja Picante', 'Ut aliquip ex ea commodo consequat. Duis aute.', 4.99, 0, 350, 5),
  ('Orégãos Secos', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.', 3.99, 0, 100, 1),
  ('Molho de Piri-Piri', 'Sed do eiusmod tempor incididunt ut labore et dolore magna.', 4.50, 0, 75, 2),
  ('Canela em Pau', 'Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris.', 6.25, 0, 250, 3),
  ('Paprica Doce', 'Duis aute irure dolor in reprehenderit in voluptate velit esse cillum.', 8.75, 0, 150, 4),
  ('Molho de Tomate Picante', 'Excepteur sint occaecat cupidatat non proident, sunt in culpa.', 3.25, 0, 200, 5),
  ('Noz-Moscada Moída', 'Qui officia deserunt mollit anim id est laborum.', 7.80, 0, 50, 1),
  ('Molho de Mostarda', 'Consectetur adipiscing elit, sed do eiusmod tempor incididunt.', 5.75, 0.2, 100, 2),
  ('Alho em Pó', 'Ut labore et dolore magna aliqua. Ut enim ad minim veniam.', 6.50, 0, 300, 3),
  ('Salsa Seca', 'Minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip.', 2.50, 0.4, 20, 4),
  ('Molho de Soja Picante', 'Ut aliquip ex ea commodo consequat. Duis aute.', 4.99, 0, 350, 5),
  ('Orégãos Secos', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.', 3.99, 0, 100, 1),
  ('Molho de Piri-Piri', 'Sed do eiusmod tempor incididunt ut labore et dolore magna.', 4.50, 0, 75, 2),
  ('Canela em Pau', 'Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris.', 6.25, 0, 250, 3),
  ('Paprica Doce', 'Duis aute irure dolor in reprehenderit in voluptate velit esse cillum.', 8.75, 0, 150, 4),
  ('Molho de Tomate Picante', 'Excepteur sint occaecat cupidatat non proident, sunt in culpa.', 3.25, 0, 200, 5),
  ('Noz-Moscada Moída', 'Qui officia deserunt mollit anim id est laborum.', 7.80, 0, 50, 1),
  ('Molho de Mostarda', 'Consectetur adipiscing elit, sed do eiusmod tempor incididunt.', 5.75, 0.7, 100, 2),
  ('Alho em Pó', 'Ut labore et dolore magna aliqua. Ut enim ad minim veniam.', 6.50, 0, 300, 3),
  ('Salsa Seca', 'Minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip.', 2.50, 0.5, 20, 4),
  ('Molho de Soja Picante', 'Ut aliquip ex ea commodo consequat. Duis aute.', 4.99, 0, 350, 5);

INSERT INTO Comentario (timestamp, texto, avaliacao, id_utilizador, id_produto) VALUES
  ('2023-08-15 08:15:30', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.', 4, 20, 8),
  ('2023-08-16 10:20:45', 'Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', 3, 10, 15),
  ('2023-08-17 12:35:15', 'Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris.', 5, 8, 32),
  ('2023-08-18 14:45:59', 'Duis aute irure dolor in reprehenderit in voluptate velit esse cillum.', 2, 12, 21),
  ('2023-08-19 16:55:37', 'Excepteur sint occaecat cupidatat non proident, sunt in culpa.', 1, 11, 5);

INSERT INTO Notificacao_Compra (id, id_compra) VALUES
  (1, 1),
  (2, 2),
  (3, 3),
  (4, 4),
  (5, 5),
  (6, 6),
  (7, 7),
  (8, 8),
  (9, 9),
  (10, 10),
  (11, 11),
  (12, 12),
  (13, 13),
  (14, 14),
  (15, 15),
  (16, 16),
  (17, 17),
  (18, 18),
  (19, 19),
  (20, 20),
  (21, 21),
  (22, 22),
  (23, 23),
  (24, 24),
  (25, 25),
  (26, 26),
  (27, 27),
  (28, 28),
  (29, 29),
  (30, 30),
  (31, 31),
  (32, 32),
  (33, 33),
  (34, 34),
  (35, 35),
  (36, 36),
  (37, 37),
  (38, 38),
  (39, 39),
  (40, 40),
  (41, 41),
  (42, 42),
  (43, 43),
  (44, 44),
  (45, 45),
  (46, 46),
  (47, 47),
  (48, 48),
  (49, 49),
  (50, 50),
  (51, 51),
  (52, 52),
  (53, 53),
  (54, 54),
  (55, 55),
  (56, 56),
  (57, 57),
  (58, 58),
  (59, 59),
  (60, 60),
  (61, 61),
  (62, 62),
  (63, 63),
  (64, 64),
  (65, 65),
  (66, 66),
  (67, 67),
  (68, 68),
  (69, 69),
  (70, 70),
  (71, 71),
  (72, 72),
  (73, 73),
  (74, 74),
  (75, 75),
  (76, 76),
  (77, 77),
  (78, 78),
  (79, 79),
  (80, 80),
  (81, 81),
  (82, 82),
  (83, 83),
  (84, 84),
  (85, 85),
  (86, 86),
  (87, 87),
  (88, 88),
  (89, 89),
  (90, 90),
  (91, 91),
  (92, 92),
  (93, 93),
  (94, 94),
  (95, 95),
  (96, 96),
  (97, 97),
  (98, 98),
  (99, 99),
  (100, 100);

INSERT INTO Notificacao_Devolucao (id, id_devolucao) VALUES
  (1, 1),
  (2, 2),
  (3, 3),
  (4, 4),
  (5, 5),
  (6, 6),
  (7, 7),
  (8, 8),
  (9, 9),
  (10, 10);

INSERT INTO Notificacao_Reembolso (id, id_reembolso) VALUES
  (1, 1),
  (2, 2),
  (3, 3),
  (4, 4),
  (5, 5),
  (6, 6),
  (7, 7),
  (8, 8),
  (9, 9),
  (10, 10);
