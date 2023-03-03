<?php

namespace App\Controller;

use TypeError;
use App\Entity\Product;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Serializer\Exception\NotEncodableValueException;
use Symfony\Component\Serializer\Exception\NotNormalizableValueException;

class ProductController extends AbstractController
{

    public function index()
    {
        return $this->render('base.html.twig');
    }

    /**
     * @Route("/api/json/create", name="create", methods={"POST"})
     */
    public function create(
        Request             $request,
        SerializerInterface $serializer,
        ValidatorInterface  $validator
    ): JsonResponse
    {

        $data = $request->getContent();
        $product = $serializer->deserialize($data, Product::class, 'json');

        try {
            $errors = $validator->validate($product);

            if (count($errors) > 0) {
                $idx = (count($errors)) - 1;
                $error = $errors->get($idx)->getMessage();
                return $this->json($error, 400);
            }

            $product->setCreatedAt(new \DateTime());
            $em = $this->getDoctrine()->getManager();
            $em->persist($product);
            $em->flush();
            return $this->json('Product created successfully', 201);

        } catch (NotEncodableValueException $e) {
            $message = $e->getMessage();
            throw new NotEncodableValueException($message);
        } catch (NotNormalizableValueException $e) {
            $message = $e->getMessage();
            throw new NotNormalizableValueException($message);
        }
    }

    /**
     * @Route("/api/json/get", name="get", methods={"GET"})
     */
    public function getAll(): JsonResponse
    {
        $product = $this->getDoctrine()->getRepository(Product::class)->findAll();

        if (!$product) {
            return new JsonResponse('No product found in the database', 404);
        }

        return $this->json($product, 200);
    }

    /**
     * @Route("/api/json/get/{id}", name="get_id", methods={"GET"})
     */
    public function getProductById(int $id): JsonResponse
    {
        $product = $this->getDoctrine()->getRepository(Product::class)->find($id);

        if (!$product) {
            return new JsonResponse('Product does not exist', 404);
        }

        return $this->json($product, 200);
    }

    /**
     * @Route("/api/json/update/{id}", name="update", methods={"PATCH", "PUT"})
     */
    public function update(
        int                 $id,
        Request             $request,
        SerializerInterface $serializer,
        ValidatorInterface  $validator
    ): JsonResponse
    {
        $data = $request->getContent();
        $product_update = $serializer->deserialize($data, Product::class, 'json');
        $product = $this->getDoctrine()->getRepository(Product::class)->find($id);
        try {
            if ($product_update->getName() !== null) {
                $product->setName($product_update->getName());
            }

            if ($product_update->getDescription() !== null) {
                $product->setDescription($product_update->getDescription());
            }

            if ($product_update->getQuantity() !== null) {
                $product->setQuantity($product_update->getQuantity());
            }

            if ($product_update->getPrice() !== null) {
                $product->setPrice($product_update->getPrice());
            }

            $errors = $validator->validate($product);

            if (count($errors) > 0) {
                $i = (count($errors)) - 1;
                $error = $errors->get($i)->getMessage();
                return $this->json($error, 400);
            }

            $em = $this->getDoctrine()->getManager();
            $em->persist($product);
            $em->flush();

            return $this->json('Product updated successfully', 200);
        } catch (TypeError $e) {
            $message = $e->getMessage();
            throw new TypeError($message);
        } catch (NotEncodableValueException $e) {
            $message = $e->getMessage();
            throw new NotEncodableValueException($message);
        } catch (NotNormalizableValueException $e) {
            $message = $e->getMessage();
            throw new NotNormalizableValueException($message);
        }
    }

    /**
     * @Route("/api/json/delete/{id}", name="delete", methods={"DELETE"})
     */
    public function delete(int $id): JsonResponse
    {
        $product = $this->getDoctrine()->getRepository(Product::class)->find($id);

        if (!$product) {
            return new JsonResponse('Product does not exist.', 404);
        }

        $em = $this->getDoctrine()->getManager();
        $em->remove($product);
        $em->flush();

        return new JsonResponse('Product deleted successfully', 200);
    }
}
