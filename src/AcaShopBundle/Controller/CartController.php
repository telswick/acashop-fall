<?php

namespace AcaShopBundle\Controller;

use AcaShopBundle\Db\Database;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;

/**
 * Class CartController deals with all things related to the cart
 * @package AcaShopBundle\Controller
 */
class CartController extends Controller
{




    /**
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showCartAction()
    {
        // Write a query to fetch all the products that are in your cart
        // This query should be written in the service
        // The method should return an array of all "joined" product records with
        //  relevant information needed to render a cart

        // Get all the products from the newly created method in the CartService
        // Assign that data to the template
        // loop through the data and display a table
        // Extra: Also create the forms mentioned on the board (update, delete)

        // $cart = $this->get('cart');


        // $db = $this->get('acadb');

        /**
        $query = '
        SELECT
            *
        FROM
            aca_cart_product'
        ;
        */



        // $cartdata = $db->fetchRowMany($query);

        // $lastitem = array_pop($cartdata);

        $cart = $this->get('cart');          // trying to use CartService

        $cartProducts = $cart->showCart();



        return $this->render(
            'AcaShopBundle:Cart:show.all.html.twig',
            array('stuff' => $cartProducts)


        );


    }


    public function addCartAction(Request $request)
    {
        echo "Here in addCartAction";
        echo "<br/>";

        // echo "Here in the Cart Controller";


        //  $db = $this->get('acadb');

        $productId = $request->get('product_id');
        echo '$productId=' . $productId;
        echo "<br/>";

        $quantity = $request->get('qty');
        echo '$quantity=' . $quantity;
        echo "<br/>";

        $cart = $this->get('cart');          // trying to use CartService

        $result = $cart->addProduct($productId, $quantity);

        // return new RedirectResponse('/cart');

        // die('should have added to table aca_cart_product');

        // echo '<pre/>';
        // print_r($result);

        $db = $this->get('acadb');

        $query = '
        SELECT
            *
        FROM
            aca_cart_product'
        ;



        $cartdata = $db->fetchRowMany($query);

        $lastitem = array_pop($cartdata);

//        echo '<pre/>';
//        print_r($lastitem);
//
//        die('cart data');
//
//
//
//
        return new RedirectResponse('/cart');


        /**
        return $this->render(

            'AcaShopBundle:Cart:show.all.html.twig',
            array('stuff' => $lastitem)

        );
        **/


        // die();

        // this is like bound parameters
        // need session out of the container get->session
        // first see if you have a cart record already and if not then start a new one
        // get product_id and price as hidden values
        // $data = $db->insertMany('aca_cart', array('user_id'));

        // return new RedirectResponse('/cart');

    }



}