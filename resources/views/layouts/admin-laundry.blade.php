<aside class="sidebar">
    <div class="sidebar-header">
        <h5>Admin Laundry</h5>
    </div>

    <ul class="sidebar-menu">
        <li>
            <a href="/admin/laundry/dashboard">
                <i class="icon-dashboard"></i> Dashboard
            </a>
        </li>
        <li>
            <a href="/admin/laundry/orders">
                <i class="icon-orders"></i> Pesanan
            </a>
        </li>
        <li class="logout">
            <form method="POST" action="/logout">
                @csrf
                <button>Logout</button>
            </form>
        </li>
    </ul>
</aside>
