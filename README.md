## Покрокова інструкція запуску

### Крок 1: Розпакувати
```bash
unzip plant-management.zip
cd plant-management
```

### Крок 2: MySQL (Docker)
```bash
docker-compose up -d
sleep 15  # Зачекати запуску MySQL
```

### Крок 3: PHP залежності
```bash
composer install
```

### Крок 4: JS залежності
```bash
npm install
```

### Крок 5: Налаштування
```bash
cp .env.example .env
php artisan key:generate
```

### Крок 6: База даних
```bash
php artisan migrate --seed
```

### Крок 7: Запуск (2 термінали)

**Термінал 1 - Frontend:**
```bash
npm run dev
```

**Термінал 2 - Backend:**
```bash
php artisan serve
```

### Крок 8: Відкрити
```
http://localhost:8000
```

## Готово!

---

## Перевірка системи

### MySQL працює?
```bash
docker-compose ps
# Має бути: Up
```

### База даних створена?
```bash
mysql -h 127.0.0.1 -P 3306 -u user -ppassword -e "SHOW DATABASES;"
# Має бути: plant_mysql
```

### Vite працює?
```
Має показати: http://localhost:5173
```

### Laravel працює?
```
Має показати: http://127.0.0.1:8000
```

---

## Тестові дані

Після `php artisan migrate --seed` буде створено:

**Типи рослин:**
- fruit plants
- coniferous plants
- ornamental plants

**Препарати:**
- Actara
- Ridomil Gold
- Topaz
- Konfidor Maxi

---

## Проблеми?

**MySQL не запускається:**
```bash
docker-compose down -v
docker-compose up -d
```

**Composer помилки:**
```bash
composer install --ignore-platform-reqs
```

**NPM помилки:**
```bash
rm -rf node_modules package-lock.json
npm install
```

**База даних помилки:**
```bash
php artisan migrate:fresh --seed
```
