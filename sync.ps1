# sync.ps1 - Automated Site Downloader
# This script reads config.json and downloads files from the server.

$config = Get-Content "config.json" | ConvertFrom-Json

$hostName = $config.server.host
$username = $config.server.username
$password = $config.server.password
$remotePath = $config.server.remote_path
$localPath = Get-Location

Write-Host "--- Server Sync Started ---" -ForegroundColor Cyan

# 1. Download Files
Write-Host "Downloading files from $hostName..." -ForegroundColor Yellow
# Note: This assumes standard scp is available on Windows.
# We use -r for recursive and -P for port.
scp -P $config.server.port -r "$($username)@$($hostName):$remotePath/*" "$localPath"

# 2. Database Export (Optional)
if ($config.database.remote.name -ne "YOUR_REMOTE_DB_NAME") {
    Write-Host "Attempting Database Export..." -ForegroundColor Yellow
    $dbName = $config.database.remote.name
    $dbUser = $config.database.remote.user
    $dbPass = $config.database.remote.pass
    
    # Run mysqldump on server and stream to local file
    ssh -p $config.server.port "$($username)@$($hostName)" "mysqldump -u $dbUser -p'$dbPass' $dbName" > "db_dump.sql"
    
    if ($LASTEXITCODE -eq 0) {
        Write-Host "Database exported to db_dump.sql" -ForegroundColor Green
    } else {
        Write-Host "Database export failed. You may need to export it manually from phpMyAdmin." -ForegroundColor Red
    }
}

Write-Host "--- Sync Completed ---" -ForegroundColor Green
