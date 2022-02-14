## Local setup
1. (If on Windows) Install and lanch WSL: https://docs.microsoft.com/en-us/windows/wsl/install
2. Install Docker: https://docs.docker.com/get-docker/
3. Clone the repository: https://docs.github.com/en/repositories/creating-and-managing-repositories/cloning-a-repository
4. Enter the project directory inside terminal: `cd cyf-resources`
5. Copy .env.example and rename to .env: `cp .env.example .env`
6. Initialize Laravel Sail: https://laravel.com/docs/8.x/sail#installing-composer-dependencies-for-existing-projects
7. Start Sail: `./vendor/bin/sail up -d`
8. Run install: `./vendor/bin/sail artisan sail:install`
9. Run migrations: `./vendor/bin/sail artisan migrate --seed`
    * If you get "Access denied for user 'sail'", run: `./vendor/bin/sail down --rmi all -v` and repeat step 7
11. Generate app key: `./vendor/bin/sail artisan key:generate`
12. Run npm scripts: `./vendor/bin/sail npm install && npm run dev`
13. Start server: `./vendor/bin/sail artisan serve`
