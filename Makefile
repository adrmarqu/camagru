NAME = camagru

all: up

up:
	@echo "Starting $(NAME) environment..."
	docker-compose up -d --build

down:
	@echo "Stopping $(NAME) containers..."
	docker-compose down

restart:
	@echo "Restarting $(NAME) containers..."
	docker-compose restart

status:
	docker-compose ps

logs:
	docker-compose logs -f

clean: down
	@echo "Cleaning dangling containers and networks for $(NAME)..."
	docker system prune -f

fclean: clean
	@echo "Removing physical volumes for $(NAME) (Deletes Database!)..."
	docker-compose down -v
	docker volume rm $$(docker volume ls -q) 2>/dev/null || true

re: fclean all

chrome:
	@echo "Opening Camagru in Google Chrome..."
	@open -a "Google Chrome" http://camagru.42barcelona || open http://localhost

fire:
	@echo "Opening Camagru in Firefox..."
	@open -a "Firefox" http://camagru.42barcelona || open http://localhost

open:
	@echo "Opening Camagru..."
	@open -a "Google Chrome" http://camagru.42barcelona 2>/dev/null || \
	 open -a "Firefox" http://camagru.42barcelona 2>/dev/null || \
	 open http://camagru.42barcelona

db:
	@echo "Opening phpMyAdmin..."
	@open -a "Google Chrome" http://localhost:8080 2>/dev/null || open http://localhost:8080

.PHONY: all up down restart status logs clean fclean re chrome fire open db