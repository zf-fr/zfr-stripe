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

use GuzzleHttp\Command\CommandInterface;
use GuzzleHttp\Command\ServiceClientInterface;
use Iterator;

/**
 * Basic iterator that is used to iterate over all Stripe commands
 *
 * This is used for the new (introduced in 2014-03-28) cursor-based pagination
 *
 * @author  Michaël Gallego <mic.gallego@gmail.com>
 * @licence MIT
 */
class StripeCommandsCursorIterator implements Iterator
{
    /**
     * @var ServiceClientInterface
     */
    private $client;

    /**
     * @var CommandInterface
     */
    private $command;

    /**
     * @var int
     */
    private $requestCount = 0;

    /**
     * @var string|null
     */
    private $nextToken;

    /**
     * @var array
     */
    private $result = [];

    /**
     * @var int|null
     */
    private $maxResults = null;

    /**
     * @var int
     */
    private $iterationCount = 0;

    /**
     * @param ServiceClientInterface $client
     * @param CommandInterface       $command
     */
    public function __construct(ServiceClientInterface $client, CommandInterface $command)
    {
        $this->client  = $client;
        $this->command = $command;

        // If there is no explicit limit set, we use the maximum allowed by Stripe (100)
        if (!isset($command['limit'])) {
            $command['limit'] = 100;
        }
    }

    /**
     * @param int $maxResults
     */
    public function setMaxResults($maxResults)
    {
        $this->maxResults = (int) $maxResults;
    }

    /**
     * @return int
     */
    public function getMaxResults()
    {
        return $this->maxResults;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return iterator_to_array($this, false);
    }

    /**
     * @return array
     */
    public function getNext()
    {
        $this->result = [];
        $countLoaded  = $this->requestCount * $this->command['limit'];

        if ((!$this->requestCount || $this->nextToken)
            && ($this->maxResults === null || $countLoaded < $this->maxResults)
        ) {
            $this->loadNextResult();
        }

        return $this->result;
    }

    /**
     * {@inheritDoc}
     */
    public function current()
    {
        return current($this->result);
    }

    /**
     * {@inheritDoc}
     */
    public function next()
    {
        next($this->result);
        $this->iterationCount++;
    }

    /**
     * {@inheritDoc}
     */
    public function key()
    {
        return key($this->result);
    }

    /**
     * {@inheritDoc}
     */
    public function valid()
    {
        if (null !== key($this->result)) {
            return null !== $this->maxResults ? ($this->iterationCount < $this->maxResults) : true;
        }

        return !empty($this->getNext());
    }

    /**
     * {@inheritDoc}
     */
    public function rewind()
    {
        $this->requestCount   = 0;
        $this->iterationCount = 0;
        $this->result         = [];
        $this->nextToken      = null;
    }

    /**
     * @return void
     */
    private function loadNextResult()
    {
        if ($this->nextToken) {
            $this->command['starting_after'] = $this->nextToken;
        } else {
            unset($this->command['starting_after']);
        }

        $response = $this->client->execute($this->command);

        $this->result = $response['data'];
        $this->requestCount++;

        if ($response['has_more']) {
            $this->nextToken = end($response['data'])['id'];
        }
    }
}
