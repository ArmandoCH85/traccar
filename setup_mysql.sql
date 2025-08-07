-- Script para configurar MySQL con root y contraseña 123456
CREATE DATABASE IF NOT EXISTS trackar;
USE trackar;

-- Configurar contraseña para root si es necesario
-- ALTER USER 'root'@'localhost' IDENTIFIED WITH mysql_native_password BY '123456';
-- FLUSH PRIVILEGES;

SELECT 'Database trackar ready' as status;