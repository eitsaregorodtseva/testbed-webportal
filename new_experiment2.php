<?php 
session_start();

if(!$_SESSION['is_auth']) {
    header("location: .");
    exit();
}
?>

<?php include("header.php") ?>

        <div class="container">
            <h2>New experiment</h2>
            <form class="well form-horizontal" id="form_new_exp">
                <h3>3. Configure your nodes</h3>
                <p>
                    <select id="all_nodes" size="15" multiple></select>
                    <select id="all_profils" size="15">
                        <option value="profile1">profile1</option>
                    </select>
                    <select id="all_firmwares" size="15">
                    </select>
                    <input type="file" id="files" name="files[]" multiple />
                </p>
                <p>
                    <button id="btn_assoc" class="btn">Associate</button>
                    <button id="btn_submit" class="btn btn-primary" type="submit">Submit</button>
                </p>
                <p>
                    <table style="width:500px" class="table table-striped table-bordered table-condensed">
                        <thead>
                            <tr>
                                <th>node</th>
                                <th>profile</th>
                                <th>firmware</th>
                            </tr>
                        </thead>
                        <tbody id="my_assoc"></tbody>
                    </table>
                </p>
            </form>
            <?php include( 'footer.php') ?>
        </div>
        <script type="text/javascript">
            var exp_json_tmp = localStorage.getItem("exp_json");
            var exp_json = JSON.parse(exp_json_tmp);

            var binary = [];

            var withAssoc = false;

            $(document).ready(function () {

                var selected_nodes = exp_json.nodes;
                for (i = 0; i < selected_nodes.length; i++) {
                    if (selected_nodes[i] != "") $("#all_nodes").append(new Option(selected_nodes[i], selected_nodes[i], false, false));
                }

                $("#form_new_exp").bind('submit', function () {
                    console.log(JSON.stringify(exp_json));

                    var url = "/rest/experiment?body";
                    var content_type = "application/json; charset=utf-8";
                    var data = JSON.stringify(exp_json);
                    var datab = JSON.stringify(exp_json);

                    var boundary = "----------------------------a9c9cb8394e1";

                    if (withAssoc) {
                        url = "/rest/experiment";
                        content_type = "multipart/form-data; boundary="+boundary;
                        data = "";

                        for (i = 0; i < binary.length; i++) {
                            data += "--" + boundary + '\r\n';
                            data += 'Content-Disposition: form-data; name="' + binary[i].name + '"; filename="' + binary[i].name + '"\r\n';
                            data += 'Content-Type: text/plain\r\n\r\n';
                            data += binary[i].bin + '\r\n';
                        }

                        //add json
                        data += boundary + '\r\n';
                        data += 'Content-Disposition: form-data; name="'+exp_json.name+'.json"; filename="'+exp_json.name+'.json"\r\n';
                        data += 'Content-Type: application/json\r\n\r\n';
                        data += datab + '\r\n\r\n';

                        data += "--" + boundary + '--\r\n';

                        //data = new FormData();
                        //data.append(binary[0].name,binary[0].bin);
                    }

                    $.ajax({
                        url: url,
                        type: "POST",
                        dataType: "text",
                        contentType: content_type,
                        processData: false,
                        data: data,
                        success: function (data) {
                            alert("ok: " + data);
                        },
                        error: function (XMLHttpRequest, textStatus, errorThrows) {
                            alert("error: " + errorThrows);
                        }
                    });

                    return false;
                });

                $("#btn_assoc").click(function () {

                    if (!withAssoc) {
                        exp_json.profileassociations = [];
                        exp_json.firmwareassociations = [];


//TODO: for debug only
exp_json.profiles = {};
exp_json.profiles.profile1 = {};
exp_json.profiles.profile1.power = 'dc';
exp_json.profiles.profile1.sensor = {};
exp_json.profiles.profile1.sensor.temperature = false;
exp_json.profiles.profile1.sensor.luminosity = false;
exp_json.profiles.profile1.sensor.frequency = 15;
exp_json.profiles.profile1.consemptium = {};
exp_json.profiles.profile1.consemptium.current = true;
exp_json.profiles.profile1.consemptium.voltage = true;
exp_json.profiles.profile1.consemptium.frequency = 60;
exp_json.profiles.profile1.radio = {};
exp_json.profiles.profile1.radio.rssi = false;
exp_json.profiles.profile1.radio.frequency = 11;
exp_json.profiles.profile1.profilename = 'profile1';


                        withAssoc = true;
                    }

                    var nodes_str = $("#all_nodes").val();
                    var profil_set = $("#all_profils").val();
                    var firmware_set = $("#all_firmwares").val();

                    if (nodes_str == null || profil_set == null || firmware_set == null) return false;

                    $("#all_nodes option:selected").remove();

                    for (i = 0; i < nodes_str.length; i++) {
			$("#my_assoc").append("<tr><td>" + nodes_str[i] + "</td><td>" + profil_set + "</td><td>" + firmware_set + "</td></tr>");
                    }

                    var find = false;
                    //if profil already exist in the table
                        for (i = 0; i < exp_json.profileassociations.length; i++) {
                            if (exp_json.profileassociations[i].profilename == profil_set) {
				exp_json.profileassociations[i].nodes = exp_json.profileassociations[i].nodes.concat(nodes_str);
				find = true;
                            }
                        }

                    if (!find) {
                        exp_json.profileassociations.push({
                            "profilename": profil_set,
                            "nodes": nodes_str
                        });
                    }

                    find = false;
                    //if firmware already exist in the table
                        for (i = 0; i < exp_json.firmwareassociations.length; i++) {
                            if (exp_json.firmwareassociations[i].firmwarename == firmware_set) {
				exp_json.firmwareassociations[i].nodes = exp_json.firmwareassociations[i].nodes.concat(nodes_str);
                                find = true;
                            }
                        }

                    if (!find) {
                        exp_json.firmwareassociations.push({
                            "firmwarename": firmware_set,
                            "nodes": nodes_str
                        });
                    }
                    return false;
                });

            });


            function handleFileSelect(evt) {
                var files = evt.target.files; // FileList object

                // Loop through the FileList and render image files as thumbnails.
                for (var i = 0, f; f = files[i]; i++) {

                    var reader = new FileReader();

                    // Closure to capture the file information.
                    reader.onload = (function (theFile) {
                        return function (e) {

                            binary.push({
                                "name": theFile.name,
                                "bin": e.target.result
                            });

                            $("#all_firmwares").append(new Option(theFile.name, theFile.name, false, false));
                        };
                    })(f);

                    reader.readAsText(f);
                }
            }

            document.getElementById('files').addEventListener('change', handleFileSelect, false);
        </script>