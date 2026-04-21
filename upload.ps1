# upload.ps1 - Automated Site Uploader
# This script reads config.json and uploads files back to the server.

$config = Get-Content "config.json" | ConvertFrom-Json

$hostName = $config.server.host
$username = $config.server.username
$remotePath = $config.server.remote_path
$localPath = Get-Location

Write-Host "--- Server Upload Started ---" -ForegroundColor Cyan

# 1. Upload Files
Write-Host "Uploading files to $hostName..." -ForegroundColor Yellow
# Note: We use scp -r to upload the entire directory content to the remote path.
# We exclude config.json and .git/ manually if possible, or just upload everything and rely on .gitignore for git.
# scp doesn't have an easy exclude, so we might want to use rsync if available, or WinSCP.
# But for simplicity, we can upload specific folders or the whole thing minus the sensitive ones.

scp -P $config.server.port -r "$localPath/*" "$($username)@$($hostName):$remotePath"

if ($LASTEXITCODE -eq 0) {
    Write-Host "--- Upload Completed Successfully ---" -ForegroundColor Green
} else {
    Write-Host "--- Upload Failed ---" -ForegroundColor Red
}
