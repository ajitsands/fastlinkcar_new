# upload.ps1 - Automated Site Uploader via cPanel API
# This script reads config.json, zips the site, uploads via cPanel API, and extracts it.

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

Write-Host "--- Server Upload Started (via HTTPS/cPanel API) ---" -ForegroundColor Cyan

# 1. Compress Local Files
Write-Host "Compressing local files into deployment.zip..." -ForegroundColor Yellow
if (Test-Path "deployment.zip") { Remove-Item "deployment.zip" -Force }

$itemsToCompress = Get-ChildItem -Path $localPath | Where-Object { $_.Name -notin @(".git", "node_modules", "site_backup.zip", "deployment.zip", ".vscode", "db_dump.sql") }
Compress-Archive -Path $itemsToCompress.FullName -DestinationPath "deployment.zip" -Force

if (-Not (Test-Path "deployment.zip")) {
    Write-Host "Compression failed." -ForegroundColor Red
    exit
}

# 2. Upload the ZIP via UAPI
Write-Host "Uploading deployment.zip to server..." -ForegroundColor Yellow
$uploadUrl = "https://$($hostName):2083/execute/Fileman/upload_files"

# Upload to the user's home directory
$uploadDest = "/home/$username"
$curlArgs = @(
    "-k",
    "-s",
    "-H", "Authorization: Basic $encodedAuth",
    "-F", "dir=$uploadDest",
    "-F", "file-1=@deployment.zip",
    $uploadUrl
)
$curlOutput = & curl.exe $curlArgs | ConvertFrom-Json

if ($curlOutput.status -eq 1) {
    Write-Host "Upload successful." -ForegroundColor Green
} else {
    Write-Host "Upload failed: $($curlOutput.errors)" -ForegroundColor Red
    exit
}

# 3. Extract the ZIP via cPanel API 2
Write-Host "Extracting files on the server directly to public_html..." -ForegroundColor Yellow
$extractUrl = "https://$($hostName):2083/json-api/cpanel"
$extractParams = @{
    cpanel_jsonapi_user = $username
    cpanel_jsonapi_apiversion = 2
    cpanel_jsonapi_module = "Fileman"
    cpanel_jsonapi_func = "fileop"
    op = "extract"
    sourcefiles = "$uploadDest/deployment.zip"
    dest = $remotePath
}

try {
    $extractResponse = Invoke-RestMethod -Method Post -Uri $extractUrl -Headers $headers -Body $extractParams
    if ($extractResponse.cpanelresult.error) {
        Write-Host "Extraction error: $($extractResponse.cpanelresult.error)" -ForegroundColor Red
    } else {
        Write-Host "Extraction successful." -ForegroundColor Green
    }
} catch {
    Write-Host "Extraction API call failed: $_" -ForegroundColor Red
}

# 4. Cleanup
Write-Host "Cleaning up deployment.zip..." -ForegroundColor Yellow
Remove-Item "deployment.zip" -Force
$deleteUrl = "https://$($hostName):2083/execute/Fileman/fileop?op=unlink&source_1=$uploadDest/deployment.zip"
Invoke-RestMethod -Uri $deleteUrl -Headers $headers | Out-Null

Write-Host "--- Upload Completed Successfully ---" -ForegroundColor Green

