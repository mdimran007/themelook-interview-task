(function ($) {
    "use strict";
    $(document).ready(function () {
        $(".product-attribute-size").hide();
        $(".product-attribute-color").hide();
    });
    $(document).on('change', '.product-attribute', function () {
        var selectedAttribute = $(this).select2("val");
        selectedAttribute.forEach(function (item) {
            if (item == 'size') {
                $(".product-attribute-size").show();
            } else if (item == 'color') {
                $(".product-attribute-color").show();
            }
        });
    });
    $(document).on('click', '.attribute-remove', function () {
        $(this).closest('.form-group').hide();
    });
})(jQuery)
