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
git clone <repository-url>
cd mini-blog

2. Függőségek telepítése
composer install

3. Környezeti változók beállítása
Másold át a .env fájlt és állítsd be az adatbázis kapcsolatot:
cp .env .env.dev
Szerkeszd a .env.dev fájlt:
DATABASE_URL="sqlite:///%kernel.project_dir%/var/data.db"

4. Adatbázis létrehozása és migrációk futtatása
bash# Adatbázis létrehozása
php bin/console doctrine:database:create

5. Szerver indítása
Symfony fejlesztői szerver indítása
symfony server:start

# Használat
Nyisd meg a böngészőt és navigálj a http://localhost:8000 címre
Az alkalmazás automatikusan betölti a meglévő bejegyzéseket
Új bejegyzést az oldal tetején található űrlappal hozhatsz létre
A bejegyzéseket a mellettük található gombokkal törölheted, a szerkesztés gomb jelenleg még nem működik.

# Fejlesztési parancsok
Cache ürítése
php bin/console cache:clear

Új migráció létrehozása
php bin/console make:migration
Entitás létrehozása/módosítása
php bin/console make:entity
Kontrollerek létrehozása
php bin/console make:controller

# Gyakori probléma
"Invalid date" hiba a frontend-en
A backend nem megfelelő formátumban küldi a dátumokat, ennek okán a szerkesztés sem működik, az adatbázis viszont befogadja. 


# Adatbázis kapcsolati problémák
Ellenőrizd a .env.dev fájlban az adatbázis beállításokat
Győződj meg róla, hogy az adatbázis szerver fut

# Composer függőségek hibái
Futtasd újra: composer install
Frissítsd a függőségeket: composer update