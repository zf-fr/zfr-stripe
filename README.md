ZfrStripe
=========

[![Latest Stable Version](https://poser.pugx.org/zfr/zfr-stripe/v/stable.png)](https://packagist.org/packages/zfr/zfr-stripe)

ZfrStripe is a modern PHP library based on Guzzle for [Stripe payment system](https://www.stripe.com).

## Dependencies

* PHP 5.4+
* [Guzzle](http://www.guzzlephp.org): >= 5.0

## Installation

Installation of ZfrStripe is only officially supported using Composer:

```sh
php composer.phar require zfr/zfr-stripe:3.*
```

## Tutorial

First, you need to instantiate the Stripe client, passing your private API key (you can find it in your Stripe
settings):

```php
$client = new StripeClient('my-api-key');
```

> You can change the API key for the client using the `setApiKey` method. This is useful if you are using Stripe
Connect and make both your own API calls and API calls on behalf of your users.

The currently latest supported version of the API is **2015-04-07**. You can (and should) also explicitly specify the version
of the client using the second parameter:

```php
$client = new StripeClient('my-api-key', '2015-04-07');
```

### Versioning

Stripe versions its API using a dated version ("2013-12-03", "2014-01-31"...). Their [versioning policy](https://stripe.com/docs/upgrades)
is to release a new dated version each time something changes in their API (for instance, if a response returns
new attributes, if new endpoint is added)...

Starting from v2, ZfrStripe does not follow this mechanism strictly, because new endpoints are actually also available for older versions of Stripe. We therefore only release a new descriptor each time an endpoint is **removed** or if its URL changes.

However, each new minor version (2.1.0 to 2.2.0 for instance) will update the Stripe API version to the latest available. This means that Stripe responses *may* change. This means that to keep BC you should either tighten your dependency (2.1.* instead of 2.* for instance) OR always specify the exact version you want, as shown above.

Currently, the following Stripe API versions are accepted by ZfrStripe: `2014-03-28`, `2014-05-19`, `2014-06-13`,
`2014-06-17`, `2014-07-22`,  `2014-07-26`,  `2014-08-04`, `2014-08-20`, `2014-09-08`, `2014-10-07`, `2014-11-05`,
`2014-11-20`, `2014-12-08`, `2014-12-17`, `2014-12-22`, `2015-01-11`, `2015-01-26`, `2015-02-10`, `2015-02-18`,
`2015-03-24`, `2015-04-07`. I will try to update the library as soon as new version are released.

> If you need support for older versions, please use branch v1 of ZfrStripe.

### How to use it?

Using the client is easy. For instance, here is how you'd create a new charge:

```php
$details = $client->createCharge([
    'amount'   => 500,
    'currency' => 'EUR',
    'customer' => 'cus_37EGGf4LMGgYy8'
]);
```

The parameters have a direct one-to-one mapping with the official documentation (for any reference, you can also
check the `ZfrStripe\Client\ServiceDescription\Stripe-v1.1.php` file). To know what the responses look like, please
refer to the [official API reference](https://stripe.com/docs/api).

#### Using a different Stripe API version

For each requests, we send the "Stripe-Version" header to Stripe. Usually, the best
way is to upgrade your API version globally in your Stripe dashboard. However, you may want to use two different versions in different part of your code, or test new features during development without changing it globally to your whole Stripe account.

To do that, you can explicitely set the wanted version in the constructor. Example:

```php
$stripeClient = new StripeClient('my-api-key', '2014-03-28');
```

You can dynamically change the version using the `setApiVersion` method:

```php
$stripeClient = new StripeClient('my-api-key', '2014-03-28');

// Responses will be formatted according to the 2014-03-28 version...

$stripeClient->setApiVersion('2014-08-20');

// Responses will now be formatted according to the 2014-08-20 version...
```

Alternatively, you can also create different Stripe clients.

#### Stripe Connect

If you are using Stripe Connect, you will want to make API calls on behalf of your client. You have nothing special
to do: just use the `setApiKey` method with the customer's access token:

```php
$client->setApiKey('my-customers-token');
// All API calls will be made on behalf of this customer now!
```

Please note that if you want to use again your own secret key, you will need to make a new call to this method.

#### Expand

All Stripe API requests have support to expand some nested objects inside responses. Therefore, ZfrStripe supports this
through the `expand` parameter, which must be an array:

```php
$details = $client->getCharges([
    'expand' => ['customer']
]);
```

#### Iterators

You may want to retrieve a list of customers, events or charges. Instead of manually doing all the requests yourself,
you can use iterators. ZfrStripe provides iterators for all iterable resources:

```php
$iterator = $client->getCustomersIterator();

foreach ($iterator as $user) {
    // Do something
}
```

By default, ZfrStripe will implicitly add the limit parameter to 100 (the maximum page size allowed by Stripe API). You
may want to lower this limit by explicitly passing the `limit` parameter. You can limit the maximum number of elements
you want to retrive (in total) by calling the `setMaxResults` method on the iterator.

With iterators, you can still use any API parameters. For instance, this will retrieve all the events
that have the event `customer.subscription.updated`, doing a new API call each 50 elements (this means that only
up to 50 elements are stored in memory), setting a limit of maximum 500 elements to retrieve:

```php
$iterator = $client->getEventsIterator(array('type' => 'customer.subscription.updated'));
$iterator->MaxResults(500);

foreach ($iterator as $event) {
    // Do something
}
```

You can also take advantage of Stripe [cursor-based pagination](https://stripe.com/docs/api#pagination):

```php
$iterator = $client->getInvoicesIterator(['starting_after' => 'in_abcdef');

foreach ($iterator as $invoices) {
    // Do something
}
```

ZfrStripe takes care of fetching the last item in the batch, extracting the id, and continuing doing requests
until no more data is available (or more results than "maxResults" have been fetched)!

#### Undocumented features

While playing with Stripe API, I realized that the API has a few filtering capabilities that were not documented,
but still accessible. Therefore, I've added some of them to this library but PLEASE be very defensive when you
use them, as Stripe may remove them (or maybe officially document them in the future). Here is a list of the
implemented hidden features:

##### Filter events

You can filter events by a object id using the `object_id` parameter. It will depend of the context. For instance
if you are specifically retrieving subscription events, the `object_id` will allow to filter by subscription:

```php
$events = $client->getEvents(['object_id' => 'cus_abc', 'type' => 'customer.*']);
```

##### Retrieve deleted customers

You can retrieve deleted customers by using the `deleted` boolean:

```php
$customers = $client->getCustomers(['deleted' => true]);
```

##### Retrieve non-paid charges

You can retrieve non paid charges by using the `paid` boolean:

```php
$notPaidCharges = $client->getCharges(['paid' => false]);
```

##### Retrieve proration items

You can retrieve proration invoice items only by using the `proration` boolean:

```php
$invoiceItems = $client->getInvoiceItems(['proration' => true]);
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
* `ZfrStripe\Exception\ApiRateLimitException`: occurs when you have reached the Stripe API limit.
* `ZfrStripe\Exception\BadRequestException`: occurs for 400 error code.
* `ZfrStripe\Exception\CardErrorException`: occurs for any card errors. According to Stripe, this error happen when
parameters were valid but the request failed (for instance if a card CVC is invalid).
* `ZfrStripe\Exception\NotFoundException`: is thrown whenever client receives a 404 exception.
* `ZfrStripe\Exception\RequestFailedException`: occurs for generic 402 error.
* `ZfrStripe\Exception\ServerErrorException`: any errors where Stripe is likely to be doing something wrong...

Usage:

```php
use ZfrStripe\Exception\TransactionErrorException;

try {
    $client->createCard([
        'card' => [
            'number'    => '4242424242424242',
            'exp_month' => '01',
            'exp_year'  => '2016'
        ]
    ]);
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

RECIPIENT CARD RELATED METHODS:

* array createRecipientCard(array $args = array())
* array deleteRecipientCard(array $args = array())
* array getRecipientCard(array $args = array())
* array getRecipientCards(array $args = array())
* array updateRecipientCard(array $args = array())

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
* array updateCoupon(array $args = array())

DISCOUNT RELATED METHODS:

* array deleteCustomerDiscount(array $args = array())
* array deleteSubscriptionDiscount(array $args = array())

INVOICE RELATED METHODS:

* array createInvoice(array $args = array())
* array getInvoice(array $args = array())
* array getInvoiceLineItems(array $args = array())
* array getInvoices(array $args = array())
* array getUpcomingInvoice(array $args = array())
* array getUpcomingInvoiceLineItems(array $args = array())
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

REFUND RELATED METHODS:

* array getRefund(array $args = array())
* array getRefunds(array $args = array())
* array updateRefund(array $args = array())

APPLICATION FEE RELATED METHODS:

* array getApplicationFee(array $args = array())
* array getApplicationFees(array $args = array())
* array refundApplicationFee(array $args = array())

BALANCE RELATED METHODS:

* array getAccountBalance(array $args = array())
* array getBalanceTransaction(array $args = array())
* array getBalanceTransactions(array $args = array())

TOKEN RELATED METHODS:

* array createCardToken(array $args = array())
* array createBankAccountToken(array $args = array())
* array getToken(array $args = array())

EVENT RELATED METHODS:

* array getEvent(array $args = array())
* array getEvents(array $args = array())

ACCOUNT RELATED METHODS:

* array getAccount(array $args = array())
