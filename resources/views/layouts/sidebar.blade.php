@php
    $user = Auth::user();
    $path = request()->path();

    // منطق فعال بودن هر منو
    $isPeopleActive = Str::is('persons*', $path) || Str::is('receipts*', $path) || Str::is('payments*', $path) ||
                      Str::is('shareholders*', $path) || Str::is('suppliers*', $path);
    $isGoodsActive = Str::is('products*', $path) || Str::is('services*', $path) || Str::is('price-list*', $path) ||
                     Str::is('barcode*', $path) || Str::is('categories*', $path);
    $isBankingActive = Str::is('banks*', $path) || Str::is('funds*', $path) || Str::is('pettycash*', $path) ||
                       Str::is('transfers*', $path) || Str::is('cheques*', $path);
    $isSalesActive = Str::is('sales*', $path) || Str::is('quick-invoice*', $path) || Str::is('return-sales*', $path) ||
                    Str::is('sale-invoices*', $path) || Str::is('return-sale-invoices*', $path) || Str::is('incomes*', $path) ||
                    Str::is('installments*', $path) || Str::is('discounted-items*', $path);
    $isPurchaseActive = Str::is('purchases*', $path) || Str::is('return-purchase*', $path) || Str::is('purchase-invoices*', $path) ||
                        Str::is('return-purchase-invoices*', $path) || Str::is('costs*', $path) || Str::is('wastes*', $path);
    $isWarehouseActive = Str::is('warehouses*', $path) || Str::is('warehouse-transfer*', $path) || Str::is('inventory*', $path) ||
                         Str::is('inventory-all*', $path) || Str::is('inventory-control*', $path);
    $isAccountingActive = Str::is('journals*', $path) || Str::is('trial-balance*', $path) || Str::is('close-year*', $path) ||
                          Str::is('accounts-table*', $path) || Str::is('consolidated-journals*', $path);
    $isOtherActive = Str::is('archive*', $path) || Str::is('sms-panel*', $path) || Str::is('inquiry*', $path) ||
                     Str::is('other-receipts*', $path) || Str::is('other-payments*', $path) ||
                     Str::is('exchange*', $path) || Str::is('balance-persons*', $path) ||
                     Str::is('balance-products*', $path) || Str::is('salary-doc*', $path);
    $isReportActive = Str::is('reports*', $path);
    $isSettingsActive = Str::is('settings*', $path);

@endphp

<aside class="sidebar" id="sidebar">
    <button class="toggle-btn" id="sidebar-toggle" title="باز/بستن سایدبار">
        <i class="fa fa-bars"></i>
    </button>
    <div class="logo" id="sidebar-logo">حسابیر</div>
    @if($user)
        <div class="user-info" id="sidebar-user">
            <img src="{{ $user->profile_photo_url ?? asset('images/default-avatar.png') }}" alt="آواتار کاربر">
            <div class="name">{{ $user->name }}</div>
        </div>
    @endif
    <ul>
        <li class="menu-item">
            <a href="/dashboard" class="menu-link {{ request()->is('dashboard') ? 'active' : '' }}">
                <span class="icon"><i class="fa fa-home"></i></span>
                <span class="menu-text">داشبورد</span>
            </a>
        </li>
        <!-- اشخاص -->
        <li class="menu-item">
            <a href="#" class="menu-link has-submenu" aria-expanded="{{ $isPeopleActive ? 'true' : 'false' }}">
                <span class="icon"><i class="fa fa-user-friends"></i></span>
                <span class="menu-text">اشخاص</span>
                <span class="submenu-arrow"><i class="fa fa-angle-down"></i></span>
            </a>
            <div class="submenu{{ $isPeopleActive ? ' open' : '' }}">
                <a href="/persons/create" class="submenu-link {{ request()->is('persons/create') ? 'active' : '' }}">شخص جدید</a>
                <a href="/persons" class="submenu-link {{ request()->is('persons') ? 'active' : '' }}">اشخاص</a>
                <a href="/receipts" class="submenu-link {{ request()->is('receipts') ? 'active' : '' }}">لیست دریافت ها</a>
                <a href="/payments" class="submenu-link {{ request()->is('payments') ? 'active' : '' }}">لیست پرداخت ها</a>
                <a href="/shareholders" class="submenu-link {{ request()->is('shareholders') ? 'active' : '' }}">سهامداران</a>
                <a href="/suppliers" class="submenu-link {{ request()->is('suppliers') ? 'active' : '' }}">فروشندگان</a>
            </div>
        </li>
        <!-- کالاها و خدمات -->
        <li class="menu-item">
            <a href="#" class="menu-link has-submenu" aria-expanded="{{ $isGoodsActive ? 'true' : 'false' }}">
                <span class="icon"><i class="fa fa-boxes"></i></span>
                <span class="menu-text">کالاها و خدمات</span>
                <span class="submenu-arrow"><i class="fa fa-angle-down"></i></span>
            </a>
            <div class="submenu{{ $isGoodsActive ? ' open' : '' }}">
                <a href="/products/create" class="submenu-link {{ request()->is('products/create') ? 'active' : '' }}">کالای جدید</a>
                <a href="/services/create" class="submenu-link {{ request()->is('services/create') ? 'active' : '' }}">خدمات جدید</a>
                <a href="/products" class="submenu-link {{ request()->is('products') ? 'active' : '' }}">کالاها و خدمات</a>
                <a href="/price-list/update" class="submenu-link {{ request()->is('price-list/update') ? 'active' : '' }}">به روز رسانی لیست قیمت</a>
                <a href="/barcode/print" class="submenu-link {{ request()->is('barcode/print') ? 'active' : '' }}">چاپ بارکد</a>
                <a href="/barcode/batch-print" class="submenu-link {{ request()->is('barcode/batch-print') ? 'active' : '' }}">چاپ بارکد تعدادی</a>
                <a href="/price-list" class="submenu-link {{ request()->is('price-list') ? 'active' : '' }}">صفحه لیست قیمت کالا</a>
                <a href="/categories/create" class="submenu-link {{ request()->is('categories/create') ? 'active' : '' }}">دسته بندی</a>
                <a href="/categories-list" class="submenu-link {{ request()->is('categories-list') ? 'active' : '' }}">لیست دسته‌بندی‌ها</a>
            </div>
        </li>
        <!-- بانکداری -->
        <li class="menu-item">
            <a href="#" class="menu-link has-submenu" aria-expanded="{{ $isBankingActive ? 'true' : 'false' }}">
                <span class="icon"><i class="fa fa-university"></i></span>
                <span class="menu-text">بانکداری</span>
                <span class="submenu-arrow"><i class="fa fa-angle-down"></i></span>
            </a>
            <div class="submenu{{ $isBankingActive ? ' open' : '' }}">
                <a href="/banks" class="submenu-link {{ request()->is('banks') ? 'active' : '' }}">بانک ها</a>
                <a href="/funds" class="submenu-link {{ request()->is('funds') ? 'active' : '' }}">صندوق ها</a>
                <a href="/pettycash" class="submenu-link {{ request()->is('pettycash') ? 'active' : '' }}">تنخواه گردان ها</a>
                <a href="/transfers" class="submenu-link {{ request()->is('transfers') ? 'active' : '' }}">انتقال</a>
                <a href="/transfers/list" class="submenu-link {{ request()->is('transfers/list') ? 'active' : '' }}">لیست انتقال ها</a>
                <a href="/cheques/received" class="submenu-link {{ request()->is('cheques/received') ? 'active' : '' }}">لیست چک های دریافتی</a>
                <a href="/cheques/paid" class="submenu-link {{ request()->is('cheques/paid') ? 'active' : '' }}">لیست چک های پرداختی</a>
            </div>
        </li>
        <!-- فروش و درآمد -->
        <li class="menu-item">
            <a href="#" class="menu-link has-submenu" aria-expanded="{{ $isSalesActive ? 'true' : 'false' }}">
                <span class="icon"><i class="fa fa-cash-register"></i></span>
                <span class="menu-text">فروش و درآمد</span>
                <span class="submenu-arrow"><i class="fa fa-angle-down"></i></span>
            </a>
            <div class="submenu{{ $isSalesActive ? ' open' : '' }}">
                <a href="/sales/create" class="submenu-link {{ request()->is('sales/create') ? 'active' : '' }}">فروش جدید</a>
                <a href="/quick-invoice" class="submenu-link {{ request()->is('quick-invoice') ? 'active' : '' }}">فاکتور سریع</a>
                <a href="/return-sales" class="submenu-link {{ request()->is('return-sales') ? 'active' : '' }}">برگشت از فروش</a>
                <a href="/sale-invoices" class="submenu-link {{ request()->is('sale-invoices') ? 'active' : '' }}">فاکتورهای فروش</a>
                <a href="/return-sale-invoices" class="submenu-link {{ request()->is('return-sale-invoices') ? 'active' : '' }}">فاکتورهای برگشت از فروش</a>
                <a href="/incomes" class="submenu-link {{ request()->is('incomes') ? 'active' : '' }}">درآمد</a>
                <a href="/incomes/list" class="submenu-link {{ request()->is('incomes/list') ? 'active' : '' }}">لیست درآمدها</a>
                <a href="/installments/contract" class="submenu-link {{ request()->is('installments/contract') ? 'active' : '' }}">قرارداد فروش اقساطی</a>
                <a href="/installments/list" class="submenu-link {{ request()->is('installments/list') ? 'active' : '' }}">لیست فروش اقساطی</a>
                <a href="/discounted-items" class="submenu-link {{ request()->is('discounted-items') ? 'active' : '' }}">اقلام تخفیف دار</a>
            </div>
        </li>
        <!-- خرید و هزینه -->
        <li class="menu-item">
            <a href="#" class="menu-link has-submenu" aria-expanded="{{ $isPurchaseActive ? 'true' : 'false' }}">
                <span class="icon"><i class="fa fa-shopping-cart"></i></span>
                <span class="menu-text">خرید و هزینه</span>
                <span class="submenu-arrow"><i class="fa fa-angle-down"></i></span>
            </a>
            <div class="submenu{{ $isPurchaseActive ? ' open' : '' }}">
                <a href="/purchases/create" class="submenu-link {{ request()->is('purchases/create') ? 'active' : '' }}">خرید جدید</a>
                <a href="/return-purchase" class="submenu-link {{ request()->is('return-purchase') ? 'active' : '' }}">برگشت از خرید</a>
                <a href="/purchase-invoices" class="submenu-link {{ request()->is('purchase-invoices') ? 'active' : '' }}">فاکتورهای خرید</a>
                <a href="/return-purchase-invoices" class="submenu-link {{ request()->is('return-purchase-invoices') ? 'active' : '' }}">فاکتورهای برگشت از خرید</a>
                <a href="/costs" class="submenu-link {{ request()->is('costs') ? 'active' : '' }}">هزینه</a>
                <a href="/costs/list" class="submenu-link {{ request()->is('costs/list') ? 'active' : '' }}">لیست هزینه ها</a>
                <a href="/wastes" class="submenu-link {{ request()->is('wastes') ? 'active' : '' }}">ضایعات</a>
                <a href="/wastes/list" class="submenu-link {{ request()->is('wastes/list') ? 'active' : '' }}">لیست ضایعات</a>
            </div>
        </li>
        <!-- انبارداری -->
        <li class="menu-item">
            <a href="#" class="menu-link has-submenu" aria-expanded="{{ $isWarehouseActive ? 'true' : 'false' }}">
                <span class="icon"><i class="fa fa-warehouse"></i></span>
                <span class="menu-text">انبارداری</span>
                <span class="submenu-arrow"><i class="fa fa-angle-down"></i></span>
            </a>
            <div class="submenu{{ $isWarehouseActive ? ' open' : '' }}">
                <a href="/warehouses" class="submenu-link {{ request()->is('warehouses') ? 'active' : '' }}">انبارها</a>
                <a href="/warehouse-transfer" class="submenu-link {{ request()->is('warehouse-transfer') ? 'active' : '' }}">حواله جدید</a>
                <a href="/inventory" class="submenu-link {{ request()->is('inventory') ? 'active' : '' }}">رسید و حواله های انبار</a>
                <a href="/inventory/current" class="submenu-link {{ request()->is('inventory/current') ? 'active' : '' }}">موجودی کالا</a>
                <a href="/inventory-all" class="submenu-link {{ request()->is('inventory-all') ? 'active' : '' }}">موجودی تمامی انبارها</a>
                <a href="/inventory-control" class="submenu-link {{ request()->is('inventory-control') ? 'active' : '' }}">انبار گردانی</a>
            </div>
        </li>
        <!-- حسابداری -->
        <li class="menu-item">
            <a href="#" class="menu-link has-submenu" aria-expanded="{{ $isAccountingActive ? 'true' : 'false' }}">
                <span class="icon"><i class="fa fa-calculator"></i></span>
                <span class="menu-text">حسابداری</span>
                <span class="submenu-arrow"><i class="fa fa-angle-down"></i></span>
            </a>
            <div class="submenu{{ $isAccountingActive ? ' open' : '' }}">
                <a href="/journals/create" class="submenu-link {{ request()->is('journals/create') ? 'active' : '' }}">سند جدید</a>
                <a href="/journals" class="submenu-link {{ request()->is('journals') ? 'active' : '' }}">لیست اسناد</a>
                <a href="/trial-balance" class="submenu-link {{ request()->is('trial-balance') ? 'active' : '' }}">تراز افتتاحیه</a>
                <a href="/close-year" class="submenu-link {{ request()->is('close-year') ? 'active' : '' }}">بستن سال مالی</a>
                <a href="/accounts-table" class="submenu-link {{ request()->is('accounts-table') ? 'active' : '' }}">جدول حساب ها</a>
                <a href="/consolidated-journals" class="submenu-link {{ request()->is('consolidated-journals') ? 'active' : '' }}">تجمیع اسناد</a>
            </div>
        </li>
        <!-- سایر -->
        <li class="menu-item">
            <a href="#" class="menu-link has-submenu" aria-expanded="{{ $isOtherActive ? 'true' : 'false' }}">
                <span class="icon"><i class="fa fa-ellipsis-h"></i></span>
                <span class="menu-text">سایر</span>
                <span class="submenu-arrow"><i class="fa fa-angle-down"></i></span>
            </a>
            <div class="submenu{{ $isOtherActive ? ' open' : '' }}">
                <a href="/archive" class="submenu-link {{ request()->is('archive') ? 'active' : '' }}">آرشیو</a>
                <a href="/sms-panel" class="submenu-link {{ request()->is('sms-panel') ? 'active' : '' }}">پنل پیامک</a>
                <a href="/inquiry" class="submenu-link {{ request()->is('inquiry') ? 'active' : '' }}">استعلام</a>
                <a href="/other-receipts" class="submenu-link {{ request()->is('other-receipts') ? 'active' : '' }}">دریافت سایر</a>
                <a href="/other-receipts/list" class="submenu-link {{ request()->is('other-receipts/list') ? 'active' : '' }}">لیست دریافت ها</a>
                <a href="/other-payments" class="submenu-link {{ request()->is('other-payments') ? 'active' : '' }}">پرداخت سایر</a>
                <a href="/other-payments/list" class="submenu-link {{ request()->is('other-payments/list') ? 'active' : '' }}">لیست پرداخت ها</a>
                <a href="/exchange" class="submenu-link {{ request()->is('exchange') ? 'active' : '' }}">سند تسعیر ارز</a>
                <a href="/balance-persons" class="submenu-link {{ request()->is('balance-persons') ? 'active' : '' }}">سند توازن اشخاص</a>
                <a href="/balance-products" class="submenu-link {{ request()->is('balance-products') ? 'active' : '' }}">سند توازن کالاها</a>
                <a href="/salary-doc" class="submenu-link {{ request()->is('salary-doc') ? 'active' : '' }}">سند حقوق</a>
            </div>
        </li>
        <!-- گزارش ها -->
        <li class="menu-item">
            <a href="/reports" class="menu-link {{ request()->is('reports') ? 'active' : '' }}">
                <span class="icon"><i class="fa fa-chart-bar"></i></span>
                <span class="menu-text">گزارش ها</span>
            </a>
        </li>
        <!-- تنظیمات -->
        <li class="menu-item">
            <a href="/settings" class="menu-link {{ request()->is('settings') ? 'active' : '' }}">
                <span class="icon"><i class="fa fa-cog"></i></span>
                <span class="menu-text">تنظیمات</span>
            </a>
        </li>
    </ul>
</aside>
