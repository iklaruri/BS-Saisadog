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
     * @Route("/ws/saisadog/venta/obtener/{codUsuario}/{fecha}", name="ws/venta/obtener/usuario/fecha", methods={"GET"})
     */
    public function getVentasPorUsuarioYFecha($codUsuario,$fecha) : JsonResponse
    {
        $em = $this->getDoctrine()->getManager();
        $ventas = $em->getRepository(Venta::class)->findVentasByUsuarioFecha($codUsuario,$fecha);
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
            \DateTime::createFromFormat('Y-m-d H:i:s', $data['fecha']),
            $data['direccion'],
            $usuario
        );

        $this->getDoctrine()->getManager()->persist($ventaNuevo);
        $this->getDoctrine()->getManager()->flush();

        return new JsonResponse(
            ['status' => 'Venta creado'],
            Response::HTTP_CREATED
        );

    }

    
    private function convertirJson($object) : JsonResponse
    {
        $encoders = [new XmlEncoder(), new JsonEncoder()];
        $normalizar = [new DateTimeNormalizer(), new ObjectNormalizer()];
        $serializer = new Serializer($normalizar, $encoders);
        $normalizado = $serializer->normalize($object, null,
            array(DateTimeNormalizer::FORMAT_KEY => 'Y/m/d'));
        $jsonContent = $serializer->serialize($normalizado, 'json');
        return JsonResponse::fromJsonString($jsonContent, Response::HTTP_OK);
    }
}
