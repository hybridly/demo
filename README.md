<br>

<p align="center">
  <img src="https://github.com/hybridly/hybridly/raw/0.x/.github/assets/logo-shadow.svg" style="width:125px;" />
</p>

<h1 align="center">Hybridly</h1>


<div align="center">
  <br />
  This is the repository hosting the demonstration application of Hybdrily.
  <br />
  Check out the <a href="https://github.com/hybridly/hybridly">main repository</a> for more information.
</div>


### How to use this Demo?
Here's a Quick Guide to run this demo locally:

1. Clone the repository:

```batch
git clone git@github.com:hybridly/demo.git blue-bird && cd blue-bird
```

2. Use SQLite to simplify installation by creating a file database.

```batch
touch database/bluebird.db
```

3. Create a new .env file by copying the .env.example and include the required database information to complete the migration.

```batch
cp .env.example .env
```

4. Replace the following database variables with the editor of your choice:
DB_CONNECTION=sqlite
DB_DATABASE=database/bluebird.db

Or you can execute the following commands if you are using MacOS:
```
sed -i -e 's/^DB_CONNECTION.*/DB_CONNECTION=sqlite/g' .env
sed -i -e 's/^DB_DATABASE.*/DB_DATABASE=database\/bluebird.db/g' .env
```

5. Install the dependencies. You can use Yarn, PNPM, Bun, or NPM for the FrontEnd dependencies. We are using NPM for this example:

```batch
npm install && composer install
```

6. Run de Migrations and Seed:

```batch
php artisan migrate --seed
```

7. Secure your local site development by using the Herd UI or with Valet on the console by using:

```batch
valet secure blue-bird
```

8. Start the Vite server and enjoy!

```batch
npm run dev
```

## Troubleshooting

#### My Vite server it's returning an error trying to start
If you are receiving this error:
```
error when starting dev server:
Error: Unable to find Valet certificate files for your host [blue-bird.test]. Ensure you have run "valet secure".
```
**Solution:**
Edit the vite.config.ts file and comment the `valetTls: true,` line.


<p align="center">
  <br />
  <br />
  <br />
  <br />
  <img src='https://cdn.jsdelivr.net/gh/innocenzi/static@latest/sponsorkit/sponsors.svg'/>
  <br />
  <br />
  <sub>·</sub>
  <br />
  <br />
  <br />
  <sub>
    Built with ❤︎ by <a href="https://github.com/enzoinnocenzi">Enzo Innocenzi</a>
  </sub>
</p>
