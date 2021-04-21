THE_TITLE

<div id="pc-crypto-form-wrap">
    <form id="pc-crypto-form">
        <div class="pc-currency pc-input-wrapper">
            <input id="pc-currency" pattern="\d*" name="pc_currency" value="1" type="text">
            <div id="pc-select-currency-btn-1" class="pc-select-currency-btn"></div>
            <div id="pc-currency-list" class="pc-dropdown-wrapper">
                <select class="pc-currency-type">
                    PREDEFINED_LIST_OF_CURRENCIES
                </select><!-- /.pc_currency-type -->
            </div>
        </div><!-- /#pc_currency -->

        <span id="pc-revert-btn">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="22" viewBox="0 0 16 22">
                <path d="M0 6.875v-3.75h10.82V0L16 5l-5.18 5V6.875H0zM16 18.875v-3.75H5.18V12L0 17l5.18 5v-3.125H16z"></path>
            </svg>
        </span>

        <div class="pc-convert pc-input-wrapper">
            <input id="pc-convert" name="pc_convert" type="text">
            <div id="pc-select-currency-btn-2" class="pc-select-currency-btn"></div>
            <div id="pc-convert-list" class="pc-dropdown-wrapper">
                <select class="pc-currency-type">
                    PREDEFINED_LIST_OF_CURRENCIES
                </select><!-- /.pc_currency-type -->
            </div>
        </div><!-- /.pc_convert -->
    </form><!-- /#pc-crypto-form -->

    <div id="pc-history-table"></div>
</div><!-- /#pc-crypto-form-wrap -->
