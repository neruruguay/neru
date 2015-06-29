<?php $GID = 'Demo' . md5(rand(54, 9595)); ?>
<div id="DemoListTemplate" class="Template<?php echo $GID ?>" style="display: none;">
    <div class="Demo">
        <div class="Imagen left">
            <a href="[URL]">
                <img src="[Imagen]" title=""/>
            </a>
        </div>
        <div class="Contenido">
            <h3>[Titulo]</h3>
            <span>[datePost] - ID: [ID]</span>
            <p>[Contenido]</p>
            <a class="Email" href="mailto:[Email]" title="Contactenos">[Email]</a>
            <div class="clear"></div>
        </div>
    </div>
</div>
<div id="DemoList" class="Render<?php echo $GID ?>"></div>
<script type="text/javascript">

    $.ajax({
        dataType: "json",
        url: "/_Service_/p/Lists/getJSON/Demo|ASC|datePost|5|null|null",
        cache: true
    }).done(function(data) {
        $.map(data, function(item, index) {

            var reps = {
                "[ID]": item.ID,
                "[IDLists]": item.IDLists,
                "[RecycleBin]": item.RecycleBin,
                "[Position]": item.Position,
                "[datePost]": item.datePost,
                "[Titulo]": item.Titulo,
                "[Contenido]": item.Contenido,
                "[Imagen]": item.Imagen,
                "[URL]": item.Url,
                "[Email]": item.Email
            };
            var itemhtml = $(".Template<?php echo $GID ?>").html();

            for (var val in reps) {
                itemhtml = itemhtml.split(val).join(reps[val]);
            }
            $(".Render<?php echo $GID ?>").append(itemhtml);

        });

    });

</script>