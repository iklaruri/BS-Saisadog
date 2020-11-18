<?php

namespace App\Controller;


use App\Entity\Producto;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
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
        $productos = $entityManager->getRepository(Producto::class)->findAllProductos();
        $json = $this->convertirJson($productos);
        return $json;
    }


    /**
     * @Route("/ws/saisadog/producto/obtenerProducto/{codProducto}/{fecha}", name="ws/producto/obtener/id", methods={"GET"})
     */
    public function getProductosById($codProducto,$fecha) : JsonResponse
    {
        $entityManager = $this->getDoctrine()->getManager();
        $producto = $entityManager->getRepository(Producto::class)->findProductoById($codProducto,$fecha);
        $json = $this->convertirJson($producto);
        return $json;
    }


    /**
     * @Route("/ws/saisadog/producto/obtenerPorGenero/{codGenero}", name="ws/producto/obtenerPorGenero/codGenero", methods={"GET"})
     */
    public function getProductosPorGenero($codGenero) : JsonResponse
    {
        $entityManager = $this->getDoctrine()->getManager();
        $productos = $entityManager->getRepository(Producto::class)->findProductosByGenero($codGenero);
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

    /**
     * @Route("/ws/saisadog/producto/obtenerPorTermino/{termino}", name="ws/producto/obtenerPorTermino/termino", methods={"GET"})
     */
    public function getProductosPorTermino($termino) : JsonResponse
    {
        $entityManager = $this->getDoctrine()->getManager();
        $productos = $entityManager->getRepository(Producto::class)->findProductosByTermino($termino);
        $json = $this->convertirJson($productos);
        return $json;
    }

    /**
     * @Route("/ws/saisadog/producto/obtenerDiscosPorTermino/{termino}", name="ws/producto/obtenerDiscosPorTermino/termino", methods={"GET"})
     */
    public function getDiscosPorTermino($termino) : JsonResponse
    {
        $entityManager = $this->getDoctrine()->getManager();
        $discos = $entityManager->getRepository(Producto::class)->findDiscosByTermino($termino);
        $json = $this->convertirJson($discos);
        return $json;
    }

    /**
     * @Route("/ws/saisadog/producto/obtenerRopasPorTermino/{termino}", name="ws/producto/obtenerRopasPorTermino/termino", methods={"GET"})
     */
    public function getRopasPorTermino($termino) : JsonResponse
    {
        $entityManager = $this->getDoctrine()->getManager();
        $discos = $entityManager->getRepository(Producto::class)->findRopasByTermino($termino);
        $json = $this->convertirJson($discos);
        return $json;
    }

    /**
     * @Route("/ws/saisadog/producto/obtenerOtrosPorTermino/{termino}", name="ws/producto/obtenerOtrosPorTermino/termino", methods={"GET"})
     */
    public function getOtrosPorTermino($termino) : JsonResponse
    {
        $entityManager = $this->getDoctrine()->getManager();
        $discos = $entityManager->getRepository(Producto::class)->findOtrosByTermino($termino);
        $json = $this->convertirJson($discos);
        return $json;
    }


    /**
     * @Route("/ws/saisadog/producto/obtenerNovedades", name="ws/producto/obtenerNovedades", methods={"GET"})
     */
    public function getProductosNovedades() : JsonResponse
    {
        $entityManager = $this->getDoctrine()->getManager();
        $productos = $entityManager->getRepository(Producto::class)->findProductosNovedades();
        $json = $this->convertirJson($productos);
        return $json;
    }


    /**
     * @Route("/ws/saisadog/producto/actualizarStock", name="ws/producto/actualizar", methods={"PUT"})
     */
    public function actualizarProductoStock(Request $request) : JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $entityManager = $this->getDoctrine()->getManager();


        $producto = $entityManager->getRepository(Producto::class)->findOneBy(['id' => $data['codProducto']]);

         $producto->setStock($data['stock']);

        $this->getDoctrine()->getManager()->persist($producto);
        $this->getDoctrine()->getManager()->flush();

        return new JsonResponse(
            ['status' => 'Talla stock actualizado'],
            Response::HTTP_CREATED
        );

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
