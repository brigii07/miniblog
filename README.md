# Backend
PHP (8.1 vagy újabb)
Symfony (6.x vagy újabb)
Doctrine ORM (adatbázis kezeléshez)
Twig (template engine)
SQLite/MySQL/PostgreSQL (adatbázis)
Composer (függőségkezelő)

# Frontend
HTML5
CSS3
jQuery
AJAX (API kommunikáció)

# Funkciók
✅ Blogbejegyzések listázása
✅ Új bejegyzés létrehozása
✅ Bejegyzések törlése
✅ Real-time frissítés (oldal újratöltés nélkül)
✅ Validáció és hibakezelés
✅ Reszponzív felület

# Telepítés és indítás
Előfeltételek
PHP 8.1 vagy újabb
Composer
Node.js és npm (opcionális, fejlesztéshez)

1. Projekt klónozása
git clone <https://github.com/brigii07/miniblog.git> - vagy Github desktoppal
cd mini-blog

2. Függőségek telepítése
composer install

3. Környezeti változók beállítása
A .env fájlt feltöltöttem, hogy használható legyen, ha gond van, akkor e szerint kell eljárni:
.env fájl tartalma:
APP_ENV=dev
APP_SECRET=secret_key
DATABASE_URL="sqlite:///%kernel.project_dir%/var/data.db"

4. Adatbázis létrehozása és adattal történő feltöltés
Adatbázis létrehozása
1.php bin/console doctrine:database:create
2.php create_table.php
3.php add_test_data.php

5. Szerver indítása
Symfony fejlesztői szerver indítása
symfony server:start

# Használat
Nyisd meg a böngészőt és navigálj a http://localhost:8000 címre.
Az alkalmazás automatikusan betölti a meglévő bejegyzéseket.
Új bejegyzést az oldal tetején található űrlappal hozhatsz létre.
A bejegyzéseket a mellettük található gombokkal törölheted, a szerkesztés gomb jelenleg még nem működik.

# Gyakori probléma
"Invalid date" hiba a frontend-en.
A backend nem megfelelő formátumban küldi a dátumokat, ennek okán a szerkesztés sem működik, az adatbázis viszont befogadja. 

# Adatbázis kapcsolati problémák
Ellenőrizd a .env.dev fájlban az adatbázis beállításokat.
Győződj meg róla, hogy az adatbázis szerver fut.

# Composer függőségek hibái
Futtasd újra: composer install
Frissítsd a függőségeket: composer update