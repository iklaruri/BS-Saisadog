<?php

namespace App\Controller;

use App\Entity\DetalleVenta;
use App\Entity\Historial;
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
        $venta= $entityManager->getRepository(Venta::class)->findLast();
        $producto= $entityManager->getRepository(Producto::class)->findOneBy(['id' => $data['codProducto']]);

        if($venta && $producto)
        {
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
        }else
        {
            return new JsonResponse(
                ['status' => 'Error al añadir Detalle venta'],
                Response::HTTP_BAD_REQUEST
            );
        }


    }

}
