# GitHub Publishing Guidelines

When pushing a professional project to a public GitHub repository, it is critical to ensure that sensitive data, local configurations, and unnecessary compiled files are NOT uploaded. 

This document explains what files should be pushed, what should be ignored, and why.

## 🛑 What NOT to Push (And Why)

These files and directories are automatically excluded via the `.gitignore` file. **Never force-push them.**

### 1. `.env` (Environment Variables)
- **Why?** This file contains your database passwords, API keys, application secrets, and local paths. Pushing this to a public repository is a severe security vulnerability.
- **Alternative:** Push `.env.example` instead. This file should contain the *keys* but dummy values (e.g., `DB_PASSWORD=secret`), allowing other developers to know what variables are required without exposing your real credentials.

### 2. `vendor/` & `node_modules/` (Dependencies)
- **Why?** These directories contain thousands of third-party library files downloaded via Composer and NPM. They are massive in size and constantly changing.
- **Alternative:** Push `composer.json`, `composer.lock`, `package.json`, and `package-lock.json`. Anyone cloning the repo can simply run `composer install` and `npm install` to download the exact versions of the dependencies needed.

### 3. `storage/` (App Storage & Logs)
- **Why?** The `storage/` directory contains cached views, application logs (`storage/logs/laravel.log`), and user-uploaded files. Pushing logs can expose sensitive user data or server paths, and cached files cause conflicts.
- **Exception:** Only the `.gitignore` files inside the empty storage subdirectories should be pushed to maintain the folder structure without the files.

### 4. `.phpunit.result.cache` or Testing Caches
- **Why?** These are temporary local files generated during test executions. They are irrelevant to the source code.

## ✅ What MUST Be Pushed

These are the files that make up your actual application logic and are safe/necessary for recruiters or collaborators to see:

1. **`app/`**: Contains all your core logic (Models, Controllers, Services). This is where recruiters will look to judge your coding style.
2. **`routes/`**: Shows how you structure your application's entry points.
3. **`database/`**: Migrations, seeders, and factories. This proves you know how to design database schemas.
4. **`resources/`**: Your React frontend files, views, and raw CSS/JS.
5. **`config/`**: Configuration files (without sensitive passwords).
6. **`tests/`**: Unit and Feature tests. Having tests in a public repo is a huge plus for recruiters.
7. **`README.md`**: The face of your project. It must be professional and explain the project's purpose and setup instructions.

## 🔑 Summary of the Git Strategy

If you ever add a new library or tool that generates local/cache files, make sure to add that folder to `.gitignore` **before** running `git add .`.

Always run `git status` before `git commit` to double-check exactly which files are being staged for the commit.
