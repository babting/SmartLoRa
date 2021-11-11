<main id="product_basket_main">
    <article id="perfume_basket_list">
        <p>장바구니</p>
        <table border="1" cellspacing="0">
            <tr>
                <th style="width : 15%;">사진</th>
                <th>상품명</th>
                <th style="width : 10%;">수량</th>
                <th style="width : 10%;">금액</th>
                <th style="width : 10%;">취소</th>
            </tr>
            <?php foreach($data as $item): ?>
            <tr id="basket_list_product_<?= $item['pnum']?>">
                <td><img src="<?= $item['img']?>" style="width : 80px; height : 80px;"></img></td>
                <td><?= $item['pname'] ?></td>
                <td><?= $item['pamount']?></td>
                <td><?= number_format($item['pprice'])?>원</td>
                <td><a href="javascript:void(0)" onclick="basketDelete(<?= $item['pnum'] ?>);" id="basket_delete_element">삭제</a></td>
            </tr>    
            <?php endforeach; ?>
        </table>
        <hr>
        <button type="button" onclick="purchase();">주문</button>
    </article>
</main>
</section> 
            <!-- <footer> 
                <p>바닥 영역</p>
            </footer>  !-->
        </div>
        <script>
            const basketDelete = pnum => {
                fetch('http://uniskoal98.dothome.co.kr/consumer/basket_delete_ajax', {
                    method : 'PATCH',
                    body: JSON.stringify({
                        product_num : pnum
                    }),
                    headers : {
                        "Content-type": "application/json; charset=UTF-8",
                        "X-Requested-With": "xmlhttprequest",
                    }
                }).then(result => result.json())
                .then(json => {
                    const basket_list_remove = document.getElementById(`basket_list_product_${pnum}`);
                    basket_list_remove.remove();
                })
                .catch(err => {
                    console.log(err);
                });
            }

            const purchase = () => {
                window.location.href = 'http://uniskoal98.dothome.co.kr/consumer/purchase';
            }
        </script>
    </body>
</html>