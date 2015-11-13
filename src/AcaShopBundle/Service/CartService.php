<?php


namespace AcaShopBundle\Service;

use Simplon\Mysql\Mysql;
use Symfony\Component\HttpFoundation\Session\Session;

class CartService
{

    // need to access db
    // can be anyone's class
    // should know what it does without referring to anything outside of it
    // type hinting good
    // use buys you $this->db->x   chaining


    /**
     * Database class
     * @var Mysql
     */
    protected $db;

    /**
     * Session object
     * @var Session
     */
    protected $session;

    public function __construct(Mysql $db, Session $session)
    {
        $this->db = $db;
        $this->session = $session;

        //start session if not already
        if (!$this->session->isStarted()) $this->session->start();
    }


    /**
     * Add a product to the cart
     * @param int $productId
     * @param int $quantity
     * @return bool
     */
    public function addProduct($productId, $quantity)
    {

        /* do something here
        $addProduct = "
            Insert INTO
              aca_cart_product
                (product_id, qty)
              VALUES
                 ('$productId', '$quantity')";
        */

        // add stuff about getting userId

        // Check if I have a cart record?

        $cartId = $this->getCartId();

        $productPrice = $this->getProductPrice($productId);


        // echo $cartId;
        // echo $productPrice;

        //$insertedId = $this->db->insert()

        $insertedId = $this->db->insert('aca_cart_product',
            array(
                'cart_id' => $cartId,
                'product_id' => $productId,
                'qty' => $quantity,
                'unit_price' => $productPrice)
        );

        return !empty($insertedId) && is_int($insertedId) ? true : false;

    }

    /**
     * Get the price of one product
     * @param int $productId
     * @return float
     */
    protected function getProductPrice($productId)
    {
     $query = 'select price from aca_product where id = "'. $productId . '"';

        $row = $this->db->fetchRow($query);

        return isset($row['price']) ? $row['price'] : null;

    }


    /**
     * Create a cart record, and return the ID, if it doesn't exist
     * If it does exist, just return the Id
     * @throws \Exception
     * @return int
     */
    public function getCartId()
    {

        // check if user has a cart
        $userId = $this->session->get('user_id');
        if (empty($userId)) {
            throw new \Exception('You must be logged in');
        }


        $query = '
            Select
                id
            from
                aca_cart
            WHERE
                user_id = ' . $userId;

        $row = $this->db->fetchRow($query, array('userId' => $userId));

        // We have a cart record
        if (isset($row['id']) && !empty($row)) {
            return $cartId = $row['id'];
        }
        else {
            $cartId = $this->db->insert('aca_cart', array('user_id' => $userId));
            return $cartId;
        }
    }


    /**
     * Get all products that are in this user's shopping cart
     * @return array|null
     * @throws \Exception
     * should id be p.id or cp.id?
     */
    public function getAllCartProducts()
    {

        $query = '
        select
	      cp.id,
	      p.name,
	      p.description,
	      p.image,
	      cp.unit_price as price,
	      cp.qty
        from
            aca_cart_product as cp
	        inner join aca_product as p on (p.id = cp.product_id)
	        left join aca_cart as c on (c.id = cp.cart_id)
        where
	        cp.cart_id = :myCartId';


        return $this->db->fetchRowMany($query,
            array(
                'myCartId' => $this->getCartId()
            )
        );

    }

    public function updateQty($cartproductId, $quantity, $cartId)
    {
        // $cartId = $this->getCartId();

        $newQty = $this->db->update('aca_cart_product',
        array(
            'id' => $cartproductId
        ),
            array(
                'qty' => $quantity
            )
        );

    }

    public function deleteItem($cartproductId, $cartId)
    {
        // $cartId = $this->getCartId();

        $query = '
            delete
              *
            from
              aca_cart_product
            where
              product_id = ' . $productId;

        /*
        return $this->db->delete('aca_cart_product',
            array(
                'product_id' => $productId
            )
            );
        */

        $tablename = 'aca_cart_product';

        $del = $this->db->delete($tablename,
            array(
                'id' => $cartproductId
            ),
            array(
                'product_id' => $productId,
                'cart_id' => $cartId
            )
        );

        return $del;




    }

}



ssh-rsa AAAAB3NzaC1yc2EAAAADAQABAAABAQDUrm7kCHIC7n1FEjFwBxhVVFhFbKH0ynpB2Axz5Kgx0JqOlD9N/ZppUsFn2KRnjXCgrOLSLzDMJ/r+ILvNvl4tbVW75iwPzw8lFslrJuROKviEGSkYJiCCocLHObBRvhvIgkFsvCi7Z3BLXd0TYzrAmWGgNJq2+X7gZQe5WZpWlday8+AjP3VAUT9PJ/9W0dV/ixUtIipMjjKk87ME4yBHwX1rPX6RQc59MB6IO52+cex8IHcJQEiK7lBT0rMYLF6SrgSCShntvImIyjmDuKcv53QRy43Gege4DhO6zQTOb1I3coFGw2oKs7Dy91GKmGq3JX4CyMWs9+/OixaCX/B1 ubuntu@ip-172-31-22-134