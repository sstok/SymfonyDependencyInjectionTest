<?php

namespace Matthias\SymfonyDependencyInjectionTest\Tests\Loader;

use Matthias\SymfonyDependencyInjectionTest\Loader\LoaderFactory;
use PHPUnit\Framework\TestCase;

class LoaderFactoryTest extends TestCase
{
    /**
     * @test
     * @dataProvider fileProvider
     */
    public function it_creates_the_appropriate_file_loader_based_on_the_extension($file, $expectedClass): void
    {
        $factory = new LoaderFactory();
        $loader = $factory->createLoaderForSource($this->createMockContainerBuilder(), $file);

        $this->assertInstanceOf($expectedClass, $loader);
    }

    /**
     * @test
     */
    public function it_creates_a_closure_loader_when_source_is_a_closure(): void
    {
        $source = function (): void {
        };
        $factory = new LoaderFactory();

        $loader = $factory->createLoaderForSource($this->createMockContainerBuilder(), $source);
        $this->assertInstanceOf('Symfony\Component\DependencyInjection\Loader\ClosureLoader', $loader);
    }

    public function fileProvider()
    {
        return [
            ['file.xml', 'Symfony\Component\DependencyInjection\Loader\XmlFileLoader'],
            ['file.yml', 'Symfony\Component\DependencyInjection\Loader\YamlFileLoader'],
            ['file.yaml', 'Symfony\Component\DependencyInjection\Loader\YamlFileLoader'],
            ['file.php', 'Symfony\Component\DependencyInjection\Loader\PhpFileLoader'],
        ];
    }

    private function createMockContainerBuilder()
    {
        return $this
            ->getMockBuilder('Symfony\Component\DependencyInjection\ContainerBuilder')
            ->disableOriginalConstructor()
            ->setMethods(null)
            ->getMock();
    }
}
