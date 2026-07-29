# Supply Transport S.A.C. — Sistema Web-Admin.

Sistema de administración web para la empresa peruana de logística y transporte **Supply Transport S.A.C.** Reemplaza la versión anterior (sitio estático en GitHub Pages) por una aplicación funcional con panel de administración, base de datos, y exportación/respaldo de información.

> Versión: **1.0** · Ver [ROADMAP.md](ROADMAP.md) para el plan hacia la versión 2.0.


## 1. Stack tecnológico

| Capa | Tecnología |
|---|---|
| Backend | PHP 8.3 (arquitectura MVC propia, sin dependencias externas de Composer) |
| Frontend | HTML5 + CSS3 + JavaScript + Bootstrap 5 + Font Awesome 6 |
| Base de datos | SQLite (local, sin configuración) / MySQL (producción) |
| Exportación | Excel (CSV compatible con acentos) y PDF (vista imprimible del navegador) |
| Respaldo | Archivo `.zip` con la base de datos + Excel de cada tabla |
| Reportes opcionales | Python 3 (script de resumen desde la base de datos) |

Esta v1 se construyó en PHP plano con una estructura de carpetas inspirada en Laravel (Controladores, Modelos, Vistas, Rutas por `index.php`) para que sea 100% gratuita de correr en cualquier hosting compartido sin necesitar Composer ni acceso a internet durante la instalación. Migrar a Laravel real es el primer punto del roadmap de la v2 una vez el hosting definitivo tenga soporte de Composer/SSH.

## 2. Capturas de las pantallas principales
- Login
- Panel de control con indicadores
- CRUD de Operativos (crear, editar, eliminar, exportar)
- CRUD de Envíos (con asignación de operativo)

## 3. Estructura de carpetas (en español)

```
supply-transport/
├── app/
│   ├── Controladores/       # Lógica de cada módulo (autenticación, operativos, envíos)
│   └── Modelos/             # Acceso a datos (una clase por tabla)
├── baseDatos/
│   ├── esquema.sql          # Esquema para SQLite (local)
│   ├── esquema_mysql.sql    # Esquema para MySQL (producción)
│   └── respaldos/           # Aquí se guardan los .zip generados por el botón "Respaldo"
├── config/
│   └── conexion.php         # Conexión única a la base de datos (SQLite o MySQL según .env)
├── recursos/
│   └── vistas/
│       ├── autenticacion/   # Vista de login
│       ├── panel/           # Panel, CRUDs y vista imprimible de reportes
│       └── compartido/      # Cabecera y pie reutilizados en todas las vistas
├── publico/                 # Raíz pública del servidor (document root)
│   ├── index.php            # Enrutador principal
│   ├── exportar.php         # Exportación a Excel / PDF
│   ├── respaldo_generar.php # Generación del respaldo .zip
│   ├── css/estilos.css
│   └── js/panel.js
├── scripts_python/
│   └── generar_reporte.py   # Script opcional de resumen (no requerido para que la app funcione)
├── pruebas/                  # Carpeta reservada para pruebas automatizadas futuras
├── .env.example
├── inicializar_bd.php        # Crea la base de datos y datos de ejemplo
├── README.md
└── ROADMAP.md
```

## 4. Instalación en local

Requisitos: PHP 8.1+ con extensiones `pdo_sqlite` y `zip` (vienen activadas por defecto en la mayoría de instalaciones, incluido XAMPP/Laragon).

```bash
# 1. Clonar el repositorio
git clone https://github.com/sjhonn/supply-transport.git
cd supply-transport

# 2. Copiar el archivo de entorno
cp .env.example .env

# 3. Inicializar la base de datos (crea tablas + usuario admin + datos de ejemplo)
php inicializar_bd.php

# 4. Levantar el servidor de desarrollo de PHP
php -S localhost:8000 -t publico
```

Abrir **http://localhost:8000/index.php?r=login**

Usuario de prueba:
- Correo: `admin@supplytransport.pe`
- Clave: `admin123`

## 5. Despliegue en producción (hosting gratuito)

1. Elegir un hosting con PHP 8+ y MySQL gratuito (ej. InfinityFree, GoogieHost) o un plan gratuito con soporte Docker (Railway, Render) si se prefiere más control.
2. Subir todo el contenido del repositorio; configurar el **document root del hosting apuntando a la carpeta `publico/`** (por seguridad, el resto del código no debe quedar accesible públicamente).
3. Crear una base de datos MySQL desde el panel del hosting y ejecutar `baseDatos/esquema_mysql.sql`.
4. Crear el archivo `.env` en la raíz (no en `publico/`) con:
   ```
   DB_CONEXION=mysql
   DB_HOST=host_que_te_da_tu_hosting
   DB_NOMBRE=nombre_de_tu_bd
   DB_USUARIO=usuario_de_tu_bd
   DB_CLAVE=clave_de_tu_bd
   ```
5. Ejecutar una vez `inicializar_bd.php` (por navegador o SSH) para crear el usuario administrador.
6. Verificar que la carpeta `baseDatos/respaldos/` tenga permisos de escritura (`chmod 775`).

## 6. Funcionalidades v1

- Autenticación con sesiones y contraseñas cifradas (`password_hash`).
- CRUD de Operativos (nombre, teléfono, placa, estado).
- CRUD de Envíos (cliente, origen, destino, operativo asignado, estado).
- Exportación a Excel (.csv compatible, con tildes/ñ correctas) y a PDF (vista imprimible lista para "Guardar como PDF").
- Respaldo completo del sistema en un solo `.zip` (base de datos + Excel de cada tabla).
- Interfaz 100% responsive con Bootstrap 5 y Font Awesome.

## 7. Roadmap

El plan detallado de mejoras hacia la versión 2.0 (notificaciones, tiempo real, migración a Laravel completo, reportes en Python, PWA) está en [ROADMAP.md](ROADMAP.md).

## 8. Licencia y autor

Proyecto de uso interno de **Supply Transport S.A.C.** Mantenido por [@sjhonn](https://github.com/sjhonn).
