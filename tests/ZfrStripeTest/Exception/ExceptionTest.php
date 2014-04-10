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

namespace ZfrStripeTest\Exception;

use Guzzle\Http\Message\Response;
use ZfrStripe\Exception\BadRequestException;
use ZfrStripe\Exception\RequestFailedException;

/**
 * @author  Michaël Gallego <mic.gallego@gmail.com>
 * @licence MIT
 */
class ExceptionTest extends \PHPUnit_Framework_TestCase
{
    public function testCanCreateException()
    {
        $command  = $this->getMock('Guzzle\Service\Command\CommandInterface');
        $request  = $this->getMock('Guzzle\Http\Message\Request', [], [], '', false);
        $command->expects($this->once())->method('getRequest')->will($this->returnValue($request));
        $response = new Response(400);
        $response->setBody('');

        $exception = BadRequestException::fromCommand($command, $response);

        $this->assertInstanceOf('ZfrStripe\Exception\BadRequestException', $exception);
    }

    public function testCanCreateCardErrorException()
    {
        $command  = $this->getMock('Guzzle\Service\Command\CommandInterface');
        $request  = $this->getMock('Guzzle\Http\Message\Request', [], [], '', false);
        $command->expects($this->once())->method('getRequest')->will($this->returnValue($request));
        $response = new Response(402);
        $response->setBody(json_encode(array('error' => array('type' => 'card_error'))));

        $exception = RequestFailedException::fromCommand($command, $response);

        $this->assertInstanceOf('ZfrStripe\Exception\CardErrorException', $exception);
    }

    public function testCanCreateApiRateLimitErrorException()
    {
        $command  = $this->getMock('Guzzle\Service\Command\CommandInterface');
        $request  = $this->getMock('Guzzle\Http\Message\Request', [], [], '', false);
        $command->expects($this->once())->method('getRequest')->will($this->returnValue($request));
        $response = new Response(400);
        $response->setBody(json_encode(array('error' => array(
            'type' => 'invalid_request_error',
            'code' => 'rate_limit'
        ))));

        $exception = BadRequestException::fromCommand($command, $response);

        $this->assertInstanceOf('ZfrStripe\Exception\ApiRateLimitException', $exception);
    }
}
