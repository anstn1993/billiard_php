//회계숫자처럼 숫자에 ,를 추가해주는 함수
function addComma(num) {
    var regexp = /\B(?=(\d{3})+(?!\d))/g;
    return num.toString().replace(regexp, ',');
}
