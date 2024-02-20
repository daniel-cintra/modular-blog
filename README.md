<p align="center" style="margin: 24px;">
    <a href="https://docs.ismodular.com" target="_blank">
    <img src="art/modular-blog-github.png" alt="Modular Blog" style="width: 100%; max-width: 800px;"></a>
</p>

<center>

[![Vue v3.x](https://img.shields.io/badge/Vue.js-v3.x-2f4053?style=for-the-badge&logo=vue.js&logoColor=39af78)](https://vuejs.org/)
[![Inertia.js v1.x](https://img.shields.io/badge/Inertia.js-v1.x-6765ea?style=for-the-badge&logo=inertia&logoColor=ffffff)](https://inertiajs.com/)
[![Laravel v10.x](https://img.shields.io/badge/Laravel-v10.x-FF2D20?style=for-the-badge&logo=laravel)](https://laravel.com)
[![Tailwind CSS v3.x](https://img.shields.io/badge/Tailwind%20CSS-v3.x-31b5f7?style=for-the-badge&logo=tailwind-css&logoColor=ffffff)](https://tailwindcss.com/)
[![Tests passing](https://img.shields.io/badge/Tests-passing-green?style=for-the-badge&logo=github)](https://github.com/daniel-cintra/modular-blog/actions)

</center>

## Modular's Blog Module

The Modular Blog Module is a Blog Module for Applications built using the [Modular Project](https://docs.ismodular.com).

It has the following features:

-   Posts Management
-   Categories Management
-   Tags Management
-   Authors Management

This means that you can easily create posts using a Fully Featured WYSIWYG Editor, and manage them using a simple and intuitive interface to create, edit, and delete posts, categories, tags, and authors, also allowing you to manage the posts' status and visibility throught publication dates.

## Preparing to install the Modular Blog Module

Before installing the Modular Blog Module, you need to make sure that you have the Modular Project installed and configured in your Laravel Application. If you haven't done that yet, you can follow the [Modular Project's Installation Guide](https://docs.ismodular.com/getting-started.html).

With the Modular Project installed, follow the steps to [Publish Site Files](https://docs.ismodular.com/essentials/site-setup.html).

Now that you have all set, proceed to install the Modular Blog Module.

## Installation

To install the Modular Blog Module, you need to require it using Composer:

```bash
composer require daniel-cintra/modular-blog
```

After that, you can run the module's installation command:

```bash
php artisan modular:blog-install
```

This command will publish the module's files required for the module to work, and also run the module's migrations and optionally seed the database with some default data.

### Check npm dependencies

The Blog Module has a dependency on the Pinia npm package. If you don't have it installed, follow these steps:

1 - On your project root run:

```bash
npm install -D pinia
```

2 - Open the file `resources/js/app.js` and add the pinia `import { createPinia } from 'pinia'` and the `.use(createPinia())` blocks.

```js
import '../css/app.css'
import 'remixicon/fonts/remixicon.css'

import { createApp, h } from 'vue'
import { createPinia } from 'pinia'
import { createInertiaApp } from '@inertiajs/vue3'
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers'
import { ZiggyVue } from '../../vendor/tightenco/ziggy/dist/vue.m'

const appName = import.meta.env.VITE_APP_NAME || 'Laravel'

// global components
import { Link } from '@inertiajs/vue3'
import Layout from './Layouts/AuthenticatedLayout.vue'

import Translations from '@/Plugins/Translations'

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => {
        const page = resolvePageComponent(
            `./Pages/${name}.vue`,
            import.meta.glob('./Pages/**/*.vue')
        )

        page.then((module) => {
            module.default.layout = module.default.layout || Layout
        })

        return page
    },
    setup({ el, App, props, plugin }) {
        return createApp({ render: () => h(App, props) })
            .use(createPinia())
            .use(plugin)
            .use(ZiggyVue, Ziggy)
            .use(Translations)
            .component('Link', Link)
            .mount(el)
    },
    progress: {
        color: '#3e63dd'
    }
})
```

Here are the manual configuration needed to finish the Blog Installation:

### 1 - BlogServiceProvider

Add the BlogServiceProvider to `/config/app.php`

```php
Modules\Blog\BlogServiceProvider::class,
```

### 2 - Backend Menu Items

Add the menu items to the `resources/js/Configs/menu.js` items array:

```js

export default {
    // Main Navigation - Side Menu
    items: [
        ...
        {
            label: 'Blog',
            permission: 'Blog',
            children: [
                {
                    label: 'Posts',
                    permission: 'Blog: Post - List',
                    icon: 'ri-draft-line',
                    link: route('blogPost.index')
                },
                {
                    label: 'Categories',
                    permission: 'Blog: Category - List',
                    icon: 'ri-folders-line',
                    link: route('blogCategory.index')
                },
                {
                    label: 'Tags',
                    permission: 'Blog: Tag - List',
                    icon: 'ri-price-tag-3-line',
                    link: route('blogTag.index')
                },
                {
                    label: 'Authors',
                    permission: 'Blog: Author - List',
                    icon: 'ri-team-line',
                    link: route('blogAuthor.index')
                }
            ]
        },
        ...
    ]
}
```

### 3 - Frontend

In `vite.config.js` manually add the module entry to:

```js
plugins: [
    laravel({
        input: [
            ...
            'resources-site/js/blog-app.js'
        ],
        refresh: [
        ]
    }),
    ...
],
```

That's it. The Blog Module should be fully functional at this stage.

### Blog Seeders (Optional Step)

The Blog Module has two built in Seeders:

1 - **BlogSeeder**: Will create `posts`, `authors`, `categories` and `tags`. It will fetch images online to populate `posts`, `authors` and `categories`, so it can take a few seconds to complete.  

2 - **BlogAclSeeder**: Will create the ACL Permissions associated with the module, so it can be associated with the desired `ACL Role` through the App Interface.

You can manually run the seeders or you can add the seeders to be executed in the `database/seeders/DatabaseSeeder.php` file.

#### Adding the seeders to the DatabaseSeeder file

To add the seeders to the main DatabaseSeeder file, import the BlogSeeders and call them inside the `run` method:

```php
<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Blog\Database\Seeders\BlogAclSeeder;
use Modules\Blog\Database\Seeders\BlogSeeder;

public function run(): void
{
    $this->call(BlogAclSeeder::class);
    $this->call(BlogSeeder::class);
}

```

#### Manually executing the Seeders

To manually execute the Seeders you can run:

```bash
php artisan db:seed --class="Modules\\Blog\\Database\\Seeders\\BlogSeeder"
```

And also:

```bash
php artisan db:seed --class="Modules\\Blog\\Database\\Seeders\\BlogAclSeeder"   
```


## License

The Modular Project is open-source software licensed under the [MIT license](LICENSE.md).
