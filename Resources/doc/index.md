KPhoenSmsSenderBundle
=====================

Integration of the [**SmsSender**](https://github.com/Carpe-Hora/SmsSender/)
library into Symfony2.


Installation
------------

Require [`kphoen/sms-sender-bundle`](https://packagist.org/packages/kphoen/sms-sender-bundle)
to your `composer.json` file:


```json
{
    "require": {
        "kphoen/sms-sender-bundle": "dev-master"
    }
}
```

Register the bundle in `app/AppKernel.php`:

    // app/AppKernel.php
    public function registerBundles()
    {
        return array(
            // ...
            new KPhoen\SmsSenderBundle\KPhoenSmsSenderBundle(),
        );
    }

Configuration
-------------

Enable the bundle's configuration in `app/config/config.yml`:

``` yaml
# app/config/config.yml
k_phoen_sms_sender:
    providers:    [nexmo]

    nexmo:
        apiKey:     lala
        apiSecret:  lala
```

The `providers` section defines the list of providers that you want to use in
your application.
Each provider defines its own section in the configuration. In this example, the
Nexmo provider needs an API key and an API secret in order to work.

Usage
-----

This bundle registers a `sms.sender` service which is an instance
of `SmsSender`. You'll be able to do whatever you want with it but be sure to
configure at least **one provider** first.

Here is an example:

```php
<?php

public function sendAction()
{
    $sms_sender = $this->get('sms.sender');
    $sms_sender->send('0642424242', 'It\'s the answer.', 'Kévin');

    return Response('Some content');
}
```

See [SmsSender's documentation](https://github.com/Carpe-Hora/SmsSender/) for
more details about the `SmsSender`'s features.
