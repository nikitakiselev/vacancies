# HeadHunter vacancies parser

## Installation

Clone `git clone https://github.com/nikitakiselev/vacancies.git Vacancies` and run it on homestead.

After start homestead and create `.env` configuration file

```Bash
homestead ssh
cd ~/Code/Vacancies
cp .env.example .env
```

Change database settings in `.env` file and install dependencies

```
composer install
npm install
gulp
```

Then,

```
art key:generate
art migrate --seed
```

Change settings in `.env` file:

```
QUEUE_DRIVER=redis
SCOUT_DRIVER=tntsearch
```

Configure queue worker with laravel documentaion [https://laravel.com/docs/5.3/queues#supervisor-configuration](https://laravel.com/docs/5.3/queues#supervisor-configuration).

You can start parser handly `art hh:parse` or do it automatically every day in 00:00. Just config your server Cron job [https://laravel.com/docs/5.3/scheduling#introduction](https://laravel.com/docs/5.3/scheduling#introduction)

## Run

To start parsing from hh run this command

```bash
php artisan hh:parse
```

To start indexing database with tntsearch run this command

```bash
php artisan scout:import
```