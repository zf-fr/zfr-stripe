ZfrStripe
=========

[![Latest Stable Version](https://poser.pugx.org/zfr/zfr-stripe/v/stable.png)](https://packagist.org/packages/zfr/zfr-stripe)

ZfrStripe is a modern PHP library based on Guzzle for [Stripe payment system](https://www.stripe.com).

> Note : this library does not contain tests, mainly because I'm not sure about how to write tests for an API
wrapper. Don't hesitate to help on this ;-).

## Dependencies

* [Guzzle](http://www.guzzlephp.org): >= 3.6

## Installation

Installation of ZfrStripe is only officially supported using Composer:

```sh
php composer.phar require zfr/zfr-stripe:1.*
```

## Tutorial

First, you need to instantiate the Stripe client, passing your private API key (you can find it in your Stripe
settings):

```php
$client = new StripeClient('my-api-key');
```

> You can change the API key for the client using the `setApiKey` method. This is useful if you are using Stripe
Connect and make both your own API calls and API calls on behalf of your users.

The currently latest supported version of the API is 2014-01-31. You can also explicitly specify the version
of the client using the second parameter:

```php
$client = new StripeClient('my-api-key', '2014-01-31');
```

### Versioning

Stripe versions its API using a dated version ("2013-12-03", "2014-01-31"...). Their [versioning policy](https://stripe.com/docs/upgrades)
is to release a new dated version each time something changes in their API (for instance, if a response returns
new attributes, if a property is marked as deprecated)...

However, for a PHP wrapper, it does not make really much sense to follow this versioning schema. Instead, I release a new
version descriptor each time new attributes are added/removed to **the requests** or if they expose new endpoints. For
instance, on 2014-01-31, Stripe released a way to attach multiple subscriptions to a customer. This resulted in additional
methods, additional attributes for the requests and the removal of old methods.

By default, each new minor version (1.1.0 to 1.2.0 for instance) *may* update the service descriptor to the latest
available. This means that to keep BC you should either tighten your dependency (1.3.* instead of 1.* for instance)
OR always specify the exact service descriptor you want, as shown above.

You can know about the available descriptors in the `ZfrStripe\Client\ServiceDescription` folder.

### How to use it?

Using the client is easy. For instance, here is how you'd create a new offer:

```php
$details = $client->createCharge(array(
    'amount'   => 500,
    'currency' => 'EUR',
    'customer' => 'cus_37EGGf4LMGgYy8'
));
```

The parameters have a direct one-to-one mapping with the official documentation (for any reference, you can also
check the `ZfrStripe\Client\ServiceDescription\Stripe-2014-01-31.php` file). To know what the responses look like, please
refer to the [official API reference](https://stripe.com/docs/api).

#### Expand

All Stripe API requests have support to expand some nested objects inside responses. Therefore, ZfrStripe supports this
through the `expand` parameter, which must be an array:

```php
$details = $client->getCharges(array(
    'expand' => array('customer')
));
```

#### Iterators

You may want to retrieve a list of customers, events or charges. Instead of manually doing all the request yourself,
you can use iterators. ZfrStripe provides iterators for all iterable resources:

```php
$iterator = $client->getCustomersIterator();

foreach ($iterator as $user) {
    // Do something
}
```

By default, ZfrStripe retrieves 100 elements per API call (which is the maximum allowed by Stripe API). You may want
to lower this limit by using the `setPageSize` method. You can also set a upper bound of how many results you want
to retrieve by using the `setLimit` method.

Finally, you can still use API parameters when using an iterator. For instance, this will retrieve all the events
that have the event `customer.subscription.updated`:

```php
$iterator = $client->getEventsIterator(array('type' => 'customer.subscription.updated'));

foreach ($iterator as $event) {
    // Do something
}
```

### Exceptions

ZfrStripe tries its best to throw useful exceptions. Two kinds of exceptions can occur:

* Guzzle exceptions: by default, Guzzle automatically validate parameters according to rules defined in the
 service description **before** sending the actual request. If you encounter those exceptions, you likely have broken
 code.
* ZfrStripe exceptions: those exceptions are thrown if an error occurred on Stripe side. Each exception implement
`ZfrStripe\Exception\ExceptionInterface`.

Here are all the exceptions:

* `ZfrStripe\Exception\UnauthorizedException`: your API key is likely to be wrong...
* `ZfrStripe\Exception\CardErrorException`: occurs for 402 errors. According to Stripe, this error happen when
parameters were valid but the request failed (for instance if a card CVC is invalid).
* `ZfrStripe\Exception\NotFoundException`: is thrown whenever client receives a 404 exception.
* `ZfrStripe\Exception\ValidationErrorException`: some errors on your sent data.
* `ZfrStripe\Exception\ServerErrorException`: any errors where Stripe is likely to be doing something wrong...

Usage:

```php
use ZfrStripe\Exception\TransactionErrorException;

try {
    $client->createCard(array(
        'card' => array(
            'number'    => '4242424242424242',
            'exp_month' => '01',
            'exp_year'  => '2016'
        )
    ));
} catch (CardErrorException $exception) {
    // Seems we couldn't create the card, maybe because it's invalid
    $why = $exception->getMessage();

    // Let's also get the response to have more info:
    $response = $exception->getResponse();
} catch (\Exception $exception) {
    // Catch any other exception...
}
```

### Complete reference

Here is a complete list of all methods:

CHARGE RELATED METHODS:

* array captureCharge(array $args = array())
* array createCharge(array $args = array())
* array getCharge(array $args = array())
* array getCharges(array $args = array())
* array refundCharge(array $args = array())
* array updateCharge(array $args = array())

CUSTOMER RELATED METHODS:

* array createCustomer(array $args = array())
* array deleteCustomer(array $args = array())
* array getCustomer(array $args = array())
* array getCustomers(array $args = array())
* array updateCustomer(array $args = array())

CARD RELATED METHODS:

* array createCard(array $args = array())
* array deleteCard(array $args = array())
* array getCard(array $args = array())
* array getCards(array $args = array())
* array updateCard(array $args = array())

SUBSCRIPTION RELATED METHODS:

* array cancelSubscription(array $args = array())
* array createSubscription(array $args = array())
* array getSubscription(array $args = array())
* array getSubscriptions(array $args = array())
* array updateSubscription(array $args = array())

PLAN RELATED METHODS:

* array createPlan(array $args = array())
* array deletePlan(array $args = array())
* array getPlan(array $args = array())
* array getPlans(array $args = array())
* array updatePlan(array $args = array())

COUPON RELATED METHODS:

* array createCoupon(array $args = array())
* array deleteCoupon(array $args = array())
* array getCoupon(array $args = array())
* array getCoupons(array $args = array())

DISCOUNT RELATED METHODS:

* array deleteCustomerDiscount(array $args = array())
* array deleteSubscriptionDiscount(array $args = array())

INVOICE RELATED METHODS:

* array createInvoice(array $args = array())
* array getInvoice(array $args = array())
* array getInvoiceLineItems(array $args = array())
* array getInvoices(array $args = array())
* array getUpcomingInvoice(array $args = array())
* array payInvoice(array $args = array())
* array updateInvoice(array $args = array())

INVOICE ITEM RELATED METHODS:

* array createInvoiceItem(array $args = array())
* array deleteInvoiceItem(array $args = array())
* array getInvoiceItem(array $args = array())
* array getInvoiceItems(array $args = array())
* array updateInvoiceItem(array $args = array())

DISPUTE RELATED METHODS:

* array closeDispute(array $args = array())
* array updateDispute(array $args = array())

TRANSFER RELATED METHODS:

* array cancelTransfer(array $args = array())
* array createTransfer(array $args = array())
* array getTransfer(array $args = array())
* array getTransfers(array $args = array())
* array updateTransfer(array $args = array())

RECIPIENT RELATED METHODS:

* array createRecipient(array $args = array())
* array deleteRecipient(array $args = array())
* array getRecipient(array $args = array())
* array getRecipients(array $args = array())
* array updateRecipient(array $args = array())

APPLICATION FEE RELATED METHODS:

* array getApplicationFee(array $args = array())
* array getApplicationFees(array $args = array())
* array refundApplicationFee(array $args = array())

TOKEN RELATED METHODS:

* array createCardToken(array $args = array())
* array createBankAccountToken(array $args = array())
* array getToken(array $args = array())

EVENT RELATED METHODS:

* array getEvent(array $args = array())
* array getEvents(array $args = array())

ACCOUNT RELATED METHODS:

* array getAccount(array $args = array())
