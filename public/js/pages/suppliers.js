$(document).ready((function(){"use strict";var e="{{ route('suppliers.list') }}";console.log(e),$("#suppliers-datatable").DataTable({processing:!0,serverSide:!0,ajax:e,language:{paginate:{previous:"<i class='mdi mdi-chevron-left'>",next:"<i class='mdi mdi-chevron-right'>"},info:"Showing suppliers _START_ to _END_ of _TOTAL_",lengthMenu:'Display <select class=\'form-select form-select-sm ms-1 me-1\'><option value="10">10</option><option value="20">20</option><option value="-1">All</option></select> suppliers'},pageLength:10,columns:[{data:"id",orderable:!1,render:function(e,a,l,s){return"display"===a&&(e='<div class="form-check"><input type="checkbox" class="form-check-input dt-checkboxes"><label class="form-check-label">&nbsp;</label></div>'),e},checkboxes:{selectRow:!0,selectAllRender:'<div class="form-check"><input type="checkbox" class="form-check-input dt-checkboxes"><label class="form-check-label">&nbsp;</label></div>'}},{data:"contact_person",render:function(e){var a='<img width="48" src="/images/users/avatar-'+(Math.floor(9*Math.random())+1)+'.jpg" alt="table-user" class="me-2 rounded-circle">';return a+='<a href="javascript:void(0);" class="text-body fw-semibold">'+e+"</a>"},orderable:!0},{data:"company_title",orderable:!0},{data:"address",orderable:!0},{data:"email",orderable:!0},{data:"phone",orderable:!0}],select:{style:"multi"},order:[[4,"desc"]],drawCallback:function(){$(".dataTables_paginate > .pagination").addClass("pagination-rounded"),$("#suppliers-datatable_length label").addClass("form-label")}})}));