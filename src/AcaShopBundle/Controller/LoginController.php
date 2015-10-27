<?php

namespace AcaShopBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AcaShopBundle\Db\Database;
use Symfony\Component\HttpFoundation\Request;

class LoginController extends Controller
{

    public function loginFormAction(Request $request)
    {
        $session = $this->get('session');

        $msg = null;
        // $loggedout = null;
        $shippingAddressId = null;
        $billingAddressId = null;

        $username = $request->get('username');
        $password = $request->get('password');

        if ($request->getMethod() == 'POST') {       // if the method is POST, then the form has been submitted

            $submitted = 'true';
        }

        $query = '
        select
            *
        from
            aca_user
        where
            username = "' . $username . '"
            and password = "' . $password . '"';

        $db = new Database();
        $data = $db->fetchRowMany($query);

        // echo "<pre>";
        // print_r($data);

        if (empty($data) && empty($username) && empty($password)) {       // No data, no username and no password

            // echo "You have logged out";
            // echo "<br/>";
            // echo "<br/>";

            $msg = 'You have logged out';

            $session->set('isLoggedIn', false);
            $session->set('username', "");
            $session->set('password', "");
        }

        else if (empty($data) && !empty($username) && !empty($password)) { // Invalid login

            // echo $username;
            // echo $password;
            echo "Invalid login, please check credentials and try again";
            echo "<br/>";
            echo "<br/>";


            $msg = 'Please check your credentials';
            $session->set('isLoggedIn', false);

        }

        else { // Valid login

            // echo $username;
            // echo $password;
            // echo "We have a valid login here (Yay!)";
            // echo "<br/>";

            $row = array_pop($data);
            $name = $row['name']; // person's name
            $shippingAddressId = $row['shipping_address_id'];   // person's shipping address
            $billingAddressId = $row['billing_address_id'];     // person's billing address

            // echo "<pre>";
            // print_r($data);

            // echo $name;

            $session->set('isLoggedIn', true);
            $session->set('name', $name);
            $session->set('shippingAddressId', $shippingAddressId);
            $session->set('billingAddressId', $billingAddressId);
            // $session->save();                   // is this needed?


        }




        $loggedIn = $session->get('isLoggedIn');
        $name = $session->get('name');

        // if logged in , get a welcome name
        return $this->render(
            'AcaShopBundle:LoginForm2:smurf.html.twig',
            array(
                'loggedIn' => $loggedIn,
                'name' => $name,
                'msg' => $msg,
                'username' => $username,
                'password' => $password,
                'shippingAddressId' => $shippingAddressId,
                'billingAddressId' => $billingAddressId
            )
        );
    }
}