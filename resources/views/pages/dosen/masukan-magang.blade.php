<x-layouts.user.main user="dosen" customContainerClass="w-full h-full">
    <div class="space-y-10 bg-[url(/public/img/wallpaper/wallpaper-chat.png)] h-full relative">
        <div class="p-4 bg-white border-gray-200 shadow-sm z-10 sticky">
            <div class="flex items-center gap-4">
                <img src="{{ asset('img/user/student-girl.png') }}" alt="Profil dosen"
                    class="w-10 h-10 object-cover rounded-full">
                <p class="font-semibold text-gray-800">Adi Bagaskara</p>
            </div>
        </div>

        <div id="chat-messages" class="flex-1 p-4 overflow-y-auto custom-scrollbar h-full">
            <div class="text-center text-xs text-gray-500 my-4">69 Dec 2069</div>
            <div class="flex justify-end mb-4">
                <div class="bg-blue-100 rounded-lg p-3 shadow-sm max-w-[calc(100%-60px)]">
                    <p class="text-base text-gray-800">Good morning sir</p>
                    <p class="text-right text-xs text-gray-500 mt-2">11:21</p>
                </div>
            </div>

            <div class="flex justify-start mb-4">
                <div class="bg-white rounded-lg p-3 shadow-sm max-w-[calc(100%-60px)]">
                    <p class="text-base text-gray-800">Morning!</p>
                    <p class="text-right text-xs text-gray-400 mt-2">11:18</p>
                </div>
            </div>

            <div class="flex justify-end mb-4">
                <div class="bg-blue-100 rounded-lg p-3 shadow-sm max-w-[calc(100%-60px)]">
                    <p class="text-base text-gray-800">How are you today?</p>
                    <p class="text-right text-xs text-gray-500 mt-2">11:21</p>
                </div>
            </div>
            <div class="flex justify-start mb-4">
                <div class="bg-white rounded-lg p-3 shadow-sm max-w-[calc(100%-60px)]">
                    <p class="text-base text-gray-800">Good</p>
                    <p class="text-right text-xs text-gray-400 mt-2">11:18</p>
                </div>
            </div>
        </div>

        <div class="bg-white p-3 border-t border-gray-200 flex items-center absolute bottom-0 w-full">
            <i class="fas fa-smile text-xl text-gray-500 mr-3 cursor-pointer"></i>
            <input type="text" placeholder="Tulis Pesan..."
                class="flex-1 p-2 rounded-full bg-gray-100 border border-gray-200 text-gray-800 focus:outline-none focus:border-blue-400 focus:ring-1 focus:ring-blue-400"
                id="message-input">
            <i class="fas fa-plus-circle text-xl text-gray-500 mx-3 cursor-pointer"></i>
            <flux:button class="bg-magnet-sky-teal! text-white!" icon="send"></flux:button>
        </div>
    </div>
</x-layouts.user.main>
