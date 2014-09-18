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
