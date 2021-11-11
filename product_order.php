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
            <?php foreach($data as $item): ?>
            <tr id="basket_order_product_<?= $item['pnum']?>">
                <td><img src="<?= $item['img']?>" style="width : 80px; height : 80px;"></img></td>
                <td><?= $item['pname'] ?></td>
                <td><?= $item['pamount']?></td>
                <td><?= number_format($item['pprice'])?>원</td>
            </tr>    
            <?php endforeach; ?>
        </table>
        <hr>
        <article id="perfume_order_content">
            <form method="post" name="perfume_order_form">
                <table id="perfume_order_table">
                    <div id="perfume_order_delivery_form"></div>
                    <div id="perfume_order_user_form"></div>
                </table>
            </form>
        </article>
    </article>
</main>
</section> 
            <!-- <footer> 
                <p>바닥 영역</p>
            </footer>  !-->
        </div>
    
    </body>
</html>