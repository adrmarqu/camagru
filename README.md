# CAMAGRU

Camagru es una aplicación web completa que permite a los usuarios crear y compartir fotomontajes. Es el primer proyecto de desarrollo web en el currículo de 42, enfocado en construir una plataforma funcional sin frameworks pesados, gestionando tanto el frontend como el backend y la persistencia de datos.

# Resumen del proyecto

El objetivo es crear una aplicación similar a Instagram que permita:

Edición mediante Webcam: Captura de fotos y superposición de imágenes (stickers).

Gestión de Usuarios: Registro, confirmación por email y recuperación de contraseña.

Interacción Social: Likes y comentarios en tiempo real.

Responsive Design: Adaptable a móviles y escritorio.

# Stack tecnologico

A diferencia de las apps modernas, Camagru se construye con tecnologías base para entender el funcionamiento del protocolo HTTP y la gestión de sesiones:

Backend: PHP (Vanilla) / Node.js (dependiendo de tu elección).

Frontend: HTML5, CSS3 (Flexbox/Grid) y JavaScript puro (AJAX).

Base de Datos: MySQL / MariaDB.

Servidor: Apache / Nginx (o servidor interno de PHP).

# Estructura del proyecto

.
├── sources/                # Código fuente de la aplicación
│   ├── public/             # Frontend
│   ├── app/                # Backend (MVC)
│   ├── database/           # Scripts de configuración e inicialización de DB
│   ├── conf/               # Archivos de configuración (Apache)
│   └── docker-compose.yml  # Orquestración de los contenedores
├── docs/                   # Manuales detallados y especificaciones técnicas
├── Makefile                # Comandos de automatización
├── en.subject.pdf          # Enunciado del proyecto
└── README.md               # Guia general

public, app y database tienen sus propios README.md

# Instalacion y setup

## Requisitos previos

Git
Docker/Docker Desktop

## Configuración rápida

- Clonar repositorio

git clone https://github.com/tu-usuario/camagru.git camagru && cd camagru

- Configurar variables de entorno en secrets

mkdir secrets && cd secrets

touch user.txt
touch pass.txt
touch db.txt
...

- Ejecutar e iniciar

make