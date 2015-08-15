jQuery(document).ready(function($){

    $('#films-archive').DataTable(
        {
            dom: '<"row"<"col-xs-12 col-sm-6"l><"col-xs-12 col-sm-6"f>>t<"row"<"col-xs-12 col-sm-6"i"><"col-xs-12 col-sm-6"p>>',

            order: [[ 0, "asc" ]],

            stateSave: true,

            iDisplayLength: 50,

            lengthMenu: [[25, 50, 100, -1], ["View 25 per page", "View 50 per page", "View 100 per page", "View All"]],

            language: {
                // lengthMenu: "<div class='form-group'><div class='input-group'><div class='input-group-addon'><i class='fa fa-list'></i></div>_MENU_</div></div>",

                // search: "<div class='form-group'><div class='input-group'><div class='input-group-addon'><i class='fa fa-search'></i></div>_INPUT_</div></div>",


                lengthMenu: "_MENU_",

                search: "_INPUT_",



                searchPlaceholder: "Search films",

                oPaginate: {
                    sPrevious: "<i class='fa fa-chevron-left'></i>",

                    sNext: "<i class='fa fa-chevron-right'></i>",
                }
            }
        }
    );

    if(window.location.hash) {
      var oTable = $('#films-archive').dataTable();
      var hash = window.location.hash.substring(1);
      oTable.fnFilter( hash );
    } else {
      // Fragment doesn't exist
    }



});
