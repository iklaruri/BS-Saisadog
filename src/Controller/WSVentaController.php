<?php

namespace App\Controller;

use App\Entity\DetalleVenta;
use App\Entity\Usuario;
use App\Entity\Venta;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class WSVentaController extends AbstractController
{

    /**
     * @Route("/ws/saisadog/venta/obtener", name="ws/venta/obtener", methods={"GET"})
     */
    public function getVentas() : JsonResponse
    {
        $em = $this->getDoctrine()->getManager();
        $ventas = $em->getRepository(Venta::class)->findAll();
        $json = $this->convertirJson($ventas);
        return $json;
    }

    /**
     * @Route("/ws/saisadog/venta/obtener/{codUsuario}", name="ws/venta/obtener/usuario", methods={"GET"})
     */
    public function getVentasPorUsuario($codUsuario) : JsonResponse
    {
        $em = $this->getDoctrine()->getManager();
        $usuario = $em->getRepository(Usuario::class)->findOneBy(['id' => $codUsuario]);
        $ventas = $em->getRepository(Venta::class)->findBy(['codusuario' => $usuario->getId()]);
        $json = $this->convertirJson($ventas);
        return $json;
    }


    /**
     * @Route("/ws/saisadog/venta/anadir", name="ws/venta/anadir", methods={"POST"})
     */
    public function anadirVenta(Request $request) : JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $em = $this->getDoctrine()->getManager();

        $usuario = $em->getRepository(Usuario::class)->findOneBy(['id' => $data['codUsuario']]);

        $ventaNuevo = new Venta(
            $data['precioFinal'],
            \DateTime::createFromFormat('Y/m/d H:i:s', $data['fecha']),
            $usuario
        );

        $this->getDoctrine()->getManager()->persist($ventaNuevo);
        $this->getDoctrine()->getManager()->flush();

        return new JsonResponse(
            ['status' => 'Venta creado'],
            Response::HTTP_CREATED
        );

    }

    /**
     * @Route("/ws/saisadog/venta/actualizar", name="ws/saisadog/venta/actualizar", methods={"PUT"})
     */
    public function actualizarVenta(Request $request) : JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $em = $this->getDoctrine()->getManager();

        $venta = $em->getRepository(Venta::class)->findOneBy(['id' => $data['id']]);

        if($venta)
        {
            $venta->setPreciofinal($data['precioFinal']);
            $venta->setFecha( \DateTime::createFromFormat('Y/m/d H:i:s', $data['fecha']));

            $this->getDoctrine()->getManager()->persist($venta);
            $this->getDoctrine()->getManager()->flush();

            return new JsonResponse(
                ['status' => 'Actualizado', 'ventaActualizado' => $venta],
                Response::HTTP_CREATED
            );
        }else{
            return new JsonResponse(
                ['status' => 'No se ha podido actualizar'],
                Response::HTTP_NOT_FOUND
            );
        }
    }

    /**
     * @Route("/ws/saisadog/venta/eliminar/{id}", name="ws/saisadog/venta/eliminar", methods={"DELETE"})
     */
    public function eliminarVenta($id) : JsonResponse
    {
        $entityManager = $this->getDoctrine()->getManager();
        $venta = $entityManager->getRepository(Venta::class)
            ->findOneBy(['id' => $id]);
        $detalleVentas = $entityManager->getRepository(DetalleVenta::class)
            ->findBy(['codventa' => $venta->getId()]);

        foreach ($detalleVentas as $detalleVenta)
        {
            $entityManager->remove($detalleVenta);
        }

        $entityManager->remove($venta);
        $entityManager->flush();
        return new JsonResponse(['status'=>'Venta eliminado'], Response::HTTP_OK);
    }

    private function convertirJson($object) : JsonResponse
    {
        $encoders = [new XmlEncoder(), new JsonEncoder()];
        $normalizar = [new DateTimeNormalizer(), new ObjectNormalizer()];
        $serializer = new Serializer($normalizar, $encoders);
        $normalizado = $serializer->normalize($object, null,
            array(DateTimeNormalizer::FORMAT_KEY => 'Y/m/d H:i:s'));
        $jsonContent = $serializer->serialize($normalizado, 'json');
        return JsonResponse::fromJsonString($jsonContent, Response::HTTP_OK);
    }
}
