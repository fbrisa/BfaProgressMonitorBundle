    ************************************************************ 
    Requirements:
    ************************************************************ 
* http://symfony.com/doc/current/assetic/asset_management.html
* https://symfony.com/doc/master/bundles/FOSJsRoutingBundle/index.html
* jQuery


    ************************************************************ 
                            Installation:
    ************************************************************ 

1)  ************************************************************ 
    Add to composer.json:
    ************************************************************ 
"require" : {
    "bfa/progressmonitorbundle": "^1.0"
},

"repositories" : [{
    "type" : "vcs",
    "url" : "https://github.com/fbrisa/BfaProgressMonitorBundle.git"
}]


2)  ************************************************************ 
    Add to you app/AppKernel.php:
    ************************************************************ 
new Bfa\ProgressMonitorBundle\BfaProgressMonitorBundle(),



3)  ************************************************************ 
    Execute the query to generate the table:
    ************************************************************ 

CREATE TABLE bfa_progress (id INT AUTO_INCREMENT NOT NULL, data_creazione DATETIME NOT NULL, max INT NOT NULL, pos INT NOT NULL, uid VARCHAR(255) NOT NULL, data VARCHAR(1024) NOT NULL, INDEX bfaprogressuid_idx (uid), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = Memory;
    

4)  ************************************************************ 
    Geenrate symlinks
    ************************************************************ 

symfony2:
    php app/console assets:install --symlink web

symfony3:
    php bin/console assets:install --symlink web


5)  ************************************************************ 
    Add route to app/routing.tml
    ************************************************************ 

bfa_progress_monitor_homepage:
    resource: "@BfaProgressMonitorBundle/Controller/"
    type:     annotation

