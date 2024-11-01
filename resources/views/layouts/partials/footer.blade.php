    <section id="footer" class="main-footer">
        <footer class="footer">
            <div class="container">
                <div class="row ">
                    <div class="col-lg-3">
                        <div class="footer_box">
                            {{-- <h3 class="hl_info_footer_title">TIN TỨC</h3> --}}
                            <ul class="footer_list_link ">
                                {{-- <li>
                                    <a  href="{{ route('list-blogs',$tab_blogs->slug) }}">{{ $tab_blogs->title }}</a>
                                </li> --}}
                                {{-- <li>
                                    <a  href="#">Tại sao chúng tôi kinh doanh lĩnh vực này?</a>
                                </li>
                                <li>
                                    <a  href="#">Quá trình phát triển</a>
                                </li>
                                <li>
                                    <a  href="#">Thành tựu,chứng nhận</a>
                                </li>
                                <li>
                                    <a  href="#">Đội ngũ luật sư,chuyên gia tư vấn</a>
                                </li>
                                <li>
                                    <a  href="#">Đội ngũ edukids</a>
                                </li>
                                <li>
                                    <a  href="#">Đánh giá nhận xét từ khách hàng</a>
                                </li>
                                <li>
                                    <a  href="#">Văn hóa doanh nghiệp</a>
                                </li>
                                <li>
                                    <a  href="#">Thiện nguyện</a>
                                </li>
                                <li>
                                    <a  href="#">Tuyển dụng</a>
                                </li>
                                <li>
                                    <a  href="#">Chính sách bảo mật</a>
                                </li> --}}
                            </ul>
                        </div>

                    </div>
                    <div class="col-lg-3">
                        {{-- <div class="footer_box">
                            <h3 class=" hl_info_footer_title">Dịch vụ edukids</h3>
                            <ul class="footer_list_link">
                                <li>
                                    <a href="#" >Bảng tổng hợp các dịch vụ của kidsedu</a>
                                </li>
                                <li>
                                    <a href="#" >Đầu tư định cư mỹ</a>
                                </li>
                                <li>
                                    <a href="#" >Đâu tư định cư Úc</a>
                                </li>
                                <li>
                                    <a href="#" >Đầu tư định cư Việt Nam</a>
                                </li>
                                <li>
                                    <a href="#" >Quốc tịnh châu Âu</a>
                                </li>
                                <li>
                                    <a href="#" >Thường trú vĩnh viễn châu ÂU</a>
                                </li>
                                <li>
                                    <a href="#" >Quốc tịch Pháp</a>
                                </li>
                                <li>
                                    <a href="#" >Thường trú nhân Bồ Đào Nha</a>
                                </li>
                                <li>
                                    <a href="#" >Thường trú nhân Lào</a>
                                </li>
                            </ul>
                        </div> --}}
                    </div>
                    {{-- <div class="col-lg-6">
                        <div class="footer_box">
                            <h3 class=" hl_info_footer_title">{{ __('location') }}</h3>
                            <div class="map-i">
                                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3919.8955010331642!2d106.71087257480434!3d10.74253668940419!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31752f82e6b90d43%3A0x4f30e03d092d2ee!2zMTIwIMSQxrDhu51uZyBz4buRIDQ1LCBUw6JuIFF1eSwgUXXhuq1uIDcsIEjhu5MgQ2jDrSBNaW5oLCBWaeG7h3QgTmFt!5e0!3m2!1svi!2s!4v1723328941016!5m2!1svi!2s" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                            </div>
                        </div>
                    </div> --}}
                    <div class="col-lg-12">
                        <div class="footer-bottom">
                            <p class="mb-2">© 2024 Copyright HỘI DOANH NGHIỆP QUẬN GÒ VẤP</p>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" ></script>
    <script src="https://code.jquery.com/jquery-3.7.1.slim.min.js" ></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js" ></script>
    <script src="https://cdn.jsdelivr.net/npm/bxslider@4.2.17/dist/jquery.bxslider.min.js" ></script>
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>

    <script src="{{ asset('js/script.js') }}" ></script>
    <script src="{{ asset('js/app.js') }}" ></script>
    <script src="{{ asset('js/animation.js') }}" ></script>

    
    <script>
        
        $(document).ready(function() {
            @if (session('success'))
                showToast('{{ session('success') }}', 'success');
            @elseif (session('error'))
                showToast('{{ session('error') }}', 'error');
            @endif
        });
    </script>
    @stack('scripts')
</body>
</html>
