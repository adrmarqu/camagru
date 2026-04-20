# --- Configuración ---
PROJECT_NAME = camagru
DC           = docker compose -f sources/docker-compose.yml
OPEN         = open # Cambiar a xdg-open en Linux si es necesario


# --- Colores para el Help ---
GREEN  = \033[0;32m
RESET  = \033[0m
YELLOW = \033[0;33m


# --- Reglas Principales ---
all: build up ## Construye y levanta los contenedores

up: ## Levanta los contenedores en segundo plano
	$(DC) up -d

down: ## Detiene los contenedores
	$(DC) down

restart: ## Reinicia los servicios (down + up)
	$(DC) down
	$(DC) up -d

build: ## Construye las imágenes sin usar la caché
	$(DC) build --no-cache

re: clean build up ## Borrado total y reinstalación completa
	@echo "$(YELLOW)Esperando a que los servicios estén listos...$(RESET)"
	@sleep 8
	$(MAKE) seed
	@echo "$(GREEN)Todo listo. Abriendo navegador...$(RESET)"
	$(MAKE) open


# --- Utilidades y Debug ---
logs: ## Muestra los logs en tiempo real
	$(DC) logs -f

bash: ## Accede a la terminal del contenedor web
	$(DC) exec web bash

ps: ## Lista el estado de los contenedores
	$(DC) ps


# --- Automatización ---
open: ## Abre la aplicación en el navegador
	$(OPEN) http://localhost:8080

bbdd: ## Abre el gestor de base de datos (puerto 5050)
	$(OPEN) http://localhost:5050

seed: ## Ejecuta el script de población de la base de datos
	$(DC) exec web php ./database/seed.php


# --- Limpieza ---
clean: ## Elimina contenedores, volúmenes, imágenes y huérfanos
	$(DC) down -v --rmi all --remove-orphans


# --- Ayuda ---
help: ## Muestra esta ayuda
	@echo "$(GREEN)Comandos disponibles para $(PROJECT_NAME):$(RESET)"
	@grep -E '^[a-zA-Z_-]+:.*?## .*$$' $(MAKEFILE_LIST) | sort | awk 'BEGIN {FS = ":.*?## "}; {printf "  $(YELLOW)%-15s$(RESET) %s\n", $$1, $$2}'

.PHONY: all down up restart logs build bash ps open bbdd seed clean re help