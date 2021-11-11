<main> <!-- 콘텐츠가 표시될 주요 영역 !-->
<div class="back_grd">
        <div class="s_text_hd">
          <p>믿을 수 있는 스마트 패키징</p>
          <p>SmartLoRa</p>
        </div>

        <div class="cons_img_sort">
          <img src="/images/perfume.png" alt="logo">
        </div>

        <div class="main_contnent_sort">

          <section>
            <div class="slideshow-container">

              <div id="content_one" class="mySlides fade main_contnent_l">
                
              </div>

              <div id="content_two" class="mySlides fade main_contnent_l">
                
              </div>

              <div class="dot_sort">
                <span class="dot" onclick="currentSlide(0)"></span>
                <span class="dot" onclick="currentSlide(1)"></span>
              </div>
            </div>

          </section>


          <!-- <div class="main_contnent_l">
            <p>SmartLoRa</p>
            <p>더 나은 서비스</p>
          </div> -->
          <div id="consumer_content_perfume" class="main_contnent_c">
            <div class="b_square_hd">
              <p>향수</p>
            </div>

          </div>
          <div id="consumer_content_order_select" class="main_contnent_r">
            <div class="b_square_hd">
              <p>주문/조회</p>
            </div>
          </div>

        </div>
      </div>
</main>
</section> 
            <!-- <footer> 
                <p>바닥 영역</p>
            </footer>  !-->
        </div>
        <script>
            const go_perfume = document.getElementById('consumer_content_perfume');

            go_perfume.addEventListener('click' , () => {
                location.href= 'http://uniskoal98.dothome.co.kr/consumer/perfume/pages/1';
            });

            const go_order = document.getElementById('consumer_content_order_select');

            go_order.addEventListener('click' , () => {
                location.href= 'http://uniskoal98.dothome.co.kr/consumer/order_select';
            });
        </script>
    </body>
</html>