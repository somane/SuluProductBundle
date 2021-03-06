<?php
/*
 * This file is part of the Sulu CMS.
 *
 * (c) MASSIVE ART WebServices GmbH
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Sulu\Bundle\ProductBundle\Controller;

use Sulu\Bundle\ProductBundle\Api\Status;
use Sulu\Bundle\ProductBundle\Api\TaxClass;
use Sulu\Bundle\ProductBundle\Entity\Currency;
use Sulu\Bundle\ProductBundle\Product\ProductManager;
use Sulu\Component\Rest\RestController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class TemplateController extends RestController
{
    /**
     * Returns Template for product list.
     *
     * @return Response
     */
    public function productListAction()
    {
        return $this->render('SuluProductBundle:Template:product.list.html.twig');
    }

    /**
     * Returns Template for product list.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function productFormAction(Request $request)
    {
        $language = $this->getLocale($request);

        $status = $this->getStatus($language);
        $units = $this->getUnits($language);
        $deliveryStates = $this->getDeliveryStates($language);

        return $this->render(
            'SuluProductBundle:Template:product.form.html.twig',
            array(
                'MAX_SEARCH_TERMS_LENGTH' => ProductManager::MAX_SEARCH_TERMS_LENGTH,
                'status' => $status,
                'units' => $units,
                'deliveryStates' => $deliveryStates,
            )
        );
    }

    public function productVariantsAction()
    {
        return $this->render('SuluProductBundle:Template:product.variants.html.twig');
    }

    /**
     * Returns Template for product import.
     *
     * @return Response
     */
    public function productImportAction()
    {
        return $this->render(
            'SuluProductBundle:Template:product.import.html.twig'
        );
    }

    /**
     * Returns Template for attribute list.
     *
     * @return Response
     */
    public function attributeListAction()
    {
        return $this->render(
            'SuluProductBundle:Template:attribute.list.html.twig'
        );
    }

    /**
     * Returns Template for attribute list.
     *
     * @return Response
     */
    public function attributeFormAction()
    {
        $repository = $this->getDoctrine()
            ->getRepository('SuluProductBundle:AttributeType');
        $types = $repository->findAll();

        $attributeTypes = array();
        foreach ($types as $type) {
            $attributeTypes[] = array(
                'id' => $type->getId(),
                'name' => $type->getName()
            );
        }

        return $this->render(
            'SuluProductBundle:Template:attribute.form.html.twig',
            array(
                'attribute_types' => $attributeTypes
            )
        );
    }

    /**
     * Returns Template for product pricing.
     *
     * @return Response
     */
    public function productPricingAction(Request $request)
    {
        // TODO use correct language
        $language = $this->getLocale($request);

        /** @var TaxClass[] $taxClasses */
        $taxClasses = $this->get('sulu_product.tax_class_manager')->findAll($language);

        $taxClassTitles = array();
        foreach ($taxClasses as $taxClass) {
            $taxClassTitles[] = array(
                'id' => $taxClass->getId(),
                'name' => $taxClass->getName()
            );
        }

        $currencies = $this->getCurrencies($language);
        $defaultCurrency = $this->container->getParameter('sulu_product.default_currency');

        return $this->render(
            'SuluProductBundle:Template:product.pricing.html.twig',
            array(
                'taxClasses' => $taxClassTitles,
                'currencies' => $currencies,
                'defaultCurrency' => $defaultCurrency
            )
        );
    }

    /**
     * Returns the template for product documents.
     *
     * @return Response
     */
    public function productDocumentsAction()
    {
        return $this->render('SuluProductBundle:Template:product.documents.html.twig');
    }

    /**
     * Returns the template for product attributes.
     *
     * @return Response
     */
    public function productAttributesAction()
    {
        return $this->render('SuluProductBundle:Template:product.attributes.html.twig');
    }

    /**
     * Returns the template for product addons.
     *
     * @return Response
     */
    public function productAddonsAction()
    {
        return $this->render('SuluProductBundle:Template:product.addons.html.twig');
    }

    /**
     * Returns status for products.
     *
     * @param string $language
     *
     * @return array
     */
    protected function getStatus($language)
    {
        /** @var Status[] $statuses */
        $statuses = $this->get('sulu_product.status_manager')->findAll($language);

        $statusTitles = array();
        foreach ($statuses as $status) {
            $statusTitles[] = array(
                'id' => $status->getId(),
                'name' => $status->getName()
            );
        }

        return $statusTitles;
    }

    /**
     * Returns units.
     *
     * @param string $language
     *
     * @return array
     */
    protected function getUnits($language)
    {
        /** @var Status[] $units */
        $units = $this->get('sulu_product.unit_manager')->findAll($language);

        $unitTitles = array();
        foreach ($units as $unit) {
            $unitTitles[] = array(
                'id' => $unit->getId(),
                'name' => $unit->getName()
            );
        }

        return $unitTitles;
    }

    /**
     * Returns currencies.
     *
     * @param string $language
     *
     * @return array
     */
    protected function getCurrencies($language)
    {
        /** @var Currency[] $currencies */
        $currencies = $this->get('sulu_product.currency_manager')->findAll($language);

        $currencyTitles = array();
        foreach ($currencies as $currency) {
            $currencyTitles[] = array(
                'id' => $currency->getId(),
                'name' => $currency->getName(),
                'code' => $currency->getCode(),
                'number' => $currency->getNumber()
            );
        }

        return $currencyTitles;
    }

    /**
     * Returns delivery states.
     *
     * @param string $language
     *
     * @return array
     */
    protected function getDeliveryStates($language)
    {
        $states = $this->getDeliveryStatusManager()->findAll($language);

        $deliveryStates = array();
        foreach ($states as $state) {
            $deliveryStates[] = array(
                'id' => $state->getId(),
                'name' => $state->getName()
            );
        }

        return $deliveryStates;
    }

    /**
     * Returns the delivery status manager.
     *
     * @return DeliveryStatusManager
     */
    private function getDeliveryStatusManager()
    {
        return $this->get('sulu_product.delivery_status_manager');
    }
}
