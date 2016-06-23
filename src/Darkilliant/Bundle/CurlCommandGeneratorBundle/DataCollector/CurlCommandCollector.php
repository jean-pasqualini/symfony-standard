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

namespace Darkilliant\Bundle\CurlCommandGeneratorBundle\DataCollector;

use Buzz\Browser;
use Buzz\Client\ClientInterface;
use Darkilliant\CurlCommandGenerator\Definition\Factory\BuzzDefinitionFactory;
use Darkilliant\CurlCommandGenerator\Definition\Factory\CurlDefinitionFactory;
use Darkilliant\CurlCommandGenerator\Generator\CommandGenerator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\DataCollector\DataCollector;
use Buzz\Message\Request as BuzzRequest;

/**
 * CurlCommandCollector
 *
 * @author Jean Pasqualini <jpasqualini75@gmail.com>
 * @package Darkilliant\Bundle\CurlCommandGeneratorBundle\DataCollector;
 */
class CurlCommandCollector extends DataCollector
{
    protected $client;

    protected $defintionCollection = array();

    protected $curlDefintionFactory;

    protected $curlCommandGenerator;

    public function __construct(Browser $browser, BuzzDefinitionFactory $curlDefinitionFactory, CommandGenerator $commandGenerator)
    {
        $this->client = $browser->getClient();

        $this->curlDefintionFactory = $curlDefinitionFactory;

        $this->curlCommandGenerator = $commandGenerator;
    }

    public function addRequest(BuzzRequest $request)
    {
        $this->defintionCollection[] = $this->curlDefintionFactory->factory($this->client, $request);
    }

    public function getCommandCollection()
    {
        return $this->data['commandCollection'];
    }

    public function collect(Request $request, Response $response, \Exception $exception = null)
    {
        $this->data = array();

        $curlCommandCollection = array();

        foreach($this->defintionCollection as $definition)
        {
            $curlCommandCollection[] = $this->curlCommandGenerator->generateCommand($definition);
        }

        $this->data['commandCollection'] = $curlCommandCollection;
    }

    public function getName()
    {
        return 'darkilliant.curl_command_collector';
    }
}