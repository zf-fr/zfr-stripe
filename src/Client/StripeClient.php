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

namespace ZfrStripe\Client;

use GuzzleHttp\Client;
use GuzzleHttp\Command\Guzzle\Description;
use GuzzleHttp\Command\Guzzle\GuzzleClient;
use GuzzleHttp\Event\BeforeEvent;
use GuzzleHttp\Query;
use ZfrStripe\Client\Iterator\StripeCommandsCursorIterator;
use ZfrStripe\Exception\UnsupportedStripeVersionException;

/**
 * @author  Michaël Gallego <mic.gallego@gmail.com>
 * @licence MIT
 *
 * CHARGE RELATED METHODS:
 *
 * @method array captureCharge(array $args = array()) {@command Stripe captureCharge}
 * @method array createCharge(array $args = array()) {@command Stripe createCharge}
 * @method array getCharge(array $args = array()) {@command Stripe getCharge}
 * @method array getCharges(array $args = array()) {@command Stripe getCharges}
 * @method array refundCharge(array $args = array()) {@command Stripe refundCharge}
 * @method array updateCharge(array $args = array()) {@command Stripe updateCharge}
 *
 * CUSTOMER RELATED METHODS:
 *
 * @method array createCustomer(array $args = array()) {@command Stripe createCustomer}
 * @method array deleteCustomer(array $args = array()) {@command Stripe deleteCustomer}
 * @method array getCustomer(array $args = array()) {@command Stripe getCustomer}
 * @method array getCustomers(array $args = array()) {@command Stripe getCustomers}
 * @method array updateCustomer(array $args = array()) {@command Stripe updateCustomer}
 *
 * CARD RELATED METHODS:
 *
 * @method array createCard(array $args = array()) {@command Stripe createCard}
 * @method array deleteCard(array $args = array()) {@command Stripe deleteCard}
 * @method array getCard(array $args = array()) {@command Stripe getCard}
 * @method array getCards(array $args = array()) {@command Stripe getCards}
 * @method array updateCard(array $args = array()) {@command Stripe updateCard}
 *
 * RECIPIENT CARD RELATED METHODS:
 *
 * @method array createRecipientCard(array $args = array()) {@command Stripe createRecipientCard}
 * @method array deleteRecipientCard(array $args = array()) {@command Stripe deleteRecipientCard}
 * @method array getRecipientCard(array $args = array()) {@command Stripe getRecipientCard}
 * @method array getRecipientCards(array $args = array()) {@command Stripe getRecipientCards}
 * @method array updateRecipientCard(array $args = array()) {@command Stripe updateRecipientCard}
 *
 * SUBSCRIPTION RELATED METHODS:
 *
 * @method array cancelSubscription(array $args = array()) {@command Stripe cancelSubscription}
 * @method array createSubscription(array $args = array()) {@command Stripe createSubscription}
 * @method array getSubscription(array $args = array()) {@command Stripe getSubscription}
 * @method array getSubscriptions(array $args = array()) {@command Stripe getSubscriptions}
 * @method array updateSubscription(array $args = array()) {@command Stripe updateSubscription}
 *
 * PLAN RELATED METHODS:
 *
 * @method array createPlan(array $args = array()) {@command Stripe createPlan}
 * @method array deletePlan(array $args = array()) {@command Stripe deletePlan}
 * @method array getPlan(array $args = array()) {@command Stripe getPlan}
 * @method array getPlans(array $args = array()) {@command Stripe getPlans}
 * @method array updatePlan(array $args = array()) {@command Stripe updatePlan}
 *
 * COUPON RELATED METHODS:
 *
 * @method array createCoupon(array $args = array()) {@command Stripe createCoupon}
 * @method array deleteCoupon(array $args = array()) {@command Stripe deleteCoupon}
 * @method array getCoupon(array $args = array()) {@command Stripe getCoupon}
 * @method array getCoupons(array $args = array()) {@command Stripe getCoupons}
 * @method array updateCoupon(array $args = array()) {@command Stripe updateCoupon}
 *
 * DISCOUNT RELATED METHODS:
 *
 * @method array deleteCustomerDiscount(array $args = array()) {@command Stripe deleteCustomerDiscount}
 * @method array deleteSubscriptionDiscount(array $args = array()) {@command Stripe deleteSubscriptionDiscount}
 *
 * INVOICE RELATED METHODS:
 *
 * @method array createInvoice(array $args = array()) {@command Stripe createInvoice}
 * @method array getInvoice(array $args = array()) {@command Stripe getInvoice}
 * @method array getInvoiceLineItems(array $args = array()) {@command Stripe getInvoiceLineItems}
 * @method array getInvoices(array $args = array()) {@command Stripe getInvoices}
 * @method array getUpcomingInvoice(array $args = array()) {@command Stripe getUpcomingInvoice}
 * @method array getUpcomingInvoiceLineItems(array $args = array()) {@command Stripe getUpcomingInvoiceLineItems}
 * @method array payInvoice(array $args = array()) {@command Stripe payInvoice}
 * @method array updateInvoice(array $args = array()) {@command Stripe updateInvoice}
 *
 * INVOICE ITEM RELATED METHODS:
 *
 * @method array createInvoiceItem(array $args = array()) {@command Stripe createInvoiceItem}
 * @method array deleteInvoiceItem(array $args = array()) {@command Stripe deleteInvoiceItem}
 * @method array getInvoiceItem(array $args = array()) {@command Stripe getInvoiceItem}
 * @method array getInvoiceItems(array $args = array()) {@command Stripe getInvoiceItems}
 * @method array updateInvoiceItem(array $args = array()) {@command Stripe updateInvoiceItem}
 *
 * DISPUTE RELATED METHODS:
 *
 * @method array closeDispute(array $args = array()) {@command Stripe closeDispute}
 * @method array updateDispute(array $args = array()) {@command Stripe updateDispute}
 *
 * TRANSFER RELATED METHODS:
 *
 * @method array cancelTransfer(array $args = array()) {@command Stripe cancelTransfer}
 * @method array createTransfer(array $args = array()) {@command Stripe createTransfer}
 * @method array getTransfer(array $args = array()) {@command Stripe getTransfer}
 * @method array getTransfers(array $args = array()) {@command Stripe getTransfers}
 * @method array updateTransfer(array $args = array()) {@command Stripe updateTransfer}
 *
 * RECIPIENT RELATED METHODS:
 *
 * @method array createRecipient(array $args = array()) {@command Stripe createRecipient}
 * @method array deleteRecipient(array $args = array()) {@command Stripe deleteRecipient}
 * @method array getRecipient(array $args = array()) {@command Stripe getRecipient}
 * @method array getRecipients(array $args = array()) {@command Stripe getRecipients}
 * @method array updateRecipient(array $args = array()) {@command Stripe updateRecipient}
 *
 * REFUND RELATED METHODS:
 *
 * @method array getRefund(array $args = array()) {@command Stripe getRefund}
 * @method array getRefunds(array $args = array()) {@command Stripe getRefunds}
 * @method array updateRefund(array $args = array()) {@command Stripe updateRefunds}
 *
 * APPLICATION FEE RELATED METHODS:
 *
 * @method array getApplicationFee(array $args = array()) {@command Stripe getApplicationFee}
 * @method array getApplicationFees(array $args = array()) {@command Stripe getApplicationFees}
 * @method array refundApplicationFee(array $args = array()) {@command Stripe refundApplicationFee}
 *
 * APPLICATION FEE REFUND RELATED METHODS:
 *
 * @method array getApplicationFeeRefund(array $args = array()) {@command Stripe getApplicationFeeRefund}
 * @method array getApplicationFeeRefunds(array $args = array()) {@command Stripe getApplicationFeeRefunds}
 * @method array updateApplicationFeeRefund(array $args = array()) {@command Stripe updateApplicationFeeRefund}
 *
 * BALANCE RELATED METHODS:
 *
 * @method array getAccountBalance(array $args = array()) {@command Stripe getAccountBalance}
 * @method array getBalanceTransaction(array $args = array()) {@command Stripe getBalanceTransaction}
 * @method array getBalanceTransactions(array $args = array()) {@command Stripe getBalanceTransactions}
 *
 * TOKEN RELATED METHODS:
 *
 * @method array createCardToken(array $args = array()) {@command Stripe createCardToken}
 * @method array createBankAccountToken(array $args = array()) {@command Stripe createBankAccountToken}
 * @method array getToken(array $args = array()) {@command Stripe getToken}
 *
 * EVENT RELATED METHODS:
 *
 * @method array getEvent(array $args = array()) {@command Stripe getEvent}
 * @method array getEvents(array $args = array()) {@command Stripe getEvents}
 *
 * ACCOUNT RELATED METHODS:
 *
 * @method array getAccount(array $args = array()) {@command Stripe getAccount}
 *
 * ITERATOR METHODS:
 *
 * @method StripeCommandsCursorIterator getCustomersIterator()
 * @method StripeCommandsCursorIterator getChargesIterator()
 * @method StripeCommandsCursorIterator getCardsIterator()
 * @method StripeCommandsCursorIterator getRecipientCardsIterator()
 * @method StripeCommandsCursorIterator getSubscriptionsIterator()
 * @method StripeCommandsCursorIterator getPlansIterator()
 * @method StripeCommandsCursorIterator getCouponsIterator()
 * @method StripeCommandsCursorIterator getInvoicesIterator()
 * @method StripeCommandsCursorIterator getInvoiceLineItemsIterator()
 * @method StripeCommandsCursorIterator GetUpcomingInvoiceLineItemsIterator()
 * @method StripeCommandsCursorIterator getInvoiceItemsIterator()
 * @method StripeCommandsCursorIterator getTransfersIterator()
 * @method StripeCommandsCursorIterator getRecipientsIterator()
 * @method StripeCommandsCursorIterator getRefundsIterator()
 * @method StripeCommandsCursorIterator getApplicationFeesIterator()
 * @method StripeCommandsCursorIterator getApplicationFeeRefundsIterator()
 * @method StripeCommandsCursorIterator getBalanceTransactionsIterator()
 * @method StripeCommandsCursorIterator getEventsIterator()
 */
class StripeClient
{
    /**
     * Stripe API version
     */
    const LATEST_API_VERSION = '2015-01-11';

    /**
     * @var Client
     */
    private $httpClient;

    /**
     * @var GuzzleClient
     */
    private $guzzleClient;

    /**
     * @var array
     */
    private $availableVersions = [
        '2014-03-28', '2014-05-19', '2014-06-13', '2014-06-17', '2014-07-22', '2014-07-26', '2014-08-04', '2014-08-20',
        '2014-09-08', '2014-10-07', '2014-11-05', '2014-11-20', '2014-12-08', '2014-12-17', '2014-12-22', '2015-01-11'
    ];

    /**
     * @var string
     */
    private $apiKey;

    /**
     * @var string
     */
    private $version;

    /**
     * Constructor
     *
     * @param string $apiKey
     * @param string $version
     */
    public function __construct($apiKey, $version = self::LATEST_API_VERSION)
    {
        $this->httpClient = new Client();

        $this->setApiKey($apiKey);
        $this->setApiVersion($version);

        // Attach various listeners that will prepare the request
        $emitter = $this->httpClient->getEmitter();
        $emitter->on('before', [$this, 'prepareQueryParams']);
        $emitter->on('before', [$this, 'authorizeRequest']);
    }

    /**
     * {@inheritdoc}
     */
    public function __call($name, array $arguments = [])
    {
        if (substr($name, -8) === 'Iterator') {
            // Allow magic method calls for iterators (e.g. $client-><CommandName>Iterator($params))
            $commandOptions  = isset($arguments[0]) ? $arguments[0] : [];
            $command         = $this->guzzleClient->getCommand(substr($name, 0, -8), $commandOptions);

            return new StripeCommandsCursorIterator($this->guzzleClient, $command);
        }

        return $this->guzzleClient->__call($name, $arguments);
    }

    /**
     * Override the API key
     *
     * @param  string $apiKey
     * @return void
     */
    public function setApiKey($apiKey)
    {
        $this->apiKey = (string) $apiKey;
    }

    /**
     * Get the current API key
     *
     * @return string
     */
    public function getApiKey()
    {
        return $this->apiKey;
    }

    /**
     * Set the Stripe API version
     *
     * This method forces to add a Stripe-Version header, so that you can use the wanted version no matter
     * what the setting is on Stripe
     *
     * @param  string $version
     * @return void
     */
    public function setApiVersion($version)
    {
        if (!in_array($version, $this->availableVersions, true)) {
            throw new UnsupportedStripeVersionException(sprintf(
                'The given Stripe version ("%s") is not supported by ZfrStripe. Value must be one of the following: "%s"',
                $version,
                implode(', ', $this->availableVersions)
            ));
        }

        $this->version = (string) $version;
        $this->httpClient->setDefaultOption('headers/Stripe-Version', $this->version);

        if ($this->version < '2014-12-08') {
            $description = new Description(include __DIR__ . '/ServiceDescription/Stripe-v1.0.php');
        } elseif ($this->version < '2014-12-17') {
            $description = new Description(include __DIR__ . '/ServiceDescription/Stripe-v1.1.php');
        } else {
            $description = new Description(include __DIR__ . '/ServiceDescription/Stripe-v1.2.php');
        }

        $this->guzzleClient = new GuzzleClient($this->httpClient, $description);
    }

    /**
     * Get current Stripe API version
     *
     * @return string
     */
    public function getApiVersion()
    {
        return $this->version;
    }

    /**
     * Modify the query aggregator
     *
     * @internal
     * @param  BeforeEvent $event
     * @return void
     */
    public function prepareQueryParams(BeforeEvent $event)
    {
        $event->getRequest()->getQuery()->setAggregator(Query::phpAggregator(false));
    }

    /**
     * Authorize the request
     *
     * @internal
     * @param  BeforeEvent $event
     * @return void
     */
    public function authorizeRequest(BeforeEvent $event)
    {
        $event->getRequest()->setHeader('Authorization', 'Basic ' . base64_encode($this->apiKey));
    }
}
