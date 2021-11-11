<!doctype html>
<html>
<!-- ce89830f329b3526174e2c529ba01e18 -->
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>SmartLoRa</title>
  <link href="/css/common.css?after" rel="stylesheet" type="text/css">
  <link href="/favicon.ico" rel="shortcut icon" type="image/x-icon">
  <script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
  <!-- <script src="./js/script.js"></script> -->
  <style>
    #content {font-family: 'NEXON Lv1 Gothic OTF'; padding: 3%;}
  </style>
</head>

<body>
    <main> <!-- 콘텐츠가 표시될 주요 영역 !-->
      <div id="map"></div>
    </main>
    <!-- <footer> 
                <p>바닥 영역</p>
            </footer>  !-->
  <!-- <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDllp_Hmnac0YYJ8VPvBCzBlKestbmv5G4&callback=initMap&libraries=&v=weekly" async></script> -->
  <script type="text/javascript" src="//dapi.kakao.com/v2/maps/sdk.js?appkey=ce89830f329b3526174e2c529ba01e18"></script>
  <script src="http://code.jquery.com/jquery-latest.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.3.0/jquery.form.min.js"></script>
  <script>

  var markers = [];

  // 커스텀 오버레이에 표시할 컨텐츠 입니다
  // 커스텀 오버레이는 아래와 같이 사용자가 자유롭게 컨텐츠를 구성하고 이벤트를 제어할 수 있기 때문에
  // 별도의 이벤트 메소드를 제공하지 않습니다
  // PN: box_sensor, name: delivery_man, take_address:  
  function ContentUpdate(data) {
      let contentString = `
      <div id="content">
      <div id="siteNotice">
      </div>
      <h1 id="firstHeading" class="firstHeading">배송현황</h1><br>
      <div id="bodyContent">
      <p><b>주문번호</b>&nbsp;${data.PN}<br>
      <b>택배원</b> : ${data.delivery_man_name} <br><br>
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

  // 카카오맵 지도 생성
  var mapContainer = document.getElementById('map'); // 지도를 표시할 div 
  var mapOption = { 
        center: new kakao.maps.LatLng(37.51245339470026, 126.90977750763444), // 지도의 중심좌표
        level: 6 // 지도의 확대 레벨
  };

  // 지도를 표시할 div와  지도 옵션으로 지도를 생성합니다
  var map = new kakao.maps.Map(mapContainer, mapOption);

  setInterval(function() {
    ajaxCall();
  }, 5000)
      
  // 지도에 마커 표시
  function setMarkers(map) {
      for(var i=0; i<markers.length; i++) {
          markers[i].setMap(map);
      }            
  }
  
  // 지도에서 마커 숨기기
  function hideAllMarkers() {
    setMarkers(null);
    markers = [];
  }

  // 인포윈도우를 표시하는 클로저를 만드는 함수입니다 
  function makeOverListener(map, marker, infowindow) {
      return function() {
          infowindow.open(map, marker);
      };
  }

  // 인포윈도우를 닫는 클로저를 만드는 함수입니다 
  function makeOutListener(infowindow) {
      return function() {
          infowindow.close();
      };
  }

  function ajaxCall() {
    $.ajax({
      url: 'http://uniskoal98.dothome.co.kr/and_sensor/jsonmap',
      type : 'POST',
      dataType : 'json',
      data : {},
      success : function(response) {
        
        console.log(response);

        if (response && Array.isArray(response)) {

          var imageSrc = '/images/location.png', // 마커이미지의 주소입니다    
              imageSize = new kakao.maps.Size(50, 50), // 마커이미지의 크기입니다
              imageOption = {offset: new kakao.maps.Point(27, 69)}; // 마커이미지의 옵션입니다. 마커의 좌표와 일치시킬 이미지 안에서의 좌표를 설정합니다

          var markerImage = new kakao.maps.MarkerImage(imageSrc, imageSize, imageOption),
              markerPosition = new kakao.maps.LatLng(37.54699, 127.09598); // 마커가 표시될 위치입니다

          if (markers.length) {
            markers = [];
            hideAllMarkers();
          }

          response.forEach(sensor => {
            // 마커를 생성합니다
            var marker = new kakao.maps.Marker({
              map: map, // 마커를 표시할 지도
              position: new kakao.maps.LatLng(sensor.gps_lat, sensor.gps_long), // 마커를 표시할 위치
              // title : '이가인', // 마커의 타이틀, 마커에 마우스를 올리면 타이틀이 표시됩니다
              image : markerImage // 마커 이미지
            });
            markers.push(marker);

            /* TODO: 수정한 부분 */
            var infowindow = new kakao.maps.InfoWindow({
                content: ContentUpdate(sensor) // 인포윈도우에 표시할 내용
            });

            // 마커에 mouseover 이벤트와 mouseout 이벤트를 등록합니다
            // 이벤트 리스너로는 클로저를 만들어 등록합니다 
            // for문에서 클로저를 만들어 주지 않으면 마지막 마커에만 이벤트가 등록됩니다
            kakao.maps.event.addListener(marker, 'mouseover', makeOverListener(map, marker, infowindow));
            kakao.maps.event.addListener(marker, 'mouseout', makeOutListener(infowindow));
          });
        } else {
          alert('유효하지 않은 응답입니다.');
        }
      },
      error : function(err){
        alert("에러");
        console.log(err);
        console.log(err.response);
      },
    });
  }
</script>
</body>
</html>