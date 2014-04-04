<?php
/*
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR
 * A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT
 * OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL,
 * SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT
 * LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE,
 * DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY
 * THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE
 * OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 *
 * This software consists of voluntary contributions made by many individuals
 * and is licensed under the MIT license.
 */

$errors = array(
    array(
        'class' => 'ZfrStripe\Exception\ValidationErrorException',
        'code'  => 400
    ),
    array(
        'class' => 'ZfrStripe\Exception\UnauthorizedException',
        'code'  => 401
    ),
    array(
        'class' => 'ZfrStripe\Exception\CardErrorException',
        'code'  => 402
    ),
    array(
        'class' => 'ZfrStripe\Exception\NotFoundException',
        'code'  => 404
    ),
    array(
        'class' => 'ZfrStripe\Exception\ServerErrorException',
        'code'  => 500
    ),
    array(
        'class' => 'ZfrStripe\Exception\ServerErrorException',
        'code'  => 502
    ),
    array(
        'class' => 'ZfrStripe\Exception\ServerErrorException',
        'code'  => 503
    ),
    array(
        'class' => 'ZfrStripe\Exception\ServerErrorException',
        'code'  => 504
    )
);

return array(
    'name'        => 'Stripe',
    'apiVersion'  => '2014-01-31',
    'baseUrl'     => 'https://api.stripe.com',
    'description' => 'Stripe is a payment system',
    'operations'  => array(
        /**
         * --------------------------------------------------------------------------------
         * CHARGES RELATED METHODS
         *
         * DOC: https://stripe.com/docs/api#charges
         * --------------------------------------------------------------------------------
         */
        'CaptureCharge' => array(
            'httpMethod'       => 'POST',
            'uri'              => '/v1/charges/{id}/capture',
            'summary'          => 'Capture an existing charge',
            'errorResponses'   => $errors,
            'parameters'       => array(
                'id' => array(
                    'description' => 'Unique identifier of the charge',
                    'location'    => 'uri',
                    'type'        => 'string',
                    'required'    => true
                ),
                'amount' => array(
                    'description' => 'Amount (in cents) to capture',
                    'location'    => 'query',
                    'type'        => 'integer',
                    'required'    => false
                ),
                'application_fee' => array(
                    'description' => 'A fee in cents that will be applied to the charge and transferred to the application owner\'s Stripe account',
                    'location'    => 'query',
                    'type'        => 'integer',
                    'required'    => false
                ),
                'expand' => array(
                    'description' => 'Allow to expand some properties',
                    'location'    => 'query',
                    'type'        => 'array',
                    'required'    => false
                )
            )
        ),

        'CreateCharge' => array(
            'httpMethod'       => 'POST',
            'uri'              => '/v1/charges',
            'summary'          => 'Create a new charge (either card or customer is needed)',
            'errorResponses'   => $errors,
            'parameters'       => array(
                'amount' => array(
                    'description' => 'Amount (in cents)',
                    'location'    => 'query',
                    'type'        => 'integer',
                    'required'    => true
                ),
                'currency' => array(
                    'description' => '3-letter ISO code for currency',
                    'location'    => 'query',
                    'type'        => 'string',
                    'required'    => true
                ),
                'customer' => array(
                    'description' => 'Unique client identifier',
                    'location'    => 'query',
                    'type'        => 'string',
                    'required'    => false
                ),
                'card' => array(
                    'description' => 'Unique card identifier (can either be an ID or a hash)',
                    'location'    => 'query',
                    'type'        => array('string', 'array'),
                    'required'    => false
                ),
                'capture' => array(
                    'description' => 'Whether or not to immediately capture the charge',
                    'location'    => 'query',
                    'type'        => 'boolean',
                    'filters'     => array('ZfrStripe\Client\Filter\BooleanFilter::encodeValue'),
                    'required'    => false
                ),
                'description' => array(
                    'description' => 'Optional description for the charge',
                    'location'    => 'query',
                    'type'        => 'string',
                    'required'    => false
                ),
                'metadata' => array(
                    'description' => 'Optional metadata',
                    'location'    => 'query',
                    'type'        => 'array',
                    'required'    => false
                ),
                'application_fee' => array(
                    'description' => 'A fee in cents that will be applied to the charge and transferred to the application owner\'s Stripe account',
                    'location'    => 'query',
                    'type'        => 'integer',
                    'required'    => false
                ),
                'expand' => array(
                    'description' => 'Allow to expand some properties',
                    'location'    => 'query',
                    'type'        => 'array',
                    'required'    => false
                )
            )
        ),

        'GetCharge' => array(
            'httpMethod'       => 'GET',
            'uri'              => '/v1/charges/{id}',
            'summary'          => 'Get an existing charge',
            'errorResponses'   => $errors,
            'parameters'       => array(
                'id' => array(
                    'description' => 'Unique identifier of the charge',
                    'location'    => 'uri',
                    'type'        => 'string',
                    'required'    => true
                ),
                'expand' => array(
                    'description' => 'Allow to expand some properties',
                    'location'    => 'query',
                    'type'        => 'array',
                    'required'    => false
                )
            )
        ),

        'GetCharges' => array(
            'httpMethod'       => 'GET',
            'uri'              => '/v1/charges',
            'summary'          => 'Get existing charges',
            'errorResponses'   => $errors,
            'parameters'       => array(
                'count' => array(
                    'description' => 'Limit on how many charges are retrieved',
                    'location'    => 'query',
                    'type'        => 'integer',
                    'min'         => 1,
                    'max'         => 100,
                    'required'    => false
                ),
                'offset' => array(
                    'description' => 'Offset into the list of returned items',
                    'location'    => 'query',
                    'type'        => 'integer',
                    'required'    => false
                ),
                'created' => array(
                    'description' => 'A filter based on the "created" field. Can be an exact UTC timestamp, or a hash',
                    'location'    => 'query',
                    'type'        => array('string', 'array'),
                    'required'    => false
                ),
                'customer' => array(
                    'description' => 'Only return charges for a specific customer',
                    'location'    => 'query',
                    'type'        => 'string',
                    'required'    => false
                ),
                'expand' => array(
                    'description' => 'Allow to expand some properties',
                    'location'    => 'query',
                    'type'        => 'array',
                    'required'    => false
                )
            )
        ),

        'RefundCharge' => array(
            'httpMethod'       => 'POST',
            'uri'              => '/v1/charges/{id}/refund',
            'summary'          => 'Refund an existing charge',
            'errorResponses'   => $errors,
            'parameters'       => array(
                'id' => array(
                    'description' => 'Unique identifier of the charge',
                    'location'    => 'uri',
                    'type'        => 'string',
                    'required'    => true
                ),
                'amount' => array(
                    'description' => 'Amount (in cents) - default to the whole charge',
                    'location'    => 'query',
                    'type'        => 'integer',
                    'required'    => false
                ),
                'refund_application_fee' => array(
                    'description' => 'Indicate whether the application fee should be refunded when refunding this charge',
                    'location'    => 'query',
                    'type'        => 'boolean',
                    'filters'     => array('ZfrStripe\Client\Filter\BooleanFilter::encodeValue'),
                    'required'    => false
                ),
                'expand' => array(
                    'description' => 'Allow to expand some properties',
                    'location'    => 'query',
                    'type'        => 'array',
                    'required'    => false
                )
            )
        ),

        'UpdateCharge' => array(
            'httpMethod'       => 'POST',
            'uri'              => '/v1/charges/{id}',
            'summary'          => 'Update an existing charge',
            'errorResponses'   => $errors,
            'parameters'       => array(
                'id' => array(
                    'description' => 'Unique identifier of the charge to update',
                    'location'    => 'uri',
                    'type'        => 'string',
                    'required'    => true
                ),
                'description' => array(
                    'description' => 'Optional description for the charge',
                    'location'    => 'query',
                    'type'        => 'string',
                    'required'    => false
                ),
                'metadata' => array(
                    'description' => 'Optional metadata',
                    'location'    => 'query',
                    'type'        => 'array',
                    'required'    => false
                ),
                'expand' => array(
                    'description' => 'Allow to expand some properties',
                    'location'    => 'query',
                    'type'        => 'array',
                    'required'    => false
                )
            )
        ),

        /**
         * --------------------------------------------------------------------------------
         * CUSTOMER RELATED METHODS
         *
         * DOC: https://stripe.com/docs/api#customers
         * --------------------------------------------------------------------------------
         */
        'CreateCustomer' => array(
            'httpMethod'       => 'POST',
            'uri'              => '/v1/customers',
            'summary'          => 'Create a new customer (either card or customer is needed)',
            'errorResponses'   => $errors,
            'parameters'       => array(
                'account_balance' => array(
                    'description' => 'An integer amount in cents that is the starting account balance for your customer',
                    'location'    => 'query',
                    'type'        => 'integer',
                    'required'    => false
                ),
                'card' => array(
                    'description' => 'Unique card identifier (can either be an ID or a hash)',
                    'location'    => 'query',
                    'type'        => array('string', 'array'),
                    'required'    => false
                ),
                'coupon' => array(
                    'description' => 'Optional coupon identifier that applies a discount on all recurring charges',
                    'location'    => 'query',
                    'type'        => 'string',
                    'required'    => false
                ),
                'plan' => array(
                    'description' => 'Optional plan for the customer',
                    'location'    => 'query',
                    'type'        => 'string',
                    'required'    => false
                ),
                'quantity' => array(
                    'description' => 'Quantity you\'d like to apply to the subscription you\'re creating',
                    'location'    => 'query',
                    'type'        => 'string',
                    'required'    => false
                ),
                'trial_end' => array(
                    'description' => 'UTC integer timestamp representing the end of the trial period the customer will get before being charged for the first time',
                    'location'    => 'query',
                    'type'        => 'integer',
                    'required'    => false
                ),
                'description' => array(
                    'description' => 'Optional description for the customer',
                    'location'    => 'query',
                    'type'        => 'string',
                    'required'    => false
                ),
                'email' => array(
                    'description' => 'Optional customer\'s email address',
                    'location'    => 'query',
                    'type'        => 'string',
                    'required'    => false
                ),
                'metadata' => array(
                    'description' => 'Optional metadata',
                    'location'    => 'query',
                    'type'        => 'array',
                    'required'    => false
                ),
                'expand' => array(
                    'description' => 'Allow to expand some properties',
                    'location'    => 'query',
                    'type'        => 'array',
                    'required'    => false
                )
            )
        ),

        'DeleteCustomer' => array(
            'httpMethod'       => 'DELETE',
            'uri'              => '/v1/customers/{id}',
            'summary'          => 'Delete an existing customer',
            'errorResponses'   => $errors,
            'parameters'       => array(
                'id' => array(
                    'description' => 'Unique identifier of the customer',
                    'location'    => 'uri',
                    'type'        => 'string',
                    'required'    => true
                ),
                'expand' => array(
                    'description' => 'Allow to expand some properties',
                    'location'    => 'query',
                    'type'        => 'array',
                    'required'    => false
                )
            )
        ),

        'GetCustomer' => array(
            'httpMethod'       => 'GET',
            'uri'              => '/v1/customers/{id}',
            'summary'          => 'Get an existing customer',
            'errorResponses'   => $errors,
            'parameters'       => array(
                'id' => array(
                    'description' => 'Unique identifier of the customer',
                    'location'    => 'uri',
                    'type'        => 'string',
                    'required'    => true
                ),
                'expand' => array(
                    'description' => 'Allow to expand some properties',
                    'location'    => 'query',
                    'type'        => 'array',
                    'required'    => false
                )
            )
        ),

        'GetCustomers' => array(
            'httpMethod'       => 'GET',
            'uri'              => '/v1/customers',
            'summary'          => 'Get existing customers',
            'errorResponses'   => $errors,
            'parameters'       => array(
                'count' => array(
                    'description' => 'Limit on how many customers are retrieved',
                    'location'    => 'query',
                    'type'        => 'integer',
                    'min'         => 1,
                    'max'         => 100,
                    'required'    => false
                ),
                'offset' => array(
                    'description' => 'Offset into the list of returned items',
                    'location'    => 'query',
                    'type'        => 'integer',
                    'required'    => false
                ),
                'created' => array(
                    'description' => 'A filter based on the "created" field. Can be an exact UTC timestamp, or a hash',
                    'location'    => 'query',
                    'type'        => array('string', 'array'),
                    'required'    => false
                ),
                'expand' => array(
                    'description' => 'Allow to expand some properties',
                    'location'    => 'query',
                    'type'        => 'array',
                    'required'    => false
                )
            )
        ),

        'UpdateCustomer' => array(
            'httpMethod'       => 'POST',
            'uri'              => '/v1/customers/{id}',
            'summary'          => 'Update an existing customer',
            'errorResponses'   => $errors,
            'parameters'       => array(
                'id' => array(
                    'description' => 'Unique identifier of the customer to update',
                    'location'    => 'uri',
                    'type'        => 'string',
                    'required'    => true
                ),
                'account_balance' => array(
                    'description' => 'An integer amount in cents that is the starting account balance for your customer',
                    'location'    => 'query',
                    'type'        => 'integer',
                    'required'    => false
                ),
                'card' => array(
                    'description' => 'Unique card identifier (can either be an ID or a hash)',
                    'location'    => 'query',
                    'type'        => array('string', 'array'),
                    'required'    => false
                ),
                'default_card' => array(
                    'description' => 'Default card identifier',
                    'location'    => 'query',
                    'type'        => 'string',
                    'required'    => false
                ),
                'coupon' => array(
                    'description' => 'Optional coupon identifier that applies a discount on all recurring charges',
                    'location'    => 'query',
                    'type'        => 'string',
                    'required'    => false
                ),
                'description' => array(
                    'description' => 'Optional description for the customer',
                    'location'    => 'query',
                    'type'        => 'string',
                    'required'    => false
                ),
                'email' => array(
                    'description' => 'Optional customer\'s email address',
                    'location'    => 'query',
                    'type'        => 'string',
                    'required'    => false
                ),
                'metadata' => array(
                    'description' => 'Optional metadata',
                    'location'    => 'query',
                    'type'        => 'array',
                    'required'    => false
                ),
                'expand' => array(
                    'description' => 'Allow to expand some properties',
                    'location'    => 'query',
                    'type'        => 'array',
                    'required'    => false
                )
            )
        ),

        /**
         * --------------------------------------------------------------------------------
         * CARD RELATED METHODS
         *
         * DOC: https://stripe.com/docs/api#cards
         * --------------------------------------------------------------------------------
         */
        'CreateCard' => array(
            'httpMethod'       => 'POST',
            'uri'              => '/v1/customers/{customer}/cards',
            'summary'          => 'Create a new card for a customer',
            'errorResponses'   => $errors,
            'parameters'       => array(
                'customer' => array(
                    'description' => 'Unique identifier of the customer',
                    'location'    => 'uri',
                    'type'        => 'string',
                    'required'    => true
                ),
                'card' => array(
                    'description' => 'Unique card identifier (can either be an ID or a hash)',
                    'location'    => 'query',
                    'type'        => array('string', 'array'),
                    'required'    => false
                ),
                'expand' => array(
                    'description' => 'Allow to expand some properties',
                    'location'    => 'query',
                    'type'        => 'array',
                    'required'    => false
                )
            )
        ),

        'DeleteCard' => array(
            'httpMethod'       => 'DELETE',
            'uri'              => '/v1/customers/{customer}/cards/{id}',
            'summary'          => 'Delete an existing customer\'s card',
            'errorResponses'   => $errors,
            'parameters'       => array(
                'id' => array(
                    'description' => 'Unique identifier of the card to delete',
                    'location'    => 'uri',
                    'type'        => 'string',
                    'required'    => true
                ),
                'customer' => array(
                    'description' => 'Unique identifier of the customer to delete the card',
                    'location'    => 'uri',
                    'type'        => 'string',
                    'required'    => true
                ),
                'expand' => array(
                    'description' => 'Allow to expand some properties',
                    'location'    => 'query',
                    'type'        => 'array',
                    'required'    => false
                )
            )
        ),

        'GetCard' => array(
            'httpMethod'       => 'GET',
            'uri'              => '/v1/customers/{customer}/cards/{id}',
            'summary'          => 'Get an existing customer\'s card',
            'errorResponses'   => $errors,
            'parameters'       => array(
                'id' => array(
                    'description' => 'Unique identifier of the card to get',
                    'location'    => 'uri',
                    'type'        => 'string',
                    'required'    => true
                ),
                'customer' => array(
                    'description' => 'Unique identifier of the customer to get the card from',
                    'location'    => 'uri',
                    'type'        => 'string',
                    'required'    => true
                ),
                'expand' => array(
                    'description' => 'Allow to expand some properties',
                    'location'    => 'query',
                    'type'        => 'array',
                    'required'    => false
                )
            )
        ),

        'GetCards' => array(
            'httpMethod'       => 'GET',
            'uri'              => '/v1/customers/{customer}/cards',
            'summary'          => 'Get existing customers\'s cards',
            'errorResponses'   => $errors,
            'parameters'       => array(
                'customer' => array(
                    'description' => 'Unique identifier of the customer to get the cards from',
                    'location'    => 'uri',
                    'type'        => 'string',
                    'required'    => true
                ),
                'count' => array(
                    'description' => 'Limit on how many cards are retrieved',
                    'location'    => 'query',
                    'type'        => 'integer',
                    'min'         => 1,
                    'max'         => 100,
                    'required'    => false
                ),
                'offset' => array(
                    'description' => 'Offset into the list of returned items',
                    'location'    => 'query',
                    'type'        => 'integer',
                    'required'    => false
                ),
                'expand' => array(
                    'description' => 'Allow to expand some properties',
                    'location'    => 'query',
                    'type'        => 'array',
                    'required'    => false
                )
            )
        ),

        'UpdateCard' => array(
            'httpMethod'       => 'POST',
            'uri'              => '/v1/customers/{customer}/cards/{id}',
            'summary'          => 'Update an existing customer',
            'errorResponses'   => $errors,
            'parameters'       => array(
                'id' => array(
                    'description' => 'Unique identifier of the card to update',
                    'location'    => 'uri',
                    'type'        => 'string',
                    'required'    => true
                ),
                'customer' => array(
                    'description' => 'Unique identifier of the customer to get the card from',
                    'location'    => 'uri',
                    'type'        => 'string',
                    'required'    => true
                ),
                'address_city' => array(
                    'location' => 'query',
                    'type'     => 'string',
                    'required' => false
                ),
                'address_country' => array(
                    'location' => 'query',
                    'type'     => 'string',
                    'required' => false
                ),
                'address_line1' => array(
                    'location' => 'query',
                    'type'     => 'string',
                    'required' => false
                ),
                'address_line2' => array(
                    'location' => 'query',
                    'type'     => 'string',
                    'required' => false
                ),
                'address_state' => array(
                    'location' => 'query',
                    'type'     => 'string',
                    'required' => false
                ),
                'address_zip' => array(
                    'location' => 'query',
                    'type'     => 'string',
                    'required' => false
                ),
                'exp_month' => array(
                    'location' => 'query',
                    'type'     => 'string',
                    'required' => false
                ),
                'exp_year' => array(
                    'location' => 'query',
                    'type'     => 'string',
                    'required' => false
                ),
                'name' => array(
                    'location' => 'query',
                    'type'     => 'string',
                    'required' => false
                ),
                'expand' => array(
                    'description' => 'Allow to expand some properties',
                    'location'    => 'query',
                    'type'        => 'array',
                    'required'    => false
                )
            )
        ),

        /**
         * --------------------------------------------------------------------------------
         * SUBSCRIPTION RELATED METHODS
         *
         * DOC: https://stripe.com/docs/api#subscriptions
         * --------------------------------------------------------------------------------
         */
        'CancelSubscription' => array(
            'httpMethod'       => 'DELETE',
            'uri'              => '/v1/customers/{customer}/subscriptions/{id}',
            'summary'          => 'Delete an existing customer\'s subscription',
            'errorResponses'   => $errors,
            'parameters'       => array(
                'id' => array(
                    'description' => 'Unique identifier of the subscription to cancel',
                    'location'    => 'uri',
                    'type'        => 'string',
                    'required'    => true
                ),
                'customer' => array(
                    'description' => 'Unique identifier of the customer to delete the card',
                    'location'    => 'uri',
                    'type'        => 'string',
                    'required'    => true
                ),
                'at_period_end' => array(
                    'description' => 'A flag that if set to true will delay the cancellation of the subscription until the end of the current period.',
                    'location'    => 'query',
                    'type'        => 'boolean',
                    'filters'     => array('ZfrStripe\Client\Filter\BooleanFilter::encodeValue'),
                    'required'    => false
                ),
                'expand' => array(
                    'description' => 'Allow to expand some properties',
                    'location'    => 'query',
                    'type'        => 'array',
                    'required'    => false
                )
            )
        ),

        'CreateSubscription' => array(
            'httpMethod'       => 'POST',
            'uri'              => '/v1/customers/{customer}/subscriptions',
            'summary'          => 'Create a customer\'s new subscription',
            'errorResponses'   => $errors,
            'parameters'       => array(
                'customer' => array(
                    'description' => 'Unique identifier of the customer',
                    'location'    => 'uri',
                    'type'        => 'string',
                    'required'    => true
                ),
                'plan' => array(
                    'description' => 'Unique plan identifier',
                    'location'    => 'query',
                    'type'        => 'string',
                    'required'    => true
                ),
                'quantity' => array(
                    'description' => 'Quantity you\'d like to apply to the subscription you\'re creating',
                    'location'    => 'query',
                    'type'        => 'string',
                    'required'    => false
                ),
                'card' => array(
                    'description' => 'Unique card identifier (can either be an ID or a hash)',
                    'location'    => 'query',
                    'type'        => array('string', 'array'),
                    'required'    => false
                ),
                'coupon' => array(
                    'description' => 'Optional coupon identifier that applies a discount at the same time as creating the subscription',
                    'location'    => 'query',
                    'type'        => 'string',
                    'required'    => false
                ),
                'trial_end' => array(
                    'description' => 'UTC integer timestamp representing the end of the trial period the customer will get before being charged for the first time',
                    'location'    => 'query',
                    'type'        => 'integer',
                    'required'    => false
                ),
                'application_fee_percent' => array(
                    'description' => 'A positive decimal (with at most two decimal places) between 1 and 100 that represents the percentage of the subscription invoice amount due each billing period that will be transferred to the application owner’s Stripe account',
                    'location'    => 'query',
                    'type'        => 'string',
                    'required'    => false
                ),
                'expand' => array(
                    'description' => 'Allow to expand some properties',
                    'location'    => 'query',
                    'type'        => 'array',
                    'required'    => false
                )
            )
        ),

        'GetSubscription' => array(
            'httpMethod'       => 'GET',
            'uri'              => '/v1/customers/{customer}/subscriptions/{id}',
            'summary'          => 'Get an existing customer\'s active subscription',
            'errorResponses'   => $errors,
            'parameters'       => array(
                'id' => array(
                    'description' => 'Unique identifier of the active subscription to get',
                    'location'    => 'uri',
                    'type'        => 'string',
                    'required'    => true
                ),
                'customer' => array(
                    'description' => 'Unique identifier of the customer to get the subscription from',
                    'location'    => 'uri',
                    'type'        => 'string',
                    'required'    => true
                ),
                'expand' => array(
                    'description' => 'Allow to expand some properties',
                    'location'    => 'query',
                    'type'        => 'array',
                    'required'    => false
                )
            )
        ),

        'GetSubscriptions' => array(
            'httpMethod'       => 'GET',
            'uri'              => '/v1/customers/{customer}/subscriptions',
            'summary'          => 'Get existing customers\'s active subscriptions',
            'errorResponses'   => $errors,
            'parameters'       => array(
                'customer' => array(
                    'description' => 'Unique identifier of the customer to get the subscriptions from',
                    'location'    => 'uri',
                    'type'        => 'string',
                    'required'    => true
                ),
                'count' => array(
                    'description' => 'Limit on how many subscriptions are retrieved',
                    'location'    => 'query',
                    'type'        => 'integer',
                    'min'         => 1,
                    'max'         => 100,
                    'required'    => false
                ),
                'offset' => array(
                    'description' => 'Offset into the list of returned items',
                    'location'    => 'query',
                    'type'        => 'integer',
                    'required'    => false
                ),
                'expand' => array(
                    'description' => 'Allow to expand some properties',
                    'location'    => 'query',
                    'type'        => 'array',
                    'required'    => false
                )
            )
        ),

        'UpdateSubscription' => array(
            'httpMethod'       => 'POST',
            'uri'              => '/v1/customers/{customer}/subscriptions/{id}',
            'summary'          => 'Update a customer\'s subscription',
            'errorResponses'   => $errors,
            'parameters'       => array(
                'id' => array(
                    'description' => 'Unique identifier of the subscription to update',
                    'location'    => 'uri',
                    'type'        => 'string',
                    'required'    => true
                ),
                'customer' => array(
                    'description' => 'Unique identifier of the customer',
                    'location'    => 'uri',
                    'type'        => 'string',
                    'required'    => true
                ),
                'plan' => array(
                    'description' => 'Unique plan identifier',
                    'location'    => 'query',
                    'type'        => 'string',
                    'required'    => true
                ),
                'quantity' => array(
                    'description' => 'Quantity you\'d like to apply to the subscription you\'re creating',
                    'location'    => 'query',
                    'type'        => 'string',
                    'required'    => false
                ),
                'card' => array(
                    'description' => 'Unique card identifier (can either be an ID or a hash)',
                    'location'    => 'query',
                    'type'        => array('string', 'array'),
                    'required'    => false
                ),
                'coupon' => array(
                    'description' => 'Optional coupon identifier that applies a discount at the same time as creating the subscription',
                    'location'    => 'query',
                    'type'        => 'string',
                    'required'    => false
                ),
                'prorate' => array(
                    'description' => 'Flag telling us whether to prorate switching plans during a billing cycle',
                    'location'    => 'query',
                    'type'        => 'boolean',
                    'filters'     => array('ZfrStripe\Client\Filter\BooleanFilter::encodeValue'),
                    'required'    => false
                ),
                'trial_end' => array(
                    'description' => 'UTC integer timestamp representing the end of the trial period the customer will get before being charged for the first time',
                    'location'    => 'query',
                    'type'        => 'integer',
                    'required'    => false
                ),
                'application_fee_percent' => array(
                    'description' => 'A positive decimal (with at most two decimal places) between 1 and 100 that represents the percentage of the subscription invoice amount due each billing period that will be transferred to the application owner’s Stripe account',
                    'location'    => 'query',
                    'type'        => 'string',
                    'required'    => false
                ),
                'expand' => array(
                    'description' => 'Allow to expand some properties',
                    'location'    => 'query',
                    'type'        => 'array',
                    'required'    => false
                )
            )
        ),

        /**
         * --------------------------------------------------------------------------------
         * PLAN RELATED METHODS
         *
         * DOC: https://stripe.com/docs/api#plans
         * --------------------------------------------------------------------------------
         */
        'CreatePlan' => array(
            'httpMethod'       => 'POST',
            'uri'              => '/v1/plans',
            'summary'          => 'Create a new plan',
            'errorResponses'   => $errors,
            'parameters'       => array(
                'id' => array(
                    'description' => 'Unique string to identify the plan',
                    'location'    => 'query',
                    'type'        => 'string',
                    'required'    => true
                ),
                'name' => array(
                    'description' => 'Unique name of the plan',
                    'location'    => 'query',
                    'type'        => 'string',
                    'required'    => true
                ),
                'amount' => array(
                    'description' => 'Amount (in cents)',
                    'location'    => 'query',
                    'type'        => 'integer',
                    'required'    => true
                ),
                'currency' => array(
                    'description' => '3-letter ISO code for currency',
                    'location'    => 'query',
                    'type'        => 'string',
                    'required'    => true
                ),
                'interval' => array(
                    'description' => 'Specify the billing frequency',
                    'location'    => 'query',
                    'type'        => 'string',
                    'required'    => true,
                    'enum'        => array('week', 'month', 'year')
                ),
                'interval_count' => array(
                    'description' => 'Number of interval between each subscription billing',
                    'location'    => 'query',
                    'type'        => 'integer',
                    'required'    => false
                ),
                'trial_period_days' => array(
                    'description' => 'Specifies a trial period in (an integer number of) days',
                    'location'    => 'query',
                    'type'        => 'integer',
                    'required'    => false
                ),
                'metadata' => array(
                    'description' => 'Optional metadata',
                    'location'    => 'query',
                    'type'        => 'array',
                    'required'    => false
                ),
                'expand' => array(
                    'description' => 'Allow to expand some properties',
                    'location'    => 'query',
                    'type'        => 'array',
                    'required'    => false
                )
            )
        ),

        'DeletePlan' => array(
            'httpMethod'       => 'DELETE',
            'uri'              => '/v1/plans/{id}',
            'summary'          => 'Delete an existing plan',
            'errorResponses'   => $errors,
            'parameters'       => array(
                'id' => array(
                    'description' => 'Unique identifier of the plan',
                    'location'    => 'uri',
                    'type'        => 'string',
                    'required'    => true
                ),
                'expand' => array(
                    'description' => 'Allow to expand some properties',
                    'location'    => 'query',
                    'type'        => 'array',
                    'required'    => false
                )
            )
        ),

        'GetPlan' => array(
            'httpMethod'       => 'GET',
            'uri'              => '/v1/plans/{id}',
            'summary'          => 'Get an existing plan',
            'errorResponses'   => $errors,
            'parameters'       => array(
                'id' => array(
                    'description' => 'Unique identifier of the plan',
                    'location'    => 'uri',
                    'type'        => 'string',
                    'required'    => true
                ),
                'expand' => array(
                    'description' => 'Allow to expand some properties',
                    'location'    => 'query',
                    'type'        => 'array',
                    'required'    => false
                )
            )
        ),

        'GetPlans' => array(
            'httpMethod'       => 'GET',
            'uri'              => '/v1/plans',
            'summary'          => 'Get existing plans',
            'errorResponses'   => $errors,
            'parameters'       => array(
                'count' => array(
                    'description' => 'Limit on how many plans are retrieved',
                    'location'    => 'query',
                    'type'        => 'integer',
                    'min'         => 1,
                    'max'         => 100,
                    'required'    => false
                ),
                'offset' => array(
                    'description' => 'Offset into the list of returned items',
                    'location'    => 'query',
                    'type'        => 'integer',
                    'required'    => false
                ),
                'expand' => array(
                    'description' => 'Allow to expand some properties',
                    'location'    => 'query',
                    'type'        => 'array',
                    'required'    => false
                )
            )
        ),

        'UpdatePlan' => array(
            'httpMethod'       => 'POST',
            'uri'              => '/v1/plans/{id}',
            'summary'          => 'Update an existing plan',
            'errorResponses'   => $errors,
            'parameters'       => array(
                'id' => array(
                    'description' => 'Unique identifier of the plan to update',
                    'location'    => 'uri',
                    'type'        => 'string',
                    'required'    => true
                ),
                'name' => array(
                    'description' => 'Unique name of the plan',
                    'location'    => 'query',
                    'type'        => 'string',
                    'required'    => false
                ),
                'metadata' => array(
                    'description' => 'Optional metadata',
                    'location'    => 'query',
                    'type'        => 'array',
                    'required'    => false
                ),
                'expand' => array(
                    'description' => 'Allow to expand some properties',
                    'location'    => 'query',
                    'type'        => 'array',
                    'required'    => false
                )
            )
        ),

        /**
         * --------------------------------------------------------------------------------
         * COUPON RELATED METHODS
         *
         * DOC: https://stripe.com/docs/api#coupons
         * --------------------------------------------------------------------------------
         */
        'CreateCoupon' => array(
            'httpMethod'       => 'POST',
            'uri'              => '/v1/coupons',
            'summary'          => 'Create a new coupon',
            'errorResponses'   => $errors,
            'parameters'       => array(
                'id' => array(
                    'description' => 'Unique string to identify the coupon (you can specify none and it will be auto-generated)',
                    'location'    => 'query',
                    'type'        => 'string',
                    'required'    => false
                ),
                'duration' => array(
                    'description' => 'Specifies how long the discount will be in effect (can be "forever", "once" or "repeating")',
                    'location'    => 'query',
                    'type'        => 'string',
                    'required'    => true,
                    'enum'        => array('forever', 'once', 'repeating')
                ),
                'amount_off' => array(
                    'description' => 'A positive integer representing the amount to subtract from an invoice total (required if "percent_off" is not passed)',
                    'location'    => 'query',
                    'type'        => 'integer',
                    'required'    => false
                ),
                'currency' => array(
                    'description' => 'Currency of the amount_off parameter (required if "amount_off" is passed)',
                    'location'    => 'query',
                    'type'        => 'string',
                    'required'    => false
                ),
                'duration_in_months' => array(
                    'description' => 'If "duration" is repeating, a positive integer that specifies the number of months the discount will be in effect',
                    'location'    => 'query',
                    'type'        => 'integer',
                    'required'    => false
                ),
                'max_redemptions' => array(
                    'description' => 'A positive integer specifying the number of times the coupon can be redeemed before it\'s no longer valid',
                    'location'    => 'query',
                    'type'        => 'integer',
                    'required'    => false
                ),
                'percent_off' => array(
                    'description' => 'A positive integer between 1 and 100 that represents the discount the coupon will apply (required if amount_off is not passed)',
                    'location'    => 'query',
                    'type'        => 'integer',
                    'required'    => false
                ),
                'redeem_by' => array(
                    'description' => 'UTC timestamp specifying the last time at which the coupon can be redeemed',
                    'location'    => 'query',
                    'type'        => 'integer',
                    'required'    => false
                ),
                'expand' => array(
                    'description' => 'Allow to expand some properties',
                    'location'    => 'query',
                    'type'        => 'array',
                    'required'    => false
                )
            )
        ),

        'DeleteCoupon' => array(
            'httpMethod'       => 'DELETE',
            'uri'              => '/v1/coupons/{id}',
            'summary'          => 'Delete an existing coupon',
            'errorResponses'   => $errors,
            'parameters'       => array(
                'id' => array(
                    'description' => 'Unique identifier of the coupon',
                    'location'    => 'uri',
                    'type'        => 'string',
                    'required'    => true
                ),
                'expand' => array(
                    'description' => 'Allow to expand some properties',
                    'location'    => 'query',
                    'type'        => 'array',
                    'required'    => false
                )
            )
        ),

        'GetCoupon' => array(
            'httpMethod'       => 'GET',
            'uri'              => '/v1/coupons/{id}',
            'summary'          => 'Get an existing coupon',
            'errorResponses'   => $errors,
            'parameters'       => array(
                'id' => array(
                    'description' => 'Unique identifier of the plan',
                    'location'    => 'uri',
                    'type'        => 'string',
                    'required'    => true
                ),
                'expand' => array(
                    'description' => 'Allow to expand some properties',
                    'location'    => 'query',
                    'type'        => 'array',
                    'required'    => false
                )
            )
        ),

        'GetCoupons' => array(
            'httpMethod'       => 'GET',
            'uri'              => '/v1/coupons/{id}',
            'summary'          => 'Get existing plans',
            'errorResponses'   => $errors,
            'parameters'       => array(
                'count' => array(
                    'description' => 'Limit on how many coupons are retrieved',
                    'location'    => 'query',
                    'type'        => 'integer',
                    'min'         => 1,
                    'max'         => 100,
                    'required'    => false
                ),
                'offset' => array(
                    'description' => 'Offset into the list of returned items',
                    'location'    => 'query',
                    'type'        => 'integer',
                    'required'    => false
                ),
                'expand' => array(
                    'description' => 'Allow to expand some properties',
                    'location'    => 'query',
                    'type'        => 'array',
                    'required'    => false
                )
            )
        ),

        /**
         * --------------------------------------------------------------------------------
         * DISCOUNT RELATED METHODS
         *
         * DOC: https://stripe.com/docs/api#discounts
         * --------------------------------------------------------------------------------
         */
        'DeleteCustomerDiscount' => array(
            'httpMethod'       => 'DELETE',
            'uri'              => '/v1/customers/{customer}/discount',
            'summary'          => 'Delete a customer wide discount',
            'errorResponses'   => $errors,
            'parameters'       => array(
                'customer' => array(
                    'description' => 'Unique identifier of the customer to delete the discount from',
                    'location'    => 'uri',
                    'type'        => 'string',
                    'required'    => true
                ),
                'expand' => array(
                    'description' => 'Allow to expand some properties',
                    'location'    => 'query',
                    'type'        => 'array',
                    'required'    => false
                )
            )
        ),

        'DeleteSubscriptionDiscount' => array(
            'httpMethod'       => 'DELETE',
            'uri'              => '/v1/customers/{customer}/subscriptions/{subscription}/discount',
            'summary'          => 'Delete a discount applied on a subscription',
            'errorResponses'   => $errors,
            'parameters'       => array(
                'customer' => array(
                    'description' => 'Unique identifier of the customer to delete the discount from',
                    'location'    => 'uri',
                    'type'        => 'string',
                    'required'    => true
                ),
                'subscription' => array(
                    'description' => 'Unique identifier of the subscription to delete the discount from',
                    'location'    => 'uri',
                    'type'        => 'string',
                    'required'    => true
                ),
                'expand' => array(
                    'description' => 'Allow to expand some properties',
                    'location'    => 'query',
                    'type'        => 'array',
                    'required'    => false
                )
            )
        ),

        /**
         * --------------------------------------------------------------------------------
         * INVOICE RELATED METHODS
         *
         * DOC: https://stripe.com/docs/api#invoices
         * --------------------------------------------------------------------------------
         */
        'CreateInvoice' => array(
            'httpMethod'       => 'POST',
            'uri'              => '/v1/invoices',
            'summary'          => 'Create a new invoice',
            'errorResponses'   => $errors,
            'parameters'       => array(
                'customer' => array(
                    'description' => 'Unique string to identify the plan',
                    'location'    => 'query',
                    'type'        => 'string',
                    'required'    => true
                ),
                'subscription' => array(
                    'description' => 'Identifier of the subscription to invoice',
                    'location'    => 'query',
                    'type'        => 'string',
                    'required'    => false
                ),
                'application_fee' => array(
                    'description' => 'A fee in cents that will be applied to the invoice and transferred to the application owner\'s Stripe account',
                    'location'    => 'query',
                    'type'        => 'integer',
                    'required'    => false
                ),
                'expand' => array(
                    'description' => 'Allow to expand some properties',
                    'location'    => 'query',
                    'type'        => 'array',
                    'required'    => false
                )
            )
        ),

        'GetInvoice' => array(
            'httpMethod'       => 'GET',
            'uri'              => '/v1/invoices/{id}',
            'summary'          => 'Get an existing invoice',
            'errorResponses'   => $errors,
            'parameters'       => array(
                'id' => array(
                    'description' => 'Unique identifier of the invoice',
                    'location'    => 'uri',
                    'type'        => 'string',
                    'required'    => true
                ),
                'expand' => array(
                    'description' => 'Allow to expand some properties',
                    'location'    => 'query',
                    'type'        => 'array',
                    'required'    => false
                )
            )
        ),

        'GetInvoiceLineItems' => array(
            'httpMethod'       => 'GET',
            'uri'              => '/v1/invoices/{id}/lines',
            'summary'          => 'Get an existing invoice line items',
            'errorResponses'   => $errors,
            'parameters'       => array(
                'id' => array(
                    'description' => 'Unique identifier of the invoice',
                    'location'    => 'uri',
                    'type'        => 'string',
                    'required'    => true
                ),
                'count' => array(
                    'description' => 'Limit on how many invoice line items are retrieved',
                    'location'    => 'query',
                    'type'        => 'integer',
                    'min'         => 1,
                    'max'         => 100,
                    'required'    => false
                ),
                'offset' => array(
                    'description' => 'Offset into the list of returned items',
                    'location'    => 'query',
                    'type'        => 'integer',
                    'required'    => false
                ),
                'customer' => array(
                    'description' => 'Only return invoice line items for a specific customer',
                    'location'    => 'query',
                    'type'        => 'string',
                    'required'    => false
                ),
                'subscription' => array(
                    'description' => 'In the case of upcoming invoices, the subscription is optional. Otherwise it is ignored',
                    'location'    => 'query',
                    'type'        => 'string',
                    'required'    => false
                ),
                'expand' => array(
                    'description' => 'Allow to expand some properties',
                    'location'    => 'query',
                    'type'        => 'array',
                    'required'    => false
                )
            )
        ),

        'GetInvoices' => array(
            'httpMethod'       => 'GET',
            'uri'              => '/v1/invoices',
            'summary'          => 'Get existing invoices',
            'errorResponses'   => $errors,
            'parameters'       => array(
                'count' => array(
                    'description' => 'Limit on how many invoices are retrieved',
                    'location'    => 'query',
                    'type'        => 'integer',
                    'min'         => 1,
                    'max'         => 100,
                    'required'    => false
                ),
                'offset' => array(
                    'description' => 'Offset into the list of returned items',
                    'location'    => 'query',
                    'type'        => 'integer',
                    'required'    => false
                ),
                'date' => array(
                    'description' => 'A filter based on the "date" field. Can be an exact UTC timestamp, or a hash',
                    'location'    => 'query',
                    'type'        => array('string', 'array'),
                    'required'    => false
                ),
                'customer' => array(
                    'description' => 'Only return invoices for a specific customer',
                    'location'    => 'query',
                    'type'        => 'string',
                    'required'    => false
                ),
                'expand' => array(
                    'description' => 'Allow to expand some properties',
                    'location'    => 'query',
                    'type'        => 'array',
                    'required'    => false
                )
            )
        ),

        'GetUpcomingInvoice' => array(
            'httpMethod'       => 'GET',
            'uri'              => '/v1/invoices/upcoming',
            'summary'          => 'Get upcoming invoices',
            'errorResponses'   => $errors,
            'parameters'       => array(
                'customer' => array(
                    'description' => 'Only return upcoming invoices for a specific customer',
                    'location'    => 'query',
                    'type'        => 'string',
                    'required'    => true
                ),
                'expand' => array(
                    'description' => 'Allow to expand some properties',
                    'location'    => 'query',
                    'type'        => 'array',
                    'required'    => false
                )
            )
        ),

        'PayInvoice' => array(
            'httpMethod'       => 'POST',
            'uri'              => '/v1/invoices/{id}/pay',
            'summary'          => 'Pay an existing invoice',
            'errorResponses'   => $errors,
            'parameters'       => array(
                'id' => array(
                    'description' => 'Unique identifier of the invoice to pay',
                    'location'    => 'uri',
                    'type'        => 'string',
                    'required'    => true
                ),
                'expand' => array(
                    'description' => 'Allow to expand some properties',
                    'location'    => 'query',
                    'type'        => 'array',
                    'required'    => false
                )
            )
        ),

        'UpdateInvoice' => array(
            'httpMethod'       => 'POST',
            'uri'              => '/v1/invoices/{id}',
            'summary'          => 'Update an existing invoice',
            'errorResponses'   => $errors,
            'parameters'       => array(
                'id' => array(
                    'description' => 'Unique identifier of the invoice to update',
                    'location'    => 'uri',
                    'type'        => 'string',
                    'required'    => true
                ),
                'application_fee' => array(
                    'description' => 'A fee in cents that will be applied to the invoice and transferred to the application owner\'s Stripe account',
                    'location'    => 'query',
                    'type'        => 'integer',
                    'required'    => false
                ),
                'closed' => array(
                    'description' => 'Boolean representing whether an invoice is closed or not',
                    'location'    => 'query',
                    'type'        => 'boolean',
                    'filters'     => array('ZfrStripe\Client\Filter\BooleanFilter::encodeValue'),
                    'required'    => false
                ),
                'expand' => array(
                    'description' => 'Allow to expand some properties',
                    'location'    => 'query',
                    'type'        => 'array',
                    'required'    => false
                )
            )
        ),

        /**
         * --------------------------------------------------------------------------------
         * INVOICE ITEM RELATED METHODS
         *
         * DOC: https://stripe.com/docs/api#invoiceitems
         * --------------------------------------------------------------------------------
         */
        'CreateInvoiceItem' => array(
            'httpMethod'       => 'POST',
            'uri'              => '/v1/invoiceitems',
            'summary'          => 'Create a new invoice item',
            'errorResponses'   => $errors,
            'parameters'       => array(
                'customer' => array(
                    'description' => 'ID of the customer who will be billed when this invoice item is billed',
                    'location'    => 'query',
                    'type'        => 'string',
                    'required'    => true
                ),
                'amount' => array(
                    'description' => 'Amount (in cents)',
                    'location'    => 'query',
                    'type'        => 'integer',
                    'required'    => true
                ),
                'currency' => array(
                    'description' => '3-letter ISO code for currency',
                    'location'    => 'query',
                    'type'        => 'string',
                    'required'    => true
                ),
                'invoice' => array(
                    'description' => 'Identifier of an existing invoice to add this invoice item to',
                    'location'    => 'query',
                    'type'        => 'string',
                    'required'    => false
                ),
                'subscription' => array(
                    'description' => 'Identifier of a subscription to add this invoice item to',
                    'location'    => 'query',
                    'type'        => 'string',
                    'required'    => false
                ),
                'description' => array(
                    'description' => 'Optional description to add',
                    'location'    => 'query',
                    'type'        => 'string',
                    'required'    => false
                ),
                'metadata' => array(
                    'description' => 'Optional metadata',
                    'location'    => 'query',
                    'type'        => 'array',
                    'required'    => false
                ),
                'expand' => array(
                    'description' => 'Allow to expand some properties',
                    'location'    => 'query',
                    'type'        => 'array',
                    'required'    => false
                )
            )
        ),

        'DeleteInvoiceItem' => array(
            'httpMethod'       => 'DELETE',
            'uri'              => '/v1/invoiceitems/{id}',
            'summary'          => 'Delete an existing invoice item',
            'errorResponses'   => $errors,
            'parameters'       => array(
                'id' => array(
                    'description' => 'Unique identifier of the invoice item',
                    'location'    => 'uri',
                    'type'        => 'string',
                    'required'    => true
                ),
                'expand' => array(
                    'description' => 'Allow to expand some properties',
                    'location'    => 'query',
                    'type'        => 'array',
                    'required'    => false
                )
            )
        ),

        'GetInvoiceItem' => array(
            'httpMethod'       => 'GET',
            'uri'              => '/v1/invoiceitems/{id}',
            'summary'          => 'Get an existing invoice item',
            'errorResponses'   => $errors,
            'parameters'       => array(
                'id' => array(
                    'description' => 'Unique identifier of the invoice item',
                    'location'    => 'uri',
                    'type'        => 'string',
                    'required'    => true
                ),
                'expand' => array(
                    'description' => 'Allow to expand some properties',
                    'location'    => 'query',
                    'type'        => 'array',
                    'required'    => false
                )
            )
        ),

        'GetInvoiceItems' => array(
            'httpMethod'       => 'GET',
            'uri'              => '/v1/invoiceitems',
            'summary'          => 'Get existing invoice items',
            'errorResponses'   => $errors,
            'parameters'       => array(
                'count' => array(
                    'description' => 'Limit on how many invoice items are retrieved',
                    'location'    => 'query',
                    'type'        => 'integer',
                    'min'         => 1,
                    'max'         => 100,
                    'required'    => false
                ),
                'offset' => array(
                    'description' => 'Offset into the list of returned items',
                    'location'    => 'query',
                    'type'        => 'integer',
                    'required'    => false
                ),
                'date' => array(
                    'description' => 'A filter based on the "date" field. Can be an exact UTC timestamp, or a hash',
                    'location'    => 'query',
                    'required'    => false
                ),
                'customer' => array(
                    'description' => 'Only return invoices for a specific customer',
                    'location'    => 'query',
                    'type'        => 'string',
                    'required'    => false
                ),
                'expand' => array(
                    'description' => 'Allow to expand some properties',
                    'location'    => 'query',
                    'type'        => 'array',
                    'required'    => false
                )
            )
        ),

        'UpdateInvoiceItem' => array(
            'httpMethod'       => 'POST',
            'uri'              => '/v1/invoiceitems/{id}',
            'summary'          => 'Update an existing invoice item',
            'errorResponses'   => $errors,
            'parameters'       => array(
                'id' => array(
                    'description' => 'Unique identifier of the invoice item to update',
                    'location'    => 'uri',
                    'type'        => 'string',
                    'required'    => true
                ),
                'description' => array(
                    'description' => 'Optional description',
                    'location'    => 'query',
                    'type'        => 'string',
                    'required'    => false
                ),
                'metadata' => array(
                    'description' => 'Optional metadata',
                    'location'    => 'query',
                    'type'        => 'array',
                    'required'    => false
                ),
                'expand' => array(
                    'description' => 'Allow to expand some properties',
                    'location'    => 'query',
                    'type'        => 'array',
                    'required'    => false
                )
            )
        ),

        /**
         * --------------------------------------------------------------------------------
         * DISPUTE RELATED METHODS
         *
         * DOC: https://stripe.com/docs/api#disputes
         * --------------------------------------------------------------------------------
         */
        'CloseDispute' => array(
            'httpMethod'       => 'POST',
            'uri'              => '/v1/charges/{charge}/dispute/close',
            'summary'          => 'Close a dispute',
            'errorResponses'   => $errors,
            'parameters'       => array(
                'charge' => array(
                    'description' => 'ID of the charge to close the dispute',
                    'location'    => 'uri',
                    'type'        => 'string',
                    'required'    => true
                ),
                'expand' => array(
                    'description' => 'Allow to expand some properties',
                    'location'    => 'query',
                    'type'        => 'array',
                    'required'    => false
                )
            )
        ),

        'UpdateDispute' => array(
            'httpMethod'       => 'DELETE',
            'uri'              => '/v1/charges/{charge}/dispute',
            'summary'          => 'Update a dispute',
            'errorResponses'   => $errors,
            'parameters'       => array(
                'charge' => array(
                    'description' => 'ID of the charge to update the dispute',
                    'location'    => 'uri',
                    'type'        => 'string',
                    'required'    => true
                ),
                'evidence' => array(
                    'description' => 'Evidence text',
                    'location'    => 'uri',
                    'type'        => 'string',
                    'required'    => false
                ),
                'expand' => array(
                    'description' => 'Allow to expand some properties',
                    'location'    => 'query',
                    'type'        => 'array',
                    'required'    => false
                )
            )
        ),

        /**
         * --------------------------------------------------------------------------------
         * TRANSFER RELATED METHODS
         *
         * DOC: https://stripe.com/docs/api#transfers
         * --------------------------------------------------------------------------------
         */
        'CancelTransfer' => array(
            'httpMethod'       => 'POST',
            'uri'              => '/v1/transfers/{id}/cancel',
            'summary'          => 'Cancel an existing transfer',
            'errorResponses'   => $errors,
            'parameters'       => array(
                'id' => array(
                    'description' => 'Unique identifier of the transfer',
                    'location'    => 'uri',
                    'type'        => 'string',
                    'required'    => true
                ),
                'expand' => array(
                    'description' => 'Allow to expand some properties',
                    'location'    => 'query',
                    'type'        => 'array',
                    'required'    => false
                )
            )
        ),

        'CreateTransfer' => array(
            'httpMethod'       => 'POST',
            'uri'              => '/v1/transfers',
            'summary'          => 'Create a new transfer',
            'errorResponses'   => $errors,
            'parameters'       => array(
                'amount' => array(
                    'description' => 'Amount (in cents)',
                    'location'    => 'query',
                    'type'        => 'integer',
                    'required'    => true
                ),
                'currency' => array(
                    'description' => '3-letter ISO code for currency',
                    'location'    => 'query',
                    'type'        => 'string',
                    'required'    => true
                ),
                'recipient' => array(
                    'description' => 'ID of an existing, verified recipient',
                    'location'    => 'query',
                    'type'        => 'string',
                    'required'    => true
                ),
                'description' => array(
                    'description' => 'Optional description to add',
                    'location'    => 'query',
                    'type'        => 'string',
                    'required'    => false
                ),
                'statement_descriptor' => array(
                    'description' => 'An arbitrary string which will be displayed on the recipient\'s bank statement',
                    'location'    => 'query',
                    'type'        => 'string',
                    'required'    => false
                ),
                'metadata' => array(
                    'description' => 'Optional metadata',
                    'location'    => 'query',
                    'type'        => 'array',
                    'required'    => false
                ),
                'expand' => array(
                    'description' => 'Allow to expand some properties',
                    'location'    => 'query',
                    'type'        => 'array',
                    'required'    => false
                )
            )
        ),

        'GetTransfer' => array(
            'httpMethod'       => 'GET',
            'uri'              => '/v1/transfers/{id}',
            'summary'          => 'Get an existing transfer',
            'errorResponses'   => $errors,
            'parameters'       => array(
                'id' => array(
                    'description' => 'Unique identifier of the transfer',
                    'location'    => 'uri',
                    'type'        => 'string',
                    'required'    => true
                ),
                'expand' => array(
                    'description' => 'Allow to expand some properties',
                    'location'    => 'query',
                    'type'        => 'array',
                    'required'    => false
                )
            )
        ),

        'GetTransfers' => array(
            'httpMethod'       => 'GET',
            'uri'              => '/v1/transfers',
            'summary'          => 'Get existing transfers',
            'errorResponses'   => $errors,
            'parameters'       => array(
                'count' => array(
                    'description' => 'Limit on how many invoice items are retrieved',
                    'location'    => 'query',
                    'type'        => 'integer',
                    'min'         => 1,
                    'max'         => 100,
                    'required'    => false
                ),
                'offset' => array(
                    'description' => 'Offset into the list of returned items',
                    'location'    => 'query',
                    'type'        => 'integer',
                    'required'    => false
                ),
                'date' => array(
                    'description' => 'A filter based on the "date" field. Can be an exact UTC timestamp, or a hash',
                    'location'    => 'query',
                    'required'    => false
                ),
                'recipient' => array(
                    'description' => 'Only return transfers for a specific recipient',
                    'location'    => 'query',
                    'type'        => 'string',
                    'required'    => false
                ),
                'status' => array(
                    'description' => 'Optionally filter by status',
                    'location'    => 'query',
                    'type'        => 'string',
                    'required'    => false,
                    'enum'        => array('pending', 'paid', 'failed')
                ),
                'expand' => array(
                    'description' => 'Allow to expand some properties',
                    'location'    => 'query',
                    'type'        => 'array',
                    'required'    => false
                )
            )
        ),

        'UpdateTransfer' => array(
            'httpMethod'       => 'POST',
            'uri'              => '/v1/transfers/{id}',
            'summary'          => 'Update an existing transfer',
            'errorResponses'   => $errors,
            'parameters'       => array(
                'id' => array(
                    'description' => 'Unique identifier of the transfer to update',
                    'location'    => 'uri',
                    'type'        => 'string',
                    'required'    => true
                ),
                'description' => array(
                    'description' => 'Optional description',
                    'location'    => 'query',
                    'type'        => 'string',
                    'required'    => false
                ),
                'metadata' => array(
                    'description' => 'Optional metadata',
                    'location'    => 'query',
                    'type'        => 'array',
                    'required'    => false
                ),
                'expand' => array(
                    'description' => 'Allow to expand some properties',
                    'location'    => 'query',
                    'type'        => 'array',
                    'required'    => false
                )
            )
        ),

        /**
         * --------------------------------------------------------------------------------
         * RECIPIENT RELATED METHODS
         *
         * DOC: https://stripe.com/docs/api#recipients
         * --------------------------------------------------------------------------------
         */
        'CreateRecipient' => array(
            'httpMethod'       => 'POST',
            'uri'              => '/v1/recipients',
            'summary'          => 'Create a new recipient',
            'errorResponses'   => $errors,
            'parameters'       => array(
                'name' => array(
                    'description' => 'The recipient\'s full, legal name',
                    'location'    => 'query',
                    'type'        => 'string',
                    'required'    => true
                ),
                'type' => array(
                    'description' => 'Type of the recipient (can be "individual" or "corporation")',
                    'location'    => 'query',
                    'type'        => 'string',
                    'required'    => true,
                    'enum'        => array('individual', 'corporation')
                ),
                'tax_id' => array(
                    'description' => 'The recipient\'s tax ID, as a string',
                    'location'    => 'query',
                    'type'        => 'string',
                    'required'    => false
                ),
                'bank_account' => array(
                    'description' => 'A bank account to attach to the recipient',
                    'location'    => 'query',
                    'type'        => 'array',
                    'required'    => false
                ),
                'email' => array(
                    'description' => 'The recipient\'s email address',
                    'location'    => 'query',
                    'type'        => 'string',
                    'required'    => false
                ),
                'description' => array(
                    'description' => 'Optional description to add',
                    'location'    => 'query',
                    'type'        => 'integer',
                    'required'    => false
                ),
                'metadata' => array(
                    'description' => 'Optional metadata',
                    'location'    => 'query',
                    'type'        => 'array',
                    'required'    => false
                ),
                'expand' => array(
                    'description' => 'Allow to expand some properties',
                    'location'    => 'query',
                    'type'        => 'array',
                    'required'    => false
                )
            )
        ),

        'DeleteRecipient' => array(
            'httpMethod'       => 'DELETE',
            'uri'              => '/v1/recipients/{id}',
            'summary'          => 'Delete an existing recipient',
            'errorResponses'   => $errors,
            'parameters'       => array(
                'id' => array(
                    'description' => 'Unique identifier of the recipient',
                    'location'    => 'uri',
                    'type'        => 'string',
                    'required'    => true
                ),
                'expand' => array(
                    'description' => 'Allow to expand some properties',
                    'location'    => 'query',
                    'type'        => 'array',
                    'required'    => false
                )
            )
        ),

        'GetRecipient' => array(
            'httpMethod'       => 'GET',
            'uri'              => '/v1/recipients/{id}',
            'summary'          => 'Get an existing recipient',
            'errorResponses'   => $errors,
            'parameters'       => array(
                'id' => array(
                    'description' => 'Unique identifier of the recipient',
                    'location'    => 'uri',
                    'type'        => 'string',
                    'required'    => true
                ),
                'expand' => array(
                    'description' => 'Allow to expand some properties',
                    'location'    => 'query',
                    'type'        => 'array',
                    'required'    => false
                )
            )
        ),

        'GetRecipients' => array(
            'httpMethod'       => 'GET',
            'uri'              => '/v1/recipients',
            'summary'          => 'Get existing recipients',
            'errorResponses'   => $errors,
            'parameters'       => array(
                'count' => array(
                    'description' => 'Limit on how many invoice items are retrieved',
                    'location'    => 'query',
                    'type'        => 'integer',
                    'min'         => 1,
                    'max'         => 100,
                    'required'    => false
                ),
                'offset' => array(
                    'description' => 'Offset into the list of returned items',
                    'location'    => 'query',
                    'type'        => 'integer',
                    'required'    => false
                ),
                'verified' => array(
                    'description' => 'Boolean to only return recipients that are verified or unverified',
                    'location'    => 'query',
                    'type'        => 'boolean',
                    'filters'     => array('ZfrStripe\Client\Filter\BooleanFilter::encodeValue'),
                    'required'    => false
                ),
                'expand' => array(
                    'description' => 'Allow to expand some properties',
                    'location'    => 'query',
                    'type'        => 'array',
                    'required'    => false
                )
            )
        ),

        'UpdateRecipient' => array(
            'httpMethod'       => 'POST',
            'uri'              => '/v1/recipients/{id}',
            'summary'          => 'Update an existing recipient',
            'errorResponses'   => $errors,
            'parameters'       => array(
                'id' => array(
                    'description' => 'Unique identifier of the recipient to update',
                    'location'    => 'uri',
                    'type'        => 'string',
                    'required'    => true
                ),
                'name' => array(
                    'description' => 'The recipient\'s full, legal name',
                    'location'    => 'query',
                    'type'        => 'string',
                    'required'    => false
                ),
                'tax_id' => array(
                    'description' => 'The recipient\'s tax ID, as a string',
                    'location'    => 'query',
                    'type'        => 'string',
                    'required'    => false
                ),
                'bank_account' => array(
                    'description' => 'A bank account to attach to the recipient',
                    'location'    => 'query',
                    'type'        => 'array',
                    'required'    => false
                ),
                'email' => array(
                    'description' => 'The recipient\'s email address',
                    'location'    => 'query',
                    'type'        => 'string',
                    'required'    => false
                ),
                'description' => array(
                    'description' => 'Optional description to add',
                    'location'    => 'query',
                    'type'        => 'integer',
                    'required'    => false
                ),
                'metadata' => array(
                    'description' => 'Optional metadata',
                    'location'    => 'query',
                    'type'        => 'array',
                    'required'    => false
                ),
                'expand' => array(
                    'description' => 'Allow to expand some properties',
                    'location'    => 'query',
                    'type'        => 'array',
                    'required'    => false
                )
            )
        ),

        /**
         * --------------------------------------------------------------------------------
         * APPLICATION FEE RELATED METHODS
         *
         * DOC: https://stripe.com/docs/api#application_fees
         * --------------------------------------------------------------------------------
         */
        'GetApplicationFee' => array(
            'httpMethod'       => 'GET',
            'uri'              => '/v1/application_fees/{id}',
            'summary'          => 'Get details about an application fee that your account has collected',
            'errorResponses'   => $errors,
            'parameters'       => array(
                'id' => array(
                    'description' => 'Unique identifier of the application fee',
                    'location'    => 'uri',
                    'type'        => 'string',
                    'required'    => true
                ),
                'expand' => array(
                    'description' => 'Allow to expand some properties',
                    'location'    => 'query',
                    'type'        => 'array',
                    'required'    => false
                )
            )
        ),

        'GetApplicationFees' => array(
            'httpMethod'       => 'GET',
            'uri'              => '/v1/application_fees',
            'summary'          => 'Get details about all applicaiton fees that your account has collected',
            'errorResponses'   => $errors,
            'parameters'       => array(
                'count' => array(
                    'description' => 'Limit on how many application fees are retrieved',
                    'location'    => 'query',
                    'type'        => 'integer',
                    'min'         => 1,
                    'max'         => 100,
                    'required'    => false
                ),
                'offset' => array(
                    'description' => 'Offset into the list of returned items',
                    'location'    => 'query',
                    'type'        => 'integer',
                    'required'    => false
                ),
                'created' => array(
                    'description' => 'A filter based on the "created" field. Can be an exact UTC timestamp, or a hash',
                    'location'    => 'query',
                    'type'        => array('string', 'array'),
                    'required'    => false
                ),
                'charge' => array(
                    'description' => 'Only return application fees for a given charge',
                    'location'    => 'query',
                    'type'        => 'string',
                    'required'    => false
                ),
                'expand' => array(
                    'description' => 'Allow to expand some properties',
                    'location'    => 'query',
                    'type'        => 'array',
                    'required'    => false
                )
            )
        ),

        'RefundApplicationFee' => array(
            'httpMethod'       => 'POST',
            'uri'              => '/v1/application_fees/{id}/refund',
            'summary'          => 'Refund an application fee that has previously been collected but not yet refunded',
            'errorResponses'   => $errors,
            'parameters'       => array(
                'id' => array(
                    'description' => 'Unique identifier of application fee to be refunded',
                    'location'    => 'uri',
                    'type'        => 'string',
                    'required'    => true
                ),
                'amount' => array(
                    'description' => 'A positive integer in cents representing how many of this fee to refund',
                    'location'    => 'query',
                    'type'        => 'integer',
                    'required'    => false
                ),
                'expand' => array(
                    'description' => 'Allow to expand some properties',
                    'location'    => 'query',
                    'type'        => 'array',
                    'required'    => false
                )
            )
        ),

        /**
         * --------------------------------------------------------------------------------
         * TOKEN RELATED METHODS
         *
         * DOC: https://stripe.com/docs/api#tokens
         * --------------------------------------------------------------------------------
         */
        'CreateCardToken' => array(
            'httpMethod'       => 'POST',
            'uri'              => '/v1/tokens',
            'summary'          => 'Create a new card token (note you must either specify card OR customer but not both)',
            'errorResponses'   => $errors,
            'parameters'       => array(
                'card' => array(
                    'description' => 'Unique card identifier (can either be an ID or a hash)',
                    'location'    => 'query',
                    'type'        => array('string', 'array'),
                    'required'    => false
                ),
                'customer' => array(
                    'description' => 'A customer (owned by the application\'s account) to create a token for',
                    'location'    => 'query',
                    'type'        => 'string',
                    'required'    => false
                ),
                'expand' => array(
                    'description' => 'Allow to expand some properties',
                    'location'    => 'query',
                    'type'        => 'array',
                    'required'    => false
                )
            )
        ),

        'CreateBankAccountToken' => array(
            'httpMethod'       => 'POST',
            'uri'              => '/v1/tokens',
            'summary'          => 'Create a bank account token',
            'errorResponses'   => $errors,
            'parameters'       => array(
                'bank_account' => array(
                    'description' => 'A bank account to attach to the recipient',
                    'location'    => 'query',
                    'type'        => 'array',
                    'required'    => false
                ),
                'expand' => array(
                    'description' => 'Allow to expand some properties',
                    'location'    => 'query',
                    'type'        => 'array',
                    'required'    => false
                )
            )
        ),

        'GetToken' => array(
            'httpMethod'       => 'GET',
            'uri'              => '/v1/tokens/{id}',
            'summary'          => 'Get details about an existing token',
            'errorResponses'   => $errors,
            'parameters'       => array(
                'id' => array(
                    'description' => 'Unique identifier of the token',
                    'location'    => 'uri',
                    'type'        => 'string',
                    'required'    => true
                ),
                'expand' => array(
                    'description' => 'Allow to expand some properties',
                    'location'    => 'query',
                    'type'        => 'array',
                    'required'    => false
                )
            )
        ),

        /**
         * --------------------------------------------------------------------------------
         * EVENT RELATED METHODS
         *
         * DOC: https://stripe.com/docs/api#events
         * --------------------------------------------------------------------------------
         */
        'GetEvent' => array(
            'httpMethod'       => 'GET',
            'uri'              => '/v1/events/{id}',
            'summary'          => 'Get details about an event',
            'errorResponses'   => $errors,
            'parameters'       => array(
                'id' => array(
                    'description' => 'Unique identifier of the event',
                    'location'    => 'uri',
                    'type'        => 'string',
                    'required'    => true
                ),
                'expand' => array(
                    'description' => 'Allow to expand some properties',
                    'location'    => 'query',
                    'type'        => 'array',
                    'required'    => false
                )
            )
        ),

        'GetEvents' => array(
            'httpMethod'       => 'GET',
            'uri'              => '/v1/events',
            'summary'          => 'Get details about all events (up to 30 days)',
            'errorResponses'   => $errors,
            'parameters'       => array(
                'count' => array(
                    'description' => 'Limit on how many application fees are retrieved',
                    'location'    => 'query',
                    'type'        => 'integer',
                    'min'         => 1,
                    'max'         => 100,
                    'required'    => false
                ),
                'offset' => array(
                    'description' => 'Offset into the list of returned items',
                    'location'    => 'query',
                    'type'        => 'integer',
                    'required'    => false
                ),
                'created' => array(
                    'description' => 'A filter based on the "created" field. Can be an exact UTC timestamp, or a hash',
                    'location'    => 'query',
                    'type'        => array('string', 'array'),
                    'required'    => false
                ),
                'type' => array(
                    'description' => 'Allow to filter events by type',
                    'location'    => 'query',
                    'type'        => 'string',
                    'required'    => false
                ),
                'expand' => array(
                    'description' => 'Allow to expand some properties',
                    'location'    => 'query',
                    'type'        => 'array',
                    'required'    => false
                )
            )
        ),

        /**
         * --------------------------------------------------------------------------------
         * ACCOUNT RELATED METHODS
         *
         * DOC: https://stripe.com/docs/api#account
         * --------------------------------------------------------------------------------
         */
        'GetAccount' => array(
            'httpMethod'       => 'GET',
            'uri'              => '/v1/account',
            'summary'          => 'Get details about the account',
            'errorResponses'   => $errors,
        )
    )
);
