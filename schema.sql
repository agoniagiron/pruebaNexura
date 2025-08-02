CREATE TABLE areas (
  id INT(11)       NOT NULL AUTO_INCREMENT,
  nombre VARCHAR(255) NOT NULL ,
  PRIMARY KEY (id)
) ENGINE=InnoDB
  DEFAULT CHARSET=utf8mb4
  COLLATE=utf8mb4_unicode_ci;

-- 3. Tabla de roles
CREATE TABLE roles (
  id INT(11)       NOT NULL AUTO_INCREMENT,
  nombre VARCHAR(255) NOT NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB
  DEFAULT CHARSET=utf8mb4
  COLLATE=utf8mb4_unicode_ci;

-- 4. Tabla de empleados
CREATE TABLE empleados (
  id INT(11)          NOT NULL AUTO_INCREMENT,
  nombre VARCHAR(255) NOT NULL  ,
  email VARCHAR(255)  NOT NULL ,
  sexo CHAR(1)        NOT NULL ,
  area_id INT(11)     NOT NULL ,
  boletin TINYINT(1)  NOT NULL DEFAULT 0 ,
  descripcion TEXT    NOT NULL ,
  PRIMARY KEY (id),
  KEY fk_empleados_area_idx (area_id),
  CONSTRAINT fk_empleados_area
    FOREIGN KEY (area_id) REFERENCES areas (id)
    ON UPDATE CASCADE
    ON DELETE RESTRICT
) ENGINE=InnoDB
  DEFAULT CHARSET=utf8mb4
  COLLATE=utf8mb4_unicode_ci;

-- 5. Tabla pivote empleado_rol
CREATE TABLE empleado_rol (
  empleado_id INT(11) NOT NULL ,
  rol_id    INT(11)  NOT NULL ,
  PRIMARY KEY (empleado_id,rol_id),
  KEY fk_emplrol_empleado_idx (empleado_id),
  KEY fk_emplrol_rol_idx (rol_id),
  CONSTRAINT fk_emplrol_empleado
    FOREIGN KEY (empleado_id) REFERENCES empleados (id)
    ON UPDATE CASCADE
    ON DELETE CASCADE,
  CONSTRAINT fk_emplrol_rol
    FOREIGN KEY (rol_id) REFERENCES roles (id)
    ON UPDATE CASCADE
    ON DELETE CASCADE
) ENGINE=InnoDB
  DEFAULT CHARSET=utf8mb4
  COLLATE=utf8mb4_unicode_ci;