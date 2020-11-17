<?php

namespace App\Controller;

use App\Entity\Genero;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;


class WSGeneroController extends AbstractController
{

    /**
     * @Route("/ws/saisadog/genero/obtener", name="ws/genero/obtener", methods={"GET"})
     */
    public function getGeneros() : JsonResponse
    {
        $entityManager = $this->getDoctrine()->getManager();
        $generos = $entityManager->getRepository(Genero::class)->findAll();
        $json = $this->convertirJson($generos);
        return $json;
    }


    private function convertirJson($object) : JsonResponse
    {
        $encoders = [new XmlEncoder(), new JsonEncoder()];
        $normalizar = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizar, $encoders);
        $normalizado = $serializer->normalize($object, null);
        $jsonContent = $serializer->serialize($normalizado, 'json');
        return JsonResponse::fromJsonString($jsonContent, Response::HTTP_OK);
    }
}
