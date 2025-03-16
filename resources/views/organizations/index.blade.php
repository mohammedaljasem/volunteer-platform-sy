<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('المنظمات') }}
            </h2>
            <div>
                <a href="{{ route('organizations.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 active:bg-blue-700 focus:outline-none focus:border-blue-700 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150">
                    {{ __('إنشاء منظمة جديدة') }}
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif
            
            @if(session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            @endif
            
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    @if($organizations->isEmpty())
                        <div class="text-center py-8">
                            <p class="text-gray-500 text-lg">{{ __('لا توجد منظمات حالياً') }}</p>
                            <a href="{{ route('organizations.create') }}" class="mt-4 inline-block px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors duration-300">
                                {{ __('إنشاء منظمة جديدة') }}
                            </a>
                        </div>
                    @else
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach($organizations as $organization)
                                <div class="border rounded-lg overflow-hidden shadow-md hover:shadow-lg transition-shadow duration-300">
                                    <div class="p-6">
                                        <div class="flex justify-between items-start mb-4">
                                            <h3 class="text-xl font-bold text-gray-800">{{ $organization->name }}</h3>
                                            <span class="px-2 py-1 text-xs rounded {{ $organization->verified ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                                {{ $organization->verified ? __('مُصدقة') : __('غير مُصدقة') }}
                                            </span>
                                        </div>
                                        
                                        <p class="text-sm text-gray-600 mb-4">{{ Str::limit($organization->description, 150) }}</p>
                                        
                                        <div class="flex justify-between items-center text-sm text-gray-600 mb-4">
                                            <span>
                                                <i class="fas fa-users ml-1"></i> {{ $organization->users_count }} {{ __('أعضاء') }}
                                            </span>
                                            <span>
                                                <i class="fas fa-briefcase ml-1"></i> {{ $organization->job_offers_count }} {{ __('فرص') }}
                                            </span>
                                        </div>
                                        
                                        <div class="mt-4">
                                            <a href="{{ route('organizations.show', $organization) }}" class="inline-block px-4 py-2 bg-gray-200 text-gray-800 rounded hover:bg-gray-300 transition-colors duration-300">
                                                {{ __('عرض التفاصيل') }}
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        
                        <div class="mt-6">
                            {{ $organizations->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 