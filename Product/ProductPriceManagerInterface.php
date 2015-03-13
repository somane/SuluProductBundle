<?php
/*
 * This file is part of the Sulu CMS.
 *
 * (c) MASSIVE ART WebServices GmbH
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Sulu\Bundle\ProductBundle\Product;

use Sulu\Bundle\ProductBundle\Entity\ProductInterface;

interface ProductPriceManagerInterface
{
    /**
     * Returns the bulk price for a certain quantity of the product by a given currency
     *
     * @param ProductInterface $product
     * @param $quantity
     * @param null $currency
     *
     * @return null|\Sulu\Bundle\ProductBundle\Entity\ProductPrice
     */
    public function getBulkPriceForCurrency(ProductInterface $product, $quantity, $currency = null);

    /**
     * Returns the base prices for the product by a given currency
     *
     * @param ProductInterface $product
     * @param null $currency
     *
     * @return null|\Sulu\Bundle\ProductBundle\Entity\ProductPrice
     */
    public function getBasePriceForCurrency(ProductInterface $product, $currency = null);

    /**
     * Helper function to get a formatted price for a given currency and locale
     *
     * @param Integer $price
     * @param String $symbol
     * @param String $locale
     *
     * @return String price
     */
    public function getFormattedPrice($price, $symbol = 'EUR', $locale = 'de');
}