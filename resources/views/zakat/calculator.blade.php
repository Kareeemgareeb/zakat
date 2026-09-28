<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('حاسبة الزكاة الإلكترونية') }}
        </h2>
    </x-slot>

    <div class="py-12" x-data="zakatCalculator()">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <h3 class="text-lg font-bold text-blue-700 mb-4">اختر نوع الزكاة</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                        <!-- Cash / Gold -->
                        <div @click="type = 'CASH_WEALTH'" 
                             :class="type === 'CASH_WEALTH' ? 'bg-blue-50 border-blue-500' : 'border-gray-200 hover:bg-gray-50'"
                             class="border-2 rounded-lg p-4 cursor-pointer transition">
                            <div class="font-bold text-center" :class="type === 'CASH_WEALTH' ? 'text-blue-900' : 'text-gray-700'">زكاة المال والذهب</div>
                        </div>
                        <!-- Livestock -->
                        <div @click="type = 'LIVESTOCK'"
                             :class="type === 'LIVESTOCK' ? 'bg-green-50 border-green-500' : 'border-gray-200 hover:bg-gray-50'"
                             class="border-2 rounded-lg p-4 cursor-pointer transition">
                            <div class="font-bold text-center" :class="type === 'LIVESTOCK' ? 'text-green-900' : 'text-gray-700'">زكاة الأنعام</div>
                        </div>
                        <!-- Crops -->
                        <div @click="type = 'CROPS_AGRICULTURE'"
                             :class="type === 'CROPS_AGRICULTURE' ? 'bg-yellow-50 border-yellow-500' : 'border-gray-200 hover:bg-gray-50'"
                             class="border-2 rounded-lg p-4 cursor-pointer transition">
                            <div class="font-bold text-center" :class="type === 'CROPS_AGRICULTURE' ? 'text-yellow-900' : 'text-gray-700'">زكاة الزروع والثمار</div>
                        </div>
                    </div>

                    <form class="space-y-4" @submit.prevent="calculate">
                        <!-- Cash Inputs -->
                        <template x-if="type === 'CASH_WEALTH'">
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">المبلغ النقدي المذخر (دينار ليبي)</label>
                                    <input type="number" x-model="form.amount" required class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" placeholder="أدخل المبلغ هنا...">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">سعر جرام الذهب عيار 24 اليوم (لغرض حساب النصاب)</label>
                                    <input type="number" x-model="form.gold_price_per_gram" required class="w-full border-gray-300 rounded-md shadow-sm bg-gray-50 focus:ring-blue-500 focus:border-blue-500">
                                </div>
                            </div>
                        </template>

                        <!-- Livestock Inputs -->
                        <template x-if="type === 'LIVESTOCK'">
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">نوع الأنعام</label>
                                    <select x-model="form.animal_type" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500">
                                        <option value="sheep">الغنم (الضأن والماعز)</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">العدد (الرأس)</label>
                                    <input type="number" x-model="form.count" required class="w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500" placeholder="أدخل عدد رؤوس الأنعام...">
                                </div>
                            </div>
                        </template>

                        <!-- Crops Inputs -->
                        <template x-if="type === 'CROPS_AGRICULTURE'">
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">وزن المحصول (بالكيلوجرام)</label>
                                    <input type="number" x-model="form.kilograms" required class="w-full border-gray-300 rounded-md shadow-sm focus:ring-yellow-500 focus:border-yellow-500" placeholder="أدخل الوزن بالكيلوجرام...">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">طريقة الري (السقي)</label>
                                    <select x-model="form.is_irrigated" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-yellow-500 focus:border-yellow-500">
                                        <option value="0">سقي بماء السماء (بعلاً) - 10%</option>
                                        <option value="1">سقي بالآلات والكلفة (ري اصطناعي) - 5%</option>
                                    </select>
                                </div>
                            </div>
                        </template>
                        
                        <!-- Error Message -->
                        <div x-show="error" x-text="error" class="text-red-600 font-bold text-sm mt-2" style="display: none;"></div>

                        <div class="pt-4">
                            <button type="submit" :disabled="loading" 
                                    :class="type === 'LIVESTOCK' ? 'bg-green-600 hover:bg-green-700' : (type === 'CROPS_AGRICULTURE' ? 'bg-yellow-600 hover:bg-yellow-700' : 'bg-blue-700 hover:bg-blue-800')"
                                    class="w-full text-white font-bold py-3 px-4 rounded-md shadow transition disabled:opacity-50">
                                <span x-show="!loading">احسب الزكاة الآن</span>
                                <span x-show="loading">جاري الحساب...</span>
                            </button>
                        </div>
                    </form>

                    <!-- Results Section -->
                    <div x-show="result" class="mt-8 p-6 bg-gray-50 border border-gray-200 rounded-lg shadow-inner" style="display: none;">
                        <h4 class="text-xl font-extrabold text-gray-800 mb-2">نتيجة الحساب الشرعي</h4>
                        
                        <div x-show="!result?.is_eligible" class="text-green-700 font-bold text-lg bg-green-100 p-3 rounded">
                            المال المدخل لم يبلغ النصاب، فلا تجب فيه الزكاة.
                        </div>

                        <div x-show="result?.is_eligible" class="space-y-3">
                            <div class="flex justify-between border-b pb-2">
                                <span class="text-gray-600">مقدار الزكاة الواجب إخراجها:</span>
                                <span class="font-bold text-red-600 text-lg" x-text="result?.zakat_due + ' ' + (result?.currency || result?.unit)"></span>
                            </div>
                            <div class="flex justify-between border-b pb-2 text-sm">
                                <span class="text-gray-500">حالة النصاب:</span>
                                <span class="font-bold text-gray-700">بلغ النصاب</span>
                            </div>
                            <div class="flex justify-between border-b pb-2 text-sm">
                                <span class="text-gray-500">التفاصيل الفقهية:</span>
                                <span class="font-bold text-gray-700" x-text="result?.breakdown"></span>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <!-- Alpine.js Logic -->
    <script>
        function zakatCalculator() {
            return {
                type: 'CASH_WEALTH',
                loading: false,
                error: null,
                result: null,
                form: {
                    amount: null,
                    gold_price_per_gram: 350,
                    animal_type: 'sheep',
                    count: null,
                    kilograms: null,
                    is_irrigated: "0"
                },
                
                async calculate() {
                    this.loading = true;
                    this.error = null;
                    this.result = null;

                    try {
                        const response = await axios.post('/api/zakat/calculate', {
                            calculation_type: this.type,
                            amount: this.form.amount,
                            gold_price_per_gram: this.form.gold_price_per_gram,
                            animal_type: this.form.animal_type,
                            count: this.form.count,
                            kilograms: this.form.kilograms,
                            is_irrigated: this.form.is_irrigated === "1"
                        });

                        this.result = response.data.results;
                    } catch (err) {
                        this.error = 'حدث خطأ أثناء الاتصال بالخادم. الرجاء التأكد من البيانات.';
                    } finally {
                        this.loading = false;
                    }
                }
            }
        }
    </script>
</x-app-layout>

