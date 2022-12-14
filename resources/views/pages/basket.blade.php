@extends('layouts.app')

@section('content')

    <main>

        <section class="basket">
            <h2 class="basket_title">{{ t('Your Basket') }}</h2>
            <div class="basket_main">
                <div class="basket_left-column">
                <div class="basket_items">

                    @if(!empty($order['ready_stories']))
                        @foreach($order['ready_stories'] as $key => $item)
                            <div class="basket_item">
                                <div class="basket_item-info">
                                    <img src="{{ asset('images/characterPage/girl.png') }}" width="71" height="101" class="basket_item-img" alt="story_photo">

                                    <div class="basket_item-text">
                                        <h3 class="basket_item-title">{{ \App\Models\Stories::find($item['story_id'])->name }}</h3>
                                        <p class="basket_item-name">{{ $item['character_name'] }}</p>
                                        <p class="has-picture">Without picture</p>
                                    </div>
                                </div>

                                <div class="price">
                                    <span class="price_number">{{ get_story_price($item['story_id'], true) }}</span>
                                    <a href="{{ u('basket-remove-item/' . $key) }}"><img src="{{ asset('images/delete.svg') }}" alt="delete item" class="delete" id="firstDelete"></a>
                                    <a href="http://materlu.loc/en/customize/4/name" class="basket_edit-settings"> Edit options</a>
                                </div>
                            </div>
                        @endforeach

                        <a href="{{ u('cuentos') }}" class="another_story">{{ t('Add another Story') }}</a>
                        <a href="{{ u('checkout') }}" class="basket_check go_to_checkout_btn second__check" id="check">{{ t('Go to Checkout') }}<img src="{{ asset('images/characterPage/right-arrow.png') }}" alt="arrow" class="button_arrow"> </a>
                    @else
                        <span class="another_story">{{ t('No books...') }}</span>
                    @endif


                </div>
                <div class="shipping">
                        <h3 class="shipping_title">{{ t('Shipping options') }}</h3>
                        <form action="{{ u('set-delivery') }}" method="post">
                            <div class="basket_dropdowns">
                            @csrf
                            <div class="country" id="basket_country_delivery_drop_items">
                                <p id="selectCountry" class="select_country">{{ get_current_delivery_country()->name }}</p>
                                <img src="{{ asset('images/indexPage/down-arrow.svg') }}" class="dropdown_arrow" alt="arrow">
                                <div class="drop_hidden2" id="dropdown2">
                                    @foreach(get_delivery_countries() as $country)
                                        <div class="dropdown_item2" data-country-id="{{ $country->id }}">
                                            <div class="dropdowm_inner_item2">
                                                <p class="dropdown_inner_item2-text">{{ $country->name }}</p>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            
                            <div class="country" id="basket_type_delivery_drop_items">
                                <p id="select_type" class="select_type">Standart delivery</p>
                                <img src="{{ asset('images/indexPage/down-arrow.svg') }}" class="dropdown_arrow" alt="arrow">
                                <div class="drop_hidden2" id="dropdownDeliveryType">
                                <div class="dropdown_item2" data-country-id="{{ $country->id }}">
                                            <div class="dropdowm_inner_item2">
                                                <p class="dropdown_inner_item2-text">Standart delivery</p>
                                            </div>
                                        </div>
                                        <div class="dropdown_item2" data-country-id="{{ $country->id }}">
                                            <div class="dropdowm_inner_item2">
                                                <p class="dropdown_inner_item2-text">Express delivery</p>
                                            </div>
                                        </div>
                                  
                                </div>
                            </div>
                            </div>
                        </form>
                        <div class="delivery-and-shipping"> 
                        <div class="delivery_box">
                            <p class="duration">{{ t('Estimated delivery time') }} </p>
                            <span class="duration_time"><span class="delivery-days">{{ get_delivery_days(get_current_delivery_country()->id) }}</span> {{ t('days') }}</span></span>
                        </div>
                        <div class="shipping_box">
                            <p class="shipping_price">{{ t('Shipping') }}</p>
                            <span class="shipping_price-count">{{ get_basket_delivery_price(true) }}</span>
                        </div>
                        </div> 
                    </div>
                </div>

                <div class="basket_settings">

                    <div class="order">
                        <h3 class="order_title">{{ t('Order details') }}</h3>
                        <div class="order_item">
                        <div class="discount__holder-disabled">
                        <p class="subtotal">{{ t('Discount Code') }}</p>

                        <form action="{{ u('set-discount') }}" method="post" id="discountCode">
                            @csrf

                            @if(session()->get('order.discount'))
                                <p class="accepted-discount">{{ t('Your discount is accepted') }}</p>
                                <input type="hidden" name="remove_discount" value="1">
                                <img src="{{ asset('images/delete.svg') }}" alt="delete item" class="remote_code" id="firstDelete">
                            @else
                                <input type="text" name="code" required class="half first_input half_basket" placeholder="Code">
                                <button class="discount_check ok" id="check">{{ t('OK') }}</button>
                            @endif

                        </form>

                    </div>
                    <div class="discount__holder-question discount__holder-question-js">
                        <div class="attention-icon">!</div>
                        <p class="discount-question">Do you have a discount code?</p>
                    </div>
                    </div>
                        <div class="order_items">
                            <div class="order_item1">
                                <p class="subtotal">{{ t('Currency') }}</p>

                                <div class="select_items1" id="dropDown1">
                                    <span id="currency1" class="settings_currency">{{ get_current_currency()->name }}</span>
                                    <img src="{{ asset('images/indexPage/down-arrow.svg') }}" width="15" height="8" alt="arrow" class="dropdown_arrow">

                                    <div class="drop_hidden2" id="dropdown0">

                                        <form id="change-currency-form" action="{{ u('currency') }}" method="post">
                                            @csrf
                                            @foreach (get_currencies() as $key => $item)
                                                <div class="dropdown_item5">
                                                    <input type="radio" id="currency-4{{ $key }}" name="currency" value="{{ $item->code }}"
                                                           class="l3">
                                                    <label for="currency-4{{ $key }}" class="c1">{{ $item->name }}</label>
                                                </div>
                                            @endforeach
                                        </form>

                                        {{--<div class="dropdown_item5">--}}
                                            {{--US Dollars--}}
                                        {{--</div>--}}


                                        {{--<div class="dropdown_item5">--}}
                                            {{--EU Euro--}}

                                        {{--</div>--}}
                                    </div>
                                </div>
                            </div>

                            <div class="order_item">
                                <p class="subtotal">{{ t('Subtotal') }}</p>
                                <span class="subtotal_price">{{ get_basket_subtotal_price(true) }}</span>
                            </div>

                            <div class="order_item">
                                <p class="delivery">{{ t('Delivery') }}</p>
                                <span class="delivery_price">{{ get_basket_delivery_price(true) }}</span>
                            </div>

                            <div class="order_item basket_total">
                                <p class="total_title">{{ t('Total') }}</p>
                                <span class="total_price">{{ get_basket_total_price(true) }}</span>
                            </div>
                        </div>

                        <img src="{{ asset('images/line.svg') }}" alt="line" class="order_line" width="1" height="195">
                    </div>

                    <a href="{{ u('checkout') }}" class="basket_check go_to_checkout_btn" id="check">{{ t('Go to Checkout') }}<img src="{{ asset('images/characterPage/right-arrow.png') }}" alt="arrow" class="button_arrow"> </a>
                </div>

            </div>
        </section>

    {{--<div class="popup popup-js">--}}
        {{--<div class="popup_rel">--}}
        {{--<img src="data:image/jpeg;base64,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" alt="popup image">--}}
        {{--<span class="cancel_popup cancel_popup-js">&times;</span>--}}
        {{--</div>--}}
    {{--</div>--}}

        {{--<div class="popup_bg popup_bg-js"></div>--}}



    </main>

    <script>
        gtag('event', 'load', {'event_category': 'basket', 'event_label': 'main_web', 'value':'1'});
    </script>

@endsection