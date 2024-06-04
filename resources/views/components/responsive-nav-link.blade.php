 @props(['active'])

 @php
     $classes = $active ?? false ? 'block w-full pl-3 pr-4 py-2 border-l-4 border-blue-6 text-left text-base font-bold text-blue-8 bg-blue-1 focus:outline-none focus:outline-none focus:text-blue-2 focus:border-blue-6 transition duration-150 ease-in-out' : 'block w-full pl-3 pr-4 py-2 border-l-4 border-transparent text-left text-base font-medium text-blue-5 hover:text-blue-2 hover:border-blue-2 focus:outline-none focus:text-blue-2 focus:border-blue-2 transition duration-150 ease-in-out';
 @endphp

 <a {{ $attributes->merge(['class' => $classes]) }}>
     {{ $slot }}
 </a>
