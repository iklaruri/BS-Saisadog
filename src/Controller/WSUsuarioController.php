<?php

namespace App\Controller;

use App\Entity\Usuario;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

class WSUsuarioController extends AbstractController
{
    /**
     * @Route("/ws/saisadog/usuario/login", name="ws/saisadog/login", methods={"POST"})
     */
    public function login(Request $request) : JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $entityManager = $this->getDoctrine()->getManager();
        $usuarioExiste = $entityManager->getRepository(Usuario::class)->findOneBy(['usuario' => $data['usuario']]);
        if($usuarioExiste)
        {
            $usuario = $entityManager->getRepository(Usuario::class)->findOneBy(['usuario' => $data['usuario'],'password' => $data['password']]);
            $json = $this->convertirJson($usuario);
            return $json;
        }else
        {
            return new JsonResponse(
                ['status' => 'El usuario no existe, registrate'],
                Response::HTTP_NO_CONTENT
            );
        }

    }

    /**
     * @Route("/ws/saisadog/usuario/obtener/{codUsuario}", name="ws/saisadog/usuario/obtener/codUsuario", methods={"GET"})
     */
    public function getUsuario($codUsuario) : JsonResponse
    {
        $entityManager = $this->getDoctrine()->getManager();
        $usuario = $entityManager->getRepository(Usuario::class)->findOneBy(['id' => $codUsuario]);
        $json = $this->convertirJson($usuario);
        return $json;
    }


    /**
     * @Route("/ws/saisadog/usuario/anadir", name="ws/saisadog/usuario/anadir", methods={"POST"})
     */
    public function anadirUsuario(Request $request) : JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $entityManager = $this->getDoctrine()->getManager();

        $usuarioExiste = $entityManager->getRepository(Usuario::class)->findOneBy(['usuario' => $data['usuario']]);

        if($usuarioExiste)
        {
            return new JsonResponse(
                ['status' => 'Usuario ya existe'],
                Response::HTTP_IM_USED
            );
        }else
        {
            $usuarioNuevo = new Usuario(
                $data['usuario'],
                $data['direccion'],
                $data['email'],
                $data['tlf'],
                $data['password'],
                ''
            );

            $this->getDoctrine()->getManager()->persist($usuarioNuevo);
            $this->getDoctrine()->getManager()->flush();

            $usuarioCreado = $entityManager->getRepository(Usuario::class)->findOneBy(['usuario' => $data['usuario']]);
            return new JsonResponse(
                ['status' => 'Usuario creado', 'usuario' => $usuarioCreado],
                Response::HTTP_CREATED
            );
        }

    }

    /**
     * @Route("/ws/saisadog/usuario/actualizar", name="ws/saisadog/usuario/actualizar", methods={"PUT"})
     */
    public function actualizarUsuario(Request $request) : JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $entityManager = $this->getDoctrine()->getManager();

        $usuario = $entityManager->getRepository(Usuario::class)->findOneBy(['id' => $data['codUsuario']]);

        if($usuario)
        {
            $usuario->setDireccion($data['direccion']);
            $usuario->setEmail($data['email']);
            $usuario->setTlf($data['tlf']);
            $usuario->setPassword($data['password']);
            $usuario->setUsuario($data['usuario']);

            $this->getDoctrine()->getManager()->persist($usuario);
            $this->getDoctrine()->getManager()->flush();

            return new JsonResponse(
                ['status' => 'Actualizado', 'usuarioActualizado' => $usuario],
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
