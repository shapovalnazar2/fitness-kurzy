# Fitness Kurzy Trénera

Webová aplikácia vytvorená v jazyku PHP bez použitia frameworku.  
Projekt slúži na správu a nákup fitness kurzov.

## Funkcie

- Registrácia používateľa
- Prihlásenie používateľa
- Odhlásenie
- Zobrazenie kurzov
- Nákup kurzov
- Stránka "Moje kurzy"
- Administrácia kurzov (CRUD)

## CRUD operácie

Administrátor môže:
-  Pridať kurz
-  Upraviť kurz
-  Vymazať kurz

## Použité technológie

- PHP 8+
- MySQL
- PDO
- HTML + CSS

## Bezpečnosť

- Heslá sú hashované pomocou `password_hash()`
- Overovanie pomocou `password_verify()`
- Použitie `sessions` pre prihlásenie
- Ochrana admin časti (kontrola role)

## Databáza

Tabuľky:
- `users`
- `courses`
- `orders`

## Spustenie projektu

1. Nainštalovať XAMPP
2. Skopírovať projekt do:
```

C:\xampp\htdocs\

```
3. Spustiť Apache a MySQL
4. Vytvoriť databázu `fitness_courses`
5. Importovať SQL tabuľky
6. Otvoriť v prehliadači:
```

[http://localhost/fitness-kurzy/public/](http://localhost/fitness-kurzy/public/)

```

## Admin prístup

Email:
```

[admin@example.com](mailto:admin@example.com)

```

Heslo:
```

admin123

```

## Autor

Študentský projekt pre predmet Skriptovacie jazyky

Nazarii Shapoval