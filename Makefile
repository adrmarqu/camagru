# Nombre del proyecto
PROJECT_NAME = camagru

# Ruta al docker-compose
DC = docker compose -f sources/docker-compose.yml

all: build up

# Levantar contenedores
up:
	$(DC) up -d

# Parar contenedores
down:
	$(DC) down

# Reiniciar
restart: down up

# Ver logs
logs:
	$(DC) logs -f

# Construir (por si luego usas Dockerfile)
build:
	$(DC) build --no-cache

# Acceder al contenedor (bash)
bash:
	$(DC) exec web bash

# Estado de contenedores
ps:
	$(DC) ps

open:
	open http://localhost:8080

bbdd:
	sleep 30
	open http://localhost:5050
	

seed:
	$(DC) exec web php ./database/seed.php

# Limpiar todo (containers + volúmenes)
clean:
	$(DC) down -v

stop: down clean

# Reinstalar todo limpio
re: stop build up open bbdd

.PHONY: 