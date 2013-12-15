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

namespace ZfrStripeTest\Http\QueryAggregator;

use Guzzle\Http\QueryString;
use ZfrStripe\Http\QueryAggregator\StripeQueryAggregator;

/**
 * @author  Michaël Gallego <mic.gallego@gmail.com>
 * @licence MIT
 */
class StripeQueryAggregatorTest extends \PHPUnit_Framework_TestCase
{
    public function testAggregator()
    {
        $query      = new QueryString();
        $aggregator = new StripeQueryAggregator();

        $result = $aggregator->aggregate('expand', array('customer', 'invoice'), $query);
        $expected[$query->encodeValue('expand[]')] = array('customer', 'invoice');

        $this->assertEquals($expected, $result);

        $result   = $aggregator->aggregate('card', array('ccv' => '123', 'name' => 'foo'), $query);
        $expected = array(
            $query->encodeValue('card[ccv]')  => '123',
            $query->encodeValue('card[name]') => 'foo'
        );

        $this->assertEquals($expected, $result);
    }
}
