
<select class="form-control form-control-sm courierStore" name="courier_store">
    <option value="">Select Store</option>
    @if(isset($stores['data']['data']))
    @foreach($stores['data']['data'] as $store)
        <option value="{{ $store['store_id'] }}">{{ $store['store_name'] }}</option>
    @endforeach
    @endif
</select>

<div class="input-group">
    <select class="form-control form-control-sm courierDistrict" name="courier_district" data-url="{{route('admin.ordersAction',['courier-district',$order->id])}}">
        <option value="">Select District</option>
        @if(isset($districts['data']['data']))
        @foreach($districts['data']['data'] as $district)
            <option value="{{ $district['city_id'] }}">{{ $district['city_name'] }}</option>
        @endforeach
        @endif
    </select>

    <select class="form-control form-control-sm courierCity" name="courier_city">
        <option value="">Select Area</option>
    </select>
</div>
