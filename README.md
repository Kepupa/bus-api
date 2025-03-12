# BusApi

![Laravel](https://img.shields.io/badge/Laravel-10.x-red)
![PHP](https://img.shields.io/badge/PHP-8.1-blue)
![PostgreSQL](https://img.shields.io/badge/PostgreSQL-14-green)
![Docker](https://img.shields.io/badge/Docker-Enabled-blue)

**Описание:**
`Bus API` — это backend-приложение на Laravel, которое предоставляет REST API для работы с расписанием рейсовых автобусов. Цель — реализовать функционал поиска автобусов по маршруту между остановками и управления маршрутами.

---

## Возможности
- **Поиск автобусов** (`/api/find-bus`): Возвращает список автобусов, проходящих через указанные остановки (`from` и `to`), с ближайшими временами прибытия.
- **Управление маршрутами**(`api/routes/{id}`): Редактирование порядка остановок на маршруте.
- Тестирование с использованием PHPUnit для проверки API. (очень простые тесты)

---

## Установка

- Перед началом работы установим все нужные инструменты:
   ```bash
    sudo apt update && sudo apt upgrade -y
    sudo apt install -y git curl unzip zip php-cli php-mbstring php-xml php-bcmath php-tokenizer composer docker.io docker-compose

1. **Клонируйте репозиторий**:
   ```bash
    git clone <URL_репозитория> bus-api
    cd bus-api
2. **Создание .env и настройка переменных окружения**:
   ```bash
    cp .env.example .env
   
3. **В .env указываем данные для подключения к PostgreSQL**:
    ```bash 
         DB_CONNECTION=pgsql
         DB_HOST=bus-postgres
         DB_PORT=5432
         DB_DATABASE=yourdb
         DB_USERNAME=postgres
         DB_PASSWORD=yourpassword
         APP_URL=http://localhost
4. **Установка зависимостей**:
    ```bash
      composer install

5. **Запуск контейнеров Docker**:
    ```bash
   docker-compose up -d --build

6. **Подготовка базы данных**:
Выполняем миграции и наполняем БД тестовыми данными:
    ```bash
   docker exec -it bus-api php artisan migrate --seed

7. **Проверяем работу API**:
Если нужна документация и список енд поинтов
    ```bash
    docker exec -it bus-api php artisan route:list


8. **Остановка и перезапуск контейнеров**:
    ```bash
        docker-compose down
        docker-compose up -d

---
**Дополнительно**:

1. Диаграмма бд лежит в

/database/schema

2. Дамп базы

backup.dump

3. Запустить тесты:
```bash
docker exec -it bus-api php artisan test
