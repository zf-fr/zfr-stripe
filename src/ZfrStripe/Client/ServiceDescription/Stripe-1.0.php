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
            'summary'          => 'Get an existing charge',
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
        )
    )
);
