<?php
/**
 * Created by PhpStorm.
 * User: rkorus
 * Date: 29.08.17
 * Time: 14:53
 */
require_once 'AutocompleteManagement.php';
class AutocompletePost extends AutocompleteManagement
{
    public function getResultFromPost($name = false)
    {
        if(empty($this->autocompletes)){
            return false;
        }
        $result = array();
        foreach ($this->autocompletes as $autocomplete){
            $ids = Tools::getValue('inputAccessories-'.$autocomplete['prefix'].$autocomplete['name']);
            $names = Tools::getValue('nameAccessories-'.$autocomplete['prefix'].$autocomplete['name']);
            if($ids === false){
                return false;
            }
            if($name){
                $result[$autocomplete['name']] = $this->getAutocompletePost($ids, $names);
            }else{
                $result[$autocomplete['name']] = $this->getAutocompletePost($ids);
            }
        }
        return $result;
    }

    private function getAutocompletePost($ids, $names = array())
    {
        if(empty($ids)){
            return array();
        }

       $arrayResult = explode('-', $ids);
       array_pop($arrayResult);

       if(!empty($names)){
           $arrayNames = explode('Ã‚Â¤', $names);
           array_pop($arrayNames);

           if(count($arrayResult) == count($arrayNames)){
               foreach ($arrayResult as $key => $id){
                    $result[] = array('id' => $id, 'name' => $arrayNames[$key]);
               }
               return $result;
           }
       }

       return $arrayResult;
    }

    public function getResultFromPostDiffed()
    {
        $resultPost = $this->getResultFromPost();
        if($resultPost === false){
            return false;
        }
        $result = array();
        foreach ($this->autocompletes as $autocomplete){
            $oldIds = empty($autocomplete['attributes'])? array() : array_column($autocomplete['attributes'], 'value');
            $newIds = $resultPost[$autocomplete['name']];
            $result[$autocomplete['name']]['delete'] = array_diff($oldIds, $newIds);
            $result[$autocomplete['name']]['add'] = array_diff($newIds, $oldIds);
        }

        return $result;

    }



}