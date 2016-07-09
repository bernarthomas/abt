<?php
/**
 * DocumentsController class file
 *
 * PHP Version 7.0.4
 *
 * @category Controller
 * @package  Controller
 * @author   Bernard Thomas <bernarthomas@free.fr>
 * @license  http://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     http://abt/documents
 */
namespace AppBundle\Controller;

use AppBundle\Entity\Document;
use AppBundle\Entity\Historique;
use AppBundle\Entity\Utilisateur;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use AppBundle\Form\DocumentType;
use AppBundle\Form\DocumentsType;
use Symfony\Component\HttpFoundation\Request;

/**
 * DocumentsController
 *
 * Call the template that permit to upload a document and list all existing docq
 *
 * @category Controller
 * @package  Controller
 * @author   Bernard Thomas <bernarthomas@free.fr>
 * @license  http://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     http://abt/documents
 */
class DocumentsController extends Controller
{
    /**
     * Render add form and document list
     *
     * @param Request $request http request object
     *
     * @Route("/documents")
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(Request $request)
    {
        $isAuthenticated = $this->get('security.authorization_checker')
            ->isGranted('IS_AUTHENTICATED_FULLY');
        if (true !== $isAuthenticated) {
            throw $this->createAccessDeniedException();
        }
        $utilisateur = $this->getUser();
        $documents = $this->get('doctrine')
            ->getRepository('AppBundle:Document')
            ->findAll();
        $docsForm = $this->get('form.factory')->create(
            DocumentsType::class, $utilisateur
        );
        dump($utilisateur->getDocuments()->getValues());
        $document = new Document();
        $docForm = $this->get('form.factory')->create(
            DocumentType::class, $document,
            [
                'action' => $this->generateUrl('document_creer')
            ]
        );

        return $this->render(
            'documents/index.html.twig',
            [
                'doc_form' => $docForm->createView(),
                'docs_form' => $docsForm->createView(),
                'documents' => $documents
            ]
        );
    }

    /**
     * Add a doc
     *
     * @param Request $request http request obje t
     *
     * @Route("/document/creer", name="document_creer")
     * @Method({"POST"})
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function createAction(Request $request)
    {
        $isAuthenticated = $this->get('security.authorization_checker')
            ->isGranted('IS_AUTHENTICATED_FULLY');
        if (true !== $isAuthenticated) {
            throw $this->createAccessDeniedException();
        }
        $document = new Document();
        $form = $this->get('form.factory')->create(DocumentType::class, $document);
        if ($form->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();
            if (empty($document->getId())) {
                $utilisateurCourant = $this->get('security.token_storage')
                    ->getToken()->getUser();
                $historique = new Historique();
                $historique
                    ->setDt(new \DateTime())
                    ->setStatut(1)
                    ->addUtilisateur($utilisateurCourant)
                    ->addDocument($document);
                $em->persist($historique);
                $document
                    ->addHistorique($historique)
                    ->addUtilisateur($utilisateurCourant);
                $utilisateurCourant
                    ->addHistorique($historique)
                    ->addDocument($document)
                    ;
                $em->persist($utilisateurCourant);
            }
            $em->persist($document);
            $em->flush();
            $request->getSession()->getFlashBag()
                ->add(
                    'info',
                    'Le document "' . $document->getTitre() . '" est enregistré.'
                );

            return $this->redirect($this->generateUrl('app_documents_index'));

        }
    }
}
