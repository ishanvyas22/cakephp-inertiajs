# Usage

## Client-side Setup

Once you have your [server-side framework configured](ServerSideSetup.md), you then need to [setup your client-side framework](https://inertiajs.com/client-side-setup). This plugin leverages [AssetMix plugin](https://github.com/ishanvyas22/asset-mix/tree/cake3) so you don't have to install all the front-end dependencies one by one. Instead you can generate scaffolding(using above command) to quickly get started.

**Note:** As of now AssetMix plugin only supports front-end scaffolding for Vue.js. If you want to use any other client side framework you can do so, refer [this](https://inertiajs.com/client-side-setup) link to know more.

### Adding new pages

As described in official documentation,

> With Inertia, each page in your application has its own controller and corresponding JavaScript component. This allows you to retrieve just the data necessary for that page, no API required.

So to create new page you need to create a JavaScript component into `assets/js/` folder matching CakePHP convention. For example, the `index` method of a `ArticlesController` would use `assets/js/Pages/Articles/Index.vue` as its view component.

Refer official documentation for more info: https://inertiajs.com/pages#creating-pages

### Resolve component from another path

By default, all your components should go into the `Pages` directory inside your js root path(`assets/js` or `resources/js`) if you want to change this path, you have to edit `app.js` file to tell bundler to resolve another path.

```js
import Vue from 'vue';
import { InertiaApp } from '@inertiajs/inertia-vue';

Vue.use(InertiaApp);

const el = document.getElementById('app');

new Vue({
    render: h => h(InertiaApp, {
        props: {
            initialPage: JSON.parse(el.dataset.page),
            resolveComponent: name => import(`@/Pages/${name}`).then(module => module.default),
        },
    }),
}).$mount(el);
```

Refer official documentation for more info: https://inertiajs.com/client-side-setup#initialize-app

---

[< Server-side Setup](ServerSideSetup.md)
