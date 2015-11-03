<?php
namespace AcaShopBundle\Controller;
use AcaShopBundle\Db\Database;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;

class ProductsController extends Controller
{
    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showProductsAction(Request $request)
    {
        echo "Here in the Products Controller";

        $msg = null;
        $session = $this->getSession();



            $query = '
            SELECT
                u.*
            FROM
                aca_product u
            WHERE
                u.product_id = "1" ';

            $db = new Database();
            $data = $db->requestQuery($query);

            $row = array_pop($data);
            $product_id = $row['product_id']; //
            $name = $row['name'];
            $description = $row['description'];
            $image = $row['image'];
            $category = $row['category'];
            $price = $row['price'];
            $date_added = $row['date_added'];


            return $this->render(
                'AcaShopBundle:ProductsForm:products-form.html.twig',
                array(
                    'product_id' => $product_id,
                    'name' => $name,
                    'description' => $description,
                    'image' => $image,
                    'category' => $category,
                    'price' => $price,
                    'date_added' => $date_added
                )

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