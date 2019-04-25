var DatatablesBasicBasic = {
    init: function () {
        var e;
        (e = $("#m_table_1")).DataTable({

        }), e.on("change", ".m-group-checkable", function () {
            var e = $(this).closest("table").find("td:first-child .m-checkable"),
                a = $(this).is(":checked");
            $(e).each(function () {
                a ? ($(this).prop("checked", !0), $(this).closest("tr").addClass("active")) : ($(this).prop("checked", !1), $(this).closest("tr").removeClass("active"))
            })
        }), e.on("change", "tbody tr .m-checkbox", function () {
            $(this).parents("tr").toggleClass("active")
        })
    }
};
jQuery(document).ready(function () {
    DatatablesBasicBasic.init()
});
