<?php
/**
 * User: boshurik
 * Date: 08.04.16
 * Time: 19:12
 */

namespace BoShurik\AdminBundle\Controller;

use Symfony\Component\Security\Core\Authorization\Voter\AuthenticatedVoter;

class SecurityController extends Controller
{
    public function loginAction()
    {
        if ($this->isGranted(AuthenticatedVoter::IS_AUTHENTICATED_FULLY)) {
            return $this->redirectToRoute('admin_dashboard');
        }

        $authenticationUtils = $this->getAuthenticationUtils();

        return $this->render('BoShurikAdminBundle:Security:login.html.twig', array(
            'username' => $authenticationUtils->getLastUsername(),
            'error'         => $authenticationUtils->getLastAuthenticationError(),
        ));
    }

    /**
     * @return \Symfony\Component\Security\Http\Authentication\AuthenticationUtils
     */
    private function getAuthenticationUtils()
    {
        return $this->get('security.authentication_utils');
    }
}