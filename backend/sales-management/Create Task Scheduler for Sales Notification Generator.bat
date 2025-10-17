@echo off
REM =========================================
REM Create Windows Task Scheduler for PHP Script
REM Runs every 1 minute
REM =========================================

set PHP_PATH=C:\xampp\php\php.exe
set SCRIPT_PATH=%~dp0salesNotificationGenerator.php
set TASK_NAME=SalesNotificationGenerator

echo Creating scheduled task: %TASK_NAME%

REM Delete task first if it already exists
schtasks /delete /tn %TASK_NAME% /f >nul 2>&1

REM Create task to run every 5 minute
schtasks /create /sc minute /mo 60 /tn %TASK_NAME% /tr "\"%PHP_PATH%\" \"%SCRIPT_PATH%\"" /rl highest

echo Task %TASK_NAME% created successfully! It will now run every 60 minutes.
pause