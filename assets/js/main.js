(function($) {

    const wrapper                = $('#pc-crypto-form-wrap');
    const form                   = $('#pc-crypto-form');
    const currencyInput          = $('#pc-currency');
    const convertInput           = $('#pc-convert');
    const container              = $('.pc-input-wrapper');
    const selectCurrencyLeft     = $('#pc-select-currency-btn-1');
    const selectCurrencyRight    = $('#pc-select-currency-btn-2');
    const revertBtn              = $('#pc-revert-btn');
    const table                  = $('#pc-history-table');
    const img_src                = 'https://s2.coinmarketcap.com/static/img/coins/64x64/';

    let saveDelay;
    let currencyPair = {
        currency: [1, 'BTC'],
        convert: [2781, 'USD'],
    };

    const options = {
        'templateSelection': custom_template,
        'templateResult': custom_template,
    };

    function custom_template(obj) {
        const val = $(obj.element).val();
        const text = $(obj.element).text();
        return $(`<img src="${img_src}${val}.png" alt="${text}" style="width:26px;height:26px;margin-right:5px;"/><span style="font-weight: 700;font-size:14px;text-align:left;font-family:Arial,Helvetica,sans-serif;">${text}</span>`);
    }

    function setSymbol() {
        selectCurrencyLeft.html(`<img src="${img_src}${currencyPair['currency'][0]}.png" title="${currencyPair['currency'][1]}" alt="${currencyPair['currency'][1]}">`);
        selectCurrencyRight.html(`<img src="${img_src}${currencyPair['convert'][0]}.png" title="${currencyPair['convert'][1]}" alt="${currencyPair['convert'][1]}">`);
    }

    function pcGetList() {
        const formData = {
            action: 'pc_get_currency_list',
        };

        $.post(pc_var_obj.ajax_url, formData, function(data, status) {
            if (status === 'success') {
                container.each(function(i) {
                    let select = $(this).find('.pc-currency-type');

                    $(data).appendTo(select);
                    select.attr('id', 'pc-select-' + (i + 1)).select2(options);

                    $('.select2-container--default .select2-selection--single').css({'height': '42px'});
                });
                setSymbol();
                $('#pc-select-1').val('1').trigger('change');
            } else {
                console.log('fail ->', data, `\nStatus -> ${status}`);
                return [];
            }
        });
    }

    function pcGetRate(currency, convert) {
        form.addClass('loading');

        const formData = {
            action: 'pc_get_price',
            amount: 1,
            id: currency,
            convert_id: convert,
        };

        $.post(pc_var_obj.ajax_url, formData, function(data, status) {
            if (status === 'success') {
                localStorage.setItem('pc_price', data);
                updateInputs('left');
                form.removeClass('loading');
            } else {
                console.log('fail ->', data, `\nStatus -> ${status}`);
                form.removeClass('loading').addClass('error');
            }
        });
    }

    function updateInputs(direction = 'left') {
        const rate = +localStorage.getItem('pc_price');
        let thisVal = currencyInput.val();
        let convertedPrice = thisVal * rate;
        let target = convertInput;
        if (direction === 'right') {
            thisVal = convertInput.val();
            convertedPrice = thisVal / rate;
            target = currencyInput;
        }
        target.val(convertedPrice);
    }

    function saveResults(amount) {
        const formData = {
            action: 'pc_set_conversion_history',
            price: localStorage.getItem('pc_price'),
            currency: currencyPair.currency[1],
            convert: currencyPair.convert[1],
            amount,
        };
        $.post(pc_var_obj.ajax_url, formData, function(data, status) {
            if (status === 'success') {
                showResults();
            } else {
                console.log('fail ->', data, `\nStatus -> ${status}`);
            }
        });
    }

    function showResults() {
        const formData = {
            action: 'pc_get_conversion_history',
        };
        $.post(pc_var_obj.ajax_url, formData, function(data, status) {
            if (status === 'success') {
                table.html(data);
            } else {
                console.log('fail ->', data, `\nStatus -> ${status}`);
            }
        });
    }

    $(document).ready(function() {

        if (wrapper.width() < 601) {
            wrapper.addClass('compact-view');
        } else {
            wrapper.removeClass('compact-view');
        }

        $(window).resize(function() {
            if (wrapper.width() < 601) {
                wrapper.addClass('compact-view');
            } else {
                wrapper.removeClass('compact-view');
            }
        });

        pcGetRate(currencyPair.currency[0], currencyPair.convert[0]);
        pcGetList();
        showResults();

        selectCurrencyLeft.on('click', function() {
            $('#pc-select-1').select2('open');
        });

        selectCurrencyRight.on('click', function() {
            $('#pc-select-2').select2('open');
        });

        currencyInput.on('input', function() {

            const thisVal = $(this).val();

            $(this).val(thisVal.replace(/[^\d]/, ''));

            updateInputs('left');

            clearTimeout(saveDelay);

            saveDelay = setTimeout(function() {
                saveResults(thisVal);
            }, 1500);
        });

        convertInput.on('input', function() {

            const thisVal = convertInput.val();
            $(this).val(thisVal.replace(/[^\d]/, ''));

            updateInputs('right');

            const thatVal = currencyInput.val();
            clearTimeout(saveDelay);

            saveDelay = setTimeout(function() {
                saveResults(thatVal);
            }, 1500);
        });

    });

    container.find('.pc-currency-type').on('select2:select', function(e) {
        let data = e.params.data;
        const curSymbol = data.element.dataset.symbol;

        if (data._resultId.indexOf('select2-pc-select-1') > -1) {
            currencyPair.currency[0] = data.id;
            currencyPair.currency[1] = curSymbol;
        } else {
            currencyPair.convert[0] = data.id;
            currencyPair.convert[1] = curSymbol;
        }
        pcGetRate(currencyPair.currency[0], currencyPair.convert[0]);
        setSymbol();

    });

    revertBtn.on('click', function() {
        const cur = currencyPair.currency;
        const con = currencyPair.convert;
        $('#pc_select-1').val(con).trigger('change');
        $('#pc_select-2').val(cur).trigger('change');
        currencyPair.currency = con;
        currencyPair.convert = cur;
        setSymbol();
        pcGetRate(currencyPair.currency[0], currencyPair.convert[0]);
    });

})(jQuery);

