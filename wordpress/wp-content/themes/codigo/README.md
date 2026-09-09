# Codigo Wordpress Project based in Laravel, TailwindCSs and Vue 3
A clean slate Wordpress application for wordpress.
Based in [sage](https://github.com/roots/sage?tab=readme-ov-file) and in [Nextly](https://github.com/web3templates/nextly-template)

[![version](https://img.shields.io/badge/version-0.1.0-yellow.svg)](https://semver.org)

## Installation

### Go to [root_folder] and clone the repository

    git clone https://github.com/pablorica/hmo
    Cloning into 'hmo'...
    remote: Enumerating objects: 182, done.
    remote: Counting objects: 100% (182/182), done.
    remote: Compressing objects: 100% (118/118), done.
    remote: Total 182 (delta 53), reused 165 (delta 40), pack-reused 0
    Receiving objects: 100% (182/182), 578.41 KiB | 16.53 MiB/s, done.
    Resolving deltas: 100% (53/53), done.

### Update bud.config.js with your local dev URL

    app.setPublicPath('../');
    ...
    app
	    .setUrl('http://localhost:3000')
	    .setProxyUrl('https://hmo.localhost')
	    .watch([
	    `resources/views`,
	    `resources/scripts`,
	    `resources/css`,
    ]);

### VUE 3

The extension is pre-configured to support Vue 3 single file components (runtime only).

You can disable the `runtimeOnly` default by adding the following to your `bud.config.js` file:

    app.vue.setRuntimeOnly(false);

The `esm-bundler` builds of Vue expose global feature flags `__VUE_OPTIONS_API__` and `__VUE_PROD_DEVTOOLS__` , they must to be defined.
You may want to enable the options API and disable the devtools:

    app.define({
        __VUE_OPTIONS_API__: true,
        __VUE_PROD_DEVTOOLS__: false,
    });

[Read more](https://bud.js.org/extensions/bud-vue) about setting up Vue in Sage.

### Compile files

    $ cd [root_folder]/wp-content/themes/codigo
    $ composer install --prefer-dist --optimize-autoloader
    $ yarn install
    
    	➤ YN0000: · Yarn 4.2.2
    	➤ YN0000: ┌ Resolution step
    	➤ YN0085: │ + @roots/bud-tailwindcss@npm:6.16.1, @roots/bud@npm:6.16.1, and 976 more.
    	➤ ...
    	➤ YN0000: · Done with warnings in 34s 39ms
    
    $ yarn build
    	
    	╭ sage [1a24dfc8407595fc] ./public
    	│
    	│ app
    	│ ◉ js/runtime.e97f88.js ✔ 1.22 kB
    	│ ◉ css/app.182da0.css ✔ 9.57 kB
    	│ ◉ js/app.c6fc6f.js ✔ 359 bytes
    	│
    	│ editor
    	│ ◉ js/runtime.e97f88.js ✔ 1.22 kB
    	│ ◉ css/editor.a5ebf3.css ✔ 2.94 kB
    	│ ◉ js/editor.7f4d85.js ✔ 1.67 kB
    	│
    	│ assets
    	│ ◉ fonts/Aeonik/Aeonik-Regular.c2876d.eot 98.41 kB
    	│ ◉ fonts/Aeonik/Aeonik-Bold.7fa62f.woff 48.8 kB
    	│ ◉ fonts/Aeonik/Aeonik-Regular.413ab3.woff 47.71 kB
    	│ ◉ fonts/Aeonik/Aeonik-Bold.f42057.woff2 36.44 kB
    	│ ◉ fonts/Aeonik/Aeonik-Regular.7ddd98.woff2 35.4 kB
    	│ … 11 additional assets not shown
    	│
    	╰ 3s 759ms 8 modules [0/8 modules cached]

#### *Error: React is not installed*

If you have this error when running `yarn`, it means that React is not installed as a devDependency.

	node:internal/process/esm_loader:42
	internalBinding('errors').triggerUncaughtException...
	Required package: react (via "react/package.json")
	...

To fix this we need both react and react-dom as devDependencies.

```$ npm install --save-dev react react-dom```

Once installed, try again:

```$ yarn install```


## Gutenberg Blocks

The `@roots/bud-preset-wordpress` package comes with an editor integration. This library adds support for registering *blocks*, *filters*, *formats*, *styles*, *variations* and *plugins*.

All modules registered with this API are registered in production and development. In development additional hot module reloading support is added.

### Adding support to your application

There are two steps:

- Making the root registration call for a given type or types.
- Adding modules to your application

In general, the above steps are the same for working with any of the supported APIs.

#### Making the root registration call

Open `resources/scripts/editor.js` and write the call `roots.register.[type]` , supplying the root directory where registrables are found.

For example, to register blocks in the application, we must add this call:

    roots.register.blocks('@scripts/blocks')

    /** Don't forget to accept any module updates! */
    if (import.meta.webpackHot) {
    import.meta.webpackHot.accept(console.error)
    }


#### Adding modules to the application

`bud.js` will look for modules in the directory indicated in the root registration call. Modules are named like `*.[type].[ext]`.

The module should export the required settings and the name of the entity.

Modules can be created using either *default exports* or *named exports*. As a general rule, we will use default exports whenever possible.

For example, to add a block variation in the Group block and add a Grid css feature, we would create a file `grid.variation.js` in the `resources/scripts/variations` directory:

    export default {
        block: `core/group`,
        name: 'group-grid',
        title: `Grid`,
        icon: 'grid-view',
        description: `Arrange blocks in a grid.`,
        attributes: {
            layout: {
                type: 'grid' 
            }
        },
        scope: [ 'block', 'inserter', 'transform' ],
        isActive: (blockAttributes) => blockAttributes.layout?.type === 'grid',
    }

#### Advantages of using this library

Without this library, if you have modified the content of a block you are developing in the editor and then make changes to a block's code that cause it to render differently, WordPress may mark the block as invalid.

This library intercepts the module update and caches the state of the block outside of WordPress' state tree. It then completely unregisters the block and then re-registers it. If the block was selected before the module update, it also deselects and reselects it.

WordPress is now looking at a different situation: a newly registered block with newly registered state. There is no discrepency and so the block is not flagged as invalid.

This library also provides a more declarative way of registering modules with WordPress than the default API, and is less prone to understandable errors importing the wrong registration functions, etc.


### Install required plugins (ACF)

Download the plugins folder from the staging server and copy it to the local installation.

[Plugins](https://hmo.codigo.co.uk/plugins.tar.gz)

### Activate ACF and then the Codigo theme in the CMS

### Media files

Some images can be found in `_images` folder

### Update the database

- Copy the database from the **_database** folder and replace it in the local installation

```bash
    cd wp-content/themes/wp-codigo-ltv/_database
    mysql -u root -p talentstudio < talentstudio.sql
    Enter password: root
```

#### Find and replace using WP_CLI

Go to the web root folder and run:

```bash
    wp search-replace 'talentstudio.codigo.co.uk' 'talentstudio.localhost' --dry-run --allow-root --all-tables
    ## If the results are ok, remove the flag '--dry-run'
    wp search-replace 'talentstudio.codigo.co.uk' 'talentstudio.localhost' --allow-root --all-tables
    ---> Success: Made 705 replacements.
```

Change database prefix using WP-CLI (if necessary)
 
[WP-CLI Rename Database Prefix](https://github.com/iandunn/wp-cli-rename-db-prefix) is an add-on to WP_CLI that allows you to change the database prefix.

  
```bash
    wp package install iandunn/wp-cli-rename-db-prefix --allow-root`
    wp rename-db-prefix 'hmosite_' --dry-run --allow-root`
    ## If the results are ok, remove the flag '--dry-run'
    wp rename-db-prefix 'hmosite_' --allow-root`
    *Warning: Use this at your own risk. If something goes wrong, it could break your site.
    Before running this, make sure to back up your `wp-config.php` file and run `wp db export`.
    Are you sure you want to rename hmo.localhost's database prefix from `wp_` to `hmosite_`? [y/n]
    Success: Successfully renamed database prefix.*
```

#### Create Database Backup

```bash
    cd wp-content/themes/wp-codigo-ltv/_database
    mysqldump -u root -proot talentstudio | gzip > wp-codigo-ltv.sql.gz
```




## Installation from scratch

### Installing Sage with Compose
See the [Sage installation documentation](https://roots.io/sage/docs/installation/).

Install Sage using Composer from your WordPress themes directory

    cd [root_folder]/wp-content/themes
    composer create-project roots/sage codigo

#### Build assets
You must build theme assets in order to access your site. 

**Run yarn from the theme directory to install dependencies**

    cd [root_folder]/wp-content/themes/codigo
    yarn

**Update bud.config.js with your local dev URL**

    app.setPublicPath('../');
    ...
    app
	    .setUrl('http://localhost:3000')
	    .setProxyUrl('https://wordpress.localhost')
	    .watch([
	    `resources/views`,
	    `resources/scripts`,
	    `resources/css`,
    ]);

**Compile assets**

    yarn build
    ...
    ╭ sage [776635f9d9aa3c07] ./public
    │
    │ app
    │ ◉ js/runtime.e97f88.js ✔ 1.22 kB
    │ ◉ css/app.194f0a.css ✔ 5.35 kB
    │ ◉ js/app.c6fc6f.js ✔ 359 bytes
    │
    │ editor
    │ ◉ js/runtime.e97f88.js ✔ 1.22 kB
    │ ◉ css/editor.ef46db.css ✔ ø
    │ ◉ js/editor.8c1474.js ✔ 1.67 kB
    │
    ╰ 2s 256ms 8 modules [0/8 modules cached]

    ✨ Done in 5.80s.

### Installing Acorn
See the [Acorn installation documentation](https://roots.io/acorn/docs/installation/).
 
Sage requires Acorn but doesn't ship with it included. This is to give you the flexibility to include it in a way that works best for your environment. There's a few different ways to install Acorn.

    cd [root_folder]/wp-content/themes/codigo
    composer require roots/acorn  

#### Add the autoload dump script

Acorn has a function that should be added to the scripts section of your composer.json file for the post-autoload-dump event. To automatically configure this script, run the following command:

    $ wp acorn acorn:init

  

### Go to CMS and select the Sage theme

Sage is ready to be used in your Wordpress installation. Go to the CMS and select the Sage theme.


## Quick Start

### Watch

```
clear
cd [root_folder]/wp-content/themes/codigo
yarn watch
```

Development URL:

http://localhost:3000/

Defined in `/bud.config.js`

```
...
  app
    .setUrl('http://localhost:3000')
    .setProxyUrl('https://wordpress.localhost')
    .watch([
        `resources/views`,
        `resources/scripts`,
        `resources/css`,
    ]);
...
```

### Build

```
clear
cd [root_folder]/wp-content/themes/codigo
yarn build
```

Localhost URL:

https://wordpress.localhost/

Defined in `/bud.config.js`

## Styling

### Tailwind Configuration File

    [root_folder]/wp-content/themes/codigo/tailwind.config.cjs

#### Compilation Errors

```
[sage] [@roots/bud-tailwindcss] › ✖  ReferenceError: require is not defined in ES module scope, you can use import instead 
This file is being treated as an ES module because it has a '.js' file extension and 'package.json' contains "type": "module". To treat it as a CommonJS script, rename it to use the '.cjs' file extension.
```

  Solution: *Change file extension*

    [root_folder]/wp-content/themes/codigo/tailwind.config.js ---> [root_folder]/wp-content/themes/codigo/tailwind.config.cjs


### CSS Files

    [root_folder]/wp-content/themes/codigo/resources/styles/app.css
    [root_folder]/wp-content/themes/codigo/resources/styles/editor.css

### Set Up Fonts

Sage includes an empty `resources/fonts/` directory for you to use for any fonts you want to use in your theme.

The Sage extension in `jsconfig.json` also contains a @fonts alias that can be used to reference assets in the `fonts/` directory.

[Read more](https://roots.io/sage/docs/fonts-setup/) about setting up fonts in Sage.


## Plugins

### Installing ACF Composer

ACF Composer is the ultimate tool for creating fields, blocks, widgets, and option pages using ACF Builder alongside Sage 10.

See the [ACF Composer installation](https://github.com/Log1x/acf-composer?tab=readme-ov-file#installation).


#### Install via Composer:

    $ composer require log1x/acf-composer

Start by publishing the `config/acf.php` configuration file using Acorn:

    $ wp acorn vendor:publish --tag="acf-composer"

If you have this warning

    INFO No publishable resources for tag [acf-composer].
    
try running this command first

    $ wp acorn package:discover
      INFO  Discovering packages.  
      nesbot/carbon ......................................................... DONE
      nunomaduro/termwind ................................................... DONE
      roots/sage ............................................................ DONE

And try again:

    $ wp acorn vendor:publish --tag="acf-composer"
      INFO  Publishing [acf-composer] assets.
      Copying file [vendor/log1x/acf-composer/config/acf.php] to [config/acf.php] ............. DONE

##### Generating a Field Group

To create your first field group, start by running the following generator command from your theme directory:   

    $ wp acorn acf:field Example

This will create `src/Fields/Example.php` which is where you will create and manage your first field group.


### Sage directives

[Sage Directives](https://log1x.github.io/sage-directives-docs/) adds a variety of useful Blade directives for use with Sage 10 including directives for WordPress, ACF, and various miscellaneous helpers.



#### Install Sage directives

    $ composer require log1x/sage-directives


#### Sage directives Examples

[Wordpress](https://log1x.github.io/sage-directives-docs/usage/wordpress.html)

**`WP_Query`**

`@query` initializes a standard `WP_Query` as `$query` and accepts the usual `WP_Query` parameters as an array.

    @query([
	    'post_type' => 'post'
    ])
    
    @posts
	    <h2  class="entry-title">@title</h2>
	    <div  class="entry-content">
		    @content
	    </div>
    @endposts


[ACF](https://log1x.github.io/sage-directives-docs/usage/acf.html)

**`@field`**


`@field` echo's the specified field using `get_field()`.

    @field('text')




## Staging Folder

[root_folder]/wp-content/themes/codigo/public



## Required Plugins

* [Advanced Custom Fields](https://www.advancedcustomfields.com/pro/)


## Required libraries

* [SAGE](https://github.com/roots/sage?tab=readme-ov-file)
* [Acorn](https://roots.io/acorn/).
* [Nextly](https://github.com/web3templates/nextly-template)
* [ACF Composer](https://github.com/Log1x/acf-composer)
* [Sage Directives](https://log1x.github.io/sage-directives-docs/)


## Copyright and License

Copyright 2023 Codigo Wordpress Theme released under the [MIT](https://github.com/pablorica/wp-codigo-ltv/blob/main/LICENSE) license.


## Versioning

We use [SemVer](https://semver.org/) for versioning. For the versions available, [list of tags can be found in this page](https://github.com/pablorica/wordpress_codigo_theme/tags).

### Changelog

[CHANGELOG.md](https://github.com/pablorica/wordpress_codigo_theme/blob/main/CHANGELOG.md)
