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

$errors = [
    [
        'class' => 'ZfrStripe\Exception\BadRequestException',
        'code'  => 400
    ],
    [
        'class' => 'ZfrStripe\Exception\UnauthorizedException',
        'code'  => 401
    ],
    [
        'class' => 'ZfrStripe\Exception\RequestFailedException',
        'code'  => 402
    ],
    [
        'class' => 'ZfrStripe\Exception\NotFoundException',
        'code'  => 404
    ],
    [
        'class' => 'ZfrStripe\Exception\ServerErrorException',
        'code'  => 500
    ],
    [
        'class' => 'ZfrStripe\Exception\ServerErrorException',
        'code'  => 502
    ],
    [
        'class' => 'ZfrStripe\Exception\ServerErrorException',
        'code'  => 503
    ],
    [
        'class' => 'ZfrStripe\Exception\ServerErrorException',
        'code'  => 504
    ]
];

return [
    'name'        => 'Stripe',
    'baseUrl'     => 'https://api.stripe.com',
    'description' => 'Stripe is a payment system',
    'operations'  => [
        /**
         * --------------------------------------------------------------------------------
         * CHARGES RELATED METHODS
         *
         * DOC: https://stripe.com/docs/api#charges
         * --------------------------------------------------------------------------------
         */

        'captureCharge' => [
            'httpMethod'       => 'POST',
            'uri'              => '/v1/charges/{id}/capture',
            'summary'          => 'Capture an existing charge',
            'errorResponses'   => $errors,
            'responseModel'    => 'getResponse',
            'parameters'       => [
                'id' => [
                    'description' => 'Unique identifier of the charge',
                    'location'    => 'uri',
                    'type'        => 'string',
                    'required'    => true
                ],
                'amount' => [
                    'description' => 'Amount (in cents) to capture',
                    'location'    => 'query',
                    'type'        => 'integer',
                    'required'    => false
                ],
                'receipt_email' => [
                    'description' => 'The email address to send this charge\'s receipt to',
                    'location'    => 'query',
                    'type'        => 'string',
                    'required'    => false
                ],
                'application_fee' => [
                    'description' => 'A fee in cents that will be applied to the charge and transferred to the application owner\'s Stripe account',
                    'location'    => 'query',
                    'type'        => 'integer',
                    'required'    => false
                ],
                'expand' => [
                    'description' => 'Allow to expand some properties',
                    'location'    => 'query',
                    'type'        => 'array',
                    'required'    => false
                ],
                'idempotency_key' => [
                    'description' => 'An indempotency key that prevents accidentally performing the same POST operation twice',
                    'location'    => 'header',
                    'sentAs'      => 'Idempotency-Key',
                    'type'        => 'string',
                    'required'    => false
                ]
            ]
        ],

        'createCharge' => [
            'httpMethod'       => 'POST',
            'uri'              => '/v1/charges',
            'summary'          => 'Create a new charge (either card or customer is needed)',
            'errorResponses'   => $errors,
            'responseModel'    => 'getResponse',
            'parameters'       => [
                'amount' => [
                    'description' => 'Amount (in cents)',
                    'location'    => 'query',
                    'type'        => 'integer',
                    'required'    => true
                ],
                'currency' => [
                    'description' => '3-letter ISO code for currency',
                    'location'    => 'query',
                    'type'        => 'string',
                    'required'    => true
                ],
                'customer' => [
                    'description' => 'Unique client identifier',
                    'location'    => 'query',
                    'type'        => 'string',
                    'required'    => false
                ],
                'card' => [
                    'description' => 'Unique card identifier (can either be an ID or a hash)',
                    'location'    => 'query',
                    'type'        => ['string', 'array'],
                    'required'    => false
                ],
                'capture' => [
                    'description' => 'Whether or not to immediately capture the charge',
                    'location'    => 'query',
                    'type'        => 'boolean',
                    'filters'     => ['ZfrStripe\Client\Filter\BooleanFilter::encodeValue'],
                    'required'    => false
                ],
                'description' => [
                    'description' => 'Optional description for the charge',
                    'location'    => 'query',
                    'type'        => 'string',
                    'required'    => false
                ],
                'metadata' => [
                    'description' => 'Optional metadata',
                    'location'    => 'query',
                    'type'        => 'array',
                    'required'    => false
                ],
                'statement_description' => [
                    'description' => 'An arbitrary string to be displayed alongside your customer\'s credit card statement',
                    'location'    => 'query',
                    'type'        => 'string',
                    'required'    => false
                ],
                'receipt_email' => [
                    'description' => 'The email address to send this charge\'s receipt to',
                    'location'    => 'query',
                    'type'        => 'string',
                    'required'    => false
                ],
                'application_fee' => [
                    'description' => 'A fee in cents that will be applied to the charge and transferred to the application owner\'s Stripe account',
                    'location'    => 'query',
                    'type'        => 'integer',
                    'required'    => false
                ],
                'shipping' => [
                    'description' => 'Shipping information for the charge',
                    'location'    => 'query',
                    'type'        => 'array',
                    'required'    => false
                ],
                'expand' => [
                    'description' => 'Allow to expand some properties',
                    'location'    => 'query',
                    'type'        => 'array',
                    'required'    => false
                ],
                'idempotency_key' => [
                    'description' => 'An indempotency key that prevents accidentally performing the same POST operation twice',
                    'location'    => 'header',
                    'sentAs'      => 'Idempotency-Key',
                    'type'        => 'string',
                    'required'    => false
                ]
            ]
        ],

        'getCharge' => [
            'httpMethod'       => 'GET',
            'uri'              => '/v1/charges/{id}',
            'summary'          => 'Get an existing charge',
            'errorResponses'   => $errors,
            'responseModel'    => 'getResponse',
            'parameters'       => [
                'id' => [
                    'description' => 'Unique identifier of the charge',
                    'location'    => 'uri',
                    'type'        => 'string',
                    'required'    => true
                ],
                'expand' => [
                    'description' => 'Allow to expand some properties',
                    'location'    => 'query',
                    'type'        => 'array',
                    'required'    => false
                ]
            ]
        ],

        'getCharges' => [
            'httpMethod'       => 'GET',
            'uri'              => '/v1/charges',
            'summary'          => 'Get existing charges',
            'errorResponses'   => $errors,
            'responseModel'    => 'getResponse',
            'parameters'       => [
                'limit' => [
                    'description' => 'Limit on how many charges are retrieved',
                    'location'    => 'query',
                    'type'        => 'integer',
                    'min'         => 1,
                    'max'         => 100,
                    'required'    => false
                ],
                'starting_after' => [
                    'description' => 'A cursor for use in the pagination',
                    'location'    => 'query',
                    'type'        => 'string',
                    'required'    => false
                ],
                'ending_before' => [
                    'description' => 'A cursor for use in the pagination',
                    'location'    => 'query',
                    'type'        => 'string',
                    'required'    => false
                ],
                'created' => [
                    'description' => 'A filter based on the "created" field. Can be an exact UTC timestamp, or a hash',
                    'location'    => 'query',
                    'type'        => ['string', 'array'],
                    'required'    => false
                ],
                'customer' => [
                    'description' => 'Only return charges for a specific customer',
                    'location'    => 'query',
                    'type'        => 'string',
                    'required'    => false
                ],
                'paid' => [
                    'description' => 'Only return paid charges (true) or not paid (false) (CAUTION: this is not explicitly documented by Stripe)',
                    'location'    => 'query',
                    'type'        => 'boolean',
                    'filters'     => ['ZfrStripe\Client\Filter\BooleanFilter::encodeValue'],
                    'required'    => false
                ],
                'expand' => [
                    'description' => 'Allow to expand some properties',
                    'location'    => 'query',
                    'type'        => 'array',
                    'required'    => false
                ],
                'include' => [
                    'description' => 'Allow to include some additional properties',
                    'location'    => 'query',
                    'type'        => 'array',
                    'required'    => false
                ]
            ]
        ],

        'refundCharge' => [
            'httpMethod'       => 'POST',
            'uri'              => '/v1/charges/{id}/refunds',
            'summary'          => 'Refund an existing charge',
            'errorResponses'   => $errors,
            'responseModel'    => 'getResponse',
            'parameters'       => [
                'id' => [
                    'description' => 'Unique identifier of the charge',
                    'location'    => 'uri',
                    'type'        => 'string',
                    'required'    => true
                ],
                'amount' => [
                    'description' => 'Amount (in cents) - default to the whole charge',
                    'location'    => 'query',
                    'type'        => 'integer',
                    'required'    => false
                ],
                'refund_application_fee' => [
                    'description' => 'Indicate whether the application fee should be refunded when refunding this charge',
                    'location'    => 'query',
                    'type'        => 'boolean',
                    'filters'     => ['ZfrStripe\Client\Filter\BooleanFilter::encodeValue'],
                    'required'    => false
                ],
                'reason' => [
                    'description' => 'Specify a reason for the refund',
                    'location'    => 'query',
                    'type'        => 'string',
                    'required'    => false,
                    'enum'        => ['duplicate', 'fraudulent', 'requested_by_customer']
                ],
                'metadata' => [
                    'description' => 'Optional metadata',
                    'location'    => 'query',
                    'type'        => 'array',
                    'required'    => false
                ],
                'expand' => [
                    'description' => 'Allow to expand some properties',
                    'location'    => 'query',
                    'type'        => 'array',
                    'required'    => false
                ],
                'idempotency_key' => [
                    'description' => 'An indempotency key that prevents accidentally performing the same POST operation twice',
                    'location'    => 'header',
                    'sentAs'      => 'Idempotency-Key',
                    'type'        => 'string',
                    'required'    => false
                ]
            ]
        ],

        'updateCharge' => [
            'httpMethod'       => 'POST',
            'uri'              => '/v1/charges/{id}',
            'summary'          => 'Update an existing charge',
            'errorResponses'   => $errors,
            'responseModel'    => 'getResponse',
            'parameters'       => [
                'id' => [
                    'description' => 'Unique identifier of the charge to update',
                    'location'    => 'uri',
                    'type'        => 'string',
                    'required'    => true
                ],
                'description' => [
                    'description' => 'Optional description for the charge',
                    'location'    => 'query',
                    'type'        => 'string',
                    'required'    => false
                ],
                'metadata' => [
                    'description' => 'Optional metadata',
                    'location'    => 'query',
                    'type'        => 'array',
                    'required'    => false
                ],
                'expand' => [
                    'description' => 'Allow to expand some properties',
                    'location'    => 'query',
                    'type'        => 'array',
                    'required'    => false
                ],
                'idempotency_key' => [
                    'description' => 'An indempotency key that prevents accidentally performing the same POST operation twice',
                    'location'    => 'header',
                    'sentAs'      => 'Idempotency-Key',
                    'type'        => 'string',
                    'required'    => false
                ]
            ]
        ],

        /**
         * --------------------------------------------------------------------------------
         * CUSTOMER RELATED METHODS
         *
         * DOC: https://stripe.com/docs/api#customers
         * --------------------------------------------------------------------------------
         */

        'createCustomer' => [
            'httpMethod'       => 'POST',
            'uri'              => '/v1/customers',
            'summary'          => 'Create a new customer (either card or customer is needed)',
            'errorResponses'   => $errors,
            'responseModel'    => 'getResponse',
            'parameters'       => [
                'account_balance' => [
                    'description' => 'An integer amount in cents that is the starting account balance for your customer',
                    'location'    => 'query',
                    'type'        => 'integer',
                    'required'    => false
                ],
                'card' => [
                    'description' => 'Unique card identifier (can either be an ID or a hash)',
                    'location'    => 'query',
                    'type'        => ['string', 'array'],
                    'required'    => false
                ],
                'coupon' => [
                    'description' => 'Optional coupon identifier that applies a discount on all recurring charges',
                    'location'    => 'query',
                    'type'        => 'string',
                    'required'    => false
                ],
                'plan' => [
                    'description' => 'Optional plan for the customer',
                    'location'    => 'query',
                    'type'        => 'string',
                    'required'    => false
                ],
                'quantity' => [
                    'description' => 'Quantity you\'d like to apply to the subscription you\'re creating',
                    'location'    => 'query',
                    'type'        => 'string',
                    'required'    => false
                ],
                'trial_end' => [
                    'description' => 'UTC integer timestamp representing the end of the trial period the customer will get before being charged for the first time',
                    'location'    => 'query',
                    'type'        => ['integer', 'string'],
                    'required'    => false
                ],
                'description' => [
                    'description' => 'Optional description for the customer',
                    'location'    => 'query',
                    'type'        => 'string',
                    'required'    => false
                ],
                'email' => [
                    'description' => 'Optional customer\'s email address',
                    'location'    => 'query',
                    'type'        => 'string',
                    'required'    => false
                ],
                'metadata' => [
                    'description' => 'Optional metadata',
                    'location'    => 'query',
                    'type'        => 'array',
                    'required'    => false
                ],
                'expand' => [
                    'description' => 'Allow to expand some properties',
                    'location'    => 'query',
                    'type'        => 'array',
                    'required'    => false
                ],
                'idempotency_key' => [
                    'description' => 'An indempotency key that prevents accidentally performing the same POST operation twice',
                    'location'    => 'header',
                    'sentAs'      => 'Idempotency-Key',
                    'type'        => 'string',
                    'required'    => false
                ]
            ]
        ],

        'deleteCustomer' => [
            'httpMethod'       => 'DELETE',
            'uri'              => '/v1/customers/{id}',
            'summary'          => 'Delete an existing customer',
            'errorResponses'   => $errors,
            'responseModel'    => 'getResponse',
            'parameters'       => [
                'id' => [
                    'description' => 'Unique identifier of the customer',
                    'location'    => 'uri',
                    'type'        => 'string',
                    'required'    => true
                ],
                'expand' => [
                    'description' => 'Allow to expand some properties',
                    'location'    => 'query',
                    'type'        => 'array',
                    'required'    => false
                ]
            ]
        ],

        'getCustomer' => [
            'httpMethod'       => 'GET',
            'uri'              => '/v1/customers/{id}',
            'summary'          => 'Get an existing customer',
            'errorResponses'   => $errors,
            'responseModel'    => 'getResponse',
            'parameters'       => [
                'id' => [
                    'description' => 'Unique identifier of the customer',
                    'location'    => 'uri',
                    'type'        => 'string',
                    'required'    => true
                ],
                'expand' => [
                    'description' => 'Allow to expand some properties',
                    'location'    => 'query',
                    'type'        => 'array',
                    'required'    => false
                ]
            ]
        ],

        'getCustomers' => [
            'httpMethod'       => 'GET',
            'uri'              => '/v1/customers',
            'summary'          => 'Get existing customers',
            'errorResponses'   => $errors,
            'responseModel'    => 'getResponse',
            'parameters'       => [
                'limit' => [
                    'description' => 'Limit on how many customers are retrieved',
                    'location'    => 'query',
                    'type'        => 'integer',
                    'min'         => 1,
                    'max'         => 100,
                    'required'    => false
                ],
                'starting_after' => [
                    'description' => 'A cursor for use in the pagination',
                    'location'    => 'query',
                    'type'        => 'string',
                    'required'    => false
                ],
                'ending_before' => [
                    'description' => 'A cursor for use in the pagination',
                    'location'    => 'query',
                    'type'        => 'string',
                    'required'    => false
                ],
                'created' => [
                    'description' => 'A filter based on the "created" field. Can be an exact UTC timestamp, or a hash',
                    'location'    => 'query',
                    'type'        => ['string', 'array'],
                    'required'    => false
                ],
                'deleted' => [
                    'description' => 'Only return deleted customers (true) or other (false)  (CAUTION: this is not explicitly documented by Stripe)',
                    'location'    => 'query',
                    'type'        => 'boolean',
                    'filters'     => ['ZfrStripe\Client\Filter\BooleanFilter::encodeValue'],
                    'required'    => false
                ],
                'expand' => [
                    'description' => 'Allow to expand some properties',
                    'location'    => 'query',
                    'type'        => 'array',
                    'required'    => false
                ],
                'include' => [
                    'description' => 'Allow to include some additional properties',
                    'location'    => 'query',
                    'type'        => 'array',
                    'required'    => false
                ]
            ]
        ],

        'updateCustomer' => [
            'httpMethod'       => 'POST',
            'uri'              => '/v1/customers/{id}',
            'summary'          => 'Update an existing customer',
            'errorResponses'   => $errors,
            'responseModel'    => 'getResponse',
            'parameters'       => [
                'id' => [
                    'description' => 'Unique identifier of the customer to update',
                    'location'    => 'uri',
                    'type'        => 'string',
                    'required'    => true
                ],
                'account_balance' => [
                    'description' => 'An integer amount in cents that is the starting account balance for your customer',
                    'location'    => 'query',
                    'type'        => 'integer',
                    'required'    => false
                ],
                'card' => [
                    'description' => 'Unique card identifier (can either be an ID or a hash)',
                    'location'    => 'query',
                    'type'        => ['string', 'array'],
                    'required'    => false
                ],
                'default_card' => [
                    'description' => 'Default card identifier',
                    'location'    => 'query',
                    'type'        => 'string',
                    'required'    => false
                ],
                'coupon' => [
                    'description' => 'Optional coupon identifier that applies a discount on all recurring charges',
                    'location'    => 'query',
                    'type'        => 'string',
                    'required'    => false
                ],
                'description' => [
                    'description' => 'Optional description for the customer',
                    'location'    => 'query',
                    'type'        => 'string',
                    'required'    => false
                ],
                'email' => [
                    'description' => 'Optional customer\'s email address',
                    'location'    => 'query',
                    'type'        => 'string',
                    'required'    => false
                ],
                'metadata' => [
                    'description' => 'Optional metadata',
                    'location'    => 'query',
                    'type'        => 'array',
                    'required'    => false
                ],
                'expand' => [
                    'description' => 'Allow to expand some properties',
                    'location'    => 'query',
                    'type'        => 'array',
                    'required'    => false
                ],
                'idempotency_key' => [
                    'description' => 'An indempotency key that prevents accidentally performing the same POST operation twice',
                    'location'    => 'header',
                    'sentAs'      => 'Idempotency-Key',
                    'type'        => 'string',
                    'required'    => false
                ]
            ]
        ],

        /**
         * --------------------------------------------------------------------------------
         * CARD RELATED METHODS
         *
         * DOC: https://stripe.com/docs/api#cards
         * --------------------------------------------------------------------------------
         */

        'createCard' => [
            'httpMethod'       => 'POST',
            'uri'              => '/v1/customers/{customer}/cards',
            'summary'          => 'Create a new card for a customer',
            'errorResponses'   => $errors,
            'responseModel'    => 'getResponse',
            'parameters'       => [
                'customer' => [
                    'description' => 'Unique identifier of the customer',
                    'location'    => 'uri',
                    'type'        => 'string',
                    'required'    => true
                ],
                'card' => [
                    'description' => 'Unique card identifier (can either be an ID or a hash)',
                    'location'    => 'query',
                    'type'        => ['string', 'array'],
                    'required'    => false
                ],
                'expand' => [
                    'description' => 'Allow to expand some properties',
                    'location'    => 'query',
                    'type'        => 'array',
                    'required'    => false
                ],
                'idempotency_key' => [
                    'description' => 'An indempotency key that prevents accidentally performing the same POST operation twice',
                    'location'    => 'header',
                    'sentAs'      => 'Idempotency-Key',
                    'type'        => 'string',
                    'required'    => false
                ]
            ]
        ],

        'deleteCard' => [
            'httpMethod'       => 'DELETE',
            'uri'              => '/v1/customers/{customer}/cards/{id}',
            'summary'          => 'Delete an existing customer\'s card',
            'errorResponses'   => $errors,
            'responseModel'    => 'getResponse',
            'parameters'       => [
                'id' => [
                    'description' => 'Unique identifier of the card to delete',
                    'location'    => 'uri',
                    'type'        => 'string',
                    'required'    => true
                ],
                'customer' => [
                    'description' => 'Unique identifier of the customer to delete the card',
                    'location'    => 'uri',
                    'type'        => 'string',
                    'required'    => true
                ],
                'expand' => [
                    'description' => 'Allow to expand some properties',
                    'location'    => 'query',
                    'type'        => 'array',
                    'required'    => false
                ]
            ]
        ],

        'getCard' => [
            'httpMethod'       => 'GET',
            'uri'              => '/v1/customers/{customer}/cards/{id}',
            'summary'          => 'Get an existing customer\'s card',
            'errorResponses'   => $errors,
            'responseModel'    => 'getResponse',
            'parameters'       => [
                'id' => [
                    'description' => 'Unique identifier of the card to get',
                    'location'    => 'uri',
                    'type'        => 'string',
                    'required'    => true
                ],
                'customer' => [
                    'description' => 'Unique identifier of the customer to get the card from',
                    'location'    => 'uri',
                    'type'        => 'string',
                    'required'    => true
                ],
                'expand' => [
                    'description' => 'Allow to expand some properties',
                    'location'    => 'query',
                    'type'        => 'array',
                    'required'    => false
                ]
            ]
        ],

        'getCards' => [
            'httpMethod'       => 'GET',
            'uri'              => '/v1/customers/{customer}/cards',
            'summary'          => 'Get existing customers\'s cards',
            'errorResponses'   => $errors,
            'responseModel'    => 'getResponse',
            'parameters'       => [
                'customer' => [
                    'description' => 'Unique identifier of the customer to get the cards from',
                    'location'    => 'uri',
                    'type'        => 'string',
                    'required'    => true
                ],
                'limit' => [
                    'description' => 'Limit on how many cards are retrieved',
                    'location'    => 'query',
                    'type'        => 'integer',
                    'min'         => 1,
                    'max'         => 100,
                    'required'    => false
                ],
                'starting_after' => [
                    'description' => 'A cursor for use in the pagination',
                    'location'    => 'query',
                    'type'        => 'string',
                    'required'    => false
                ],
                'ending_before' => [
                    'description' => 'A cursor for use in the pagination',
                    'location'    => 'query',
                    'type'        => 'string',
                    'required'    => false
                ],
                'expand' => [
                    'description' => 'Allow to expand some properties',
                    'location'    => 'query',
                    'type'        => 'array',
                    'required'    => false
                ],
                'include' => [
                    'description' => 'Allow to include some additional properties',
                    'location'    => 'query',
                    'type'        => 'array',
                    'required'    => false
                ]
            ]
        ],

        'updateCard' => [
            'httpMethod'       => 'POST',
            'uri'              => '/v1/customers/{customer}/cards/{id}',
            'summary'          => 'Update an existing customer',
            'errorResponses'   => $errors,
            'responseModel'    => 'getResponse',
            'parameters'       => [
                'id' => [
                    'description' => 'Unique identifier of the card to update',
                    'location'    => 'uri',
                    'type'        => 'string',
                    'required'    => true
                ],
                'customer' => [
                    'description' => 'Unique identifier of the customer to get the card from',
                    'location'    => 'uri',
                    'type'        => 'string',
                    'required'    => true
                ],
                'address_city' => [
                    'location' => 'query',
                    'type'     => 'string',
                    'required' => false
                ],
                'address_country' => [
                    'location' => 'query',
                    'type'     => 'string',
                    'required' => false
                ],
                'address_line1' => [
                    'location' => 'query',
                    'type'     => 'string',
                    'required' => false
                ],
                'address_line2' => [
                    'location' => 'query',
                    'type'     => 'string',
                    'required' => false
                ],
                'address_state' => [
                    'location' => 'query',
                    'type'     => 'string',
                    'required' => false
                ],
                'address_zip' => [
                    'location' => 'query',
                    'type'     => 'string',
                    'required' => false
                ],
                'exp_month' => [
                    'location' => 'query',
                    'type'     => 'string',
                    'required' => false
                ],
                'exp_year' => [
                    'location' => 'query',
                    'type'     => 'string',
                    'required' => false
                ],
                'name' => [
                    'location' => 'query',
                    'type'     => 'string',
                    'required' => false
                ],
                'expand' => [
                    'description' => 'Allow to expand some properties',
                    'location'    => 'query',
                    'type'        => 'array',
                    'required'    => false
                ],
                'idempotency_key' => [
                    'description' => 'An indempotency key that prevents accidentally performing the same POST operation twice',
                    'location'    => 'header',
                    'sentAs'      => 'Idempotency-Key',
                    'type'        => 'string',
                    'required'    => false
                ]
            ]
        ],

        /**
         * --------------------------------------------------------------------------------
         * CARD RECIPIENTS RELATED METHODS
         *
         * DOC: https://stripe.com/docs/api#cards
         * --------------------------------------------------------------------------------
         */

        'createRecipientCard' => [
            'httpMethod'       => 'POST',
            'uri'              => '/v1/recipients/{recipient}/cards',
            'summary'          => 'Create a new card for a recipient',
            'errorResponses'   => $errors,
            'responseModel'    => 'getResponse',
            'parameters'       => [
                'recipient' => [
                    'description' => 'Unique identifier of the recipient',
                    'location'    => 'uri',
                    'type'        => 'string',
                    'required'    => true
                ],
                'card' => [
                    'description' => 'Unique card identifier (can either be an ID or a hash)',
                    'location'    => 'query',
                    'type'        => ['string', 'array'],
                    'required'    => false
                ],
                'expand' => [
                    'description' => 'Allow to expand some properties',
                    'location'    => 'query',
                    'type'        => 'array',
                    'required'    => false
                ],
                'idempotency_key' => [
                    'description' => 'An indempotency key that prevents accidentally performing the same POST operation twice',
                    'location'    => 'header',
                    'sentAs'      => 'Idempotency-Key',
                    'type'        => 'string',
                    'required'    => false
                ]
            ]
        ],

        'deleteRecipientCard' => [
            'httpMethod'       => 'DELETE',
            'uri'              => '/v1/recipients/{recipient}/cards/{id}',
            'summary'          => 'Delete an existing recipients\'s card',
            'errorResponses'   => $errors,
            'responseModel'    => 'getResponse',
            'parameters'       => [
                'id' => [
                    'description' => 'Unique identifier of the card to delete',
                    'location'    => 'uri',
                    'type'        => 'string',
                    'required'    => true
                ],
                'recipient' => [
                    'description' => 'Unique identifier of the recipient to delete the card',
                    'location'    => 'uri',
                    'type'        => 'string',
                    'required'    => true
                ],
                'expand' => [
                    'description' => 'Allow to expand some properties',
                    'location'    => 'query',
                    'type'        => 'array',
                    'required'    => false
                ]
            ]
        ],

        'getRecipientCard' => [
            'httpMethod'       => 'GET',
            'uri'              => '/v1/recipients/{recipient}/cards/{id}',
            'summary'          => 'Get an existing recipient\'s card',
            'errorResponses'   => $errors,
            'responseModel'    => 'getResponse',
            'parameters'       => [
                'id' => [
                    'description' => 'Unique identifier of the card to get',
                    'location'    => 'uri',
                    'type'        => 'string',
                    'required'    => true
                ],
                'recipient' => [
                    'description' => 'Unique identifier of the recipient to get the card from',
                    'location'    => 'uri',
                    'type'        => 'string',
                    'required'    => true
                ],
                'expand' => [
                    'description' => 'Allow to expand some properties',
                    'location'    => 'query',
                    'type'        => 'array',
                    'required'    => false
                ]
            ]
        ],

        'getRecipientCards' => [
            'httpMethod'       => 'GET',
            'uri'              => '/v1/recipients/{recipient}/cards',
            'summary'          => 'Get existing recipients\'s cards',
            'errorResponses'   => $errors,
            'responseModel'    => 'getResponse',
            'parameters'       => [
                'recipient' => [
                    'description' => 'Unique identifier of the recipient to get the cards from',
                    'location'    => 'uri',
                    'type'        => 'string',
                    'required'    => true
                ],
                'limit' => [
                    'description' => 'Limit on how many cards are retrieved',
                    'location'    => 'query',
                    'type'        => 'integer',
                    'min'         => 1,
                    'max'         => 100,
                    'required'    => false
                ],
                'starting_after' => [
                    'description' => 'A cursor for use in the pagination',
                    'location'    => 'query',
                    'type'        => 'string',
                    'required'    => false
                ],
                'ending_before' => [
                    'description' => 'A cursor for use in the pagination',
                    'location'    => 'query',
                    'type'        => 'string',
                    'required'    => false
                ],
                'expand' => [
                    'description' => 'Allow to expand some properties',
                    'location'    => 'query',
                    'type'        => 'array',
                    'required'    => false
                ],
                'include' => [
                    'description' => 'Allow to include some additional properties',
                    'location'    => 'query',
                    'type'        => 'array',
                    'required'    => false
                ]
            ]
        ],

        'updateRecipientCard' => [
            'httpMethod'       => 'POST',
            'uri'              => '/v1/recipients/{recipient}/cards/{id}',
            'summary'          => 'Update an existing recipient\'s card',
            'errorResponses'   => $errors,
            'responseModel'    => 'getResponse',
            'parameters'       => [
                'id' => [
                    'description' => 'Unique identifier of the card to update',
                    'location'    => 'uri',
                    'type'        => 'string',
                    'required'    => true
                ],
                'recipient' => [
                    'description' => 'Unique identifier of the recipient to get the card from',
                    'location'    => 'uri',
                    'type'        => 'string',
                    'required'    => true
                ],
                'address_city' => [
                    'location' => 'query',
                    'type'     => 'string',
                    'required' => false
                ],
                'address_country' => [
                    'location' => 'query',
                    'type'     => 'string',
                    'required' => false
                ],
                'address_line1' => [
                    'location' => 'query',
                    'type'     => 'string',
                    'required' => false
                ],
                'address_line2' => [
                    'location' => 'query',
                    'type'     => 'string',
                    'required' => false
                ],
                'address_state' => [
                    'location' => 'query',
                    'type'     => 'string',
                    'required' => false
                ],
                'address_zip' => [
                    'location' => 'query',
                    'type'     => 'string',
                    'required' => false
                ],
                'exp_month' => [
                    'location' => 'query',
                    'type'     => 'string',
                    'required' => false
                ],
                'exp_year' => [
                    'location' => 'query',
                    'type'     => 'string',
                    'required' => false
                ],
                'name' => [
                    'location' => 'query',
                    'type'     => 'string',
                    'required' => false
                ],
                'expand' => [
                    'description' => 'Allow to expand some properties',
                    'location'    => 'query',
                    'type'        => 'array',
                    'required'    => false
                ],
                'idempotency_key' => [
                    'description' => 'An indempotency key that prevents accidentally performing the same POST operation twice',
                    'location'    => 'header',
                    'sentAs'      => 'Idempotency-Key',
                    'type'        => 'string',
                    'required'    => false
                ]
            ]
        ],

        /**
         * --------------------------------------------------------------------------------
         * SUBSCRIPTION RELATED METHODS
         *
         * DOC: https://stripe.com/docs/api#subscriptions
         * --------------------------------------------------------------------------------
         */

        'cancelSubscription' => [
            'httpMethod'       => 'DELETE',
            'uri'              => '/v1/customers/{customer}/subscriptions/{id}',
            'summary'          => 'Delete an existing customer\'s subscription',
            'errorResponses'   => $errors,
            'responseModel'    => 'getResponse',
            'parameters'       => [
                'id' => [
                    'description' => 'Unique identifier of the subscription to cancel',
                    'location'    => 'uri',
                    'type'        => 'string',
                    'required'    => true
                ],
                'customer' => [
                    'description' => 'Unique identifier of the customer to delete the card',
                    'location'    => 'uri',
                    'type'        => 'string',
                    'required'    => true
                ],
                'at_period_end' => [
                    'description' => 'A flag that if set to true will delay the cancellation of the subscription until the end of the current period.',
                    'location'    => 'query',
                    'type'        => 'boolean',
                    'filters'     => ['ZfrStripe\Client\Filter\BooleanFilter::encodeValue'],
                    'required'    => false
                ],
                'expand' => [
                    'description' => 'Allow to expand some properties',
                    'location'    => 'query',
                    'type'        => 'array',
                    'required'    => false
                ]
            ]
        ],

        'createSubscription' => [
            'httpMethod'       => 'POST',
            'uri'              => '/v1/customers/{customer}/subscriptions',
            'summary'          => 'Create a customer\'s new subscription',
            'errorResponses'   => $errors,
            'responseModel'    => 'getResponse',
            'parameters'       => [
                'customer' => [
                    'description' => 'Unique identifier of the customer',
                    'location'    => 'uri',
                    'type'        => 'string',
                    'required'    => true
                ],
                'plan' => [
                    'description' => 'Unique plan identifier',
                    'location'    => 'query',
                    'type'        => 'string',
                    'required'    => true
                ],
                'quantity' => [
                    'description' => 'Quantity you\'d like to apply to the subscription you\'re creating',
                    'location'    => 'query',
                    'type'        => 'string',
                    'required'    => false
                ],
                'card' => [
                    'description' => 'Unique card identifier (can either be an ID or a hash)',
                    'location'    => 'query',
                    'type'        => ['string', 'array'],
                    'required'    => false
                ],
                'coupon' => [
                    'description' => 'Optional coupon identifier that applies a discount at the same time as creating the subscription',
                    'location'    => 'query',
                    'type'        => 'string',
                    'required'    => false
                ],
                'billing_cycle_anchor' => [
                    'description' => 'UTC integer timestamp that defines the date of the recurring billing cycle',
                    'location'    => 'query',
                    'type'        => ['integer', 'string'],
                    'required'    => false
                ],
                'trial_end' => [
                    'description' => 'UTC integer timestamp representing the end of the trial period the customer will get before being charged for the first time',
                    'location'    => 'query',
                    'type'        => ['integer', 'string'],
                    'required'    => false
                ],
                'application_fee_percent' => [
                    'description' => 'A positive decimal (with at most two decimal places) between 1 and 100 that represents the percentage of the subscription invoice amount due each billing period that will be transferred to the application owner’s Stripe account',
                    'location'    => 'query',
                    'type'        => 'string',
                    'required'    => false
                ],
                'tax_percent' => [
                    'description' => 'A positive decimal (with at most two decimal places) between 1 and 100 that represents the percentage of the subscription invoice subtotal that will be calculated and added as tax to the final amount each billing period',
                    'location'    => 'query',
                    'type'        => 'number',
                    'required'    => false
                ],
                'metadata' => [
                    'description' => 'Optional metadata',
                    'location'    => 'query',
                    'type'        => 'array',
                    'required'    => false
                ],
                'expand' => [
                    'description' => 'Allow to expand some properties',
                    'location'    => 'query',
                    'type'        => 'array',
                    'required'    => false
                ],
                'idempotency_key' => [
                    'description' => 'An indempotency key that prevents accidentally performing the same POST operation twice',
                    'location'    => 'header',
                    'sentAs'      => 'Idempotency-Key',
                    'type'        => 'string',
                    'required'    => false
                ]
            ]
        ],

        'getSubscription' => [
            'httpMethod'       => 'GET',
            'uri'              => '/v1/customers/{customer}/subscriptions/{id}',
            'summary'          => 'Get an existing customer\'s active subscription',
            'errorResponses'   => $errors,
            'responseModel'    => 'getResponse',
            'parameters'       => [
                'id' => [
                    'description' => 'Unique identifier of the active subscription to get',
                    'location'    => 'uri',
                    'type'        => 'string',
                    'required'    => true
                ],
                'customer' => [
                    'description' => 'Unique identifier of the customer to get the subscription from',
                    'location'    => 'uri',
                    'type'        => 'string',
                    'required'    => true
                ],
                'expand' => [
                    'description' => 'Allow to expand some properties',
                    'location'    => 'query',
                    'type'        => 'array',
                    'required'    => false
                ]
            ]
        ],

        'getSubscriptions' => [
            'httpMethod'       => 'GET',
            'uri'              => '/v1/customers/{customer}/subscriptions',
            'summary'          => 'Get existing customers\'s active subscriptions',
            'errorResponses'   => $errors,
            'responseModel'    => 'getResponse',
            'parameters'       => [
                'customer' => [
                    'description' => 'Unique identifier of the customer to get the subscriptions from',
                    'location'    => 'uri',
                    'type'        => 'string',
                    'required'    => true
                ],
                'limit' => [
                    'description' => 'Limit on how many subscriptions are retrieved',
                    'location'    => 'query',
                    'type'        => 'integer',
                    'min'         => 1,
                    'max'         => 100,
                    'required'    => false
                ],
                'starting_after' => [
                    'description' => 'A cursor for use in the pagination',
                    'location'    => 'query',
                    'type'        => 'string',
                    'required'    => false
                ],
                'ending_before' => [
                    'description' => 'A cursor for use in the pagination',
                    'location'    => 'query',
                    'type'        => 'string',
                    'required'    => false
                ],
                'expand' => [
                    'description' => 'Allow to expand some properties',
                    'location'    => 'query',
                    'type'        => 'array',
                    'required'    => false
                ],
                'include' => [
                    'description' => 'Allow to include some additional properties',
                    'location'    => 'query',
                    'type'        => 'array',
                    'required'    => false
                ]
            ]
        ],

        'updateSubscription' => [
            'httpMethod'       => 'POST',
            'uri'              => '/v1/customers/{customer}/subscriptions/{id}',
            'summary'          => 'Update a customer\'s subscription',
            'errorResponses'   => $errors,
            'responseModel'    => 'getResponse',
            'parameters'       => [
                'id' => [
                    'description' => 'Unique identifier of the subscription to update',
                    'location'    => 'uri',
                    'type'        => 'string',
                    'required'    => true
                ],
                'customer' => [
                    'description' => 'Unique identifier of the customer',
                    'location'    => 'uri',
                    'type'        => 'string',
                    'required'    => true
                ],
                'plan' => [
                    'description' => 'Unique plan identifier',
                    'location'    => 'query',
                    'type'        => 'string',
                    'required'    => false
                ],
                'quantity' => [
                    'description' => 'Quantity you\'d like to apply to the subscription you\'re creating',
                    'location'    => 'query',
                    'type'        => 'string',
                    'required'    => false
                ],
                'card' => [
                    'description' => 'Unique card identifier (can either be an ID or a hash)',
                    'location'    => 'query',
                    'type'        => ['string', 'array'],
                    'required'    => false
                ],
                'coupon' => [
                    'description' => 'Optional coupon identifier that applies a discount at the same time as creating the subscription',
                    'location'    => 'query',
                    'type'        => 'string',
                    'required'    => false
                ],
                'prorate' => [
                    'description' => 'Flag telling us whether to prorate switching plans during a billing cycle',
                    'location'    => 'query',
                    'type'        => 'boolean',
                    'filters'     => ['ZfrStripe\Client\Filter\BooleanFilter::encodeValue'],
                    'required'    => false
                ],
                'billing_cycle_anchor' => [
                    'description' => 'UTC integer timestamp that defines the date of the recurring billing cycle',
                    'location'    => 'query',
                    'type'        => ['integer', 'string'],
                    'required'    => false
                ],
                'trial_end' => [
                    'description' => 'UTC integer timestamp representing the end of the trial period the customer will get before being charged for the first time',
                    'location'    => 'query',
                    'type'        => ['integer', 'string'],
                    'required'    => false
                ],
                'application_fee_percent' => [
                    'description' => 'A positive decimal (with at most two decimal places) between 1 and 100 that represents the percentage of the subscription invoice amount due each billing period that will be transferred to the application owner’s Stripe account',
                    'location'    => 'query',
                    'type'        => 'string',
                    'required'    => false
                ],
                'tax_percent' => [
                    'description' => 'A positive decimal (with at most two decimal places) between 1 and 100 that represents the percentage of the subscription invoice subtotal that will be calculated and added as tax to the final amount each billing period',
                    'location'    => 'query',
                    'type'        => 'number',
                    'required'    => false
                ],
                'metadata' => [
                    'description' => 'Optional metadata',
                    'location'    => 'query',
                    'type'        => 'array',
                    'required'    => false
                ],
                'expand' => [
                    'description' => 'Allow to expand some properties',
                    'location'    => 'query',
                    'type'        => 'array',
                    'required'    => false
                ],
                'idempotency_key' => [
                    'description' => 'An indempotency key that prevents accidentally performing the same POST operation twice',
                    'location'    => 'header',
                    'sentAs'      => 'Idempotency-Key',
                    'type'        => 'string',
                    'required'    => false
                ]
            ]
        ],

        /**
         * --------------------------------------------------------------------------------
         * PLAN RELATED METHODS
         *
         * DOC: https://stripe.com/docs/api#plans
         * --------------------------------------------------------------------------------
         */

        'createPlan' => [
            'httpMethod'       => 'POST',
            'uri'              => '/v1/plans',
            'summary'          => 'Create a new plan',
            'errorResponses'   => $errors,
            'responseModel'    => 'getResponse',
            'parameters'       => [
                'id' => [
                    'description' => 'Unique string to identify the plan',
                    'location'    => 'query',
                    'type'        => 'string',
                    'required'    => true
                ],
                'name' => [
                    'description' => 'Unique name of the plan',
                    'location'    => 'query',
                    'type'        => 'string',
                    'required'    => true
                ],
                'amount' => [
                    'description' => 'Amount (in cents)',
                    'location'    => 'query',
                    'type'        => 'integer',
                    'required'    => true
                ],
                'currency' => [
                    'description' => '3-letter ISO code for currency',
                    'location'    => 'query',
                    'type'        => 'string',
                    'required'    => true
                ],
                'interval' => [
                    'description' => 'Specify the billing frequency',
                    'location'    => 'query',
                    'type'        => 'string',
                    'required'    => true,
                    'enum'        => ['day', 'week', 'month', 'year']
                ],
                'interval_count' => [
                    'description' => 'Number of interval between each subscription billing',
                    'location'    => 'query',
                    'type'        => 'integer',
                    'required'    => false
                ],
                'trial_period_days' => [
                    'description' => 'Specifies a trial period in (an integer number of) days',
                    'location'    => 'query',
                    'type'        => 'integer',
                    'required'    => false
                ],
                'metadata' => [
                    'description' => 'Optional metadata',
                    'location'    => 'query',
                    'type'        => 'array',
                    'required'    => false
                ],
                'statement_description' => [
                    'description' => 'An arbitrary string to be displayed alongside your customer\'s credit card statement',
                    'location'    => 'query',
                    'type'        => 'string',
                    'required'    => false
                ],
                'expand' => [
                    'description' => 'Allow to expand some properties',
                    'location'    => 'query',
                    'type'        => 'array',
                    'required'    => false
                ],
                'idempotency_key' => [
                    'description' => 'An indempotency key that prevents accidentally performing the same POST operation twice',
                    'location'    => 'header',
                    'sentAs'      => 'Idempotency-Key',
                    'type'        => 'string',
                    'required'    => false
                ]
            ]
        ],

        'deletePlan' => [
            'httpMethod'       => 'DELETE',
            'uri'              => '/v1/plans/{id}',
            'summary'          => 'Delete an existing plan',
            'errorResponses'   => $errors,
            'responseModel'    => 'getResponse',
            'parameters'       => [
                'id' => [
                    'description' => 'Unique identifier of the plan',
                    'location'    => 'uri',
                    'type'        => 'string',
                    'required'    => true
                ],
                'expand' => [
                    'description' => 'Allow to expand some properties',
                    'location'    => 'query',
                    'type'        => 'array',
                    'required'    => false
                ]
            ]
        ],

        'getPlan' => [
            'httpMethod'       => 'GET',
            'uri'              => '/v1/plans/{id}',
            'summary'          => 'Get an existing plan',
            'errorResponses'   => $errors,
            'responseModel'    => 'getResponse',
            'parameters'       => [
                'id' => [
                    'description' => 'Unique identifier of the plan',
                    'location'    => 'uri',
                    'type'        => 'string',
                    'required'    => true
                ],
                'expand' => [
                    'description' => 'Allow to expand some properties',
                    'location'    => 'query',
                    'type'        => 'array',
                    'required'    => false
                ]
            ]
        ],

        'getPlans' => [
            'httpMethod'       => 'GET',
            'uri'              => '/v1/plans',
            'summary'          => 'Get existing plans',
            'errorResponses'   => $errors,
            'responseModel'    => 'getResponse',
            'parameters'       => [
                'limit' => [
                    'description' => 'Limit on how many plans are retrieved',
                    'location'    => 'query',
                    'type'        => 'integer',
                    'min'         => 1,
                    'max'         => 100,
                    'required'    => false
                ],
                'starting_after' => [
                    'description' => 'A cursor for use in the pagination',
                    'location'    => 'query',
                    'type'        => 'string',
                    'required'    => false
                ],
                'ending_before' => [
                    'description' => 'A cursor for use in the pagination',
                    'location'    => 'query',
                    'type'        => 'string',
                    'required'    => false
                ],
                'expand' => [
                    'description' => 'Allow to expand some properties',
                    'location'    => 'query',
                    'type'        => 'array',
                    'required'    => false
                ],
                'include' => [
                    'description' => 'Allow to include some additional properties',
                    'location'    => 'query',
                    'type'        => 'array',
                    'required'    => false
                ]
            ]
        ],

        'updatePlan' => [
            'httpMethod'       => 'POST',
            'uri'              => '/v1/plans/{id}',
            'summary'          => 'Update an existing plan',
            'errorResponses'   => $errors,
            'responseModel'    => 'getResponse',
            'parameters'       => [
                'id' => [
                    'description' => 'Unique identifier of the plan to update',
                    'location'    => 'uri',
                    'type'        => 'string',
                    'required'    => true
                ],
                'name' => [
                    'description' => 'Unique name of the plan',
                    'location'    => 'query',
                    'type'        => 'string',
                    'required'    => false
                ],
                'metadata' => [
                    'description' => 'Optional metadata',
                    'location'    => 'query',
                    'type'        => 'array',
                    'required'    => false
                ],
                'statement_description' => [
                    'description' => 'An arbitrary string to be displayed alongside your customer\'s credit card statement',
                    'location'    => 'query',
                    'type'        => 'string',
                    'required'    => false
                ],
                'expand' => [
                    'description' => 'Allow to expand some properties',
                    'location'    => 'query',
                    'type'        => 'array',
                    'required'    => false
                ],
                'idempotency_key' => [
                    'description' => 'An indempotency key that prevents accidentally performing the same POST operation twice',
                    'location'    => 'header',
                    'sentAs'      => 'Idempotency-Key',
                    'type'        => 'string',
                    'required'    => false
                ]
            ]
        ],

        /**
         * --------------------------------------------------------------------------------
         * COUPON RELATED METHODS
         *
         * DOC: https://stripe.com/docs/api#coupons
         * --------------------------------------------------------------------------------
         */

        'createCoupon' => [
            'httpMethod'       => 'POST',
            'uri'              => '/v1/coupons',
            'summary'          => 'Create a new coupon',
            'errorResponses'   => $errors,
            'responseModel'    => 'getResponse',
            'parameters'       => [
                'id' => [
                    'description' => 'Unique string to identify the coupon (you can specify none and it will be auto-generated)',
                    'location'    => 'query',
                    'type'        => 'string',
                    'required'    => false
                ],
                'duration' => [
                    'description' => 'Specifies how long the discount will be in effect (can be "forever", "once" or "repeating")',
                    'location'    => 'query',
                    'type'        => 'string',
                    'required'    => true,
                    'enum'        => ['forever', 'once', 'repeating']
                ],
                'amount_off' => [
                    'description' => 'A positive integer representing the amount to subtract from an invoice total (required if "percent_off" is not passed)',
                    'location'    => 'query',
                    'type'        => 'integer',
                    'required'    => false
                ],
                'currency' => [
                    'description' => 'Currency of the amount_off parameter (required if "amount_off" is passed)',
                    'location'    => 'query',
                    'type'        => 'string',
                    'required'    => false
                ],
                'duration_in_months' => [
                    'description' => 'If "duration" is repeating, a positive integer that specifies the number of months the discount will be in effect',
                    'location'    => 'query',
                    'type'        => 'integer',
                    'required'    => false
                ],
                'max_redemptions' => [
                    'description' => 'A positive integer specifying the number of times the coupon can be redeemed before it\'s no longer valid',
                    'location'    => 'query',
                    'type'        => 'integer',
                    'required'    => false
                ],
                'percent_off' => [
                    'description' => 'A positive integer between 1 and 100 that represents the discount the coupon will apply (required if amount_off is not passed)',
                    'location'    => 'query',
                    'type'        => 'integer',
                    'required'    => false
                ],
                'redeem_by' => [
                    'description' => 'UTC timestamp specifying the last time at which the coupon can be redeemed',
                    'location'    => 'query',
                    'type'        => 'integer',
                    'required'    => false
                ],
                'expand' => [
                    'description' => 'Allow to expand some properties',
                    'location'    => 'query',
                    'type'        => 'array',
                    'required'    => false
                ],
                'idempotency_key' => [
                    'description' => 'An indempotency key that prevents accidentally performing the same POST operation twice',
                    'location'    => 'header',
                    'sentAs'      => 'Idempotency-Key',
                    'type'        => 'string',
                    'required'    => false
                ]
            ]
        ],

        'deleteCoupon' => [
            'httpMethod'       => 'DELETE',
            'uri'              => '/v1/coupons/{id}',
            'summary'          => 'Delete an existing coupon',
            'errorResponses'   => $errors,
            'responseModel'    => 'getResponse',
            'parameters'       => [
                'id' => [
                    'description' => 'Unique identifier of the coupon',
                    'location'    => 'uri',
                    'type'        => 'string',
                    'required'    => true
                ],
                'expand' => [
                    'description' => 'Allow to expand some properties',
                    'location'    => 'query',
                    'type'        => 'array',
                    'required'    => false
                ]
            ]
        ],

        'getCoupon' => [
            'httpMethod'       => 'GET',
            'uri'              => '/v1/coupons/{id}',
            'summary'          => 'Get an existing coupon',
            'errorResponses'   => $errors,
            'responseModel'    => 'getResponse',
            'parameters'       => [
                'id' => [
                    'description' => 'Unique identifier of the plan',
                    'location'    => 'uri',
                    'type'        => 'string',
                    'required'    => true
                ],
                'expand' => [
                    'description' => 'Allow to expand some properties',
                    'location'    => 'query',
                    'type'        => 'array',
                    'required'    => false
                ]
            ]
        ],

        'getCoupons' => [
            'httpMethod'       => 'GET',
            'uri'              => '/v1/coupons/{id}',
            'summary'          => 'Get existing plans',
            'errorResponses'   => $errors,
            'responseModel'    => 'getResponse',
            'parameters'       => [
                'limit' => [
                    'description' => 'Limit on how many coupons are retrieved',
                    'location'    => 'query',
                    'type'        => 'integer',
                    'min'         => 1,
                    'max'         => 100,
                    'required'    => false
                ],
                'starting_after' => [
                    'description' => 'A cursor for use in the pagination',
                    'location'    => 'query',
                    'type'        => 'string',
                    'required'    => false
                ],
                'ending_before' => [
                    'description' => 'A cursor for use in the pagination',
                    'location'    => 'query',
                    'type'        => 'string',
                    'required'    => false
                ],
                'expand' => [
                    'description' => 'Allow to expand some properties',
                    'location'    => 'query',
                    'type'        => 'array',
                    'required'    => false
                ],
                'include' => [
                    'description' => 'Allow to include some additional properties',
                    'location'    => 'query',
                    'type'        => 'array',
                    'required'    => false
                ]
            ]
        ],

        'updateCoupon' => [
            'httpMethod'       => 'POST',
            'uri'              => '/v1/coupons/{id}',
            'summary'          => 'Update an existing coupon',
            'errorResponses'   => $errors,
            'responseModel'    => 'getResponse',
            'parameters'       => [
                'id' => [
                    'description' => 'Unique identifier of the coupon to update',
                    'location'    => 'uri',
                    'type'        => 'string',
                    'required'    => true
                ],
                'metadata' => [
                    'description' => 'Optional metadata',
                    'location'    => 'query',
                    'type'        => 'array',
                    'required'    => false
                ],
                'expand' => [
                    'description' => 'Allow to expand some properties',
                    'location'    => 'query',
                    'type'        => 'array',
                    'required'    => false
                ],
                'idempotency_key' => [
                    'description' => 'An indempotency key that prevents accidentally performing the same POST operation twice',
                    'location'    => 'header',
                    'sentAs'      => 'Idempotency-Key',
                    'type'        => 'string',
                    'required'    => false
                ]
            ]
        ],

        /**
         * --------------------------------------------------------------------------------
         * DISCOUNT RELATED METHODS
         *
         * DOC: https://stripe.com/docs/api#discounts
         * --------------------------------------------------------------------------------
         */

        'deleteCustomerDiscount' => [
            'httpMethod'       => 'DELETE',
            'uri'              => '/v1/customers/{customer}/discount',
            'summary'          => 'Delete a customer wide discount',
            'errorResponses'   => $errors,
            'responseModel'    => 'getResponse',
            'parameters'       => [
                'customer' => [
                    'description' => 'Unique identifier of the customer to delete the discount from',
                    'location'    => 'uri',
                    'type'        => 'string',
                    'required'    => true
                ],
                'expand' => [
                    'description' => 'Allow to expand some properties',
                    'location'    => 'query',
                    'type'        => 'array',
                    'required'    => false
                ]
            ]
        ],

        'deleteSubscriptionDiscount' => [
            'httpMethod'       => 'DELETE',
            'uri'              => '/v1/customers/{customer}/subscriptions/{subscription}/discount',
            'summary'          => 'Delete a discount applied on a subscription',
            'errorResponses'   => $errors,
            'responseModel'    => 'getResponse',
            'parameters'       => [
                'customer' => [
                    'description' => 'Unique identifier of the customer to delete the discount from',
                    'location'    => 'uri',
                    'type'        => 'string',
                    'required'    => true
                ],
                'subscription' => [
                    'description' => 'Unique identifier of the subscription to delete the discount from',
                    'location'    => 'uri',
                    'type'        => 'string',
                    'required'    => true
                ],
                'expand' => [
                    'description' => 'Allow to expand some properties',
                    'location'    => 'query',
                    'type'        => 'array',
                    'required'    => false
                ]
            ]
        ],

        /**
         * --------------------------------------------------------------------------------
         * INVOICE RELATED METHODS
         *
         * DOC: https://stripe.com/docs/api#invoices
         * --------------------------------------------------------------------------------
         */

        'createInvoice' => [
            'httpMethod'       => 'POST',
            'uri'              => '/v1/invoices',
            'summary'          => 'Create a new invoice',
            'errorResponses'   => $errors,
            'responseModel'    => 'getResponse',
            'parameters'       => [
                'customer' => [
                    'description' => 'Unique string to identify the plan',
                    'location'    => 'query',
                    'type'        => 'string',
                    'required'    => true
                ],
                'subscription' => [
                    'description' => 'Identifier of the subscription to invoice',
                    'location'    => 'query',
                    'type'        => 'string',
                    'required'    => false
                ],
                'description' => [
                    'description' => 'Optional description for the invoice',
                    'location'    => 'query',
                    'type'        => 'string',
                    'required'    => false
                ],
                'statement_description' => [
                    'description' => 'Extra information about a charge for the customer\'s credit card statement',
                    'location'    => 'query',
                    'type'        => 'string',
                    'required'    => false
                ],
                'application_fee' => [
                    'description' => 'A fee in cents that will be applied to the invoice and transferred to the application owner\'s Stripe account',
                    'location'    => 'query',
                    'type'        => 'integer',
                    'required'    => false
                ],
                'expand' => [
                    'description' => 'Allow to expand some properties',
                    'location'    => 'query',
                    'type'        => 'array',
                    'required'    => false
                ],
                'idempotency_key' => [
                    'description' => 'An indempotency key that prevents accidentally performing the same POST operation twice',
                    'location'    => 'header',
                    'sentAs'      => 'Idempotency-Key',
                    'type'        => 'string',
                    'required'    => false
                ]
            ]
        ],

        'getInvoice' => [
            'httpMethod'       => 'GET',
            'uri'              => '/v1/invoices/{id}',
            'summary'          => 'Get an existing invoice',
            'errorResponses'   => $errors,
            'responseModel'    => 'getResponse',
            'parameters'       => [
                'id' => [
                    'description' => 'Unique identifier of the invoice',
                    'location'    => 'uri',
                    'type'        => 'string',
                    'required'    => true
                ],
                'expand' => [
                    'description' => 'Allow to expand some properties',
                    'location'    => 'query',
                    'type'        => 'array',
                    'required'    => false
                ]
            ]
        ],

        'getInvoiceLineItems' => [
            'httpMethod'       => 'GET',
            'uri'              => '/v1/invoices/{invoice}/lines',
            'summary'          => 'Get an existing invoice line items',
            'errorResponses'   => $errors,
            'responseModel'    => 'getResponse',
            'parameters'       => [
                'invoice' => [
                    'description' => 'Unique identifier of the invoice to retrieve invoice items from',
                    'location'    => 'uri',
                    'type'        => 'string',
                    'required'    => true
                ],
                'customer' => [
                    'description' => 'Only return invoice line items for a specific customer',
                    'location'    => 'query',
                    'type'        => 'string',
                    'required'    => false
                ],
                'subscription' => [
                    'description' => 'In the case of upcoming invoices, the subscription is optional. Otherwise it is ignored',
                    'location'    => 'query',
                    'type'        => 'string',
                    'required'    => false
                ],
                'limit' => [
                    'description' => 'Limit on how many invoice line items are retrieved',
                    'location'    => 'query',
                    'type'        => 'integer',
                    'min'         => 1,
                    'max'         => 100,
                    'required'    => false
                ],
                'starting_after' => [
                    'description' => 'A cursor for use in the pagination',
                    'location'    => 'query',
                    'type'        => 'string',
                    'required'    => false
                ],
                'ending_before' => [
                    'description' => 'A cursor for use in the pagination',
                    'location'    => 'query',
                    'type'        => 'string',
                    'required'    => false
                ],
                'expand' => [
                    'description' => 'Allow to expand some properties',
                    'location'    => 'query',
                    'type'        => 'array',
                    'required'    => false
                ]
            ]
        ],

        'getInvoices' => [
            'httpMethod'       => 'GET',
            'uri'              => '/v1/invoices',
            'summary'          => 'Get existing invoices',
            'errorResponses'   => $errors,
            'responseModel'    => 'getResponse',
            'parameters'       => [
                'limit' => [
                    'description' => 'Limit on how many invoices are retrieved',
                    'location'    => 'query',
                    'type'        => 'integer',
                    'min'         => 1,
                    'max'         => 100,
                    'required'    => false
                ],
                'starting_after' => [
                    'description' => 'A cursor for use in the pagination',
                    'location'    => 'query',
                    'type'        => 'string',
                    'required'    => false
                ],
                'ending_before' => [
                    'description' => 'A cursor for use in the pagination',
                    'location'    => 'query',
                    'type'        => 'string',
                    'required'    => false
                ],
                'date' => [
                    'description' => 'A filter based on the "date" field. Can be an exact UTC timestamp, or a hash',
                    'location'    => 'query',
                    'type'        => ['string', 'array'],
                    'required'    => false
                ],
                'customer' => [
                    'description' => 'Only return invoices for a specific customer',
                    'location'    => 'query',
                    'type'        => 'string',
                    'required'    => false
                ],
                'expand' => [
                    'description' => 'Allow to expand some properties',
                    'location'    => 'query',
                    'type'        => 'array',
                    'required'    => false
                ],
                'include' => [
                    'description' => 'Allow to include some additional properties',
                    'location'    => 'query',
                    'type'        => 'array',
                    'required'    => false
                ]
            ]
        ],

        'getUpcomingInvoice' => [
            'httpMethod'       => 'GET',
            'uri'              => '/v1/invoices/upcoming',
            'summary'          => 'Get upcoming invoices',
            'errorResponses'   => $errors,
            'responseModel'    => 'getResponse',
            'parameters'       => [
                'customer' => [
                    'description' => 'Only return upcoming invoices for a specific customer',
                    'location'    => 'query',
                    'type'        => 'string',
                    'required'    => true
                ],
                'subscription' => [
                    'description' => 'The identifier of the subscription for which you\'d like to retrieve the upcoming invoice',
                    'location'    => 'query',
                    'type'        => 'string',
                    'required'    => false
                ],
                'expand' => [
                    'description' => 'Allow to expand some properties',
                    'location'    => 'query',
                    'type'        => 'array',
                    'required'    => false
                ]
            ]
        ],

        'getUpcomingInvoiceLineItems' => [
            'httpMethod'       => 'GET',
            'uri'              => '/v1/invoices/upcoming/lines',
            'summary'          => 'Get an existing invoice line items',
            'errorResponses'   => $errors,
            'responseModel'    => 'getResponse',
            'parameters'       => [
                'customer' => [
                    'description' => 'Only return invoice line items for a specific customer',
                    'location'    => 'query',
                    'type'        => 'string',
                    'required'    => true
                ],
                'subscription' => [
                    'description' => 'In the case of upcoming invoices, the subscription is optional. Otherwise it is ignored',
                    'location'    => 'query',
                    'type'        => 'string',
                    'required'    => false
                ],
                'limit' => [
                    'description' => 'Limit on how many invoice line items are retrieved',
                    'location'    => 'query',
                    'type'        => 'integer',
                    'min'         => 1,
                    'max'         => 100,
                    'required'    => false
                ],
                'starting_after' => [
                    'description' => 'A cursor for use in the pagination',
                    'location'    => 'query',
                    'type'        => 'string',
                    'required'    => false
                ],
                'ending_before' => [
                    'description' => 'A cursor for use in the pagination',
                    'location'    => 'query',
                    'type'        => 'string',
                    'required'    => false
                ],
                'expand' => [
                    'description' => 'Allow to expand some properties',
                    'location'    => 'query',
                    'type'        => 'array',
                    'required'    => false
                ]
            ]
        ],

        'payInvoice' => [
            'httpMethod'       => 'POST',
            'uri'              => '/v1/invoices/{id}/pay',
            'summary'          => 'Pay an existing invoice',
            'errorResponses'   => $errors,
            'responseModel'    => 'getResponse',
            'parameters'       => [
                'id' => [
                    'description' => 'Unique identifier of the invoice to pay',
                    'location'    => 'uri',
                    'type'        => 'string',
                    'required'    => true
                ],
                'expand' => [
                    'description' => 'Allow to expand some properties',
                    'location'    => 'query',
                    'type'        => 'array',
                    'required'    => false
                ],
                'idempotency_key' => [
                    'description' => 'An indempotency key that prevents accidentally performing the same POST operation twice',
                    'location'    => 'header',
                    'sentAs'      => 'Idempotency-Key',
                    'type'        => 'string',
                    'required'    => false
                ]
            ]
        ],

        'updateInvoice' => [
            'httpMethod'       => 'POST',
            'uri'              => '/v1/invoices/{id}',
            'summary'          => 'Update an existing invoice',
            'errorResponses'   => $errors,
            'responseModel'    => 'getResponse',
            'parameters'       => [
                'id' => [
                    'description' => 'Unique identifier of the invoice to update',
                    'location'    => 'uri',
                    'type'        => 'string',
                    'required'    => true
                ],
                'description' => [
                    'description' => 'Optional description for the invoice',
                    'location'    => 'query',
                    'type'        => 'string',
                    'required'    => false
                ],
                'statement_description' => [
                    'description' => 'Extra information about a charge for the customer\'s credit card statement',
                    'location'    => 'query',
                    'type'        => 'string',
                    'required'    => false
                ],
                'forgiven' => [
                    'description' => 'Whether an invoice is forgiven or not',
                    'location'    => 'query',
                    'type'        => 'boolean',
                    'filters'     => ['ZfrStripe\Client\Filter\BooleanFilter::encodeValue'],
                    'required'    => false
                ],
                'application_fee' => [
                    'description' => 'A fee in cents that will be applied to the invoice and transferred to the application owner\'s Stripe account',
                    'location'    => 'query',
                    'type'        => 'integer',
                    'required'    => false
                ],
                'closed' => [
                    'description' => 'Boolean representing whether an invoice is closed or not',
                    'location'    => 'query',
                    'type'        => 'boolean',
                    'filters'     => ['ZfrStripe\Client\Filter\BooleanFilter::encodeValue'],
                    'required'    => false
                ],
                'expand' => [
                    'description' => 'Allow to expand some properties',
                    'location'    => 'query',
                    'type'        => 'array',
                    'required'    => false
                ],
                'idempotency_key' => [
                    'description' => 'An indempotency key that prevents accidentally performing the same POST operation twice',
                    'location'    => 'header',
                    'sentAs'      => 'Idempotency-Key',
                    'type'        => 'string',
                    'required'    => false
                ]
            ]
        ],

        /**
         * --------------------------------------------------------------------------------
         * INVOICE ITEM RELATED METHODS
         *
         * DOC: https://stripe.com/docs/api#invoiceitems
         * --------------------------------------------------------------------------------
         */

        'createInvoiceItem' => [
            'httpMethod'       => 'POST',
            'uri'              => '/v1/invoiceitems',
            'summary'          => 'Create a new invoice item',
            'errorResponses'   => $errors,
            'responseModel'    => 'getResponse',
            'parameters'       => [
                'customer' => [
                    'description' => 'ID of the customer who will be billed when this invoice item is billed',
                    'location'    => 'query',
                    'type'        => 'string',
                    'required'    => true
                ],
                'amount' => [
                    'description' => 'Amount (in cents)',
                    'location'    => 'query',
                    'type'        => 'integer',
                    'required'    => true
                ],
                'currency' => [
                    'description' => '3-letter ISO code for currency',
                    'location'    => 'query',
                    'type'        => 'string',
                    'required'    => true
                ],
                'invoice' => [
                    'description' => 'Identifier of an existing invoice to add this invoice item to',
                    'location'    => 'query',
                    'type'        => 'string',
                    'required'    => false
                ],
                'subscription' => [
                    'description' => 'Identifier of a subscription to add this invoice item to',
                    'location'    => 'query',
                    'type'        => 'string',
                    'required'    => false
                ],
                'description' => [
                    'description' => 'Optional description to add',
                    'location'    => 'query',
                    'type'        => 'string',
                    'required'    => false
                ],
                'metadata' => [
                    'description' => 'Optional metadata',
                    'location'    => 'query',
                    'type'        => 'array',
                    'required'    => false
                ],
                'expand' => [
                    'description' => 'Allow to expand some properties',
                    'location'    => 'query',
                    'type'        => 'array',
                    'required'    => false
                ],
                'idempotency_key' => [
                    'description' => 'An indempotency key that prevents accidentally performing the same POST operation twice',
                    'location'    => 'header',
                    'sentAs'      => 'Idempotency-Key',
                    'type'        => 'string',
                    'required'    => false
                ]
            ]
        ],

        'deleteInvoiceItem' => [
            'httpMethod'       => 'DELETE',
            'uri'              => '/v1/invoiceitems/{id}',
            'summary'          => 'Delete an existing invoice item',
            'errorResponses'   => $errors,
            'responseModel'    => 'getResponse',
            'parameters'       => [
                'id' => [
                    'description' => 'Unique identifier of the invoice item',
                    'location'    => 'uri',
                    'type'        => 'string',
                    'required'    => true
                ],
                'expand' => [
                    'description' => 'Allow to expand some properties',
                    'location'    => 'query',
                    'type'        => 'array',
                    'required'    => false
                ]
            ]
        ],

        'getInvoiceItem' => [
            'httpMethod'       => 'GET',
            'uri'              => '/v1/invoiceitems/{id}',
            'summary'          => 'Get an existing invoice item',
            'errorResponses'   => $errors,
            'responseModel'    => 'getResponse',
            'parameters'       => [
                'id' => [
                    'description' => 'Unique identifier of the invoice item',
                    'location'    => 'uri',
                    'type'        => 'string',
                    'required'    => true
                ],
                'expand' => [
                    'description' => 'Allow to expand some properties',
                    'location'    => 'query',
                    'type'        => 'array',
                    'required'    => false
                ]
            ]
        ],

        'getInvoiceItems' => [
            'httpMethod'       => 'GET',
            'uri'              => '/v1/invoiceitems',
            'summary'          => 'Get existing invoice items',
            'errorResponses'   => $errors,
            'responseModel'    => 'getResponse',
            'parameters'       => [
                'limit' => [
                    'description' => 'Limit on how many invoice items are retrieved',
                    'location'    => 'query',
                    'type'        => 'integer',
                    'min'         => 1,
                    'max'         => 100,
                    'required'    => false
                ],
                'starting_after' => [
                    'description' => 'A cursor for use in the pagination',
                    'location'    => 'query',
                    'type'        => 'string',
                    'required'    => false
                ],
                'ending_before' => [
                    'description' => 'A cursor for use in the pagination',
                    'location'    => 'query',
                    'type'        => 'string',
                    'required'    => false
                ],
                'created' => [
                    'description' => 'A filter based on the "date" field. Can be an exact UTC timestamp, or a hash',
                    'location'    => 'query',
                    'required'    => false
                ],
                'customer' => [
                    'description' => 'Only return invoices for a specific customer',
                    'location'    => 'query',
                    'type'        => 'string',
                    'required'    => false
                ],
                'proration' => [
                    'description' => 'Only return proration item (true) or other (false)  (CAUTION: this is not explicitly documented by Stripe)',
                    'location'    => 'query',
                    'type'        => 'boolean',
                    'filters'     => ['ZfrStripe\Client\Filter\BooleanFilter::encodeValue'],
                    'required'    => false
                ],
                'expand' => [
                    'description' => 'Allow to expand some properties',
                    'location'    => 'query',
                    'type'        => 'array',
                    'required'    => false
                ],
                'include' => [
                    'description' => 'Allow to include some additional properties',
                    'location'    => 'query',
                    'type'        => 'array',
                    'required'    => false
                ]
            ]
        ],

        'updateInvoiceItem' => [
            'httpMethod'       => 'POST',
            'uri'              => '/v1/invoiceitems/{id}',
            'summary'          => 'Update an existing invoice item',
            'errorResponses'   => $errors,
            'responseModel'    => 'getResponse',
            'parameters'       => [
                'id' => [
                    'description' => 'Unique identifier of the invoice item to update',
                    'location'    => 'uri',
                    'type'        => 'string',
                    'required'    => true
                ],
                'description' => [
                    'description' => 'Optional description',
                    'location'    => 'query',
                    'type'        => 'string',
                    'required'    => false
                ],
                'metadata' => [
                    'description' => 'Optional metadata',
                    'location'    => 'query',
                    'type'        => 'array',
                    'required'    => false
                ],
                'expand' => [
                    'description' => 'Allow to expand some properties',
                    'location'    => 'query',
                    'type'        => 'array',
                    'required'    => false
                ],
                'idempotency_key' => [
                    'description' => 'An indempotency key that prevents accidentally performing the same POST operation twice',
                    'location'    => 'header',
                    'sentAs'      => 'Idempotency-Key',
                    'type'        => 'string',
                    'required'    => false
                ]
            ]
        ],

        /**
         * --------------------------------------------------------------------------------
         * DISPUTE RELATED METHODS
         *
         * DOC: https://stripe.com/docs/api#disputes
         * --------------------------------------------------------------------------------
         */

        'closeDispute' => [
            'httpMethod'       => 'POST',
            'uri'              => '/v1/charges/{charge}/dispute/close',
            'summary'          => 'Close a dispute',
            'errorResponses'   => $errors,
            'responseModel'    => 'getResponse',
            'parameters'       => [
                'charge' => [
                    'description' => 'ID of the charge to close the dispute',
                    'location'    => 'uri',
                    'type'        => 'string',
                    'required'    => true
                ],
                'expand' => [
                    'description' => 'Allow to expand some properties',
                    'location'    => 'query',
                    'type'        => 'array',
                    'required'    => false
                ],
                'idempotency_key' => [
                    'description' => 'An indempotency key that prevents accidentally performing the same POST operation twice',
                    'location'    => 'header',
                    'sentAs'      => 'Idempotency-Key',
                    'type'        => 'string',
                    'required'    => false
                ]
            ]
        ],

        'updateDispute' => [
            'httpMethod'       => 'POST',
            'uri'              => '/v1/charges/{charge}/dispute',
            'summary'          => 'Update a dispute',
            'errorResponses'   => $errors,
            'responseModel'    => 'getResponse',
            'parameters'       => [
                'charge' => [
                    'description' => 'ID of the charge to update the dispute',
                    'location'    => 'uri',
                    'type'        => 'string',
                    'required'    => true
                ],
                'evidence' => [
                    'description' => 'Evidence hash',
                    'location'    => 'query',
                    'type'        => 'array',
                    'required'    => false
                ],
                'metadata' => [
                    'description' => 'Optional metadata',
                    'location'    => 'query',
                    'type'        => 'array',
                    'required'    => false
                ],
                'expand' => [
                    'description' => 'Allow to expand some properties',
                    'location'    => 'query',
                    'type'        => 'array',
                    'required'    => false
                ],
                'idempotency_key' => [
                    'description' => 'An indempotency key that prevents accidentally performing the same POST operation twice',
                    'location'    => 'header',
                    'sentAs'      => 'Idempotency-Key',
                    'type'        => 'string',
                    'required'    => false
                ]
            ]
        ],

        /**
         * --------------------------------------------------------------------------------
         * TRANSFER RELATED METHODS
         *
         * DOC: https://stripe.com/docs/api#transfers
         * --------------------------------------------------------------------------------
         */

        'cancelTransfer' => [
            'httpMethod'       => 'POST',
            'uri'              => '/v1/transfers/{id}/cancel',
            'summary'          => 'Cancel an existing transfer',
            'errorResponses'   => $errors,
            'responseModel'    => 'getResponse',
            'parameters'       => [
                'id' => [
                    'description' => 'Unique identifier of the transfer',
                    'location'    => 'uri',
                    'type'        => 'string',
                    'required'    => true
                ],
                'expand' => [
                    'description' => 'Allow to expand some properties',
                    'location'    => 'query',
                    'type'        => 'array',
                    'required'    => false
                ],
                'idempotency_key' => [
                    'description' => 'An indempotency key that prevents accidentally performing the same POST operation twice',
                    'location'    => 'header',
                    'sentAs'      => 'Idempotency-Key',
                    'type'        => 'string',
                    'required'    => false
                ]
            ]
        ],

        'createTransfer' => [
            'httpMethod'       => 'POST',
            'uri'              => '/v1/transfers',
            'summary'          => 'Create a new transfer',
            'errorResponses'   => $errors,
            'responseModel'    => 'getResponse',
            'parameters'       => [
                'amount' => [
                    'description' => 'Amount (in cents)',
                    'location'    => 'query',
                    'type'        => 'integer',
                    'required'    => true
                ],
                'currency' => [
                    'description' => '3-letter ISO code for currency',
                    'location'    => 'query',
                    'type'        => 'string',
                    'required'    => true
                ],
                'recipient' => [
                    'description' => 'ID of an existing, verified recipient',
                    'location'    => 'query',
                    'type'        => 'string',
                    'required'    => true
                ],
                'description' => [
                    'description' => 'Optional description to add',
                    'location'    => 'query',
                    'type'        => 'string',
                    'required'    => false
                ],
                'statement_description' => [
                    'description' => 'An arbitrary string which will be displayed on the recipient\'s bank statement',
                    'location'    => 'query',
                    'type'        => 'string',
                    'required'    => false
                ],
                'metadata' => [
                    'description' => 'Optional metadata',
                    'location'    => 'query',
                    'type'        => 'array',
                    'required'    => false
                ],
                'expand' => [
                    'description' => 'Allow to expand some properties',
                    'location'    => 'query',
                    'type'        => 'array',
                    'required'    => false
                ],
                'idempotency_key' => [
                    'description' => 'An indempotency key that prevents accidentally performing the same POST operation twice',
                    'location'    => 'header',
                    'sentAs'      => 'Idempotency-Key',
                    'type'        => 'string',
                    'required'    => false
                ]
            ]
        ],

        'getTransfer' => [
            'httpMethod'       => 'GET',
            'uri'              => '/v1/transfers/{id}',
            'summary'          => 'Get an existing transfer',
            'errorResponses'   => $errors,
            'responseModel'    => 'getResponse',
            'parameters'       => [
                'id' => [
                    'description' => 'Unique identifier of the transfer',
                    'location'    => 'uri',
                    'type'        => 'string',
                    'required'    => true
                ],
                'expand' => [
                    'description' => 'Allow to expand some properties',
                    'location'    => 'query',
                    'type'        => 'array',
                    'required'    => false
                ]
            ]
        ],

        'getTransfers' => [
            'httpMethod'       => 'GET',
            'uri'              => '/v1/transfers',
            'summary'          => 'Get existing transfers',
            'errorResponses'   => $errors,
            'responseModel'    => 'getResponse',
            'parameters'       => [
                'limit' => [
                    'description' => 'Limit on how many transfers are retrieved',
                    'location'    => 'query',
                    'type'        => 'integer',
                    'min'         => 1,
                    'max'         => 100,
                    'required'    => false
                ],
                'starting_after' => [
                    'description' => 'A cursor for use in the pagination',
                    'location'    => 'query',
                    'type'        => 'string',
                    'required'    => false
                ],
                'ending_before' => [
                    'description' => 'A cursor for use in the pagination',
                    'location'    => 'query',
                    'type'        => 'string',
                    'required'    => false
                ],
                'date' => [
                    'description' => 'A filter based on the "date" field. Can be an exact UTC timestamp, or a hash',
                    'location'    => 'query',
                    'required'    => false
                ],
                'recipient' => [
                    'description' => 'Only return transfers for a specific recipient',
                    'location'    => 'query',
                    'type'        => 'string',
                    'required'    => false
                ],
                'status' => [
                    'description' => 'Optionally filter by status',
                    'location'    => 'query',
                    'type'        => 'string',
                    'required'    => false,
                    'enum'        => ['pending', 'paid', 'failed']
                ],
                'expand' => [
                    'description' => 'Allow to expand some properties',
                    'location'    => 'query',
                    'type'        => 'array',
                    'required'    => false
                ],
                'include' => [
                    'description' => 'Allow to include some additional properties',
                    'location'    => 'query',
                    'type'        => 'array',
                    'required'    => false
                ]
            ]
        ],

        'updateTransfer' => [
            'httpMethod'       => 'POST',
            'uri'              => '/v1/transfers/{id}',
            'summary'          => 'Update an existing transfer',
            'errorResponses'   => $errors,
            'responseModel'    => 'getResponse',
            'parameters'       => [
                'id' => [
                    'description' => 'Unique identifier of the transfer to update',
                    'location'    => 'uri',
                    'type'        => 'string',
                    'required'    => true
                ],
                'description' => [
                    'description' => 'Optional description',
                    'location'    => 'query',
                    'type'        => 'string',
                    'required'    => false
                ],
                'metadata' => [
                    'description' => 'Optional metadata',
                    'location'    => 'query',
                    'type'        => 'array',
                    'required'    => false
                ],
                'expand' => [
                    'description' => 'Allow to expand some properties',
                    'location'    => 'query',
                    'type'        => 'array',
                    'required'    => false
                ],
                'idempotency_key' => [
                    'description' => 'An indempotency key that prevents accidentally performing the same POST operation twice',
                    'location'    => 'header',
                    'sentAs'      => 'Idempotency-Key',
                    'type'        => 'string',
                    'required'    => false
                ]
            ]
        ],

        /**
         * --------------------------------------------------------------------------------
         * RECIPIENT RELATED METHODS
         *
         * DOC: https://stripe.com/docs/api#recipients
         * --------------------------------------------------------------------------------
         */

        'createRecipient' => [
            'httpMethod'       => 'POST',
            'uri'              => '/v1/recipients',
            'summary'          => 'Create a new recipient',
            'errorResponses'   => $errors,
            'responseModel'    => 'getResponse',
            'parameters'       => [
                'name' => [
                    'description' => 'The recipient\'s full, legal name',
                    'location'    => 'query',
                    'type'        => 'string',
                    'required'    => true
                ],
                'type' => [
                    'description' => 'Type of the recipient (can be "individual" or "corporation")',
                    'location'    => 'query',
                    'type'        => 'string',
                    'required'    => true,
                    'enum'        => ['individual', 'corporation']
                ],
                'tax_id' => [
                    'description' => 'The recipient\'s tax ID, as a string',
                    'location'    => 'query',
                    'type'        => 'string',
                    'required'    => false
                ],
                'bank_account' => [
                    'description' => 'A bank account to attach to the recipient',
                    'location'    => 'query',
                    'type'        => 'array',
                    'required'    => false
                ],
                'email' => [
                    'description' => 'The recipient\'s email address',
                    'location'    => 'query',
                    'type'        => 'string',
                    'required'    => false
                ],
                'description' => [
                    'description' => 'Optional description to add',
                    'location'    => 'query',
                    'type'        => 'integer',
                    'required'    => false
                ],
                'metadata' => [
                    'description' => 'Optional metadata',
                    'location'    => 'query',
                    'type'        => 'array',
                    'required'    => false
                ],
                'expand' => [
                    'description' => 'Allow to expand some properties',
                    'location'    => 'query',
                    'type'        => 'array',
                    'required'    => false
                ],
                'idempotency_key' => [
                    'description' => 'An indempotency key that prevents accidentally performing the same POST operation twice',
                    'location'    => 'header',
                    'sentAs'      => 'Idempotency-Key',
                    'type'        => 'string',
                    'required'    => false
                ]
            ]
        ],

        'deleteRecipient' => [
            'httpMethod'       => 'DELETE',
            'uri'              => '/v1/recipients/{id}',
            'summary'          => 'Delete an existing recipient',
            'errorResponses'   => $errors,
            'responseModel'    => 'getResponse',
            'parameters'       => [
                'id' => [
                    'description' => 'Unique identifier of the recipient',
                    'location'    => 'uri',
                    'type'        => 'string',
                    'required'    => true
                ],
                'expand' => [
                    'description' => 'Allow to expand some properties',
                    'location'    => 'query',
                    'type'        => 'array',
                    'required'    => false
                ]
            ]
        ],

        'getRecipient' => [
            'httpMethod'       => 'GET',
            'uri'              => '/v1/recipients/{id}',
            'summary'          => 'Get an existing recipient',
            'errorResponses'   => $errors,
            'responseModel'    => 'getResponse',
            'parameters'       => [
                'id' => [
                    'description' => 'Unique identifier of the recipient',
                    'location'    => 'uri',
                    'type'        => 'string',
                    'required'    => true
                ],
                'expand' => [
                    'description' => 'Allow to expand some properties',
                    'location'    => 'query',
                    'type'        => 'array',
                    'required'    => false
                ]
            ]
        ],

        'getRecipients' => [
            'httpMethod'       => 'GET',
            'uri'              => '/v1/recipients',
            'summary'          => 'Get existing recipients',
            'errorResponses'   => $errors,
            'responseModel'    => 'getResponse',
            'parameters'       => [
                'limit' => [
                    'description' => 'Limit on how many recipients are retrieved',
                    'location'    => 'query',
                    'type'        => 'integer',
                    'min'         => 1,
                    'max'         => 100,
                    'required'    => false
                ],
                'starting_after' => [
                    'description' => 'A cursor for use in the pagination',
                    'location'    => 'query',
                    'type'        => 'string',
                    'required'    => false
                ],
                'ending_before' => [
                    'description' => 'A cursor for use in the pagination',
                    'location'    => 'query',
                    'type'        => 'string',
                    'required'    => false
                ],
                'verified' => [
                    'description' => 'Boolean to only return recipients that are verified or unverified',
                    'location'    => 'query',
                    'type'        => 'boolean',
                    'filters'     => ['ZfrStripe\Client\Filter\BooleanFilter::encodeValue'],
                    'required'    => false
                ],
                'expand' => [
                    'description' => 'Allow to expand some properties',
                    'location'    => 'query',
                    'type'        => 'array',
                    'required'    => false
                ]
            ]
        ],

        'updateRecipient' => [
            'httpMethod'       => 'POST',
            'uri'              => '/v1/recipients/{id}',
            'summary'          => 'Update an existing recipient',
            'errorResponses'   => $errors,
            'responseModel'    => 'getResponse',
            'parameters'       => [
                'id' => [
                    'description' => 'Unique identifier of the recipient to update',
                    'location'    => 'uri',
                    'type'        => 'string',
                    'required'    => true
                ],
                'name' => [
                    'description' => 'The recipient\'s full, legal name',
                    'location'    => 'query',
                    'type'        => 'string',
                    'required'    => false
                ],
                'tax_id' => [
                    'description' => 'The recipient\'s tax ID, as a string',
                    'location'    => 'query',
                    'type'        => 'string',
                    'required'    => false
                ],
                'bank_account' => [
                    'description' => 'A bank account to attach to the recipient',
                    'location'    => 'query',
                    'type'        => 'array',
                    'required'    => false
                ],
                'email' => [
                    'description' => 'The recipient\'s email address',
                    'location'    => 'query',
                    'type'        => 'string',
                    'required'    => false
                ],
                'description' => [
                    'description' => 'Optional description to add',
                    'location'    => 'query',
                    'type'        => 'integer',
                    'required'    => false
                ],
                'metadata' => [
                    'description' => 'Optional metadata',
                    'location'    => 'query',
                    'type'        => 'array',
                    'required'    => false
                ],
                'expand' => [
                    'description' => 'Allow to expand some properties',
                    'location'    => 'query',
                    'type'        => 'array',
                    'required'    => false
                ],
                'idempotency_key' => [
                    'description' => 'An indempotency key that prevents accidentally performing the same POST operation twice',
                    'location'    => 'header',
                    'sentAs'      => 'Idempotency-Key',
                    'type'        => 'string',
                    'required'    => false
                ]
            ]
        ],

        /**
         * --------------------------------------------------------------------------------
         * REFUND RELATED METHODS
         *
         * DOC: https://stripe.com/docs/api#refunds
         * --------------------------------------------------------------------------------
         */

        'getRefund' => [
            'httpMethod'       => 'GET',
            'uri'              => '/v1/charges/{charge}/refunds/{id}',
            'summary'          => 'Get an existing refund',
            'errorResponses'   => $errors,
            'responseModel'    => 'getResponse',
            'parameters'       => [
                'id' => [
                    'description' => 'Unique identifier of the refund',
                    'location'    => 'uri',
                    'type'        => 'string',
                    'required'    => true
                ],
                'charge' => [
                    'description' => 'Unique identifier of the charge to get the refund from',
                    'location'    => 'uri',
                    'type'        => 'string',
                    'required'    => true
                ],
                'expand' => [
                    'description' => 'Allow to expand some properties',
                    'location'    => 'query',
                    'type'        => 'array',
                    'required'    => false
                ]
            ]
        ],

        'getRefunds' => [
            'httpMethod'       => 'GET',
            'uri'              => '/v1/charges/{charge}/refunds',
            'summary'          => 'Get existing refunds for a given charge',
            'errorResponses'   => $errors,
            'responseModel'    => 'getResponse',
            'parameters'       => [
                'charge' => [
                    'description' => 'Charge to get the refunds from',
                    'location'    => 'uri',
                    'type'        => 'string',
                    'required'    => true
                ],
                'limit' => [
                    'description' => 'Limit on how many charges are retrieved',
                    'location'    => 'query',
                    'type'        => 'integer',
                    'min'         => 1,
                    'max'         => 100,
                    'required'    => false
                ],
                'starting_after' => [
                    'description' => 'A cursor for use in the pagination',
                    'location'    => 'query',
                    'type'        => 'string',
                    'required'    => false
                ],
                'ending_before' => [
                    'description' => 'A cursor for use in the pagination',
                    'location'    => 'query',
                    'type'        => 'string',
                    'required'    => false
                ],
                'expand' => [
                    'description' => 'Allow to expand some properties',
                    'location'    => 'query',
                    'type'        => 'array',
                    'required'    => false
                ],
                'include' => [
                    'description' => 'Allow to include some additional properties',
                    'location'    => 'query',
                    'type'        => 'array',
                    'required'    => false
                ]
            ]
        ],

        'updateRefund' => [
            'httpMethod'       => 'POST',
            'uri'              => '/v1/charges/{charge}/refunds/{id}',
            'summary'          => 'Update an existing charge',
            'errorResponses'   => $errors,
            'responseModel'    => 'getResponse',
            'parameters'       => [
                'id' => [
                    'description' => 'Unique identifier of the refund to update',
                    'location'    => 'uri',
                    'type'        => 'string',
                    'required'    => true
                ],
                'charge' => [
                    'description' => 'Charge to get the refunds from',
                    'location'    => 'uri',
                    'type'        => 'string',
                    'required'    => true
                ],
                'metadata' => [
                    'description' => 'Optional metadata',
                    'location'    => 'query',
                    'type'        => 'array',
                    'required'    => false
                ],
                'expand' => [
                    'description' => 'Allow to expand some properties',
                    'location'    => 'query',
                    'type'        => 'array',
                    'required'    => false
                ],
                'idempotency_key' => [
                    'description' => 'An indempotency key that prevents accidentally performing the same POST operation twice',
                    'location'    => 'header',
                    'sentAs'      => 'Idempotency-Key',
                    'type'        => 'string',
                    'required'    => false
                ]
            ]
        ],

        /**
         * --------------------------------------------------------------------------------
         * APPLICATION FEE RELATED METHODS
         *
         * DOC: https://stripe.com/docs/api#application_fees
         * --------------------------------------------------------------------------------
         */

        'getApplicationFee' => [
            'httpMethod'       => 'GET',
            'uri'              => '/v1/application_fees/{id}',
            'summary'          => 'Get details about an application fee that your account has collected',
            'errorResponses'   => $errors,
            'responseModel'    => 'getResponse',
            'parameters'       => [
                'id' => [
                    'description' => 'Unique identifier of the application fee',
                    'location'    => 'uri',
                    'type'        => 'string',
                    'required'    => true
                ],
                'expand' => [
                    'description' => 'Allow to expand some properties',
                    'location'    => 'query',
                    'type'        => 'array',
                    'required'    => false
                ]
            ]
        ],

        'getApplicationFees' => [
            'httpMethod'       => 'GET',
            'uri'              => '/v1/application_fees',
            'summary'          => 'Get details about all application fees that your account has collected',
            'errorResponses'   => $errors,
            'responseModel'    => 'getResponse',
            'parameters'       => [
                'limit' => [
                    'description' => 'Limit on how many application fees are retrieved',
                    'location'    => 'query',
                    'type'        => 'integer',
                    'min'         => 1,
                    'max'         => 100,
                    'required'    => false
                ],
                'starting_after' => [
                    'description' => 'A cursor for use in the pagination',
                    'location'    => 'query',
                    'type'        => 'string',
                    'required'    => false
                ],
                'ending_before' => [
                    'description' => 'A cursor for use in the pagination',
                    'location'    => 'query',
                    'type'        => 'string',
                    'required'    => false
                ],
                'created' => [
                    'description' => 'A filter based on the "created" field. Can be an exact UTC timestamp, or a hash',
                    'location'    => 'query',
                    'type'        => ['string', 'array'],
                    'required'    => false
                ],
                'charge' => [
                    'description' => 'Only return application fees for a given charge',
                    'location'    => 'query',
                    'type'        => 'string',
                    'required'    => false
                ],
                'expand' => [
                    'description' => 'Allow to expand some properties',
                    'location'    => 'query',
                    'type'        => 'array',
                    'required'    => false
                ],
                'include' => [
                    'description' => 'Allow to include some additional properties',
                    'location'    => 'query',
                    'type'        => 'array',
                    'required'    => false
                ]
            ]
        ],

        'refundApplicationFee' => [
            'httpMethod'       => 'POST',
            'uri'              => '/v1/application_fees/{id}/refunds',
            'summary'          => 'Refund an application fee that has previously been collected but not yet refunded',
            'errorResponses'   => $errors,
            'responseModel'    => 'getResponse',
            'parameters'       => [
                'id' => [
                    'description' => 'Unique identifier of application fee to be refunded',
                    'location'    => 'uri',
                    'type'        => 'string',
                    'required'    => true
                ],
                'amount' => [
                    'description' => 'A positive integer in cents representing how many of this fee to refund',
                    'location'    => 'query',
                    'type'        => 'integer',
                    'required'    => false
                ],
                'expand' => [
                    'description' => 'Allow to expand some properties',
                    'location'    => 'query',
                    'type'        => 'array',
                    'required'    => false
                ],
                'idempotency_key' => [
                    'description' => 'An indempotency key that prevents accidentally performing the same POST operation twice',
                    'location'    => 'header',
                    'sentAs'      => 'Idempotency-Key',
                    'type'        => 'string',
                    'required'    => false
                ]
            ]
        ],

        /**
         * --------------------------------------------------------------------------------
         * APPLICATION FEE REFUND RELATED METHODS
         *
         * DOC: https://stripe.com/docs/api#fee_refunds
         * --------------------------------------------------------------------------------
         */

        'getApplicationFeeRefund' => [
            'httpMethod'       => 'GET',
            'uri'              => '/v1/application_fees/{fee}/refunds/{id}',
            'summary'          => 'Get details about an application fee refund',
            'errorResponses'   => $errors,
            'responseModel'    => 'getResponse',
            'parameters'       => [
                'id' => [
                    'description' => 'Unique identifier of the application fee refund',
                    'location'    => 'uri',
                    'type'        => 'string',
                    'required'    => true
                ],
                'fee' => [
                    'description' => 'Unique identifier of the application fee that was refunded',
                    'location'    => 'uri',
                    'type'        => 'string',
                    'required'    => true
                ],
                'expand' => [
                    'description' => 'Allow to expand some properties',
                    'location'    => 'query',
                    'type'        => 'array',
                    'required'    => false
                ]
            ]
        ],

        'getApplicationFeeRefunds' => [
            'httpMethod'       => 'GET',
            'uri'              => '/v1/application_fees/{fee}/refunds',
            'summary'          => 'Get details about all application fee refunds',
            'errorResponses'   => $errors,
            'responseModel'    => 'getResponse',
            'parameters'       => [
                'fee' => [
                    'description' => 'Unique identifier of the application fee we want refunds',
                    'location'    => 'uri',
                    'type'        => 'string',
                    'required'    => true
                ],
                'limit' => [
                    'description' => 'Limit on how many application fee refunds are retrieved',
                    'location'    => 'query',
                    'type'        => 'integer',
                    'min'         => 1,
                    'max'         => 100,
                    'required'    => false
                ],
                'starting_after' => [
                    'description' => 'A cursor for use in the pagination',
                    'location'    => 'query',
                    'type'        => 'string',
                    'required'    => false
                ],
                'ending_before' => [
                    'description' => 'A cursor for use in the pagination',
                    'location'    => 'query',
                    'type'        => 'string',
                    'required'    => false
                ],
                'expand' => [
                    'description' => 'Allow to expand some properties',
                    'location'    => 'query',
                    'type'        => 'array',
                    'required'    => false
                ],
                'include' => [
                    'description' => 'Allow to include some additional properties',
                    'location'    => 'query',
                    'type'        => 'array',
                    'required'    => false
                ]
            ]
        ],

        'updateApplicationFeeRefund' => [
            'httpMethod'       => 'POST',
            'uri'              => '/v1/application_fees/{fee}/refunds/{id}',
            'summary'          => 'Update an application fee refund',
            'errorResponses'   => $errors,
            'responseModel'    => 'getResponse',
            'parameters'       => [
                'id' => [
                    'description' => 'Unique identifier of application fee refund',
                    'location'    => 'uri',
                    'type'        => 'string',
                    'required'    => true
                ],
                'fee' => [
                    'description' => 'Unique identifier of the application fee refund to update',
                    'location'    => 'uri',
                    'type'        => 'string',
                    'required'    => true
                ],
                'metadata' => [
                    'description' => 'Optional metadata',
                    'location'    => 'query',
                    'type'        => 'array',
                    'required'    => false
                ],
                'expand' => [
                    'description' => 'Allow to expand some properties',
                    'location'    => 'query',
                    'type'        => 'array',
                    'required'    => false
                ],
                'idempotency_key' => [
                    'description' => 'An indempotency key that prevents accidentally performing the same POST operation twice',
                    'location'    => 'header',
                    'sentAs'      => 'Idempotency-Key',
                    'type'        => 'string',
                    'required'    => false
                ]
            ]
        ],

        /**
         * --------------------------------------------------------------------------------
         * BALANCE RELATED METHODS
         *
         * DOC: https://stripe.com/docs/api#balance
         * --------------------------------------------------------------------------------
         */

        'getAccountBalance' => [
            'httpMethod'       => 'GET',
            'uri'              => '/v1/balance',
            'summary'          => 'Get the current account balance',
            'errorResponses'   => $errors,
            'responseModel'    => 'getResponse',
            'parameters'       => [
                'expand' => [
                    'description' => 'Allow to expand some properties',
                    'location'    => 'query',
                    'type'        => 'array',
                    'required'    => false
                ]
            ]
        ],

        'getBalanceTransaction' => [
            'httpMethod'       => 'GET',
            'uri'              => '/v1/balance/history/{id}',
            'summary'          => 'Get an existing balance transaction by its id',
            'errorResponses'   => $errors,
            'responseModel'    => 'getResponse',
            'parameters'       => [
                'id' => [
                    'description' => 'Unique identifier of the balance transaction to get',
                    'location'    => 'uri',
                    'type'        => 'string',
                    'required'    => true
                ],
                'expand' => [
                    'description' => 'Allow to expand some properties',
                    'location'    => 'query',
                    'type'        => 'array',
                    'required'    => false
                ]
            ]
        ],

        'getBalanceTransactions' => [
            'httpMethod'       => 'GET',
            'uri'              => '/v1/balance/history',
            'summary'          => 'Get all the balance transactions',
            'errorResponses'   => $errors,
            'responseModel'    => 'getResponse',
            'parameters'       => [
                'limit' => [
                    'description' => 'Limit on how many application fees are retrieved',
                    'location'    => 'query',
                    'type'        => 'integer',
                    'min'         => 1,
                    'max'         => 100,
                    'required'    => false
                ],
                'starting_after' => [
                    'description' => 'A cursor for use in the pagination',
                    'location'    => 'query',
                    'type'        => 'string',
                    'required'    => false
                ],
                'ending_before' => [
                    'description' => 'A cursor for use in the pagination',
                    'location'    => 'query',
                    'type'        => 'string',
                    'required'    => false
                ],
                'available_on' => [
                    'description' => 'A filter based on the "available_on" field. Can be an exact UTC timestamp, or a hash',
                    'location'    => 'query',
                    'type'        => ['string', 'array'],
                    'required'    => false
                ],
                'created' => [
                    'description' => 'A filter based on the "created" field. Can be an exact UTC timestamp, or a hash',
                    'location'    => 'query',
                    'type'        => ['string', 'array'],
                    'required'    => false
                ],
                'currency' => [
                    'description' => 'Filter for currency',
                    'location'    => 'query',
                    'type'        => 'string',
                    'required'    => false
                ],
                'source' => [
                    'description' => 'Filter balance transactions using a specific source id (for example a charge id)',
                    'location'    => 'query',
                    'type'        => 'string',
                    'required'    => false
                ],
                'transfer' => [
                    'description' => 'For automatic Stripe transfers only, only returns transactions that were transferred out on the specified transfer ID',
                    'location'    => 'query',
                    'type'        => 'string',
                    'required'    => false
                ],
                'type' => [
                    'description' => 'Only returns transactions of the given type',
                    'location'    => 'query',
                    'type'        => 'string',
                    'required'    => false,
                    'enum'        => [
                        'adjustment', 'application_fee', 'charge', 'fee_refund', 'refund', 'transfer', 'transfer_failure'
                    ]
                ],
                'expand' => [
                    'description' => 'Allow to expand some properties',
                    'location'    => 'query',
                    'type'        => 'array',
                    'required'    => false
                ],
                'include' => [
                    'description' => 'Allow to include some additional properties',
                    'location'    => 'query',
                    'type'        => 'array',
                    'required'    => false
                ]
            ]
        ],

        /**
         * --------------------------------------------------------------------------------
         * TOKEN RELATED METHODS
         *
         * DOC: https://stripe.com/docs/api#tokens
         * --------------------------------------------------------------------------------
         */

        'createCardToken' => [
            'httpMethod'       => 'POST',
            'uri'              => '/v1/tokens',
            'summary'          => 'Create a new card token (note you must either specify card OR customer but not both)',
            'errorResponses'   => $errors,
            'responseModel'    => 'getResponse',
            'parameters'       => [
                'card' => [
                    'description' => 'Unique card identifier (can either be an ID or a hash)',
                    'location'    => 'query',
                    'type'        => ['string', 'array'],
                    'required'    => false
                ],
                'customer' => [
                    'description' => 'A customer (owned by the application\'s account) to create a token for',
                    'location'    => 'query',
                    'type'        => 'string',
                    'required'    => false
                ],
                'expand' => [
                    'description' => 'Allow to expand some properties',
                    'location'    => 'query',
                    'type'        => 'array',
                    'required'    => false
                ],
                'idempotency_key' => [
                    'description' => 'An indempotency key that prevents accidentally performing the same POST operation twice',
                    'location'    => 'header',
                    'sentAs'      => 'Idempotency-Key',
                    'type'        => 'string',
                    'required'    => false
                ]
            ]
        ],

        'createBankAccountToken' => [
            'httpMethod'       => 'POST',
            'uri'              => '/v1/tokens',
            'summary'          => 'Create a bank account token',
            'errorResponses'   => $errors,
            'responseModel'    => 'getResponse',
            'parameters'       => [
                'bank_account' => [
                    'description' => 'A bank account to attach to the recipient',
                    'location'    => 'query',
                    'type'        => 'array',
                    'required'    => false
                ],
                'expand' => [
                    'description' => 'Allow to expand some properties',
                    'location'    => 'query',
                    'type'        => 'array',
                    'required'    => false
                ],
                'idempotency_key' => [
                    'description' => 'An indempotency key that prevents accidentally performing the same POST operation twice',
                    'location'    => 'header',
                    'sentAs'      => 'Idempotency-Key',
                    'type'        => 'string',
                    'required'    => false
                ]
            ]
        ],

        'getToken' => [
            'httpMethod'       => 'GET',
            'uri'              => '/v1/tokens/{id}',
            'summary'          => 'Get details about an existing token',
            'errorResponses'   => $errors,
            'responseModel'    => 'getResponse',
            'parameters'       => [
                'id' => [
                    'description' => 'Unique identifier of the token',
                    'location'    => 'uri',
                    'type'        => 'string',
                    'required'    => true
                ],
                'expand' => [
                    'description' => 'Allow to expand some properties',
                    'location'    => 'query',
                    'type'        => 'array',
                    'required'    => false
                ]
            ]
        ],

        /**
         * --------------------------------------------------------------------------------
         * EVENT RELATED METHODS
         *
         * DOC: https://stripe.com/docs/api#events
         * --------------------------------------------------------------------------------
         */

        'getEvent' => [
            'httpMethod'       => 'GET',
            'uri'              => '/v1/events/{id}',
            'summary'          => 'Get details about an event',
            'errorResponses'   => $errors,
            'responseModel'    => 'getResponse',
            'parameters'       => [
                'id' => [
                    'description' => 'Unique identifier of the event',
                    'location'    => 'uri',
                    'type'        => 'string',
                    'required'    => true
                ],
                'expand' => [
                    'description' => 'Allow to expand some properties',
                    'location'    => 'query',
                    'type'        => 'array',
                    'required'    => false
                ]
            ]
        ],

        'getEvents' => [
            'httpMethod'       => 'GET',
            'uri'              => '/v1/events',
            'summary'          => 'Get details about all events (up to 30 days)',
            'errorResponses'   => $errors,
            'responseModel'    => 'getResponse',
            'parameters'       => [
                'limit' => [
                    'description' => 'Limit on how many events are retrieved',
                    'location'    => 'query',
                    'type'        => 'integer',
                    'min'         => 1,
                    'max'         => 100,
                    'required'    => false
                ],
                'starting_after' => [
                    'description' => 'A cursor for use in the pagination',
                    'location'    => 'query',
                    'type'        => 'string',
                    'required'    => false
                ],
                'ending_before' => [
                    'description' => 'A cursor for use in the pagination',
                    'location'    => 'query',
                    'type'        => 'string',
                    'required'    => false
                ],
                'created' => [
                    'description' => 'A filter based on the "created" field. Can be an exact UTC timestamp, or a hash',
                    'location'    => 'query',
                    'type'        => ['string', 'array'],
                    'required'    => false
                ],
                'type' => [
                    'description' => 'Allow to filter events by type',
                    'location'    => 'query',
                    'type'        => 'string',
                    'required'    => false
                ],
                'object_id' => [
                    'description' => 'Allow to filter by customer (CAUTION: this is not explicitly documented by Stripe)',
                    'location'    => 'query',
                    'type'        => 'string',
                    'required'    => false
                ],
                'expand' => [
                    'description' => 'Allow to expand some properties',
                    'location'    => 'query',
                    'type'        => 'array',
                    'required'    => false
                ],
                'include' => [
                    'description' => 'Allow to include some additional properties',
                    'location'    => 'query',
                    'type'        => 'array',
                    'required'    => false
                ]
            ]
        ],

        /**
         * --------------------------------------------------------------------------------
         * ACCOUNT RELATED METHODS
         *
         * DOC: https://stripe.com/docs/api#account
         * --------------------------------------------------------------------------------
         */

        'getAccount' => [
            'httpMethod'       => 'GET',
            'uri'              => '/v1/account',
            'summary'          => 'Get details about the account',
            'errorResponses'   => $errors,
            'responseModel'    => 'getResponse'
        ]
    ],
    'models' => [
        'getResponse' => [
            'type' => 'object',
            'additionalProperties' => [
                'location' => 'json'
            ]
        ]
    ]
];
