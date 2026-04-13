-- ============================================================
-- BASE DE DATOS: Le Mascotte - Tienda de Mascotas & Clínica
-- ============================================================

CREATE DATABASE IF NOT EXISTS le_mascotte 
  CHARACTER SET utf8mb4 
  COLLATE utf8mb4_unicode_ci;

USE le_mascotte;

-- ------------------------------------------------------------
-- TABLA: categorias
-- ------------------------------------------------------------
CREATE TABLE categorias (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(100) NOT NULL,
  slug VARCHAR(100) NOT NULL UNIQUE,
  descripcion TEXT,
  icono VARCHAR(50),
  tipo ENUM('producto','exotico') DEFAULT 'producto',
  activo TINYINT(1) DEFAULT 1,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

INSERT INTO categorias (nombre, slug, descripcion, icono, tipo) VALUES
('Alimento', 'alimento', 'Comida premium para tus mascotas', '🍖', 'producto'),
('Juguetes', 'juguetes', 'Entretenimiento y estimulación', '🎾', 'producto'),
('Higiene', 'higiene', 'Cuidado e higiene personal', '🛁', 'producto'),
('Reptiles', 'reptiles', 'Productos especiales para reptiles', '🦎', 'exotico'),
('Aves', 'aves', 'Todo para tus aves y loros', '🦜', 'exotico'),
('Pequeños Mamíferos', 'pequenos-mamiferos', 'Hámsters, conejos y más', '🐹', 'exotico');

-- ------------------------------------------------------------
-- TABLA: productos
-- ------------------------------------------------------------
CREATE TABLE productos (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(200) NOT NULL,
  descripcion TEXT,
  descripcion_larga TEXT,
  precio DECIMAL(10,2) NOT NULL,
  precio_anterior DECIMAL(10,2),
  stock INT DEFAULT 0,
  categoria_id INT,
  imagen_url VARCHAR(500),
  imagen_secundaria VARCHAR(500),
  es_exotico TINYINT(1) DEFAULT 0,
  tip_cuidado TEXT COMMENT 'Tip especial para mascotas exóticas',
  destacado TINYINT(1) DEFAULT 0,
  activo TINYINT(1) DEFAULT 1,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (categoria_id) REFERENCES categorias(id) ON DELETE SET NULL
) ENGINE=InnoDB;

INSERT INTO productos (nombre, descripcion, precio, precio_anterior, stock, categoria_id, imagen_url, es_exotico, tip_cuidado, destacado) VALUES
-- Alimentos
('Alimento Premium para Perros', 'Alimento balanceado con proteínas de alta calidad para perros adultos.', 45.99, 52.00, 50, 1, 'https://images.unsplash.com/photo-1587300003388-59208cc962cb?w=400', 0, NULL, 1),
('Alimento para Gatos Senior', 'Nutrición especializada para gatos mayores de 7 años.', 38.50, NULL, 30, 1, 'https://images.unsplash.com/photo-1514888286974-6c03e2ca1dba?w=400', 0, NULL, 1),
('Snacks Naturales para Perros', 'Premios saludables sin conservantes artificiales.', 12.99, NULL, 100, 1, 'https://images.unsplash.com/photo-1583511655826-05700442e8fd?w=400', 0, NULL, 0),
('Alimento Húmedo para Cachorros', 'Comida húmeda balanceada para cachorros en crecimiento.', 8.99, NULL, 80, 1, 'https://images.unsplash.com/photo-1587300003388-59208cc962cb?w=400', 0, NULL, 0),
-- Juguetes
('Pelota Interactiva para Perros', 'Pelota con dispensador de premios para estimulación mental.', 18.99, 24.00, 40, 2, 'https://images.unsplash.com/photo-1548199973-03cce0bbc87b?w=400', 0, NULL, 1),
('Torre de Juegos para Gatos', 'Torre de 3 niveles con plataformas y juguetes colgantes.', 55.00, NULL, 20, 2, 'https://images.unsplash.com/photo-1574144611937-0df059b5ef3e?w=400', 0, NULL, 0),
('Cuerda de Jaladero', 'Juguete de cuerda resistente para perros activos.', 9.50, NULL, 60, 2, 'https://images.unsplash.com/photo-1612774412771-005ed8e861d2?w=400', 0, NULL, 0),
-- Higiene
('Shampoo Hipoalergénico', 'Shampoo suave para pieles sensibles. Sin parabenos.', 15.99, NULL, 45, 3, 'https://images.unsplash.com/photo-1600490036275-5ef01cf4d935?w=400', 0, NULL, 0),
('Kit de Cepillo Dental Canino', 'Kit completo con cepillo y pasta dental sabor pollo.', 11.99, 14.00, 35, 3, 'https://images.unsplash.com/photo-1587300003388-59208cc962cb?w=400', 0, NULL, 0),
('Cortauñas Profesional', 'Cortauñas de acero inoxidable con protector de seguridad.', 22.00, NULL, 25, 3, 'https://images.unsplash.com/photo-1516750105099-4b8a83e217ee?w=400', 0, NULL, 1),
-- Exóticos - Reptiles
('Terrario Starter Kit 40L', 'Kit completo con terrario, lámpara UV y termómetro digital.', 120.00, 150.00, 10, 4, 'https://images.unsplash.com/photo-1591389703635-e15a07b842d7?w=400', 1, 'Los reptiles necesitan gradiente de temperatura. Mantén un lado caliente (28-32°C) y un lado fresco (22-25°C) para que tu mascota regule su temperatura.', 1),
('Lámpara UV-B para Reptiles', 'Lámpara de espectro completo UVA/UVB para síntesis de vitamina D3.', 45.00, NULL, 15, 4, 'https://images.unsplash.com/photo-1425082661705-1834bfd09dca?w=400', 1, 'La exposición UV es vital: sin luz UVB, los reptiles diurnos no pueden procesar el calcio, lo que lleva al metabolic bone disease.', 1),
('Sustrato Natural para Reptiles', 'Mezcla orgánica de coco y musgo ideal para reptiles tropicales.', 18.00, NULL, 20, 4, 'https://images.unsplash.com/photo-1502780402662-acc01917738e?w=400', 1, 'Mantén la humedad entre 60-80% para reptiles tropicales. Rocía el sustrato por las mañanas para simular el ciclo natural.', 0),
-- Exóticos - Aves
('Jaula Premium para Loros', 'Jaula espaciosa de acero inoxidable con juguetes y perchas naturales.', 195.00, 220.00, 8, 5, 'https://images.unsplash.com/photo-1552728089-57bdde30beb3?w=400', 1, 'Los loros son seres sociales: necesitan mínimo 4 horas de interacción diaria fuera de la jaula para mantener su salud mental.', 1),
('Mezcla de Semillas Premium', 'Mezcla sin rellenos para loros y cotorras. Sin semillas de girasol.', 24.99, NULL, 30, 5, 'https://images.unsplash.com/photo-1558618666-fcd25c85cd64?w=400', 1, 'Varía la dieta de tu ave: las semillas deben ser solo el 30% de su alimentación. Completa con frutas frescas, vegetales y pellets.', 0),
-- Exóticos - Pequeños mamíferos
('Jaula Habitat para Hámster', 'Jaula de múltiples niveles con rueda silenciosa y tubos de exploración.', 48.00, NULL, 12, 6, 'https://images.unsplash.com/photo-1425082661705-1834bfd09dca?w=400', 1, 'Los hámsters recorren hasta 8 km noche. Una rueda silenciosa de mínimo 28cm de diámetro es esencial para su bienestar.', 0),
('Pellets Balanceados para Conejo', 'Alimento completo rico en fibra para conejos domésticos.', 19.99, NULL, 25, 6, 'https://images.unsplash.com/photo-1585110396000-c9ffd4e4b308?w=400', 1, 'El heno debe ser el 80% de la dieta de tu conejo. Los pellets son complementarios. Asegura acceso ilimitado a heno Timothy fresco.', 0);

-- ------------------------------------------------------------
-- TABLA: clientes
-- ------------------------------------------------------------
CREATE TABLE clientes (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(150) NOT NULL,
  email VARCHAR(200) UNIQUE NOT NULL,
  telefono VARCHAR(20),
  direccion TEXT,
  ciudad VARCHAR(100),
  pais VARCHAR(100) DEFAULT 'El Salvador',
  password_hash VARCHAR(255),
  activo TINYINT(1) DEFAULT 1,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- ------------------------------------------------------------
-- TABLA: pedidos
-- ------------------------------------------------------------
CREATE TABLE pedidos (
  id INT AUTO_INCREMENT PRIMARY KEY,
  cliente_id INT,
  nombre_cliente VARCHAR(150) NOT NULL,
  email_cliente VARCHAR(200) NOT NULL,
  telefono VARCHAR(20),
  direccion_entrega TEXT NOT NULL,
  subtotal DECIMAL(10,2) NOT NULL,
  descuento DECIMAL(10,2) DEFAULT 0,
  impuesto DECIMAL(10,2) DEFAULT 0,
  total DECIMAL(10,2) NOT NULL,
  estado ENUM('pendiente','confirmado','procesando','enviado','entregado','cancelado') DEFAULT 'pendiente',
  notas TEXT,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (cliente_id) REFERENCES clientes(id) ON DELETE SET NULL
) ENGINE=InnoDB;

-- ------------------------------------------------------------
-- TABLA: detalle_pedidos
-- ------------------------------------------------------------
CREATE TABLE detalle_pedidos (
  id INT AUTO_INCREMENT PRIMARY KEY,
  pedido_id INT NOT NULL,
  producto_id INT NOT NULL,
  nombre_producto VARCHAR(200) NOT NULL,
  precio_unitario DECIMAL(10,2) NOT NULL,
  cantidad INT NOT NULL,
  subtotal DECIMAL(10,2) NOT NULL,
  FOREIGN KEY (pedido_id) REFERENCES pedidos(id) ON DELETE CASCADE,
  FOREIGN KEY (producto_id) REFERENCES productos(id) ON DELETE RESTRICT
) ENGINE=InnoDB;

-- ------------------------------------------------------------
-- TABLA: mascotas (para historial clínica)
-- ------------------------------------------------------------
CREATE TABLE mascotas (
  id INT AUTO_INCREMENT PRIMARY KEY,
  cliente_id INT,
  nombre VARCHAR(100) NOT NULL,
  tipo ENUM('perro','gato','ave','reptil','roedor','otro') NOT NULL,
  raza VARCHAR(100),
  edad_años TINYINT,
  peso_kg DECIMAL(5,2),
  notas_medicas TEXT,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (cliente_id) REFERENCES clientes(id) ON DELETE SET NULL
) ENGINE=InnoDB;

-- ------------------------------------------------------------
-- TABLA: citas
-- ------------------------------------------------------------
CREATE TABLE citas (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nombre_dueno VARCHAR(150) NOT NULL,
  email VARCHAR(200),
  telefono VARCHAR(20) NOT NULL,
  nombre_mascota VARCHAR(100) NOT NULL,
  tipo_mascota ENUM('perro','gato','ave','reptil','roedor','otro') NOT NULL,
  motivo_consulta TEXT NOT NULL,
  fecha_preferida DATE NOT NULL,
  hora_preferida TIME NOT NULL,
  estado ENUM('solicitada','confirmada','completada','cancelada') DEFAULT 'solicitada',
  notas_veterinario TEXT,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- ------------------------------------------------------------
-- TABLA: contacto_mensajes
-- ------------------------------------------------------------
CREATE TABLE contacto_mensajes (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(150) NOT NULL,
  email VARCHAR(200) NOT NULL,
  asunto VARCHAR(300),
  mensaje TEXT NOT NULL,
  leido TINYINT(1) DEFAULT 0,
  respondido TINYINT(1) DEFAULT 0,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- ------------------------------------------------------------
-- TABLA: configuracion
-- ------------------------------------------------------------
CREATE TABLE configuracion (
  clave VARCHAR(100) PRIMARY KEY,
  valor TEXT,
  descripcion VARCHAR(300)
) ENGINE=InnoDB;

INSERT INTO configuracion VALUES
('nombre_tienda', 'Le Mascotte', 'Nombre de la tienda'),
('slogan', 'Cuidamos a los que más quieres', 'Slogan principal'),
('telefono', '+503 2200-0000', 'Teléfono de contacto'),
('email', 'info@lemascotte.com', 'Email de contacto'),
('direccion', 'San Salvador, El Salvador', 'Dirección física'),
('horario_semana', 'Lunes - Viernes: 9:00 - 20:00', 'Horario entre semana'),
('horario_sabado', 'Sábado: 10:00 - 18:00', 'Horario sábados'),
('horario_domingo', 'Domingo: 10:00 - 14:00', 'Horario domingos'),
('emergencias', '24/7', 'Atención de emergencias'),
('impuesto_porcentaje', '13', 'Porcentaje de IVA/impuesto'),
('moneda', 'USD', 'Moneda de la tienda'),
('simbolo_moneda', '$', 'Símbolo de moneda');

-- ------------------------------------------------------------
-- VISTAS útiles
-- ------------------------------------------------------------

CREATE OR REPLACE VIEW v_productos_completos AS
SELECT 
  p.id, p.nombre, p.descripcion, p.precio, p.precio_anterior,
  p.stock, p.imagen_url, p.es_exotico, p.tip_cuidado, p.destacado,
  c.nombre AS categoria, c.slug AS categoria_slug, c.tipo AS categoria_tipo
FROM productos p
LEFT JOIN categorias c ON p.categoria_id = c.id
WHERE p.activo = 1;

CREATE OR REPLACE VIEW v_pedidos_resumen AS
SELECT 
  p.id, p.nombre_cliente, p.email_cliente, p.total, p.estado, p.created_at,
  COUNT(dp.id) AS total_items
FROM pedidos p
LEFT JOIN detalle_pedidos dp ON p.id = dp.pedido_id
GROUP BY p.id;

CREATE OR REPLACE VIEW v_citas_hoy AS
SELECT * FROM citas 
WHERE fecha_preferida = CURDATE() 
  AND estado IN ('solicitada','confirmada')
ORDER BY hora_preferida;

-- ------------------------------------------------------------
-- TABLA: admin_usuarios
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS admin_usuarios (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(150) NOT NULL,
  email VARCHAR(200) UNIQUE NOT NULL,
  password_hash VARCHAR(255) NOT NULL,
  activo TINYINT(1) DEFAULT 1,
  ultimo_login TIMESTAMP NULL,
  ultimo_ip VARCHAR(45),
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- Usuario admin por defecto: admin@lemascotte.com / admin123
INSERT INTO admin_usuarios (nombre, email, password_hash) VALUES
('Administrador', 'admin@lemascotte.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi');
-- NOTA: El hash corresponde a la contraseña "admin123"
-- Para cambiarla usa: password_hash('tu_nueva_contraseña', PASSWORD_BCRYPT)
