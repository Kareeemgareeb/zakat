<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('بوابة المستفيد') }}
        </h2>
    </x-slot>

    <div class="py-12" x-data="beneficiaryPortal()">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    @if(!$user->beneficiary)
                        <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mb-4 rounded">
                            <div class="flex">
                                <div class="ml-3">
                                    <p class="text-sm text-yellow-700 font-bold">
                                        عذراً، حسابك الحالي غير مرتبط بملف مستفيد في صندوق الزكاة. يرجى مراجعة الإدارة.
                                    </p>
                                </div>
                            </div>
                        </div>
                    @else
                        <h3 class="text-2xl font-bold text-blue-800 mb-6 border-b pb-2">بيانات الملف الأساسية</h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                            <div class="bg-gray-50 p-4 rounded-lg border border-gray-200 shadow-sm">
                                <div class="text-sm text-gray-500 mb-1">رقم الملف</div>
                                <div class="text-lg font-bold text-gray-800">{{ $user->beneficiary->file_number }}</div>
                            </div>
                            <div class="bg-gray-50 p-4 rounded-lg border border-gray-200 shadow-sm">
                                <div class="text-sm text-gray-500 mb-1">رب الأسرة</div>
                                <div class="text-lg font-bold text-gray-800">{{ $user->beneficiary->full_name }}</div>
                            </div>
                            <div class="bg-gray-50 p-4 rounded-lg border border-gray-200 shadow-sm">
                                <div class="text-sm text-gray-500 mb-1">حالة الملف</div>
                                <div>
                                    @if($user->beneficiary->eligibility_status === 'VERIFIED')
                                        <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full bg-green-100 text-green-800">معتمد</span>
                                    @elseif($user->beneficiary->eligibility_status === 'PENDING')
                                        <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">قيد المراجعة</span>
                                    @else
                                        <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full bg-red-100 text-red-800">غير مستحق</span>
                                    @endif
                                </div>
                            </div>
                            <div class="bg-gray-50 p-4 rounded-lg border border-gray-200 shadow-sm">
                                <div class="text-sm text-gray-500 mb-1">تاريخ التجديد القادم</div>
                                @php
                                    $dueDate = \Carbon\Carbon::parse($user->beneficiary->next_renewal_due);
                                    $isExpired = $dueDate->isPast();
                                @endphp
                                <div class="text-lg font-bold {{ $isExpired ? 'text-red-600' : 'text-green-600' }}">
                                    {{ $dueDate->format('Y-m-d') }}
                                </div>
                            </div>
                        </div>

                        <!-- File Renewal Section -->
                        <h3 class="text-2xl font-bold text-blue-800 mb-4 border-b pb-2">تجديد الملف السنوي</h3>
                        
                        <div class="bg-blue-50 border border-blue-200 p-6 rounded-lg">
                            @if($isExpired)
                                <div class="mb-4 text-red-600 font-bold">
                                    ⚠️ لقد انتهت صلاحية ملفك. يجب تقديم طلب تجديد سنوي لاستمرار صرف المساعدات.
                                </div>
                                
                                <div x-show="!successMessage">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">ملاحظات إضافية للإدارة (مثال: مولود جديد، تغيير السكن)</label>
                                    <textarea x-model="notes" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 mb-4" rows="3"></textarea>
                                    
                                    <button @click="submitRenewal" :disabled="loading" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded shadow disabled:opacity-50 transition">
                                        <span x-show="!loading">تقديم طلب التجديد</span>
                                        <span x-show="loading">جاري الإرسال...</span>
                                    </button>
                                </div>

                                <div x-show="errorMessage" x-text="errorMessage" class="mt-3 text-red-600 font-bold"></div>
                                <div x-show="successMessage" x-text="successMessage" class="mt-3 text-green-700 font-bold bg-green-100 p-3 rounded"></div>
                            @else
                                <div class="text-green-700 font-bold">
                                    ✅ ملفك ساري المفعول ولا يحتاج إلى تجديد في الوقت الحالي.
                                </div>
                            @endif
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>

    <!-- Alpine.js Logic -->
    <script>
        function beneficiaryPortal() {
            return {
                notes: '',
                loading: false,
                errorMessage: null,
                successMessage: null,

                async submitRenewal() {
                    this.loading = true;
                    this.errorMessage = null;
                    this.successMessage = null;

                    try {
                        const response = await axios.post('/beneficiary/renew-file', {
                            beneficiary_notes: this.notes
                        });
                        this.successMessage = response.data.message;
                    } catch (err) {
                        this.errorMessage = err.response?.data?.error || 'حدث خطأ أثناء إرسال الطلب.';
                    } finally {
                        this.loading = false;
                    }
                }
            }
        }
    </script>
</x-app-layout>

