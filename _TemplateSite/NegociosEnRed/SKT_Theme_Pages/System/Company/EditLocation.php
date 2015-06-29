<form method="POST" id="UpdateLocation<?php echo $User->id ?>">
    <div class="row">
        <div class="col-md-12"><h4 class="text-color skt-icon-location">Coordenadas del Mapa de ubicaci&oacute;n</h4></div>
        <hr>
        <div class="row hidden-md hidden-sm hidden-xs">
            <div class="col-md-4">
                <label>Latitud</label>
                <input value="<?php echo $User->Lat; ?>" name="Lat" id="latFld" type="text" class="form-control" />
            </div>
            <div class="col-md-4">
                <label>Longitud</label>
                <input value="<?php echo $User->Lon; ?>" name="Lon" id="lngFld" type="text" class="form-control" />
            </div>
            <div class="col-md-4">
                <label>Zoom</label>
                <input value="<?php echo $User->zoom; ?>" name="zoom" id="ZoomFld" type="text" class="form-control">
            </div>
        </div>
        <hr>
        <div class="form-group">
            <div class="alert alert-info"><i class="skt-icon-info"></i> <b>Haciendo click sobre el mapa podrá indicar la ubicación y el zoom deseado.</b></div>
            <div id="map_canvas_change" style="height:300px;width:100%; border-radius: 7px; display: block;"></div>
        </div>
    </div>
</form>
<button type="button" onclick="UpdateDataLocation<?php echo $User->id ?>();" id="UpdateDataUserLocation" class="right btn btn-primary btn-large btn-lg float-right" ><i class="skt-icon-location"></i> Guardar Mapa de ubicaci&oacute;n</button>
<script src="http://maps.google.com/maps/api/js?sensor=false&amp;language=en" type="text/javascript"></script>
<script type="text/javascript">

    function UpdateDataLocation<?php echo $User->id ?>() {
        var UrlUpdateData = '/SKTGoTo/' + admd2('CRUD/ViewEditElementsAsList/Lists/Users/UpdateData');
        var ID = '<?php echo $User->id; ?>';
        jQuery.ajax({
            'type': 'POST',
            'url': UrlUpdateData,
            'cache': false,
            'data': $('#UpdateLocation<?php echo $User->id ?>').serialize() + '&ID=' + ID,
            'success': function (data) {
                $('#SKT_UpdateDataInfo').html(data).show();
                setTimeout(function () {
                    $('#SKT_UpdateDataInfo').hide();
                    $('#SKT_UpdateDataInfo').html('');
                }, 3500);
            }
        });
    }

    /*MAPA GOOGLE*/

    var map;
    var markersArray = [];

    function initMap()
    {
        setTimeout(function () {
            var latlng = new google.maps.LatLng(<?php echo $User->Lat; ?>, <?php echo $User->Lon; ?>);
            var myOptions = {
                zoom: <?php echo $User->zoom; ?>,
                center: latlng,
                mapTypeId: google.maps.MapTypeId.ROADMAP
            };
            map = new google.maps.Map(document.getElementById("map_canvas_change"), myOptions);
            placeMarker(latlng);
            // add a click event handler to the map object
            google.maps.event.addListener(map, "click", function (event)
            {
                // place a marker
                placeMarker(event.latLng);

                // display the lat/lng in your form's lat/lng fields
                document.getElementById("latFld").value = event.latLng.lat();
                document.getElementById("lngFld").value = event.latLng.lng();
                document.getElementById("ZoomFld").value = map.getZoom();
            });

        }, 800);
    }
    function placeMarker(location) {
        // first remove all markers if there are any
        deleteOverlays();

        var marker = new google.maps.Marker({
            position: location,
            map: map
        });

        // add marker in markers array
        markersArray.push(marker);

        //map.setCenter(location);
    }

    // Deletes all markers in the array by removing references to them
    function deleteOverlays() {
        if (markersArray) {
            for (i in markersArray) {
                markersArray[i].setMap(null);
            }
            markersArray.length = 0;
        }
    }

</script>