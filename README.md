
# 🏆 La Liga Tracker API

API desarrollada en Laravel para gestionar partidos de una liga de fútbol.  
Permite crear, visualizar, actualizar y eliminar partidos a través de endpoints RESTful.

---

## 🖼️ Vista del Frontend

![La Liga Tracker Frontend](image.png)

---

## 📦 Tecnologías utilizadas

- Laravel 10+
- PostgreSQL
- Docker & Docker Compose
- Nginx (para producción)
- Certificados SSL (Let's Encrypt o manual)

---

## 🚀 Endpoints de la API

### Obtener todos los partidos
```
GET /api/matches
```

### Obtener un partido por ID
```
GET /api/matches/{id}
```

### Crear un nuevo partido
```
POST /api/matches
```

### Actualizar un partido existente
```
PUT /api/matches/{id}
```

### Eliminar un partido
```
DELETE /api/matches/{id}
```

---

## 🛠️ Estructura del proyecto

- `/app/Http/Controllers/LeagueMatchController.php`: controlador principal para manejar la lógica de los partidos.
- `/routes/api.php`: definición de rutas del API.

---

## ⚙️ Despliegue con Docker

Para desplegar este proyecto, usá el archivo `DEPLOY.md` incluido con todos los pasos necesarios para levantarlo en producción, incluyendo Nginx, SSL, PostgreSQL y Laravel en Docker.

---

## 💻 Frontend

El frontend es una interfaz HTML local para interactuar con esta API. Se descarga como `LaLigaTracker.html` en las instrucciones del laboratorio.

---

## 🧑‍💻 Autor

Desarrollado por Kevin (a.k.a. DerNait) para prácticas de Sistemas y Tecnologías Web.
