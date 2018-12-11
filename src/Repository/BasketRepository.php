<?php

namespace App\Repository;

use App\Entity\Product;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class BasketRepository
{
    private const SESSION_BASKET_KEY = 'basket';

    public const KEY_PRODUCT_ID = 'id';
    public const KEY_PRODUCT_NAME = 'name';
    public const KEY_PRODUCT_PRICE = 'price';
    public const KEY_PRODUCT_AMOUNT = 'amount';

    /** @var SessionInterface */
    private $session;

    public function __construct(SessionInterface $session)
    {
        $this->session = $session;
    }

    public function addProductToBasket(Product $product): void
    {
        $basket = $this->getBasket();

        if (!isset($basket[$product->getId()])) {
            $this->updateProductInBasket($product, 1);
        }
    }

    public function updateProductInBasket(Product $product, int $amount): void
    {
        $basket = $this->getBasket();

        if ($amount <= 0) {
            unset($basket[$product->getId()]);
        } else {
            $basket[$product->getId()] = [
                self::KEY_PRODUCT_ID => $product->getId(),
                self::KEY_PRODUCT_NAME => $product->getName(),
                self::KEY_PRODUCT_PRICE => $product->getPrice(),
                self::KEY_PRODUCT_AMOUNT => $amount,
            ];
        }

        $this->setBasket($basket);
    }

    public function clear(): void
    {
        $this->setBasket([]);
    }

    public function getBasket(): array
    {
        return $this->session->get(self::SESSION_BASKET_KEY, []);
    }

    private function setBasket(array $basket): void
    {
        $this->session->set(self::SESSION_BASKET_KEY, $basket);
    }
}
