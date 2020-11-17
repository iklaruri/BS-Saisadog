<?php

namespace App\Controller;

use App\Entity\Producto;
use App\Entity\Talla;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class WSTallaController extends AbstractController
{
    /**
     * @Route("/ws/saisadog/talla/obtener/{codProducto}", name="ws/talla/obtener/codProducto", methods={"GET"})
     */
    public function getTallasPorProducto($codProducto) : JsonResponse
    {
        $entityManager = $this->getDoctrine()->getManager();
        $tallas = $entityManager->getRepository(Talla::class)->findTallasByProducto($codProducto);
        $json = $this->convertirJson($tallas);
        return $json;
    }


    /**
     * @Route("/ws/saisadog/talla/actualizarStock", name="ws/talla/actualizarStock", methods={"PUT"})
     */
    public function actualizarTallaStock(Request $request) : JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $entityManager = $this->getDoctrine()->getManager();

        $talla = $entityManager->getRepository(Talla::class)->findOneBy(['codtallaje' => $data['codTallaje'],'codproducto' => $data['codProducto']]);

        if($talla)
        {
            $talla->setStock($data['stock']);
            $this->getDoctrine()->getManager()->persist($talla);
            $this->getDoctrine()->getManager()->flush();

            return new JsonResponse(
                ['status' => 'Actualizado', 'tallaActualizado' => $talla],
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
        $normalizar = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizar, $encoders);
        $normalizado = $serializer->normalize($object, null);
        $jsonContent = $serializer->serialize($normalizado, 'json');
        return JsonResponse::fromJsonString($jsonContent, Response::HTTP_OK);
    }
}
