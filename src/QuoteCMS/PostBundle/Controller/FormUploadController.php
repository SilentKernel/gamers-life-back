<?php

namespace QuoteCMS\PostBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use QuoteCMS\PostBundle\Form\PostPictureType;
use QuoteCMS\PostBundle\Entity\PostPicture;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;


class FormUploadController extends Controller
{
    public function PostPictureFormAction($postFormId, Request $request)
    {
        // do not inject anything in my HTML (event if twig should do it) !
        $postFormId = htmlspecialchars($postFormId);

        $postPicture = new PostPicture();
        $form = $this->get('form.factory')->create(new PostPictureType(), $postPicture);

        if ($form->handleRequest($request)->isValid())
        {
            $jsonArray = $this->get('quote_cms_core_upload_validator')
                ->isValid($postPicture->getFile(),"postPicture");

            if ($jsonArray["success"])
            {
                $this->get('stof_doctrine_extensions.uploadable.manager')
                    ->markEntityToUpload($postPicture, $postPicture->getFile());
                $em = $this->getDoctrine()->getManager();
                $em->persist($postPicture);
                $em->flush();
                $postPicture->setFile(null);

                $this->container
                ->get('liip_imagine.controller')
                ->filterAction($request, $postPicture->__toString(), 'screenshot_mobile');

                // keep this upload in session to link it to the correct quote
                $session = $request->getSession();
                if ($session->has($postFormId))
                    $uploadedPictures = $session->get($postFormId);
                else
                    $uploadedPictures = array();

                $uploadedPictures[] = $postPicture->getId();
                $session->set($postFormId, $uploadedPictures);
            }

            return new JsonResponse($jsonArray);
        }

        return $this->render('QuoteCMSPostBundle:Form:postUploadModal.html.twig', array(
            'form' => $form->createView(),
            'postFormId' => $postFormId
        ));
    }
}
