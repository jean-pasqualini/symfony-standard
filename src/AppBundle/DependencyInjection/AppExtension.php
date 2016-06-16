<?php
/**
 * Created by PhpStorm.
 * User: prestataire
 * Date: 15/06/16
 * Time: 15:49
 */

namespace AppBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\Config\FileLocator;

/**
 * AppExtension
 *
 * @author Jean Pasqualini <jean.pasqualini@digitaslbi.fr>
 * @copyright 2016 DigitasLbi France
 * @package AppBundle\DependencyInjection;
 */
class AppExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');

    }
}