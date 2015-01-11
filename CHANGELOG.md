# 3.0.0

* ZfrStripe now uses Guzzle v5 (instead of v3). Usage of ZfrStripe does not change, except that Guzzle 5 is
substantially faster. This change has introduced a few breaking changes (those are documented in UPGRADING document)

# 2.8.1

* Add the new `tax_percent` property to subscriptions.

# 2.8.0

* [BC] Set default Stripe API to "2014-12-22" version

# 2.7.0

* [BC] Set default Stripe API to "2014-12-17" version. This version replaced the `statement_description` to
`statement_descriptor` for charges, plans, invoices and tranfers. Therefore, a new descriptor has been released for
versions starting at "2014-12-17".

# 2.6.0

* [BC] Set default Stripe API to "2014-12-08" version

# 2.5.0

* [BC] Set default Stripe API to "2014-11-20" version

# 2.4.0

* [BC] Set default Stripe API to "2014-11-05" version

# 2.3.6

* Add support for the new `reason` property when creating a refund.

# 2.3.5

* Fix IDE auto-completion hint for `getUpcomingInvoiceLineItems` method

# 2.3.4

* Add missing `getUpcomingInvoiceLineItems` endpoint. This can be used to retrieve all the invoice line items from
a given upcoming invoice.

# 2.3.3

* `forgiven` boolean was not properly encoded when updating an invoice.

# 2.3.2

* Add support for filtering deleted customers or not through the `deleted` parameter. Please note
that this feature **IS NOT** documented and officially supported by Stripe, and may be removed without caution.

# 2.3.1

* Add support for the new `shipping` array when creating charges.
* Add support for filtering charges if they are paid or not through the `paid` parameter. Please note
that this feature **IS NOT** documented and officially supported by Stripe, and may be removed without caution.

# 2.3.0

* [BC] Set default Stripe API to "2014-10-07" version
* ZfrStripe now uses PSR-4 for autoloading. This has flattened the structure of the libray, it should not break any of your code :).

# 2.2.4

* You can now use the shortcut `now` when setting or updating `trial_end` property.
* Add support for the new `billing_cycle_anchor` property when creating and updating a subscription.

# 2.2.3

* Fix a bug when filtering invoice items by date.

# 2.2.2

* Add support for filtering invoice items if they are proration or not through the `proration` parameter. Please note
that this feature **IS NOT** documented and officially supported by Stripe, and may be removed without caution.

# 2.2.1

* Add support for `object_id` when retrieving events. This allows to filter events by customer. Please note that
this feature **IS NOT** documented and officially supported by Stripe, but as it powers Stripe dashboard, it should
not be removed.

# 2.2.0

* The `getInvoiceLineItems` was not working correctly when pagination.
* [BC] For consistency with other resources, the `id` parameter for retrieving invoice line items has been rename
`invoice`.

# 2.1.0

* [BC] Set default Stripe API to "2014-09-08" version.

# 2.0.4

* Fix docblock to allow auto-completion on `getInvoiceLineItemsIterator`

# 2.0.3

* Balance transactions history for fee refund can be retrieved using the "fee_refund" type (Stripe documentation was
wrong)

# 2.0.2

* Fix `updateApplicationFeeRefund` method

# 2.0.1

* Fix error with exception name

# 2.0.0

* [BC] PHP minimum dependency has been raised to PHP 5.4
* [BC] Any descriptor before 2014-03-28 has been removed. If you need a previous version, please use 1.x branch.
* Add new method to update coupons.
* Add missing recipient card endpoints.
* API version can now be changed by using the same client.
* After some talk with Stripe developers, I realized I could simplify how versioning is done inside ZfrStripe. Starting
from v2, I will reuse the same descriptor until an endpoint actually changes (for instance, in January 2014 the endpoint
to get customer's subscriptions changed from "/customers/cus_abc/subscription" to "/customers/cus_abc_subscriptions"). However,
if a new endpoint is introduced, it can actually be accessed even for older versions so that we do not need to duplicate
the whole descriptor.

# 1.12.0

* [BC] Update latest API descriptor to 2014-08-20. This changes the response when getting disputes.

# 1.11.0

* [BC] Update latest API descriptor to 2014-08-04. This changes the response when getting transfers.

# 1.10.0

* [BC] Update latest API descriptor to 2014-07-26. This adds new endpoint for application fee refunds, and change
the endpoint to refund an application fee.

# 1.9.0

* [BC] Update latest API descriptor to 2014-07-22.

# 1.8.2

* Add the `statement_description` to invoice.
* Add the new `forgiven` property when updating an invoice for latest descriptor.

# 1.8.1

* Fix descriptor for refunds endpoint.

# 1.8.0

* [BC] The "Stripe-Version" header is now added to all requests. This allow to do API calls using another API version
than the one define in your Stripe dashboard (see doc for more details).
* [BC] Update latest API descriptor to 2014-06-17. It includes the following changes:
* Refunds is now a first-class resource, so you can retrieve, update and list refunds through specific methods.
* Allow dispute to have metadata (starting from 2014-06-17).
* Allow charges to have metadata (starting from 2014-06-17).
* Add the various "balance" methods that were missing. It has been backported to all descriptors.

# 1.7.2

* Add the new `receipt_email` property for charges.

# 1.7.1

* Add support for "day" interval for plans.

# 1.7.0

* [BC] Update latest API descriptor to 2014-05-19. This adds support for metadata in subscriptions.

# 1.6.1

* You can now set `statement_description` with `createPlan` and `updatePlan` methods (only for version starting
from 2014-03-28).

# 1.6.0

* Add new useful and more precise exceptions. This may be a minor BC. Before this release, ZfrStripe used to throw
a CardErrorException on 402. Now, it only throws this exception if the error type is `card_error`, otherwise it
throws a RequestFailedException. Alternatively, the ValidationErrorException has been replaced with a more generic
BadRequestException, which more closely follows Stripe API. Furthermore, an ApiRateLimitException has been added to
easily track an API rate limit error.

# 1.5.3

* Add missing `subscription` parameter to `getUpcomingInvoice` method since 2014-01-31

# 1.5.2

* Add the new `ending_before` property for the cursor-based pagination (from 2014-03-28 version only)

# 1.5.1

* Properly encode boolean values to "true" or "false" string, as required by Stripe API. The change has been applied
to all the previous service description.

# 1.5.0

* [BC] Update latest API descriptor to 2014-03-28. This adds support for the new cursor-based pagination. This version
removes the "offset" parameter, in favour of a new "starting_after" parameter. The new "limit" parameter is equivalent
to the old "count" parameter. If you use ZfrStripe iterators, this does not change anything for you.

# 1.4.0

* [BC] Update latest API descriptor to 2014-03-13. This adds a new "statement_description" for both creating charge and
transfer, and remove "statement_descriptor" from transfer.

# 1.3.1

* Fix a bug when setting a description for invoice items [#1]

# 1.3.0

* [BC] Update latest API descriptor to 2014-01-31
* Fix a bug when using iterators that always skipped the first element

# 1.2.0

* Add iterators

# 1.1.0

* Allow to reuse the same client with different API keys (useful when dealing with Stripe Connect)

# 1.0.0

* Initial release
