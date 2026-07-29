# Roadmap de Modernización — Supply Transport S.A.C.

> Repositorio base: `sjhonn/supply-transport` (actualmente sitio estático HTML/CSS/JS + Supabase, publicado en GitHub Pages).
> Objetivo: pasar de una página estática a una aplicación web completa (frontend + backend + base de datos), responsive, funcional en local y en producción, gratuita, y con todo el proyecto (carpetas, archivos, README) en español.

---

## 1. Diagnóstico del repositorio actual

Estructura detectada hoy:

```
supply-transport/
├── assets/images/
├── css/
├── data/
├── js/
├── supabase/
├── admin.html
├── dashboard.html
├── index.html
├── login.html
└── README.md
```

Es un sitio 100% estático (HTML/CSS/JS) que usa Supabase como backend-as-a-service. No hay PHP, Laravel, Node.js ni Python todavía.

## 2. Aclaración importante sobre el stack pedido

Pediste PHP, Laravel, Node.js, Python y Bootstrap 5 todos juntos. En un proyecto real no se mezclan varios backends a la vez (cada uno maneja su propia base de datos, sesiones y despliegue, y eso duplica trabajo y complica el hosting gratuito). Lo que sí es una práctica normal y muy usada es:

| Capa | Tecnología | Rol |
|---|---|---|
| **Backend principal** | **Laravel (PHP)** | API + panel admin + lógica de negocio + exportación Excel/PDF + base de datos |
| **Frontend** | HTML + CSS + JS + **Bootstrap 5** + **Font Awesome** | Interfaz pública y panel admin, responsive |
| **Base de datos** | **MySQL** (o MariaDB) | Datos de operativos, clientes, envíos, usuarios |
| **Scripts auxiliares (opcional)** | **Python** | Reportes/analítica pesada, limpieza de datos, tareas programadas (cron) fuera del ciclo web |
| **Servicios en tiempo real (opcional, v2)** | **Node.js** | Notificaciones push / websockets si se necesita mapa en vivo |

Laravel hace de "columna vertebral": sirve el HTML con Blade, expone una API, y ya integra Bootstrap 5 y Font Awesome en el frontend. Node.js y Python quedan como **piezas opcionales de la v2**, no como bases paralelas. Esto evita duplicar autenticación y base de datos.

Nota: dijiste "Laragol v6" — asumo que es un error de tipeo y te refieres a **Laravel**. La versión estable recomendada hoy es **Laravel 11** (LTS activo); Laravel 6 ya no recibe soporte de seguridad, así que no es recomendable partir de ahí.

## 3. Estructura de carpetas propuesta (todo en español)

```
supply-transport/
├── app/
│   ├── Http/
│   │   ├── Controladores/
│   │   └── Middleware/
│   ├── Modelos/
│   └── Servicios/
│       ├── ExportadorExcel.php      // un único comentario: exporta datos a .xlsx usando Laravel Excel
│       └── ExportadorPdf.php        // un único comentario: genera reportes PDF con DomPDF
├── baseDatos/
│   ├── migraciones/
│   ├── semillas/
│   └── respaldos/                   // aquí se guardan los .sql, .xlsx y .pdf de backup
├── config/
├── publico/
│   ├── css/
│   ├── js/
│   ├── imagenes/
│   └── index.php
├── recursos/
│   ├── vistas/
│   │   ├── autenticacion/
│   │   │   └── login.blade.php
│   │   ├── panel/
│   │   │   ├── panel.blade.php
│   │   │   └── administracion.blade.php
│   │   └── publico/
│   │       └── inicio.blade.php
│   └── js/
├── rutas/
│   ├── web.php
│   └── api.php
├── scripts_python/
│   └── generar_reporte.py           // un único comentario: script opcional para reportes programados
├── pruebas/
├── .env.example
├── README.md
└── ROADMAP.md
```

Traducción de conceptos Laravel → carpeta en español (mapeo, para que quien mantenga el proyecto sepa dónde va cada cosa):

- `app/Http/Controllers` → `app/Http/Controladores`
- `app/Models` → `app/Modelos`
- `resources/views` → `recursos/vistas`
- `routes` → `rutas`
- `public` → `publico`
- `database` → `baseDatos`
- `tests` → `pruebas`

(Laravel permite renombrar namespaces/carpetas vía `composer.json` y el `AppServiceProvider`; esto se deja como tarea técnica de la v1, punto 4.2.)

## 4. Roadmap — Versión 1.0

**Meta de la v1: migrar de estático a Laravel funcional, responsive, con CRUD y base de datos, corriendo en local y en producción gratuita.**

### 4.1 Preparación (semana 1)
- Instalar Laravel 11 + Composer + Node (solo para compilar assets con Vite).
- Configurar MySQL local (XAMPP/Laragon) y `.env.example`.
- Migrar diseño actual (Bootstrap 5 + Font Awesome) a `recursos/vistas` con Blade.

### 4.2 Estructura y traducción al español (semana 1-2)
- Renombrar carpetas según la tabla del punto 3.
- Ajustar `composer.json` (autoload PSR-4) y providers para que el namespace en español funcione sin romper Laravel.
- Un único comentario explicativo por archivo clave (controlador, modelo, servicio).

### 4.3 Autenticación y roles (semana 2)
- Login con Laravel Breeze/Fortify (reemplaza `login.html`).
- Roles: Administrador / Operativo (reemplaza lógica actual de `admin.html` y `dashboard.html`).

### 4.4 CRUD principal (semana 3-4)
- CRUD de Administrador.
- CRUD de Operativo.
- CRUD de Clientes / Envíos / Transporte.
- Gestión de mapas por operativo (Leaflet + Google Maps API, capa gratuita).

### 4.5 Importación / Exportación (semana 4-5)
- Exportar a Excel: paquete `maatwebsite/laravel-excel`.
- Exportar a PDF: paquete `barryvdh/laravel-dompdf`.
- Importar desde Excel (carga masiva de operativos/envíos).
- Respaldo de base de datos: comando Artisan (`php artisan backup:run`) que genera `.sql` + copia `.xlsx`/`.pdf` en `baseDatos/respaldos/`.

### 4.6 Responsive y UI (semana 5)
- Bootstrap 5 grid + componentes; Font Awesome para iconografía.
- Revisión en móvil/tablet/desktop.

### 4.7 Despliegue gratuito (semana 6)
- **Local:** Laragon/XAMPP + MySQL.
- **Producción gratuita recomendada:** InfinityFree o GoogieHost (PHP 8+, MySQL, cPanel) para hosting compartido gratuito; alternativa con mejor estabilidad de por vida gratis limitada: Railway o Render en plan free con contenedor Docker si se prefiere control total.
- Documentar variables de entorno de producción.
- README.md v1 completo (instalación local, instalación en producción, capturas).

**Entregable v1:** Laravel + MySQL + Bootstrap 5 + Font Awesome, CRUD completo, import/export Excel y PDF, backup a SQL/Excel/PDF, 100% responsive, todo en español, corriendo en local y en un hosting gratuito real.

## 5. Roadmap — Versión 2.0

**Meta de la v2: features avanzadas, tiempo real, automatización y reportes.**

| Módulo | Detalle |
|---|---|
| Confirmación por correo | Laravel Notifications + Mailtrap/Gmail SMTP gratuito |
| Mensajería automática | Colas (Queues) con `database` driver, sin necesidad de Redis de pago |
| Notificaciones al sistema | Laravel Echo + Node.js (Socket.io) para notificaciones en vivo — aquí sí entra Node.js, como servicio aparte |
| Reportes avanzados | Scripts Python (pandas) para analítica de envíos, ejecutados por cron y expuestos como endpoint que Laravel consume |
| Mapa en tiempo real multi-operativo | WebSockets + Leaflet, actualización en vivo de posición |
| Panel de auditoría | Historial de cambios (Laravel Auditing) |
| PWA | Convertir el panel en Progressive Web App para uso desde celular sin instalar app |
| CI/CD gratuito | GitHub Actions para pruebas automáticas antes de desplegar |

## 6. Buenas prácticas a mantener en ambas versiones
- Un solo comentario aclaratorio por archivo (no bloques de comentarios de diseño repetidos).
- Nombres de carpetas, rutas y variables de vista en español; nombres técnicos internos de Laravel (los que el framework exige, como `Controller`, `Model` base) se mantienen en inglés solo donde el framework lo requiera.
- `.env` nunca se sube al repo; solo `.env.example`.
- Backups programados semanalmente (Artisan Scheduler) a `baseDatos/respaldos/`.

## 7. Estructura sugerida del nuevo README.md
1. Nombre y descripción de la empresa/proyecto.
2. Capturas de pantalla.
3. Stack tecnológico (tabla igual a la del punto 2).
4. Instalación en local (paso a paso, comandos).
5. Instalación/despliegue en producción gratuita.
6. Estructura de carpetas (árbol en español).
7. Funcionalidades (CRUD, exportación, backups).
8. Roadmap resumido (link a este archivo).
9. Licencia y autor.

---

¿Quieres que arranque ya con el **README.md real en español** siguiendo esta estructura, o prefieres que primero te arme el **esqueleto del proyecto Laravel** con las carpetas ya renombradas?
