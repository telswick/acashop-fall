<?php


namespace AcaShopBundle\Service;

use Simplon\Mysql\Mysql;
use Symfony\Component\HttpFoundation\Session\Session;

class CheckoutService
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

    public function getUserId()
    {
        return $this->session->get('user_id');

    }


    public function getShippingAddressId($userId)
    {
        $shippingIdquery = '
            select
                shipping_address_id
            from aca_user
            WHERE
                user_id = "' . $userId . '"
        ';

        return $this->db->fetchRow($shippingIdquery);

    }

    public function getShippingAddress($shippingId)
    {

        // now get shipping address
        $shipQuery ='
                select
                    street,
                    city,
                    state,
                    zip
                from aca_address
                WHERE
                    address_id = "'. $shippingId . '"
            ';



        $row = $this->db->fetchRow($shipQuery,
            array(
                'shippingId' => $shippingId)
            );

        // echo '<pre/>';
        // print_r($row);

        // die('shipping address');

        return $row;


    }

    public function getBillingAddressId($userId)
    {
        $billingIdquery = '
            select
                billing_address_id
            from aca_user
            WHERE
                user_id = "' . $userId . '"
        ';

        return $this->db->fetchRow($billingIdquery);

    }

    public function getBillingAddress($billingId)
    {
        // now get billing address
        $billQuery ='
                select
                    street,
                    city,
                    state,
                    zip
                from aca_address
                WHERE
                    address_id = "' . $billingId . '"
            ';

        $row = $this->db->fetchRow($billQuery,
            array(
                'billingAddress' => $billingId)
            );

        // echo '<pre/>';
        // print_r($row);

        // die('billing address');

        return $row;

    }






}