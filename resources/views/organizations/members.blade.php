<div class="mt-8">
    <h3 class="text-lg font-medium text-gray-900">{{ __('أعضاء المنظمة') }}</h3>
    
    @if(count($organization->users) === 0)
        <div class="mt-4 text-gray-500">
            {{ __('لا يوجد أعضاء في هذه المنظمة حالياً.') }}
        </div>
    @else
        <div class="mt-4 overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                            {{ __('الاسم') }}
                        </th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                            {{ __('البريد الإلكتروني') }}
                        </th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                            {{ __('الدور') }}
                        </th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                            {{ __('تاريخ الانضمام') }}
                        </th>
                        @php
                            $isManager = DB::table('organization_user')
                                ->where('user_id', Auth::id())
                                ->where('organization_id', $organization->id)
                                ->where('role', 'مدير')
                                ->exists();
                        @endphp
                        @if($isManager)
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                            {{ __('الإجراءات') }}
                        </th>
                        @endif
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($organization->users as $user)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="text-sm font-medium text-gray-900">{{ $user->name }}</div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-500">{{ $user->email }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $user->pivot->role === 'مدير' ? 'bg-green-100 text-green-800' : 'bg-blue-100 text-blue-800' }}">
                                {{ $user->pivot->role }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $user->pivot->created_at ? \Carbon\Carbon::parse($user->pivot->created_at)->format('Y-m-d') : __('غير متوفر') }}
                        </td>
                        @if($isManager)
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            @if($user->id !== Auth::id())
                            <form method="POST" action="{{ route('organizations.remove-member', $organization) }}" class="inline-block">
                                @csrf
                                @method('DELETE')
                                <input type="hidden" name="user_id" value="{{ $user->id }}">
                                <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('{{ __('هل أنت متأكد من إزالة هذا العضو؟') }}')">
                                    {{ __('إزالة') }}
                                </button>
                            </form>
                            @if($user->pivot->role !== 'مدير')
                            <form method="POST" action="{{ route('organizations.update-member-role', $organization) }}" class="inline-block ml-2">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="user_id" value="{{ $user->id }}">
                                <input type="hidden" name="role" value="مدير">
                                <button type="submit" class="text-blue-600 hover:text-blue-900">
                                    {{ __('ترقية لمدير') }}
                                </button>
                            </form>
                            @else
                            <form method="POST" action="{{ route('organizations.update-member-role', $organization) }}" class="inline-block ml-2">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="user_id" value="{{ $user->id }}">
                                <input type="hidden" name="role" value="عضو">
                                <button type="submit" class="text-gray-600 hover:text-gray-900">
                                    {{ __('تخفيض لعضو') }}
                                </button>
                            </form>
                            @endif
                            @else
                            <span class="text-gray-400">{{ __('أنت') }}</span>
                            @endif
                        </td>
                        @endif
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
    
    @if($isManager)
    <div class="mt-6">
        <h4 class="text-md font-medium text-gray-900">{{ __('إضافة عضو جديد') }}</h4>
        <form method="POST" action="{{ route('organizations.add-member', $organization) }}" class="mt-2">
            @csrf
            <div class="flex space-x-2 space-x-reverse">
                <div class="w-2/3">
                    <input type="email" name="email" placeholder="{{ __('البريد الإلكتروني للعضو') }}" required class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                    @error('email')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="w-1/3">
                    <select name="role" required class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                        <option value="عضو">{{ __('عضو') }}</option>
                        <option value="مدير">{{ __('مدير') }}</option>
                    </select>
                </div>
                <div>
                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 active:bg-blue-700 focus:outline-none focus:border-blue-700 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150">
                        {{ __('إضافة') }}
                    </button>
                </div>
            </div>
        </form>
    </div>
    @endif
</div> 