<?php

namespace App\Controller;

use App\Entity\Producto;
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
        $em = $this->getDoctrine()->getManager();
        $productos = $em->getRepository(Producto::class)->findAll();
        $json = $this->convertirJson($productos);
        return $json;
    }

    /**
     * @Route("/ws/saisadog/producto/obtenerPorArtista/{codArtista}", name="ws/producto/obtenePorArtista/codArtista", methods={"GET"})
     */
    public function getProductosPorArtista($codArtista) : JsonResponse
    {
        $em = $this->getDoctrine()->getManager();
        $productos = $em->getRepository(Producto::class)->findBy(['codartista' => $codArtista]);
        $json = $this->convertirJson($productos);
        return $json;
    }

    /**
     * @Route("/ws/saisadog/producto/obtenerPorTipo/{codTipo}", name="ws/producto/obtenerPorTipo/codTipo", methods={"GET"})
     */
    public function getProductosPorTipo($codTipo) : JsonResponse
    {
        $em = $this->getDoctrine()->getManager();
        $productos = $em->getRepository(Producto::class)->findBy(['codtipoProducto' => $codTipo]);
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
