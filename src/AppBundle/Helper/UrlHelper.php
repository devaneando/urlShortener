<?php

namespace AppBundle\Helper;

use AppBundle\Entity\Repository\UrlRepository;
use AppBundle\Entity\Url;
use AppBundle\Exception\InvalidUrlException;
use AppBundle\Exception\NonexistentHashException;
use AppBundle\Exception\NonexistentUrlException;
use Doctrine\ORM\EntityManager;

class UrlHelper
{
    const VALID_URL_REGEX = "/^(?:http(s)?:\/\/)?[\w.-]+(?:\.[\w\.-]+)+[\w\-\._~:\/?#[\]@!\$&'\(\)\*\+,;=.]+$/";
    const HASH_ALGORITM = 'crc32';

    /**
     * @var UrlRepository
     */
    private $urlRepository;

    /**
     * @var EntityManager;
     */
    private $entityManager;

    /**
     * Set urlRepository.
     *
     * @param UrlRepository $urlRepository
     *
     * @return self
     */
    public function setUrlRepository(UrlRepository $urlRepository)
    {
        $this->urlRepository = $urlRepository;

        return $this;
    }

    /**
     * Set entityManager.
     *
     * @param EntityManager $entityManager
     *
     * @return self
     */
    public function setEntityManager(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;

        return $this;
    }

    /**
     * Get the hash of a URL.
     *
     * @param string $url
     *
     * @throws InvalidUrlException
     *
     * @return string
     */
    public function getHash(string $url)
    {
        $url = trim($url);

        // Prevents attacks in case somebody bypass the javascript validation
        if (!preg_match(self::VALID_URL_REGEX, $url)) {
            throw new InvalidUrlException();
        }

        try {
            $objUrl = $this->urlRepository->getOneByUrl($url);
        } catch (NonexistentUrlException $ex) {
            $objUrl = new Url();
            $objUrl
                ->setHash(hash(self::HASH_ALGORITM, $url))
                ->setUrl($url);
            $this->entityManager->persist($objUrl);
            $this->entityManager->flush($objUrl);
        }

        return $objUrl->getHash();
    }

    /**
     * Get the URL of a hash.
     *
     * @param string $hash
     *
     * @throws NonexistentHashException
     *
     * @return string
     */
    public function getUrl(string $hash)
    {
        $hash = trim($hash);

        $objUrl = $this->urlRepository->getOneByHash($hash);

        return $objUrl->getUrl();
    }
}
