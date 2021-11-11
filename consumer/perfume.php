<main id="perfume_main"> <!-- 향수 상품 페이지 !-->
    <article id="perfume_list_box">
        <?php foreach($data as $item): ?>
            <div id="perfume_list_item">
                <img src="<?= $item['img'] ?>" onclick="location.href='/consumer/perfume/shop/<?= $item['pnum'] ?>';"></img>
                <div id="vertical" style="border-bottom : 1px solid; border-color: rgba(237,237,237);"><p><?= $item['pname'] ?></p></div>
                <div id="vertical"><p><?= number_format($item['pprice']) ?>원</p></div>
            </div>
        <?php endforeach; ?>
    </article>
    <ul>
        <li><a href=""><</a></li>
        <li><a href="/consumer/perfume/pages/1">1</a></li>
        <li><a href="/consumer/perfume/pages/2">2</a></li>
        <li><a href="/consumer/perfume/pages/3">3</a></li>
        <li><a href="">></a></li>

        <!-- 검색 기능 추가할 때 개편예정 !-->
    </ul>
</main>