# MyCar — Sistema de alquiler de vehículos

Trabajo práctico Nº 2 — Frameworks (TAPW-TATW). Aplicación MVC desarrollada con
**CodeIgniter 4**, con dos roles de usuario (Administrador y Cliente).

## Requisitos

- XAMPP (Apache + MySQL/MariaDB + PHP 8.2 o superior, con las extensiones
  `mysqli`, `mbstring` e `intl` — todas vienen activadas por defecto en XAMPP).

## Instalación

1. **Copiar la carpeta del proyecto** (esta misma, `topicosCode-ejercicio1`,
   o como la renombres) dentro de `C:\xampp\htdocs\`. Por ejemplo:
   `C:\xampp\htdocs\mycar\`.

2. **Importar la base de datos**: abrí phpMyAdmin
   (`http://localhost/phpmyadmin`), creá una pestaña **Importar** y
   seleccioná el archivo `database/BD-topicos2.sql`. Esto crea la base
   `mycar_db` con sus tablas y datos de ejemplo (no es necesario crear la
   base manualmente, el script la crea por su cuenta).

3. **Verificar la URL base**: abrí el archivo `.env` en la raíz del
   proyecto y revisá la línea:

   ```
   app.baseURL = 'http://localhost/mycar/public/'
   ```

   Si copiaste el proyecto con otro nombre de carpeta (no `mycar`), cambiá
   esa línea para que coincida. Por ejemplo, si la carpeta se llama
   `topicosCode-ejercicio1`, debería quedar:

   ```
   app.baseURL = 'http://localhost/topicosCode-ejercicio1/public/'
   ```

4. **Verificar los datos de conexión a la base** (también en `.env`,
   ya configurados para XAMPP por defecto, normalmente no hace falta
   tocarlos):

   ```
   database.default.hostname = localhost
   database.default.database = mycar_db
   database.default.username = root
   database.default.password =
   ```

5. **Acceder a la aplicación** desde el navegador, en la URL que
   configuraste en `app.baseURL` (ej: `http://localhost/mycar/public/`).

## Usuarios de prueba

| Rol           | Usuario  | Contraseña  |
|---------------|----------|-------------|
| Administrador | `admin`  | `admin123`  |
| Cliente       | `jperez` | `cliente123`|

También se puede crear una cuenta de cliente nueva desde la pantalla de
login, opción **"Registrate como cliente"**.

## Funcionalidad implementada

- **Login** con roles Administrador / Cliente, y **registro** de nuevos
  clientes.
- **Mostrar**:
  - Listado de vehículos disponibles (ambos roles).
  - Alquileres vigentes, con los datos del cliente (admin).
  - Historial completo de alquileres (admin).
  - Búsqueda de alquileres dado un vehículo → clientes que lo alquilaron.
  - Búsqueda de alquileres dado un cliente → vehículos que alquiló.
  - Mis reservas y alquileres (cliente).
- **Alta**:
  - Registrar un vehículo nuevo (admin).
  - El cliente reserva un vehículo (fecha desde + cantidad de días); la
    reserva queda **pendiente**.
  - El administrador aprueba la reserva pendiente, lo que **registra el
    alquiler** automáticamente y marca el vehículo como no disponible.
- **Baja (lógica)**:
  - Dar de baja un vehículo o un cliente (no se borran datos, se
    conserva el historial; un cliente de baja no puede iniciar sesión).
  - Registrar la devolución de un alquiler (el vehículo vuelve a estar
    disponible).
- **Modificación**:
  - Editar los datos de un vehículo o de un cliente.

## Estructura relevante

```
app/Controllers/   Auth, Home, Vehiculos, Clientes, Reservas, Alquileres
app/Models/        UsuarioModel, ClienteModel, VehiculoModel, ReservaModel, AlquilerModel
app/Filters/        AuthFilter, AdminFilter, ClienteFilter (control de acceso por rol)
app/Views/          insider/ (layout + panel cliente), admin/, login/, vehiculos/, clientes/, reservas/, alquileres/
database/           BD-topicos2.sql (script de creación + datos de ejemplo)
public/assets/      CSS y JS propios (sin dependencias externas)
```

## Notas de diseño

- Las bajas son **lógicas** (columna `estado`), nunca se elimina un
  registro físicamente, para conservar el historial de alquileres.
- Las contraseñas se guardan con `password_hash` (bcrypt).
- La interfaz usa una paleta oscura y minimalista (gris/negro), sin
  imágenes externas ni librerías de JavaScript.
