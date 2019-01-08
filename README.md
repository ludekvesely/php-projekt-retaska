# Re-taška

## Jak zprovoznit aplikaci (lokální instalace)

### Instalace závislostí
`composer install`

### Start databáze
`sudo service mysql start`

### Vytvoření databáze `php-projekt-retaska`
`bin/console doctrine:database:create`

### Založení tabulek
`bin/console doctrine:schema:update --force`

### Vytvoření uživatele do administrace
`bin/console user:create admin 1234`

## Jak zprovoznit aplikaci (docker)

### Konfigurace prostředí
Nejprve je nutné si připravit konfigurační soubor `docker-compose.override.yaml` na základě souboru `docker-compose.override.yaml.dist`

### Spuštění projektu
`docker-compose up`

### Instalace závislostí
`docker-compose exec app composer install`

### Založení tabulek
`docker-compose exec app bin/console doctrine:schema:update --force`

### Vytvoření uživatele do administrace
`docker-compose exec app bin/console user:create admin 1234`