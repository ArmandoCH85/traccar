.icon { font-size: 16px; padding: 2px; }
.thumbnail-preview .full-preview { position: absolute; background-color: rgb(255, 255, 255); padding: 5px; right: 15px; top: 15px; border: 1px solid gray; visibility: hidden; color: rgb(0, 0, 0); text-decoration: none; }
.thumbnail-preview .full-preview img { max-width: 400px; max-height: 400px; }
.thumbnail-preview:hover { background-color: transparent; z-index: 50; }
.thumbnail-preview:hover .full-preview { visibility: visible; }
table.dataTable { clear: both; margin-top: 6px !important; margin-bottom: 6px !important; max-width: none !important; border-collapse: separate !important; }
table.dataTable.nowrap td, table.dataTable.nowrap th { white-space: nowrap; }
table.dataTable td, table.dataTable th { box-sizing: content-box; }
table.dataTable td.dataTables_empty, table.dataTable th.dataTables_empty { text-align: center; }
table.dataTable thead > tr > td:active, table.dataTable thead > tr > th:active { outline: 0px; }
div.dataTables_wrapper .bottom { border-top: 1px solid rgb(217, 217, 217); }
div.dataTables_wrapper div.dataTables_length label { font-weight: 400; text-align: left; white-space: nowrap; }
div.dataTables_wrapper div.dataTables_length select { width: 75px; display: inline-block; }
div.dataTables_wrapper div.dataTables_filter { text-align: right; }
div.dataTables_wrapper div.dataTables_filter label { font-weight: 400; white-space: nowrap; text-align: left; }
div.dataTables_wrapper div.dataTables_filter input { margin-left: 0.5em; display: inline-block; width: auto; }
div.dataTables_wrapper div.dataTables_info { padding-top: 8px; white-space: nowrap; }
div.dataTables_wrapper div.dataTables_paginate ul.pagination { margin: 2px 0px; white-space: nowrap; }
div.dataTables_wrapper div.dataTables_processing { position: absolute; top: 50%; left: 50%; width: 200px; margin-left: -100px; margin-top: -26px; text-align: center; padding: 1em 0px; }
@media screen and (max-width: 767px) {
  div.dataTables_wrapper div.dataTables_filter, div.dataTables_wrapper div.dataTables_info, div.dataTables_wrapper div.dataTables_length, div.dataTables_wrapper div.dataTables_paginate { text-align: center; }
}
div.table-responsive > div.dataTables_wrapper > div.checkboxes, div.table-responsive > div.dataTables_wrapper > div.plans, div.table-responsive > div.dataTables_wrapper > div.row { margin: 0px; }
div.table-responsive > div.dataTables_wrapper > div.checkboxes > div[class^="col-"]:first-child, div.table-responsive > div.dataTables_wrapper > div.plans > div[class^="col-"]:first-child, div.table-responsive > div.dataTables_wrapper > div.row > div[class^="col-"]:first-child { padding-left: 0px; }
div.table-responsive > div.dataTables_wrapper > div.checkboxes > div[class^="col-"]:last-child, div.table-responsive > div.dataTables_wrapper > div.plans > div[class^="col-"]:last-child, div.table-responsive > div.dataTables_wrapper > div.row > div[class^="col-"]:last-child { padding-right: 0px; }
.dataTables_paginate { float: right; padding-left: 0px; margin: 7px 0px; border-radius: 0px; }
.dataTables_paginate > span { line-height: 1.42857; }
.dataTables_paginate .paginate_button { padding: 6px 12px; line-height: 1.42857; text-decoration: none; color: rgb(32, 32, 32); background-color: rgb(255, 255, 255); border: 1px solid transparent; margin-left: -1px; }
.dataTables_paginate .paginate_button:first-child { margin-left: 0px; border-bottom-left-radius: 0px; border-top-left-radius: 0px; }
.dataTables_paginate .paginate_button:last-child { border-bottom-right-radius: 0px; border-top-right-radius: 0px; }
.dataTables_paginate .paginate_button:hover { cursor: pointer; }
.dataTables_paginate .paginate_button:focus, .dataTables_paginate .paginate_button:hover { z-index: 3; color: rgb(32, 32, 32); background-color: rgb(249, 249, 249); border-color: transparent; }
.dataTables_paginate .paginate_button.current, .dataTables_paginate .paginate_button.current:focus, .dataTables_paginate .paginate_button.current:hover { z-index: 2; color: rgb(27, 153, 189); background-color: rgb(249, 249, 249); border-color: transparent; cursor: default; }
.dataTables_paginate .paginate_button.disabled, .dataTables_paginate .paginate_button.disabled:focus, .dataTables_paginate .paginate_button.disabled:hover { color: rgb(170, 170, 170); background-color: rgb(255, 255, 255); border-color: transparent; cursor: not-allowed; }
.chat-fc-form-outer { left: 20px; }
.fc-form { padding-top: 20px !important; }
.pre-fc-field input { padding: 8px !important; }
.days-count { color: red; font-weight: bold; }
.text-container { padding: 2px 20px; font-size: 13px; display: inline-block; }
.text-container img { max-height: 21px; margin-right: 7px; }