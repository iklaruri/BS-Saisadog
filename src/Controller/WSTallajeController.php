<?php

namespace App\Controller;

use App\Entity\Tallaje;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class WSTallajeController extends AbstractController
{
    /**
     * @Route("/ws/saisadog/tallaje/obtener", name="ws/tallaje/obtenerTodos", methods={"GET"})
     */
    public function getTallajes() : JsonResponse
    {
        $entityManager = $this->getDoctrine()->getManager();
        $tallas = $entityManager->getRepository(Tallaje::class)->findAll();
        $json = $this->convertirJson($tallas);
        return $json;
    }


    /**
     * @Route("/ws/saisadog/tallaje/anadir", name="ws/tallajr/anadir", methods={"POST"})
     */
    public function anadirTallaje(Request $request) : JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $entityManager = $this->getDoctrine()->getManager();

        $tallaje = $entityManager->getRepository(Tallaje::class)->findOneBy(['nombre' => $data['nombre']]);

        if($tallaje)
        {
            return new JsonResponse(
                ['status' => 'Tallaje ya existe'],
                Response::HTTP_IM_USED
            );
        }else
        {
            $tallajeNuevo = new Tallaje(
                $data['nombre']
            );

            $this->getDoctrine()->getManager()->persist($tallajeNuevo);
            $this->getDoctrine()->getManager()->flush();

            return new JsonResponse(
                ['status' => 'Tallaje creado'],
                Response::HTTP_CREATED
            );
        }
    }


    /**
     * @Route("/ws/saisadog/tallaje/actualizar", name="ws/tallaje/actualizar", methods={"PUT"})
     */
    public function actualizarTallaje(Request $request) : JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $entityManager = $this->getDoctrine()->getManager();

        $tallaje = $entityManager->getRepository(Tallaje::class)->findOneBy(['id' => $data['id']]);

        if($tallaje)
        {
            $tallaje->setNombre($data['nombre']);

            $this->getDoctrine()->getManager()->persist($tallaje);
            $this->getDoctrine()->getManager()->flush();

            return new JsonResponse(
                ['status' => 'Actualizado', 'tallajeActualizado' => $tallaje],
                Response::HTTP_CREATED
            );
        }else{
            return new JsonResponse(
                ['status' => 'No se ha podido actualizar'],
                Response::HTTP_NOT_FOUND
            );
        }
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
