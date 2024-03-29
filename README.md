The example of implementing a modest social network using the Laravel + Vue.JS.

## Install

1. Clone project and install dependencies
    ```bash
    git clone https://github.com/fussraider/tiny-social-network && cd ./tiny-social-network
    composer install
    npm install
    ```

2. Configure the environment

    Copy `.env.example` as name `.env`
    ```bash
    cp .env.example .env
    ```
    Open `.env` and configure `DB_*` parameters (and `APP_URL` if your local domain different from localhost). Then execute:
    ```bash
    php artisan key:generate
    php artisan jwt:secret
    php artisan storage:link
    ```

3. Migrate & seed
    ```bash
    php artisan migrate --seed
    ```
   
4. Complete 

    Open [localhost](http://localhost) (or your custom domain)
    
    Use this data for authorization
    - email: `admin@admin.com`
    - password: `admin123`
    
    Or you can be register a new account
    
## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
