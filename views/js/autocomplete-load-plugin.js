function loadPlugin(pluginJS, pluginCSS) {
    if(!jQuery().autocomplete) {
        $('body').append('<script src="'+ pluginJS +'"></script>');
        $('body').append('<link rel="stylesheet" href="'+ pluginCSS +'" type="text/css" media="all" />');
    }
}