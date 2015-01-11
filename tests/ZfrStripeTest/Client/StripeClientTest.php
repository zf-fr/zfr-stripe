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

namespace ZfrStripeTest\Client;

use PHPUnit_Framework_TestCase;
use ZfrStripe\Client\StripeClient;

/**
 * @author  Michaël Gallego <mic.gallego@gmail.com>
 * @licence MIT
 */
class StripeClientTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var StripeClient
     */
    protected $client;

    public function setUp()
    {
        $this->client = new StripeClient('abc');
        $this->assertEquals('abc', $this->client->getApiKey());
    }

    public function testCanRetrieveApiVersion()
    {
        $this->assertInternalType('string', $this->client->getApiVersion());
    }

    public function testTriggerExceptionIfUnsupportedVersionIsSet()
    {
        $this->setExpectedException('ZfrStripe\Exception\UnsupportedStripeVersionException');

        $this->client->setApiVersion('2014-01-01');
    }

    public function testAssertApiVersionHeaderIsAdded()
    {
        $this->assertEquals($this->client->getApiVersion(), $this->client->getDefaultOption('headers/Stripe-Version'));

        // Assert it changes it if we update the version
        $this->client->setApiVersion('2014-05-19');
        $this->assertEquals('2014-05-19', $this->client->getDefaultOption('headers/Stripe-Version'));
    }
}
