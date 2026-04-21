# sync_cpanel.ps1 - Reliable CPanel API Downloader
# This script uses the CPanel API (UAPI) to zip the site and download it.

$config = Get-Content "config.json" | ConvertFrom-Json

$hostName = $config.server.host
$username = $config.server.username
$password = $config.server.password
$remotePath = $config.server.remote_path # e.g. /home/sandsl23/public_html/aacar.sandslab.com/
$localPath = Get-Location

# Prepare Authentication
$authPair = "$($username):$($password)"
$encodedAuth = [Convert]::ToBase64String([Text.Encoding]::ASCII.GetBytes($authPair))
$headers = @{
    "Authorization" = "Basic $encodedAuth"
}

Write-Host "--- CPanel API Sync Started ---" -ForegroundColor Cyan

# 1. Compress Files on Server
Write-Host "Requesting server to ZIP files..." -ForegroundColor Yellow
$compressUrl = "https://$($hostName):2083/execute/Fileman/compress"
# We need to strip /home/user/ from the path if required by API, 
# but usually full path works if we specify the destination.
$destBranch = "migration_backup.zip"
$params = @{
    dir = $remotePath
    files = "*"
    dest_file = "/home/$($username)/$destBranch"
}

try {
    $response = Invoke-RestMethod -Method Post -Uri $compressUrl -Headers $headers -Body $params -ErrorAction Stop
    if ($response.status -eq 1) {
        Write-Host "Compression successful: $($response.data.dest_file)" -ForegroundColor Green
    } else {
        throw "Compression failed: $($response.errors)"
    }
} catch {
    Write-Host "Error during compression: $_" -ForegroundColor Red
    exit
}

# 2. Download the ZIP file
Write-Host "Downloading $destBranch..." -ForegroundColor Yellow
$downloadUrl = "https://$($hostName):2083/download?file=%2fhome%2f$($username)%2f$destBranch"
# Use curl.exe as it handles large binary downloads more robustly than Invoke-RestMethod sometimes
curl.exe -k -H "Authorization: Basic $encodedAuth" -o "$localPath\site_backup.zip" $downloadUrl

if (Test-Path "$localPath\site_backup.zip") {
    Write-Host "Download complete: site_backup.zip" -ForegroundColor Green
} else {
    Write-Host "Download failed." -ForegroundColor Red
    exit
}

# 3. Export Database via API
Write-Host "Exporting Database: $($config.database.remote.name)..." -ForegroundColor Yellow
# Note: CPanel UAPI doesn't have a direct 'export to file' in one call easily for individual DBs 
# without phpMyAdmin, so we'll try to use the 'Mysql/dump_database_schema' and stream it if possible
# or just ask user to do it if this fails.
$dbUrl = "https://$($hostName):2083/execute/Mysql/dump_database_schema?dbname=$($config.database.remote.name)"
try {
    $dbResponse = Invoke-RestMethod -Uri $dbUrl -Headers $headers
    if ($dbResponse.status -eq 1) {
        $dbResponse.data | Out-File "db_dump.sql"
        Write-Host "Database schema exported to db_dump.sql (Data might be missing, check file)" -ForegroundColor Green
    }
} catch {
    Write-Host "API DB Export failed, skipping..." -ForegroundColor Gray
}

# 4. Extract Files
Write-Host "Extracting files..." -ForegroundColor Yellow
Expand-Archive -Path "$localPath\site_backup.zip" -DestinationPath "$localPath" -Force
Write-Host "Files extracted to $localPath" -ForegroundColor Green

# 5. Cleanup Server
Write-Host "Cleaning up server..." -ForegroundColor Yellow
$deleteUrl = "https://$($hostName):2083/execute/Fileman/fileop?op=unlink&source_1=/home/$($username)/$destBranch"
Invoke-RestMethod -Uri $deleteUrl -Headers $headers | Out-Null

Write-Host "--- Sync Completed ---" -ForegroundColor Green
