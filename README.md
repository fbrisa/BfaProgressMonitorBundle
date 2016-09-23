Requirements:
https://symfony.com/doc/master/bundles/FOSJsRoutingBundle/index.html

Installation:
1) Add to you app/AppKernel.php:

    new Bfa\ProgressMonitorBundle\BfaProgressMonitorBundle(

2) Execute the query to generate the table:
    CREATE TABLE bfa_progress (id INT AUTO_INCREMENT NOT NULL, data_creazione DATETIME NOT NULL, max INT NOT NULL, pos INT NOT NULL, uid VARCHAR(255) NOT NULL, data VARCHAR(1024) NOT NULL, INDEX bfaprogressuid_idx (uid), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = Memory;
    

