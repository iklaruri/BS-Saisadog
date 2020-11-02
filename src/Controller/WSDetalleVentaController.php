<?php

namespace App\Controller;

use App\Entity\DetalleVenta;
use App\Entity\Producto;
use App\Entity\Venta;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;


class WSDetalleVentaController extends AbstractController
{

    /**
     * @Route("/ws/saisadog/detalleVenta/anadir", name="ws/detalleVenta/anadir/venta", methods={"POST"})
     */
    public function anadirDetalleVenta(Request $request) : JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $entityManager = $this->getDoctrine()->getManager();

        $venta = $entityManager->getRepository(Venta::class)->findOneBy(['id' => $data['codVenta']]);
        $producto = $entityManager->getRepository(Producto::class)->findOneBy(['id' => $data['codProducto']]);

        $detalleVentaNuevo = new DetalleVenta(
            $data['cantidad'],
            $producto,
            $venta
        );

        $this->getDoctrine()->getManager()->persist($detalleVentaNuevo);
        $this->getDoctrine()->getManager()->flush();

        return new JsonResponse(
            ['status' => 'Detalle venta creado'],
            Response::HTTP_CREATED
        );
    }


    /**
     * @Route("/ws/saisadog/detalleVenta/eliminar", name="ws/saisadog/detalleVenta/eliminar", methods={"DELETE"})
     */
    public function eliminarDetalleVenta(Request $request) : JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $entityManager = $this->getDoctrine()->getManager();
        $detalleventa = $entityManager->getRepository(DetalleVenta::class)
            ->findOneBy(['id' => $data['id']]);
        $entityManager->remove($detalleventa);
        $entityManager->flush();
        return new JsonResponse(['status'=>'DetalleVenta eliminado'], Response::HTTP_OK);
    }


    /**
     * @Route("/ws/saisadog/detalleVenta/actualizar", name="ws/detalleVenta/actualizar/venta", methods={"POST"})
     */
    public function actualizarDetalleVenta(Request $request) : JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $entityManager = $this->getDoctrine()->getManager();

        $venta = $entityManager->getRepository(Venta::class)->findOneBy(['id' => $data['codVenta']]);
        $producto = $entityManager->getRepository(Producto::class)->findOneBy(['id' => $data['codProducto']]);

        $detalleVenta = $entityManager->getRepository(DetalleVenta::class)->findOneBy(['codventa' => $venta->getId(),'codproducto' => $producto->getId()]);

        $detalleVenta->setCantidad($data['cantidad']);
        $this->getDoctrine()->getManager()->persist($detalleVenta);
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
