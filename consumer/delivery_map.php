<main id="product_map_main">
    <article id="product_map_content">
    </article>
    <article class="menu">
        <div id="menu_slide">
            <div id="menu_content">
                <div id="menu_order">
                    <p id="product_number">주문번호</p>
                    <div id="image_box"></div>
                    <p id="product_pname">이름</p>
                    <p id="product_delivery">배송지</p>
                    <p id="product_infomation">부가정보</p>
                </div>
                <div id="menu_delivery">
                    <p id="menu_delivery_name">배송현황</p>
                    <?php foreach($problem as $item): ?>
                        <div id="menu_problem_list">
                            <p style="font-size:18px; padding: 12px 0px 15px 8px;"><?= $item['description'] ?></p>
                            <p style="float : right; padding : 0px 8px 12px 0px;">발생일 : <?= $item['problem_date'] ?></p>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
        <button type="button" id="menu_button" onclick="slides();"> 메뉴 </button>
    </article>
    
</main>
</section> 
            <!-- <footer> 
                <p>바닥 영역</p>
            </footer>  !-->
        </div>
        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCrm2cdiaHLaSWq8yIEsDqM33KONc7pjmM&callback=initMap&libraries=&v=weekly" async></script>
        <script>

            let slides_state = false;
            const slides = () => {
                let menu = document.getElementsByClassName("menu");

                if(slides_state) {
                    menu[0].classList.remove('menu_on');
                    menu[0].classList.add('menu_off');
                    slides_state = !slides_state;
                }
                else {
                    menu[0].classList.remove('menu_off');
                    menu[0].classList.add('menu_on');
                    slides_state = !slides_state;
                }
            }


            function ContentUpdate(data) {
                const contentString = `
                <div id="content">
                <div id="siteNotice">
                </div>
                <h1 id="firstHeading" class="firstHeading">배송현황</h1><br>
                <div id="bodyContent">
                <p><b>주문번호</b>&nbsp;${data.PN}<br>
                <b>택배원</b> : ${data.name} <br><br>
                <b>배송주소</b> : ${data.take_address} ${data.take_address_detail} <br>
                --- <br>
                <b>현재위치</b> : 서울특별시 <br>
                <b>파손정도</b> : 안전 <br>
                - 온도 : ${data.temp}<sup>o</sup>C <br>
                - 습도 : ${data.humi}% <br>
                - 조도 : ${data.illum} <br>
                - 충격 : ${data.shock} <br>
               --- <br>
                </div>
                </div>
                `;

                return contentString;
            }

            // 왼쪽 슬라이드 상단 컨텐츠 내용 

            function SlideUpdate(data) {
                const product_number = document.getElementById('product_number');
                const product_pname = document.getElementById('product_pname');
                const product_delivery = document.getElementById('product_delivery');
                const product_infomation = document.getElementById('product_infomation');

                
                product_number.innerHTML = `주문번호 : ${data.PN}`;
                product_pname.innerHTML = (data.count > 1) ? `${data.pname}외 ${data.count - 1}건` : `${data.pname}`;
                product_delivery.innerHTML = `배송지 : ${data.take_address} ${data.take_address_detail}`;
                product_infomation.innerHTML = `${data.buy_name} / ${data.total}원`;
            }

            function CheckProblem(data) {
                let problem_description = '';
                let delivery_state = "OK"; // 상태값을 전달하기 위한 변수 

	if(data.state === "OK") { // 배송상태가 괜찮을 때 값을 계속 판단
                    if(parseInt(data.shock) <= 50) { problem_description += ` 충돌`; delivery_state = "BREAK";}
                    if(parseInt(data.illum) >= 130) { delivery_state = "BREAK"; problem_description += ` 외부 유출`;  }
                    if(parseInt(data.temp) >= 30) { problem_description += ` 과열`; delivery_state = "BREAK"; }
                    if(parseInt(data.humi) >= 60) { problem_description += ` 습함`; delivery_state = "BREAK"; }
                }
                else if(data.state === "BREAK"){
                    if(parseFloat(data.shock) > 50 && parseFloat(data.illum) < 130 && parseFloat(data.temp) < 30 && parseFloat(data.humi) < 60) {
                        problem_description += ` 원상 복구`;
                        delivery_state = "OK"; // 다시 원상태로 돌아왔을 경우 다시 state 값 변환
                    }
                }
                
                
	 if(problem_description !== '') {
                    console.log(problem_description);
                    const problem_message = `현황 보고 ->${problem_description}`;
                    
                    fetch(`http://uniskoal98.dothome.co.kr/consumer/problem_ajax`, {
                    method : 'POST',
                    body : JSON.stringify({
                        PN: data.PN,
                        problem_date: '<?= date("Y-m-d H:i:s") ?>', 
                        description: problem_message,
                        state: delivery_state,
                    }),
                    headers : {
                        "Content-type": "application/json; charset=UTF-8",
                        "X-Requested-With": "xmlhttprequest",
                    },
                    }).catch(err => {
                        console.log(err);
                    });
                }
                
            }

            /*function CreateNode(data) { // 배송 현황 추가 (슬라이드 왼쪽 하단)
                const menu_delivery = document.getElementById('menu_delivery');
                for(let i = 0; i < data.length; i++) {
                    menu_delivery.appendChild(document.createElement('div'));
                }
            }*/

            // 맵 관련 함수
            function initMap() {
                var seoul = { lat: 37.5642135 ,lng: 127.0016985 };
                map = new google.maps.Map( document.getElementById('product_map_content'), {
                    zoom: 10,
                    center: seoul
                });
                
                const imageSrc = {
                    url: '/images/location.png',
                    size: new google.maps.Size(50, 50),
                    scaledSize: new google.maps.Size(50, 50),
                    origin: new google.maps.Point(0, 0),
                    anchor: new google.maps.Point(27, 67),
                } // 마커이미지의 주소입니다    
                
                const infowindow = new google.maps.InfoWindow({
                    content: null, // 계속 업데이트가 될 것이 때문에 굳이 필요 없음.
                });
                const marker = new google.maps.Marker({
                    position: seoul,
                    map: map,
                    icon: imageSrc,
                });
                let a = 1;
                setInterval(function() { // 지속적으로 마커 위치 업데이트
                    fetch(`http://uniskoal98.dothome.co.kr/consumer/map_ajax/${<?= $pn ?>}`, {
                    method : 'GET',
                    headers : {
                        "Content-type": "application/json; charset=UTF-8",
                        "X-Requested-With": "xmlhttprequest",
                    }
                    }).then(result => result.json())
                    .then(json => {
                        SlideUpdate(json.data); // 슬라이드 정보 최신화
                        marker.setPosition({lat: parseFloat(json.data.gps_lat) , lng: parseFloat(json.data.gps_long)}); // 마커 갱신
                        infowindow.setContent(ContentUpdate(json.data)); // 마커 정보창 갱신
                        CheckProblem(json.data); // 상자의 상태값을 판단해 문제 정보 보내기
                    })
                    .catch(err => {
                        console.log(err);
                    });
                }, 1000);

                marker.addListener("click", () => {
                    infowindow.open({
                        anchor: marker,
                        map,
                        shouldFocus: false,
                    });
                });
            }
        </script>
    </body>
</html>