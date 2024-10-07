<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Basic CRUD Application - jQuery EasyUI CRUD Demo</title>
    <link rel="stylesheet" type="text/css" href="../jquery/themes/default/easyui.css">
    <link rel="stylesheet" type="text/css" href="../jquery/themes/icon.css">
    <link rel="stylesheet" type="text/css" href="../jquery/themes/color.css">
    <script type="text/javascript" src="../jquery/jquery.min.js"></script>
    <script type="text/javascript" src="../jquery/jquery.easyui.min.js"></script>
</head>
<body>
    <h2>Basic CRUD Application</h2>
    <p>Click the buttons on datagrid toolbar to do crud actions.</p>
    
    <table id="dg" title="Mis Estudiantes" class="easyui-datagrid" style="width:700px;height:250px"
            url="../controllers/apiRest.php" method="GET"
            toolbar="#toolbar" pagination="true"
            rownumbers="true" fitColumns="true" singleSelect="true">
        <thead>
            <tr>
                <th field="cedula" width="50">Cedula</th>
                <th field="nombre" width="50">Nombre</th>
                <th field="apellido" width="50">Apellido</th>
                <th field="direccion" width="50">Direccion</th>
                <th field="telefono" width="50">Telefono</th>
            </tr>
        </thead>
    </table>
    <div id="toolbar">
    <input id="cedulaSearch" class="easyui-textbox" style="width:150px" prompt="Buscar por cédula">
    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-search" plain="true" onclick="searchByCedula()">Buscar</a>
    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="newUser()">Nuevo Estudiante</a>
    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="editUser()">Editar Estudiante</a>
    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="destroyUser()">Eliminar Estudiante</a>
</div>

    
    <div id="dlg" class="easyui-dialog" style="width:400px" data-options="closed:true,modal:true,border:'thin',buttons:'#dlg-buttons'">
        <form id="fm" method="post" novalidate style="margin:0;padding:20px 50px">
            <h3>Informacion Estudiantes</h3>
            <div style="margin-bottom:10px">
                <input name="cedula" id="cedulaField" class="easyui-textbox" required="true" label="Cedula:" style="width:100%">
            </div>
            <div style="margin-bottom:10px">
                <input name="nombre" class="easyui-textbox" required="true" label="Nombre:" style="width:100%">
            </div>
            <div style="margin-bottom:10px">
                <input name="apellido" class="easyui-textbox" required="true" label="Apellido:" style="width:100%">
            </div>
            <div style="margin-bottom:10px">
                <input name="direccion" class="easyui-textbox" required="true"  label="Direccion:" style="width:100%">
            </div>
            <div style="margin-bottom:10px">
                <input name="telefono" class="easyui-textbox" required="true"  label="Telefono:" style="width:100%">
            </div>
        </form>
    </div>
    <div id="dlg-buttons">
        <a href="javascript:void(0)" class="easyui-linkbutton c6" iconCls="icon-ok" onclick="saveUser()" style="width:90px">Save</a>
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlg').dialog('close')" style="width:90px">Cancel</a>
    </div>
    <script type="text/javascript">
        var url;
        function newUser(){
            $('#dlg').dialog('open').dialog('center').dialog('setTitle','Nuevo Estudiante');
            $('#fm').form('clear');
            $('#cedulaField').textbox('readonly', false); 
            url = '../controllers/apiRest.php';
        }
        function editUser() {
        var row = $('#dg').datagrid('getSelected');
            if (row) {
                $('#dlg').dialog('open').dialog('center').dialog('setTitle', 'Editar Estudiante');
                $('#fm').form('load', row);
                $('#cedulaField').textbox('readonly', true);  
        url = '../controllers/apiRest.php?cedula=' + row.cedula; 
    }
}

function saveUser() {
    var method = url.includes('cedula') ? 'PUT' : 'POST';  
    
    $.ajax({
        url: url,
        type: method,
        data: $('#fm').serialize(),  
        success: function (result) {
            var result = eval('(' + result + ')');
            if (result.errorMsg) {
                $.messager.show({
                    title: 'Error',
                    msg: result.errorMsg
                });
            } else {
                $('#dlg').dialog('close');  
                $('#dg').datagrid('reload'); 
            }
        },
        error: function (error) {
            $.messager.show({
                title: 'Error',
                msg: error.responseText
            });
        }
    });
}

function searchByCedula(){
    var cedula = $('#cedulaSearch').val();  
    if (cedula) {
        $('#dg').datagrid('load', {  
            cedula: cedula
        });
    } else {
        $('#dg').datagrid('load', {});  
    }
}


function destroyUser() {
    var row = $('#dg').datagrid('getSelected');
    if (row) {
        $.messager.confirm('Confirm', 'Are you sure you want to destroy this user?', function (r) {
            if (r) {
                $.ajax({
                    url: "../controllers/apiRest.php?cedula=" + row.cedula + "&_method=DELETE",
                    type: "POST",  
                    dataType: "json",
                    success: function (jsondata) {
                        $('#dg').datagrid('reload');
                    },
                    error: function (error) {
                        $.messager.show({    
                            title: 'Error',
                            msg: error.responseText
                        });
                    }
                });
            }
        });
    }
}

    </script>
</body>
</html>