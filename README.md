# 🏢 Condominio San Diego — Sistema de Gestión v2.0

Sistema web desarrollado con **Laravel 11** para la gestión integral de un condominio residencial.

## ✨ Mejoras de la versión 2.0

- **UI/UX completamente rediseñada**: panel oscuro moderno, KPIs en tiempo real, badges de estado consistentes
- **Campana de notificaciones** en la barra superior con contador de no leídas
- **Avatar de usuario** con inicial en color, menú desplegable mejorado
- **Página de login** rediseñada con show/hide password y feedback visual
- **Botones de confirmación SweetAlert2** en todas las eliminaciones (sin modales anidados en tablas)
- **Filtros mejorados** con filtro por prioridad en incidencias, leída/no leída en notificaciones
- **Paginación estilizada** consistente en todas las tablas
- **Empty states** descriptivos en tablas vacías
- **Alertas de sesión** unificadas via SweetAlert2 toast
- **CSS custom.css**: variables CSS, tokens de color, badges de estado reutilizables
- **Bootstrap 5.3.3** actualizado (desde 5.2.3)
- **Layout unificado**: todas las vistas ahora extienden `plantilla`
- **BitacoraController**: filtros por usuario, acción y rango de fechas
- **ResidenteController**: filtro por tipo y búsqueda mejorada
- **IncidenciaController**: filtro por prioridad
- **NotificacionController**: filtro por estado leída/no leída

## 📦 Paquetes y Casos de Uso

| Paquete | CUs | Descripción |
|---------|-----|-------------|
| PKG 1 | CU1, CU2, CU3, CU4 | Acceso y Seguridad |
| PKG 2 | CU5, CU6, CU13, CU20 | Personas y Estructura |
| PKG 3 | CU7, CU8, CU9, CU10, CU15, CU16, CU17 | Gestión Operativa |
| PKG 4 | CU11, CU12, CU14, CU18, CU19 | Comunicación y Reportes |

## 🚀 Instalación

```bash
# 1. Clonar el proyecto
git clone <url> condominio-san-diego
cd condominio-san-diego

# 2. Instalar dependencias
composer install
npm install

# 3. Configurar entorno
cp .env.example .env
php artisan key:generate

# 4. Configurar base de datos en .env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=condominio_sa
DB_USERNAME=root
DB_PASSWORD=

# 5. Migrar y sembrar
php artisan migrate --seed

# 6. Compilar assets
npm run build

# 7. Servir
php artisan serve
```

## 👥 Usuarios por defecto

| Email | Contraseña | Rol |
|-------|-----------|-----|
| admin@admin.com | password | ADMINISTRADOR |
| guardia@condominio.com | password | PORTERO |
| residente@condominio.com | password | RESIDENTE |

## 🛠️ Stack Tecnológico

- **Backend**: Laravel 11, PHP 8.2+
- **Frontend**: Bootstrap 5.3, SweetAlert2, FontAwesome 6
- **Auth**: Spatie Laravel-Permission
- **Pagos**: Stripe, QR Code
- **PDFs**: Barryvdh/laravel-dompdf
- **DB**: MySQL / SQLite

## 📁 Estructura relevante

```
app/
├── Http/Controllers/   # 20+ controladores de CU
├── Models/             # Modelos Eloquent
├── Traits/BitacoraTrait.php
resources/views/
├── plantilla.blade.php     # Layout principal
├── components/             # Header, Menú, Footer
├── panel/index.blade.php   # Dashboard con KPIs
└── */index|create|edit|show.blade.php
public/
└── css/custom.css          # Estilos mejorados v2.0
```
