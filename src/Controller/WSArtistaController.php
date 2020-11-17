<?php

namespace App\Controller;

use App\Entity\Artista;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

class WSArtistaController extends AbstractController
{

    /**
     * @Route("/ws/saisadog/artista/obtener", name="ws/artista/obtener", methods={"GET"})
     */
    public function getArtistas() : JsonResponse
    {
        $entityManager = $this->getDoctrine()->getManager();
        $artistas = $entityManager->getRepository(Artista::class)->findAllOrder();
        $json = $this->convertirJson($artistas);
        return $json;
    }

    /**
     * @Route("/ws/saisadog/artista/obtenerNovedades", name="ws/artista/obtenerNovedades", methods={"GET"})
     */
    public function getArtistasNovedades() : JsonResponse
    {
        $entityManager = $this->getDoctrine()->getManager();
        $artistas = $entityManager->getRepository(Artista::class)->findArtistasNovedades();
        $json = $this->convertirJson($artistas);
        return $json;
    }


    private function convertirJson($object) : JsonResponse
    {
        $encoders = [new XmlEncoder(), new JsonEncoder()];
        $normalizar = [new DateTimeNormalizer(), new ObjectNormalizer()];
        $serializer = new Serializer($normalizar, $encoders);
        $normalizado = $serializer->normalize($object, null,
            array(DateTimeNormalizer::FORMAT_KEY => 'Y'));
        $jsonContent = $serializer->serialize($normalizado, 'json');
        return JsonResponse::fromJsonString($jsonContent, Response::HTTP_OK);
    }
}
