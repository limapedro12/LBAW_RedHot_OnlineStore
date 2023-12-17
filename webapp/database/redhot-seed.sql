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
DROP TABLE IF EXISTS Faqs CASCADE;
DROP TABLE IF EXISTS Visits CASCADE;

CREATE TABLE Utilizador (
	id SERIAL PRIMARY KEY,
  nome VARCHAR(256),
  email VARCHAR(256) UNIQUE,
	password VARCHAR(256),
  telefone VARCHAR(256),
  morada VARCHAR(256),
  codigo_postal VARCHAR(256),
  localidade VARCHAR(256),
  remember_token VARCHAR(256),
  profile_image VARCHAR(1024),
  banned BOOLEAN DEFAULT FALSE,
  became_admin BOOLEAN DEFAULT FALSE,
  deleted BOOLEAN DEFAULT FALSE
);

CREATE TABLE Administrador (
  id SERIAL PRIMARY KEY,
  nome VARCHAR(256) NOT NULL,
  email VARCHAR(256) UNIQUE NOT NULL,
  password VARCHAR(256) NOT NULL,
  remember_token VARCHAR(256),
  profile_image VARCHAR(1024)
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
  destaque BOOLEAN DEFAULT FALSE,
  deleted BOOLEAN DEFAULT FALSE
);

CREATE TABLE Comentario (
	id SERIAL PRIMARY KEY,
  timestamp TIMESTAMP NOT NULL CHECK (timestamp <= now()),
  texto TEXT NOT NULL,
  avaliacao INTEGER NOT NULL CHECK (avaliacao >= 1 AND avaliacao <= 5),
  id_utilizador INTEGER NOT NULL REFERENCES Utilizador (id) ON UPDATE CASCADE,
  id_produto INTEGER NOT NULL REFERENCES Produto (id) ON UPDATE CASCADE ON DELETE CASCADE
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

CREATE TABLE ProdutoCarrinho (
	id SERIAL PRIMARY KEY,
  id_produto INTEGER REFERENCES Produto (id) ON UPDATE CASCADE,
	id_utilizador INTEGER REFERENCES Utilizador (id) ON UPDATE CASCADE,
  quantidade INTEGER NOT NULL CHECK (quantidade > 0),
  timestamp TIMESTAMP NOT NULL DEFAULT now() CHECK (timestamp <= now()),
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

CREATE TABLE Visits (
  id SERIAL PRIMARY KEY,
  ip_address VARCHAR(256) NOT NULL,
  timestamp TIMESTAMP NOT NULL CHECK (timestamp <= now())
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

INSERT INTO Utilizador (nome, email, password) VALUES ('Utilizador','user@users.com','$2y$10$Rs590ufQ2U3ies52lz1R0.KNlZaOIaVoPGJqKqbYBG5ZLaCwDVZ3.'); -- password: 12345678

INSERT INTO Administrador (nome, email, password) VALUES ('admin', 'admin@admin.pt', '$2y$10$R6IeqCxQxMConGFO3OHuq.Um2vxTYB9NKikC6Hky8cmUCln6jl5k6'); -- password: 12345678

INSERT INTO Visits (ip_address, timestamp) VALUES 
('192.168.1.2', '2021-05-01 00:00:00'),
('192.168.1.3', '2023-12-16 00:00:00');

INSERT INTO Produto (nome, descricao, precoAtual, desconto, stock, id_administrador, product_image, categoria, destaque) VALUES
('Sacana Piri-Piri Extra Picante', 'O piri-piri atinge um novo nível de intensidade neste molho extra picante. Apenas para os corajosos que buscam o máximo de calor.', 10.49, 0.08, 45, 1, 'sources/products/molhos/sacana-piri-piri-extra-picante.png', 'Molhos', false),
('Molho Picante Chiplote Piri-Piri & Co', 'Descubra o equilíbrio perfeito entre o fumado do chipotle e o calor do piri-piri. Um molho irresistível para os apreciadores de sabores intensos.', 7.79, 0, 60, 1, 'sources/products/molhos/molho-chiplote-piri-piri.png', 'Molhos', false),
('Peluche Furrybones Chilito Chili Pepper', 'Abraçe a fofura picante com o peluche Furrybones Chilito Chili Pepper. Uma adição encantadora à sua coleção de peluches.', 12.49, 0.1, 30, 1, 'sources/products/misc/peluche-furrybones-chilito.png', 'Misc', TRUE),
('Estatua de Malaguetas Levantadas', 'Adorne o seu espaço com esta estatueta de malaguetas levantadas. Uma representação vibrante e expressiva do calor que a malagueta traz.', 19.99, 0.15, 15, 1, 'sources/products/misc/estatua-malaguetas-levantadas.png', 'Misc', FALSE),
('Chili Oil with Crispy Garlic (Haute)', 'O Chili Oil with Crispy Garlic da Haute é a combinação perfeita de calor e textura crocante. Transforme suas receitas com esse óleo saboroso.', 12.49, 0.2, 15, 1, 'sources/products/oleo/chili-oil-with-crispy-garlic-haute.png', 'Óleo', FALSE),
('Peluche Malagueta', 'Deixe-se envolver pelo calor reconfortante deste peluche malagueta. Uma companhia perfeita para os amantes do picante.', 8.99, 0.05, 50, 1, 'sources/products/misc/peluche-malagueta.png', 'Misc', FALSE),
('Sementes de Carolina Reaper', 'Desafie-se a cultivar a malagueta mais picante do mundo com as sementes de Carolina Reaper. Uma jornada ardente espera por você.', 2.99, 0.05, 60, 1, 'sources/products/sementes/sementes-carolina-reaper.png', 'Sementes', FALSE),
('Estatua de Malagueta', 'Enriqueça a sua decoração com esta estatueta elegante de malagueta. Uma peça de arte única para os apreciadores do picante.', 16.79, 0.12, 20, 1, 'sources/products/misc/estatua-malagueta.png', 'Misc', FALSE),
('Vaso Maduro de Pimentas', 'Opte por um vaso repleto de pimentas maduras, uma verdadeira obra-prima da natureza. Um presente perfeito para os amantes do picante.', 17.99, 0.2, 15, 1, 'sources/products/vasos/vaso-maduro-pimentas.png', 'Vasos', FALSE),
('Habanero Orange', 'Uma malagueta fresca com sabor cítrico e ardência intensa. Ideal para quem busca um toque exótico e picante em suas receitas.', 2.49, 0.05, 30, 1, 'sources/products/malaguetas-frescas/habanero-orange.png', 'Malaguetas Frescas', FALSE),
('Sementes de Habanero Orange', 'Cultive a sua própria variedade de malagueta com as sementes de Habanero Orange. Desenvolva plantas vibrantes e colha frutos cítricos e picantes.', 1.99, 0.02, 100, 1, 'sources/products/sementes/sementes-habanero-orange.png', 'Sementes', FALSE),
('Stretchy Chilli Peppers Duo', 'Divirta-se com este duo de stretchy chilli peppers. Uma opção descontraída para aliviar o stress enquanto mantém o tema picante.', 5.99, 0.03, 40, 1, 'sources/products/misc/stretchy-chilli-peppers-duo.png', 'Misc', FALSE),
('Tabasco', 'O clássico molho Tabasco, com seu sabor característico e explosivo. Perfeito para dar um toque picante a qualquer prato.', 6.49, 0, 75, 1, 'sources/products/molhos/tabasco.png', 'Molhos', false),
('Sementes de Habanero', 'Cultive Habaneros em casa com estas sementes de alta qualidade. Uma experiência gratificante para os entusiastas do picante e da jardinagem.', 1.79, 0.01, 120, 1, 'sources/products/sementes/sementes-habanero.png', 'Sementes', FALSE),
('Sementes de Jalapeño', 'Comece a sua plantação de malaguetas Jalapeño com estas sementes de alta qualidade. Desfrute do processo de crescimento e colha recompensas picantes.', 1.29, 0, 200, 1, 'sources/products/sementes/sementes-jalapeno.png', 'Sementes', FALSE),
('Kuduro Fire Piri-Piri Gindungo', 'A receita exclusiva de RicFazeres combina o sabor do piri-piri com a intensidade do gindungo. Um molho picante inspirado na cultura angolana.', 11.89, 0, 55, 1, 'sources/products/molhos/kuduro-fire-piri-piri-gindungo.png', 'Molhos', false),
('Mega Extra Hot Sardines', 'Experimente as sardinhas extra picantes, uma explosão de sabor e calor em cada mordida. Ideal para os apreciadores de snacks intensos.', 3.79, 0.1, 40, 1, 'sources/products/snacks/mega-extra-hot-sardines.png', 'Snacks', TRUE),
('One Chip Challenge', 'Aceite o desafio da One Chip, a batata chip mais picante do mundo. Um lanche extremamente ardente para os corajosos amantes de picância.', 4.99, 0.15, 50, 1, 'sources/products/snacks/one-chip-challenge.png', 'Snacks', FALSE),
('I Am Super Spicy', 'Uma explosão de especiarias neste molho maionese super picante. Transforme suas refeições com este toque de intensidade.', 8.99, 0.1, 40, 1, 'sources/products/molhos/i-am-super-spicy.png', 'Molhos', false),
('Habanero Chocolate', 'Experimente o calor sofisticado do Habanero Chocolate. Uma malagueta fresca com notas de cacau que elevam o seu paladar a um novo patamar.', 2.79, 0.08, 25, 1, 'sources/products/malaguetas-frescas/habanero-chocolate.png', 'Malaguetas Frescas', FALSE),
('Jalapeño', 'Malagueta fresca Jalapeño, perfeita para adicionar um toque suave de calor a pratos variados. Um clássico versátil na culinária picante.', 1.99, 0.02, 50, 1, 'sources/products/malaguetas-frescas/jalapeno.png', 'Malaguetas Frescas', FALSE),
('Tabasco Sriracha', 'A clássica Sriracha com o toque inconfundível do Tabasco. Um molho que eleva o sabor dos pratos, proporcionando uma experiência única.', 9.29, 0.6, 50, 1, 'sources/products/molhos/tabasco-sriracha.png', 'Molhos', false),
('Ghost Pepper', 'Uma malagueta fresca com o calor assombrante da Ghost Pepper. Adicione um toque misterioso e ardente às suas criações culinárias.', 3.29, 0.06, 30, 1, 'sources/products/malaguetas-frescas/ghost-pepper.png', 'Malaguetas Frescas', FALSE),
('Crispy Chili Oil (Laoganma)', 'Eleve seus pratos com o Crispy Chili Oil da Laoganma. Uma mistura irresistível de óleo e especiarias para dar um toque crocante e picante.', 8.99, 0.15, 20, 1, 'sources/products/oleo/crispy-chili-oil-laoganma.png', 'Óleo', FALSE),
('Takis Fuego', 'Os Takis Fuego, um snack crocante e picante que conquistou os amantes de snacks ao redor do mundo. A explosão de sabor que você procura.', 2.99, 0.05, 60, 1, 'sources/products/snacks/takis-fuego.png', 'Snacks', FALSE),
('Malagueta', 'A malagueta fresca tradicional, um ingrediente indispensável para quem aprecia a culinária picante. Adicione intensidade aos seus pratos.', 1.79, 0.01, 60, 1, 'sources/products/malaguetas-frescas/malagueta.png', 'Malaguetas Frescas', FALSE),
('Vaso de Malaguetas', 'Decore o seu espaço com um vaso exuberante de malaguetas. Uma mistura de cor e sabor que transforma o ambiente.', 12.99, 0.1, 25, 1, 'sources/products/vasos/vaso-malaguetas.png', 'Vasos', FALSE),
('Samyang Spicy Chicken Noodles', 'As famosas noodles de frango picantes Samyang. Um prato instantâneo que combina sabor delicioso com o calor irresistível.', 5.49, 0.08, 30, 1, 'sources/products/snacks/samyang-spicy-chicken-noodles.png', 'Snacks', FALSE),
('Vaso Natural de Pimentas', 'Adicione um toque rústico à sua decoração com este vaso natural de pimentas. Uma combinação de beleza e picância para encantar os seus sentidos.', 14.99, 0.15, 20, 1, 'sources/products/vasos/vaso-natural-pimentas.png', 'Vasos', FALSE),
('Sacana Piri-Piri Com Cannabis', 'Uma experiência única com o piri-piri potenciado pelos sabores da cannabis. Um molho provocador para os aventureiros gastronómicos.', 12.99, 0.15, 30, 1, 'sources/products/molhos/sacana-piri-piri-cannabis.png', 'Molhos', true),
('Spicy Chili Dark Chocolate', 'Desfrute da combinação única de chocolate escuro e pimenta da Lindt. O Spicy Chili Dark Chocolate oferece um toque picante agridoce irresistível.', 6.99, 0.12, 25, 1, 'sources/products/snacks/spicy-chili-dark-chocolate.png', 'Snacks', FALSE),
('Gochujang Chili Paste', 'A Gochujang Chili Paste é uma pasta fermentada que proporciona um sabor único e picante. Experimente na culinária asiática para um toque autêntico.', 7.99, 0.08, 30, 1, 'sources/products/pastas/gochujang-chili-paste.png', 'Pasta', FALSE),
('Pickles Jalapeño', 'Desfrute da suculência e do toque picante dos pickles de Jalapeño. Um acompanhamento perfeito para dar um kick aos seus pratos favoritos.', 4.29, 0.07, 35, 1, 'sources/products/conservas/pickles-jalapeno.png', 'Conservas', FALSE),
('Sementes de Scotch Bonnet', 'Cultive as sementes de Scotch Bonnet para uma colheita de malaguetas caribenhas. Transforme o seu jardim numa fonte de calor tropical.', 2.19, 0.04, 75, 1, 'sources/products/sementes/sementes-scotch-bonnet.png', 'Sementes', FALSE),
('Concerva de Pimenta Habanero', 'Descubra a intensidade da concerva de pimenta Habanero. Uma explosão de calor e sabor que transforma até os pratos mais simples.', 5.49, 0.1, 30, 1, 'sources/products/conservas/concerva-pimenta-habanero.png', 'Conservas', FALSE),
('Scotch Bonnet', 'Experimente o sabor único da Scotch Bonnet, uma malagueta fresca com origens caribenhas. Uma explosão de calor tropical em cada mordida.', 2.69, 0.04, 35, 1, 'sources/products/malaguetas-frescas/scotch-bonnet.png', 'Malaguetas Frescas', FALSE),
('Da Bomb - Beyond Insanity', 'Prepare-se para uma explosão de calor com este molho além da insanidade. Uma experiência picante para os verdadeiros amantes do ardente.', 14.99, 0.12, 25, 1, 'sources/products/molhos/da-bomb-beyond-insanity.png', 'Molhos', true),
('Habanero Chilli Code 10', 'Um molho ardente que desafia os limites do picante. Ideal para os amantes de sabores intensos e emocionantes.', 9.99, 0.05, 50, 1, 'sources/products/molhos/habanero-chilli-code-10.png', 'Molhos', false),
('Concerva de Pimenta Malagueta', 'A conserva de pimenta malagueta é um tesouro ardente em cada frasco. Um complemento saboroso para elevar o nível de picância nas suas refeições.', 3.89, 0.05, 40, 1, 'sources/products/conservas/concerva-pimenta-malagueta.png', 'Conservas', FALSE),
('Malaguetas Moidas (Deluxe)', 'As Malaguetas Moídas Deluxe são a escolha perfeita para quem busca praticidade e sabor intenso. Adicione o calor desejado a qualquer prato.', 6.79, 0.1, 25, 1, 'sources/products/pastas/malaguetas-moidas-deluxe.png', 'Pasta', FALSE),
('Trinidad Scorpion', 'Explore o calor feroz da Trinidad Scorpion, uma malagueta fresca que desafia os limites do picante. Aventure-se nesta experiência intensa.', 3.49, 0.07, 20, 1, 'sources/products/malaguetas-frescas/trinidad-scorpion.png', 'Malaguetas Frescas', FALSE),
('Sementes de Habanero Chocolate', 'Inicie a sua plantação com as sementes de Habanero Chocolate. Desfrute do desafio de cultivar malaguetas de sabor intenso e coloração única.', 2.29, 0.03, 80, 1, 'sources/products/sementes/sementes-habanero-chocolate.png', 'Sementes', FALSE),
('Sementes de Red Cherry', 'As sementes de Red Cherry são perfeitas para quem busca malaguetas pequenas e vibrantes. Cultive-as e adicione cor e sabor aos seus pratos.', 1.49, 0, 150, 1, 'sources/products/sementes/sementes-red-cherry.png', 'Sementes', FALSE),
('Carolina Reaper', 'A malagueta fresca Carolina Reaper, atual detentora do título de mais picante do mundo. Apenas para os corajosos que buscam o extremo.', 3.99, 0.1, 15, 1, 'sources/products/malaguetas-frescas/carolina-reaper.png', 'Malaguetas Frescas', FALSE),
('Habanero', 'A clássica malagueta Habanero, conhecida por seu calor intenso e sabor frutado. Uma escolha ousada para os amantes de picância.', 2.29, 0.03, 40, 1, 'sources/products/malaguetas-frescas/habanero.png', 'Malaguetas Frescas', FALSE),
('Fato de Malagueta', 'Entre no espírito picante com este fato de malagueta. Perfeito para festas temáticas e eventos que pedem um toque de humor ardente.', 29.99, 0.2, 10, 1, 'sources/products/misc/fato-malagueta.png', 'Misc', FALSE);


INSERT INTO Compra (timestamp, total, descricao, id_utilizador, estado, id_administrador) VALUES
  ('2023-01-09 08:30:00', 50.99, 'Compra de molhos picantes', 1, 'Concluído', 1),
  ('2023-01-14 09:15:00', 30.25, 'Compra de sementes de malagueta', 1, 'Em andamento', 1),
  ('2023-01-14 10:45:00', 75.50, 'Compra de picles de malagueta', 1, 'Pendente', 1),
  ('2023-02-19 12:00:00', 20.99, 'Compra de malaguetas frescas', 1, 'Concluído', 1),
  ('2023-02-19 13:30:00', 45.75, 'Compra de molho de pimenta', 1, 'Concluído', 1),
  ('2023-02-25 14:45:00', 60.50, 'Compra de especiarias', 1, 'Pendente', 1),
  ('2023-02-25 16:00:00', 15.99, 'Compra de sementes de pimenta', 1, 'Concluído', 1),
  ('2023-02-25 17:15:00', 35.25, 'Compra de molho de pimenta doce', 1, 'Em andamento', 1),
  ('2023-02-27 18:30:00', 28.75, 'Compra de conservas picantes', 1, 'Pendente', 1),
  ('2023-02-27 19:45:00', 10.50, 'Compra de malaguetas em conserva', 1, 'Concluído', 1),
  ('2023-04-29 21:00:00', 42.99, 'Compra de temperos exóticos', 1, 'Em andamento', 1),
  ('2023-04-30 22:15:00', 18.50, 'Compra de molho de pimenta tailandês', 1, 'Pendente', 1),
  ('2023-04-30 23:30:00', 55.75, 'Compra de pó de malagueta', 1, 'Concluído', 1),
  ('2023-04-15 00:45:00', 22.25, 'Compra de molho de pimenta defumado', 1, 'Pendente', 1),
  ('2023-05-02 02:00:00', 38.99, 'Compra de picles de pimenta', 1, 'Concluído', 1),
  ('2023-05-02 03:15:00', 48.75, 'Compra de malaguetas secas', 1, 'Em andamento', 1),
  ('2023-05-05 04:30:00', 25.99, 'Compra de molho de pimenta agridoce', 1, 'Concluído', 1),
  ('2023-05-08 05:45:00', 30.50, 'Compra de malaguetas em conserva', 1, 'Pendente', 1),
  ('2023-05-10 07:00:00', 12.25, 'Compra de sementes de malagueta habanero', 1, 'Concluído', 1),
  ('2023-05-10 08:15:00', 36.99, 'Compra de molho de pimenta cítrico', 1, 'Em andamento', 1),
  ('2023-05-10 09:30:00', 19.75, 'Compra de picles de pimenta doce', 1, 'Pendente', 1),
  ('2023-05-15 10:45:00', 26.50, 'Compra de molho de pimenta picante', 1, 'Concluído', 1),
  ('2023-06-15 12:00:00', 8.99, 'Compra de malagueta fresca', 1, 'Concluído', 1),
  ('2023-07-16 13:15:00', 33.75, 'Compra de molho de pimenta defumado', 1, 'Pendente', 1),
  ('2023-07-17 14:30:00', 15.50, 'Compra de pó de malagueta', 1, 'Em andamento', 1),
  ('2023-07-18 15:45:00', 23.99, 'Compra de malagueta em conserva', 1, 'Concluído', 1),
  ('2023-08-18 17:00:00', 40.25, 'Compra de molho de pimenta agridoce', 1, 'Pendente', 1),
  ('2023-10-25 18:15:00', 14.75, 'Compra de picles de pimenta picante', 1, 'Em andamento', 1),
  ('2023-10-25 19:30:00', 29.50, 'Compra de sementes de malagueta jalapeño', 1, 'Concluído', 1),
  ('2023-10-29 20:45:00', 17.25, 'Compra de molho de pimenta tailandês', 1, 'Pendente', 1),
  ('2023-08-10 08:30:00', 65.99, 'Compra de molhos picantes', 1, 'Concluído', 1),
  ('2023-09-10 09:15:00', 40.25, 'Compra de sementes de malagueta', 1, 'Em andamento', 1),
  ('2023-10-10 10:45:00', 85.50, 'Compra de picles de malagueta', 1, 'Pendente', 1),
  ('2023-11-10 12:00:00', 30.99, 'Compra de malaguetas frescas', 1, 'Concluído', 1),
  ('2023-12-10 13:30:00', 55.75, 'Compra de molho de pimenta', 1, 'Concluído', 1),
  ('2023-01-10 14:45:00', 70.50, 'Compra de especiarias', 1, 'Pendente', 1),
  ('2023-02-10 16:00:00', 20.99, 'Compra de sementes de pimenta', 1, 'Concluído', 1),
  ('2023-03-10 17:15:00', 45.25, 'Compra de molho de pimenta doce', 1, 'Em andamento', 1),
  ('2023-04-10 18:30:00', 38.75, 'Compra de conservas picantes', 1, 'Pendente', 1),
  ('2023-05-10 19:45:00', 15.50, 'Compra de malaguetas em conserva', 1, 'Concluído', 1),
  ('2023-06-10 21:00:00', 62.99, 'Compra de temperos exóticos', 1, 'Em andamento', 1),
  ('2023-07-10 22:15:00', 28.50, 'Compra de molho de pimenta tailandês', 1, 'Pendente', 1),
  ('2023-08-10 23:30:00', 65.75, 'Compra de pó de malagueta', 1, 'Concluído', 1),
  ('2023-09-10 00:45:00', 32.25, 'Compra de molho de pimenta defumado', 1, 'Pendente', 1),
  ('2023-10-10 02:00:00', 58.99, 'Compra de picles de pimenta', 1, 'Concluído', 1),
  ('2023-11-10 03:15:00', 68.75, 'Compra de malaguetas secas', 1, 'Em andamento', 1),
  ('2023-12-10 04:30:00', 35.99, 'Compra de molho de pimenta agridoce', 1, 'Concluído', 1),
  ('2023-01-10 05:45:00', 40.50, 'Compra de malaguetas em conserva', 1, 'Pendente', 1),
  ('2023-02-10 07:00:00', 22.25, 'Compra de sementes de malagueta habanero', 1, 'Concluído', 1),
  ('2023-03-10 08:15:00', 46.99, 'Compra de molho de pimenta cítrico', 1, 'Em andamento', 1),
  ('2023-04-10 09:30:00', 29.75, 'Compra de picles de pimenta doce', 1, 'Pendente', 1),
  ('2023-05-10 10:45:00', 36.50, 'Compra de molho de pimenta picante', 1, 'Concluído', 1),
  ('2023-06-10 12:00:00', 18.99, 'Compra de malagueta fresca', 1, 'Concluído', 1),
  ('2023-07-10 13:15:00', 43.75, 'Compra de molho de pimenta defumado', 1, 'Pendente', 1),
  ('2023-08-10 14:30:00', 25.50, 'Compra de pó de malagueta', 1, 'Em andamento', 1),
  ('2023-09-10 15:45:00', 33.99, 'Compra de malagueta em conserva', 1, 'Concluído', 1),
  ('2023-10-10 17:00:00', 50.25, 'Compra de molho de pimenta agridoce', 1, 'Pendente', 1),
  ('2023-11-10 18:15:00', 24.75, 'Compra de picles de pimenta picante', 1, 'Em andamento', 1),
  ('2023-12-10 19:30:00', 39.50, 'Compra de sementes de malagueta jalapeño', 1, 'Concluído', 1),
  ('2023-01-10 20:45:00', 27.25, 'Compra de molho de pimenta tailandês', 1, 'Pendente', 1);

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