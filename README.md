# Bienes Raíces

Una aplicación web completa para la gestión de bienes raíces construida con Laravel. Permite a los vendedores gestionar sus propiedades, y a los usuarios explorar y contactar sobre propiedades disponibles.

## Características Principales

### Backend (Laravel)
- **Gestión de Usuarios**: Sistema de autenticación completo con roles de usuario y vendedor
- **Gestión de Propiedades**: CRUD completo para propiedades inmobiliarias
- **Gestión de Vendedores**: Panel de administración para vendedores
- **API RESTful**: Endpoints para integración con frontend
- **Base de Datos**: Migraciones y seeders para configuración inicial

### Frontend (JavaScript)
- **Modo Oscuro (Dark Mode)**:
  - Detecta la preferencia del sistema del usuario (`prefers-color-scheme`)
  - Permite al usuario cambiar manualmente entre modo claro y oscuro con un botón
  - Guarda la preferencia del usuario en `localStorage` para mantener la consistencia entre visitas

- **Navegación Responsiva**:
  - Implementa un menú de tipo "hamburguesa" para dispositivos móviles que despliega la navegación principal
  - Es accesible, actualizando el estado `aria-expanded` para lectores de pantalla

- **Formulario de Contacto Dinámico**:
  - Muestra campos de formulario condicionales basados en el método de contacto seleccionado por el usuario (Teléfono o Email)

- **Efectos de Scroll**:
  - Añade un efecto visual a la barra de navegación cuando el usuario se desplaza hacia abajo en la página, cambiando su estilo para una mejor visibilidad

- **Notificaciones con Autocierre**:
  - Las alertas o notificaciones aparecen con una animación suave y se ocultan y eliminan automáticamente después de 5 segundos

- **Mejoras de UI**:
  - Cierra automáticamente los menús desplegables (dropdowns) cuando el usuario hace clic fuera de ellos, mejorando la usabilidad

## Requisitos del Sistema

- **PHP**: ^8.2
- **Laravel**: ^12.0
- **Node.js**: Para compilación de assets
- **Composer**: Para gestión de dependencias PHP
- **Base de Datos**: MySQL, PostgreSQL o SQLite

## Instalación

1. **Clona el repositorio**:
   ```bash
   git clone <url-del-repositorio>
   cd bienes_raices_laravel
   ```

2. **Instala las dependencias de PHP**:
   ```bash
   composer install
   ```

3. **Instala las dependencias de JavaScript**:
   ```bash
   npm install
   ```

4. **Configura el archivo de entorno**:
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

5. **Configura la base de datos** en el archivo `.env`:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=bienes_raices
   DB_USERNAME=tu_usuario
   DB_PASSWORD=tu_contraseña
   ```

6. **Ejecuta las migraciones**:
   ```bash
   php artisan migrate
   ```

7. **Ejecuta los seeders** (opcional, para datos de prueba):
   ```bash
   php artisan db:seed
   ```

8. **Compila los assets**:
   ```bash
   npm run build
   # O para desarrollo con hot reload:
   npm run dev
   ```

9. **Inicia el servidor**:
   ```bash
   php artisan serve
   ```

## Uso

### Desarrollo
Para ejecutar la aplicación en modo desarrollo con todos los servicios:
```bash
composer run dev
```

Esto iniciará:
- Servidor de Laravel en `http://localhost:8000`
- Cola de trabajos
- Vite para compilación de assets con hot reload

### Producción
```bash
npm run build
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

## Estructura del Proyecto

```
bienes_raices_laravel/
├── app/                          # Código de la aplicación Laravel
│   ├── Http/Controllers/         # Controladores
│   ├── Models/                   # Modelos Eloquent
│   └── View/Components/          # Componentes de Blade
├── bootstrap/                    # Archivos de arranque
├── config/                       # Archivos de configuración
├── database/                     # Migraciones, factories y seeders
├── public/                       # Assets públicos e imágenes
├── resources/                    # Vistas, CSS, JS y SCSS
│   ├── js/                       # JavaScript
│   ├── scss/                     # SCSS
│   ├── views/                    # Vistas Blade
│   └── lang/                     # Archivos de idioma
├── routes/                       # Definición de rutas
├── storage/                      # Archivos temporales y logs
├── tests/                        # Pruebas
└── vendor/                       # Dependencias de Composer
```

## Tecnologías Utilizadas

### Backend
- **Laravel 12**: Framework PHP
- **PHP 8.2+**: Lenguaje de programación
- **MySQL/PostgreSQL/SQLite**: Base de datos
- **Blade**: Motor de plantillas

### Frontend
- **JavaScript (ES6+)**: Lógica del cliente
- **SCSS**: Preprocesador CSS
- **Vite**: Bundler y herramienta de desarrollo
- **Alpine.js**: Framework JavaScript ligero (si se usa)

### Herramientas de Desarrollo
- **Composer**: Gestión de dependencias PHP
- **NPM**: Gestión de dependencias JavaScript
- **Pest**: Framework de pruebas
- **Laravel Pint**: Formateador de código

## Scripts Disponibles

### Composer Scripts
- `composer run dev`: Inicia todos los servicios de desarrollo
- `composer run test`: Ejecuta las pruebas

### NPM Scripts
- `npm run dev`: Compilación de assets con hot reload
- `npm run build`: Compilación de assets para producción

## Contribuciones

1. Fork el proyecto
2. Crea una rama para tu feature (`git checkout -b feature/AmazingFeature`)
3. Commit tus cambios (`git commit -m 'Add some AmazingFeature'`)
4. Push a la rama (`git push origin feature/AmazingFeature`)
5. Abre un Pull Request

## Licencia

Este proyecto está bajo la Licencia MIT. Ver el archivo `LICENSE` para más detalles.

## Soporte

Si encuentras algún problema o tienes preguntas, por favor abre un issue en el repositorio o contacta al equipo de desarrollo.

---

**Nota**: Este proyecto está en desarrollo activo. Las características pueden cambiar sin previo aviso.
