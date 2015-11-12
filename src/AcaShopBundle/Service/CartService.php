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
	      p.id,
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

    public function updateQty($productId, $quantity, $cartId)
    {
        // $cartId = $this->getCartId();

        $newQty = $this->db->replace('aca_cart_product',
            array(
                'cart_id' => $cartId,
                'product_id' => $productId,
                'qty' => $quantity
            )
        );

    }

    public function deleteItem($productId, $cartId)
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
                'product_id' => $productId,
                'cart_id' => $cartId
            )
        );

        return $del;




    }

}