<?php
namespace AcaShopBundle\Controller;
use AcaShopBundle\Db\Database;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;

class RegistrationController extends Controller
{
    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function registrationFormAction(Request $request)
    {
        echo "Here in the Registration Controller";

        $msg = null;
        $session = $this->getSession();
        $name = $request->get('name');
        $username = $request->get('username');
        $password = $request->get('password');

        if (!empty($username) && !empty($password)) {
            $query = '
            INSERT INTO aca_user
            (name, username, password)
            VALUES
            ("' . $name . '", "' . $username . '", "' . $password . '")';

            $db = new Database();
            $db->insertQuery($query);

            $session->set('submitRegistration', true);
            $session->set('loggedIn', true);

            $session->save();

            $submitRegistration = $session->get('submitRegistration');
            $name = $session->get('name');

            return new RedirectResponse('/');
        }

        return $this->render(
            'AcaShopBundle:RegistrationForm:registration-form.html.twig'
            );



    }


    /**
     * Get a valid started session
     * @return Session
     */
    private function getSession()
    {
        /** @var Session $session */
        $session = $this->get('session');
        if (!$session->isStarted()) {
            $session->start();
        }
        return $session;
    }

}