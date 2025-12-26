<footer class="bg-blue-50 py-10 mt-auto">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row justify-between items-start gap-8">
            
            <div class="flex space-x-6 w-full md:w-1/2">
                <div class="flex-shrink-0">
                    <img src="{{ asset('logo_mv.png') }}" alt="MV Logo" class="w-20 h-20 rounded-full object-cover shadow-sm">
                </div>
                <div class="text-gray-600 text-sm leading-relaxed">
                    <h3 class="font-bold text-gray-800 mb-1 text-lg">CÔNG TY TNHH MONET</h3>
                    <p>Số ĐKKD: 0315367026. Nơi cấp: Sở Kế hoạch và Đầu tư TP. Hồ Chí Minh</p>
                    <p class="mb-2">Đăng ký lần đầu ngày 01/11/2018</p>
                    <p>Địa chỉ: 38 Nguyễn Trung Trực, P.5, Q. Bình Thạnh, TP. Hồ Chí Minh</p>
                    
                    <div class="mt-4 flex flex-wrap gap-2 text-sm font-medium">
                        <a href="#" class="text-gray-600 hover:text-red-500 transition">Về chúng tôi</a>
                        <span class="text-gray-300">|</span>
                        <a href="#" class="text-gray-600 hover:text-red-500 transition">Chính sách bảo mật</a>
                        <span class="text-gray-300">|</span>
                        <a href="#" class="text-gray-600 hover:text-red-500 transition">Hỗ trợ</a>
                    </div>
                </div>
            </div>

            <div class="w-full md:w-1/2 md:pl-10">
                <h3 class="font-bold text-gray-800 mb-4 border-l-4 border-blue-500 pl-3">ĐỐI TÁC</h3>
                
                <div class="flex flex-wrap gap-3 mb-4">
                    @foreach(['beta-cineplex-v2.jpg', 'cinestar.png', 'dcine.png', 'mega-gs-cinemas.png'] as $logo)
                        <img src="{{ asset('partners/' . $logo) }}" class="w-10 h-10 rounded-full shadow-md object-contain bg-white" alt="Partner">
                    @endforeach
                </div>
                
                <div>
                    <img src="{{ asset('partners/trade.png') }}" class="h-10 w-auto" alt="Bộ Công Thương">
                </div>
            </div>
        </div>
        
        <div class="border-t border-blue-200 mt-8 pt-4 text-center text-xs text-gray-500">
            &copy; {{ date('Y') }} Monet Cinema. All rights reserved.
        </div>
    </div>
</footer>