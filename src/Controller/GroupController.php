<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Group;

class GroupController extends AbstractController
{
    /**
     * @Route("/groups", name="group_get_all", methods={"GET"})
     */
    public function getAll(): JsonResponse
    {
        $groups = $this->getDoctrine()->getRepository(Group::class)->findAll();
        $data = [];
        foreach ($groups as $group) {
            $data[] = [
                'id' => $group->getId(),
                'name' => $group->getName()
            ];
        }

        return $this->json($data);
    }

    /**
     * @Route("/group", name="group_create", methods={"POST"})
     */
    public function create(Request $request): JsonResponse
    {
        $em = $this->getDoctrine()->getManager();

        $group = new Group();
        $group->setName("Name");
        $group->setState("State");
        $group->setCity("City");
        $group->setStartYear(new \DateTime("2020"));
        $group->setPresentation("PRésentation");

        $this->getDoctrine()->getRepository(Group::class)->add($group, true);

        return $this->json([
            'message' => 'Group created with success!'
        ]);
    }

     /**
     * @Route("/group/{id}", name="group_edit", methods={"PUT"})
     */
    public function edit(int $id, Request $request): JsonResponse
    {
        $em = $this->getDoctrine()->getManager();
        $group = $this->getDoctrine()->getRepository(Group::class)->find($id);

        if (!$group) {
            return $this->json(['message' => "No group for id: $id"], 404);
        }

        $group->setName("Name 2");
        $group->setState("State 2");
        $group->setCity("City 2");
        $group->setStartYear(new \DateTime("2020"));
        $group->setPresentation("PRésentation test");

        $this->getDoctrine()->getRepository(Group::class)->save($group);

        return $this->json([
            'message' => 'Group updated with success!'
        ]);
    }

    // public function bulkCreate(Request $request): JsonResponse
    // {

    // }
}
