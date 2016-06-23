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

namespace Darkilliant\Bundle\CurlCommandGeneratorBundle\Adapter\Buzz;

use Buzz\Listener\ListenerInterface;
use Buzz\Message\MessageInterface;
use Buzz\Message\RequestInterface;
use Darkilliant\Bundle\CurlCommandGeneratorBundle\DataCollector\CurlCommandCollector;
use Symfony\Component\DependencyInjection\ContainerInterface;


/**
 * BuzzRequestListener
 *
 * @author Jean Pasqualini <jpasqualini75@gmail.com>
 * @package Darkilliant\Bundle\CurlCommandGeneratorBundle\Adapter\Buzz;
 */
class BuzzRequestListener implements ListenerInterface
{
    protected $container;

    protected $collector;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function getCurlCommandCollector()
    {
        if($this->collector === null) {
            $this->collector = $this->container->get('darkilliant.curl_command_generator.curl_command_collector');
        }

        return $this->collector;
    }

    public function preSend(RequestInterface $request)
    {
        $this->getCurlCommandCollector()->addRequest($request);
    }

    public function postSend(RequestInterface $request, MessageInterface $response)
    {
        // TODO: Implement postSend() method.
    }
}