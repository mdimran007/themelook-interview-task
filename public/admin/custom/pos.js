(function ($) {
    "use strict";
    $(document).ready(() => {
        let count = 1;
        $(document).on('click', '.add-to-list', function () {
            if (count == 1) {
                $('#tbody').html('');
            }
            var imgae = $(this).data('product_img');
            var price = $(this).data('product_price');
            var name = $(this).data('product_name');
            var id = $(this).data('id');
            var tax = $(this).data('tax');
            var discount = $(this).data('discount');
            let dynamicRowHTML = `<tr class="rowClass" data-pro_id="${id}">
                                        <td>
                                            <input type="hidden" name="product[]" value="${id}">
                                            <input type="hidden" name="product_price[]" class="product-price" value="${price}">
                                            <input type="hidden" name="product_tax[]" class="product-tax" value="${tax}">
                                            <input type="hidden" name="product_discount[]" class="product-discount" value="${discount}">
                                            <div class="d-flex">
                                                <img src="${imgae}"
                                                     class="card-img-top w-50" alt="img">
                                                <span class="mx-2">${name}</span>
                                            </div>
                                        </td>
                                        <td>
                                            <input class="w-75 form-control product-qty" type="text" value="1" name="product_qty[]">
                                        </td>
                                        <td><span class="product-price-show"></span>$</td>
                                        <td class="text-right">
                                                <a href="#" class="remove">
                                                    <i class="far fa-trash-alt text-danger"></i>
                                                </a>
                                        </td>
                                    </tr>`;

            var appendStatus =0;
            $('.rowClass').each(function (index, item) {
                var pro_id = $(this).data('pro_id');
                if(pro_id == id){
                    appendStatus = 1;
                    var currentQty = $(this).find('input.product-qty').val();
                    $(this).find('input.product-qty').val(parseInt(currentQty)+1);
                }
            });
            if(appendStatus == 0){
                $('#tbody').append(dynamicRowHTML);
            }
            count++;

            priceCalculation();
            subTotalCalculation();
            taxCalculation();
            totalCalculation();
        });

        $(document).on('click', '.remove', function () {
            count--;
            $(this).parent('td.text-right').parent('tr.rowClass').remove();
            priceCalculation();
            subTotalCalculation();
            taxCalculation();
            totalCalculation();
            if(count == 1){
                $('#tbody').append(` <tr>
                                        <td colspan="4" class="text-center">No Item Selected</td>
                                    </tr>`);
            }
        });

        function priceCalculation() {
            $('.rowClass').each(function (index, item) {
                var price = $(this).find('input.product-price').val();
                var qty = $(this).find('input.product-qty').val();
                var total = parseFloat(price) * parseFloat(qty);
                $(this).find('span.product-price-show').text(Math.round(total));
            });
        }

        function subTotalCalculation() {
            var total = 0;
            $('.rowClass').each(function (index, item) {
                var price = $(this).find('span.product-price-show').text();
                total = total + parseFloat(price);
            });
            $('#subTotal').text(Math.round(total));
        }

        function taxCalculation() {
            var total = 0;
            $('.rowClass').each(function (index, item) {
                var tax = $(this).find('input.product-tax').val();
                var qty = $(this).find('input.product-qty').val();
                total = total = (total + parseFloat(tax))*qty;
            });
            $('#taxValue').text(Math.round(total));
        }

        function totalCalculation() {
            var subtoatal = $("#subTotal").text();
            var taxValue = $("#taxValue").text();
            $('#total').text(Math.round(parseFloat(subtoatal)+parseFloat(taxValue)));
        }

        $(document).on('input', '.product-qty', function () {
            priceCalculation();
            subTotalCalculation();
            taxCalculation();
            totalCalculation();
        });

        window.priceCalculation = priceCalculation;
        window.subTotalCalculation = subTotalCalculation;
        window.taxCalculation = taxCalculation;
        window.totalCalculation = totalCalculation;
    })
})(jQuery)
