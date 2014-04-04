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
