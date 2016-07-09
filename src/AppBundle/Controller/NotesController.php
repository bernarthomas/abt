<?php
/**
 * NotesController class file
 *
 * PHP Version 7.0.4
 *
 * @category Controller
 * @package  Controller
 * @author   Bernard Thomas <bernarthomas@free.fr>
 * @license  http://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     http://abt/notes
 */
namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * NotesController
 *
 * Call the template that permit to create new note and list all existing notes
 *
 * @category Controller
 * @package  Controller
 * @author   Bernard Thomas <bernarthomas@free.fr>
 * @license  http://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     http://abt/notes
 */
class NotesController extends Controller
{
    /**
     * Show notes list template
     *
     * @Route("/notes")
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        $isAuthenticated = $this->get('security.authorization_checker')
            ->isGranted('IS_AUTHENTICATED_FULLY');
        if (true !== $isAuthenticated) {
            throw $this->createAccessDeniedException();
        }

        return $this->render('notes/index.html.twig');
    }

}
