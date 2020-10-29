<?php

namespace App\Controller;

use App\Entity\DetalleVenta;
use App\Entity\Producto;
use App\Entity\Venta;
use http\Env\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class WSDetalleVentaController extends AbstractController
{
    /**
     * @Route("/ws/saisadog/detalleVenta/obtener/{codVenta}", name="ws/detalleVenta/obtener/venta", methods={"GET"})
     */
    public function getDetalleVentas($codVenta) : JsonResponse
    {

        $em = $this->getDoctrine()->getManager();
        $detalleVentas = $em->getRepository(DetalleVenta::class)->findBy(['codventa' => $codVenta]);
        $json = $this->convertirJson($detalleVentas);
        return $json;
    }

    /**
     * @Route("/ws/saisadog/detalleVenta/anadir", name="ws/detalleVenta/anadir/venta", methods={"POST"})
     */
    public function anadirDetalleVenta(Request $detalleVenta) : JsonResponse
    {
        $data = json_decode($detalleVenta->getContent(), true);
        $em = $this->getDoctrine()->getManager();

        $venta = $em->getRepository(Venta::class)->findOneBy(['id' => $data['codVenta']]);
        $producto = $em->getRepository(Producto::class)->findOneBy(['id' => $data['codProducto']]);

        $detalleVentaNuevo = new DetalleVenta(
            $producto,
            $venta,
            $data['cantidad']
        );

        $this->getDoctrine()->getManager()->persist($detalleVentaNuevo);
        $this->getDoctrine()->getManager()->flush();

        return new JsonResponse(
            ['status' => 'Detalle venta creado'],
            Response::HTTP_CREATED
        );
    }


    /**
     * @Route("/ws/saisadog/detalleVenta/actualizar", name="ws/detalleVenta/actualizar/venta", methods={"POST"})
     */
    public function actualizarDetalleVenta(Request $request) : JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $em = $this->getDoctrine()->getManager();

        $venta = $em->getRepository(Venta::class)->findOneBy(['id' => $data['codVenta']]);
        $producto = $em->getRepository(Producto::class)->findOneBy(['id' => $data['codProducto']]);

        $detalleVenta = $em->getRepository(DetalleVenta::class)->findOneBy(['codventa' => $venta->getId(),'codproducto' => $producto->getId()]);

        $detalleVenta->setCantidad($data['cantidad']);
        $this->getDoctrine()->getManager()->persist($detalleVenta);
        $this->getDoctrine()->getManager()->flush();

        return new JsonResponse(
            ['status' => 'Calificacion actualizado'],
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
