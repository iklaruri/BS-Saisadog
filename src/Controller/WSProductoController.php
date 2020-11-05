<?php

namespace App\Controller;

use App\Entity\Artista;
use App\Entity\Producto;
use App\Entity\ProductoGenero;
use App\Entity\TipoProducto;
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
     * @Route("/ws/saisadog/producto/anadir", name="ws/producto/anadir", methods={"POST"})
     */
    public function anadirProducto(Request $request) : JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $entityManager = $this->getDoctrine()->getManager();

        $producto = $entityManager->getRepository(Producto::class)->findOneBy(['nombre' => $data['nombre'],'codartista' => $data['codArtista'],'codtipoProducto' => $data['codTipoProducto']]);

        if($producto)
        {
            return new JsonResponse(
                ['status' => 'Producto ya existe'],
                Response::HTTP_IM_USED
            );
        }else
        {
            $artista = $entityManager->getRepository(Artista::class)->findOneBy(['id' => $data['codArtista']]);
            $tipoProducto = $entityManager->getRepository(TipoProducto::class)->findOneBy(['id' => $data['codTipoProducto']]);

            if($artista && $tipoProducto)
            {
                $productoNuevo = new Producto(
                    $data['nombre'],
                    $data['stock'],
                    $artista,
                    $tipoProducto
                );

                $this->getDoctrine()->getManager()->persist($productoNuevo);
                $this->getDoctrine()->getManager()->flush();

                return new JsonResponse(
                    ['status' => 'Producto creado'],
                    Response::HTTP_CREATED
                );
            }else
            {
                return new JsonResponse(
                    ['status' => 'Artista o TipoProducto no existe'],
                    Response::HTTP_CREATED
                );
            }
        }
    }

    /**
     * @Route("/ws/saisadog/producto/actualizar", name="ws/producto/actualizar", methods={"PUT"})
     */
    public function actualizarProducto(Request $request) : JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $entityManager = $this->getDoctrine()->getManager();

        $artista = $entityManager->getRepository(Artista::class)->findOneBy(['id' => $data['codArtista']]);
        $tipoProducto = $entityManager->getRepository(TipoProducto::class)->findOneBy(['id' => $data['codTipoProducto']]);

        $producto = $entityManager->getRepository(Producto::class)->findOneBy(['codartista' => $artista->getId(),'codtipoProducto' => $tipoProducto->getId()]);

        $producto->setNombre($data['nombre']);
        $producto->setStock($data['stock']);

        $this->getDoctrine()->getManager()->persist($producto);
        $this->getDoctrine()->getManager()->flush();

        return new JsonResponse(
            ['status' => 'Detalle Venta actualizado'],
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
