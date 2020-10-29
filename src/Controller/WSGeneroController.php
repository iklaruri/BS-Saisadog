<?php

namespace App\Controller;

use App\Entity\Genero;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;


class WSGeneroController extends AbstractController
{
    /**
     * @Route("/ws/saisadog/genero/obtener", name="ws/genero/obtener", methods={"GET"})
     */
    public function getGeneros() : JsonResponse
    {
        $em = $this->getDoctrine()->getManager();
        $generos = $em->getRepository(Genero::class)->findAll();
        $json = $this->convertirJson($generos);
        return $json;
    }


    /**
     * @Route("/ws/saisadog/genero/anadir", name="ws/genero/anadir", methods={"POST"})
     */
    public function anadirGenero(Request $genero) : JsonResponse
    {
        $data = json_decode($genero->getContent(), true);
        $em = $this->getDoctrine()->getManager();

        $genero = $em->getRepository(Genero::class)->findOneBy(['nombre' => $data['nombre']]);

        if($genero)
        {
            return new JsonResponse(
                ['status' => 'Genero ya existe'],
                Response::HTTP_IM_USED
            );
        }else
        {
            $generoNuevo = new Genero(
                $data['nombre']
            );

            $this->getDoctrine()->getManager()->persist($generoNuevo);
            $this->getDoctrine()->getManager()->flush();

            return new JsonResponse(
                ['status' => 'Genero creado'],
                Response::HTTP_CREATED
            );
        }
    }


    /**
     * @Route("/ws/saisadog/genero/actualizar", name="ws/genero/actualizar", methods={"PUT"})
     */
    public function generoActualizar(Request $genero) : JsonResponse
    {
        $data = json_decode($genero->getContent(), true);
        $em = $this->getDoctrine()->getManager();

        $genero = $em->getRepository(Genero::class)->findOneBy(['id' => $data['id']]);

        if($genero)
        {
            $genero->setNombre($data['nombre']);

            $this->getDoctrine()->getManager()->persist($genero);
            $this->getDoctrine()->getManager()->flush();

            return new JsonResponse(
                ['status' => 'Actualizado', 'generoActualizado' => $genero],
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
