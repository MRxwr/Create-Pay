/*DataTable Init*/

"use strict";

$(document).ready(function () {
  "use strict";

  $("#myTable").DataTable({
    columnDefs: [{ targets: 0, type: "date-euro" }],
    order: [0, "desc"],
  });
  $("#datable_2").DataTable({ lengthChange: false });
});
