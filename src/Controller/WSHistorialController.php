<?php

namespace App\Controller;

use App\Entity\Historial;
use App\Entity\Producto;
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

class WSHistorialController extends AbstractController
{


    /**
     * @Route("/ws/saisadog/historial/anadir", name="ws/historial/anadir", methods={"POST"})
     */
    public function anadirHistorial(Request $request) : JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $entityManager = $this->getDoctrine()->getManager();

        $producto = $entityManager->getRepository(Producto::class)->findOneBy(['id' => $data['codProducto']]);
        $historial = $entityManager->getRepository(Historial::class)->findOneBy(['codproducto' => $data['codProducto'],'fechafin' => null]);

        if($historial)
        {
            $historial->setFechafin(\DateTime::createFromFormat('Y-m-d', $data['fecha']));
            $historial->setEsoferta(false);
            $this->getDoctrine()->getManager()->persist($historial);
            $this->getDoctrine()->getManager()->flush();
        }

        $historialNuevo = new Historial(
            $data['precio'],
            \DateTime::createFromFormat('Y-m-d', $data['fecha']),
            $data['esOferta'],
            $producto
        );

        $this->getDoctrine()->getManager()->persist($historialNuevo);
        $this->getDoctrine()->getManager()->flush();

        return new JsonResponse(
            ['status' => 'Historial creado'],
            Response::HTTP_CREATED
        );

    }

}
