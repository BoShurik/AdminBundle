AdminBundle
===========

## Installation

#### Add on composer.json (see http://getcomposer.org/)

    "require" :  {
        // ...
        "knplabs/knp-menu-bundle":"dev-master",
    }

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

#### Add routes to app/routing.yml

    BoShurikAdminBundle:
        resource: "@BoShurikAdminBundle/Resources/config/routing.yml"
        prefix:   /admin