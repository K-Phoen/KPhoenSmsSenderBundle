KPhoenSmsSenderBundle
=====================

Integration of the [**SmsSender**](https://github.com/Carpe-Hora/SmsSender/)
library into Symfony2.

This bundle also integrates SmsSender in Symfony's Web Profiler.

<img src="https://raw.github.com/K-Phoen/KPhoenSmsSenderBundle/master/Resources/doc/web_profiler.png" width="280" height="175" />


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
    pool:         memory    # can be null (and is by default)
    providers:    [nexmo]

    nexmo:
        api_key:     lala
        api_secret:  lala
```

The `providers` section defines the list of providers that you want to use in
your application.
Each provider defines its own section in the configuration. In this example, the
Nexmo provider needs an API key and an API secret in order to work.

The `pool` section defines the pooling strategy used by the sender. When
enabled, messages sending is deferred to after the response is sent to the
user (see Symfony's [kernel.terminate](http://symfony.com/doc/current/components/http_kernel/introduction.html#the-kernel-terminate-event) event).


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


Reference Configuration
-----------------------

You MUST define the providers you want to use in your configuration. Some of
them need information (API key for instance).

You'll find the reference configuration below:

``` yaml
# app/config/config.yml
k_phoen_sms_sender:
    pool:         ~   # right now, only "memory" is supported
    http_adapter: curl
    providers:    [dummy, esendex, nexmo, twilio, cardboardfish, valuefirst]

    dummy:        ~

    twilio:
        account_sid:  lala
        api_secret:   lala

    nexmo:
        api_key:      lala
        api_secret:   lala

    esendex:
        username:     lala
        password:     lala
        account_ref:  lala

    cardboardfish:
        username:     lala
        password:     lala

    valuefirst:
        username:     lala
        password:     lala
```
