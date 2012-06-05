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
            
            <div class="alert" id="txt_notif">
                <button class="close" data-dismiss="alert">×</button>
                <p id="txt_notif_msg"></p>
            </div>
            
            <p>
                <a class="btn" href="new_experiment.php">Previous step</a>
            </p>
            
            <form class="well form-horizontal" id="form_new_exp" >
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

                $("#txt_notif").hide();

                var selected_nodes = exp_json.nodes;
                for (i = 0; i < selected_nodes.length; i++) {
                    if (selected_nodes[i] != "") $("#all_nodes").append(new Option(selected_nodes[i], selected_nodes[i], false, false));
                }

                $("#form_new_exp").bind('submit', function () {
                    console.log(JSON.stringify(exp_json));

                    var mydata = JSON.stringify(exp_json);
                    var datab = "";

                    
                    if (withAssoc) {
                        var boundary = "AaB03x";
  
                        //JSON
                        datab += "--" + boundary + '\r\n';
                        datab += 'Content-Disposition: form-data; name="'+exp_json.name+'.json"; filename="'+exp_json.name+'.json"\r\n';
                        datab += 'Content-Type: application/json\r\n\r\n';
                        datab += mydata + '\r\n\r\n';
                        //datab += "--" + boundary + '\r\n';


                        for (i = 0; i < binary.length; i++) {
                            datab += "--" + boundary + '\r\n';
                            datab += 'Content-Disposition: form-data; name="' + binary[i].name + '"; filename="' + binary[i].name + '"\r\n';
                            datab += 'Content-Type: text/plain\r\n\r\n';
                            datab += binary[i].bin + '\r\n';
                        }

                        //add json
                        datab += "--" + boundary + '--';


                        $.ajax({
                            type: "POST",
                            dataType: "text",
                            
                            data: datab,
                            url: "/rest/experiment",
                            contentType: "multipart/form-data; boundary="+boundary,
                            
                            //data: "data="+datab,
                            //url: "dump.php",
                            success: function (data_server) {
                                $("#txt_notif_msg").html(data_server);
                                $("#txt_notif").show();
                                $("#txt_notif").removeClass("alert-error");
                                $("#txt_notif").addClass("alert-success");
                            },
                            error: function (XMLHttpRequest, textStatus, errorThrows) {
                                $("#txt_notif_msg").html(errorThrows);
                                $("#txt_notif").show();
                                $("#txt_notif").removeClass("alert-success");
                                $("#txt_notif").addClass("alert-error");
                            }
                        });
                    }
                    else
                    {
                        $.ajax({
                            type: "POST",
                            dataType: "text",
                            data: mydata,
                            contentType: "application/json; charset=utf-8",
                            url: "/rest/experiment?body",
                            success: function (data_server) {
                                $("#txt_notif_msg").html(data_server);
                                $("#txt_notif").show();
                                $("#txt_notif").removeClass("alert-error");
                                $("#txt_notif").addClass("alert-success");
                            },
                            error: function (XMLHttpRequest, textStatus, errorThrows) {
                                $("#txt_notif_msg").html(errorThrows);
                                $("#txt_notif").show();
                                $("#txt_notif").removeClass("alert-success");
                                $("#txt_notif").addClass("alert-error");
                            }
                        });
                        
                    }



                    return false;
                });

                $("#btn_assoc").click(function () {

                    if (!withAssoc) {
                        exp_json.profileassociations = [];
                        exp_json.firmwareassociations = [];

                        //TODO: default profil, only for debug
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
