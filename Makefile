# Nombre del proyecto
PROJECT_NAME = webapp

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
	$(DC) build

# Acceder al contenedor (bash)
bash:
	$(DC) exec web bash

# Estado de contenedores
ps:
	$(DC) ps

open:
	open http://localhost:8080

# Limpiar todo (containers + volúmenes)
clean:
	$(DC) down -v

# Reinstalar todo limpio
re: all clean build up