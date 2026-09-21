# Property Manager

A simple dashboard to manage your rental properties: properties, units, tenants, bills, payments, and tenant concerns — built with Laravel.

No coding knowledge needed to run it. Follow the steps below once, then just start it whenever you want to use it.

## What's inside

- **Properties** — the buildings/houses you manage
- **Units** — individual units/rooms inside each property, with rent amount and occupancy status
- **Tenants** — who lives where, contact info, move-in/move-out dates
- **Bills & Payments** — log rent, electricity, water, internet, or other bills per unit, and record payments against them (auto-tracks paid/partial/unpaid)
- **Tenant Concerns** — a simple ticket log for maintenance requests or complaints, with priority and status, plus a resolution note you write that the tenant can see
- **Dashboard** — an at-a-glance summary: occupancy, unpaid bills total, open concerns, recent payments
- **Tenant Portal** — a separate, simpler login for your tenants (at `/portal`) where each tenant can see only their own bills and payment history, raise a concern, and see your resolution once you've written one

It uses SQLite, so there's no separate database server to install or configure — it's just a file.

## Easiest way to run it (Mac): Laravel Herd

1. Download and install **[Laravel Herd](https://herd.laravel.com)** (free). It installs PHP and Composer for you — nothing else to set up.
2. Unzip this project into a folder, e.g. `~/Herd/property-manager`.
3. Open **Terminal**, then run:
   ```bash
   cd ~/Herd/property-manager
   composer install
   cp .env.example .env
   php artisan key:generate
   php artisan migrate
   php artisan db:seed
   ```
4. Open the app: with Herd, any site inside your Herd sites folder is automatically available at `http://property-manager.test`. If you placed the folder outside Herd's sites directory, instead run:
   ```bash
   php artisan serve
   ```
   and open **http://127.0.0.1:8000** in your browser.
5. Log in as the property manager with:
   - Email: `admin@example.com`
   - Password: `password`

   (You can change these before step 3 by editing `ADMIN_EMAIL` and `ADMIN_PASSWORD` in the `.env` file, or change your password later by asking an AI coding assistant to add a "change password" page.)

   The sample tenant also has portal access for you to try — go to `/portal` (or `http://property-manager.test/portal` with Herd) and log in with:
   - Email: `juan@example.com`
   - Password: `tenant123`

## Alternative: plain PHP + Composer (any OS)

If you already have PHP 8.3+ and Composer installed:

```bash
cd property-manager
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan db:seed
php artisan serve
```

Then open **http://127.0.0.1:8000**.

## Everyday use

Once set up, to run the app again you only need:

```bash
cd property-manager
php artisan serve
```

(Not needed at all if you're using Herd and placed the project in its sites folder — it's just always running.)

## Sample data

The first time you run `php artisan db:seed`, it creates one sample property with two units, a tenant, a couple of bills, a payment, and a maintenance concern — just so the dashboard isn't empty. Feel free to delete these from the app once you've explored it (Properties → Delete, etc.). Running the seed command again will **not** duplicate this sample data, and it will keep your admin login in sync with whatever is in `.env`.

## Giving a tenant portal access

Portal access is off by default for a new tenant — they're just a record until you turn it on. To let a tenant log in:

1. Go to **Tenants**, open the tenant, and click **Edit**.
2. Make sure they have an **email** filled in — that's their portal username.
3. Fill in **Tenant portal password** with anything 6+ characters, then **Update**.
4. Give the tenant that email + password and point them to your site's `/portal` address (e.g. `https://yourdomain.com/portal`).

Leaving the password field blank when editing later keeps their current password unchanged. To reset a forgotten password, just type a new one in that same field.

A tenant only ever sees bills for the unit they're currently assigned to, and only their own concerns — never anyone else's data.

## Backing up your data

All your data lives in one file: `database/database.sqlite`. To back up, just copy that file somewhere safe (like a cloud drive). To restore, put the file back in the same spot.

## Making changes later ("vibe coding")

This is a completely standard Laravel application — plain controllers, Eloquent models, Blade views, no exotic tooling. That makes it easy to hand to any AI coding assistant (Claude Code, Cursor, etc.) with requests like:

- "Add a field for tenant emergency contact"
- "Add a report page that totals rent collected per month"
- "Let me upload a photo for each unit"
- "Add a second admin user"

Key folders to know about:
- `app/Models/` — the data types (Property, Unit, Tenant, Bill, Payment, Concern)
- `app/Http/Controllers/` — the logic behind each page
- `resources/views/` — the actual page templates (Blade + Tailwind CSS, precompiled to `public/css/app.css` — no build step needed to run the app)
- `database/migrations/` — the database structure
- `routes/web.php` — the list of pages/URLs

## Changing colors/styling later

The look of the app comes from a single prebuilt file: `public/css/app.css`. You won't need to touch it to use the app. If you (or an AI assistant) later change styling in the `resources/views/` files and want those changes to show up, it needs a one-time Node.js install, then:

```bash
npm install
npx tailwindcss -i resources/css/tailwind.css -o public/css/app.css --minify
```

## Troubleshooting

- **"could not find driver" error**: your PHP install is missing the SQLite extension (`pdo_sqlite`). Laravel Herd includes it automatically; on other setups, enable it in your `php.ini`.
- **Blank page / 500 error**: run `php artisan key:generate` if you skipped it, and check `storage/logs/laravel.log` for details.
- **Forgot your password**: edit `ADMIN_PASSWORD` in `.env` and re-run `php artisan db:seed`.
