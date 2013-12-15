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
use Guzzle\Service\Client;
use Guzzle\Service\Description\ServiceDescription;

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
 * SUBSCRIPTION RELATED METHODS:
 *
 * @method array cancelSubscription(array $args = array()) {@command Stripe CancelSubscription}
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
 *
 * DISCOUNT RELATED METHODS:
 *
 * @method array deleteDiscount(array $args = array()) {@command Stripe DeleteDiscount}
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
 * APPLICATION FEE RELATED METHODS:
 *
 * @method array getApplicationFee(array $args = array()) {@command Stripe GetApplicationFee}
 * @method array getApplicationFees(array $args = array()) {@command Stripe GetApplicationFees}
 * @method array refundApplicationFee(array $args = array()) {@command Stripe RefundApplicationFee}
 *
 * ACCOUNT RELATED METHODS:
 *
 * @method array getAccount(array $args = array()) {@command Stripe GetAccount}
 */
class StripeClient extends Client
{
    /**
     * Stripe API version
     */
    const LATEST_API_VERSION = '1.0';

    /**
     * @var string
     */
    protected $apiKey;

    /**
     * Constructor
     *
     * @param string $apiKey
     * @param string $version
     */
    public function __construct($apiKey, $version = self::LATEST_API_VERSION)
    {
        parent::__construct();

        $this->apiKey = $apiKey;

        $this->setDescription(ServiceDescription::factory(sprintf(
            __DIR__ . '/ServiceDescription/Stripe-%s.php',
            $version
        )));

        // Prefix the User-Agent by SDK version, and set the base URL
        $this->setUserAgent('zfr-stripe-php', true);

        // Add an event to set the Authorization param
        $dispatcher = $this->getEventDispatcher();

        $dispatcher->addListener('command.before_send', array($this, 'authorizeRequest'));
    }

    /**
     * {@inheritdoc}
     */
    public function __call($method, $args = array())
    {
        return parent::__call(ucfirst($method), $args);
    }

    /**
     * Get current MailChimp API version
     *
     * @return string
     */
    public function getApiVersion()
    {
        return $this->serviceDescription->getApiVersion();
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
