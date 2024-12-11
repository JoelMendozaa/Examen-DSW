CREATE TABLE aulas
        (
             id INT NOT NULL AUTO_INCREMENT PRIMARY KEY
            ,nombre VARCHAR(20)
            ,letra CHAR(01)
            ,numero INT UNIQUE
            ,planta INT

            ,ip_alta            VARCHAR(15)
            ,fecha_alta         TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            ,ip_ult_mod         VARCHAR(15)
            ,fecha_ult_mod      TIMESTAMP DEFAULT CURRENT_TIMESTAMP
      );



INSERT INTO aulas (nombre, letra, numero, planta) VALUES ('1DAW', 'D', 1, 2);
INSERT INTO aulas (nombre, letra, numero, planta) VALUES ('2DAW', 'D', 2, 2);
INSERT INTO aulas (nombre, letra, numero, planta) VALUES ('Ateka', 'D', 3, 3);
INSERT INTO aulas (nombre, letra, numero, planta) VALUES ('1SMR', 'I', 4, 1);
INSERT INTO aulas (nombre, letra, numero, planta) VALUES ('2SMR', 'D', 5, 1);
INSERT INTO aulas (nombre, letra, numero, planta) VALUES ('1DAM', 'D', 6, 3);
INSERT INTO aulas (nombre, letra, numero, planta) VALUES ('2DAM', 'I', 7, 3);
INSERT INTO aulas (nombre, letra, numero, planta) VALUES ('Medusa', 'D', 8, 3);
