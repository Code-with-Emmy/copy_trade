<div class="row">
    <div class="col-md-8 offset-md-2">
        <form action="javascript:void(0)" method="POST" id="coinpayform">
            @csrf
            @method('PUT')
            <div class="form-group">
                <h5 class="">Merchant ID</h5>
                <input class="form-control  " placeholder="Merchant ID" type="text" name="cp_m_id"
                    value="{{ old('cp_m_id', data_get($cpd, 'cp_m_id')) }}" required>
            </div>

            <div class="form-group">
                <h5 class="">CoinPayment IPN Secret</h5>
                <input class="form-control  " placeholder="CoinPayment IPN Secret" type="text" name="cp_ipn_secret"
                    value="{{ old('cp_ipn_secret', data_get($cpd, 'cp_ipn_secret')) }}" required>
            </div>

            <div class="form-group">
                <h5 class="">CoinPayments debug email</h5>
                <input class="form-control  " placeholder="CoinPayments debug email" type="text"
                    name="cp_debug_email" value="{{ old('cp_debug_email', data_get($cpd, 'cp_debug_email')) }}" required>
            </div>
            <div class="form-group">
                <h5 class="">Public key</h5>
                <input class="form-control  " placeholder="Public key" type="text" name="cp_p_key"
                    value="{{ old('cp_p_key', data_get($cpd, 'cp_p_key')) }}" required>
            </div>
            <div class="form-group">
                <h5 class="">Private key</h5>
                <input class="form-control  " placeholder="Private key" type="text" name="cp_pv_key"
                    value="{{ old('cp_pv_key', data_get($cpd, 'cp_pv_key')) }}" required>
            </div>
            <div class="form-group">
                <input type="submit" class="px-5 btn btn-primary btn-lg" value="Save">
            </div>
        </form>
    </div>
</div>
