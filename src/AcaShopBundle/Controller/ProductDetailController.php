<?php
namespace AcaShopBundle\Controller;
use AcaShopBundle\Db\Database;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFpundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;

class ProductDetailController extends Controller
{

    public function showProductDetailAction ($slug, Request $request)
    {
        echo "Here in the ProductDetail Controller";

        $msg = null;
        $session = $this->getSession();



        $query = '
            SELECT
                u.*
            FROM
                aca_product u
            WHERE
              slug = "' . $slug . '"
            ';

        $db = new Database();
        $data = $db->requestQuery($query);
        $data = $data[0];

        /*
        $row = array_pop($data);
        $product_id = $row['product_id']; //
        $name = $row['name'];
        $description = $row['description'];
        $image = $row['image'];
        $category = $row['category'];
        $price = $row['price'];
        $price = "$" . (float)$price;
        $date_added = $row['date_added'];
        */


        return $this->render(
            'AcaShopBundle:ProductsForm:productdetail-form.html.twig',
            array('products' => $data)

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








