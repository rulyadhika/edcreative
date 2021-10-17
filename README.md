# EdCreative
A simple blog

Built using :
* PHP 7.4
* CodeIgniter 4.0.4
* Bootstrap v4.6
* Sass
* Datatables
* CKEditor
* CKFinder
* Sweetalert2
* MythAuth
* SBAdmin2


## Installation

You can clone the repository with this command, or download this [zip](https://github.com/rulyadhika/edcreative/archive/main.zip) file.

```bash
> git clone https://github.com/rulyadhika/edcreative.git
```

## Configuration
1. Change terminal directory to edcreative folder
```bash
> cd edcreative
```

2. Run this command
```bash
> composer install
```

3. Move and replace myth folder at the project root directory to /vendor

4. Download ckfinder version 3.5.1.1 for PHP, [here](https://ckeditor.com/ckfinder/download/)

5. Then extract ZIP File to /public/src/plugins/

6. Move and replace ckfinder folder at the project root directory to /public/src/plugins/

7. Duplicate env file and rename it to .env

8. Configure your baseURL and database in .env file

9. Ensure your database is setup correctly, then run this command
```bash
> php spark migrate
> php spark migrate --all
> php spark db:seed AppSeeder

```

10. Run local development server
```bash
> php spark serve
```

## User credential for administrator
* username : administrator
* password : 02UQKmdRgv
