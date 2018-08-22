<?php

namespace AppBundle\Helper;

class UrlHelper
{
    /**
     * @var UrlRepository
     */
    private $urlRepository;

    /**
     * Set urlRepository.
     *
     * @param UrlRepository $urlRepository
     */
    public function setUrlRepository(UrlRepository $urlRepository)
    {
        $this->urlRepository = $urlRepository;
    }
}
