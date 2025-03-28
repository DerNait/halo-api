
# 📄 DEPLOY.md – Despliegue de HaloAPI con Laravel + Docker + PostgreSQL + Nginx + SSL

## 🧰 Requisitos del servidor

- Ubuntu (o distro con soporte Docker)
- Docker & Docker Compose instalados
- Acceso root o sudo
- Nginx instalado
- Certificado SSL configurado para el subdominio (en este caso: `haloapi.dernait.my`)

## 🚀 Pasos para el despliegue

### 1. Clonar el repositorio

```bash
cd /var/www/
git clone https://github.com/tu-usuario/tu-repo.git haloapi
cd haloapi
```

### 2. Configurar variables de entorno

```bash
cp .env.example .env
nano .env
```

Cambiar o verificar al menos:

```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://haloapi.dernait.my

DB_CONNECTION=pgsql
DB_HOST=db
DB_PORT=5432
DB_DATABASE=haloapi
DB_USERNAME=admin
DB_PASSWORD=12345
```

Agregar si no existen:

```env
APP_PORT=8080
DB_PORT_OUT=5432
```

### 3. Verificar `docker-compose.yml`

Debe usar `Dockerfile` y no tener volúmenes locales:

```yaml
  app:
    build:
      context: .
      dockerfile: Dockerfile
    ports:
      - "${APP_PORT}:8000"
    depends_on:
      - db
    environment:
      DB_CONNECTION: ${DB_CONNECTION}
      DB_HOST: ${DB_HOST}
      DB_PORT: ${DB_PORT}
      DB_DATABASE: ${DB_DATABASE}
      DB_USERNAME: ${DB_USERNAME}
      DB_PASSWORD: ${DB_PASSWORD}
```

### 4. Construir y levantar los contenedores

```bash
docker compose up --build -d
```

### 5. Verificar contenedores

```bash
docker ps
```

### 6. Correr migraciones y generar clave

```bash
docker compose exec app php artisan migrate
docker compose exec app php artisan config:cache
docker compose exec app php artisan key:generate
```

## 🌐 Configuración de Nginx con SSL (subdominio)

Archivo en: `/etc/nginx/sites-available/haloapi.dernait.my`

```nginx
server {
    listen 80;
    server_name haloapi.dernait.my;
    return 301 https://$host$request_uri;
}

server {
    listen 443 ssl;
    server_name haloapi.dernait.my;

    ssl_certificate /etc/ssl/certs/dernait.crt;
    ssl_certificate_key /etc/ssl/certs/dernait.key;

    ssl_protocols TLSv1.2 TLSv1.3;
    ssl_ciphers HIGH:!aNULL:!MD5;

    location / {
        proxy_pass http://127.0.0.1:8080;
        proxy_http_version 1.1;
        proxy_set_header Host $host;
        proxy_set_header X-Real-IP $remote_addr;
        proxy_set_header X-Forwarded-For $proxy_add_x_forwarded_for;
        proxy_set_header X-Forwarded-Proto $scheme;
    }
}
```

Activar el sitio:

```bash
sudo ln -s /etc/nginx/sites-available/haloapi.dernait.my /etc/nginx/sites-enabled/
sudo nginx -t
sudo systemctl reload nginx
```

## 🛠️ Comandos útiles

```bash
# Ver logs
docker compose logs -f app

# Reiniciar contenedores
docker compose restart

# Acceder al contenedor
docker compose exec app bash
```

## ✅ Acceso final

```
https://haloapi.dernait.my
```

🎉 ¡Tu API Laravel está en producción, servida con Docker y Nginx como un profesional!

## 📁 Configuración completa de Nginx

```nginx
server {
    listen 80;
    server_name haloapi.dernait.my;
    return 301 https://$host$request_uri;
}

server {
    listen 443 ssl;
    server_name haloapi.dernait.my;

    ssl_certificate /etc/ssl/certs/dernait.crt;
    ssl_certificate_key /etc/ssl/certs/dernait.key;

    ssl_protocols TLSv1.2 TLSv1.3;
    ssl_ciphers HIGH:!aNULL:!MD5;

    location / {
        proxy_pass http://127.0.0.1:8080;  # Laravel está mapeado al host por el puerto 8080
        proxy_http_version 1.1;
        proxy_set_header Host $host;
        proxy_set_header X-Real-IP $remote_addr;
        proxy_set_header X-Forwarded-For $proxy_add_x_forwarded_for;
        proxy_set_header X-Forwarded-Proto $scheme;
    }
}
```

## 🐘 Conexión remota a PostgreSQL desde TablePlus (vía SSH - recomendado)

En lugar de abrir el puerto 5432 públicamente, se recomienda conectar usando un túnel SSH.

### 🎯 Ventajas:
- No expone tu base de datos a Internet
- Más seguro, sin necesidad de modificar el firewall
- Compatible con herramientas como TablePlus, DBeaver, pgAdmin, etc.

### 🛠 Configuración en TablePlus

#### Conexión principal (arriba):
| Campo     | Valor         |
|-----------|---------------|
| Host      | localhost     |
| Port      | 5432          |
| User      | admin         |
| Password  | 12345         |
| Database  | haloapi       |

#### Sección “Over SSH”:
| Campo     | Valor                         |
|-----------|-------------------------------|
| Server    | haloapi.dernait.my **o** IP   |
| Port      | 22                            |
| User      | ubuntu (o tu usuario del server) |
| Key       | Ruta a tu clave privada SSH   |

> Asegurate de tener tu llave SSH cargada (ej: `~/.ssh/id_rsa`), y que tu servidor tenga el puerto 22 abierto.

---

¡Con esta configuración, TablePlus crea un túnel seguro al servidor y se conecta a PostgreSQL como si estuviera local!
