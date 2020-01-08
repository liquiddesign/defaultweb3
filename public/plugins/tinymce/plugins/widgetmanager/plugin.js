tinymce.PluginManager.add('widgetmanager', function(editor) {
    function showDialog() {
        editor.windowManager.open({
            title: "Přidat widget",
            width: 600,
            height: 410,
            url: pub_url + '/plugins/tinymce/plugins/widgetmanager/dialog.php',
            onSubmit: function() {
            }
        });
    }
    editor.addButton('widgetmanager', {
        icon: 'awesome fas fa-map',
        tooltip: 'Přidat widget',
        onclick: showDialog
    });
});