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

namespace ZfrStripe\Client\Iterator;

use Guzzle\Service\Command\CommandInterface;
use Guzzle\Service\Resource\ResourceIterator;

/**
 * Basic iterator that is used to iterate over all Stripe commands
 *
 * This is used for the new (introduced in 2014-03-28) cursor-based pagination
 *
 * @author  Michaël Gallego <mic.gallego@gmail.com>
 * @licence MIT
 */
class StripeCommandsCursorIterator extends ResourceIterator
{
    /**
     * @param CommandInterface $command
     * @param array            $data
     */
    public function __construct(CommandInterface $command, array $data = array())
    {
        parent::__construct($command, $data);

        $this->pageSize = 100; // This is the maximum allowed by Stripe
    }

    /**
     * {@inheritDoc}
     */
    protected function sendRequest()
    {
        $this->command->set('limit', $this->pageSize);

        if ($this->nextToken) {
            $this->command->set('starting_after', $this->nextToken);
        }

        $result   = $this->command->execute();
        $data     = $result['data'];
        $lastItem = end($data);

        // This avoid to do any additional request
        $this->nextToken = $result['has_more'] ? $lastItem['id'] : false;

        return $data;
    }
}
