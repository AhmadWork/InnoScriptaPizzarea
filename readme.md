# InnoScriota Pizzarea

## Set Up

#### Clone the repository:

```bash
git clone https://github.com/AhmadWork/InnoScriptaPizzarea.git
```

#### Create your environment file:
```bash
cp .env
```
#### Update these settings in the .env file:

* DB_DATABASE (your local database, i.e. "innoScripta_Pizzarea")
* DB_USERNAME (your local db username, i.e. "root")
* DB_PASSWORD (your local db password, i.e. "")
* HASHIDS_SALT (use the app key or match the variable used in production)

#### Install PHP dependencies:

```bash
composer install
```

#### Generate an app key:
```bash
php artisan key:generate
```

#### Generate JWT keys for the .env file:
```bash
php artisan jwt:secret
```

#### Run the database migrations:
```bash
php artisan migrate
```

#### Install Javascript dependencies:
```bash
npm install
```

#### Run an initial build:
```bash
npm run dev
```

### React Code 
due to the limited time I didn't focus on the design and opt to go with bootstrap, I tried to show more than one way of bulding component(e.g:Checkout was bulid with functional component and hooks and Login was bulid with class component)
and show more than one way of state managment(e.g: auth was handled with redux and cart was handled with context).

#### Database Seeding

If you need sample data to work with, you can seed the database:

```
php artisan migrate:refresh --seed --force
```
#### Seeded User

After seeding the database, you can log in with these credentials:

Email: `admin@innoscripta.test`
Password: `password`
