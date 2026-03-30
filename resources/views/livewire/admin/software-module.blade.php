<div>
    <div class="row">
        <div class="col-12">

            <h3 class="text-info">This section describes how you want to use Pro Remedy Investment script.</h3>
            <form action="">
                <div class="row">
                    <div class="mt-4 col-md-6">

                        <h5 class="">Investment:</h5>
                        <div class="selectgroup">
                            <label class="selectgroup-item">
                                <input type="radio" class="selectgroup-input" name="investment"
                                    wire:click="updateModule('investment', 'true')"
                                    {{ $mod['investment'] ? 'checked' : '' }}>
                                <span class="selectgroup-button">Enabled</span>
                            </label>
                            <label class="selectgroup-item">
                                <input type="radio" class="selectgroup-input" name="investment"
                                    wire:click="updateModule('investment', 'false')"
                                    {{ $mod['investment'] ? '' : 'checked' }}>
                                <span class="selectgroup-button">Disabled</span>
                            </label>
                        </div>
                        <div class="mt-2 pr-3">
                            <small class="">All features relating to user investment will be
                                displayed on user dashboard(buying of plan and earning profit etc..).</small>
                        </div>
                    </div>

                    <div class="mt-4 col-md-6">
                        <h5 class="">Crypto Swap:</h5>
                        <div class="selectgroup">
                            <label class="selectgroup-item">
                                <input type="radio" class="selectgroup-input" name="cryptoswap"
                                    wire:click="updateModule('cryptoswap','true')"
                                    {{ $mod['cryptoswap'] ? 'checked' : '' }}>
                                <span class="selectgroup-button">Enabled</span>
                            </label>
                            <label class="selectgroup-item">
                                <input type="radio" class="selectgroup-input" name="cryptoswap"
                                    wire:click="updateModule('cryptoswap','false')"
                                    {{ $mod['cryptoswap'] ? '' : 'checked' }}>
                                <span class="selectgroup-button">Disabled</span>
                            </label>
                        </div>
                        <div class="mt-2">
                            <small class="">If enabled, the system will display all
                                functionalities about crypto swapping on user dashboard.</small>
                        </div>
                    </div>


                    <div class="mt-4 col-md-6">
                        <h5 class="">Membership/Course:</h5>
                        <div class="selectgroup">
                            <label class="selectgroup-item">
                                <input type="radio" class="selectgroup-input" name="membership"
                                    wire:click="updateModule('membership', 'true')"
                                    {{ $mod['membership'] ? 'checked' : '' }}>
                                <span class="selectgroup-button">Enabled</span>
                            </label>
                            <label class="selectgroup-item">
                                <input type="radio" class="selectgroup-input" name="membership"
                                    wire:click="updateModule('membership', 'false')"
                                    {{ $mod['membership'] ? '' : 'checked' }}>
                                <span class="selectgroup-button">Disabled</span>
                            </label>
                        </div>
                        <div class="mt-2">
                            <small class="">If enabled, the system will display all
                                course and education features on user dashboard.</small>
                        </div>
                    </div>

                    <div class="mt-4 col-md-6">
                        <h5 class="">Trading Signal:</h5>
                        <div class="selectgroup">
                            <label class="selectgroup-item">
                                <input type="radio" class="selectgroup-input" name="signal"
                                    wire:click="updateModule('signal', 'true')"
                                    {{ $mod['signal'] ? 'checked' : '' }}>
                                <span class="selectgroup-button">Enabled</span>
                            </label>
                            <label class="selectgroup-item">
                                <input type="radio" class="selectgroup-input" name="signal"
                                    wire:click="updateModule('signal', 'false')"
                                    {{ $mod['signal'] ? '' : 'checked' }}>
                                <span class="selectgroup-button">Disabled</span>
                            </label>
                        </div>
                        <div class="mt-2 text-right">
                            <small class="">If enabled, users will see the option to buy signal subscription.</small>
                        </div>
                    </div>                </div>
            </form>
        </div>
    </div>
</div>
