-- ============================================================
-- MyCar - Sistema de Alquiler de Vehiculos
-- TAPW - TATW | Practico Nº 2 - Frameworks de Desarrollo WEB
-- Base de datos: mycar_db
-- Importar este archivo desde phpMyAdmin (pestaña "Importar")
-- ============================================================

CREATE DATABASE IF NOT EXISTS mycar_db
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_general_ci;

USE mycar_db;

SET FOREIGN_KEY_CHECKS = 0;

DROP TABLE IF EXISTS alquileres;
DROP TABLE IF EXISTS reservas;
DROP TABLE IF EXISTS vehiculos;
DROP TABLE IF EXISTS clientes;
DROP TABLE IF EXISTS usuarios;

SET FOREIGN_KEY_CHECKS = 1;

-- ------------------------------------------------------------
-- 1. TABLA: USUARIOS
-- Cuentas de acceso al sistema. Dos roles: admin / cliente
-- ------------------------------------------------------------
CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    contra VARCHAR(255) NOT NULL,
    rol ENUM('admin', 'cliente') NOT NULL DEFAULT 'cliente',
    estado TINYINT(1) NOT NULL DEFAULT 1,
    creado_en TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- ------------------------------------------------------------
-- 2. TABLA: CLIENTES
-- ------------------------------------------------------------
CREATE TABLE clientes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL UNIQUE,
    nombre VARCHAR(50) NOT NULL,
    apellido VARCHAR(50) NOT NULL,
    direccion VARCHAR(100) NOT NULL,
    telefono VARCHAR(30) NOT NULL,
    fecha_alta DATE NOT NULL,
    estado TINYINT(1) NOT NULL DEFAULT 1,
    CONSTRAINT fk_clientes_usuario FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- ------------------------------------------------------------
-- 3. TABLA: VEHICULOS
-- ------------------------------------------------------------
CREATE TABLE vehiculos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    marca VARCHAR(50) NOT NULL,
    modelo VARCHAR(50) NOT NULL,
    anio INT NOT NULL,
    plazas INT NOT NULL,
    motor VARCHAR(50) NOT NULL,
    kilometraje DECIMAL(10,2) NOT NULL DEFAULT 0,
    precio_dia DECIMAL(10,2) NOT NULL,
    disponible TINYINT(1) NOT NULL DEFAULT 1,
    estado TINYINT(1) NOT NULL DEFAULT 1,
    CONSTRAINT chk_precio CHECK (precio_dia > 0)
) ENGINE=InnoDB;

-- ------------------------------------------------------------
-- 4. TABLA: RESERVAS
-- Solicitud que envia el cliente. El admin la transforma en alquiler.
-- ------------------------------------------------------------
CREATE TABLE reservas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    cliente_id INT NOT NULL,
    vehiculo_id INT NOT NULL,
    fecha_desde DATE NOT NULL,
    cantidad_dias INT NOT NULL,
    estado ENUM('pendiente', 'aprobada', 'rechazada') NOT NULL DEFAULT 'pendiente',
    creado_en TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_reservas_cliente FOREIGN KEY (cliente_id) REFERENCES clientes(id) ON DELETE RESTRICT,
    CONSTRAINT fk_reservas_vehiculo FOREIGN KEY (vehiculo_id) REFERENCES vehiculos(id) ON DELETE RESTRICT
) ENGINE=InnoDB;

-- ------------------------------------------------------------
-- 5. TABLA: ALQUILERES
-- Se genera cuando el administrador aprueba una reserva.
-- ------------------------------------------------------------
CREATE TABLE alquileres (
    id INT AUTO_INCREMENT PRIMARY KEY,
    reserva_id INT NOT NULL UNIQUE,
    cliente_id INT NOT NULL,
    vehiculo_id INT NOT NULL,
    fecha_desde DATE NOT NULL,
    fecha_hasta DATE NOT NULL,
    devuelto TINYINT(1) NOT NULL DEFAULT 0,
    fecha_devolucion DATE NULL,
    CONSTRAINT fk_alquileres_reserva FOREIGN KEY (reserva_id) REFERENCES reservas(id) ON DELETE RESTRICT,
    CONSTRAINT fk_alquileres_cliente FOREIGN KEY (cliente_id) REFERENCES clientes(id) ON DELETE RESTRICT,
    CONSTRAINT fk_alquileres_vehiculo FOREIGN KEY (vehiculo_id) REFERENCES vehiculos(id) ON DELETE RESTRICT
) ENGINE=InnoDB;

-- ============================================================
-- DATOS DE PRUEBA
-- ============================================================

-- Usuario administrador -> usuario: admin    clave: admin123
INSERT INTO usuarios (usuario, email, contra, rol, estado) VALUES
('admin', 'admin@mycar.com', '$2y$10$ZCdLyd.PtOUXSMzL30hdmeSv8NXhNhBSDypQqqpMZRc5H737JSjha', 'admin', 1);

-- Usuario cliente de prueba -> usuario: jperez   clave: cliente123
INSERT INTO usuarios (usuario, email, contra, rol, estado) VALUES
('jperez', 'jperez@mail.com', '$2y$10$8Aue28AivK0o9FK8nr8n9OIUiMCe1T0jY6JRyl4rXN0gLdRl7Ry86', 'cliente', 1);

INSERT INTO clientes (usuario_id, nombre, apellido, direccion, telefono, fecha_alta, estado) VALUES
(2, 'Juan', 'Perez', 'Av. San Martin 123, San Luis', '266-4445566', CURDATE(), 1);

-- Vehiculos disponibles
INSERT INTO vehiculos (marca, modelo, anio, plazas, motor, kilometraje, precio_dia, disponible, estado) VALUES
('Volkswagen', 'Gol Trend', 2021, 5, '1.6 Nafta', 32500.00, 18500.00, 1, 1),
('Toyota', 'Corolla', 2022, 5, '2.0 Nafta', 18000.00, 27500.00, 1, 1),
('Chevrolet', 'Onix', 2020, 5, '1.4 Nafta', 41200.00, 16800.00, 1, 1),
('Ford', 'Ranger', 2019, 5, '3.2 Diesel', 65000.00, 35000.00, 1, 1),
('Fiat', 'Cronos', 2023, 5, '1.3 Nafta', 9500.00, 19900.00, 1, 1),
('Renault', 'Duster', 2021, 5, '1.6 Nafta', 28700.00, 24500.00, 0, 1),
('Peugeot', '208', 2018, 5, '1.6 Nafta', 78400.00, 15200.00, 1, 0);

-- Una reserva pendiente de aprobacion (para probar la vista Alta del Admin)
INSERT INTO reservas (cliente_id, vehiculo_id, fecha_desde, cantidad_dias, estado) VALUES
(1, 2, CURDATE() + INTERVAL 2 DAY, 4, 'pendiente');

-- Una reserva ya aprobada con su alquiler activo (para probar Mostrar / Baja)
INSERT INTO reservas (cliente_id, vehiculo_id, fecha_desde, cantidad_dias, estado) VALUES
(1, 6, CURDATE() - INTERVAL 3 DAY, 5, 'aprobada');

INSERT INTO alquileres (reserva_id, cliente_id, vehiculo_id, fecha_desde, fecha_hasta, devuelto) VALUES
(2, 1, 6, CURDATE() - INTERVAL 3 DAY, CURDATE() + INTERVAL 2 DAY, 0);
