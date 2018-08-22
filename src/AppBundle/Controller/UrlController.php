<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Url;
use AppBundle\Form\UrlType;
use AppBundle\Helper\UrlHelper;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

/**
 * @\Sensio\Bundle\FrameworkExtraBundle\Configuration\Route(service="app.controller.url")
 */
class UrlController extends Controller
{
    /**
     * @var UrlHelper
     */
    private $urlHelper;

    public function setUrlHelper(UrlHelper $urlHelper)
    {
        $this->urlHelper = $urlHelper;
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
        // @Fix: the urlHelper service injection is not working here. The lines below are a workaround.
        /** @var UrlHelper $urlHelper */
        $urlHelper = $this->container->get('app.helper.url');
        $this->urlHelper = $urlHelper;

        $form = $this->createForm(UrlType::class);

        // Handle the form post
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $urlForm = $request->get('appbundle_url')['url'];

            $hash = $this->urlHelper->getHash($urlForm);

            /** @var Session $session */
            $session = $request->getSession();

            $session->getFlashBag()->add(
                'success',
                sprintf(
                    'Your shortened url is: %s',
                    $this->generateUrl(
                        'go_to',
                        ['hash' => $hash],
                        UrlGeneratorInterface::ABSOLUTE_URL
                    )
                )
            );
        }

        return $this->render(
            'url/shorten_url.html.twig',
            ['form' => $form->createView()]
        );
    }

    /**
     * @Route("/{hash}", name="go_to", requirements={"page"="[a-zA-Z0-9]{8}"})
     */
    public function goToAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('url/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
        ]);
    }
}
