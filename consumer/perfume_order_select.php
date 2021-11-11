<main id="product_select_main">
    <article id="perfume_order_select_list">
        <p>주문/조회</p>
        <table border="1" cellspacing="0">
            <tr>
                <th style="width : 10%;">날짜</th>
                <th>주문번호</th>
                <th style="width : 55%;" colspan="2">상품명</th>
                <th style="width : 10%;">주문금액</th>
                <th style="width : 10%;">상태</th>
            </tr>
            <?php foreach($data as $item): ?>
            <tr>
                <td><?= $item['order_date'] ?></td>
                <td><?= $item['PN'] ?></td>
                <td><img src="<?= $item['first_product_img']?>" style="width : 80px; height : 80px;"></img></td>
                <td><?php
                    switch((int) $item['product_count']) {
                        case 1:
                            echo $item['first_product_pname'];
                            break;
                        default:
                            echo $item['first_product_pname'].' 외 '.((int) $item['product_count'] - 1).'건';
                    } 
                ?></td>
                <td><?= number_format($item['total_pprice']) ?>원</td>
                <?php if($item['delivery_state'] === 'prepare'): ?>
                    <td>배송준비</td>
                <?php elseif($item['delivery_state'] === 'delivering'): ?>
                    <td>
                        배송중<br>
                        <a href="/consumer/map/<?= $item['PN'] ?>" style="color:red;">[배송 추적]</a>
                    </td>
                <?php elseif($item['delivery_state'] === 'finished'): ?>
                    <td>배송완료</td>
                <?php endif; ?>
            </tr>    
            <?php endforeach; ?>
        </table>
        <hr>
    </article> 
</main>
</section> 
            <!-- <footer> 
                <p>바닥 영역</p>
            </footer>  !-->
        </div>
    </body>
</html>