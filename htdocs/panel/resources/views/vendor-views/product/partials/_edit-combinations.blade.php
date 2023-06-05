@if(count($combinations) > 0)
    <table class="table table-bordered">
        <thead>
        <tr>
            <td class="text-center">
                <label for="" class="control-label">{{translate('messages.Variant')}}</label>
            </td>
            <td class="text-center">
                <label for="" class="control-label">{{translate('messages.Variant Price')}}</label>
            </td>
            @if($stock)
            <td class="text-center">
                <label for="" class="control-label text-capitalize">{{translate('messages.stock')}}</label>
            </td>
            @endif
        </tr>
        </thead>
        <tbody>

        @foreach ($combinations as $key => $combination)
            <tr>
                <td>
                    <label for="" class="control-label">{{ $combination['type'] }}</label>
                </td>
                <td>
                    <input type="number" name="price_{{ $combination['type'] }}"
                           value="{{$combination['price']}}" min="0"
                           step="0.01"
                           class="form-control" required>
                </td>
                @if ($stock)
                    <td>
                        <input type="number" name="stock_{{ $combination['type'] }}" value="{{$combination['stock']??0}}" min="0" step="0.01"
                                class="form-control" required>
                    </td>
                @endif
            </tr>
        @endforeach
        </tbody>
    </table>
@endif
