@props([
    'activity',
    'showActions' => true,
    'compact' => false
])

<div {{ $attributes->merge(['class' => 'bg-white dark:bg-gray-800 rounded-xl overflow-hidden shadow-soft hover:shadow-card transition-all duration-300 border border-gray-100 dark:border-gray-700']) }}>
    <div class="relative overflow-hidden h-1">
        <div class="absolute top-0 right-0 left-0 h-1 
            @if($activity['color'] == 'blue') bg-blue-500
            @elseif($activity['color'] == 'green') bg-green-500
            @elseif($activity['color'] == 'yellow') bg-yellow-500
            @elseif($activity['color'] == 'indigo') bg-indigo-500
            @elseif($activity['color'] == 'red') bg-red-500
            @else bg-gray-500
            @endif">
        </div>
    </div>
    
    <div class="p-4 sm:p-5">
        <div class="flex items-start gap-3">
            <div class="flex-shrink-0">
                <div class="h-12 w-12 rounded-full 
                    @if($activity['color'] == 'blue') bg-blue-100 dark:bg-blue-900
                    @elseif($activity['color'] == 'green') bg-green-100 dark:bg-green-900
                    @elseif($activity['color'] == 'yellow') bg-yellow-100 dark:bg-yellow-900
                    @elseif($activity['color'] == 'indigo') bg-indigo-100 dark:bg-indigo-900
                    @elseif($activity['color'] == 'red') bg-red-100 dark:bg-red-900
                    @else bg-gray-100 dark:bg-gray-900
                    @endif 
                    flex items-center justify-center">
                    
                    @if($activity['icon'] == 'add')
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 
                            @if($activity['color'] == 'blue') text-blue-600 dark:text-blue-400
                            @elseif($activity['color'] == 'green') text-green-600 dark:text-green-400
                            @elseif($activity['color'] == 'yellow') text-yellow-600 dark:text-yellow-400
                            @elseif($activity['color'] == 'indigo') text-indigo-600 dark:text-indigo-400
                            @elseif($activity['color'] == 'red') text-red-600 dark:text-red-400
                            @else text-gray-600 dark:text-gray-400
                            @endif" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z" clip-rule="evenodd" />
                        </svg>
                    @elseif($activity['icon'] == 'money')
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 
                            @if($activity['color'] == 'blue') text-blue-600 dark:text-blue-400
                            @elseif($activity['color'] == 'green') text-green-600 dark:text-green-400
                            @elseif($activity['color'] == 'yellow') text-yellow-600 dark:text-yellow-400
                            @elseif($activity['color'] == 'indigo') text-indigo-600 dark:text-indigo-400
                            @elseif($activity['color'] == 'red') text-red-600 dark:text-red-400
                            @else text-gray-600 dark:text-gray-400
                            @endif" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z" />
                        </svg>
                    @elseif($activity['icon'] == 'badge')
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 
                            @if($activity['color'] == 'blue') text-blue-600 dark:text-blue-400
                            @elseif($activity['color'] == 'green') text-green-600 dark:text-green-400
                            @elseif($activity['color'] == 'yellow') text-yellow-600 dark:text-yellow-400
                            @elseif($activity['color'] == 'indigo') text-indigo-600 dark:text-indigo-400
                            @elseif($activity['color'] == 'red') text-red-600 dark:text-red-400
                            @else text-gray-600 dark:text-gray-400
                            @endif" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                    @else
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 
                            @if($activity['color'] == 'blue') text-blue-600 dark:text-blue-400
                            @elseif($activity['color'] == 'green') text-green-600 dark:text-green-400
                            @elseif($activity['color'] == 'yellow') text-yellow-600 dark:text-yellow-400
                            @elseif($activity['color'] == 'indigo') text-indigo-600 dark:text-indigo-400
                            @elseif($activity['color'] == 'red') text-red-600 dark:text-red-400
                            @else text-gray-600 dark:text-gray-400
                            @endif" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-8.707l-3-3a1 1 0 00-1.414 0l-3 3a1 1 0 001.414 1.414L9 9.414V13a1 1 0 102 0V9.414l1.293 1.293a1 1 0 001.414-1.414z" clip-rule="evenodd" />
                        </svg>
                    @endif
                </div>
            </div>
            
            <div class="flex-1">
                <div class="flex items-center justify-between">
                    <h3 class="text-md font-medium text-gray-900 dark:text-white">{{ $activity['title'] }}</h3>
                    <span class="text-sm text-gray-500 dark:text-gray-400">{{ $activity['date']->diffForHumans() }}</span>
                </div>
                
                @if(!empty($activity['subtitle']) && !$compact)
                <p class="mt-1.5 text-sm text-gray-600 dark:text-gray-300">
                    {{ $activity['subtitle'] }}
                </p>
                @endif
                
                @if(!empty($activity['meta']))
                <div class="flex flex-wrap gap-2 mt-2">
                    @foreach($activity['meta'] as $key => $value)
                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium 
                        @if($activity['color'] == 'blue') bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200
                        @elseif($activity['color'] == 'green') bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200
                        @elseif($activity['color'] == 'yellow') bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200
                        @elseif($activity['color'] == 'indigo') bg-indigo-100 text-indigo-800 dark:bg-indigo-900 dark:text-indigo-200
                        @elseif($activity['color'] == 'red') bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200
                        @else bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-200
                        @endif">
                        {{ $key }}: {{ $value }}
                    </span>
                    @endforeach
                </div>
                @endif
                
                @if($showActions && !$compact)
                <div class="mt-3">
                    <a href="{{ $activity['link'] }}" class="inline-flex items-center text-sm font-medium 
                        @if($activity['color'] == 'blue') text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300
                        @elseif($activity['color'] == 'green') text-green-600 hover:text-green-800 dark:text-green-400 dark:hover:text-green-300
                        @elseif($activity['color'] == 'yellow') text-yellow-600 hover:text-yellow-800 dark:text-yellow-400 dark:hover:text-yellow-300
                        @elseif($activity['color'] == 'indigo') text-indigo-600 hover:text-indigo-800 dark:text-indigo-400 dark:hover:text-indigo-300
                        @elseif($activity['color'] == 'red') text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300
                        @else text-gray-600 hover:text-gray-800 dark:text-gray-400 dark:hover:text-gray-300
                        @endif">
                        عرض التفاصيل
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 -mt-0.5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M12.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </a>
                </div>
                @endif
            </div>
        </div>
    </div>
</div> 