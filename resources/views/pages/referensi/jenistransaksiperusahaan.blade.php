@extends('layouts.default')

@section('title', 'Referensi | Jenis Transaksi Perusahaan')

@section('content')
	<!-- begin panel -->
	<div class="panel panel-info">
		<div class="panel-heading">
			<h4 class="panel-title">Referensi - Jenis Transaksi Perusahaan</h4>
			<div class="panel-heading-btn">
				<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
				<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-redo"></i></a>
				<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
				<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
			</div>
		</div>
		<div class="panel-body">
			<div id="ref-jenistransaksiperusahaan" style="height: 400px; width:100%;"></div>
		</div>
	</div>
	<!-- end panel -->
@endsection

@push('scripts')

<script>

var store = new DevExpress.data.CustomStore({
    key: "id",
    load: function() {
        return sendRequest(apiurl + "/jenistransaksiperusahaan");
    },
    insert: function(values) {
        return sendRequest(apiurl + "/jenistransaksiperusahaan", "POST", values);
    },
    update: function(key, values) {
        return sendRequest(apiurl + "/jenistransaksiperusahaan/"+key, "PUT", values);
    },
    remove: function(key) {
        return sendRequest(apiurl + "/jenistransaksiperusahaan/"+key, "DELETE");
    },
});

function moveEditColumnToLeft(dataGrid) {
    dataGrid.columnOption("command:edit", { 
        visibleIndex: -1,
        width: 80 
    });
}
// attribute
var dataGrid = $("#ref-jenistransaksiperusahaan").dxDataGrid({    
    dataSource: store,
    allowColumnReordering: true,
    allowColumnResizing: true,
    columnsAutoWidth: true,
    // columnMinWidth: 80,
    wordWrapEnabled: true,
    showBorders: true,
    filterRow: { visible: false },
    filterPanel: { visible: false },
    headerFilter: { visible: true },
    editing: {
        useIcons:true,
        mode: "batch",
        allowAdding: true,
        allowUpdating: true,
        allowDeleting: false,
    },
    scrolling: {
        mode: "virtual"
    },
    columns: [
        { 
            dataField: "nama_transaksi_perusahaan",
            sortOrder: "asc",
            validationRules: [
                { 
                    type: "required" 
                }
            ]
        },
		{ 
			dataField: "keterangan_transaksi",
        },
        { 
			dataField: "jenis_transaksi",
            lookup: {
                dataSource: [{id:0,value:'Masuk'},{id:1,value:'Keluar'}],
                valueExpr: 'value',
                displayExpr: 'value',
                searchEnabled: false
            },
        },
		{ 
			dataField: "status_aktif",
			dataType: "boolean",
            encodeHtml: false,
            customizeText: function (e) {
                var arrText = ["<span class='btn btn-danger btn-xs'>Tidak Aktif</span>","<span class='btn btn-success btn-xs'>Aktif</span>"];
                return arrText[e.value];
            }
		},
       
    ],
    export: {
        enabled: true,
        fileName: "referensi-jenistransaksiperusahaan",
        excelFilterEnabled: true,
        allowExportSelectedData: true
    },
    onInitNewRow: function(e) {  

    } ,
    onContentReady: function(e){
        moveEditColumnToLeft(e.component);
    },
    onEditorPreparing: function(e) {

    },
    onToolbarPreparing: function(e) {
        dataGrid = e.component;

        e.toolbarOptions.items.unshift({						
            location: "after",
            widget: "dxButton",
            options: {
                hint: "Refresh Data",
                icon: "refresh",
                onClick: function() {
                    dataGrid.refresh();
                }
            }
        })
    },
}).dxDataGrid("instance");
</script>

@endpush