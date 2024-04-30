<?php

  require_once("../../globals.php");
  require_once("$srcdir/api.inc");
  require_once("$srcdir/forms.inc");
  require_once("$srcdir/options.inc.php");

 use OpenEMR\Core\Header;

?>

<html>

  <head>

    <title><?php echo xlt("Import Mass Upload Patient CCD"); ?></title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <link rel="stylesheet" href="<?php echo $GLOBALS['assets_static_relative']; ?>/duxlink/css/custom.css">

    <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>


      <?php Header::setupHeader(['datatables', 'datatables-colreorder', 'datatables-dt', 'datatables-bs']) ?>


    <script type="text/javascript" >

      $(document).ready(function() {

        var oTable = $('#pt_table').dataTables({
          'processing': true,
          'serverSide': true,
          'sAjaxSource': '../../ajax/upload/uploadfile.php',
          'fnServerParams': function ( aoData ) {
            aoData.push( { "name": "task", "value": 'getdata' } );
          },
          'aoColumns': [
            { 'mData': 'fname' },
            { 'mData': 'lname' },
            { 'mData': 'state' },
            { 'mData': 'city' },
            { 'mData': 'address' },
            { 'mData': 'phone' },
            { 'mData': 'postal_code' },
            { 'mData': 'sex' },
            { 'mData': 'ethnicity' },
            { 'mData': 'deleted' }
          ],
          "aoColumnDefs": [{
            "aTargets": [ 9 ],
            "mData": "deleted",
            "mRender": function ( data, type, full ) {
              var res = "";
              if(data > 0){
                res = '<button type="button" class="btn btn-primary expired" id="'+data+'">Delete</button>';
              }

              return res;
            }
          }],
          'fnInitComplete': function(oSettings, json) {
            if(json.iTotalRecords > 0){
              $('#btn-refresh').show()
            }
          },
          'sServerMethod': 'POST',
          'bDeferRender': true,
          'lengthMenu': [ 10, 25, 50, 100 ]
        })

        //function delete
        $('#pt_table_wrapper').on('click', '#pt_table tbody td', function (e) {

          // Get the position of the current data from the node
          e.preventDefault()

          aPos = oTable.fnGetPosition(this);
          id = event.target.id

          var formData = new FormData()
          formData.append('task', 'DeleteRecord')
          formData.append('id', id )
          formData.append('ajax', true)

          $.ajax({
            url: '../../ajax/upload/uploadfile.php',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success:function(resp){
              //Recargar Tabla
              oTable.fnDestroy()
              DrawTable()
            }
          });

        })

        $('#form-submit').on('submit', function(e) {
          e.preventDefault()
          oTable.fnDestroy()
          DrawTable()
        })

        $('#SaveData').on('click', function(e) {
          oTable.fnDestroy()
          SaveDate()
        })

      })

    </script>
  </head>

  <body class="body_top">

    <div id="dynamic" class="container-fluid"><!-- TBD: id seems unused, is this div required? -->

      <div class="row mt-4">
        <div class="col-md-12">
          <form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" name="submit" id="form-submit" enctype="multipart/form-data"  method="post">
            <div class="row">

              <div class="col-md-3">
                <div class="custom-file">
                  <input type="file" name="file[]" class="custom-file-input" id="customFile" multiple>
                  <label class="custom-file-label" for="customFile">Choose files</label>
                </div>
              </div>

              <div class="col-md-3">
                <div class="custom-file">
                  <select name="select_file" id="select_file" class="form-control">
                    <option value="office_ally">Office Ally</option>
                    <option value="greenwise">Greenway</option>
                    <option value="memorial">Memorial</option>
                    <option value="plaza">Plaza</option>
                    <option value="emedical">eMedical</option>
                  </select>
                </div>
              </div>

              <div class="col-md-3">
                <div class="custom-file">
                  <?php dropdown_facility($facility, 'form_facility'); ?>
                </div>
              </div>

              <div class="col-md-3">
                <input type="submit" value="Submit File to Evaluate" id="btn-submit" class="btn btn-primary">
              </div>

            </div>
          </form>
        </div>
      </div>

      <img src="<?php echo $GLOBALS['assets_static_relative']; ?>/images/loading.gif" style="display:none" width="150" id="img-loading">

      <div class="row mt-2">
        <div class="col-md-4">
          <div id="btn-refresh" style="display:none">
            <button class="btn btn-primary" id="SaveData">Upload new Data</button>
          </div>
        </div>
      </div>

      <div class="row mt-2">
        <div class="col-md-12">
          <table cellpadding="0" cellspacing="0" border="0" class="display table table-bordered table-condensed table-striped table-hover" id="pt_table">
            <thead>
              <tr>
                <th>First Name</th>
                <th>Last Name</th>
                <th>State</th>
                <th>City</th>
                <th>Address</th>
                <th>Phone</th>
                <th>Postal Code</th>
                <th>Sex</th>
                <th>Ethnicity</th>
                <th> </th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td colspan="10" class="dataTables_empty">...</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>

    </div>

    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    <script src="<?php echo $GLOBALS['assets_static_relative']; ?>/duxlink/ccd/js/massupload.js"></script>

  </body>

</html>
