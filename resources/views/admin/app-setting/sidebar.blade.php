<div class="email-leftbar card">
    <div class="mail-list">
        @can('general-setting.list')
            <a href="{{ route('admin.settings.general') }}"
                class="{{ request()->routeIs('admin.settings.general') ? 'active' : '' }}">
                <i class="ri ri-arrow-right-s-line me-2"></i> General Setting
            </a>
        @endcan
        @can('authentication-setting.list')
            <a href="{{ route('admin.settings.authentication') }}"
                class="{{ request()->routeIs('admin.settings.authentication') ? 'active' : '' }}">
                <i class="ri ri-arrow-right-s-line me-2"></i> Authentication Setting
            </a>
        @endcan
        @can('dashboard-setting.list')
            <a href="{{ route('admin.settings.dashboard') }}"
                class="{{ request()->routeIs('admin.settings.dashboard') ? 'active' : '' }}">
                <i class="ri ri-arrow-right-s-line me-2"></i> Dashboard Setting
            </a>
        @endcan
        @can('payment-method-setting.list')
            <a href="{{ route('admin.settings.paymentMethod') }}"
                class="{{ request()->routeIs('admin.settings.paymentMethod') ? 'active' : '' }}">
                <i class="ri ri-arrow-right-s-line me-2"></i> Payment Methods
            </a>
        @endcan
        @can('mail-setting.list')
            <a href="{{ route('admin.settings.mail') }}"
                class="{{ request()->routeIs('admin.settings.mail') ? 'active' : '' }}">
                <i class="ri ri-arrow-right-s-line me-2"></i> Mail Setting
            </a>
        @endcan
        @can('currency-setting.list')
            <a href="{{ route('admin.settings.currency') }}"
                class="{{ request()->routeIs('admin.settings.currency') ? 'active' : '' }}">
                <i class="ri ri-arrow-right-s-line me-2"></i> Currency Setting
            </a>
        @endcan
    </div>
</div>
{{-- email-leftbar --}}
