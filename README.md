# 🏢 Condominio San Diego — Sistema de Gestión

![Laravel](https://img.shields.io/badge/Laravel-11-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)
![PHP](https://img.shields.io/badge/PHP-8.2+-777BB4?style=for-the-badge&logo=php&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-8.0-4479A1?style=for-the-badge&logo=mysql&logoColor=white)
![Bootstrap](https://img.shields.io/badge/Bootstrap-5.3-7952B3?style=for-the-badge&logo=bootstrap&logoColor=white)
![Tailwind](https://img.shields.io/badge/Tailwind-4-06B6D4?style=for-the-badge&logo=tailwindcss&logoColor=white)
![Vite](https://img.shields.io/badge/Vite-5-646CFF?style=for-the-badge&logo=vite&logoColor=white)
![License](https://img.shields.io/badge/License-MIT-green?style=for-the-badge)

Sistema web desarrollado con **Laravel 11** para la gestión integral de un condominio residencial: residentes, propiedades, unidades, cuotas, pagos, reservas de áreas comunes, incidencias, comunicados, visitas, inventario y más.

---

## ✨ Características principales

- **UI/UX rediseñada**: panel oscuro moderno, KPIs en tiempo real, badges de estado consistentes.
- **Campana de notificaciones** en la barra superior con contador de no leídas.
- **Avatar de usuario** con inicial en color y menú desplegable mejorado.
- **Login rediseñado** con show/hide password y feedback visual.
- **Confirmaciones SweetAlert2** en todas las eliminaciones.
- **Filtros avanzados**: por prioridad en incidencias, leídas/no leídas en notificaciones, rango de fechas en bitácora, tipo y búsqueda en residentes.
- **Paginación estilizada** y **empty states** descriptivos en todas las tablas.
- **Alertas de sesión** unificadas vía SweetAlert2 toast.
- **CSS custom** con variables, tokens de color y badges reutilizables.
- **Layout unificado**: todas las vistas extienden de `plantilla`.
- **Bitácora** de acciones con filtros por usuario, acción y fecha.


---

## 🛠️ Stack Tecnológico

| Capa | Tecnología |
|------|------------|
| **Backend** | PHP 8.2+ / Laravel 11 |
| **Frontend** | Blade + Bootstrap 5.3 + Tailwind CSS 4 + SASS + Vite 5 |
| **Base de Datos** | MySQL / SQLite |
| **Autenticación y Roles** | Spatie Laravel-Permission |
| **Panel Admin** | AdminLTE 3 |
| **PDF** | barryvdh/laravel-dompdf |
| **Pagos** | Stripe (modo test) |
| **Alertas UI** | SweetAlert2 |
| **Testing** | PHPUnit 11 |

---

## ✅ Requisitos Previos

| Herramienta | Versión Mínima |
|-------------|----------------|
| PHP | 8.2+ |
| Composer | 2.x |
| Node.js | 18+ |
| MySQL | 8.0+ (o SQLite para desarrollo) |
| Git | 2.40+ |

---

## 🚀 Instalación y Ejecución

### Paso 1 — Clonar el repositorio

```bash
git clone https://github.com/Rolandovs7/condominio.git
cd condominio
```

### Paso 2 — Instalar dependencias

```bash
composer install
npm install
```

### Paso 3 — Configurar entorno

```bash
cp .env.example .env
php artisan key:generate
```

Edita `.env` y configura la base de datos y las credenciales de Stripe:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=condominio_sa
DB_USERNAME=root
DB_PASSWORD=

STRIPE_KEY=pk_test_tu_clave_publica
STRIPE_SECRET=sk_test_tu_clave_secreta
STRIPE_WEBHOOK_SECRET=
```

### Paso 4 — Migrar y sembrar

```bash
php artisan migrate --seed
```

### Paso 5 — Compilar assets

```bash
npm run build
```

### Paso 6 — Levantar el servidor

```bash
php artisan serve
```

**Acceso:** http://127.0.0.1:8000

---

> ⚠️ Cambia estas credenciales en producción.

---

## 🧰 Comandos útiles

```bash
# Desarrollo con HMR de Vite
npm run dev

# Build de producción
npm run build

# Correr tests
vendor/bin/phpunit

# Formatear código (Laravel Pint)
vendor/bin/pint

# Limpiar cachés
php artisan optimize:clear
```

---

## 📁 Estructura relevante

```
app/
├── Http/
│   ├── Controllers/        # 20+ controladores por caso de uso
│   ├── Middleware/         # BitacoraMiddleware
│   └── Requests/           # Validaciones de formulario
├── Models/                 # Modelos Eloquent
├── Providers/
└── Traits/BitacoraTrait.php

config/                     # Configuración (app, auth, permission, adminlte…)
database/
├── factories/
├── migrations/             # 30+ migraciones
└── seeders/                # 20+ seeders

lang/
├── es/                     # Traducciones al español
└── vendor/adminlte/        # Traducciones de AdminLTE

public/
├── css/custom.css          # Estilos v2.0
└── images/

resources/
├── css/  js/  sass/
└── views/
    ├── plantilla.blade.php     # Layout principal
    ├── components/             # Header, Menú, Footer
    ├── panel/index.blade.php   # Dashboard con KPIs
    └── */index|create|edit|show.blade.php

routes/
├── web.php
└── console.php

storage/
└── logs/

tests/
├── Feature/
└── Unit/
```

---

## 🔒 Seguridad

- `.env` **nunca** se versiona.
- Stripe keys de prueba con placeholders en `.env.example`.
- Roles y permisos gestionados con **Spatie Laravel-Permission**.
- Bitácora de acciones de usuario (quién, qué, cuándo).
- Protección CSRF en todos los formularios.
- Validación de entrada con Form Requests.


---

## 👤 Autor

**Rolando Velasco Soliz**

---

## 📝 Licencia

Este proyecto está bajo la licencia **MIT**. Consulta el archivo `LICENSE` para más detalles.

---

⭐ Si este proyecto te resultó útil, dale una estrella en GitHub.