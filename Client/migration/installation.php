<?php
$currentDir = getcwd();
chdir('/var/www');

exec('PGPASSWORD=mypassword psql -d postgres -U postgres -h readdb -f migration/migration.sql');

echo "\nDone.\n";