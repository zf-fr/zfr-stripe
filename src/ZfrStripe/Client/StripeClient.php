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

use Guzzle\Common\Event;
use Guzzle\Plugin\ErrorResponse\ErrorResponsePlugin;
use Guzzle\Service\Client;
use Guzzle\Service\Description\ServiceDescription;
use Guzzle\Service\Resource\ResourceIterator;
use ZfrStripe\Client\Iterator\StripeCommandsCursorIterator;
use ZfrStripe\Exception\UnsupportedStripeVersionException;
use ZfrStripe\Http\QueryAggregator\StripeQueryAggregator;

/**
 * @author  Michaël Gallego <mic.gallego@gmail.com>
 * @licence MIT
 *
 * CHARGE RELATED METHODS:
 *
 * @method array captureCharge(array $args = array()) {@command Stripe CaptureCharge}
 * @method array createCharge(array $args = array()) {@command Stripe CreateCharge}
 * @method array getCharge(array $args = array()) {@command Stripe GetCharge}
 * @method array getCharges(array $args = array()) {@command Stripe GetCharges}
 * @method array refundCharge(array $args = array()) {@command Stripe RefundCharge}
 * @method array updateCharge(array $args = array()) {@command Stripe UpdateCharge}
 *
 * CUSTOMER RELATED METHODS:
 *
 * @method array createCustomer(array $args = array()) {@command Stripe CreateCustomer}
 * @method array deleteCustomer(array $args = array()) {@command Stripe DeleteCustomer}
 * @method array getCustomer(array $args = array()) {@command Stripe GetCustomer}
 * @method array getCustomers(array $args = array()) {@command Stripe GetCustomers}
 * @method array updateCustomer(array $args = array()) {@command Stripe UpdateCustomer}
 *
 * CARD RELATED METHODS:
 *
 * @method array createCard(array $args = array()) {@command Stripe CreateCard}
 * @method array deleteCard(array $args = array()) {@command Stripe DeleteCard}
 * @method array getCard(array $args = array()) {@command Stripe GetCard}
 * @method array getCards(array $args = array()) {@command Stripe GetCards}
 * @method array updateCard(array $args = array()) {@command Stripe UpdateCard}
 *
 * RECIPIENT CARD RELATED METHODS:
 *
 * @method array createRecipientCard(array $args = array()) {@command Stripe CreateRecipientCard}
 * @method array deleteRecipientCard(array $args = array()) {@command Stripe DeleteRecipientCard}
 * @method array getRecipientCard(array $args = array()) {@command Stripe GetRecipientCard}
 * @method array getRecipientCards(array $args = array()) {@command Stripe GetRecipientCards}
 * @method array updateRecipientCard(array $args = array()) {@command Stripe UpdateRecipientCard}
 *
 * SUBSCRIPTION RELATED METHODS:
 *
 * @method array cancelSubscription(array $args = array()) {@command Stripe CancelSubscription}
 * @method array createSubscription(array $args = array()) {@command Stripe CreateSubscription}
 * @method array getSubscription(array $args = array()) {@command Stripe GetSubscription}
 * @method array getSubscriptions(array $args = array()) {@command Stripe GetSubscriptions}
 * @method array updateSubscription(array $args = array()) {@command Stripe UpdateSubscription}
 *
 * PLAN RELATED METHODS:
 *
 * @method array createPlan(array $args = array()) {@command Stripe CreatePlan}
 * @method array deletePlan(array $args = array()) {@command Stripe DeletePlan}
 * @method array getPlan(array $args = array()) {@command Stripe GetPlan}
 * @method array getPlans(array $args = array()) {@command Stripe GetPlans}
 * @method array updatePlan(array $args = array()) {@command Stripe UpdatePlan}
 *
 * COUPON RELATED METHODS:
 *
 * @method array createCoupon(array $args = array()) {@command Stripe CreateCoupon}
 * @method array deleteCoupon(array $args = array()) {@command Stripe DeleteCoupon}
 * @method array getCoupon(array $args = array()) {@command Stripe GetCoupon}
 * @method array getCoupons(array $args = array()) {@command Stripe GetCoupons}
 * @method array updateCoupon(array $args = array()) {@command Stripe UpdateCoupon}
 *
 * DISCOUNT RELATED METHODS:
 *
 * @method array deleteCustomerDiscount(array $args = array()) {@command Stripe DeleteCustomerDiscount}
 * @method array deleteSubscriptionDiscount(array $args = array()) {@command Stripe DeleteSubscriptionDiscount}
 *
 * INVOICE RELATED METHODS:
 *
 * @method array createInvoice(array $args = array()) {@command Stripe CreateInvoice}
 * @method array getInvoice(array $args = array()) {@command Stripe GetInvoice}
 * @method array getInvoiceLineItems(array $args = array()) {@command Stripe GetInvoiceLineItems}
 * @method array getInvoices(array $args = array()) {@command Stripe GetInvoices}
 * @method array getUpcomingInvoice(array $args = array()) {@command Stripe GetUpcomingInvoice}
 * @method array payInvoice(array $args = array()) {@command Stripe PayInvoice}
 * @method array updateInvoice(array $args = array()) {@command Stripe UpdateInvoice}
 *
 * INVOICE ITEM RELATED METHODS:
 *
 * @method array createInvoiceItem(array $args = array()) {@command Stripe CreateInvoiceItem}
 * @method array deleteInvoiceItem(array $args = array()) {@command Stripe DeleteInvoiceItem}
 * @method array getInvoiceItem(array $args = array()) {@command Stripe GetInvoiceItem}
 * @method array getInvoiceItems(array $args = array()) {@command Stripe GetInvoiceItems}
 * @method array updateInvoiceItem(array $args = array()) {@command Stripe UpdateInvoiceItem}
 *
 * DISPUTE RELATED METHODS:
 *
 * @method array closeDispute(array $args = array()) {@command Stripe CloseDispute}
 * @method array updateDispute(array $args = array()) {@command Stripe UpdateDispute}
 *
 * TRANSFER RELATED METHODS:
 *
 * @method array cancelTransfer(array $args = array()) {@command Stripe CancelTransfer}
 * @method array createTransfer(array $args = array()) {@command Stripe CreateTransfer}
 * @method array getTransfer(array $args = array()) {@command Stripe GetTransfer}
 * @method array getTransfers(array $args = array()) {@command Stripe GetTransfers}
 * @method array updateTransfer(array $args = array()) {@command Stripe UpdateTransfer}
 *
 * RECIPIENT RELATED METHODS:
 *
 * @method array createRecipient(array $args = array()) {@command Stripe CreateRecipient}
 * @method array deleteRecipient(array $args = array()) {@command Stripe DeleteRecipient}
 * @method array getRecipient(array $args = array()) {@command Stripe GetRecipient}
 * @method array getRecipients(array $args = array()) {@command Stripe GetRecipients}
 * @method array updateRecipient(array $args = array()) {@command Stripe UpdateRecipient}
 *
 * REFUND RELATED METHODS:
 *
 * @method array getRefund(array $args = array()) {@command Stripe GetRefund}
 * @method array getRefunds(array $args = array()) {@command Stripe GetRefunds}
 * @method array updateRefund(array $args = array()) {@command Stripe UpdateRefunds}
 *
 * APPLICATION FEE RELATED METHODS:
 *
 * @method array getApplicationFee(array $args = array()) {@command Stripe GetApplicationFee}
 * @method array getApplicationFees(array $args = array()) {@command Stripe GetApplicationFees}
 * @method array refundApplicationFee(array $args = array()) {@command Stripe RefundApplicationFee}
 *
 * APPLICATION FEE REFUND RELATED METHODS:
 *
 * @method array getApplicationFeeRefund(array $args = array()) {@command Stripe GetApplicationFeeRefund}
 * @method array getApplicationFeeRefunds(array $args = array()) {@command Stripe GetApplicationFeeRefunds}
 * @method array updateApplicationFeeRefund(array $args = array()) {@command Stripe UpdateApplicationFeeRefund}
 *
 * BALANCE RELATED METHODS:
 *
 * @method array getAccountBalance(array $args = array()) {@command Stripe GetAccountBalance}
 * @method array getBalanceTransaction(array $args = array()) {@command Stripe GetBalanceTransaction}
 * @method array getBalanceTransactions(array $args = array()) {@command Stripe GetBalanceTransactions}
 *
 * TOKEN RELATED METHODS:
 *
 * @method array createCardToken(array $args = array()) {@command Stripe CreateCardToken}
 * @method array createBankAccountToken(array $args = array()) {@command Stripe CreateBankAccountToken}
 * @method array getToken(array $args = array()) {@command Stripe GetToken}
 *
 * EVENT RELATED METHODS:
 *
 * @method array getEvent(array $args = array()) {@command Stripe GetEvent}
 * @method array getEvents(array $args = array()) {@command Stripe GetEvents}
 *
 * ACCOUNT RELATED METHODS:
 *
 * @method array getAccount(array $args = array()) {@command Stripe GetAccount}
 *
 * ITERATOR METHODS:
 *
 * @method ResourceIterator getCustomersIterator()
 * @method ResourceIterator getChargesIterator()
 * @method ResourceIterator getCardsIterator()
 * @method ResourceIterator getRecipientCardsIterator()
 * @method ResourceIterator getSubscriptionsIterator()
 * @method ResourceIterator getPlansIterator()
 * @method ResourceIterator getCouponsIterator()
 * @method ResourceIterator getInvoicesIterator()
 * @method ResourceIterator getInvoiceItemsIterator()
 * @method ResourceIterator getTransfersIterator()
 * @method ResourceIterator getRecipientsIterator()
 * @method ResourceIterator getRefundsIterator()
 * @method ResourceIterator getApplicationFeesIterator()
 * @method ResourceIterator getApplicationFeeRefundsIterator()
 * @method ResourceIterator getBalanceTransactionsIterator()
 * @method ResourceIterator getEventsIterator()
 */
class StripeClient extends Client
{
    /**
     * Stripe API version
     */
    const LATEST_API_VERSION = '2014-08-20';

    /**
     * @var array
     */
    protected $availableVersions = [
        '2014-03-28', '2014-05-19', '2014-06-17', '2014-07-22', '2014-07-26', '2014-08-04', '2014-08-20'
    ];

    /**
     * @var string
     */
    protected $apiKey;

    /**
     * @var string
     */
    protected $version;

    /**
     * Constructor
     *
     * @param string $apiKey
     * @param string $version
     */
    public function __construct($apiKey, $version = self::LATEST_API_VERSION)
    {
        parent::__construct();

        $this->setApiKey($apiKey);
        $this->setApiVersion($version);

        $this->setUserAgent('zfr-stripe-php', true);

        // Add an event to set the Authorization param before sending any request
        $dispatcher = $this->getEventDispatcher();

        $dispatcher->addSubscriber(new ErrorResponsePlugin());
        $dispatcher->addListener('command.after_prepare', [$this, 'afterPrepare']);
        $dispatcher->addListener('command.before_send', [$this, 'authorizeRequest']);
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
     * {@inheritdoc}
     */
    public function __call($method, $args = [])
    {
        if (substr($method, -8) === 'Iterator') {
            // Allow magic method calls for iterators (e.g. $client-><CommandName>Iterator($params))
            $commandOptions  = isset($args[0]) ? $args[0] : [];
            $iteratorOptions = isset($args[1]) ? $args[1] : [];
            $command         = $this->getCommand(substr($method, 0, -8), $commandOptions);

            return new StripeCommandsCursorIterator($command, $iteratorOptions);
        }

        return parent::__call(ucfirst($method), $args);
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
        $this->setDefaultOption('headers', ['Stripe-Version' => (string) $this->version]);

        $this->setDescription(ServiceDescription::factory(sprintf(
            __DIR__ . '/ServiceDescription/Stripe-v1.0.php'
        )));
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
     * @param  Event $event
     * @return void
     */
    public function afterPrepare(Event $event)
    {
        /* @var \Guzzle\Service\Command\CommandInterface $command */
        $command = $event['command'];
        $request = $command->getRequest();

        $request->getQuery()->setAggregator(new StripeQueryAggregator());
    }

    /**
     * Authorize the request
     *
     * @internal
     * @param  Event $event
     * @return void
     */
    public function authorizeRequest(Event $event)
    {
        /* @var \Guzzle\Service\Command\CommandInterface $command */
        $command = $event['command'];

        $request = $command->getRequest();
        $request->setAuth($this->apiKey);
    }
}
