{if isset($autocompletes) && $autocompletes }
    {if isset($srcs) && $srcs}
        {foreach from=$srcs item=src}
            <script src="{$src}"></script>
        {/foreach}
    {/if}
    <script>
        var PLUGINJS = '{$PLUGINJS|escape:'htmlall':'UTF-8'}';
        var PLUGINCSS = '{$PLUGINCSS|escape:'htmlall':'UTF-8'}';
        loadPlugin(PLUGINJS, PLUGINCSS);
        window['Autocompleate'] = [];
    </script>
    <div class="{if $div}panel{/if}">
    {*form*}
    {if isset($form) && $form.flag === true && !$form.ajax}
        <form class="autocomplete-form {if $form.ajax}autocomplete-ajax{/if}" action="{$form.src}" method="post">
    {/if}
    {*div*}
    {if $div && $name}
        <div class="panel-heading">
            {$name}
        </div>
    {/if}
    {*/div*}
    {foreach from=$autocompletes item=autocomplete}
<div class="">
    {if isset($autocomplete.label) && $autocomplete.label}
    <label class="control-label">
            <span class="">
                {$autocomplete.label}
            </span>
    </label>
    {/if}
    <input name="inputAccessories-{$autocomplete.prefix}{$autocomplete.name}" class="autocomplete-input-form" id="inputAccessories-{$autocomplete.prefix}{$autocomplete.name}" value="{if isset($autocomplete.attributes) && $autocomplete.attributes}{foreach from=$autocomplete.attributes item=attribute}{$attribute.id}-{/foreach}{else}{/if}" type="hidden">
    <input name="nameAccessories-{$autocomplete.prefix}{$autocomplete.name}" class="autocomplete-input-form" id="nameAccessories-{$autocomplete.prefix}{$autocomplete.name}" value="{if isset($autocomplete.attributes) && $autocomplete.attributes}{foreach from=$autocomplete.attributes item=attribute}{$attribute.name}Ã‚Â¤{/foreach}{else}{/if}" type="hidden">
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
                    </button>{$attribute.name}
                </div>
            {/foreach}
        {/if}
    </div>
    <script>
        window['Autocompleate'].push(new AutocompleteManagement('{$autocomplete.prefix}{$autocomplete.name}', '{$autocomplete.url}', '{$autocomplete.limit}') )
    </script>

</div>
    {/foreach}
            {*/form*}
    {if isset($form) && $form.flag === true && $form.ajax}
        <br>
        <button type="button" data-link="{$form.src}" id="autocomplete-save-form">
            <i class="">{$form.name}</i>
        </button>
    {elseif isset($form) && $form.flag === true && !$form.ajax}
            <input value="{$form.name}" type="submit">
        </form>
    {/if}
</div>
{/if}

