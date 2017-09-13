<?php
/**
 * Created by PhpStorm.
 * User: rkorus
 * Date: 28.08.17
 * Time: 14:23
 */
class AutocompleteManagement
{
    protected $autocompletes = array();
    protected $prefix = '';
    protected $context;

    public function __construct($prefix = '')
    {
        $this->prefix = $prefix;
        $this->context = Context::getContext();
    }

    public function addAutocomplete($name, $url, $label = '', $attributes = array(), $limit = 0)
    {
        if(!$this->checkAtrributes($attributes)){
            return false;
        }
        $name = $this->trimName($name);

        $this->autocompletes[$name] =
            array(
                'name' => $name,
                'label' => $label,
                'attributes' => $attributes,
                'prefix' => $this->prefix.'-',
                'url' => $url,
                'limit' => $limit,
            );
    }


    private function checkAtrributes($attributes)
    {
        if(empty($attributes)){
            return true;
        }

        $flag = true;
        if(is_array($attributes)){
            foreach ($attributes as $attribute){
                if(!is_array($attribute)){
                    return false;
//todo do dopracowania z widokiem    return count(array_intersect_key(array('id' => 1, 'name' => 1), $attributes)) == 2;
                }else{
                  $flag = count(array_intersect_key(array('id' => 1, 'name' => 1), $attribute)) == 2 && $flag;
                }
                if(!$flag){
                    return false;
                }
            }
            return true;
        }

        return false;
    }

    public function removeAutocomplete($name)
    {
        $name = $this->trimName($name);
        unset($this->autocompletes[$name]);
    }

    public function generateAutocomplete()
    {
        $link = str_replace($_SERVER['DOCUMENT_ROOT'],'',dirname(__FILE__));
        $link .= '/views/js/autocomplete.js';


       $this->context->smarty->assign(array(
           'autocompletes' => $this->autocompletes,
           'src' => $link,
        ));


        return Context::getContext()->smarty->fetch(dirname(__FILE__).'/views/autocomplete.tpl');

    }

    public static function trimName($name)
    {
        return str_replace(' ', '-', $name);
    }
}