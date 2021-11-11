<main id="product_success_main">
    <article id="product_success_content">
        <img src="/images/present.png" alt="주문성공">
        <p style="font-size : 36px; margin-top : 20px;">주문/결제가 정상적으로 완료되었습니다</p>
        <p style="font-size : 18px; margin-top : 45px; margin-bottom : 45px;">저희 스마트로라를 이용해 주셔서 감사합니다.</p>
        <div id="product_success_content_information">
            <p style="font-weight : bold;"><?= $_SESSION['username']?>의 주문내역</p>
            <p style="font-size : 26px; margin-top : 20px; margin-bottom : 20px;">주문번호 <span style="color : #8ed2c7;"><?= $pn ?></span></p>
            <p>주문내역 관리는 <strong><a href="/consumer/order_select">[주문/조회]</a></strong> 에서 하실 수 있습니다</p>
        </div>
    </article>
</main>
</section> 
            <!-- <footer> 
                <p>바닥 영역</p>
            </footer>  !-->
        </div>
    </body>
</html>