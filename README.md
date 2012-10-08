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

#### Add security settings to app/security.yml

    encoders:
        BoShurik\AdminBundle\Entity\Administrator:
            algorithm:          sha512
            iterations:         5000
            encode_as_base64:   true

    providers:
        admin:
            entity:
                class: BoShurik\AdminBundle\Entity\Administrator
                property: username

    firewalls:
        admin_area:
            provider: admin
            pattern:    ^/admin
            form_login:
                check_path: /admin/auth
                login_path: /admin/login
                default_target_path: /admin
            logout:
                path:   /admin/logout
                target: /admin
            anonymous: ~

    access_control:
        - { path: ^/admin/login, role: IS_AUTHENTICATED_ANONYMOUSLY }
        - { path: ^/admin, role: IS_AUTHENTICATED_FULLY }

#### Do not forget to enable translator in app/config.yml