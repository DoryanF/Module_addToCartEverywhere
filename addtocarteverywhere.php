<?php
/**
 * Copyright since 2007 PrestaShop SA and Contributors
 * PrestaShop is an International Registered Trademark & Property of PrestaShop SA
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License 3.0 (AFL-3.0)
 * that is bundled with this package in the file LICENSE.md.
 * It is also available through the world-wide-web at this URL:
 * https://opensource.org/licenses/AFL-3.0
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@prestashop.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade PrestaShop to newer
 * versions in the future. If you wish to customize PrestaShop for your
 * needs please refer to https://devdocs.prestashop.com/ for more information.
 *
 * @author    PrestaShop SA and Contributors <contact@prestashop.com>
 * @copyright Since 2007 PrestaShop SA and Contributors
 * @license   https://opensource.org/licenses/AFL-3.0 Academic Free License 3.0 (AFL-3.0)
 */

if (!defined('_PS_VERSION_')) {
    exit;
}

class AddToCartEverywhere extends Module
{
    public function __construct()
    {
        $this->name = 'addtocarteverywhere';
        $this->tab = 'front_office_features';
        $this->version = '1.0.0';
        $this->author = 'Doryan Fourrichon';
        $this->ps_versions_compliancy = [
            'min' => '1.6',
            'max' => _PS_VERSION_
        ];
        
        //récupération du fonctionnement du constructeur de la méthode __construct de Module
        parent::__construct();
        $this->bootstrap = true;

        $this->displayName = $this->l('Add To Cart Everywhere');
        $this->description = $this->l('Ajout d\'un bouton ajout au panier sur tous les produits');

        $this->confirmUninstall = $this->l('Do you want to delete this module');
    }

    public function install()
    {
        if (!parent::install() ||
        !Configuration::updateValue('CATEGORIEBUTTON', 0) ||
        !Configuration::updateValue('SEARCHBUTTON', 0) ||
        !Configuration::updateValue('POPULAIRESBUTTON', 0) ||
        !Configuration::updateValue('RELATEDBUTTON', 0) ||
        !Configuration::updateValue('QUANTITYBUTTON', 0) ||
        !Configuration::updateValue('ADDTOCART', 'ADD TO CART') ||
        !Configuration::updateValue('COLORTEXT', '#000000') ||
        !Configuration::updateValue('COLORBACKGROUND', '#00ced1') ||
        !Configuration::updateValue('COLORHOVER', '#00ced1') ||
        !$this->registerHook('displayProductListReviews') ||
        !$this->registerHook('displayHeader')
        ) {
            return false;
        }
            return true;
    }

    public function uninstall()
    {
        if (!parent::uninstall() ||
        !Configuration::deleteByName('CATEGORIEBUTTON') ||
        !Configuration::deleteByName('SEARCHBUTTON') ||
        !Configuration::deleteByName('POPULAIRESBUTTON') ||
        !Configuration::deleteByName('RELATEDBUTTON') ||
        !Configuration::deleteByName('QUANTITYBUTTON') ||
        !Configuration::deleteByName('ADDTOCART') ||
        !Configuration::deleteByName('COLORTEXT') ||
        !Configuration::deleteByName('COLORBACKGROUND') ||
        !Configuration::deleteByName('COLORHOVER') ||
        !$this->unregisterHook('displayProductListReviews') ||
        !$this->unregisterHook('displayHeader')
        ) {
            return false;
        }
            return true;
    }

    public function getContent()
    {
        return $this->postProcess().$this->renderForm();
    }

    public function postProcess()
    {
        if(Tools::isSubmit('saving'))
        {
            if(Validate::isBool(Tools::getValue('CATEGORIEBUTTON')) || Validate::isBool(Tools::getValue('SEARCHBUTTON')) 
            || Validate::isBool(Tools::getValue('POPULAIRESBUTTON')) || Validate::isBool(Tools::getValue('RELATEDBUTTON'))
            || Validate::isBool(Tools::getValue('QUANTITYBUTTON')) || Validate::isGenericName(Tools::getValue('ADDTOCART'))
            || Validate::isColor(Tools::getValue('COLORTEXT')) || Validate::isColor(Tools::getValue('COLORBACKGROUND'))
            || Validate::isColor(Tools::getValue('COLORHOVER'))
            )
            {
                Configuration::updateValue('CATEGORIEBUTTON',Tools::getValue('CATEGORIEBUTTON'));
                Configuration::updateValue('SEARCHBUTTON', Tools::getValue('SEARCHBUTTON'));
                Configuration::updateValue('POPULAIRESBUTTON', Tools::getValue('POPULAIRESBUTTON'));
                Configuration::updateValue('RELATEDBUTTON', Tools::getValue('RELATEDBUTTON'));
                Configuration::updateValue('QUANTITYBUTTON', Tools::getValue('QUANTITYBUTTON'));
                Configuration::updateValue('ADDTOCART', Tools::getValue('ADDTOCART'));
                Configuration::updateValue('COLORTEXT', Tools::getValue('COLORTEXT'));
                Configuration::updateValue('COLORBACKGROUND', Tools::getValue('COLORBACKGROUND'));
                Configuration::updateValue('COLORHOVER', Tools::getValue('COLORHOVER'));


                return $this->displayConfirmation('Bien enregistré !');
            }

                return $this->displayError('Erreur quelque part');
        }
    }


    public function renderForm()
    {
        $field_form[0]['form'] = [
            'legend' => [
                'title' => $this->l('Setings'),
            ],
            'input' => [
                [
                    'type' => 'switch',
                        'label' => $this->l('Display button categories page'),
                        'name' => 'CATEGORIEBUTTON',
                        'is_bool' => true,
                        'values' => array(
                            array(
                                'id' => 'label2_on',
                                'value' => 1,
                                'label' => $this->l('Oui')
                            ),
                            array(
                                'id' => 'label2_off',
                                'value' => 0,
                                'label' => $this->l('Non')
                            )
                        )
                ],
                [
                    'type' => 'switch',
                        'label' => $this->l('Display button research page'),
                        'name' => 'SEARCHBUTTON',
                        'is_bool' => true,
                        'values' => array(
                            array(
                                'id' => 'label2_on',
                                'value' => 1,
                                'label' => $this->l('Oui')
                            ),
                            array(
                                'id' => 'label2_off',
                                'value' => 0,
                                'label' => $this->l('Non')
                            )
                        )
                ],
                [
                    'type' => 'switch',
                        'label' => $this->l('Display button populaire products'),
                        'name' => 'POPULAIRESBUTTON',
                        'is_bool' => true,
                        'values' => array(
                            array(
                                'id' => 'label2_on',
                                'value' => 1,
                                'label' => $this->l('Oui')
                            ),
                            array(
                                'id' => 'label2_off',
                                'value' => 0,
                                'label' => $this->l('Non')
                            )
                        )
                ],
                [
                    'type' => 'switch',
                        'label' => $this->l('Display button related products'),
                        'name' => 'RELATEDBUTTON',
                        'is_bool' => true,
                        'values' => array(
                            array(
                                'id' => 'label2_on',
                                'value' => 1,
                                'label' => $this->l('Oui')
                            ),
                            array(
                                'id' => 'label2_off',
                                'value' => 0,
                                'label' => $this->l('Non')
                            )
                        )
                ],
                [
                    'type' => 'switch',
                        'label' => $this->l('Active quantity button'),
                        'name' => 'QUANTITYBUTTON',
                        'is_bool' => true,
                        'values' => array(
                            array(
                                'id' => 'label2_on',
                                'value' => 1,
                                'label' => $this->l('Oui')
                            ),
                            array(
                                'id' => 'label2_off',
                                'value' => 0,
                                'label' => $this->l('Non')
                            )
                        )
                ],
                [
                    "type" => "text",
                    'label' => $this->l('Text for button'),
                    'name' => 'ADDTOCART',
                    'required' => true,
                ],
                [
                    'type' => 'color',
                    'label' => $this->l('choose your text color'),
                    'name' => 'COLORTEXT'
                ],
                [
                    'type' => 'color',
                    'label' => $this->l('choose your background color'),
                    'name' => 'COLORBACKGROUND'
                ],
                [
                    'type' => 'color',
                    'label' => $this->l('choose your color hover'),
                    'name' => 'COLORHOVER'
                ],
            ],
            'submit' => [
                'title' => $this->l('save'),
                'class' => 'btn btn-primary',
                'name' => 'saving'
            ]
        ];

        $helper = new HelperForm();
        $helper->module  = $this;
        $helper->name_controller = $this->name;
        $helper->currentIndex = $this->context->link->getAdminLink('AdminModules', false).'&configure='.$this->name.'&tab_module='.$this->tab.'&module_name='.$this->name;
        $helper->token = Tools::getAdminTokenLite('AdminModules');

        $helper->fields_value['CATEGORIEBUTTON'] = Configuration::get('CATEGORIEBUTTON');
        $helper->fields_value['SEARCHBUTTON'] = Configuration::get('SEARCHBUTTON');
        $helper->fields_value['POPULAIRESBUTTON'] = Configuration::get('POPULAIRESBUTTON');
        $helper->fields_value['RELATEDBUTTON'] = Configuration::get('RELATEDBUTTON');
        $helper->fields_value['QUANTITYBUTTON'] = Configuration::get('QUANTITYBUTTON');
        $helper->fields_value['ADDTOCART'] = Configuration::get('ADDTOCART');
        $helper->fields_value['COLORTEXT'] = Configuration::get('COLORTEXT');
        $helper->fields_value['COLORBACKGROUND'] = Configuration::get('COLORBACKGROUND');
        $helper->fields_value['COLORHOVER'] = Configuration::get('COLORHOVER');

        return $helper->generateForm($field_form);
    }

    public function hookDisplayProductListReviews($params)
    {

        $links = new Link();
        // dump(Context::getContext()->controller);

        if (Configuration::get('POPULAIRESBUTTON') == 1 && Context::getContext()->controller->php_self == 'index') {
            
            $this->smarty->assign(
                array(
                    'context' => Context::getContext()->controller,
                    'btnDisplayQuantity' => Configuration::get('QUANTITYBUTTON'),
                    'btnText' => Configuration::get('ADDTOCART'),
                    'btnColorText' => Configuration::get('COLORTEXT'),
                    'btnColorBackground' => Configuration::get('COLORBACKGROUND'),
                    'btnColorHover' => Configuration::get('COLORHOVER'),
                    'product' => $params["product"],
                    'links' => $links
                )
            );
    
            return $this->display(__FILE__, '/views/templates/hook/addtocart.tpl');
        }

        if(Configuration::get('RELATEDBUTTON') == 1)
        {
            $this->smarty->assign(
                array(
                    'context' => Context::getContext()->controller,
                    'btnDisplayQuantity' => Configuration::get('QUANTITYBUTTON'),
                    'btnText' => Configuration::get('ADDTOCART'),
                    'btnColorText' => Configuration::get('COLORTEXT'),
                    'btnColorBackground' => Configuration::get('COLORBACKGROUND'),
                    'btnColorHover' => Configuration::get('COLORHOVER'),
                    'product' => $params["product"],
                    'links' => $links
                )
            );
    
            return $this->display(__FILE__, '/views/templates/hook/addtocart.tpl');
        }


        if(Configuration::get('CATEGORIEBUTTON') == 1 && Context::getContext()->controller->php_self == 'category')
        {
            $this->smarty->assign(
                array(
                    'context' => Context::getContext()->controller,
                    'btnDisplayQuantity' => Configuration::get('QUANTITYBUTTON'),
                    'btnText' => Configuration::get('ADDTOCART'),
                    'btnColorText' => Configuration::get('COLORTEXT'),
                    'btnColorBackground' => Configuration::get('COLORBACKGROUND'),
                    'btnColorHover' => Configuration::get('COLORHOVER'),
                    'product' => $params["product"],
                    'links' => $links
                )
            );
    
            return $this->display(__FILE__, '/views/templates/hook/addtocart.tpl');
        }
        
        if(Configuration::get('SEARCHBUTTON') == 1 && Context::getContext()->controller->php_self == 'search')
        {
            $this->smarty->assign(
                array(
                    'context' => Context::getContext()->controller,
                    'btnDisplayQuantity' => Configuration::get('QUANTITYBUTTON'),
                    'btnText' => Configuration::get('ADDTOCART'),
                    'btnColorText' => Configuration::get('COLORTEXT'),
                    'btnColorBackground' => Configuration::get('COLORBACKGROUND'),
                    'btnColorHover' => Configuration::get('COLORHOVER'),
                    'product' => $params["product"],
                    'links' => $links
                )
            );
    
            return $this->display(__FILE__, '/views/templates/hook/addtocart.tpl');
        }

        

    }

    public function hookDisplayHeader()
    {
        // dump($this->context);
        $this->context->controller->registerStylesheet('css-hovercarousel','modules/addtocarteverywhere/views/css/style.css');
    }

}