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
