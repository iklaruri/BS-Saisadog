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
        $entityManager = $this->getDoctrine()->getManager();
        $artistas = $entityManager->getRepository(Artista::class)->findAllOrder();
        $json = $this->convertirJson($artistas);
        return $json;
    }

    /**
     * @Route("/ws/saisadog/artista/obtenerNovedades", name="ws/artista/obtenerNovedades", methods={"GET"})
     */
    public function getArtistasNovedades() : JsonResponse
    {
        $entityManager = $this->getDoctrine()->getManager();
        $artistas = $entityManager->getRepository(Artista::class)->findArtistasNovedades();
        $json = $this->convertirJson($artistas);
        return $json;
    }

    /**
     * @Route("/ws/saisadog/artista/anadir", name="ws/artista/anadir", methods={"POST"})
     */
    public function anadirArtista(Request $request) : JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $entityManager = $this->getDoctrine()->getManager();

        $artista = $entityManager->getRepository(Artista::class)->findOneBy(['nombre' => $data['nombre']]);

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
                \DateTime::createFromFormat('Y', $data['fechaFundacion']),
                $data['foto']
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
        $entityManager = $this->getDoctrine()->getManager();

        $artista = $entityManager->getRepository(Artista::class)->findOneBy(['id' => $data['id']]);

        if($artista)
        {
            $artista->setNombre($data['nombre']);
            $artista->setFechafundacion( \DateTime::createFromFormat('Y', $data['fechaFundacion']));
            $artista->setFoto($data['foto']);

            $this->getDoctrine()->getManager()->persist($artista);
            $this->getDoctrine()->getManager()->flush();

            return new JsonResponse(
                ['status' => 'Actualizado', 'artistaActualizado' => $artista],
                Response::HTTP_OK
            );
        }else{
            return new JsonResponse(
                ['status' => 'No se ha podido actualizar'],
                Response::HTTP_NO_CONTENT
            );
        }
    }


    private function convertirJson($object) : JsonResponse
    {
        $encoders = [new XmlEncoder(), new JsonEncoder()];
        $normalizar = [new DateTimeNormalizer(), new ObjectNormalizer()];
        $serializer = new Serializer($normalizar, $encoders);
        $normalizado = $serializer->normalize($object, null,
            array(DateTimeNormalizer::FORMAT_KEY => 'Y'));
        $jsonContent = $serializer->serialize($normalizado, 'json');
        return JsonResponse::fromJsonString($jsonContent, Response::HTTP_OK);
    }
}
