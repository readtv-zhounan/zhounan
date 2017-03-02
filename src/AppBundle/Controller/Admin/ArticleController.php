<?php

namespace AppBundle\Controller\Admin;

use AppBundle\Entity\Article;
use AppBundle\Form\Type\ArticleType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/article")
 */
class ArticleController extends Controller
{
    /**
     * @Route("/", name="admin_article_index", methods={"GET"})
     */
    public function indexAction(Request $request)
    {
        $qb = $this->get('doctrine.orm.entity_manager')
            ->getRepository('AppBundle:Article')
            ->createQueryBuilder('a')
            ->orderBy('a.createdAt', 'DESC')
        ;

        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate($qb, $request->query->getInt('page', 1), 20);

        return $this->render('admin/article/index.html.twig', compact('pagination'));
    }

    /**
     * @Route("/new", name="admin_article_new", methods={"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $form = $this->createForm(ArticleType::class);

        $form->handleRequest($request);
        if ($form->isValid()) {
            $article = $form->getData();

            $em = $this->get('doctrine.orm.entity_manager');
            $em->persist($article);
            $em->flush();

            return $this->redirectToRoute('admin_article_edit', ['id' => $article->getId()]);
        }

        return $this->render('admin/article/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="admin_article_edit", methods={"GET", "PUT"}, requirements={"id"="\d+"})
     */
    public function editAction(Article $article, Request $request)
    {
        $editForm = $this->createForm(ArticleType::class, $article, [
            'method' => 'PUT',
        ]);
        $deleteForm = $this->createDeleteForm($article->getId());

        $editForm->handleRequest($request);
        if ($editForm->isValid()) {
            $em = $this->get('doctrine.orm.entity_manager');
            $em->flush();

            $this->addFlash('success', '修改成功');

            return $this->redirectToRoute('admin_article_index');
        }

        return $this->render('admin/article/edit.html.twig', [
            'article' => $article,
            'editForm' => $editForm->createView(),
            'deleteForm' => $deleteForm->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="admin_article_delete", methods={"PATCH"}, requirements={"id"="\d+"})
     */
    public function deleteAction(Article $article, Request $request)
    {
        $form = $this->createDeleteForm($article->getId());

        $form->handleRequest($request);
        if ($form->isValid()) {
            $em = $this->get('doctrine.orm.entity_manager');

            $em->remove($article);
            $em->flush();

            $this->addFlash('success', '操作成功');
        }

        return $this->redirect($this->generateUrl('admin_article_index'));
    }

    /**
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_article_delete', ['id' => $id]))
            ->setMethod('PATCH')
            ->getForm()
        ;
    }
}
