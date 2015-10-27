<?php
$currentDir = getcwd();
chdir('/var/www');

exec('PGPASSWORD=mypassword psql -d postgres -U postgres -h readdb -f migration/migration.sql');

@mkdir("/tmp/metadata", 0777, true);
chmod("/tmp/metadata", 0777);
chown("/tmp/metadata", 'www-data');

@mkdir("/tmp/annotations", 0777, true);
chmod("/tmp/annotations", 0777);
chown("/tmp/annotations", 'www-data');

echo "\nDone.\n";