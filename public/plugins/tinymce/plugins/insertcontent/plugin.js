tinymce.PluginManager.add('insertcontent', function(editor) {
    function showDialog() {
        editor.windowManager.open({
            title: "Vložit obsah",
            name: "asd",
            width: 600,
            height: 410,
            url: pub_url + '/plugins/tinymce/plugins/insertcontent/dialog.php',
            onSubmit: function() {
            },
        });
    }
    editor.addButton('insertcontent', {
        icon: 'awesome fas fa-language',
        tooltip: 'Vložit obsah',
        onclick: showDialog
    });
});