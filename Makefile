NAME = camagru

all: up

up:
	@echo "Levantando el entorno de $(NAME)..."
	docker-compose up -d --build

down:
	@echo "Deteniendo los contenedores de $(NAME)..."
	docker-compose down

restart:
	@echo "Reiniciando contenedores de $(NAME)..."
	docker-compose restart

status:
	docker-compose ps

logs:
	docker-compose logs -f

clean: down
	@echo "Limpiando contenedores y redes sobrantes de $(NAME)..."
	docker system prune -f

fclean: clean
	@echo "Eliminando volúmenes físicos de $(NAME) (¡Borra la Base de Datos!)..."
	docker-compose down -v
	docker volume rm $$(docker volume ls -q) 2>/dev/null || true

re: fclean all

chrome:
	@echo "Abriendo Camagru en Google Chrome..."
	@open -a "Google Chrome" http://camagru.42barcelona || open http://localhost

fire:
	@echo "Abriendo Camagru en Google Chrome..."
	@open -a "Google Chrome" http://camagru.42barcelona || open http://localhost

open:
	@echo "Abriendo Camagru..."
	@open -a "Google Chrome" http://camagru.42barcelona 2>/dev/null || \
	 open -a "Firefox" http://camagru.42barcelona 2>/dev/null || \
	 open http://camagru.42barcelona

db:
	@echo "Abriendo phpMyAdmin..."
	@open -a "Google Chrome" http://localhost:8080 2>/dev/null

.PHONY: all up down restart status logs clean fclean re chrome fire open open_db