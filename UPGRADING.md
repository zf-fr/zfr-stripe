# From 2.x to 3.x

ZfrStripe 3 upgraded Guzzle from v3 to v5. In this version, iterators have been removed and must be now implemented
in user-land. ZfrStripe therefore implements a lightweight iterator that replaces previous Guzzle iterator. As a
consequence, a few things have changed.

The `setPageSize` method has been removed, in favour of explicitly using the standard `limit` parameter from Stripe.
This makes the client more coherent.

Before:

```php
$iterator = $stripeClient->getCustomersIterator();
$iterator->setPageSize(50);
```

After:

```php
$iterator = $stripeClient->getCustomersIterator(['limit' => 50]);
```

The `setLimit` (that was used to limit the **total** number of results) was confusing because it had the same name
as Stripe `limit` parameter. This method has been removed in favour of a new `setMaxResults` method. For instance,
to create an iterator that fetch a maximum number of 200 elements, with a limit of 50 elements per API call.

Before:

```php
$iterator = $stripeClient->getCustomersIterator();
$iterator->setPageSize(50);
$iterator->setLimit(200);
```

After:

```php
$iterator = $stripeClient->getCustomersIterator(['limit' => 50]);
$iterator->setMaxResults(200);
```