-- =====================================================
-- SCRIPT SQL CON DATOS DE EJEMPLO - MAGY MAKEUP
-- Base de Datos: magy_makeup
-- Fecha: 2025-11-26
-- Este script inserta datos de prueba en las tablas
-- =====================================================

USE magy_makeup;

-- =====================================================
-- DATOS: PERMISOS Y ROLES
-- =====================================================

-- Insertar permisos
INSERT INTO `permissions` (`name`, `guard_name`, `created_at`, `updated_at`) VALUES
('ver usuarios', 'web', NOW(), NOW()),
('crear usuarios', 'web', NOW(), NOW()),
('ver citas', 'web', NOW(), NOW()),
('crear citas', 'web', NOW(), NOW()),
('editar citas', 'web', NOW(), NOW()),
('eliminar citas', 'web', NOW(), NOW());

-- Insertar roles
INSERT INTO `roles` (`name`, `guard_name`, `created_at`, `updated_at`) VALUES
('super-admin', 'web', NOW(), NOW()),
('recepcionista', 'web', NOW(), NOW()),
('cliente', 'web', NOW(), NOW()),
('estilista', 'web', NOW(), NOW());

-- Asignar todos los permisos al super-admin
INSERT INTO `role_has_permissions` (`permission_id`, `role_id`)
SELECT p.id, r.id
FROM `permissions` p
CROSS JOIN `roles` r
WHERE r.name = 'super-admin';

-- Asignar permisos al recepcionista
INSERT INTO `role_has_permissions` (`permission_id`, `role_id`)
SELECT p.id, r.id
FROM `permissions` p
CROSS JOIN `roles` r
WHERE r.name = 'recepcionista'
AND p.name IN ('ver citas', 'editar citas');

-- Asignar permisos al cliente
INSERT INTO `role_has_permissions` (`permission_id`, `role_id`)
SELECT p.id, r.id
FROM `permissions` p
CROSS JOIN `roles` r
WHERE r.name = 'cliente'
AND p.name IN ('ver citas', 'crear citas');

-- =====================================================
-- DATOS: USUARIOS
-- =====================================================

-- Insertar usuarios principales (password: bcrypt hash de '12345' para todos excepto admin que es 'admin')
-- Nota: En producción, ejecuta php artisan tinker y usa Hash::make('password')

INSERT INTO `users` (`name`, `email`, `telefono`, `email_verified_at`, `password`, `created_at`, `updated_at`) VALUES
('admin', 'admin@gmail.com', NULL, NOW(), '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NOW(), NOW()),
('recepcionista', 'recepcionista@recepcionista.com', NULL, NOW(), '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NOW(), NOW()),
('cliente', 'cliente@cliente.com', NULL, NOW(), '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NOW(), NOW()),
('estilista', 'estilista@cliente.com', NULL, NOW(), '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NOW(), NOW()),
('María García', 'maria.garcia@gmail.com', 59123456, NOW(), '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NOW(), NOW()),
('Ana López', 'ana.lopez@gmail.com', 59234567, NOW(), '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NOW(), NOW()),
('Carmen Martínez', 'carmen.martinez@gmail.com', 59345678, NOW(), '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NOW(), NOW()),
('Laura Rodríguez', 'laura.rodriguez@gmail.com', 59456789, NOW(), '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NOW(), NOW()),
('Sofía Hernández', 'sofia.hernandez@gmail.com', 59567890, NOW(), '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NOW(), NOW()),
('Isabella Torres', 'isabella.torres@gmail.com', 59678901, NOW(), '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NOW(), NOW()),
('Valentina Ruiz', 'valentina.ruiz@magy.com', 59789012, NOW(), '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NOW(), NOW()),
('Camila Díaz', 'camila.diaz@magy.com', 59890123, NOW(), '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NOW(), NOW()),
('Gabriela Morales', 'gabriela.morales@magy.com', 59901234, NOW(), '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NOW(), NOW()),
('Daniela Castro', 'daniela.castro@magy.com', 59012345, NOW(), '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NOW(), NOW()),
('Natalia Ramos', 'natalia.ramos@magy.com', 59112345, NOW(), '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NOW(), NOW()),
('Fernanda Silva', 'fernanda.silva@magy.com', 59212345, NOW(), '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NOW(), NOW());

-- Asignar roles a usuarios
INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`)
SELECT r.id, 'App\\Models\\User', u.id
FROM `roles` r, `users` u
WHERE (r.name = 'super-admin' AND u.email = 'admin@gmail.com')
   OR (r.name = 'recepcionista' AND u.email = 'recepcionista@recepcionista.com')
   OR (r.name = 'cliente' AND u.email IN ('cliente@cliente.com', 'maria.garcia@gmail.com', 'ana.lopez@gmail.com', 'carmen.martinez@gmail.com', 'laura.rodriguez@gmail.com', 'sofia.hernandez@gmail.com', 'isabella.torres@gmail.com'))
   OR (r.name = 'estilista' AND u.email IN ('estilista@cliente.com', 'valentina.ruiz@magy.com', 'camila.diaz@magy.com', 'gabriela.morales@magy.com', 'daniela.castro@magy.com', 'natalia.ramos@magy.com', 'fernanda.silva@magy.com'));

-- =====================================================
-- DATOS: CLIENTES
-- =====================================================

INSERT INTO `clients` (`user_id`, `direccion`, `frecuencia`, `observacion`, `created_at`, `updated_at`)
SELECT u.id, 'Zona Sur, La Paz', 3, 'Cliente frecuente', NOW(), NOW()
FROM `users` u WHERE u.email = 'cliente@cliente.com'
UNION ALL
SELECT u.id, 'Av. 6 de Agosto #1234', 5, 'Prefiere citas matutinas', NOW(), NOW()
FROM `users` u WHERE u.email = 'maria.garcia@gmail.com'
UNION ALL
SELECT u.id, 'Calacoto, Calle 10', 2, NULL, NOW(), NOW()
FROM `users` u WHERE u.email = 'ana.lopez@gmail.com'
UNION ALL
SELECT u.id, 'Sopocachi, Av. 20 de Octubre', 4, 'Cliente VIP', NOW(), NOW()
FROM `users` u WHERE u.email = 'carmen.martinez@gmail.com'
UNION ALL
SELECT u.id, 'San Miguel, Zona Central', 3, NULL, NOW(), NOW()
FROM `users` u WHERE u.email = 'laura.rodriguez@gmail.com'
UNION ALL
SELECT u.id, 'Miraflores, Calle Rosendo Gutierrez', 6, 'Muy puntual', NOW(), NOW()
FROM `users` u WHERE u.email = 'sofia.hernandez@gmail.com'
UNION ALL
SELECT u.id, 'Obrajes, Calle 12', 2, 'Primera vez', NOW(), NOW()
FROM `users` u WHERE u.email = 'isabella.torres@gmail.com';

-- =====================================================
-- DATOS: HORARIOS
-- =====================================================

INSERT INTO `horarios` (`dia`, `hora_inicio`, `hora_fin`, `created_at`, `updated_at`) VALUES
('Lunes a Viernes', '09:00:00', '18:00:00', NOW(), NOW()),
('Sábados', '10:00:00', '14:00:00', NOW(), NOW()),
('Lunes a Sábado', '08:00:00', '20:00:00', NOW(), NOW()),
('Martes a Viernes', '14:00:00', '22:00:00', NOW(), NOW());

-- =====================================================
-- DATOS: ESTILISTAS
-- =====================================================

INSERT INTO `estilistas` (`user_id`, `horario_id`, `calificacion`, `comision`, `disponibilidad`, `especialidad`, `estado`, `total_comisiones`, `created_at`, `updated_at`)
SELECT u.id, 1, 5, 50.00, 'Disponible', 'Cortes y Peinados', 'antiguo', 0.00, NOW(), NOW()
FROM `users` u WHERE u.email = 'estilista@cliente.com'
UNION ALL
SELECT u.id, 1, 5, 50.00, 'Disponible', 'Maquillaje', 'antiguo', 0.00, NOW(), NOW()
FROM `users` u WHERE u.email = 'valentina.ruiz@magy.com'
UNION ALL
SELECT u.id, 2, 4, 40.00, 'Disponible', 'Colorimetría', 'nuevo', 0.00, NOW(), NOW()
FROM `users` u WHERE u.email = 'camila.diaz@magy.com'
UNION ALL
SELECT u.id, 3, 5, 50.00, 'Disponible', 'Peinados de Novia', 'antiguo', 0.00, NOW(), NOW()
FROM `users` u WHERE u.email = 'gabriela.morales@magy.com'
UNION ALL
SELECT u.id, 1, 4, 40.00, 'Disponible', 'Manicure y Pedicure', 'nuevo', 0.00, NOW(), NOW()
FROM `users` u WHERE u.email = 'daniela.castro@magy.com'
UNION ALL
SELECT u.id, 4, 5, 50.00, 'Disponible', 'Maquillaje de Novia', 'antiguo', 0.00, NOW(), NOW()
FROM `users` u WHERE u.email = 'natalia.ramos@magy.com'
UNION ALL
SELECT u.id, 3, 4, 40.00, 'Disponible', 'Cejas y Pestañas', 'nuevo', 0.00, NOW(), NOW()
FROM `users` u WHERE u.email = 'fernanda.silva@magy.com';

-- =====================================================
-- DATOS: SERVICIOS
-- =====================================================

INSERT INTO `servicios` (`categoria`, `nombre`, `descripcion`, `duracion`, `precio_servicio`, `estado`, `created_at`, `updated_at`) VALUES
('corte', 'Corte de Cabello Dama', 'Corte profesional de cabello para dama', '60', 80.00, 'activo', NOW(), NOW()),
('corte', 'Corte de Cabello Caballero', 'Corte clásico o moderno para caballero', '45', 60.00, 'activo', NOW(), NOW()),
('peinado', 'Peinado Simple', 'Peinado para ocasiones casuales', '30', 50.00, 'activo', NOW(), NOW()),
('peinado', 'Peinado de Novia', 'Peinado elaborado para novias', '120', 250.00, 'activo', NOW(), NOW()),
('peinado', 'Peinado de Fiesta', 'Peinado elegante para eventos', '90', 150.00, 'activo', NOW(), NOW()),
('maquillaje', 'Maquillaje Social', 'Maquillaje para eventos diurnos', '60', 100.00, 'activo', NOW(), NOW()),
('maquillaje', 'Maquillaje de Novia', 'Maquillaje completo para novias', '120', 300.00, 'activo', NOW(), NOW()),
('maquillaje', 'Maquillaje de Noche', 'Maquillaje para eventos nocturnos', '90', 180.00, 'activo', NOW(), NOW()),
('colorimetria', 'Tinte Completo', 'Aplicación de tinte de un solo tono', '120', 200.00, 'activo', NOW(), NOW()),
('colorimetria', 'Mechas Californianas', 'Mechas con efecto natural', '180', 350.00, 'activo', NOW(), NOW()),
('colorimetria', 'Balayage', 'Técnica de coloración degradada', '180', 400.00, 'activo', NOW(), NOW()),
('tratamiento', 'Tratamiento Capilar', 'Tratamiento de hidratación profunda', '60', 120.00, 'activo', NOW(), NOW()),
('tratamiento', 'Keratina', 'Alisado brasileño con keratina', '240', 500.00, 'activo', NOW(), NOW()),
('uñas', 'Manicure', 'Manicure básico', '45', 40.00, 'activo', NOW(), NOW()),
('uñas', 'Pedicure', 'Pedicure completo', '60', 50.00, 'activo', NOW(), NOW()),
('uñas', 'Uñas Acrílicas', 'Aplicación de uñas acrílicas', '120', 150.00, 'activo', NOW(), NOW()),
('cejas', 'Depilación de Cejas', 'Diseño y depilación de cejas', '20', 25.00, 'activo', NOW(), NOW()),
('cejas', 'Tinte de Cejas', 'Tinte profesional de cejas', '30', 30.00, 'activo', NOW(), NOW()),
('pestañas', 'Extensiones de Pestañas', 'Aplicación de pestañas postizas', '90', 180.00, 'activo', NOW(), NOW()),
('pestañas', 'Lifting de Pestañas', 'Permanente de pestañas', '60', 100.00, 'activo', NOW(), NOW());

-- =====================================================
-- DATOS: ASIGNACIÓN ESTILISTA-SERVICIO
-- =====================================================

-- Asignar servicios a estilistas (cada estilista tiene sus especialidades)
INSERT INTO `estilista_servicio` (`estilista_id`, `servicio_id`, `created_at`, `updated_at`)
SELECT e.id, s.id, NOW(), NOW()
FROM `estilistas` e
JOIN `users` u ON e.user_id = u.id
CROSS JOIN `servicios` s
WHERE (u.email = 'valentina.ruiz@magy.com' AND s.categoria IN ('maquillaje', 'cejas', 'pestañas'))
   OR (u.email = 'camila.diaz@magy.com' AND s.categoria IN ('colorimetria', 'tratamiento'))
   OR (u.email = 'gabriela.morales@magy.com' AND s.categoria IN ('peinado', 'tratamiento'))
   OR (u.email = 'daniela.castro@magy.com' AND s.categoria IN ('uñas', 'cejas'))
   OR (u.email = 'natalia.ramos@magy.com' AND s.categoria IN ('maquillaje', 'peinado'))
   OR (u.email = 'fernanda.silva@magy.com' AND s.categoria IN ('cejas', 'pestañas'))
   OR (u.email = 'estilista@cliente.com' AND s.categoria IN ('corte', 'peinado'));

-- =====================================================
-- DATOS: PRODUCTOS
-- =====================================================

INSERT INTO `productos` (`nombre`, `marca`, `cantidad`, `costo`, `descripcion`, `created_at`, `updated_at`) VALUES
('Shampoo Profesional', 'Loreal', 50, 45.00, 'Shampoo para cabello profesional', NOW(), NOW()),
('Acondicionador', 'Loreal', 45, 50.00, 'Acondicionador hidratante', NOW(), NOW()),
('Tinte Negro', 'Koleston', 30, 35.00, 'Tinte permanente negro', NOW(), NOW()),
('Tinte Castaño', 'Koleston', 25, 35.00, 'Tinte permanente castaño', NOW(), NOW()),
('Keratina Brasileña', 'Inoar', 10, 250.00, 'Tratamiento de keratina', NOW(), NOW()),
('Base de Maquillaje', 'MAC', 20, 180.00, 'Base de cobertura completa', NOW(), NOW()),
('Mascara de Pestañas', 'Maybelline', 30, 40.00, 'Máscara waterproof', NOW(), NOW()),
('Labial Matte', 'Ruby Rose', 40, 25.00, 'Labial de larga duración', NOW(), NOW()),
('Esmalte de Uñas', 'OPI', 60, 30.00, 'Esmalte profesional', NOW(), NOW()),
('Removedor de Esmalte', 'Generic', 40, 15.00, 'Removedor sin acetona', NOW(), NOW());

-- =====================================================
-- DATOS: PROMOCIONES
-- =====================================================

INSERT INTO `promocions` (`nombre`, `porcentaje`, `descripcion`, `fecha_inicio`, `fecha_fin`, `created_at`, `updated_at`) VALUES
('Descuento Fin de Año', 20, 'Descuento especial para fin de año', '2025-12-01', '2025-12-31', NOW(), NOW()),
('Promoción San Valentín', 15, 'Descuento por el día del amor', '2026-02-01', '2026-02-14', NOW(), NOW()),
('Día de la Madre', 25, 'Promoción especial para mamás', '2026-05-01', '2026-05-31', NOW(), NOW());

-- =====================================================
-- DATOS: HERRAMIENTAS
-- =====================================================

INSERT INTO `herramientas` (`nombre`, `tipo`, `cantidad`, `marca`, `estadoHerramienta`, `observacion`, `created_at`, `updated_at`) VALUES
('Secadora Profesional', 'secadora', 5, 'Philips', 'Disponible', 'Secadora de 2000W', NOW(), NOW()),
('Plancha Alisadora', 'plancha', 4, 'BaByliss', 'Disponible', 'Plancha de cerámica', NOW(), NOW()),
('Tijera Profesional', 'tijera', 10, 'Jaguar', 'Disponible', 'Tijera alemana de corte', NOW(), NOW()),
('Tijera de Entresacar', 'tijera', 8, 'Jaguar', 'Disponible', 'Tijera para texturizar', NOW(), NOW()),
('Rizador', 'rizador', 3, 'Remington', 'Disponible', 'Rizador automático', NOW(), NOW()),
('Brocha de Maquillaje Set', 'maquillaje', 6, 'Sigma', 'Disponible', 'Set completo de brochas', NOW(), NOW()),
('Pinzas de Depilar', 'depilacion', 15, 'Tweezerman', 'Disponible', 'Pinzas de precisión', NOW(), NOW()),
('Lámpara LED', 'uñas', 4, 'Sun', 'Disponible', 'Lámpara para uñas de gel', NOW(), NOW());

-- =====================================================
-- DATOS DE EJEMPLO: CITAS
-- =====================================================

-- Citas confirmadas
INSERT INTO `citas` (`user_id`, `estilista_id`, `servicio_id`, `estado`, `anticipo`, `precio_total`, `comision_estilista`, `fecha`, `hora`, `tipo`, `created_at`, `updated_at`)
SELECT
    uc.id,
    (SELECT e.id FROM estilistas e JOIN users u ON e.user_id = u.id WHERE u.email = 'valentina.ruiz@magy.com' LIMIT 1),
    (SELECT id FROM servicios WHERE nombre = 'Maquillaje Social' LIMIT 1),
    'confirmada',
    50.00,
    100.00,
    50.00,
    '2025-11-28',
    '10:00',
    'servicio',
    NOW(),
    NOW()
FROM users uc WHERE uc.email = 'maria.garcia@gmail.com';

INSERT INTO `citas` (`user_id`, `estilista_id`, `servicio_id`, `estado`, `anticipo`, `precio_total`, `comision_estilista`, `fecha`, `hora`, `tipo`, `created_at`, `updated_at`)
SELECT
    uc.id,
    (SELECT e.id FROM estilistas e JOIN users u ON e.user_id = u.id WHERE u.email = 'gabriela.morales@magy.com' LIMIT 1),
    (SELECT id FROM servicios WHERE nombre = 'Peinado de Fiesta' LIMIT 1),
    'confirmada',
    75.00,
    150.00,
    75.00,
    '2025-11-29',
    '15:00',
    'servicio',
    NOW(),
    NOW()
FROM users uc WHERE uc.email = 'ana.lopez@gmail.com';

-- Citas pendientes
INSERT INTO `citas` (`user_id`, `estilista_id`, `servicio_id`, `estado`, `anticipo`, `precio_total`, `comision_estilista`, `fecha`, `hora`, `tipo`, `created_at`, `updated_at`)
SELECT
    uc.id,
    (SELECT e.id FROM estilistas e JOIN users u ON e.user_id = u.id WHERE u.email = 'camila.diaz@magy.com' LIMIT 1),
    (SELECT id FROM servicios WHERE nombre = 'Balayage' LIMIT 1),
    'pendiente',
    200.00,
    400.00,
    160.00,
    '2025-11-30',
    '14:00',
    'servicio',
    NOW(),
    NOW()
FROM users uc WHERE uc.email = 'carmen.martinez@gmail.com';

-- =====================================================
-- FIN DEL SCRIPT DE DATOS
-- =====================================================

SELECT 'Datos insertados exitosamente!' AS mensaje;
SELECT COUNT(*) AS total_usuarios FROM users;
SELECT COUNT(*) AS total_clientes FROM clients;
SELECT COUNT(*) AS total_estilistas FROM estilistas;
SELECT COUNT(*) AS total_servicios FROM servicios;
SELECT COUNT(*) AS total_citas FROM citas;
