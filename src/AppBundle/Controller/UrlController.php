<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Repository\UrlRepository;
use AppBundle\Entity\Url;
use AppBundle\Form\UrlType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route as ConfigurationRoute;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UrlController extends Controller
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

    /**
     * @Route("/test", name="test")
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('url/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
        ]);
    }

    /**
     * @Route("/", name="shorten")
     *
     * Shorten a url.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function shortenAction(Request $request)
    {
        $url = new Url();
        $form = $this->createForm(UrlType::class, $url);

        // Handle the form post
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /**
             * @TODO: Clean the given url to prevent attacks and persist it
             * @TODO: Change the flash message to display the generated hash
             */
            $request->getSession()
                ->getFlashBag()
                ->add('success', 'Return here the URL hash!');
        }

        return $this->render(
            'url/shorten_url.html.twig',
            ['form' => $form->createView()]
        );
    }
}
