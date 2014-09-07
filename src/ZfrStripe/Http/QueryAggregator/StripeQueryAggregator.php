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

namespace ZfrStripe\Http\QueryAggregator;

use Guzzle\Http\QueryAggregator\QueryAggregatorInterface;
use Guzzle\Http\QueryString;

/**
 * Stripe is super picky on the format for query params. For instance, for the "expand" query parameter,
 * it does not support when values are indexed (eg. ?expand[0]=foo&expand[1]=bar). Therefore, we have
 * to concatenate them differently
 *
 * @author  Michaël Gallego <mic.gallego@gmail.com>
 * @licence MIT
 */
class StripeQueryAggregator implements QueryAggregatorInterface
{
    /**
     * {@inheritDoc}
     */
    public function aggregate($key, $value, QueryString $query)
    {
        $ret = [];

        foreach ($value as $k => $v) {
            if (is_int($k)) {
                return [$query->encodeValue("{$key}[]") => $value];
            }

            $k = "{$key}[{$k}]";

            if (is_array($v)) {
                $ret = array_merge($ret, self::aggregate($k, $v, $query));
            } else {
                $ret[$query->encodeValue($k)] = $query->encodeValue($v);
            }
        }

        return $ret;
    }
}
