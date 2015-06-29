<div id="IMG"></div>
<div id="UploadBtn">
    <noscript>
    <p>Lo sentimos, para cargar el archivo es necesario tener java activado en su navegador.<br />
        Recomendamos como navegador: IExplorer > 8, Firefox o Chrome.</p>
    </noscript>
</div>
<script>
    function Name() {
        var name = $('#Form_Templates #Title').val();
        var rand = Math.floor((Math.random() * 10000000) + 1);
        return name + rand;
    }
    /* ----------------------------- UPLOAD DOC --------------------------------------------------*/
    var Upload = new qq.FileUploader({
        element: document.getElementById('UploadBtn'),
        action: URL_VERSION + '/CRUD/ViewEditElementsAsList/Lists/Templates/Upload/Handler.php?Name=' + Name(),
        multiple: false,
        sizeLimit: 1024000,
        allowedExtensions: ['jpg', 'gif', 'png'],
        onComplete: function(id, fileName, responseJSON) {
            $('#Form_Templates #UploadBtn .qq-upload-list').html('');
            $("#Form_Templates #IMG").html('<img src="./_FileSystems/CodeSnippets_Preview/' + responseJSON["filename"] + '?r=' + Math.floor(Math.random() * 4) + '" alt="" style="max-height:350px;" />');
            $("#Form_Templates #Image").val(responseJSON["filename"]);
        }
    });
</script>