Cookie Tracker Bundle
=================

This bundle allow you to simply put a cookie on your users based on the request on your symfony2 application, without modifying your templates & controllers.

### Features:
- Customizable Cookie Factory
- Customizable Request Handler
- Comes with "ready-to-go" simple "GET parameter" behavior (see 3. Simple use-case)

### Todo:
- travis CI configuration
- enhance documentation
- tests


## 1. Installation:
**- with deps**
```yml
[CookieTracker]
    git=https://github.com/Cethy/CookieTrackerBundle.git
    target=/bundles/Cethyworks/CookieTrackerBundle
```

**- with composer**

[...]


## 2. Enable the bundle:

Enable the bundle in the kernel:

```php
<?php
// app/autoload.php
$loader->registerNamespaces(array(
    // ...
    'Cethyworks'       => __DIR__.'/../vendor/bundles',
));
```
```php
<?php
// app/AppKernel.php

public function registerBundles()
{
    $bundles = array(
        // ...
        new Cethyworks\CookieTrackerBundle\CethyworksCookieTrackerBundle(),
    );
}
```

## 3. Simple use-case (Tracking a user based on a GET parameter)

The bundle comes with this simple use-case directly usable with some configuration (in app/config/config.yml) :

minimal configuration :
```yml
cethyworks_cookie_tracker:
    from_simple_tracker:
        enabled: true
```

full configuration (display default values) :
```yml
cethyworks_cookie_tracker:
    from_simple_tracker:
        enabled: true
        get_parameter: from
        cookie:
            name: from
            expire: 60
```

Call any url of your website with an added GET parameter "from" and the listener will tie to the response a cookie named "from" with the value of the get parameter and a expire value of 60 days.