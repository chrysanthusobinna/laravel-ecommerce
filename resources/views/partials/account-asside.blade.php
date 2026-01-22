	                		<aside class="col-12 col-md-4 col-lg-3">
    <div class="mb-4">
        <ul class="nav nav-dashboard flex-column" role="tablist">
            <li class="nav-item">
                <a class="nav-link {{ Request::routeIs('customer.account') ? 'active' : '' }}" href="{{ route('customer.account') }}">My Account</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Request::routeIs('customer.orders') ? 'active' : '' }}" href="{{ route('customer.orders') }}">Orders</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Request::routeIs('customer.change.password') ? 'active' : '' }}" href="{{ route('customer.change.password') }}">Change Password</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Request::routeIs('customer.edit.profile') ? 'active' : '' }}" href="{{ route('customer.edit.profile') }}">Edit Account</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('product.list') }}">Return to Shopping</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('auth.logout') }}">Logout</a>
            </li>
        </ul>
    </div>
</aside><!-- End .col-lg-3 -->