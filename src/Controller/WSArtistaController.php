<?php

namespace App\Controller;

use App\Entity\Artista;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

class WSArtistaController extends AbstractController
{
    /**
     * @Route("/ws/saisadog/artista/obtener", name="ws/artista/obtener", methods={"GET"})
     */
    public function getArtistas() : JsonResponse
    {
        $em = $this->getDoctrine()->getManager();
        $artistas = $em->getRepository(Artista::class)->findAll();
        $json = $this->convertirJson($artistas);
        return $json;
    }


    /**
     * @Route("/ws/saisadog/artista/anadir", name="ws/artista/anadir", methods={"POST"})
     */
    public function anadirArtista(Request $request) : JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $em = $this->getDoctrine()->getManager();

        $artista = $em->getRepository(Artista::class)->findOneBy(['nombre' => $data['nombre']]);

        if($artista)
        {
            return new JsonResponse(
                ['status' => 'Artista ya existe'],
                Response::HTTP_IM_USED
            );
        }else
        {
            $artistaNuevo = new Artista(
                $data['nombre'],
                \DateTime::createFromFormat('Y/m/d', $data['fechaFundacion'])
            );

            $this->getDoctrine()->getManager()->persist($artistaNuevo);
            $this->getDoctrine()->getManager()->flush();

            return new JsonResponse(
                ['status' => 'Artista creado'],
                Response::HTTP_CREATED
            );
        }
    }


    /**
     * @Route("/ws/saisadog/artista/actualizar", name="ws/artista/actualizar", methods={"PUT"})
     */
    public function actualizarArtista(Request $request) : JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $em = $this->getDoctrine()->getManager();

        $artista = $em->getRepository(Artista::class)->findOneBy(['id' => $data['id']]);

        if($artista)
        {
            $artista->setNombre($data['nombre']);
            $artista->setFechafundacion( \DateTime::createFromFormat('Y/m/d', $data['fechaFundacion']));

            $this->getDoctrine()->getManager()->persist($artista);
            $this->getDoctrine()->getManager()->flush();

            return new JsonResponse(
                ['status' => 'Actualizado', 'artistaActualizado' => $artista],
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
        $normalizar = [new DateTimeNormalizer(), new ObjectNormalizer()];
        $serializer = new Serializer($normalizar, $encoders);
        $normalizado = $serializer->normalize($object, null,
            array(DateTimeNormalizer::FORMAT_KEY => 'Y/m/d'));
        $jsonContent = $serializer->serialize($normalizado, 'json');
        return JsonResponse::fromJsonString($jsonContent, Response::HTTP_OK);
    }
}
