<?php
namespace AcaShopBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AcaShopBundle\Db\Database;
use Symfony\Component\HttpFoundation\Request;



class LogoutController extends Controller
{
    public function logoutFormAction(Request $request)
    {
        $session = $this->get('session');
        $msg = null;
        $username = $request->get('username');
        $password = $request->get('password');

        if (empty($data) && !empty($username) && !empty($password)) { // Invalid login
            $msg = 'Please check your credentials';
            $session->set('isLoggedIn', false);
        } else { // Valid login
            $row = array_pop($data);
            $name = $row['name']; // person's name
            $session->set('isLoggedIn', true);
            $session->set('name', $name);
            $session->save();

        }
        $loggedIn = $session->get('isLoggedIn');
        $name = $session->get('name');
        return $this->render(
            'AcaShopBundle:LoginForm:login.form.traci.html.twig',
            array(
                'loggedIn' => $loggedIn,
                'name' => $name,
                'msg' => $msg,
                'username' => $username,
                'password' => $password
            )
        );
    }
}