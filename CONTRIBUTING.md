## Installation

1. Clone the repository:

```shell
git clone git@github.com:hybridly/demo.git blue-bird && cd blue-bird
```

2. Use SQLite to simplify installation by creating a file database.

```shell
touch database/bluebird.db
```

3. Create a new `.env` file by copying `.env.example` and include the required database information to complete the migration.

```shell
cp .env.example .env
```

4. Fill the following environment variables:

```
DB_CONNECTION=sqlite
DB_DATABASE=database/bluebird.db
```

1. Install the dependencies using `pnpm` (we recommend using [`ni`](https://github.com/antfu/ni) if you are used to other package managers):

```shell
pnpm install # or `ni`
composer install
```

6. Run the migrations:

```shell
php artisan migrate --seed
```

7. Secure your local site development by using the Herd UI or with Valet on the console by using:

```shell
valet secure blue-bird
```

8. Start the Vite server and enjoy!

```shell
pnpm run dev # or `nr dev`
```

## Troubleshooting

If you are receiving this error:

```
error when starting dev server:
Error: Unable to find Valet certificate files for your host [blue-bird.test]. Ensure you have run "valet secure".
```

- Run `valet secure`
- Or edit `vite.config.ts` and remove the `valetTls` line.
