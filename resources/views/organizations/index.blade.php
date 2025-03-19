<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('المنظمات') }}
            </h2>
            <div>
                <a href="{{ route('organizations.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 active:bg-blue-700 focus:outline-none focus:border-blue-700 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150 dark:hover:bg-blue-600 dark:focus:ring-blue-400">
                    {{ __('إنشاء منظمة جديدة') }}
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4 dark:bg-green-900/40 dark:border-green-800 dark:text-green-300" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif
            
            @if(session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4 dark:bg-red-900/40 dark:border-red-800 dark:text-red-300" role="alert">
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            @endif
            
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
                    @if($organizations->isEmpty())
                        <div class="text-center py-8">
                            <p class="text-gray-500 dark:text-gray-400 text-lg">{{ __('لا توجد منظمات حالياً') }}</p>
                            <a href="{{ route('organizations.create') }}" class="mt-4 inline-block px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors duration-300 dark:bg-blue-700 dark:hover:bg-blue-600">
                                {{ __('إنشاء منظمة جديدة') }}
                            </a>
                        </div>
                    @else
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach($organizations as $organization)
                                <div class="border rounded-lg overflow-hidden shadow-md hover:shadow-lg transition-shadow duration-300 bg-white dark:bg-gray-800 dark:border-gray-700">
                                    @if($organization->verified)
                                        <div class="bg-green-50 dark:bg-green-900/20 text-green-700 dark:text-green-300 text-xs px-2 py-1 absolute left-2 top-2 rounded">
                                            {{ __('مُصدقة') }}
                                        </div>
                                    @else
                                        <div class="bg-yellow-50 dark:bg-yellow-900/20 text-yellow-700 dark:text-yellow-300 text-xs px-2 py-1 absolute left-2 top-2 rounded">
                                            {{ __('غير مُصدقة') }}
                                        </div>
                                    @endif
                                    
                                    <div class="p-6">
                                        <h3 class="text-xl font-bold text-gray-800 dark:text-gray-200 mb-3">{{ $organization->name }}</h3>
                                        
                                        <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">{{ Str::limit($organization->description, 150) }}</p>
                                        
                                        <div class="flex justify-between items-center text-sm text-gray-600 dark:text-gray-400 mb-4">
                                            <span>
                                                <i class="fas fa-users ml-1"></i> {{ $organization->users_count }} {{ __('أعضاء') }}
                                            </span>
                                            <span>
                                                <i class="fas fa-briefcase ml-1"></i> {{ $organization->job_offers_count }} {{ __('فرص') }}
                                            </span>
                                        </div>
                                        
                                        <div class="mt-4">
                                            <a href="{{ route('organizations.show', $organization) }}" class="inline-block px-4 py-2 bg-gray-200 text-gray-800 rounded hover:bg-gray-300 transition-colors duration-300 dark:bg-gray-700 dark:text-gray-200 dark:hover:bg-gray-600">
                                                {{ __('عرض التفاصيل') }}
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        
                        <div class="mt-6 dark:text-gray-200">
                            {{ $organizations->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 