AdminBundle
===========

Inspired by standard crud generator

## Installation

#### Composer

``` bash
$ composer require boshurik/admin-bundle
```


#### Register the bundle

``` php
<?php
// app/AppKernel.php

public function registerBundles()
{
    $bundles = array(
        // ...
        new BoShurik\AdminBundle\BoShurikAdminBundle(),
    );
    // ...
}
```

#### Add routes to `app/config/routing.yml`

``` yaml
    BoShurikAdminBundle:
        resource: "@BoShurikAdminBundle/Resources/config/routing.yml"
        prefix:   /admin
```

#### Add administrator entity, form type and form filter classes

`TBD`

#### Add security configuration

`TBD`

## Development

* `npm install`
* `bower install`
* `gulp build`

or just

* `npm install && bower install && gulp build`