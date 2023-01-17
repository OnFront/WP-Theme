# Setup

### All commands need to be run on payeye theme root example:

- `~/Sites/payeye/public_html/wp-content/themes/payeye`

### Config

- movefile.yml
    - vhost: `http://payeye.local` !important, don't change it. Your local host have to by `http://payeye.local`
    - wordpress_path: `/Users/payeye/Sites/payeye/public_html` your relative path
    - database:
        - name: `payeye` your db name
        - user: `root` your db user
        - password: `'1234'` your db password
        - host: `localhost` you host

- gulpfile
    - hostName: `payeye.local` !important, don't change it.
    - browser:
        - `google-chrome`  Linux
        - `chrome`  Windows
        - `google chrome`  OS

### Before develop

- npm install
- composer install
    - after install run: `composer dump`
    - sometimes autoload will be broken to fix it run again: `composer dump`

### Develop

- yarn start

If working fine without error then:

- Browser will be open automatic
- Hot reload will enable when you change **scss, js, twig, php** see gulpfile.js **config.watch**
- automatic refresh file js nad css in public directory

### Create controller

- run command: `php bin/application.php app:create-controller MyFirst`

If success then output:

- Created controller: MyFirstController
- src/Controller/MyFirstController.php
- templates/my_first/index.twig

you can go and check this file.

# Structure

Theme support MVC architecture by using own custom framework and **Timber** bundle: https://timber.github.io/docs/

- acf-json ( https://www.advancedcustomfields.com/resources/local-json/ )
- bin (CLI - command line interface)
    - application.php - command to create controller
    - maintenance.sh - command to enable maintenance mode in UAT and PROD before copy ENV by WP ENGINE (https://wpengine.com/)
    - after-migration-to-prod.sh - command to disable maintenance mode in UAT and PROD after copy ENV by WP ENGINE (https://wpengine.com/)
- cache (dependency injection, twig)
- config (dependency injection, twig)
- node_modules (npm modules)
- public (icon, image, css, js)
    - css and js will be automatic generate while develop or deploy
- resources (js and scss automatic convert to js and css in public directory)
- src (controller layer)
- template (view layer by twig: https://twig.symfony.com/)
- vendor (php bundle)

# Standard code

### PHP

- required PHP 7.4.X
- PSR 12 (just setup in PHP Storm code style PSR 12 to use auto format). Docs https://www.php-fig.org/psr/psr-12/

### SCSS

- BEM https://en.bem.info/methodology/css/

### JS

- Vanilla JS http://vanilla-js.com/

# Deploy

### Deploy theme to UAT

Deploy by **wordmove** https://github.com/welaika/wordmove support OS nad Linux

###### **go to style.css and change Version to bigger. For example: Version: 0.1.020 to Version: 0.1.021**

- `wordmove push -t`

#### Info

- We just deploy payeye theme. Nothing more important !!!.
- Plugins install and update manual via dashboard https://uatpayeye.wpengine.com/.
- WP core please update via WP Engine provider. https://identity.wpengine.com/.

#### UAT is ready. Go testing and if working go run Deploy UAT to PROD

### Deploy UAT to PROD

- `bash ./bin/deploy-uat-to-prod.sh`