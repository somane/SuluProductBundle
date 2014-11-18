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
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class TemplateController extends Controller
{
    /**
     * Returns Template for product list
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function productListAction()
    {
        return $this->render('SuluProductBundle:Template:product.list.html.twig');
    }

    /**
     * Returns Template for product list
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function productFormAction()
    {
        // TODO use correct language
        $language = 'en';

        $status = $this->getStatus($language);
        $units = $this->getUnits($language);

        return $this->render(
            'SuluProductBundle:Template:product.form.html.twig',
            array(
                'status' => $status,
                'units' => $units
            )
        );
    }

    public function productVariantsAction()
    {
        return $this->render('SuluProductBundle:Template:product.variants.html.twig');
    }

    /**
     * Returns Template for product import
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function productImportAction()
    {
        return $this->render(
            'SuluProductBundle:Template:product.import.html.twig'
        );
    }

    /**
     * Returns Template for attribute list
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function attributeListAction()
    {
        return $this->render(
            'SuluProductBundle:Template:attribute.list.html.twig'
        );
    }

    /**
     * Returns Template for attribute list
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function attributeFormAction()
    {
        $repository = $this->getDoctrine()
            ->getRepository('SuluProductBundle:AttributeType');
        $types = $repository->findAll();

        $attributeTypes = array();
        foreach ($types as $type) {
            $attributeTypes[] = array(
                'id'=>$type->getId(),
                'name'=>$type->getName()
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
     * Returns Template for product pricing
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function productPricingAction()
    {
        /** @var TaxClass[] $taxClasses */
        $taxClasses = $this->get('sulu_product.tax_class_manager')->findAll('en');

        $taxClassTitles = array();
        foreach ($taxClasses as $taxClass) {
            $taxClassTitles[] = array(
                'id' => $taxClass->getId(),
                'name' => $taxClass->getName()
            );
        }

        return $this->render(
            'SuluProductBundle:Template:product.pricing.html.twig',
            array('taxClasses' => $taxClassTitles)
        );
    }

    /**
     * Returns the template for product documents
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function productDocumentsAction()
    {
        return $this->render('SuluProductBundle:Template:product.documents.html.twig');
    }

    /**
     * Returns status for products
     *
     * @param $language
     * @return array
     */
    private function getStatus($language)
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
     * Returns units
     *
     * @param $language
     * @return array
     */
    private function getUnits($language)
    {
        /** @var Status[] $units */
        $units = $this->get('sulu_product.unit_manager')->findAll($language);

        $unitTitles = array();
        foreach ($units as $status) {
            $unitTitles[] = array(
                'id' => $status->getId(),
                'name' => $status->getName()
            );
        }

        return $unitTitles;
    }
}
