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

return array(
    'name'        => 'Stripe',
    'apiVersion'  => '1.0',
    'baseUrl'     => 'https://api.stripe.com',
    'description' => 'Paymill is a payment system',
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
                )
            )
        ),

        'CreateCharge' => array(
            'httpMethod'       => 'POST',
            'uri'              => '/v1/charges',
            'summary'          => 'Create a new charge (either card or customer is needed)',
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
                    'required'    => false
                ),
                'capture' => array(
                    'description' => 'Whether or not to immediately capture the charge',
                    'location'    => 'query',
                    'type'        => 'boolean',
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
            )
        ),

        'GetCharge' => array(
            'httpMethod'       => 'GET',
            'uri'              => '/v1/charges/{id}',
            'summary'          => 'Get an existing charge',
            'parameters'       => array(
                'id' => array(
                    'description' => 'Unique identifier of the charge',
                    'location'    => 'uri',
                    'type'        => 'string',
                    'required'    => true
                ),
            )
        ),

        'GetCharges' => array(
            'httpMethod'       => 'GET',
            'uri'              => '/v1/charges',
            'summary'          => 'Get existing charges',
            'parameters'       => array(
                'count' => array(
                    'description' => 'Limit on how much charges are retrieved',
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
                    'required'    => false
                ),
                'customer' => array(
                    'description' => 'Only return charges for a specific customer',
                    'location'    => 'query',
                    'type'        => 'string',
                    'required'    => false
                ),
            )
        ),

        'RefundCharge' => array(
            'httpMethod'       => 'POST',
            'uri'              => '/v1/charges/{id}/refund',
            'summary'          => 'Refund an existing charge',
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
                    'required'    => false
                )
            )
        ),

        'UpdateCharge' => array(
            'httpMethod'       => 'POST',
            'uri'              => '/v1/charges/{id}',
            'summary'          => 'Update an existing charge',
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
            )
        ),

        'DeleteCustomer' => array(
            'httpMethod'       => 'DELETE',
            'uri'              => '/v1/customers/{id}',
            'summary'          => 'Delete an existing customer',
            'parameters'       => array(
                'id' => array(
                    'description' => 'Unique identifier of the customer',
                    'location'    => 'uri',
                    'type'        => 'string',
                    'required'    => true
                ),
            )
        ),

        'GetCustomer' => array(
            'httpMethod'       => 'GET',
            'uri'              => '/v1/customers/{id}',
            'summary'          => 'Get an existing customer',
            'parameters'       => array(
                'id' => array(
                    'description' => 'Unique identifier of the customer',
                    'location'    => 'uri',
                    'type'        => 'string',
                    'required'    => true
                ),
            )
        ),

        'GetCustomers' => array(
            'httpMethod'       => 'GET',
            'uri'              => '/v1/customers',
            'summary'          => 'Get existing customers',
            'parameters'       => array(
                'count' => array(
                    'description' => 'Limit on how much customers are retrieved',
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
                    'required'    => false
                ),
            )
        ),

        'UpdateCustomer' => array(
            'httpMethod'       => 'POST',
            'uri'              => '/v1/customers/{id}',
            'summary'          => 'Update an existing customer',
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
            'uri'              => '/v1/customers/{customer_id}/cards',
            'summary'          => 'Create a new card for a customer',
            'parameters'       => array(
                'customer_id' => array(
                    'description' => 'Unique identifier of the customer',
                    'location'    => 'uri',
                    'type'        => 'string',
                    'required'    => true
                ),
                'card' => array(
                    'description' => 'Unique card identifier (can either be an ID or a hash)',
                    'location'    => 'query',
                    'required'    => false
                )
            )
        ),

        'DeleteCard' => array(
            'httpMethod'       => 'DELETE',
            'uri'              => '/v1/customers/{customer_id}/cards/{id}',
            'summary'          => 'Delete an existing customer\'s card',
            'parameters'       => array(
                'id' => array(
                    'description' => 'Unique identifier of the card to delete',
                    'location'    => 'uri',
                    'type'        => 'string',
                    'required'    => true
                ),
                'customer_id' => array(
                    'description' => 'Unique identifier of the customer to delete the card',
                    'location'    => 'uri',
                    'type'        => 'string',
                    'required'    => true
                ),
            )
        ),

        'GetCard' => array(
            'httpMethod'       => 'GET',
            'uri'              => '/v1/customers/{customer_id}/cards/{id}',
            'summary'          => 'Get an existing customer\'s card',
            'parameters'       => array(
                'id' => array(
                    'description' => 'Unique identifier of the card to get',
                    'location'    => 'uri',
                    'type'        => 'string',
                    'required'    => true
                ),
                'customer_id' => array(
                    'description' => 'Unique identifier of the customer to get the card from',
                    'location'    => 'uri',
                    'type'        => 'string',
                    'required'    => true
                ),
            )
        ),

        'GetCards' => array(
            'httpMethod'       => 'GET',
            'uri'              => '/v1/customers/{customer_id}/cards',
            'summary'          => 'Get existing customers\'s cards',
            'parameters'       => array(
                'customer_id' => array(
                    'description' => 'Unique identifier of the customer to get the cards from',
                    'location'    => 'uri',
                    'type'        => 'string',
                    'required'    => true
                ),
                'count' => array(
                    'description' => 'Limit on how much cards are retrieved',
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
            )
        ),

        'UpdateCard' => array(
            'httpMethod'       => 'POST',
            'uri'              => '/v1/customers/{customer_id}/cards/{id}',
            'summary'          => 'Update an existing customer',
            'parameters'       => array(
                'id' => array(
                    'description' => 'Unique identifier of the card to update',
                    'location'    => 'uri',
                    'type'        => 'string',
                    'required'    => true
                ),
                'customer_id' => array(
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
            'uri'              => '/v1/customers/{customer_id}/subscription',
            'summary'          => 'Delete an existing customer\'s card',
            'parameters'       => array(
                'customer_id' => array(
                    'description' => 'Unique identifier of the customer to delete the card',
                    'location'    => 'uri',
                    'type'        => 'string',
                    'required'    => true
                ),
                'at_period_end' => array(
                    'description' => 'A flag that if set to true will delay the cancellation of the subscription until the end of the current period.',
                    'location'    => 'query',
                    'type'        => 'boolean',
                    'required'    => false
                )
            )
        ),

        'UpdateSubscription' => array(
            'httpMethod'       => 'POST',
            'uri'              => '/v1/customers/{customer_id}/subscription',
            'summary'          => 'Update a customer\'s subscription',
            'parameters'       => array(
                'customer_id' => array(
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
                    'required'    => false
                ),
                'trial_end' => array(
                    'description' => 'UTC integer timestamp representing the end of the trial period the customer will get before being charged for the first time',
                    'location'    => 'query',
                    'type'        => 'string',
                    'required'    => false
                ),
                'application_fee_percent' => array(
                    'description' => 'A positive decimal (with at most two decimal places) between 1 and 100 that represents the percentage of the subscription invoice amount due each billing period that will be transferred to the application owner’s Stripe account',
                    'location'    => 'query',
                    'type'        => 'string',
                    'required'    => false
                )
            )
        ),
    )
);
