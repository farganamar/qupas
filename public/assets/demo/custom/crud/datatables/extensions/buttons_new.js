var DatatablesExtensionButtons = { init: function () { var t, e; t = $("#m_table_2").DataTable({ responsive: !0, buttons: ["print", "copyHtml5", "excelHtml5", "csvHtml5", "pdfHtml5"] }), $("#export_print").on("click", function (e) { e.preventDefault(), t.button(0).trigger() }), $("#export_copy").on("click", function (e) { e.preventDefault(), t.button(1).trigger() }), $("#export_excel").on("click", function (e) { e.preventDefault(), t.button(2).trigger() }), $("#export_csv").on("click", function (e) { e.preventDefault(), t.button(3).trigger() }), $("#export_pdf").on("click", function (e) { e.preventDefault(), t.button(4).trigger() }), (e = $(".m_table_ranking").DataTable({ columnDefs: [{ searchable: !1, orderable: !1, targets: [0, 1, 2, 3, 4, 5, 6, 7, 8] }], order: [[9, "desc"]], buttons: ["print", "copyHtml5", "excelHtml5", "csvHtml5", "pdfHtml5"] })).on("order.dt search.dt", function () { e.column(0, { search: "applied", order: "applied" }).nodes().each(function (t, e) { t.innerHTML = e + 1 }) }).draw(), $("#export_print").on("click", function (t) { t.preventDefault(), e.button(0).trigger() }), $("#export_copy").on("click", function (t) { t.preventDefault(), e.button(1).trigger() }), $("#export_excel").on("click", function (t) { t.preventDefault(), e.button(2).trigger() }), $("#export_csv").on("click", function (t) { t.preventDefault(), e.button(3).trigger() }), $("#export_pdf").on("click", function (t) { t.preventDefault(), e.button(4).trigger() }) } }; jQuery(document).ready(function () { DatatablesExtensionButtons.init() });