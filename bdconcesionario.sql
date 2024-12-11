drop database if exists BDConcesionario;

/** Crea la base de datos. */
create database BDConcesionario;

/** Crea el usuario para acceder a la base de datos. */
create or replace user 'UBDConcesionario'@'localhost' identified by 'Lo-1234-lo';

/** Concede privilegios al usuario para acceder a la base de datos. */
grant select, insert, update, delete on BDConcesionario.* 
    to 'UBDConcesionario'@'localhost';

/** Selecciona la base de datos. */
use BDConcesionario;

-- Tabla usuarios
CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabla coches
CREATE TABLE coches (
    id INT AUTO_INCREMENT PRIMARY KEY,
    marca VARCHAR(50) NOT NULL,
    modelo VARCHAR(50) NOT NULL,
    descripcion VARCHAR(100) NOT NULL,
    año INT NOT NULL,
    precio DECIMAL(10, 2) NOT NULL,
    imagen VARCHAR(255), -- Nombre del archivo de imagen
    motor VARCHAR(50),
    combustible VARCHAR(50),
    potencia VARCHAR(50),
    velocidad_maxima VARCHAR(50),
    aceleracion VARCHAR(50),
    fecha_agregado TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabla reservas
CREATE TABLE reservas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL,
    coche_id INT NOT NULL,
    fecha_reserva TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    estado ENUM('pendiente', 'confirmada', 'cancelada') DEFAULT 'pendiente',
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE,
    FOREIGN KEY (coche_id) REFERENCES coches(id) ON DELETE CASCADE
);

CREATE TABLE favoritos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    coche_id INT NOT NULL,
    FOREIGN KEY (user_id) REFERENCES usuarios(id),
    FOREIGN KEY (coche_id) REFERENCES coches(id)
);


INSERT INTO coches (marca, modelo, descripcion, año, precio, imagen, motor, combustible, potencia, velocidad_maxima, aceleracion)
VALUES
    ('BMW', 'M140i', 'Deportivo compacto con gran potencia y aceleración', 2020, 35000, 'BMWM140i.jpg', 'I6 3.0L', 'Gasolina', '335 CV', '250 km/h', '4.6 s'),
    ('Mercedes-Benz', 'A35 AMG', 'Sedán ágil y deportivo, con excelente rendimiento', 2021, 45000, 'MercedesA35AMG.jpg', 'I4 2.0L', 'Gasolina', '302 CV', '250 km/h', '4.7 s'),
    ('Audi', 'RS5', 'Coupé elegante con gran velocidad y potencia', 2018, 75000, 'AudiRS5.jpg', 'V6 2.9L Biturbo', 'Gasolina',  '450 CV', '280 km/h', '3.9 s'),
    ('Mercedes-Benz', 'AMG C63 Black Series', 'Coupé de alto rendimiento y estilo agresivo', 2012, 120000, 'MercedesC63AMG.jpg', 'V8 6.2L', 'Gasolina', '510 CV', '300 km/h', '4.2 s'),
    ('Shelby', 'GT500', 'Muscle car clásico, potente y emblemático', 1967, 150000, 'ShelbyGT500.jpg', 'V8 7.0L', 'Gasolina', '355 CV', '210 km/h', '6.5 s'),
    ('Porsche', '911 Turbo S', 'Superdeportivo veloz y sofisticado', 2021, 205000, 'Porsche911TurboS.jpg', 'Bóxer 6 3.8L Twin-turbo', 'Gasolina', '640 CV', '330 km/h', '2.7 s'),
    ('Lancia', 'Delta HF Integrale Evo 2', 'Compacto leyenda de los rallyes', 1993, 60000, 'LanciaDeltaHF.jpg', 'I4 2.0L Turbo', 'Gasolina', '215 CV', '220 km/h', '5.7 s'),
    ('RAM', 'TRX', 'Pickup de alto rendimiento con diseño agresivo y motor potente', 2022, 92000, 'RAMTRX.jpg', 'V8 6.2L Supercharged', 'Gasolina', '702 CV', '190 km/h', '4.5 s'),
    ('Nissan', 'Patrol GR', 'SUV robusto y fiable, diseñado para terrenos difíciles', 2005, 30000, 'NissanPatrolGR.jpg', 'I6 3.0L Diesel', 'Diésel', '158 CV', '170 km/h', '14.5 s'),
    ('Lotus', 'Exige Sport 420 Final Edition', 'Deportivo ligero y ágil, edición especial de despedida', 2021, 110000, 'LotusExigeSport420.jpg', 'V6 3.5L Supercharged', 'Gasolina', '420 CV', '280 km/h', '3.3 s'),
    ('BMW', 'X5M', 'SUV de lujo con prestaciones deportivas y gran comodidad', 2021, 130000, 'BMWX5M.jpg', 'V8 4.4L Twin-Turbo', 'Gasolina', '617 CV', '290 km/h', '3.9 s'),
    ('Seat', 'León Cupra', 'Hatchback deportivo con excelente rendimiento y diseño', 2022, 45000, 'SeatLeonCupra.jpg', 'I4 2.0L Turbo', 'Gasolina', '300 CV', '250 km/h', '5.6 s'),
    ('Volvo', 'Polestar 1', 'Coupé híbrido de lujo con enfoque en sostenibilidad y rendimiento', 2021, 160000, 'VolvoPolestar1.jpg', 'I4 2.0L Turbo + Eléctrico', 'Gasolina', '619 CV', '250 km/h', '4.2 s');


