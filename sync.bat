@echo off
echo ========================================
echo   Syncing E-Benta with GitHub (main)...
echo ========================================
git pull origin main
php artisan migrate --force
php artisan optimize:clear
echo.
echo ========================================
echo   Sync Complete! All updated!
echo ========================================
