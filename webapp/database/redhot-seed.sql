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
DROP TABLE IF EXISTS Notificacao_Carrinho CASCADE;
DROP TABLE IF EXISTS Notificacao_Wishlist CASCADE;

CREATE TABLE Utilizador (
	id SERIAL PRIMARY KEY,
  nome VARCHAR(256) NOT NULL,
  email VARCHAR(256) UNIQUE NOT NULL,
	password VARCHAR(256) NOT NULL,
  telefone VARCHAR(256),
  morada VARCHAR(256),
  codigo_postal VARCHAR(256),
  localidade VARCHAR(256),
  remember_token VARCHAR(256),
  profile_image VARCHAR(1024)
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
  id_utilizador INTEGER REFERENCES Utilizador (id) ON UPDATE CASCADE,
  id_administrador INTEGER REFERENCES Administrador (id) ON UPDATE CASCADE,
  link VARCHAR(1024),
  lida BOOLEAN NOT NULL DEFAULT FALSE,
  para_todos_administradores BOOLEAN NOT NULL DEFAULT FALSE
);

CREATE TABLE Produto (
	id SERIAL PRIMARY KEY,
  nome VARCHAR(256) NOT NULL,
	descricao TEXT NOT NULL,
  precoAtual FLOAT NOT NULL CHECK (precoAtual >= 0),
	desconto FLOAT CHECK (desconto >= 0 AND desconto <= 100),
  stock INTEGER NOT NULL CHECK (stock >= 0),
  id_administrador INTEGER REFERENCES Administrador (id) ON UPDATE CASCADE,
  product_image VARCHAR(1024),
  categoria VARCHAR(256),
  destaque BOOLEAN DEFAULT FALSE
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
	id SERIAL PRIMARY KEY,
  id_utilizador INTEGER REFERENCES Utilizador (id) ON UPDATE CASCADE,
  id_produto INTEGER REFERENCES Produto (id) ON UPDATE CASCADE
);

CREATE TABLE UtilizadorNaoAutenticadoComProdutosNoCarrinho (
	id INTEGER PRIMARY KEY
);

CREATE TABLE ProdutoCarrinho (
	id SERIAL PRIMARY KEY,
  id_produto INTEGER REFERENCES Produto (id) ON UPDATE CASCADE,
	id_utilizador INTEGER REFERENCES Utilizador (id) ON UPDATE CASCADE,
  quantidade INTEGER NOT NULL CHECK (quantidade > 0),
	id_utilizador_nao_autenticado INTEGER
);

CREATE TABLE ProdutoCompra (
  id SERIAL PRIMARY KEY,
  id_produto INTEGER REFERENCES Produto (id) ON UPDATE CASCADE,
  id_compra INTEGER REFERENCES Compra (id) ON UPDATE CASCADE,
  quantidade INTEGER NOT NULL CHECK (quantidade > 0),
  preco FLOAT NOT NULL CHECK (preco >= 0)
);

CREATE TABLE Notificacao_Carrinho (
	id INTEGER PRIMARY KEY REFERENCES Notificacao (id) ON UPDATE CASCADE,
  id_produto_carrinho INTEGER REFERENCES ProdutoCarrinho (id) ON UPDATE CASCADE
);

CREATE TABLE Notificacao_Wishlist (
	id INTEGER PRIMARY KEY REFERENCES Notificacao (id) ON UPDATE CASCADE,
  id_produto_wishlist INTEGER REFERENCES ProdutoWishlist (id) ON UPDATE CASCADE
);

CREATE TABLE Faqs (
  id SERIAL PRIMARY KEY,
  pergunta TEXT NOT NULL,
  resposta TEXT NOT NULL,
  id_administrador INTEGER REFERENCES Administrador (id) ON UPDATE CASCADE
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

INSERT INTO Utilizador (nome, email, password, profile_image) VALUES ('Utilizador','user@users.com','$2y$10$Rs590ufQ2U3ies52lz1R0.KNlZaOIaVoPGJqKqbYBG5ZLaCwDVZ3.', 'profile/1u9ceaMiBdeI0gaSjwfqQ3C73dPHULuVKzOhzXDf.gif'); -- password: 12345678

INSERT INTO Administrador (nome, email, password) VALUES ('admin', 'admin@admin.pt', '$2y$10$R6IeqCxQxMConGFO3OHuq.Um2vxTYB9NKikC6Hky8cmUCln6jl5k6'); -- password: 12345678

INSERT INTO Produto (nome, descricao, precoAtual, desconto, stock, id_administrador, categoria, destaque) VALUES
  ('Molho de Malagueta Habanero Extra Forte', 'Molho picante feito com malaguetas Habanero para os amantes de pimenta.', 7.99, 0.1, 40, 1, 'Molhos', true),
  ('Sementes de Malagueta Jalapeño', 'Sementes de malagueta Jalapeño para cultivar em seu jardim ou horta.', 4.50, 0.05, 100, 1, 'Sementes', true),
  ('Malagueta Ghost Pepper Seca', 'Malagueta seca da variedade Ghost Pepper, conhecida por sua extrema pungência.', 10.99, 0.15, 30, 1, 'Especiarias', true),
  ('Picles de Malagueta Agridoce', 'Picles de malagueta agridoce, uma deliciosa opção para aperitivos.', 6.25, 0.08, 50, 1, 'Conservas', true),
  ('Molho de Malagueta Chipotle Defumado', 'Molho defumado com malaguetas Chipotle para um sabor único.', 8.75, 0.12, 35, 1, 'Molhos', false),
  ('Malagueta Trinidad Scorpion Fresca', 'Experimente a potência da malagueta Trinidad Scorpion em sua forma fresca.', 12.99, 0.2, 25, 1, 'Malaguetas Frescas', false),
  ('Tempero de Malagueta Cajun', 'Tempero Cajun com o toque picante da malagueta, ideal para pratos saborosos.', 5.75, 0.07, 60, 1, 'Temperos', false),
  ('Pó de Malagueta Red Savina', 'Pó de malagueta Red Savina, um toque de calor intenso para suas receitas.', 9.50, 0.1, 45, 1, 'Temperos', false),
  ('Molho de Malagueta Szechuan', 'Molho de malagueta Szechuan para adicionar um sabor asiático aos seus pratos.', 7.25, 0.09, 55, 1, 'Molhos', false),
  ('Conjunto de Malaguetas Ornamentais Variadas', 'Decore seu espaço com este conjunto de malaguetas ornamentais em diferentes cores.', 15.50, 0.18, 20, 1, 'Decoração', false),
  ('Pimenta Habanero em Conserva', 'Pimentas Habanero em conserva, perfeitas para dar um toque picante aos seus sanduíches.', 6.99, 0.06, 70, 1, 'Conservas', false),
  ('Molho de Malagueta Thai Sweet Chili', 'Molho agridoce de malagueta Thai Sweet Chili para uma explosão de sabores.', 8.50, 0.1, 40, 1, 'Molhos', false),
  ('Kit de Cultivo Indoor de Malaguetas', 'Crie sua plantação de malaguetas em casa com este kit para cultivo indoor.', 18.99, 0.25, 15, 1, 'Plantas', false),
  ('Malagueta Aleppo Seca', 'Malagueta Aleppo seca, com um toque frutado, perfeita para pratos mediterrâneos.', 11.75, 0.15, 30, 1, 'Especiarias', false),
  ('Molho de Malagueta Mango Habanero', 'Molho de malagueta com a doçura da manga e o calor da Habanero.', 9.25, 0.1, 50, 1, 'Molhos', false),
  ('Sementes de Malagueta Scotch Bonnet', 'Sementes de malagueta Scotch Bonnet para cultivar em seu próprio jardim.', 5.99, 0.07, 80, 1, 'Sementes', false),
  ('Malagueta Cherry Bomb Fresca', 'Malagueta Cherry Bomb fresca, uma opção suave para quem aprecia um toque de pimenta.', 14.99, 0.2, 25, 1, 'Malaguetas Frescas', false),
  ('Molho de Malagueta Citrus Inferno', 'Molho picante com toques cítricos para uma experiência explosiva.', 7.75, 0.08, 65, 1, 'Molhos', false),
  ('Malagueta Aleppo em Conserva', 'Pimentas Aleppo em conserva, ideais para saladas e aperitivos.', 6.25, 0.05, 90, 1, 'Conservas', false),
  ('Molho de Malagueta Barbecue Picante', 'Molho de malagueta com sabor defumado, perfeito para churrascos.', 10.50, 0.12, 40, 1, 'Molhos', false),
  ('Malagueta Thai Bird Eye Fresca', 'Malagueta Thai Bird Eye fresca, excelente para pratos tailandeses autênticos.', 13.25, 0.18, 30, 1, 'Malaguetas Frescas', false),
  ('Molho de Malagueta Harissa', 'Molho de malagueta Harissa para dar um toque picante à culinária do Oriente Médio.', 8.99, 0.1, 55, 1, 'Molhos', false),
  ('Mix de Pimentas em Conserva', 'Mix de pimentas em conserva para uma explosão de sabores no seu paladar.', 9.75, 0.1, 50, 1, 'Conservas', false),
  ('Malagueta Lemon Drop Seca', 'Malagueta Lemon Drop seca, conhecida por seu sabor cítrico e ardência intensa.', 12.50, 0.15, 35, 1, 'Especiarias', false),
  ('Molho de Malagueta Raspberry Inferno', 'Molho de malagueta com toques de framboesa para uma experiência única.', 11.25, 0.13, 45, 1, 'Molhos', false),
  ('Sementes de Malagueta Habanero', 'Malagueta extremamente picante, originária da região do Caribe.', 5.99, 0.1, 50, 1, 'Sementes', false),
  ('Molho de Malagueta Chipotle', 'Molho defumado com malaguetas Chipotle, perfeito para churrascos.', 6.75, 0.07, 80, 1, 'Molhos', false),
  ('Malagueta Thai Bird Eye Seca', 'Malagueta seca da variedade Thai Bird Eye, ideal para pratos asiáticos.', 8.49, 0.12, 30, 1, 'Especiarias', false),
  ('Pó de Malagueta Ancho', 'Pó de malagueta Ancho, suave e defumado, ótimo para temperar carnes.', 9.99, 0.15, 40, 1, 'Temperos', false),
  ('Conjunto de Malaguetas Ornamentais', 'Decore sua casa com malaguetas ornamentais em diferentes cores.', 12.50, 0.2, 20, 1, 'Decoração', false),
  ('Óleo de Malagueta Infundido', 'Óleo de oliva infundido com malaguetas, ideal para dar um toque picante aos pratos.', 7.99, 0.1, 60, 1, 'Óleos', false),
  ('Malagueta Bhut Jolokia Fresca', 'Experimente a intensidade da malagueta Bhut Jolokia, uma das mais picantes do mundo.', 15.99, 0.25, 15, 1, 'Malaguetas Frescas', false),
  ('Mistura de Malaguetas Secas', 'Mistura de malaguetas secas de várias variedades para dar um toque especial aos seus pratos.', 10.25, 0.18, 35, 1, 'Especiarias', false),
  ('Chutney de Malagueta e Manga', 'Chutney agridoce com malagueta e manga, ideal para acompanhar queijos.', 8.75, 0.1, 50, 1, 'Condimentos', false),
  ('Pimenta Jalapeño em Conserva', 'Pimentas Jalapeño em conserva, prontas para serem adicionadas aos seus pratos.', 5.25, 0.05, 70, 1, 'Conservas', false),
  ('Molho de Malagueta Sriracha', 'Molho de malagueta Sriracha, trazendo um toque asiático aos seus pratos.', 6.99, 0.08, 90, 1, 'Molhos', false),
  ('Kit de Cultivo de Malaguetas', 'Crie sua plantação de malaguetas em casa com este kit completo.', 19.99, 0.3, 10, 1, 'Plantas', false),
  ('Malagueta Carolina Reaper Desidratada', 'Experimente o calor intenso da malagueta Carolina Reaper em forma desidratada.', 14.50, 0.2, 25, 1, 'Especiarias', false),
  ('Molho de Malagueta Doce', 'Molho suave de malagueta doce, perfeito para quem prefere um toque leve de pimenta.', 5.50, 0.06, 85, 1, 'Molhos', false),
  ('Pó de Malagueta Kashmiri', 'Pó de malagueta Kashmiri, com sabor único e coloração vibrante para realçar suas receitas.', 11.75, 0.15, 45, 1, 'Temperos', false),
  ('Molho de Malagueta Black Garlic', 'Molho de malagueta enriquecido com alho negro para um sabor único.', 9.99, 0.12, 45, 1, 'Molhos', false),
  ('Pó de Malagueta Thai Bird Eye', 'Pó de malagueta Thai Bird Eye para dar um toque tailandês aos seus pratos.', 7.50, 0.08, 60, 1, 'Temperos', false),
  ('Chips de Malagueta Assada', 'Chips de malagueta assada, um petisco crocante e picante.', 5.25, 0.05, 80, 1, 'Snacks', false),
  ('Molho de Malagueta Smoky Maple', 'Molho de malagueta com aroma defumado e toque de xarope de bordo.', 10.75, 0.15, 40, 1, 'Molhos', false),
  ('Sementes de Malagueta Trinidad 7 Pot', 'Sementes de malagueta Trinidad 7 Pot para os corajosos em busca de pimenta extrema.', 6.99, 0.1, 55, 1, 'Sementes', false),
  ('Conjunto de Malaguetas Variadas em Conserva', 'Conjunto de malaguetas variadas em conserva para explorar diferentes sabores.', 12.25, 0.2, 30, 1, 'Conservas', false),
  ('Molho de Malagueta Sweet Jalapeño', 'Molho agridoce de malagueta com o toque suave da pimenta Jalapeño.', 8.50, 0.1, 50, 1, 'Molhos', false),
  ('Malagueta Scotch Bonnet Seca', 'Malagueta Scotch Bonnet seca, ideal para pratos caribenhos.', 9.25, 0.13, 35, 1, 'Especiarias', false),
  ('Molho de Malagueta Mango Tango', 'Molho de malagueta com a dança tropical da manga, uma explosão de sabores.', 11.50, 0.18, 25, 1, 'Molhos', false),
  ('Kit de Cultivo de Malaguetas Exóticas', 'Crie sua plantação com este kit de malaguetas de variedades exóticas.', 17.99, 0.25, 15, 1, 'Plantas', false),
  ('Malagueta Carolina Reaper em Conserva', 'Pimentas Carolina Reaper em conserva, para os verdadeiros amantes de pimenta.', 7.99, 0.07, 70, 1, 'Conservas', false),
  ('Molho de Malagueta Raspberry Habanero', 'Molho de malagueta com framboesa e a potência da pimenta Habanero.', 8.75, 0.1, 60, 1, 'Molhos', false),
  ('Pó de Malagueta Moruga Scorpion', 'Pó de malagueta Moruga Scorpion para os apreciadores de sabores intensos.', 13.50, 0.15, 30, 1, 'Temperos', false),
  ('Malagueta Peri-Peri Fresca', 'Malagueta Peri-Peri fresca, uma explosão de sabor africano em suas receitas.', 14.25, 0.2, 20, 1, 'Malaguetas Frescas', false),
  ('Molho de Malagueta Green Envy', 'Molho de malagueta verde com um toque de invejável calor.', 6.99, 0.08, 75, 1, 'Molhos', false),
  ('Picles de Malagueta Habanero', 'Picles de malagueta Habanero para os amantes de sabores intensos.', 5.50, 0.06, 85, 1, 'Conservas', false),
  ('Molho de Malagueta Pineapple Heat', 'Molho de malagueta com o calor da pimenta e a doçura do abacaxi.', 9.75, 0.1, 50, 1, 'Molhos', false),
  ('Chips de Malagueta Wasabi', 'Chips de malagueta com um toque picante de wasabi, uma combinação única.', 6.25, 0.05, 65, 1, 'Snacks', false),
  ('Molho de Malagueta Blackberry Inferno', 'Molho de malagueta com amoras para um toque frutado e ardência intensa.', 12.99, 0.15, 40, 1, 'Molhos', false),
  ('Pó de Malagueta Aleppo', 'Pó de malagueta Aleppo para um sabor único com notas frutadas.', 7.25, 0.1, 55, 1, 'Temperos', false),
  ('Malagueta Lemon Habanero Fresca', 'Malagueta Lemon Habanero fresca, uma combinação de citrinos e pimenta.', 15.99, 0.2, 25, 1, 'Malaguetas Frescas', false),
  ('Molho de Malagueta Cilantro Lime', 'Molho de malagueta com o frescor do coentro e limão.', 10.50, 0.12, 35, 1, 'Molhos', false),
  ('Sementes de Malagueta Bhutlah', 'Sementes de malagueta Bhutlah para os que buscam a pimenta mais quente.', 8.99, 0.1, 60, 1, 'Sementes', false),
  ('Picles de Malagueta Sweet Heat', 'Picles de malagueta com um toque agridoce para uma experiência equilibrada.', 6.75, 0.08, 80, 1, 'Conservas', false),
  ('Molho de Malagueta Smoky Raspberry', 'Molho de malagueta defumado com framboesa para uma explosão de sabores.', 11.25, 0.13, 45, 1, 'Molhos', false),
  ('Malagueta Serrano Seca', 'Malagueta Serrano seca para um toque picante e colorido em suas receitas.', 9.75, 0.1, 50, 1, 'Especiarias', false),
  ('Molho de Malagueta Garlic Lime', 'Molho de malagueta com alho e limão para um sabor refrescante.', 7.99, 0.09, 70, 1, 'Molhos', false),
  ('Mix de Malaguetas Frescas', 'Mix de malaguetas frescas para explorar diferentes níveis de calor.', 14.50, 0.18, 30, 1, 'Malaguetas Frescas', false),
  ('Molho de Malagueta Orange Habanero', 'Molho de malagueta com a doçura da laranja e o calor da pimenta Habanero.', 8.25, 0.1, 55, 1, 'Molhos', false),
  ('Malagueta Chocolate Habanero Fresca', 'Malagueta Chocolate Habanero fresca, uma variedade rara com sabor único.', 12.99, 0.2, 25, 1, 'Malaguetas Frescas', false),
  ('Pó de Malagueta Datil', 'Pó de malagueta Datil para um toque de calor com sabor frutado.', 10.99, 0.15, 40, 1, 'Temperos', false),
  ('Molho de Malagueta Sweet Onion', 'Molho de malagueta com cebola doce para uma combinação irresistível.', 9.25, 0.12, 35, 1, 'Molhos', false),
  ('Picles de Malagueta Thai Bird Eye', 'Picles de malagueta Thai Bird Eye para um sabor picante e exótico.', 6.50, 0.07, 80, 1, 'Conservas', false),
  ('Molho de Malagueta Green Serenade', 'Molho de malagueta verde com notas refrescantes, uma serenata de sabores.', 11.75, 0.14, 45, 1, 'Molhos', false),
  ('Sementes de Malagueta Fatalii', 'Sementes de malagueta Fatalii para os aventureiros em busca de pimenta intensa.', 7.75, 0.1, 60, 1, 'Sementes', false),
  ('Malagueta Lemon Drop Seca', 'Malagueta Lemon Drop seca, conhecida por seu sabor cítrico e ardência intensa.', 12.50, 0.15, 35, 1, 'Especiarias', false),
  ('Molho de Malagueta Mango Inferno', 'Molho de malagueta com manga para um toque doce antes do calor intenso.', 8.99, 0.1, 50, 1, 'Molhos', false),
  ('Pó de Malagueta Aji Amarillo', 'Pó de malagueta Aji Amarillo para um sabor autêntico peruano.', 9.75, 0.13, 45, 1, 'Temperos', false),
  ('Malagueta Scotch Bonnet Fresca', 'Malagueta Scotch Bonnet fresca, ideal para pratos caribenhos autênticos.', 14.25, 0.18, 30, 1, 'Malaguetas Frescas', false),
  ('Molho de Malagueta Blueberry Heat', 'Molho de malagueta com o toque frutado das amoras azuis.', 11.99, 0.16, 25, 1, 'Molhos', false),
  ('Molho de Malagueta Habanero Extra Forte', 'Molho picante feito com malaguetas Habanero para os amantes de pimenta.', 7.99, 0, 40, 1, 'Molhos', false),
  ('Sementes de Malagueta Jalapeño', 'Sementes de malagueta Jalapeño para cultivar em seu jardim ou horta.', 4.50, 0, 100, 1, 'Sementes', false),
  ('Malagueta Ghost Pepper Seca', 'Malagueta seca da variedade Ghost Pepper, conhecida por sua extrema pungência.', 10.99, 0, 30, 1, 'Especiarias', false),
  ('Picles de Malagueta Agridoce', 'Picles de malagueta agridoce, uma deliciosa opção para aperitivos.', 6.25, 0, 50, 1, 'Conservas', false),
  ('Molho de Malagueta Chipotle Defumado', 'Molho defumado com malaguetas Chipotle para um sabor único.', 8.75, 0, 35, 1, 'Molhos', false),
  ('Malagueta Trinidad Scorpion Fresca', 'Experimente a potência da malagueta Trinidad Scorpion em sua forma fresca.', 12.99, 0, 25, 1, 'Malaguetas Frescas', false),
  ('Tempero de Malagueta Cajun', 'Tempero Cajun com o toque picante da malagueta, ideal para pratos saborosos.', 5.75, 0, 60, 1, 'Temperos', false),
  ('Pó de Malagueta Red Savina', 'Pó de malagueta Red Savina, um toque de calor intenso para suas receitas.', 9.50, 0, 45, 1, 'Temperos', false),
  ('Molho de Malagueta Szechuan', 'Molho de malagueta Szechuan para adicionar um sabor asiático aos seus pratos.', 7.25, 0, 55, 1, 'Molhos', false),
  ('Conjunto de Malaguetas Ornamentais Variadas', 'Decore seu espaço com este conjunto de malaguetas ornamentais em diferentes cores.', 15.50, 0, 20, 1, 'Decoração', false),
  ('Pimenta Habanero em Conserva', 'Pimentas Habanero em conserva, perfeitas para dar um toque picante aos seus sanduíches.', 6.99, 0, 70, 1, 'Conservas', false),
  ('Molho de Malagueta Thai Sweet Chili', 'Molho agridoce de malagueta Thai Sweet Chili para uma explosão de sabores.', 8.50, 0, 40, 1, 'Molhos', false),
  ('Kit de Cultivo Indoor de Malaguetas', 'Crie sua plantação de malaguetas em casa com este kit para cultivo indoor.', 18.99, 0, 15, 1, 'Plantas', false),
  ('Malagueta Aleppo Seca', 'Malagueta Aleppo seca, com um toque frutado, perfeita para pratos mediterrâneos.', 11.75, 0, 30, 1, 'Especiarias', false),
  ('Molho de Malagueta Mango Habanero', 'Molho de malagueta com a doçura da manga e o calor da Habanero.', 9.25, 0, 50, 1, 'Molhos', false),
  ('Sementes de Malagueta Scotch Bonnet', 'Sementes de malagueta Scotch Bonnet para cultivar em seu próprio jardim.', 5.99, 0, 80, 1, 'Sementes', false),
  ('Malagueta Cherry Bomb Fresca', 'Malagueta Cherry Bomb fresca, uma opção suave para quem aprecia um toque de pimenta.', 14.99, 0, 25, 1, 'Malaguetas Frescas', false),
  ('Molho de Malagueta Citrus Inferno', 'Molho picante com toques cítricos para uma experiência explosiva.', 7.75, 0, 65, 1, 'Molhos', false),
  ('Malagueta Aleppo em Conserva', 'Pimentas Aleppo em conserva, ideais para saladas e aperitivos.', 6.25, 0, 90, 1, 'Conservas', false),
  ('Molho de Malagueta Barbecue Picante', 'Molho de malagueta com sabor defumado, perfeito para churrascos.', 10.50, 0, 40, 1, 'Molhos', false),
  ('Malagueta Thai Bird Eye Fresca', 'Malagueta Thai Bird Eye fresca, excelente para pratos tailandeses autênticos.', 13.25, 0, 30, 1, 'Malaguetas Frescas', false),
  ('Molho de Malagueta Harissa', 'Molho de malagueta Harissa para dar um toque picante à culinária do Oriente Médio.', 8.99, 0, 55, 1, 'Molhos', false),
  ('Mix de Pimentas em Conserva', 'Mix de pimentas em conserva para uma explosão de sabores no seu paladar.', 9.75, 0, 50, 1, 'Conservas', false),
  ('Malagueta Lemon Drop Seca', 'Malagueta Lemon Drop seca, conhecida por seu sabor cítrico e ardência intensa.', 12.50, 0, 35, 1, 'Especiarias', false),
  ('Molho de Malagueta Raspberry Inferno', 'Molho de malagueta com toques de framboesa para uma experiência única.', 11.25, 0, 45, 1, 'Molhos', false),
  ('Malagueta Serrano Seca', 'Malagueta Serrano seca para um toque picante e colorido em suas receitas.', 9.75, 0, 50, 1, 'Especiarias', false),
  ('Molho de Malagueta Garlic Lime', 'Molho de malagueta com alho e limão para um sabor refrescante.', 7.99, 0, 70, 1, 'Molhos', false),
  ('Mix de Malaguetas Frescas', 'Mix de malaguetas frescas para explorar diferentes níveis de calor.', 14.50, 0, 30, 1, 'Malaguetas Frescas', false),
  ('Molho de Malagueta Orange Habanero', 'Molho de malagueta com a doçura da laranja e o calor da pimenta Habanero.', 8.25, 0, 55, 1, 'Molhos', false),
  ('Malagueta Chocolate Habanero Fresca', 'Malagueta Chocolate Habanero fresca, uma variedade rara com sabor único.', 12.99, 0, 25, 1, 'Malaguetas Frescas', false),
  ('Pó de Malagueta Datil', 'Pó de malagueta Datil para um toque de calor com sabor frutado.', 10.99, 0, 40, 1, 'Temperos', false),
  ('Molho de Malagueta Sweet Onion', 'Molho de malagueta com cebola doce para uma combinação irresistível.', 9.25, 0, 35, 1, 'Molhos', false),
  ('Picles de Malagueta Thai Bird Eye', 'Picles de malagueta Thai Bird Eye para um sabor picante e exótico.', 6.50, 0, 80, 1, 'Conservas', false),
  ('Molho de Malagueta Green Serenade', 'Molho de malagueta verde com notas refrescantes, uma serenata de sabores.', 11.75, 0, 45, 1, 'Molhos', false),
  ('Sementes de Malagueta Fatalii', 'Sementes de malagueta Fatalii para os aventureiros em busca de pimenta intensa.', 7.75, 0, 60, 1, 'Sementes', false),
  ('Malagueta Lemon Drop Seca', 'Malagueta Lemon Drop seca, conhecida por seu sabor cítrico e ardência intensa.', 12.50, 0, 35, 1, 'Especiarias', false),
  ('Molho de Malagueta Mango Inferno', 'Molho de malagueta com manga para um toque doce antes do calor intenso.', 8.99, 0, 50, 1, 'Molhos', false),
  ('Pó de Malagueta Aji Amarillo', 'Pó de malagueta Aji Amarillo para um sabor autêntico peruano.', 9.75, 0, 45, 1, 'Temperos', false),
  ('Malagueta Scotch Bonnet Fresca', 'Malagueta Scotch Bonnet fresca, ideal para pratos caribenhos autênticos.', 14.25, 0, 30, 1, 'Malaguetas Frescas', false),
  ('Molho de Malagueta Blueberry Heat', 'Molho de malagueta com o toque frutado das amoras azuis.', 11.99, 0, 25, 1, 'Molhos', false),
  ('Molho de Malagueta Habanero Extra Forte', 'Molho picante feito com malaguetas Habanero para os amantes de pimenta.', 7.99, 0, 40, 1, 'Molhos', false),
  ('Sementes de Malagueta Jalapeño', 'Sementes de malagueta Jalapeño para cultivar em seu jardim ou horta.', 4.50, 0, 100, 1, 'Sementes', false),
  ('Malagueta Ghost Pepper Seca', 'Malagueta seca da variedade Ghost Pepper, conhecida por sua extrema pungência.', 10.99, 0, 30, 1, 'Especiarias', false),
  ('Picles de Malagueta Agridoce', 'Picles de malagueta agridoce, uma deliciosa opção para aperitivos.', 6.25, 0, 50, 1, 'Conservas', false),
  ('Molho de Malagueta Chipotle Defumado', 'Molho defumado com malaguetas Chipotle para um sabor único.', 8.75, 0, 35, 1, 'Molhos', false),
  ('Malagueta Trinidad Scorpion Fresca', 'Experimente a potência da malagueta Trinidad Scorpion em sua forma fresca.', 12.99, 0, 25, 1, 'Malaguetas Frescas', false),
  ('Tempero de Malagueta Cajun', 'Tempero Cajun com o toque picante da malagueta, ideal para pratos saborosos.', 5.75, 0, 60, 1, 'Temperos', false),
  ('Pó de Malagueta Red Savina', 'Pó de malagueta Red Savina, um toque de calor intenso para suas receitas.', 9.50, 0, 45, 1, 'Temperos', false),
  ('Molho de Malagueta Szechuan', 'Molho de malagueta Szechuan para adicionar um sabor asiático aos seus pratos.', 7.25, 0, 55, 1, 'Molhos', false),
  ('Conjunto de Malaguetas Ornamentais Variadas', 'Decore seu espaço com este conjunto de malaguetas ornamentais em diferentes cores.', 15.50, 0, 20, 1, 'Decoração', false),
  ('Pimenta Habanero em Conserva', 'Pimentas Habanero em conserva, perfeitas para dar um toque picante aos seus sanduíches.', 6.99, 0, 70, 1, 'Conservas', false),
  ('Molho de Malagueta Thai Sweet Chili', 'Molho agridoce de malagueta Thai Sweet Chili para uma explosão de sabores.', 8.50, 0, 40, 1, 'Molhos', false),
  ('Kit de Cultivo Indoor de Malaguetas', 'Crie sua plantação de malaguetas em casa com este kit para cultivo indoor.', 18.99, 0, 15, 1, 'Plantas', false),
  ('Malagueta Aleppo Seca', 'Malagueta Aleppo seca, com um toque frutado, perfeita para pratos mediterrâneos.', 11.75, 0, 30, 1, 'Especiarias', false),
  ('Molho de Malagueta Mango Habanero', 'Molho de malagueta com a doçura da manga e o calor da Habanero.', 9.25, 0, 50, 1, 'Molhos', false),
  ('Sementes de Malagueta Scotch Bonnet', 'Sementes de malagueta Scotch Bonnet para cultivar em seu próprio jardim.', 5.99, 0, 80, 1, 'Sementes', false),
  ('Malagueta Cherry Bomb Fresca', 'Malagueta Cherry Bomb fresca, uma opção suave para quem aprecia um toque de pimenta.', 14.99, 0, 25, 1, 'Malaguetas Frescas', false),
  ('Molho de Malagueta Citrus Inferno', 'Molho picante com toques cítricos para uma experiência explosiva.', 7.75, 0, 65, 1, 'Molhos', false),
  ('Malagueta Aleppo em Conserva', 'Pimentas Aleppo em conserva, ideais para saladas e aperitivos.', 6.25, 0, 90, 1, 'Conservas', false),
  ('Molho de Malagueta Barbecue Picante', 'Molho de malagueta com sabor defumado, perfeito para churrascos.', 10.50, 0, 40, 1, 'Molhos', false),
  ('Malagueta Thai Bird Eye Fresca', 'Malagueta Thai Bird Eye fresca, excelente para pratos tailandeses autênticos.', 13.25, 0, 30, 1, 'Malaguetas Frescas', false),
  ('Molho de Malagueta Harissa', 'Molho de malagueta Harissa para dar um toque picante à culinária do Oriente Médio.', 8.99, 0, 55, 1, 'Molhos', false),
  ('Mix de Pimentas em Conserva', 'Mix de pimentas em conserva para uma explosão de sabores no seu paladar.', 9.75, 0, 50, 1, 'Conservas', false),
  ('Malagueta Lemon Drop Seca', 'Malagueta Lemon Drop seca, conhecida por seu sabor cítrico e ardência intensa.', 12.50, 0, 35, 1, 'Especiarias', false),
  ('Molho de Malagueta Raspberry Inferno', 'Molho de malagueta com toques de framboesa para uma experiência única.', 11.25, 0, 45, 1, 'Molhos', false),
  ('Malagueta Serrano Seca', 'Malagueta Serrano seca para um toque picante e colorido em suas receitas.', 9.75, 0, 50, 1, 'Especiarias', false),
  ('Molho de Malagueta Garlic Lime', 'Molho de malagueta com alho e limão para um sabor refrescante.', 7.99, 0, 70, 1, 'Molhos', false),
  ('Mix de Malaguetas Frescas', 'Mix de malaguetas frescas para explorar diferentes níveis de calor.', 14.50, 0, 30, 1, 'Malaguetas Frescas', false),
  ('Molho de Malagueta Orange Habanero', 'Molho de malagueta com a doçura da laranja e o calor da pimenta Habanero.', 8.25, 0, 55, 1, 'Molhos', false),
  ('Malagueta Chocolate Habanero Fresca', 'Malagueta Chocolate Habanero fresca, uma variedade rara com sabor único.', 12.99, 0, 25, 1, 'Malaguetas Frescas', false),
  ('Pó de Malagueta Datil', 'Pó de malagueta Datil para um toque de calor com sabor frutado.', 10.99, 0, 40, 1, 'Temperos', false),
  ('Molho de Malagueta Sweet Onion', 'Molho de malagueta com cebola doce para uma combinação irresistível.', 9.25, 0, 35, 1, 'Molhos', false),
  ('Picles de Malagueta Thai Bird Eye', 'Picles de malagueta Thai Bird Eye para um sabor picante e exótico.', 6.50, 0, 80, 1, 'Conservas', false),
  ('Molho de Malagueta Green Serenade', 'Molho de malagueta verde com notas refrescantes, uma serenata de sabores.', 11.75, 0, 45, 1, 'Molhos', false),
  ('Sementes de Malagueta Fatalii', 'Sementes de malagueta Fatalii para os aventureiros em busca de pimenta intensa.', 7.75, 0, 60, 1, 'Sementes', false),
  ('Malagueta Lemon Drop Seca', 'Malagueta Lemon Drop seca, conhecida por seu sabor cítrico e ardência intensa.', 12.50, 0, 35, 1, 'Especiarias', false),
  ('Molho de Malagueta Mango Inferno', 'Molho de malagueta com manga para um toque doce antes do calor intenso.', 8.99, 0, 50, 1, 'Molhos', false),
  ('Pó de Malagueta Aji Amarillo', 'Pó de malagueta Aji Amarillo para um sabor autêntico peruano.', 9.75, 0, 45, 1, 'Temperos', false),
  ('Malagueta Scotch Bonnet Fresca', 'Malagueta Scotch Bonnet fresca, ideal para pratos caribenhos autênticos.', 14.25, 0, 30, 1, 'Malaguetas Frescas', false),
  ('Molho de Malagueta Blueberry Heat', 'Molho de malagueta com o toque frutado das amoras azuis.', 11.99, 0, 25, 1, 'Molhos', false);
  
INSERT INTO Compra (timestamp, total, descricao, id_utilizador, estado, id_administrador) VALUES
  (CURRENT_TIMESTAMP, 50.99, 'Compra de molhos picantes', 1, 'Concluído', 1),
  (CURRENT_TIMESTAMP, 30.25, 'Compra de sementes de malagueta', 1, 'Em andamento', 1),
  (CURRENT_TIMESTAMP, 75.50, 'Compra de picles de malagueta', 1, 'Pendente', 1),
  (CURRENT_TIMESTAMP, 20.99, 'Compra de malaguetas frescas', 1, 'Concluído', 1),
  (CURRENT_TIMESTAMP, 45.75, 'Compra de molho de pimenta', 1, 'Concluído', 1),
  (CURRENT_TIMESTAMP, 60.50, 'Compra de especiarias', 1, 'Pendente', 1),
  (CURRENT_TIMESTAMP, 15.99, 'Compra de sementes de pimenta', 1, 'Concluído', 1),
  (CURRENT_TIMESTAMP, 35.25, 'Compra de molho de pimenta doce', 1, 'Em andamento', 1),
  (CURRENT_TIMESTAMP, 28.75, 'Compra de conservas picantes', 1, 'Pendente', 1),
  (CURRENT_TIMESTAMP, 10.50, 'Compra de malaguetas em conserva', 1, 'Concluído', 1),
  (CURRENT_TIMESTAMP, 42.99, 'Compra de temperos exóticos', 1, 'Em andamento', 1),
  (CURRENT_TIMESTAMP, 18.50, 'Compra de molho de pimenta tailandês', 1, 'Pendente', 1),
  (CURRENT_TIMESTAMP, 55.75, 'Compra de pó de malagueta', 1, 'Concluído', 1),
  (CURRENT_TIMESTAMP, 22.25, 'Compra de molho de pimenta defumado', 1, 'Pendente', 1),
  (CURRENT_TIMESTAMP, 38.99, 'Compra de picles de pimenta', 1, 'Concluído', 1),
  (CURRENT_TIMESTAMP, 48.75, 'Compra de malaguetas secas', 1, 'Em andamento', 1),
  (CURRENT_TIMESTAMP, 25.99, 'Compra de molho de pimenta agridoce', 1, 'Concluído', 1),
  (CURRENT_TIMESTAMP, 30.50, 'Compra de malaguetas em conserva', 1, 'Pendente', 1),
  (CURRENT_TIMESTAMP, 12.25, 'Compra de sementes de malagueta habanero', 1, 'Concluído', 1),
  (CURRENT_TIMESTAMP, 36.99, 'Compra de molho de pimenta cítrico', 1, 'Em andamento', 1),
  (CURRENT_TIMESTAMP, 19.75, 'Compra de picles de pimenta doce', 1, 'Pendente', 1),
  (CURRENT_TIMESTAMP, 26.50, 'Compra de molho de pimenta picante', 1, 'Concluído', 1),
  (CURRENT_TIMESTAMP, 8.99, 'Compra de malagueta fresca', 1, 'Concluído', 1),
  (CURRENT_TIMESTAMP, 33.75, 'Compra de molho de pimenta defumado', 1, 'Pendente', 1),
  (CURRENT_TIMESTAMP, 15.50, 'Compra de pó de malagueta', 1, 'Em andamento', 1),
  (CURRENT_TIMESTAMP, 23.99, 'Compra de malagueta em conserva', 1, 'Concluído', 1),
  (CURRENT_TIMESTAMP, 40.25, 'Compra de molho de pimenta agridoce', 1, 'Pendente', 1),
  (CURRENT_TIMESTAMP, 14.75, 'Compra de picles de pimenta picante', 1, 'Em andamento', 1),
  (CURRENT_TIMESTAMP, 29.50, 'Compra de sementes de malagueta jalapeño', 1, 'Concluído', 1),
  (CURRENT_TIMESTAMP, 17.25, 'Compra de molho de pimenta tailandês', 1, 'Pendente', 1);

INSERT INTO Comentario (timestamp, texto, avaliacao, id_utilizador, id_produto) VALUES
  (CURRENT_TIMESTAMP, 'Ótimo produto! Muito picante, exatamente como eu gosto.', 5, 1, 1),
  (CURRENT_TIMESTAMP, 'Adorei o molho de pimenta, excelente sabor!', 4, 1, 2),
  (CURRENT_TIMESTAMP, 'As sementes de malagueta cresceram rápido, estou muito satisfeito.', 5, 1, 3),
  (CURRENT_TIMESTAMP, 'Produto de qualidade, chegou em perfeito estado.', 4, 1, 4),
  (CURRENT_TIMESTAMP, 'Molho de tomate picante é uma ótima adição às minhas receitas.', 3, 1, 5),
  (CURRENT_TIMESTAMP, 'Picles de malagueta são deliciosos, recomendo!', 5, 1, 6),
  (CURRENT_TIMESTAMP, 'Molho de piri-piri é perfeito para pratos mais leves.', 4, 1, 7),
  (CURRENT_TIMESTAMP, 'Excelente produto, o mix de malaguetas frescas é incrível.', 5, 1, 8),
  (CURRENT_TIMESTAMP, 'Malagueta em conserva é um ótimo acompanhamento para lanches.', 4, 1, 9),
  (CURRENT_TIMESTAMP, 'Sabor intenso! Molho de malagueta com alho e limão é incrível.', 5, 1, 10),
  (CURRENT_TIMESTAMP, 'Malagueta scotch bonnet fresca é muito aromática, adorei!', 5, 1, 11),
  (CURRENT_TIMESTAMP, 'Molho de malagueta com manga é uma explosão de sabores.', 4, 1, 12),
  (CURRENT_TIMESTAMP, 'Pó de malagueta datil é perfeito para pratos mais apimentados.', 5, 1, 13),
  (CURRENT_TIMESTAMP, 'Molho de malagueta sweet onion é delicioso, equilibra bem o doce e o picante.', 4, 1, 14),
  (CURRENT_TIMESTAMP, 'Picles de malagueta thai bird eye são picantes e viciantes.', 5, 1, 15);

-- Avaliação 1
INSERT INTO Comentario (timestamp, texto, avaliacao, id_utilizador, id_produto) VALUES
  (CURRENT_TIMESTAMP, 'Produto não atendeu às expectativas, muito decepcionado.', 1, 1, 16),
  (CURRENT_TIMESTAMP, 'Não gostei do sabor, não recomendaria.', 1, 1, 17),
  (CURRENT_TIMESTAMP, 'Sementes de malagueta não germinaram corretamente.', 1, 1, 18),
  (CURRENT_TIMESTAMP, 'Produto danificado durante o transporte.', 1, 1, 19),
  (CURRENT_TIMESTAMP, 'Molho de pimenta muito fraco, sem sabor.', 1, 1, 20);

-- Avaliação 2
INSERT INTO Comentario (timestamp, texto, avaliacao, id_utilizador, id_produto) VALUES
  (CURRENT_TIMESTAMP, 'Aceitável, mas esperava mais.', 2, 1, 21),
  (CURRENT_TIMESTAMP, 'Não é ruim, mas definitivamente não é ótimo.', 2, 1, 22),
  (CURRENT_TIMESTAMP, 'Sabor mediano, não compraria novamente.', 2, 1, 23),
  (CURRENT_TIMESTAMP, 'Produto com qualidade inferior ao esperado.', 2, 1, 24),
  (CURRENT_TIMESTAMP, 'Molho de pimenta de média intensidade.', 2, 1, 25);

-- Avaliação 3
INSERT INTO Comentario (timestamp, texto, avaliacao, id_utilizador, id_produto) VALUES
  (CURRENT_TIMESTAMP, 'Produto decente, atendeu parcialmente às expectativas.', 3, 1, 26),
  (CURRENT_TIMESTAMP, 'Gosto aceitável, mas não excepcional.', 3, 1, 27),
  (CURRENT_TIMESTAMP, 'Sabor razoável, consideraria outras opções.', 3, 1, 28),
  (CURRENT_TIMESTAMP, 'Produto dentro da média, sem grande destaque.', 3, 1, 29),
  (CURRENT_TIMESTAMP, 'Molho de pimenta com calor moderado.', 3, 1, 30);

-- Avaliação 4
INSERT INTO Comentario (timestamp, texto, avaliacao, id_utilizador, id_produto) VALUES
  (CURRENT_TIMESTAMP, 'Bom produto, sabor agradável.', 4, 1, 31),
  (CURRENT_TIMESTAMP, 'Gostei bastante, compraria novamente.', 4, 1, 32),
  (CURRENT_TIMESTAMP, 'Sabor acima da média, recomendo.', 4, 1, 33),
  (CURRENT_TIMESTAMP, 'Produto de qualidade, superou as expectativas.', 4, 1, 34),
  (CURRENT_TIMESTAMP, 'Molho de pimenta com bom equilíbrio de sabores.', 4, 1, 35);

-- Avaliação 5
INSERT INTO Comentario (timestamp, texto, avaliacao, id_utilizador, id_produto) VALUES
  (CURRENT_TIMESTAMP, 'Produto incrível, superou todas as expectativas!', 5, 1, 36),
  (CURRENT_TIMESTAMP, 'Sabor extraordinário, definitivamente recomendaria.', 5, 1, 37),
  (CURRENT_TIMESTAMP, 'O melhor que já experimentei, vale cada centavo.', 5, 1, 38),
  (CURRENT_TIMESTAMP, 'Produto de alta qualidade, não tenho do que reclamar.', 5, 1, 39),
  (CURRENT_TIMESTAMP, 'Molho de pimenta extremamente picante e delicioso.', 5, 1, 40);

INSERT INTO ProdutoWishlist (id_utilizador, id_produto) VALUES
  (1, 5),
  (1, 7);

INSERT INTO Faqs (pergunta, resposta, id_administrador) VALUES
  ('Qual é o prazo de entrega dos produtos?', 
   'O prazo de entrega dos nossos produtos é de 3 a 5 dias úteis após a confirmação do pagamento. Este período pode variar consoante a sua localização, mas fazemos o nosso melhor para garantir que os produtos cheguem até si o mais rápido possível.', 
   1),
  ('Como posso devolver um produto?', 
   'Para devolver um produto, por favor, entre em contacto com o nosso serviço de apoio ao cliente dentro de 30 dias após a compra. Iremos fornecer-lhe as instruções necessárias e, após a verificação do estado do produto, procederemos ao reembolso ou ofereceremos uma alternativa adequada.', 
   1),
  ('Posso cancelar uma encomenda após a compra?', 
   'Infelizmente, não podemos cancelar uma encomenda após a compra, uma vez que processamos os pedidos rapidamente para garantir a entrega o mais breve possível. Certifique-se de revisar cuidadosamente os itens no seu carrinho antes de finalizar a compra.', 
   1),
  ('Como faço para registar uma conta?', 
   'Para registar uma conta, visite o nosso site e clique no botão "Registar" no canto superior direito. Preencha os campos necessários com as suas informações pessoais e siga as instruções para criar a sua conta. Uma vez registado, poderá desfrutar de benefícios exclusivos e acompanhar o histórico das suas compras.', 
   1),
  ('É seguro comprar no site da RedHot?', 
   'Sim, é seguro comprar no site da RedHot. Implementamos medidas rigorosas de segurança para proteger as suas informações pessoais e transações. Utilizamos métodos de pagamento seguros e garantimos que os seus dados são tratados com a máxima confidencialidade. Pode comprar connosco com total confiança.', 
   1),
  ('O que devo fazer se esquecer a minha palavra-passe?', 
   'Se esquecer a sua palavra-passe, vá até à página de login e clique em "Esqueceu a palavra-passe?". Siga as instruções para redefinir a sua palavra-passe. Se precisar de assistência adicional, entre em contacto com o nosso serviço de apoio ao cliente.', 
   1),
  ('Como posso contactar o serviço de apoio ao cliente?', 
   'Pode entrar em contacto com o nosso serviço de apoio ao cliente enviando um e-mail para ajuda@redhot.pt. Estamos disponíveis para responder às suas perguntas, fornecer assistência personalizada e resolver quaisquer problemas que possa ter. Estamos aqui para ajudar!', 
   1),
  ('Posso adicionar vários produtos ao meu carrinho?', 
   'Sim, pode adicionar vários produtos ao seu carrinho antes de finalizar a compra. Nós encorajamos a explorar a variedade de produtos que oferecemos e a adicionar todos os itens desejados ao seu carrinho. Certifique-se de rever os itens no seu carrinho antes de concluir a compra para garantir que tem tudo o que precisa.', 
   1),
  ('Qual é a política de privacidade da RedHot?', 
   'A nossa política de privacidade detalha como recolhemos, utilizamos e divulgamos as suas informações pessoais. Para obter informações detalhadas, consulte a secção de Políticas de Privacidade no nosso site. Estamos empenhados em proteger a sua privacidade e garantir que as suas informações são tratadas com a máxima confidencialidade.', 
   1),
  ('Como posso seguir o estado da minha encomenda?', 
   'Pode seguir o estado da sua encomenda iniciando sessão na sua conta e acedendo à secção "Histórico de Encomendas". Lá encontrará informações atualizadas sobre o estado da sua encomenda, incluindo o número de rastreamento, se aplicável. Estamos sempre disponíveis para fornecer informações adicionais, se necessário.', 
   1);