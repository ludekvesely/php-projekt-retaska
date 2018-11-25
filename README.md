# Re-taška

## Jak zprovoznit aplikaci

### Instalace závislostí
`composer install`

### Start databáze
`sudo service mysql start`

### Vytvoření databáze `php-projekt-retaska`
`bin/console doctrine:database:create`

### Založení tabulek
`bin/console doctrine:schema:update --force`
