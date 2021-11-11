<main id="product_buy_main">
    <article id="perfume_shop">
        <div id="perfume_shop_product">
            <img src="<?= $data[0]['img'] ?>" alt="제품이미지"></img>
        </div>
        <div id="perfume_shop_purchase">
            <div id="perfume_shop_interface">
                <p><?= $data[0]['pname'] ?></p>
                <form method="post" name="perfume_shop_interface_select">
                    <input type="hidden" name="product_pnum" value="<?= $data[0]['pnum'] ?>">
                    <input type="hidden" name="product_image" value="<?= $data[0]['img'] ?>">
                    <input type="hidden" name="product_pname" value="<?= $data[0]['pname'] ?>">
                    <input type="hidden" name="product_pprice" value="<?= $data[0]['pprice'] ?>">
                    <table border="0" id="perfume_shop_table">
                        <tr>
                            <td>판매가격</td>
                            <td style="font-weight:900;" class="perfume_pprice"><?= number_format($data[0]['pprice'])?>원</td>
                        </tr>
                        <tr>
                            <td>수량</td>
                            <td>
                                <input id="product_count" type="text" name="amount" size="4" maxlength="3" value="1">
                                <a href="javascript:void(0)" onclick="countChange('up');" id="count_up_btn">수량증가</a>
                                <a href="javascript:void(0)" onclick="countChange('down');" id="count_down_btn">수량감소</a>
                            </td>
                        </tr>
                    </table>
                    <input type="submit" formaction="/consumer/purchase" value="주문하기">
                    <input id="basketButton" type="button" value="장바구니"> 
                </form>
            </div>
        </div>
    </article>
    <div id="basket_notice"> <!-- 알림판 !-->
        <p id="notice_text"></p>
        <p>지금 확인하시겠습니까?</p>
        <a href="/consumer/basket">예</a>
        <a id="basket_cancel">계속쇼핑</a>
    </div>
</main>
</section> 
            <!-- <footer> 
                <p>바닥 영역</p>
            </footer>  !-->
        </div>
        <script>

            let pprice = document.querySelector('.perfume_pprice'); // 가격이 유동적으로 변하는 부분
            const product_value = document.getElementById('product_count'); // 갯수 변동 부분
            
            function priceToString(price) {
                return price.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ',');
            }

            function perfume_price(number) {
                pprice.innerText = `${priceToString(parseInt(<?= $data[0]['pprice'] ?>) * number)}원`;
            }

            function countChange(change) {
                
                if(parseInt(product_value.value) === 1 && change === 'down') { // 아무일도 안일어 나게 막음 
                }
                else {
                    let count = parseInt(product_value.value);
                    count = (change === 'up') ? ++count : --count;

                    console.log(count);
                    product_value.value = count;
                    perfume_price(count);
                }
            }
            
            function addBasket() {
                
                // ajax 요청을 동기적으로 제어해서 장바구니 기능을 수행하는 코드
                return new Promise((resolve , reject) => {
                    const ajax = new XMLHttpRequest();

                    // 전송할 데이터 만들기
                    let product = {
                        email : "<?= $_SESSION['userid'] ?>",
                        pnum : <?= $data[0]['pnum'] ?>,
                        img : "<?= $data[0]['img'] ?>",
                        pname : "<?= $data[0]['pname'] ?>",
                        pprice : <?= $data[0]['pprice'] ?>,
                        pamount : parseInt(product_value.value)
                    }

                    ajax.open('POST' , 'http://uniskoal98.dothome.co.kr/consumer/basket_ajax');
                    ajax.setRequestHeader("X-Requested-With",'xmlhttprequest');
                    ajax.setRequestHeader('Content-type', 'application/json');
                    
                    ajax.onreadystatechange = function() {
                        if(ajax.readyState !== XMLHttpRequest.DONE) return;

                        if(ajax.status >= 200 && ajax.status <= 400) {
                            resolve(ajax.responseText);
                        }
                        else {
                            reject(new Error(ajax.status));
                        }
                    }

                    ajax.send(JSON.stringify(product));
                });
            }

            // 장바구니 기능을 구현하기 위한 Promise 생성
            const target = document.getElementById('basketButton');
            let notice = document.getElementById('basket_notice');
            let cancel = document.getElementById('basket_cancel');
            let text = document.getElementById('notice_text');

            function toggle(str) {
                text.innerText = str;
                notice.style.display = "block";
            }

            cancel.addEventListener('click' , () => { // 알림판을 껐을 때
                notice.style.display = "none";
            });

            target.addEventListener('click' , async () => {
                try {
                    const result = await addBasket();

                    if(result === "성공!") { // db를 넣는데 성공했으므로 그와 관련된 문구를 보여주는 UI를 나타낸다.
                        toggle("상품이 장바구니에 담겼습니다.");
                    }
                    else { // 중복된 제품을 장바구니에 넣으려고 하는 경우
                        toggle("상품이 이미 장바구니에 존재합니다.");
                    }
                } catch(e) {
                    console.log(e); // 예외 발생시 console 출력으로 원인 파악
                }
            });

            

            
        </script>
    </body>
</html>