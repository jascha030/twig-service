<?php

declare(strict_types=1);

namespace Jascha030\Twig;

use Interop\Container\ServiceProviderInterface;
use Jascha030\Twig\Templater\TemplaterInterface;
use Psr\Container\ContainerInterface;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use Twig\Loader\LoaderInterface;
use Twig\TwigFilter;
use Twig\TwigFunction;

final class TwigServiceProvider implements ServiceProviderInterface
{
    /**
     * {@inheritDoc}
     */
    public function getFactories(): array
    {
        return [
            'twig.root.path'          => static function () {
                return null;
            },
            /**
             * Interfaces and class-bindings.
             *
             * @see  LoaderInterface
             *
             * @uses FilesystemLoader
             */
            LoaderInterface::class    => static function (ContainerInterface $c): LoaderInterface {
                return new FilesystemLoader(
                    $c->has('twig.root') ? $c->get('twig.root') : '',
                    $c->has('twig.root.path') ? $c->get('twig.root.path') : null
                );
            },
            /**
             * Twig Environment factory binding.
             *
             * @see   LoaderInterface
             *
             * @uses  LoaderInterface::class, as key to retrieve the defined loader from the container.
             * @uses  'twig.functions' key to retrieve twig function extensions to be added to Environment, from the container.
             * @uses  'twig.filters'   key to retrieve twig filter extensions to be added to Environment, from the container.
             */
            Environment::class        => static function (ContainerInterface $c): Environment {
                $environment = new Environment($c->get(LoaderInterface::class));

                foreach ($c->get('twig.functions') as $key => $closure) {
                    $environment->addFunction(new TwigFunction($key, $closure));
                }

                foreach ($c->get('twig.filters') as $key => $closure) {
                    $environment->addFilter(new TwigFilter($key, $closure));
                }

                $environment->addGlobal('post', []);

                return $environment;
            },
            TemplaterInterface::class => static function (ContainerInterface $c) {
                return new TwigService($c->get(Environment::class));
            },
        ];
    }

    public function getExtensions(): array
    {
        return [];
    }
}
