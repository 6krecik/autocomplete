{if isset($autocompletes) && $autocompletes }
    <script src="{if isset($src) && $src}{$src}{/if}"></script>
    <script>window['Autocompleate'] = [];</script>
    {foreach from=$autocompletes item=autocomplete}
<div class="">
    {if isset($autocomplete.label) && $autocomplete.label}
    <label class="control-label">
            <span class="">
                {$autocomplete.label}
            </span>
    </label>
    {/if}
    <input name="inputAccessories-{$autocomplete.prefix}{$autocomplete.name}" id="inputAccessories-{$autocomplete.prefix}{$autocomplete.name}" value="{if isset($autocomplete.attributes) && $autocomplete.attributes}{foreach from=$autocomplete.attributes item=attribute}{$attribute.id}-{/foreach}{else}{/if}" type="hidden">
    <input name="nameAccessories-{$autocomplete.prefix}{$autocomplete.name}" id="nameAccessories-{$autocomplete.prefix}{$autocomplete.name}" value="{if isset($autocomplete.attributes) && $autocomplete.attributes}{foreach from=$autocomplete.attributes item=attribute}{$attribute.name}Ã‚Â¤{/foreach}{else}{/if}" type="hidden">
    <div id="ajax_choose_{$autocomplete.prefix}{$autocomplete.name}">
        <div class="input-group">
            <input class="aut" id="autocomplete-input-{$autocomplete.prefix}{$autocomplete.name}" name="autocomplete-input-{$autocomplete.prefix}{$autocomplete.name}" autocomplete="off" class="ac_input" type="text">
            <span class="input-group-addon"><i class="icon-search"></i></span>
        </div>
    </div>
    <div id="divAccessories-{$autocomplete.prefix}{$autocomplete.name}">
        {if isset($autocomplete.attributes) && $autocomplete.attributes}
            {foreach from=$autocomplete.attributes item=attribute}
                <div class="form-control-static">
                    <button type="button" class="delAccessory btn btn-default" name="{$attribute.id}">
                        <i class="icon-remove text-danger"></i>
                    </button>&nbsp;{$attribute.name}
                </div>
            {/foreach}
        {/if}
    </div>
    <script>
        window['Autocompleate'].push(new AutocompleteManagement('{$autocomplete.prefix}{$autocomplete.name}', '{$autocomplete.url}', '{$autocomplete.limit}') )
    </script>


</div>
    {/foreach}
{/if}

