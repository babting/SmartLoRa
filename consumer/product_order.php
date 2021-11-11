<main id="product_order_main">
<article id="perfume_order_list">
        <p>주문하기</p>
        <table border="1" cellspacing="0">
            <caption>주문리스트</caption>
            <tr>
                <th style="width : 15%;">사진</th>
                <th>상품명</th>
                <th style="width : 10%;">수량</th>
                <th style="width : 10%;">금액</th>
            </tr>
            <?php 
                $totalPrice = 0; // 총 상품금액
                $fee = 2500; // 배송비 
            ?>
            <?php foreach($data as $item): ?>
            <tr id="basket_order_product_<?= $item['pnum']?>">
                <td><img src="<?= $item['img']?>" style="width : 80px; height : 80px;"></img></td>
                <td><?= $item['pname'] ?></td>
                <td><?= $item['pamount']?></td>
                <td><?= number_format((int) $item['pprice'] * (int) $item['pamount'])?>원</td>
                <?php $totalPrice += (int) $item['pprice'] * (int) $item['pamount'];?>
            </tr>    
            <?php endforeach; ?>
        </table>
        <article id="perfume_order_content">
            <form method="post" name="perfume_order_form" action="/consumer/purchase_execute" onsubmit="return valid_order();">
                <?php if(isset($data[0]['order_process'])): ?>
                    <input type="hidden" name="order_process" value="single">
                    <input type="hidden" name="single_pnum" value="<?= $data[0]['pnum'] ?>">
                <?php endif; ?>
                <p>배송지 정보</p>
                <div id="perfume_order_table">
                    <div class="perfume_table_tr">
                        <div id="perfume_order_delivery_form">
                            <ul>
                                <li style="padding-bottom:4px;">배송지</li>
                                <li>
                                    <input type="text" id="takeNameInput" name="takename" size="20" maxlength="20" placeholder="받는이">
                                    <button type="button" onclick="equal_consumer();">주문자 정보와 동일</button>
                                </li>
                                <li>
                                    <input type="text" id="fiveNumberInput" name="fivenumber" size="20" maxlength="20" placeholder="우편번호" readonly>
                                    <button type="button" onclick="sample6_execDaumPostcode();">주소 검색</button>
                                </li>
                                <li>
                                    <input type="text" id="addressInput" name="address" size="35" maxlength="35" placeholder="주소" readonly>
                                    <input type="text" id="addressDetailInput" name="address_detail" size="35" maxlength="35" placeholder="상세주소" >
                                </li>
                                <li style="font-size:14px; padding-top:15px;">배송지 : 대한민국</li>
                                <li>
                                    <input type="text" name="delivery_message" size="100" maxlength="300" placeholder="배송 메시지를 입력 해 주세요">
                                </li>
                            </ul>
                        </div>
                        <div id="perfume_order_user_form">
                            <ul>
                                <li style="padding-bottom:4px;">주문자</li>
                                <li>
                                    <input type="text" id="userNameInput" name="username" size="20" maxlength="20" placeholder="이름">
                                    <button type="button" onclick="equal_delivery();">사용자 계정과 동일</button>
                                </li>
                                <li>
                                    <input type="text" id="perfumeOrderPhoneOne" name="user_phone[]" size="3" maxlength="4" placeholder="휴대폰">&nbsp-
                                    <input type="text" id="perfumeOrderPhoneTwo" name="user_phone[]" size="3" maxlength="4">&nbsp-
                                    <input type="text" id="perfumeOrderPhoneThree" name="user_phone[]" size="3" maxlength="4">
                                </li>
                                <li>
                                    <input type="text" id="perfumeOrderEmail" name="user_email" size="20" maxlength="40" placeholder="이메일">
                                </li>
                                <li style="font-size:13px; padding-top:5px;">
                                    - 주문자 정보로 주문관련 정보가 문자와 이메일로 발송됩니다.
                                </li>
                                <li style="font-size:13px;">
                                    - 정확한 휴대폰번호와 이메일주소를 확인하세요.
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="perfume_table_tr">
                        <div id="perfume_order_purchase_form"></div>
                        <div id="perfume_order_price_form">
                            <ul style="padding : 20px 10px 10px 15px;">
                                <li>
                                    <ul class="perfume_order_price_list">
                                        <li>상품금액</li>
                                        <li><?= number_format($totalPrice) ?>원</li>
                                    </ul>
                                </li>
                                <li>
                                    <ul class="perfume_order_price_list" style="padding-bottom : 20px;">
                                        <li>배송비</li>
                                        <li><?= number_format($fee) ?>원</li>
                                    </ul>
                                </li>
                                <li>
                                    <ul class="perfume_order_price_list" style="padding-top : 10px; border-top : 1px solid rgba(0,0,0,0.5);">
                                        <li>최종 결제금액</li>
                                        <li style="color:red;"><?= number_format($fee + $totalPrice) ?>원</li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div id="perfume_order_button">
                    <input type="submit" value="주문하기">
                    <button id="return" type="button" onclick="return_basket();">장바구니로 돌아가기</button>
                </div>
            </form>
        </article>
    </article>
</main>
</section> 
            <!-- <footer> 
                <p>바닥 영역</p>
            </footer>  !-->
        </div>
        <script>
            const equal_delivery = () => { 
                const usernameinput = document.getElementById('userNameInput');
                const perfumeorderphoneone = document.getElementById('perfumeOrderPhoneOne');
                const perfumeorderphonetwo = document.getElementById('perfumeOrderPhoneTwo');
                const perfumeorderphonethree = document.getElementById('perfumeOrderPhoneThree');
                const perfumeorderemail = document.getElementById('perfumeOrderEmail');

                usernameinput.value= "<?= $_SESSION['username']?>";
                
                const userphone = "<?= $_SESSION['userphone'] ?>".split('-');
                console.log(userphone);

                perfumeorderphoneone.value = userphone[0];
                perfumeorderphonetwo.value = userphone[1];
                perfumeorderphonethree.value = userphone[2];

                perfumeorderemail.value= "<?= $_SESSION['userid']?>";
            }

            const equal_consumer = () => {
                const takenameinput = document.getElementById('takeNameInput');
                const usernameinput = document.getElementById('userNameInput');

                takenameinput.value = usernameinput.value;
            }

            const return_basket = () => {
                window.location.href = 'http://uniskoal98.dothome.co.kr/consumer/basket';
            }

            const valid_order = () => {
                return true;
            }
        </script>
    </body>
</html>