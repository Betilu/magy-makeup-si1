# Guía de Despliegue en Render con Docker

## 📋 Prerequisitos

1. Cuenta en [Render.com](https://render.com)
2. Repositorio Git con tu proyecto (GitHub, GitLab, o Bitbucket)
3. Credenciales de Stripe configuradas

## 🚀 Pasos para Desplegar

### 1. Preparar el Repositorio

Asegúrate de que estos archivos estén en tu repositorio:
- ✅ `Dockerfile`
- ✅ `docker/nginx.conf`
- ✅ `docker/supervisord.conf`
- ✅ `docker/entrypoint.sh`
- ✅ `.dockerignore`
- ✅ `render.yaml`

### 2. Commit y Push

```bash
git add .
git commit -m "Add Docker configuration for Render deployment"
git push origin main
```

### 3. Configurar en Render

#### Opción A: Usando Blueprint (render.yaml)

1. Ve a [Render Dashboard](https://dashboard.render.com/)
2. Haz clic en "New +" → "Blueprint"
3. Conecta tu repositorio
4. Render detectará automáticamente el archivo `render.yaml`
5. Revisa la configuración y haz clic en "Apply"

#### Opción B: Configuración Manual

##### Crear Base de Datos:
1. Click en "New +" → "MySQL"
2. Nombre: `magy-makeup-db`
3. Database: `magy_make_up`
4. User: `magy_user`
5. Plan: Selecciona según tus necesidades
6. Crea la base de datos

##### Crear Web Service:
1. Click en "New +" → "Web Service"
2. Conecta tu repositorio
3. Configuración:
   - **Name**: `magy-makeup-app`
   - **Environment**: `Docker`
   - **Region**: Oregon (o el que prefieras)
   - **Branch**: `main` (o tu rama principal)
   - **Dockerfile Path**: `./Dockerfile`

### 4. Configurar Variables de Entorno

En el Web Service, ve a "Environment" y agrega:

#### Variables Obligatorias:
```
APP_NAME=MagyMakeup
APP_ENV=production
APP_DEBUG=false
LOG_CHANNEL=stderr
LOG_LEVEL=info

# Database (Render las completará automáticamente si usas blueprint)
DB_CONNECTION=mysql
DB_HOST=[desde la base de datos]
DB_PORT=3306
DB_DATABASE=magy_make_up
DB_USERNAME=[desde la base de datos]
DB_PASSWORD=[desde la base de datos]

# Session & Cache
SESSION_DRIVER=database
CACHE_STORE=database
QUEUE_CONNECTION=database

# Stripe
STRIPE_KEY=tu_clave_publica_stripe
STRIPE_SECRET=tu_clave_secreta_stripe
STRIPE_WEBHOOK_SECRET=tu_webhook_secret_stripe

# Mail (configura según tu proveedor)
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=tu_username
MAIL_PASSWORD=tu_password
```

#### Variables Generadas Automáticamente:
- `APP_KEY` - Render puede generarla automáticamente
- `APP_URL` - Se asigna automáticamente con la URL de tu servicio

### 5. Configurar el Health Check

En "Settings" del Web Service:
- **Health Check Path**: `/`

### 6. Deploy

1. Haz clic en "Manual Deploy" → "Deploy latest commit"
2. Espera a que el build complete (puede tomar 5-10 minutos la primera vez)
3. Verifica los logs para asegurarte de que todo esté correcto

## 🔧 Post-Deployment

### Ejecutar Migraciones

Si no configuraste las migraciones automáticas en el entrypoint, puedes ejecutarlas manualmente:

1. Ve a tu Web Service en Render
2. Click en "Shell" en el menú lateral
3. Ejecuta:
```bash
php artisan migrate --force
php artisan db:seed --force
```

### Configurar Webhooks de Stripe

1. En tu [Dashboard de Stripe](https://dashboard.stripe.com/webhooks)
2. Agrega un nuevo endpoint: `https://tu-app.onrender.com/stripe/webhook`
3. Selecciona los eventos que necesites
4. Copia el signing secret y actualiza `STRIPE_WEBHOOK_SECRET` en Render

## 📊 Monitoreo

- **Logs**: Accesibles desde el dashboard de Render
- **Metrics**: CPU, memoria y tráfico disponibles en la pestaña "Metrics"
- **Health Checks**: Render monitoreará automáticamente tu aplicación

## 🐛 Troubleshooting

### Error: "Failed to read dockerfile"
- Verifica que todos los archivos en `docker/` existan
- Asegúrate de que `entrypoint.sh` tenga permisos de ejecución

### Error: "Database connection refused"
- Verifica que las variables de entorno de la base de datos estén correctas
- Asegúrate de que la base de datos esté en la misma región que el web service

### Error 500 después del deploy
- Revisa los logs: `docker logs` en la consola de Render
- Verifica que `APP_KEY` esté configurada
- Confirma que las migraciones se hayan ejecutado

### Assets no cargan
- Verifica que `npm run build` se ejecute correctamente
- Revisa que los archivos estén en `/public/build`

## 💡 Optimizaciones

### Reducir tiempo de build:
1. Usa Docker layer caching (disponible en planes pagados)
2. Optimiza el `.dockerignore`

### Mejorar performance:
1. Considera usar Redis para cache y sessions (requiere plan adicional)
2. Configura un CDN para assets estáticos

### Costos:
- **Plan Starter**: Ideal para desarrollo/staging
- **Plan Standard**: Recomendado para producción
- La base de datos MySQL tiene costos separados

## 🔗 Enlaces Útiles

- [Documentación de Render](https://render.com/docs)
- [Render con Laravel](https://render.com/docs/deploy-laravel)
- [Docker en Render](https://render.com/docs/docker)
- [Variables de Entorno](https://render.com/docs/environment-variables)

## 🆘 Soporte

Si encuentras problemas:
1. Revisa los logs en Render Dashboard
2. Consulta la documentación oficial
3. Contacta a soporte de Render desde el dashboard
