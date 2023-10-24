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




