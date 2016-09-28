# ProgressMonitorBundle


## Requirements
* http://symfony.com/doc/current/assetic/asset_management.html
* https://symfony.com/doc/master/bundles/FOSJsRoutingBundle/index.html
* jQuery


## Installation

Add to composer.json:
```
"require" : {
    "bfa/progressmonitorbundle": "^1.0"
},
```

```
"repositories" : [{
    "type" : "vcs",
    "url" : "https://github.com/fbrisa/BfaProgressMonitorBundle.git"
}]
```

Add to you app/AppKernel.php:
```php
new Bfa\ProgressMonitorBundle\BfaProgressMonitorBundle(),
```


Execute the query to generate the table:
```sql
CREATE TABLE bfa_progress (id INT AUTO_INCREMENT NOT NULL, data_creazione DATETIME NOT NULL, max INT NOT NULL, pos INT NOT NULL, uid VARCHAR(255) NOT NULL, data VARCHAR(20000) NOT NULL, INDEX bfaprogressuid_idx (uid), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = Memory;
```

Geenrate symlinks
symfony2:
```bash
php app/console assets:install --symlink web
```

symfony3:
```bash
php bin/console assets:install --symlink web
```

Add route to app/routing.tml

```yml
bfa_progress_monitor_homepage:
    resource: "@BfaProgressMonitorBundle/Controller/"
    type:     annotation
```


## Examples:
See doc folder for a controller and twig example
    