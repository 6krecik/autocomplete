

function AutocompleteManagement(suffix, url, limit) {
    this.excluded = 0;
    this.suffix = '-'+suffix;
    this.url = url;
    this.limit = limit;
    this.counter= $('#divAccessories'+this.suffix+' > div').length;
    var _this = this;

    _this.init = function(suffix, url){
        _this.checkCounter();
        _this.initAccessoriesAutocomplete();

        $(document).on('click', '#divAccessories'+_this.suffix+' .delAccessory', function() {

            _this.delAccessory($(this).attr('name'));
        });
    }

    _this.initAccessoriesAutocomplete = function(){
        $('#autocomplete-input'+_this.suffix)
        // .autocomplete('ajax_products_list.php?exclude_packs=0&excludeVirtuals=0', {
            .autocomplete(_this.url+'&exclude_packs=0&excludeVirtuals=0', {
                minChars: 1,
                autoFill: true,
                max:20,
                matchContains: true,
                mustMatch:false,
                scroll:false,
                cacheLength:0,
                formatItem: function(item) {
                    return item[1]+' - '+item[0];
                }
            }).result(this.addAccessory);
        $('#autocomplete-input'+_this.suffix).setOptions({
            extraParams: {
                excludeIds : _this.getAccessoriesIds()
            }
        });
    }

    _this.addAccessory = function(event, data, formatted){
        _this.counter++;
        _this.checkCounter();
        if (data == null)
            return false;
        var productId = data[1];
        var productName = data[0];
        var $divAccessories = $('#divAccessories'+_this.suffix);
        var $inputAccessories = $('#inputAccessories'+_this.suffix);
        var $nameAccessories = $('#nameAccessories'+_this.suffix);

        /* delete product from select + add product line to the div, input_name, input_ids elements */
        $divAccessories.html($divAccessories.html() + '<div class="form-control-static"><button type="button" class="delAccessory btn btn-default" name="' + productId + '"><i class="icon-remove text-danger"></i></button>&nbsp;'+ productName +'</div>');
        $nameAccessories.val($nameAccessories.val() + productName + 'Ã‚Â¤');
        $inputAccessories.val($inputAccessories.val() + productId + '-');
        $('#autocomplete-input'+_this.suffix).val('');
        $('#autocomplete-input'+_this.suffix).setOptions({
            extraParams: {
                excludeIds : _this.getAccessoriesIds()
            }
        });
    }

    _this.getAccessoriesIds = function(){
        if ($('#inputAccessories'+this.suffix).val() === undefined)
            return _this.excluded;
        return _this.excluded + ',' + $('#inputAccessories'+_this.suffix).val().replace(/\-/g,',');
    }

    _this.delAccessory = function(id){
        var div = getE('divAccessories'+_this.suffix);
        var input = getE('inputAccessories'+_this.suffix);
        var name = getE('nameAccessories'+_this.suffix);

        // Cut hidden fields in array
        var inputCut = input.value.split('-');
        var nameCut = name.value.split('Ã‚Â¤');

        if (inputCut.length != nameCut.length)
            return jAlert('Bad size');

        // Reset all hidden fields
        input.value = '';
        name.value = '';
        div.innerHTML = '';
        for (i in inputCut)
        {
            // If empty, error, next
            if (!inputCut[i] || !nameCut[i])
                continue ;

            // Add to hidden fields no selected products OR add to select field selected product
            if (inputCut[i] != id)
            {
                input.value += inputCut[i] + '-';
                name.value += nameCut[i] + 'Ã‚Â¤';
                div.innerHTML += '<div class="form-control-static"><button type="button" class="delAccessory btn btn-default" name="' + inputCut[i] +'"><i class="icon-remove text-danger"></i></button>&nbsp;' + nameCut[i] + '</div>';
            }
            else
                $('#selectAccessories'+_this.suffix).append('<option selected="selected" value="' + inputCut[i] + '-' + nameCut[i] + '">' + inputCut[i] + ' - ' + nameCut[i] + '</option>');
        }

        $('#autocomplete-input'+_this.suffix).setOptions({
            extraParams: {
                excludeIds : _this.getAccessoriesIds()
            }                });

        _this.counter--;
        _this.checkCounter();
    }

    _this.checkCounter = function(){
        console.log(_this.limit);
        console.log(_this.counter);
        if(0 != _this.limit){
            if (_this.counter >= _this.limit) {
                $('#autocomplete-input'+_this.suffix).attr('disabled', 'disabled');
            }
            if (_this.counter < _this.limit) {
                $('#autocomplete-input'+_this.suffix).removeAttr("disabled");
            }
        }
    }

    _this.init(suffix, url);
}

