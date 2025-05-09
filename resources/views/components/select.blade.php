@props(['value', 'name', 'error','disable','step'])
<select  @isset($step) disabled @endif  {{ $attributes->class([
    'select select-bordered select-xs w-full pr-8 px-3 bg-transparant border shadow-sm border-slate-300
    placeholder-slate-400
    focus:outline-none focus:border-sky-500 focus:ring-sky-500 block w-full sm:text-xs font-semibold focus:ring-1 ',
    'border-rose-500 ring-1 ring-rose-500 outline-none ' => $error,
    ]) }} >
    {{ $slot }}

</select>