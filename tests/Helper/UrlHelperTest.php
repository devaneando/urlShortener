<?php

namespace tests\Helper;

use AppBundle\Exception\InvalidUrlException;
use AppBundle\Exception\NonexistentHashException;
use AppBundle\Helper\UrlHelper;
use Devaneando\NameGeneratorBundle\Helper\RandomHelper;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * vendor/bin/simple-phpunit -c ./phpunit.xml.dist ./tests/Helper/UrlHelperTest.php.
 */
class UrlHelperTest extends KernelTestCase
{
    const VALID_HASH = '1943bdba';
    const VALID_URL = 'https://github.com';

    private $container;

    public function setUp()
    {
        self::bootKernel();
        $this->container = self::$kernel->getContainer();
    }

    public function testGetHashInvalid()
    {
        /** @var UrlHelper $urlHelper */
        $urlHelper = $this->container->get('app.helper.url');
        $this->expectException(InvalidUrlException::class);
        $urlHelper->getHash('aaaa a a a a a a a a');
    }

    public function testGetHash()
    {
        /** @var UrlHelper $urlHelper */
        $urlHelper = $this->container->get('app.helper.url');
        $this->assertEquals(
            self::VALID_HASH,
            $urlHelper->getHash(self::VALID_URL)
        );
    }

    public function testGetUrlInvalid()
    {
        /** @var UrlHelper $urlHelper */
        $urlHelper = $this->container->get('app.helper.url');
        $this->expectException(NonexistentHashException::class);
        $urlHelper->getUrl('abc_abc_abc_abc_abc_abc_abc');
    }

    public function testGetUrl()
    {
        /** @var UrlHelper $urlHelper */
        $urlHelper = $this->container->get('app.helper.url');
        $this->assertEquals(
            self::VALID_URL,
            $urlHelper->getUrl(self::VALID_HASH)
        );
    }
}
