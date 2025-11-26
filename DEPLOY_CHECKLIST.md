# ✅ Checklist de Verificación para Deploy en Render

## Archivos Docker Creados
- [x] `Dockerfile` - Configuración principal de Docker
- [x] `docker/nginx.conf` - Configuración de Nginx
- [x] `docker/supervisord.conf` - Configuración de Supervisor
- [x] `docker/entrypoint.sh` - Script de inicio
- [x] `.dockerignore` - Archivos a excluir de la imagen

## Configuración de Render
- [x] `render.yaml` - Blueprint de Render (configuración automática)
- [x] `DEPLOY_RENDER.md` - Guía completa de despliegue

## Antes de Desplegar

### 1. Verificar archivos esenciales
```bash
# Verifica que estos archivos existan:
- [ ] .env.example está actualizado
- [ ] composer.json tiene todas las dependencias
- [ ] package.json está completo
- [ ] Las migraciones están en database/migrations/
```

### 2. Preparar el repositorio Git
```bash
# Ejecuta estos comandos:
git add .
git commit -m "Configure Docker for Render deployment"
git push origin main
```

### 3. Configuración en Render.com

#### Variables de Entorno Críticas:
```
- [ ] APP_KEY (generar nueva para producción)
- [ ] DB_HOST, DB_PORT, DB_DATABASE, DB_USERNAME, DB_PASSWORD
- [ ] STRIPE_KEY (clave pública)
- [ ] STRIPE_SECRET (clave secreta)
- [ ] STRIPE_WEBHOOK_SECRET
- [ ] MAIL_* (configuración de correo)
```

#### Configuración de la Base de Datos:
```
- [ ] Crear base de datos MySQL en Render
- [ ] Nombre: magy-makeup-db
- [ ] Database: magy_make_up
- [ ] Region: Misma que el web service
```

#### Configuración del Web Service:
```
- [ ] Tipo: Docker
- [ ] Dockerfile Path: ./Dockerfile
- [ ] Health Check Path: /
- [ ] Auto-Deploy: Activado
```

### 4. Post-Deployment

```bash
# Después del primer deploy, ejecuta en la Shell de Render:
- [ ] php artisan migrate --force
- [ ] php artisan db:seed --force (si tienes seeders)
- [ ] php artisan storage:link
```

### 5. Configurar Webhooks de Stripe

```
- [ ] Ir a Dashboard de Stripe → Webhooks
- [ ] Agregar endpoint: https://tu-app.onrender.com/stripe/webhook
- [ ] Copiar signing secret
- [ ] Actualizar STRIPE_WEBHOOK_SECRET en Render
```

### 6. Verificación Final

```
- [ ] La aplicación carga correctamente
- [ ] El login funciona
- [ ] La conexión a la base de datos funciona
- [ ] Los assets (CSS/JS) cargan correctamente
- [ ] Las rutas principales funcionan
- [ ] Los pagos de Stripe funcionan
- [ ] Los emails se envían correctamente
```

## 🚨 Problemas Comunes

### Build falla
- Verifica los logs en Render
- Asegúrate de que todos los archivos en `docker/` existan
- Confirma que las dependencias en composer.json sean correctas

### Aplicación no inicia
- Verifica que APP_KEY esté configurada
- Revisa las variables de entorno de la base de datos
- Chequea los logs de Supervisor

### Error 500
- Verifica APP_DEBUG=false en producción
- Confirma que las migraciones se ejecutaron
- Revisa los logs: php artisan log:clear y luego reproduce el error

### Assets no cargan
- Verifica que `npm run build` se ejecutó correctamente
- Confirma que los archivos estén en `/public/build`
- Revisa la configuración de Vite en `vite.config.js`

## 📝 Notas Importantes

1. **Primera vez**: El build puede tardar 5-10 minutos
2. **Variables sensibles**: Nunca comitees el archivo `.env` real
3. **APP_KEY**: Genera una nueva para producción (no uses la de desarrollo)
4. **Logs**: Usa LOG_CHANNEL=stderr en producción para ver logs en Render
5. **Cache**: Render limpia la cache en cada deploy

## 🔄 Actualizaciones Futuras

Para actualizar tu aplicación:
```bash
git add .
git commit -m "Tu mensaje de commit"
git push origin main
```

Render detectará automáticamente el push y desplegará la nueva versión.

## 💰 Costos Estimados

- **Web Service (Starter)**: ~$7/mes
- **MySQL Database (Starter)**: ~$7/mes
- **Total aproximado**: ~$14/mes

Plans superiores ofrecen más recursos y características como:
- Más CPU y RAM
- Más conexiones a la base de datos
- Docker layer caching
- Priority support

## ✅ Todo Listo

Si completaste todos los items del checklist, tu aplicación debería estar funcionando en Render!

URL de tu aplicación: `https://magy-makeup-app.onrender.com` (o el nombre que elijas)

---

**¿Necesitas ayuda?**
- Documentación: https://render.com/docs
- Soporte: support@render.com
- Community: https://community.render.com
