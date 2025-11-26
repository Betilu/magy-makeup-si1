-- =====================================================
-- SCRIPT SQL COMPLETO - SISTEMA DE CITAS MAGY MAKEUP
-- Base de Datos: magy_makeup
-- Fecha: 2025-11-26
-- Incluye: Creación de tablas + Datos de ejemplo
-- =====================================================

-- PASO 1: CREAR BASE DE DATOS
-- =====================================================
DROP DATABASE IF EXISTS magy_makeup;
CREATE DATABASE magy_makeup CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE magy_makeup;

-- =====================================================
-- PASO 2: CREAR TODAS LAS TABLAS
-- =====================================================

-- Tabla: users
CREATE TABLE `users` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(255) NOT NULL,
    `email` VARCHAR(255) NOT NULL UNIQUE,
    `telefono` BIGINT NULL,
    `email_verified_at` TIMESTAMP NULL,
    `password` VARCHAR(255) NOT NULL,
    `remember_token` VARCHAR(100) NULL,
    `created_at` TIMESTAMP NULL,
    `updated_at` TIMESTAMP NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabla: password_reset_tokens
CREATE TABLE `password_reset_tokens` (
    `email` VARCHAR(255) NOT NULL,
    `token` VARCHAR(255) NOT NULL,
    `created_at` TIMESTAMP NULL,
    PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabla: sessions
CREATE TABLE `sessions` (
    `id` VARCHAR(255) NOT NULL,
    `user_id` BIGINT UNSIGNED NULL,
    `ip_address` VARCHAR(45) NULL,
    `user_agent` TEXT NULL,
    `payload` LONGTEXT NOT NULL,
    `last_activity` INT NOT NULL,
    PRIMARY KEY (`id`),
    INDEX `sessions_user_id_index` (`user_id`),
    INDEX `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Sistema de cache
CREATE TABLE `cache` (
    `key` VARCHAR(255) NOT NULL,
    `value` MEDIUMTEXT NOT NULL,
    `expiration` INT NOT NULL,
    PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `cache_locks` (
    `key` VARCHAR(255) NOT NULL,
    `owner` VARCHAR(255) NOT NULL,
    `expiration` INT NOT NULL,
    PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Sistema de jobs
CREATE TABLE `jobs` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `queue` VARCHAR(255) NOT NULL,
    `payload` LONGTEXT NOT NULL,
    `attempts` TINYINT UNSIGNED NOT NULL,
    `reserved_at` INT UNSIGNED NULL,
    `available_at` INT UNSIGNED NOT NULL,
    `created_at` INT UNSIGNED NOT NULL,
    PRIMARY KEY (`id`),
    INDEX `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `job_batches` (
    `id` VARCHAR(255) NOT NULL,
    `name` VARCHAR(255) NOT NULL,
    `total_jobs` INT NOT NULL,
    `pending_jobs` INT NOT NULL,
    `failed_jobs` INT NOT NULL,
    `failed_job_ids` LONGTEXT NOT NULL,
    `options` MEDIUMTEXT NULL,
    `cancelled_at` INT NULL,
    `created_at` INT NOT NULL,
    `finished_at` INT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `failed_jobs` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `uuid` VARCHAR(255) NOT NULL UNIQUE,
    `connection` TEXT NOT NULL,
    `queue` TEXT NOT NULL,
    `payload` LONGTEXT NOT NULL,
    `exception` LONGTEXT NOT NULL,
    `failed_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Sistema de roles y permisos
CREATE TABLE `permissions` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(255) NOT NULL,
    `guard_name` VARCHAR(255) NOT NULL,
    `created_at` TIMESTAMP NULL,
    `updated_at` TIMESTAMP NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `permissions_name_guard_name_unique` (`name`, `guard_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `roles` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(255) NOT NULL,
    `guard_name` VARCHAR(255) NOT NULL,
    `created_at` TIMESTAMP NULL,
    `updated_at` TIMESTAMP NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `roles_name_guard_name_unique` (`name`, `guard_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `model_has_permissions` (
    `permission_id` BIGINT UNSIGNED NOT NULL,
    `model_type` VARCHAR(255) NOT NULL,
    `model_id` BIGINT UNSIGNED NOT NULL,
    PRIMARY KEY (`permission_id`, `model_id`, `model_type`),
    INDEX `model_has_permissions_model_id_model_type_index` (`model_id`, `model_type`),
    CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `model_has_roles` (
    `role_id` BIGINT UNSIGNED NOT NULL,
    `model_type` VARCHAR(255) NOT NULL,
    `model_id` BIGINT UNSIGNED NOT NULL,
    PRIMARY KEY (`role_id`, `model_id`, `model_type`),
    INDEX `model_has_roles_model_id_model_type_index` (`model_id`, `model_type`),
    CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `role_has_permissions` (
    `permission_id` BIGINT UNSIGNED NOT NULL,
    `role_id` BIGINT UNSIGNED NOT NULL,
    PRIMARY KEY (`permission_id`, `role_id`),
    INDEX `role_has_permissions_role_id_foreign` (`role_id`),
    CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
    CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Bitácora de actividades
CREATE TABLE `activity_logs` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `user_id` BIGINT UNSIGNED NOT NULL,
    `ip_address` VARCHAR(255) NOT NULL,
    `action` VARCHAR(255) NOT NULL,
    `description` TEXT NOT NULL,
    `browser` TEXT NOT NULL,
    `created_at` TIMESTAMP NULL,
    `updated_at` TIMESTAMP NULL,
    PRIMARY KEY (`id`),
    INDEX `activity_logs_user_id_foreign` (`user_id`),
    CONSTRAINT `activity_logs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Módulo de clientes
CREATE TABLE `clients` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `user_id` BIGINT UNSIGNED NOT NULL,
    `direccion` VARCHAR(255) NOT NULL,
    `frecuencia` INT NOT NULL,
    `observacion` TEXT NULL,
    `created_at` TIMESTAMP NULL,
    `updated_at` TIMESTAMP NULL,
    PRIMARY KEY (`id`),
    INDEX `clients_user_id_foreign` (`user_id`),
    CONSTRAINT `clients_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Herramientas y horarios
CREATE TABLE `herramientas` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `nombre` VARCHAR(255) NOT NULL,
    `tipo` VARCHAR(255) NOT NULL,
    `cantidad` INT NOT NULL,
    `marca` VARCHAR(255) NOT NULL,
    `estadoHerramienta` VARCHAR(255) NOT NULL,
    `observacion` TEXT NULL,
    `created_at` TIMESTAMP NULL,
    `updated_at` TIMESTAMP NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `horarios` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `dia` VARCHAR(255) NOT NULL,
    `hora_inicio` TIME NOT NULL,
    `hora_fin` TIME NOT NULL,
    `created_at` TIMESTAMP NULL,
    `updated_at` TIMESTAMP NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Estilistas
CREATE TABLE `estilistas` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `horario_id` BIGINT UNSIGNED NOT NULL,
    `user_id` BIGINT UNSIGNED NOT NULL,
    `calificacion` INT NOT NULL,
    `comision` DOUBLE(10,2) NOT NULL DEFAULT 0.00,
    `disponibilidad` VARCHAR(255) NOT NULL,
    `especialidad` VARCHAR(255) NOT NULL,
    `estado` VARCHAR(255) NOT NULL DEFAULT 'nuevo',
    `total_comisiones` DOUBLE(10,2) NOT NULL DEFAULT 0.00,
    `created_at` TIMESTAMP NULL,
    `updated_at` TIMESTAMP NULL,
    PRIMARY KEY (`id`),
    INDEX `estilistas_horario_id_foreign` (`horario_id`),
    INDEX `estilistas_user_id_foreign` (`user_id`),
    CONSTRAINT `estilistas_horario_id_foreign` FOREIGN KEY (`horario_id`) REFERENCES `horarios` (`id`) ON DELETE CASCADE,
    CONSTRAINT `estilistas_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `asignacion_herramientas` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `herramienta_id` BIGINT UNSIGNED NOT NULL,
    `estilista_id` BIGINT UNSIGNED NOT NULL,
    `recepcionista_id` BIGINT UNSIGNED NOT NULL,
    `estadoEntrega` VARCHAR(255) NOT NULL,
    `estadoDevolucion` VARCHAR(255) NOT NULL,
    `fechaAsignacion` DATE NOT NULL,
    `fechaDevolucion` DATE NULL,
    `created_at` TIMESTAMP NULL,
    `updated_at` TIMESTAMP NULL,
    PRIMARY KEY (`id`),
    INDEX `asignacion_herramientas_herramienta_id_foreign` (`herramienta_id`),
    INDEX `asignacion_herramientas_estilista_id_foreign` (`estilista_id`),
    INDEX `asignacion_herramientas_recepcionista_id_foreign` (`recepcionista_id`),
    CONSTRAINT `asignacion_herramientas_herramienta_id_foreign` FOREIGN KEY (`herramienta_id`) REFERENCES `herramientas` (`id`) ON DELETE CASCADE,
    CONSTRAINT `asignacion_herramientas_estilista_id_foreign` FOREIGN KEY (`estilista_id`) REFERENCES `estilistas` (`id`) ON DELETE CASCADE,
    CONSTRAINT `asignacion_herramientas_recepcionista_id_foreign` FOREIGN KEY (`recepcionista_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Servicios y productos
CREATE TABLE `servicios` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `categoria` VARCHAR(255) NOT NULL,
    `nombre` VARCHAR(255) NOT NULL,
    `descripcion` TEXT NULL,
    `duracion` VARCHAR(255) NOT NULL,
    `precio_servicio` DECIMAL(8,2) NOT NULL DEFAULT 0.00,
    `estado` VARCHAR(255) NOT NULL DEFAULT 'activo',
    `created_at` TIMESTAMP NULL,
    `updated_at` TIMESTAMP NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `productos` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `nombre` VARCHAR(255) NOT NULL,
    `marca` VARCHAR(255) NOT NULL,
    `cantidad` INT NOT NULL,
    `costo` DECIMAL(8,2) NOT NULL,
    `descripcion` TEXT NULL,
    `created_at` TIMESTAMP NULL,
    `updated_at` TIMESTAMP NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `promocions` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `nombre` VARCHAR(255) NOT NULL,
    `porcentaje` INT NOT NULL,
    `descripcion` TEXT NULL,
    `fecha_inicio` DATE NOT NULL,
    `fecha_fin` DATE NOT NULL,
    `created_at` TIMESTAMP NULL,
    `updated_at` TIMESTAMP NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tablas pivot
CREATE TABLE `servicio_productos` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `servicio_id` BIGINT UNSIGNED NOT NULL,
    `producto_id` BIGINT UNSIGNED NOT NULL,
    `created_at` TIMESTAMP NULL,
    `updated_at` TIMESTAMP NULL,
    PRIMARY KEY (`id`),
    INDEX `servicio_productos_servicio_id_foreign` (`servicio_id`),
    INDEX `servicio_productos_producto_id_foreign` (`producto_id`),
    CONSTRAINT `servicio_productos_servicio_id_foreign` FOREIGN KEY (`servicio_id`) REFERENCES `servicios` (`id`) ON DELETE CASCADE,
    CONSTRAINT `servicio_productos_producto_id_foreign` FOREIGN KEY (`producto_id`) REFERENCES `productos` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `promocion_servicios` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `servicio_id` BIGINT UNSIGNED NOT NULL,
    `promocion_id` BIGINT UNSIGNED NOT NULL,
    `created_at` TIMESTAMP NULL,
    `updated_at` TIMESTAMP NULL,
    PRIMARY KEY (`id`),
    INDEX `promocion_servicios_servicio_id_foreign` (`servicio_id`),
    INDEX `promocion_servicios_promocion_id_foreign` (`promocion_id`),
    CONSTRAINT `promocion_servicios_servicio_id_foreign` FOREIGN KEY (`servicio_id`) REFERENCES `servicios` (`id`) ON DELETE CASCADE,
    CONSTRAINT `promocion_servicios_promocion_id_foreign` FOREIGN KEY (`promocion_id`) REFERENCES `promocions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `estilista_servicio` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `estilista_id` BIGINT UNSIGNED NOT NULL,
    `servicio_id` BIGINT UNSIGNED NOT NULL,
    `created_at` TIMESTAMP NULL,
    `updated_at` TIMESTAMP NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `estilista_servicio_unique` (`estilista_id`, `servicio_id`),
    INDEX `estilista_servicio_servicio_id_foreign` (`servicio_id`),
    CONSTRAINT `estilista_servicio_estilista_id_foreign` FOREIGN KEY (`estilista_id`) REFERENCES `estilistas` (`id`) ON DELETE CASCADE,
    CONSTRAINT `estilista_servicio_servicio_id_foreign` FOREIGN KEY (`servicio_id`) REFERENCES `servicios` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Citas
CREATE TABLE `citas` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `user_id` BIGINT UNSIGNED NOT NULL,
    `estilista_id` BIGINT UNSIGNED NOT NULL,
    `servicio_id` BIGINT UNSIGNED NOT NULL,
    `estado` VARCHAR(255) NOT NULL,
    `anticipo` DECIMAL(8,2) NULL,
    `precio_total` DECIMAL(8,2) NULL,
    `comision_estilista` DECIMAL(8,2) NULL,
    `fecha` VARCHAR(255) NOT NULL,
    `hora` VARCHAR(255) NOT NULL,
    `tipo` VARCHAR(255) NOT NULL,
    `created_at` TIMESTAMP NULL,
    `updated_at` TIMESTAMP NULL,
    PRIMARY KEY (`id`),
    INDEX `citas_user_id_foreign` (`user_id`),
    INDEX `citas_estilista_id_foreign` (`estilista_id`),
    INDEX `citas_servicio_id_foreign` (`servicio_id`),
    CONSTRAINT `citas_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
    CONSTRAINT `citas_estilista_id_foreign` FOREIGN KEY (`estilista_id`) REFERENCES `estilistas` (`id`) ON DELETE CASCADE,
    CONSTRAINT `citas_servicio_id_foreign` FOREIGN KEY (`servicio_id`) REFERENCES `servicios` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Notificaciones
CREATE TABLE `notificacions` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `client_id` BIGINT UNSIGNED NOT NULL,
    `cita_id` BIGINT UNSIGNED NOT NULL,
    `estado` VARCHAR(255) NOT NULL,
    `fecha` DATE NOT NULL,
    `mensaje` TEXT NOT NULL,
    `created_at` TIMESTAMP NULL,
    `updated_at` TIMESTAMP NULL,
    PRIMARY KEY (`id`),
    INDEX `notificacions_client_id_foreign` (`client_id`),
    INDEX `notificacions_cita_id_foreign` (`cita_id`),
    CONSTRAINT `notificacions_client_id_foreign` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`) ON DELETE CASCADE,
    CONSTRAINT `notificacions_cita_id_foreign` FOREIGN KEY (`cita_id`) REFERENCES `citas` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabla de migraciones
CREATE TABLE `migrations` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `migration` VARCHAR(255) NOT NULL,
    `batch` INT NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- PASO 3: INSERTAR DATOS DE EJEMPLO
-- =====================================================

-- Permisos
INSERT INTO `permissions` (`name`, `guard_name`, `created_at`, `updated_at`) VALUES
('ver usuarios', 'web', NOW(), NOW()),
('crear usuarios', 'web', NOW(), NOW()),
('ver citas', 'web', NOW(), NOW()),
('crear citas', 'web', NOW(), NOW()),
('editar citas', 'web', NOW(), NOW()),
('eliminar citas', 'web', NOW(), NOW());

-- Roles
INSERT INTO `roles` (`name`, `guard_name`, `created_at`, `updated_at`) VALUES
('super-admin', 'web', NOW(), NOW()),
('recepcionista', 'web', NOW(), NOW()),
('cliente', 'web', NOW(), NOW()),
('estilista', 'web', NOW(), NOW());

-- Asignar permisos a roles
INSERT INTO `role_has_permissions` (`permission_id`, `role_id`)
SELECT p.id, r.id FROM `permissions` p CROSS JOIN `roles` r WHERE r.name = 'super-admin';

INSERT INTO `role_has_permissions` (`permission_id`, `role_id`)
SELECT p.id, r.id FROM `permissions` p CROSS JOIN `roles` r
WHERE r.name = 'recepcionista' AND p.name IN ('ver citas', 'editar citas');

INSERT INTO `role_has_permissions` (`permission_id`, `role_id`)
SELECT p.id, r.id FROM `permissions` p CROSS JOIN `roles` r
WHERE r.name = 'cliente' AND p.name IN ('ver citas', 'crear citas');

-- Usuarios (password: '12345' para todos - Hash: $2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi)
INSERT INTO `users` (`name`, `email`, `telefono`, `email_verified_at`, `password`, `created_at`, `updated_at`) VALUES
('admin', 'admin@gmail.com', NULL, NOW(), '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NOW(), NOW()),
('recepcionista', 'recepcionista@recepcionista.com', NULL, NOW(), '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NOW(), NOW()),
('cliente', 'cliente@cliente.com', NULL, NOW(), '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NOW(), NOW()),
('María García', 'maria.garcia@gmail.com', 59123456, NOW(), '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NOW(), NOW()),
('Valentina Ruiz', 'valentina.ruiz@magy.com', 59789012, NOW(), '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NOW(), NOW()),
('Camila Díaz', 'camila.diaz@magy.com', 59890123, NOW(), '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NOW(), NOW());

-- Asignar roles a usuarios
INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`)
VALUES
((SELECT id FROM roles WHERE name = 'super-admin'), 'App\\Models\\User', 1),
((SELECT id FROM roles WHERE name = 'recepcionista'), 'App\\Models\\User', 2),
((SELECT id FROM roles WHERE name = 'cliente'), 'App\\Models\\User', 3),
((SELECT id FROM roles WHERE name = 'cliente'), 'App\\Models\\User', 4),
((SELECT id FROM roles WHERE name = 'estilista'), 'App\\Models\\User', 5),
((SELECT id FROM roles WHERE name = 'estilista'), 'App\\Models\\User', 6);

-- Clientes
INSERT INTO `clients` (`user_id`, `direccion`, `frecuencia`, `observacion`, `created_at`, `updated_at`) VALUES
(3, 'Zona Sur, La Paz', 3, 'Cliente frecuente', NOW(), NOW()),
(4, 'Av. 6 de Agosto #1234', 5, 'Prefiere citas matutinas', NOW(), NOW());

-- Horarios
INSERT INTO `horarios` (`dia`, `hora_inicio`, `hora_fin`, `created_at`, `updated_at`) VALUES
('Lunes a Viernes', '09:00:00', '18:00:00', NOW(), NOW()),
('Sábados', '10:00:00', '14:00:00', NOW(), NOW());

-- Estilistas
INSERT INTO `estilistas` (`user_id`, `horario_id`, `calificacion`, `comision`, `disponibilidad`, `especialidad`, `estado`, `total_comisiones`, `created_at`, `updated_at`) VALUES
(5, 1, 5, 50.00, 'Disponible', 'Maquillaje', 'antiguo', 0.00, NOW(), NOW()),
(6, 1, 4, 40.00, 'Disponible', 'Colorimetría', 'nuevo', 0.00, NOW(), NOW());

-- Servicios
INSERT INTO `servicios` (`categoria`, `nombre`, `descripcion`, `duracion`, `precio_servicio`, `estado`, `created_at`, `updated_at`) VALUES
('maquillaje', 'Maquillaje Social', 'Maquillaje para eventos diurnos', '60', 100.00, 'activo', NOW(), NOW()),
('maquillaje', 'Maquillaje de Novia', 'Maquillaje completo para novias', '120', 300.00, 'activo', NOW(), NOW()),
('colorimetria', 'Balayage', 'Técnica de coloración degradada', '180', 400.00, 'activo', NOW(), NOW()),
('peinado', 'Peinado de Fiesta', 'Peinado elegante para eventos', '90', 150.00, 'activo', NOW(), NOW());

-- Asignar servicios a estilistas
INSERT INTO `estilista_servicio` (`estilista_id`, `servicio_id`, `created_at`, `updated_at`) VALUES
(1, 1, NOW(), NOW()),
(1, 2, NOW(), NOW()),
(2, 3, NOW(), NOW());

-- =====================================================
-- FIN DEL SCRIPT COMPLETO
-- =====================================================

SELECT '✅ Base de datos creada y poblada exitosamente!' AS RESULTADO;
SELECT 'Usuarios de prueba (todos con password: 12345):' AS INFO;
SELECT name, email FROM users;
