# StatWise (Dev) - Petite documentation

Ce README contient des commandes pratiques pour lancer les tests, importer la base, et vérifier les flows de test.

## Import DB
Pour importer la base :

```powershell
php tools/import_db.php
```

## Seeder
Pour créer un utilisateur admin et quelques entités de démo :

```powershell
php tools/seed_db.php
```

## Exécuter la suite de tests CLI
Cette suite exécute les tests indépendants par des scripts PHP en CLI pour vérifier:
- l'API `programs/list`
- création de programmes via AJAX simulé
- création & listing de rapports
- export CSV

```powershell
php tools/run_tests.php
```

## Notes
- Les formulaires POST sont protégés par un token CSRF (champ caché `/_csrf`) généré via `csrf_field()`.
- Les actions d'administration (création programme, modification suppression, etc.) demandent le rôle admin (role id 1).
- Vous pouvez ajouter des tests supplémentaires dans `tools/` en suivant le modèle des scripts existants.
# Saul HTML Free  - Bootstrap 5 HTML Multipurpose Admin Dashboard Theme

- For a quick start please check [Online documentation](//preview.keenthemes.com/saul-html-free/documentation/getting-started.html)

- For more amazing features and solutions, please upgrade to [Saul HTML Pro](//keenthemes.com/products/saul-html-pro)

- For any theme related questions go to our [Support Center](//devs.keenthemes.com)

- Stay tuned for updates via [Twitter](//twitter.com/keenthemes), [Instagram](//instagram.com/keenthemes), [Dribbble](//dribbble.com/keenthemes) and [Facebook](//facebook.com/keenthemes)

# More Templates & Graphics

Check out our market for more free and pro templates and graphics: [Keenthemes Market](//keenthemes.com).

# Copyright & License

copyright 2021 Keenthemes. The code is released under the MIT license. There is only one limitation that you can not use the code as it is, modified or part of other item to re-distribute or resell as stock item. 

Happy coding with Saul HTML Free!