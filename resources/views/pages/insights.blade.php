@extends('layouts.app')
@section('title', 'تحليلات AI وذكاء الأعمال')
@section('page-title', '✨ تحليلات الذكاء الاصطناعي')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6" x-data="aiChat()">
    
    {{-- Left Column: Placeholder --}}
    <div class="lg:col-span-2 flex items-center justify-center bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-2xl p-12 shadow-sm border-dashed">
        <div class="text-center">
            <div class="text-5xl mb-4 opacity-20">📊</div>
            <h2 class="text-2xl font-bold text-gray-300 dark:text-gray-700 uppercase tracking-widest">قريباً</h2>
            <p class="text-gray-500 mt-2 text-sm">نحن نعمل على تطوير لوحة تحليلات متقدمة بالذكاء الاصطناعي</p>
        </div>
    </div>

    {{-- Right Column: AI Chat --}}
    <div class="lg:col-span-1">
        <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-2xl flex flex-col h-[calc(100vh-12rem)] sticky top-24 shadow-xl overflow-hidden">
            {{-- Chat Header --}}
            <div class="p-4 border-b border-gray-100 dark:border-gray-800 bg-gray-50/50 dark:bg-gray-800/50 flex items-center gap-3">
                <div class="w-8 h-8 rounded-full bg-gradient-to-tr from-purple-500 to-blue-500 flex items-center justify-center text-white text-xs shadow-inner">AI</div>
                <div>
                    <h3 class="text-sm font-bold text-gray-900 dark:text-white">مساعد ليالي العمر الذكي</h3>
                    <p class="text-[10px] text-emerald-500 flex items-center gap-1">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                        مدعوم بواسطة Gemini
                    </p>
                </div>
            </div>

            {{-- Chat Messages --}}
            <div class="flex-1 overflow-y-auto p-4 space-y-4 bg-gray-50/30 dark:bg-black/10" id="chat-container">
                <template x-for="msg in messages" :key="msg.id">
                    <div :class="msg.role === 'user' ? 'flex justify-end' : 'flex justify-start'">
                        <div :class="msg.role === 'user' 
                            ? 'bg-primary-600 text-white rounded-2xl rounded-tr-none px-4 py-2 max-w-[85%] text-sm shadow-sm' 
                            : 'bg-white dark:bg-gray-800 text-gray-800 dark:text-gray-200 border border-gray-200 dark:border-gray-700 rounded-2xl rounded-tl-none px-4 py-2 max-w-[85%] text-sm shadow-sm'"
                            x-text="msg.text">
                        </div>
                    </div>
                </template>
                <div x-show="loading" class="flex justify-start">
                    <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-2xl rounded-tl-none px-4 py-2 text-sm flex gap-1">
                        <span class="w-1.5 h-1.5 rounded-full bg-gray-400 animate-bounce"></span>
                        <span class="w-1.5 h-1.5 rounded-full bg-gray-400 animate-bounce [animation-delay:0.2s]"></span>
                        <span class="w-1.5 h-1.5 rounded-full bg-gray-400 animate-bounce [animation-delay:0.4s]"></span>
                    </div>
                </div>
            </div>

            {{-- Chat Input --}}
            <div class="p-4 border-t border-gray-100 dark:border-gray-800">
                <form @submit.prevent="sendMessage()" class="relative">
                    <input type="text" x-model="newMessage" placeholder="اسألني أي شيء عن عملك..." 
                           class="w-full bg-gray-50 dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-xl pl-12 pr-4 py-3 text-sm text-gray-900 dark:text-white focus:outline-none focus:border-primary-500 transition-all"
                           :disabled="loading">
                    <button type="submit" class="absolute left-2 top-2 w-8 h-8 bg-primary-600 text-white rounded-lg flex items-center justify-center hover:bg-primary-500 transition-colors"
                            :disabled="loading || !newMessage.trim()">
                        <svg class="w-4 h-4 rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </button>
                </form>
                <p class="text-[9px] text-gray-500 mt-2 text-center">الذكاء الاصطناعي قد يخطئ، يرجى مراجعة القرارات الهامة.</p>
            </div>
        </div>
    </div>
</div>

<script>
function aiChat() {
    return {
        messages: [
            { id: 1, role: 'ai', text: 'أهلاً بك! أنا مساعدك الذكي في ليالي العمر. كيف يمكنني مساعدتك اليوم في تحليل بيانات المحل أو تقديم نصائح؟' }
        ],
        newMessage: '',
        loading: false,

        async sendMessage() {
            if (!this.newMessage.trim() || this.loading) return;

            const userText = this.newMessage;
            this.messages.push({ id: Date.now(), role: 'user', text: userText });
            this.newMessage = '';
            this.loading = true;

            this.scrollToBottom();

            try {
                const response = await fetch('{{ route('insights.chat') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ message: userText })
                });

                const data = await response.json();
                this.messages.push({ id: Date.now() + 1, role: 'ai', text: data.response });
            } catch (error) {
                this.messages.push({ id: Date.now() + 1, role: 'ai', text: 'عذراً، حدث خطأ في الاتصال. يرجى المحاولة مرة أخرى.' });
            } finally {
                this.loading = false;
                this.scrollToBottom();
            }
        },

        scrollToBottom() {
            setTimeout(() => {
                const container = document.getElementById('chat-container');
                container.scrollTop = container.scrollHeight;
            }, 50);
        }
    }
}
</script>
@endsection

