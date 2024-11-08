Step Asas Laravel

1. Environment - (.env) Edit Database etc
2. Create Controller - php artisan make:controller <ModuleName>Controller -r
3. Create Form Request - php artisan make:request <ModuleName>Request & set authorize() true
4. Create Model - php artisan make:model <ModuleName> -m
5. Register Routes - (Routes/web.php) Route::resources('module',<ModuleName>Controller::class)
6. Create View - add new folder resources/views/<ModuleName>/file.blade.php

Folder Structure & Life Circle
------------------------------
1# Database Structure / Migration
database\migrations\date_time_migration_name.php
-- <ColumnName>

2# Logic
app\Http\Controllers\<ModuleName>Controller.php

4# Paparan / Visual / Html / Form
resources\views\<ModuleName>\<PageName>.blade.php
-- <ColumnName>

5# Data Firewall / Form Request
app\Http\Requests\<ModuleName>Request.php
-- <ColumnName> with Rules

6# Data / Model
app\Models\<ModuleName>.php
-- <ColumnName> as fillable


Windows
-------
1. Open the Start menu, type "PowerShell," right-click on "Windows PowerShell," and select "Run as Administrator".
2. run: Set-ExecutionPolicy RemoteSigned
3. Confirm by typing Y when prompted.


composer create-project laravel/laravel:^9.0 bookings
cd bookings
composer require laravel/ui 
composer require laravel/fortify
php artisan vendor:publish --provider="Laravel\Fortify\FortifyServiceProvider"
php artisan ui bootstrap --auth
php artisan session:table
php artisan migrate
npm install
npm run dev
