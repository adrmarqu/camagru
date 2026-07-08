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

.PHONY: all up down restart status logs clean fclean re