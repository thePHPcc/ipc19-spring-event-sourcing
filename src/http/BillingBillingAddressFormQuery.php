<?php declare(strict_types=1);

namespace Eventsourcing;
use Slim\Http\Response;

class BillingAddressFormQuery
{
   /**
     * @var Session
     */
    private $session;

    public function __construct(Session $session)
    {
        $this->session = $session;
    }

    public function execute(Response $response) {
        if (!$this->session->hasCheckoutId()) {
            return $response->withRedirect('/');
        }

        $id = $this->session->getId();
        $renderer = new \Slim\Views\PhpRenderer(__DIR__ . '/templates');
        $data = [
            'cartItemList' => file_get_contents(__DIR__ . '/../../var/projections/cartItems_' . $id->asString() . '.html')
        ];
        return $renderer->render($response, 'address.phtml', $data);
    }

}
