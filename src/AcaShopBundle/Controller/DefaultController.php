<?php

namespace AcaShopBundle\Controller;

use AcaShopBundle\Db\Database;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{public function indexAction()
    {
        return $this->render(
            'AcaShopBundle:Default:index.html.twig'
        );
    }

    /*
    public function loginFormAction()
    {
        return $this->render(
            'AcaShopBundle:LoginForm:login.form.traci.html.twig'
        );
        // die('I am here show me a login form');
    }


    public function processLoginAction(Request $request)
    {
        // $username = $_POST['name'];     // not good! because of context of being used in a browser
                                        // locks you to this one context, could be used in different ways

        // $password = $_POST['password'];

        $username = $request->get('username');          // pulling from the form but could be anywhere
        echo '$username=' . $username . '<br/';

        $password = $request->get('password');
        echo '$password=' . $password . '<br/>';

        $query = "
        select
            user_id
        from
            aca_user
        where
            username = '$username'
            and password = '$password';";

        echo $query;

        $db = new Database();
        $data = $db->fetchRowMany($query);

        print_r($data);

        // die();

        // Run a query against the DB
        // Check for the record that exists or not
        // If you find a record, its a valid user
        // If you don't, they are not valid

        // If they are valid, set things to session
        // Make the login boxes go away!


        // symfony adds magic to process, injects object called Request,
        // we don't care where they come from user $request->get

    }
*/

}
