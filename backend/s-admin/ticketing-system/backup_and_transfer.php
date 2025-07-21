<?php
header('Content-Type: application/json');
include('../../dbconn.php');
session_start();

date_default_timezone_set("Asia/Manila");

$backupFile = '/tmp/' . $db_name . '_' . date("Y-m-d_H-i-s") . '.sql';
$mountPoint = '/mnt/backup_share'; // this should be already mounted

$mysqldumpPath = '/usr/bin/mysqldump'; // full path to mysqldump

if ($db_password === "") {
    $dumpCommand = "$mysqldumpPath -h $db_host -u $db_username $db_name > $backupFile";
} else {
    $dumpCommand = "$mysqldumpPath -h $db_host -u $db_username -p'$db_password' $db_name > $backupFile";
}
exec($dumpCommand, $output, $returnVar);

if ($returnVar !== 0) {
    http_response_code(500);
    die("❌ Database backup failed. Command: $dumpCommand");
}
echo "✅ Database dumped to: $backupFile<br>";

// Step 2: Copy to Windows shared folder
$destination = $mountPoint . '/' . basename($backupFile);

if (!copy($backupFile, $destination)) {
    http_response_code(500);
    die("❌ Failed to copy to Windows shared folder: $destination");
}
echo "✅ Backup copied to Windows share: $destination<br>";

// Optional: Delete local file
unlink($backupFile);
echo "✅ Local backup file deleted.";
