<?php

session_start();
if(!$_SESSION['is_auth'] || !$_SESSION['is_admin'] ) {
    header("location: .");
    exit();
}

?>

<?php include("header.php") ?>

    <div class="container">
      
      <div class="row">
        <div class="span12">
          <h2>Users</h2>
        </div>
      </div>
  
      <div class="row">
        <div class="span2 offset10" style="text-align:right">
          <a href="#" class="btn btn-add" data-toggle="modal">Add user(s)</a>
        </div>
      </div>

      <div class="row">
        <div class="span12">
		<!-- <a href="#" class="btn btn-add" data-toggle="modal">Add user(s)</a> -->
                <table id="tbl_users" class="table table-bordered table-striped table-condensed">
                <thead>
                    <tr>
                        <th>Login</th>
                        <th>FirstName</th>
                        <th>LastName</th>
                        <th>Email</th>
                        <th>Options</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
                </table>
        </div>

      </div>

        <div id="add_modal" class="modal hide fade">
            <div class="modal-header">
              <a class="close" data-dismiss="modal">X</a>
              <h3>Add user(s) <span id="s_login"></span></h3>
              
            </div>
           <div class="modal-body">
               <div class="alert alert-error" id="div_error" style="display:none"></div>
               
                <form class="well form-horizontal" id="form_add">

              <div class="control-group">
                <label class="control-label" for="txt_firstname">First Name:</label>
                <div class="controls">
                    <input id="txt_firstname" type="text" class="input-xlarge" required="required"/>
                </div>
              </div>

              <div class="control-group">
                <label class="control-label" for="txt_lastname">Last Name:</label>
                <div class="controls">
                    <input id="txt_lastname" type="text" class="input-xlarge" required="required"/>
                </div>
              </div>

              <div class="control-group">
                <label class="control-label" for="txt_howmany">How many user:</label>
                <div class="controls">
                    <input id="txt_howmany" type="text" class="input-xlarge" required="required" value="1"/>
                </div>
              </div>

              <div class="control-group">
                <label class="control-label" for="txt_email">Email:</label>
                <div class="controls">
                    <input id="txt_email" type="email" class="input-xlarge" required="required"/>
                </div>
              </div>

              <div class="control-group">
                <label class="control-label" for="txt_structure">Structure:</label>
                <div class="controls">
                    <input id="txt_structure" type="text" class="input-xlarge" required="required" />
                </div>
              </div>

              <div class="control-group">
                <label class="control-label" for="txt_city">City:</label>
                <div class="controls">
                    <input id="txt_city" type="text" class="input-xlarge" required="required" />
                </div>
              </div>

              <div class="control-group">
                <label class="control-label" for="txt_country">Country:</label>
                <div class="controls">
                    <input id="txt_country" type="text" class="input-xlarge" required="required" />
                </div>
              </div>

              <div class="control-group">
                <label class="control-label" for="txt_sshkey">SSH Key:</label>
                <div class="controls">
                    <textarea id="txt_sshkey" class="input-xlarge" rows="3" required="required"></textarea>
                </div>
              </div>
              
               <div class="control-group">
                <label class="control-label" for="txt_motivation">Motivation:</label>
                <div class="controls">
                    <textarea id="txt_motivation" class="input-xlarge" rows="3" required="required"></textarea>
                </div>
              </div>
              
            </div>
            
            <div class="modal-footer">
                   <button id="btn_add" class="btn btn-primary" type="submit">Add</button>
                </form>
            </div>
            
        </div>

        <div id="edit_modal" class="modal hide fade">
            <div class="modal-header">
              <a class="close" data-dismiss="modal">X</a>
              <h3>Edit user <span id="s_login_e"></span></h3>
              
            </div>
           <div class="modal-body">
               <div class="alert alert-error" id="div_error" style="display:none"></div>
               
                <form class="well form-horizontal" id="form_modify">

              <div class="control-group">
                <label class="control-label" for="txt_firstname_e">First Name:</label>
                <div class="controls">
                    <input id="txt_firstname_e" type="text" class="input-xlarge" required="required"/>
                </div>
              </div>

              <div class="control-group">
                <label class="control-label" for="txt_lastname_e">Last Name:</label>
                <div class="controls">
                    <input id="txt_lastname_e" type="text" class="input-xlarge" required="required"/>
                </div>
              </div>

              <div class="control-group">
                <label class="control-label" for="txt_login_e">Login:</label>
                <div class="controls">
                    <input id="txt_login_e" type="text" class="input-xlarge" required="required" disabled="disabled"/>
                </div>
              </div>

              <div class="control-group">
                <label class="control-label" for="txt_email_e">Email:</label>
                <div class="controls">
                    <input id="txt_email_e" type="email" class="input-xlarge" required="required"/>
                </div>
              </div>

              <div class="control-group">
                <label class="control-label" for="txt_structure_e">Structure:</label>
                <div class="controls">
                    <input id="txt_structure_e" type="text" class="input-xlarge" required="required" />
                </div>
              </div>

              <div class="control-group">
                <label class="control-label" for="txt_city_e">City:</label>
                <div class="controls">
                    <input id="txt_city_e" type="text" class="input-xlarge" required="required" />
                </div>
              </div>

              <div class="control-group">
                <label class="control-label" for="txt_country_e">Country:</label>
                <div class="controls">
                    <input id="txt_country_e" type="text" class="input-xlarge" required="required" />
                </div>
              </div>

              <div class="control-group">
                <label class="control-label" for="txt_sshkey_e">SSH Key:</label>
                <div class="controls">
                    <textarea id="txt_sshkey_e" class="input-xlarge" rows="3" required="required"></textarea>
                </div>
              </div>
              
               <div class="control-group">
                <label class="control-label" for="txt_motivation_e">Motivation:</label>
                <div class="controls">
                    <textarea id="txt_motivation_e" class="input-xlarge" rows="3" required="required"></textarea>
                </div>
              </div>
              
            </div>
            
            <div class="modal-footer">
                   <button id="btn_modify" class="btn btn-primary" type="submit">Modify</button>
                </form>
            </div>
            
        </div>


      <hr>

<?php include('footer.php') ?>

<link href="css/datatable.css" rel="stylesheet">
<script type="text/javascript" language="javascript" src="js/jquery.dataTables.min.js"></script>
<script type="text/javascript" language="javascript" src="js/datatable.js"></script>
 
    <script type="text/javascript">

    var users = {};
    var selectedUser = {};

    $(document).ready(function()
    {
        $('#add_modal').modal('hide');
        $('#edit_modal').modal('hide');

        /* Load data in the table */
        $.ajax({
            url: "/rest/admin/users",
            type: "GET",
            dataType: "json",
            success:function(data){
                users = data;
                var i = 0;
                $.each(data, function(key,val) {
                    var btnValidClass = "btn-primary";
                    var btnValidValue="Pending";
                    if(val.validate) {
                         btnValidClass="";
                         btnValidValue="Valid";
                    }

                    btnAdminClass = '';
                    btnAdminValue = "User";
                    if(val.admin) {
                        btnAdminClass = 'btn-warning';
                        btnAdminValue = "Admin";
                    }
 
                     //user row
                    $("#tbl_users tbody").append(
                    '<tr data=' + i + '>'+
                    '<td>' + val.login + '</td>'+
                    '<td>' + val.firstName + '</td>'+
                    '<td>'+ val.lastName +'</td>'+
                    '<td><a href="mailto:' + val.email + '">' + val.email + '</a></td>'+
                    '<td><a href="#" class="btn btn-valid '+btnValidClass+'" data="'+i+'" data-state="'+val.validate+'" onClick="validateUser('+i+')">'+btnValidValue+'</a> ' +
                        '<a href="#" class="btn btn-edit" data-toggle="modal" data="'+i+'">Edit</a> ' +
                        '<a href="#" class="btn btn-admin '+btnAdminClass+'" data="'+i+'" data-state="'+val.admin+'" onClick="setAdmin('+i+')">'+btnAdminValue+'</a> ' +
                        '<a href="#"><button class="btn btn-danger" data="'+i+'" onClick="deleteUser('+i+')">Delete</button></a></td>'
                    +'</tr>');
                    $("tr[data="+i+"] .btn-valid").width(50);
                    $("tr[data="+i+"] .btn-admin").width(50);
                    i++;
                });

                //action on edit button: load data on modal form
                $(".btn-edit").click(function(){
                    var userId = $(this).attr("data");
                    selectedUser = users[userId];
                    $('#s_login_e').html(selectedUser.login);
                    $('#txt_sshkey_e').val(selectedUser.sshPublicKey);
                    $('#txt_firstname_e').val(selectedUser.firstName);
                    $('#txt_lastname_e').val(selectedUser.lastName);
                    $('#txt_login_e').val(selectedUser.login);
                    $('#txt_email_e').val(selectedUser.email);
                    $('#txt_structure_e').val(selectedUser.structure);
                    $('#txt_city_e').val(selectedUser.city);
                    $('#txt_country_e').val(selectedUser.country);
                    $('#txt_motivation_e').val(selectedUser.motivations);
                    $("#edit_modal").modal('show');
                });
                $('#tbl_users').dataTable({
			"sDom": "<''f>t<''i'p>",
                        "bPaginate": true,
                        "sPaginationType": "bootstrap",
                        "bLengthChange": false,
                        "bFilter": true,
                        "bSort": true,
                        "bInfo": true,
                        "bAutoWidth": false
                } );

            },
            error:function(XMLHttpRequest, textStatus, errorThrows){
                alert("error: " + errorThrows)
            }
        });
    });
    
    /* Add user(s) */
    $(".btn-add").click(function(){
	$("#add_modal").modal('show');
    });
    $('#form_add').bind('submit', function(){
    
        var userregister = {
        "firstName":$("#txt_firstname").val(),
        "lastName":$("#txt_lastname").val(),
        "email":$("#txt_email").val(),
        "structure":$("#txt_structure").val(),
        "city":$("#txt_city").val(),
        "country":$("#txt_country").val(),
        "sshPublicKey":$("#txt_sshkey").val(),
        "motivations":$("#txt_motivation").val(),
        "nbUsersToAdd":$("#txt_howmany").val(),
        };
        
        console.log(userregister);
        
        $.ajax({
            url: "/rest/admin/users",
            type: "POST",
            dataType: "text",
            contentType: "application/json; charset=utf-8",
            data: JSON.stringify(userregister),
            success:function(data){
                 window.location.reload();
 	    },
            error:function(XMLHttpRequest, textStatus, errorThrows){
                if(XMLHttpRequest.status == 409)
                {
                    $("#div_error").show();
                    $("#div_error").removeClass("alert-success");
                    $("#div_error").addClass("alert-error");
                    $("#div_error").html("This user is already registered");
                }
                else if(XMLHttpRequest.status == 403)
                {
                    $("#div_error").show();
                    $("#div_error").removeClass("alert-success");
                    $("#div_error").addClass("alert-error");
                    $("#div_error").html("Error");
                    $("#cg_captcha").addClass("error");
                    $("#captcha").focus();
                }
                else {
                    $("#div_error").show();
                    $("#div_error").removeClass("alert-success");
                    $("#div_error").addClass("alert-error");
                    $("#div_error").html(errorThrows); 
                }  
            }
        });
        
    	return false;
    
    });
    
    /* Delete a user */
    function deleteUser(id) 
    {
        if(confirm("Delete user?"))
        {
            var userdelete = users[id];
            $.ajax({
            url: "/rest/admin/users/"+userdelete.login,
                type: "DELETE",
                contentType: "application/json",
                dataType: "text",
            
                success:function(data){
                    $("tr[data="+id+"]").remove()    
                },
                error:function(XMLHttpRequest, textStatus, errorThrows){
                    alert("error: " + errorThrows)
                }
            });
        }
    };
    
    
    /* Toggle Valid state */
    function validateUser(id) {
        var state = $("tr[data="+id+"] .btn-valid").attr("data-state");
        var confirmText = "Validate user?";
        if(state=="true") confirmText="Unvalidate user?";

        if(confirm(confirmText)) {
            //toggle validate flag
            var user = users[id];
            user.validate = !user.validate;
            
            $.ajax({
                url: "/rest/admin/users/"+user.login,
                type: "PUT",
                dataType: "text",
                contentType: "application/json; charset=utf-8",
                data: JSON.stringify(user),
                success:function(data){
                    if(state == "false") {
                        $("tr[data="+id+"] .btn-valid").removeClass("btn-primary");
                        $("tr[data="+id+"] .btn-valid").attr("data-state","true");
                        $("tr[data="+id+"] .btn-valid").text("Valid");
                    } else {
                        $("tr[data="+id+"] .btn-valid").addClass("btn-primary");
                        $("tr[data="+id+"] .btn-valid").attr("data-state","false");
                        $("tr[data="+id+"] .btn-valid").text("Pending");
                    }
                },
                error:function(XMLHttpRequest, textStatus, errorThrows){
                    alert("error:" + errorThrows)
                }
            })
        };
    };
    
    
    /* Toggle Admin state */
    function setAdmin(id) 
    {
        var state = $("tr[data="+id+"] .btn-admin").attr("data-state");
        var confirmText = "Set Admin state?";
        if(state=="true") confirmText="Unset Admin state?";


        if(confirm(confirmText))
        {
            //toggle admin flag
            var user = users[id];
            user.admin = !user.admin;
            
            $.ajax({
                url: "/rest/admin/users/"+user.login,
                type: "PUT",
                dataType: "text",
                contentType: "application/json; charset=utf-8",
                data: JSON.stringify(user),
                success:function(data){
                    if(state == "false") {
                        $("tr[data="+id+"] .btn-admin").addClass("btn-warning");
                        $("tr[data="+id+"] .btn-admin").attr("data-state","true");
                        $("tr[data="+id+"] .btn-admin").text("Admin");
                    } else {
                        $("tr[data="+id+"] .btn-admin").removeClass("btn-warning");
                        $("tr[data="+id+"] .btn-admin").attr("data-state","false");
                        $("tr[data="+id+"] .btn-admin").text("User");
                    }
                },
                error:function(XMLHttpRequest, textStatus, errorThrows){
                    alert("error:" + errorThrows)
                }
            })
        };
    };   
    
    
    /* Save values from edit modal */
    $('#form_modify').bind('submit', function()
    {
        //change all value
        selectedUser.firstName = $("#txt_firstname_e").val();
        selectedUser.lastName = $("#txt_lastname_e").val();
        selectedUser.login = $("#txt_login_e").val();
        selectedUser.email = $("#txt_email_e").val();
        selectedUser.sshPublicKey = $("#txt_sshkey_e").val();
        selectedUser.motivations = $("#txt_motivation_e").val();
        selectedUser.structure = $("#txt_structure_e").val();
        selectedUser.city = $("#txt_city_e").val();
        selectedUser.country = $("#txt_country_e").val();
        
        $.ajax({
            url: "/rest/admin/users/"+selectedUser.login,
            type: "PUT",
            dataType: "text",
            contentType: "application/json; charset=utf-8",
            data: JSON.stringify(selectedUser),
            success:function(data){
                $("#edit_modal").modal('hide');
                $("#div_error").html("");
            },
            error:function(XMLHttpRequest, textStatus, errorThrows){
                $("#div_error").show();
                $("#div_error").removeClass("alert-success");
                $("#div_error").addClass("alert-error");
                $("#div_error").html("Error");
            }
        });
        
    return false;
    
    }); 
    
    
    </script>

  </body>
</html>
