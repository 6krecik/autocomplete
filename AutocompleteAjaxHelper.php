<?php
class AutocompleteAjaxHelper extends AutocompleteAjaxHelperDb
{
    public function getAjax($object, $function, $fieldName , $fieldId)
    {
        if (!defined('_PS_ADMIN_DIR_')) {
            define('_PS_ADMIN_DIR_', getcwd());
        }

        $query = Tools::getValue('q', false);
        if (!$query or $query == '' or strlen($query) < 1) {
            die();
        }

        if ($pos = strpos($query, ' (ref:')) {
            $query = substr($query, 0, $pos);
        }

        $excludeIds = Tools::getValue('excludeIds', false);
        if ($excludeIds && $excludeIds != 'NaN') {
            $excludeIds = implode(',', array_map('intval', explode(',', $excludeIds)));
        } else {
            $excludeIds = '';
        }

        if(is_callable([$object, $function])){
            $items = $object->$function($query, $excludeIds);
            if (!empty($items)) {
                foreach ($items as $item) {
                    echo trim($item[$fieldName]).'|'.(int)($item[$fieldId])."\n";
                }
                die();
            }
        }
        Tools::jsonEncode(new stdClass);
    }

    public function getAjaxProducts()
    {
        $this->getAjax($this, 'getProductsAutocomplete', 'name', 'id_product');
    }

    public function getAjaxCategory()
    {
        $this->getAjax($this, 'getCategoriesAutocomplete', 'name', 'id_category');
    }



}