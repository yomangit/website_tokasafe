<div>
    <div>
        <div class="dropdown dropdown-end">
            <label tabindex="0" class="btn btn-ghost btn-sm btn-circle">
                <div class="indicator">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0" />
                    </svg>
                    <span class="text-xs badge badge-xs indicator-item">{{ auth()->user()->unreadNotifications->count() }}</span>
                </div>
            </label>
            <div tabindex="0" class="mt-3 z-[1] card card-compact dropdown-content w-96 bg-base-100 shadow">
                <div class="card-body">
                    <table>
                        <tbody>
                            @foreach(auth()->user()->unreadNotifications as $notification)
                            <tr>
                                <td class="text-xs font-signika text-sky-400"><a href="{{ $notification->data['url'] }}">{{ $notification->data['greeting'] }} send notification to you</a></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
</div>
