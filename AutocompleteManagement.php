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
    protected $div = false;
    protected $form = ['flag' => false, 'src' => '', 'ajax' => 'false'];
    protected $name = 'autocomplete';
    protected $srcs = [];
    protected $mainUrl = '';


    public function __construct($prefix = '')
    {
        $this->mainUrl = str_replace($_SERVER['DOCUMENT_ROOT'],'',dirname(__FILE__)).'/';
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

    public function setDiv($flag, $name = null)
    {
        $this->name = $name? $name : $this->name;
        $this->div = $flag;
    }

    public function setForm($flag, $src, $ajax = false, $name = 'save')
    {
        $this->form['flag'] = $flag;
        $this->form['src'] = $src;
        $this->form['ajax'] = $ajax;
        $this->form['name'] = $name;
    }

    public function generateAutocomplete()
    {
        $this->addSrc('views/js/autocomplete.js');
        $this->addSrc('views/js/autocomplete-ajaxform.js');


       $this->context->smarty->assign(array(
           'autocompletes' => $this->autocompletes,
           'srcs' => $this->srcs,
           'div' => $this->div,
           'name' => $this->name,
           'form' => $this->form,
        ));


        return Context::getContext()->smarty->fetch(dirname(__FILE__).'/views/autocomplete.tpl');

    }

    protected function addSrc($src)
    {
        $this->srcs[] = $this->mainUrl.$src;
    }

    public static function trimName($name)
    {
        return str_replace(' ', '-', $name);
    }
}