<?php

namespace App\Controller;

use App\Entity\Producto;
use App\Entity\ProductoGenero;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class WSProductoController extends AbstractController
{

    /**
     * @Route("/ws/saisadog/producto/obtener", name="ws/producto/obtener", methods={"GET"})
     */
    public function getProductos() : JsonResponse
    {
        $entityManager = $this->getDoctrine()->getManager();
        $productos = $entityManager->getRepository(Producto::class)->findAll();
        $json = $this->convertirJson($productos);
        return $json;
    }

    /**
     * @Route("/ws/saisadog/producto/obtenerPorGenero/{codGenero}", name="ws/producto/obtenePorGenero/codGenero", methods={"GET"})
     */
    public function getProductosPorGenero($codGenero) : JsonResponse
    {
        $entityManager = $this->getDoctrine()->getManager();
        $productos = $entityManager->getRepository(ProductoGenero::class)->findProductosByGenero($codGenero);
        $json = $this->convertirJson($productos);
        return $json;
    }


    /**
     * @Route("/ws/saisadog/producto/obtenerPorArtista/{codArtista}", name="ws/producto/obtenePorArtista/codArtista", methods={"GET"})
     */
    public function getProductosPorArtista($codArtista) : JsonResponse
    {
        $entityManager = $this->getDoctrine()->getManager();
        $productos = $entityManager->getRepository(Producto::class)->findProductosByArtista($codArtista);
        $json = $this->convertirJson($productos);
        return $json;
    }

    /**
     * @Route("/ws/saisadog/producto/obtenerPorTipo/{codTipo}", name="ws/producto/obtenerPorTipo/codTipo", methods={"GET"})
     */
    public function getProductosPorTipo($codTipo) : JsonResponse
    {
        $entityManager = $this->getDoctrine()->getManager();
        $productos = $entityManager->getRepository(Producto::class)->findProductosByTipo($codTipo);;
        $json = $this->convertirJson($productos);
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
